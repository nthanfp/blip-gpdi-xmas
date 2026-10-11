<?php

class Registration_Model extends CI_Model
{
    private $_table = 'act_xmas_registration';
    private $_attendee = 'act_xmas_attendee';

    public function data_list($page = 1, $per_page = 10, $search = '', $floor = '', $status = '', $sort_by = 'date', $sort_order = 'desc')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;
        $search = trim((string) $search);

        $sortable = [
            'code'      => 'r.ref_code',
            'phone'     => 'r.phone',
            'floor'     => 'r.floor',
            'attendees' => 'attendee_count',
            'status'    => 'confirmed_count',
            'date'      => 'r.created_date',
        ];
        $orderField = $sortable[$sort_by] ?? 'r.created_date';
        $orderDir = strtolower((string) $sort_order) === 'asc' ? 'ASC' : 'DESC';

        $where = [];
        $binds = [];

        if ($search !== '') {
            $like = '%' . $search . '%';
            $where[] = '(r.phone LIKE ? OR r.ref_code LIKE ? OR EXISTS (SELECT 1 FROM ' . $this->_attendee . ' ax WHERE ax.registrationid = r.registrationid AND ax.name LIKE ?))';
            $binds[] = $like;
            $binds[] = $like;
            $binds[] = $like;
        }
        if ($floor !== '' && $floor !== null) {
            $where[] = 'r.floor = ?';
            $binds[] = (int) $floor;
        }
        if ($status !== '' && $status !== null) {
            $where[] = 'r.status = ?';
            $binds[] = (int) $status;
        }

        $whereSql = $where ? ' WHERE ' . implode(' AND ', $where) : '';

        $total = $this->db->query(
            'SELECT COUNT(*) AS total FROM ' . $this->_table . ' r' . $whereSql,
            $binds
        )->row()->total;

        $sql = 'SELECT r.registrationid, r.phone, r.floor, r.status, r.ref_code, r.created_date,
                       f.name AS floor_name,
                       COUNT(a.attendeeid) AS attendee_count,
                       SUM(CASE WHEN a.status = 1 THEN 1 ELSE 0 END) AS confirmed_count,
                       GROUP_CONCAT(a.name ORDER BY a.is_primary DESC, a.attendeeid ASC SEPARATOR ", ") AS attendee_names
                FROM ' . $this->_table . ' r
                LEFT JOIN set_xmas_floor f ON f.floor = r.floor
                LEFT JOIN ' . $this->_attendee . ' a ON a.registrationid = r.registrationid'
            . $whereSql . '
                GROUP BY r.registrationid
                ORDER BY ' . $orderField . ' ' . $orderDir . ', r.registrationid DESC
                LIMIT ' . $per_page . ' OFFSET ' . $offset;

        $rows = $this->db->query($sql, $binds)->result();

        return [
            'success' => true,
            'message' => 'Registration data retrieved successfully',
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

    public function data_list_people($page = 1, $per_page = 10, $search = '', $floor = '', $status = '', $sort_by = 'date', $sort_order = 'desc')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;
        $search = trim((string) $search);

        $sortable = [
            'code'   => 'r.ref_code',
            'phone'  => 'r.phone',
            'floor'  => 'r.floor',
            'name'   => 'a.name',
            'status' => 'a.status',
            'date'   => 'r.created_date',
        ];
        $orderField = $sortable[$sort_by] ?? 'r.created_date';
        $orderDir = strtolower((string) $sort_order) === 'asc' ? 'ASC' : 'DESC';

        $where = ['1 = 1'];
        $binds = [];

        if ($search !== '') {
            $like = '%' . $search . '%';
            $where[] = '(r.phone LIKE ? OR r.ref_code LIKE ? OR a.name LIKE ?)';
            $binds[] = $like;
            $binds[] = $like;
            $binds[] = $like;
        }
        if ($floor !== '' && $floor !== null) {
            $where[] = 'r.floor = ?';
            $binds[] = (int) $floor;
        }
        if ($status !== '' && $status !== null) {
            $where[] = 'a.status = ?';
            $binds[] = (int) $status;
        }

        $whereSql = ' WHERE ' . implode(' AND ', $where);

        $total = $this->db->query(
            'SELECT COUNT(*) AS total
             FROM ' . $this->_attendee . ' a
             JOIN ' . $this->_table . ' r ON r.registrationid = a.registrationid' . $whereSql,
            $binds
        )->row()->total;

        $sql = 'SELECT a.attendeeid, a.name, a.age, a.status, a.is_primary,
                       r.registrationid, r.phone, r.floor, r.ref_code, r.created_date
                FROM ' . $this->_attendee . ' a
                JOIN ' . $this->_table . ' r ON r.registrationid = a.registrationid'
            . $whereSql . '
                ORDER BY ' . $orderField . ' ' . $orderDir . ', r.registrationid DESC, a.is_primary DESC, a.attendeeid ASC
                LIMIT ' . $per_page . ' OFFSET ' . $offset;

        $rows = $this->db->query($sql, $binds)->result();

        return [
            'success' => true,
            'message' => 'Attendee data retrieved successfully',
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

    public function data_detail($id)
    {
        $id = (int) $id;

        $row = $this->db->query(
            'SELECT r.registrationid, r.phone, r.floor, r.status, r.ref_code, r.ip_address, r.ua, r.created_date,
                    f.name AS floor_name, f.capacity
             FROM ' . $this->_table . ' r
             LEFT JOIN set_xmas_floor f ON f.floor = r.floor
             WHERE r.registrationid = ?',
            [$id]
        )->row();

        if (!$row) {
            return ['success' => false, 'message' => 'Registration not found'];
        }

        $row->attendees = $this->db->query(
            'SELECT attendeeid, name, age, is_primary, status
             FROM ' . $this->_attendee . '
             WHERE registrationid = ?
             ORDER BY is_primary DESC, attendeeid ASC',
            [$id]
        )->result();

        return ['success' => true, 'message' => 'OK', 'data' => $row];
    }

    public function data_status($id, $status, $attendee_ids = [])
    {
        $id = (int) $id;
        $status = (int) $status;

        if (!$id) {
            return ['success' => false, 'message' => 'Registration ID is required'];
        }
        if (!in_array($status, [1, 2], true)) {
            return ['success' => false, 'message' => 'Invalid status'];
        }

        $exists = $this->db->where('registrationid', $id)->count_all_results($this->_table);
        if (!$exists) {
            return ['success' => false, 'message' => 'Registration not found'];
        }

        $selected = [];
        foreach ((array) $attendee_ids as $aid) {
            $aid = (int) $aid;
            if ($aid > 0) {
                $selected[] = $aid;
            }
        }
        $selected = array_values(array_unique($selected));

        if (!$selected) {
            return ['success' => false, 'message' => 'Select at least one attendee.'];
        }

        // Pastikan attendee milik registrasi ini saja
        $valid = $this->db->where('registrationid', $id)
            ->where_in('attendeeid', $selected)
            ->count_all_results($this->_attendee);

        if ($valid !== count($selected)) {
            return ['success' => false, 'message' => 'Invalid attendee selection.'];
        }

        $this->db->trans_begin();

        $this->db->where('registrationid', $id);
        $this->db->update($this->_table, ['status' => $status]);

        if ($status === 1) {
            // Terpilih -> Confirmed; sisanya TIDAK diubah (tetap status sebelumnya / pending)
            $this->db->where('registrationid', $id)
                ->where_in('attendeeid', $selected)
                ->update($this->_attendee, ['status' => 1]);
        } else {
            // Terpilih -> Cancelled, sisanya tidak diubah
            $this->db->where('registrationid', $id)
                ->where_in('attendeeid', $selected)
                ->update($this->_attendee, ['status' => 2]);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return ['success' => false, 'message' => 'Failed to update status. Please try again.'];
        }

        $this->db->trans_commit();

        $labels = [1 => 'confirmed', 2 => 'cancelled'];
        $count = count($selected);
        return ['success' => true, 'message' => $count . ' attendee(s) marked as ' . $labels[$status]];
    }

    public function data_delete($id)
    {
        $id = (int) $id;

        if (!$id) {
            return ['success' => false, 'message' => 'Registration ID is required'];
        }

        $exists = $this->db->where('registrationid', $id)->count_all_results($this->_table);
        if (!$exists) {
            return ['success' => false, 'message' => 'Registration not found'];
        }

        // attendee ikut terhapus via ON DELETE CASCADE
        $this->db->where('registrationid', $id);
        $this->db->delete($this->_table);

        return ['success' => true, 'message' => 'Registration deleted successfully'];
    }

    public function data_delete_attendee($id)
    {
        $id = (int) $id;

        if (!$id) {
            return ['success' => false, 'message' => 'Attendee ID is required'];
        }

        $exists = $this->db->where('attendeeid', $id)->count_all_results($this->_attendee);
        if (!$exists) {
            return ['success' => false, 'message' => 'Attendee not found'];
        }

        $this->db->where('attendeeid', $id);
        $this->db->delete($this->_attendee);

        return ['success' => true, 'message' => 'Attendee deleted successfully'];
    }

    public function data_stats()
    {
        $floors = $this->db->order_by('floor', 'ASC')->get('set_xmas_floor')->result();

        $peopleByFloor = $this->db->query(
            'SELECT r.floor, COUNT(a.attendeeid) AS people
             FROM ' . $this->_table . ' r
             JOIN ' . $this->_attendee . ' a ON a.registrationid = r.registrationid
             WHERE r.status <> 2 AND a.status <> 2
             GROUP BY r.floor'
        )->result();

        $map = [];
        foreach ($peopleByFloor as $p) {
            $map[(int) $p->floor] = (int) $p->people;
        }

        $floor_stats = [];
        foreach ($floors as $f) {
            $registered = isset($map[(int) $f->floor]) ? $map[(int) $f->floor] : 0;
            $floor_stats[] = [
                'floor' => (int) $f->floor,
                'name' => $f->name,
                'capacity' => (int) $f->capacity,
                'registered' => $registered,
                'remaining' => max(0, (int) $f->capacity - $registered)
            ];
        }

        $totals = $this->db->query(
            'SELECT COUNT(*) AS total_registration,
                    SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) AS total_pending,
                    SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) AS total_confirmed,
                    SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) AS total_cancelled
             FROM ' . $this->_table
        )->row();

        $total_people = $this->db->query(
            'SELECT COUNT(*) AS total_people FROM ' . $this->_attendee
        )->row();

        return [
            'success' => true,
            'message' => 'OK',
            'data' => [
                'floors' => $floor_stats,
                'totals' => [
                    'registration' => (int) $totals->total_registration,
                    'pending' => (int) $totals->total_pending,
                    'confirmed' => (int) $totals->total_confirmed,
                    'cancelled' => (int) $totals->total_cancelled,
                    'people' => (int) $total_people->total_people
                ]
            ]
        ];
    }

    public function data_update_capacity($cap1, $cap2)
    {
        $caps = [1 => $cap1, 2 => $cap2];

        foreach ($caps as $floor => $cap) {
            if ($cap === null || $cap === '' || !ctype_digit((string) $cap)) {
                return ['success' => false, 'message' => 'Quota must be a number.'];
            }
            if ((int) $cap > 10000) {
                return ['success' => false, 'message' => 'Quota maximum is 10000 per floor.'];
            }
        }

        // Jemaat terdaftar (bukan cancelled, per jemaat maupun registrasi) per lantai
        $peopleByFloor = $this->db->query(
            'SELECT r.floor, COUNT(a.attendeeid) AS people
             FROM ' . $this->_table . ' r
             JOIN ' . $this->_attendee . ' a ON a.registrationid = r.registrationid
             WHERE r.status <> 2 AND a.status <> 2
             GROUP BY r.floor'
        )->result();

        $map = [];
        foreach ($peopleByFloor as $p) {
            $map[(int) $p->floor] = (int) $p->people;
        }

        foreach ($caps as $floor => $cap) {
            $exists = $this->db->where('floor', $floor)->count_all_results('set_xmas_floor');
            if (!$exists) {
                return ['success' => false, 'message' => 'Floor ' . $floor . ' not found.'];
            }

            $registered = isset($map[$floor]) ? $map[$floor] : 0;
            if ((int) $cap < $registered) {
                return [
                    'success' => false,
                    'message' => 'Floor ' . $floor . ' quota (' . (int) $cap . ') cannot be less than the number of registered attendees (' . $registered . ').'
                ];
            }
        }

        $this->db->trans_begin();
        foreach ($caps as $floor => $cap) {
            $this->db->set('capacity', (int) $cap)->where('floor', $floor)->update('set_xmas_floor');
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return ['success' => false, 'message' => 'Failed to update quota. Please try again.'];
        }

        $this->db->trans_commit();

        return [
            'success' => true,
            'message' => 'Floor quota updated: Floor 1 = ' . (int) $cap1 . ', Floor 2 = ' . (int) $cap2
        ];
    }
}
