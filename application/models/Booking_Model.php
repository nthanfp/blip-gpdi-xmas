<?php

class Booking_Model extends CI_Model
{
    private $_table = 'act_xmas_booking';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Global_Model');
        $this->load->helper('global');
    }

    private function current_user_id()
    {
        $CI =& get_instance();
        if (!isset($CI->Auth_Model)) {
            $CI->load->model('Auth_Model');
        }
        $current_user = $CI->Auth_Model->current_user();
        return $current_user ? $current_user->mst_adminid : null;
    }

    public function rules($mode = 'create')
    {
        return [
            [
                'field' => 'floor',
                'label' => 'Floor',
                'rules' => 'required|integer'
            ],
            [
                'field' => 'seats',
                'label' => 'Seats',
                'rules' => 'required|integer|greater_than[0]'
            ],
            [
                'field' => 'keterangan',
                'label' => 'Keterangan',
                'rules' => 'required|max_length[255]'
            ]
        ];
    }

    /* Total kursi yang ditahan (booking aktif) per lantai => [floor => seats] */
    public function booked_by_floor($exclude_bookingid = null)
    {
        if (!$this->db->table_exists($this->_table)) {
            return [];
        }

        $sql = 'SELECT floor, COALESCE(SUM(seats), 0) AS seats
                FROM ' . $this->_table . '
                WHERE status = 0';
        $bind = [];

        if ($exclude_bookingid !== null) {
            $sql .= ' AND bookingid <> ?';
            $bind[] = (int) $exclude_bookingid;
        }

        $sql .= ' GROUP BY floor';

        $rows = $this->db->query($sql, $bind)->result();

        $map = [];
        foreach ($rows as $r) {
            $map[(int) $r->floor] = (int) $r->seats;
        }
        return $map;
    }

    /* Jemaat terdaftar (bukan cancelled) per lantai => [floor => people] */
    private function registered_by_floor()
    {
        $rows = $this->db->query(
            'SELECT r.floor, COUNT(a.attendeeid) AS people
             FROM act_xmas_registration r
             JOIN act_xmas_attendee a ON a.registrationid = r.registrationid
             WHERE r.status <> 2 AND a.status <> 2
             GROUP BY r.floor'
        )->result();

        $map = [];
        foreach ($rows as $r) {
            $map[(int) $r->floor] = (int) $r->people;
        }
        return $map;
    }

    public function data_list($page = 1, $per_page = 10, $search = '', $floor = '')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;

        $this->db->from($this->_table . ' b');
        $this->db->join('set_xmas_floor f', 'f.floor = b.floor', 'left');

        if ($search !== '') {
            $this->db->group_start()
                ->like('b.keterangan', $search)
                ->or_like('f.name', $search)
                ->group_end();
        }

        if ($floor !== '' && $floor !== null) {
            $this->db->where('b.floor', (int) $floor);
        }

        $total = $this->db->count_all_results('', false);

        $this->db->order_by('b.bookingid', 'DESC');
        $this->db->limit($per_page, $offset);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Booking retrieved successfully',
            'data' => $rows,
            'pagination' => [
                'page' => $page,
                'per_page' => $per_page,
                'total' => (int) $total,
                'total_pages' => (int) ceil($total / $per_page),
                'has_prev' => $page > 1,
                'has_next' => ($page * $per_page) < $total
            ]
        ];
    }

    public function data_new(array $input)
    {
        $floor = (int) ($input['floor'] ?? 0);
        $seats = (int) ($input['seats'] ?? 0);
        $keterangan = trim((string) ($input['keterangan'] ?? ''));
        $status = !empty($input['status']) ? 1 : 0;

        if ($keterangan === '' || mb_strlen($keterangan) > 255) {
            return ['success' => false, 'message' => 'Keterangan wajib diisi (maks 255 karakter).'];
        }
        if ($seats < 1) {
            return ['success' => false, 'message' => 'Jumlah kursi minimal 1.'];
        }

        $this->db->trans_begin();

        $floor_row = $this->db->query(
            'SELECT floor, name, capacity FROM set_xmas_floor WHERE floor = ? FOR UPDATE',
            [$floor]
        )->row();

        if (!$floor_row) {
            $this->db->trans_rollback();
            return ['success' => false, 'message' => 'Lantai tidak ditemukan.'];
        }

        if ($status === 0) {
            $registered_map = $this->registered_by_floor();
            $booked_map = $this->booked_by_floor();
            $registered = $registered_map[$floor] ?? 0;
            $booked = $booked_map[$floor] ?? 0;
            $remaining = max(0, (int) $floor_row->capacity - $registered - $booked);

            if ($seats > $remaining) {
                $this->db->trans_rollback();
                return [
                    'success' => false,
                    'message' => 'Sisa kuota ' . $floor_row->name . ' tinggal ' . $remaining . ' kursi. Booking tidak boleh melebihi sisa kuota.'
                ];
            }
        }

        $bookingid = $this->Global_Model->get_autoid_seq($this->_table);
        if ($bookingid === null) {
            $this->db->trans_rollback();
            return ['success' => false, 'message' => 'Gagal membuat ID booking.'];
        }

        $insert = $this->db->insert($this->_table, [
            'bookingid' => $bookingid,
            'floor' => $floor,
            'seats' => $seats,
            'keterangan' => $keterangan,
            'status' => $status,
            'created_by' => $this->current_user_id(),
            'created_date' => date('Y-m-d H:i:s')
        ]);

        if (!$insert || $this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return ['success' => false, 'message' => 'Gagal menyimpan booking.'];
        }

        $this->db->trans_commit();

        return ['success' => true, 'message' => 'Booking berhasil ditambahkan.'];
    }

    public function data_edit($id)
    {
        $item = $this->db->get_where($this->_table, ['bookingid' => (int) $id])->row();

        if (!$item) {
            return ['success' => false, 'message' => 'Booking tidak ditemukan.'];
        }

        return ['success' => true, 'message' => 'Booking retrieved successfully', 'data' => $item];
    }

    public function data_update($id, array $input)
    {
        $id = (int) $id;
        $item = $this->db->get_where($this->_table, ['bookingid' => $id])->row();
        if (!$item) {
            return ['success' => false, 'message' => 'Booking tidak ditemukan.'];
        }

        $floor = (int) ($input['floor'] ?? 0);
        $seats = (int) ($input['seats'] ?? 0);
        $keterangan = trim((string) ($input['keterangan'] ?? ''));
        $status = !empty($input['status']) ? 1 : 0;

        if ($keterangan === '' || mb_strlen($keterangan) > 255) {
            return ['success' => false, 'message' => 'Keterangan wajib diisi (maks 255 karakter).'];
        }
        if ($seats < 1) {
            return ['success' => false, 'message' => 'Jumlah kursi minimal 1.'];
        }

        $this->db->trans_begin();

        $floor_row = $this->db->query(
            'SELECT floor, name, capacity FROM set_xmas_floor WHERE floor = ? FOR UPDATE',
            [$floor]
        )->row();

        if (!$floor_row) {
            $this->db->trans_rollback();
            return ['success' => false, 'message' => 'Lantai tidak ditemukan.'];
        }

        if ($status === 0) {
            $registered_map = $this->registered_by_floor();
            $booked_map = $this->booked_by_floor($id);
            $registered = $registered_map[$floor] ?? 0;
            $booked = $booked_map[$floor] ?? 0;
            $remaining = max(0, (int) $floor_row->capacity - $registered - $booked);

            if ($seats > $remaining) {
                $this->db->trans_rollback();
                return [
                    'success' => false,
                    'message' => 'Sisa kuota ' . $floor_row->name . ' tinggal ' . $remaining . ' kursi. Booking tidak boleh melebihi sisa kuota.'
                ];
            }
        }

        $update = $this->db->where('bookingid', $id)->update($this->_table, [
            'floor' => $floor,
            'seats' => $seats,
            'keterangan' => $keterangan,
            'status' => $status,
            'modified_by' => $this->current_user_id(),
            'modified_date' => date('Y-m-d H:i:s')
        ]);

        if (!$update || $this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return ['success' => false, 'message' => 'Gagal memperbarui booking.'];
        }

        $this->db->trans_commit();

        return ['success' => true, 'message' => 'Booking berhasil diperbarui.'];
    }

    public function data_delete($id)
    {
        $item = $this->db->get_where($this->_table, ['bookingid' => (int) $id])->row();
        if (!$item) {
            return ['success' => false, 'message' => 'Booking tidak ditemukan.'];
        }

        $delete = $this->db->delete($this->_table, ['bookingid' => (int) $id]);

        return [
            'success' => (bool) $delete,
            'message' => $delete ? 'Booking berhasil dihapus.' : 'Gagal menghapus booking.'
        ];
    }
}
