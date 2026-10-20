<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (file_exists(APPPATH . 'config/db_bypass.php')) {
            return;
        }
        $this->load->model('Setpref_Model');
        $this->load->model('Registration_Model');
        $this->load->model('Faq_Model');
        $this->load->library('user_agent');
    }

    private function respond(array $response)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    private function _is_maintenance()
    {
        if (!isset($this->Setpref_Model)) return false;
        return $this->Setpref_Model->get_pref('maintenance_mode') === '1';
    }

    private function _require_mobile()
    {
        if (!$this->agent->is_mobile()) {
            $this->load->view('landing/mobile_only');
            return false;
        }
        return true;
    }

    public function index()
    {
        if ($this->_is_maintenance()) {
            $this->load->view('landing/maintenance');
            return;
        }

        $this->load->view('landing/index');
    }

    public function complete()
    {
        if ($this->_is_maintenance()) {
            $this->load->view('landing/maintenance');
            return;
        }

        if (!$this->_require_mobile()) return;

        $this->load->view('landing/complete');
    }

    public function example()
    {
        if ($this->_is_maintenance()) {
            $this->load->view('landing/maintenance');
            return;
        }

        if (!$this->_require_mobile()) return;
    }

    public function invite($slug = null)
    {
        if ($this->_is_maintenance()) {
            $this->load->view('landing/maintenance');
            return;
        }

        /* FAQ dari database (fallback kosong bila model/db belum siap) */
        $faqs = [];
        if (isset($this->Faq_Model) && $this->db->table_exists('set_faq')) {
            $faqs = $this->Faq_Model->get_active();
        }

        $this->load->view('landing/invite', ['slug' => $slug, 'faqs' => $faqs]);
    }

    /* Sisa kursi real-time (publik, untuk form pendaftaran di invite.php) */
    public function registration_seats()
    {
        $this->respond($this->Registration_Model->data_stats());
    }

    /* Submit pendaftaran (publik) */
    public function registration_submit()
    {
        $phone = trim((string) $this->input->post('phone', true));
        $floor = (int) $this->input->post('floor', true);
        $attendees = $this->input->post('attendees', true);

        /* Validasi server-side */
        if (!preg_match('/^0[0-9]{9,13}$/', $phone)) {
            $this->respond(['success' => false, 'message' => 'No. Handphone tidak valid.']);
            return;
        }

        if (!in_array($floor, [1, 2], true)) {
            $this->respond(['success' => false, 'message' => 'Silakan pilih lantai terlebih dahulu.']);
            return;
        }

        if (!is_array($attendees) || count($attendees) === 0) {
            $this->respond(['success' => false, 'message' => 'Minimal harus ada 1 jemaat.']);
            return;
        }

        $clean = [];
        foreach ($attendees as $i => $a) {
            $name = isset($a['name']) ? trim((string) $a['name']) : '';
            $age = isset($a['age']) ? $a['age'] : '';

            if ($name === '' || mb_strlen($name) > 50) {
                $this->respond(['success' => false, 'message' => 'Nama jemaat wajib diisi (maks 50 karakter).']);
                return;
            }
            if ($age === '' || !ctype_digit((string) $age) || (int) $age > 120) {
                $this->respond(['success' => false, 'message' => 'Umur setiap jemaat wajib diisi (0-120).']);
                return;
            }

            $clean[] = [
                'name' => $name,
                'age' => (int) $age,
                'is_primary' => $i === 0 ? 1 : 0
            ];
        }

        /* Cek nomor sudah pernah daftar — minta konfirmasi daftar ulang */
        if ($this->input->post('confirm') !== '1') {
            $dup = $this->db->query(
                'SELECT COUNT(x.attendeeid) AS people, MAX(r.created_date) AS last_at
                 FROM act_xmas_registration r
                 JOIN act_xmas_attendee x ON x.registrationid = r.registrationid AND x.status <> 2
                 WHERE r.phone = ? AND r.status <> 2',
                [$phone]
            )->row();

            if ($dup && (int) $dup->people > 0) {
                $bulan = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                $ts = strtotime($dup->last_at);
                $this->respond([
                    'success' => false,
                    'requires_confirm' => true,
                    'message' => 'Nomor ini sudah pernah mendaftar.',
                    'data' => [
                        'count' => (int) $dup->people,
                        'registered_at' => date('d', $ts) . ' ' . $bulan[(int) date('n', $ts)] . ' ' . date('Y, H:i', $ts)
                    ]
                ]);
                return;
            }
        }

        $seat_count = count($clean);

        /* Transaksi: cek sisa kursi (FOR UPDATE per lantai) lalu insert */
        $this->db->trans_begin();

        $floor_row = $this->db->query(
            'SELECT floor, name, capacity FROM set_xmas_floor WHERE floor = ? FOR UPDATE',
            [$floor]
        )->row();

        if (!$floor_row) {
            $this->db->trans_rollback();
            $this->respond(['success' => false, 'message' => 'Lantai tidak ditemukan.']);
            return;
        }

        $registered = $this->db->query(
            'SELECT COUNT(a.attendeeid) AS people
             FROM act_xmas_registration r
             JOIN act_xmas_attendee a ON a.registrationid = r.registrationid
             WHERE r.floor = ? AND r.status <> 2 AND a.status <> 2',
            [$floor]
        )->row()->people;

        $remaining = max(0, (int) $floor_row->capacity - (int) $registered);
        if ($seat_count > $remaining) {
            $this->db->trans_rollback();
            $this->respond([
                'success' => false,
                'message' => 'Kursi ' . $floor_row->name . ' tinggal ' . $remaining . ' lagi. Kurangi jumlah jemaat.'
            ]);
            return;
        }

        /* Ref code unik */
        $ref_code = null;
        for ($i = 0; $i < 5; $i++) {
            $candidate = 'GP' . strtoupper(bin2hex(random_bytes(3)));
            $exists = $this->db->where('ref_code', $candidate)->count_all_results('act_xmas_registration');
            if (!$exists) {
                $ref_code = $candidate;
                break;
            }
        }
        if ($ref_code === null) {
            $this->db->trans_rollback();
            $this->respond(['success' => false, 'message' => 'Gagal membuat kode registrasi. Coba lagi.']);
            return;
        }

        $this->db->insert('act_xmas_registration', [
            'phone' => $phone,
            'floor' => $floor,
            'status' => 0,
            'ref_code' => $ref_code,
            'ip_address' => $this->input->ip_address(),
            'ua' => isset($_SERVER['HTTP_USER_AGENT']) ? substr($_SERVER['HTTP_USER_AGENT'], 0, 300) : '',
            'created_date' => date('Y-m-d H:i:s')
        ]);
        $registrationid = $this->db->insert_id();

        if (!$registrationid) {
            $this->db->trans_rollback();
            $this->respond(['success' => false, 'message' => 'Gagal menyimpan pendaftaran. Coba lagi.']);
            return;
        }

        $rows = [];
        foreach ($clean as $c) {
            $rows[] = [
                'registrationid' => $registrationid,
                'name' => $c['name'],
                'age' => $c['age'],
                'is_primary' => $c['is_primary'],
                'created_date' => date('Y-m-d H:i:s')
            ];
        }
        $this->db->insert_batch('act_xmas_attendee', $rows);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->respond(['success' => false, 'message' => 'Gagal menyimpan data jemaat. Coba lagi.']);
            return;
        }

        $this->db->trans_commit();

        $this->respond([
            'success' => true,
            'message' => 'Pendaftaran berhasil.',
            'data' => [
                'ref_code' => $ref_code,
                'floor' => $floor,
                'attendees' => $seat_count
            ]
        ]);
    }
}
