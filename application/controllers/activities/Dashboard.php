<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
    }

    private function guard_menu_access($menuid, $subperm = null)
    {
        $result = $this->Setmenu_Model->check_menu($menuid, $subperm);

        if (!$result['success'] || !$result['allowed']) {
            show_404();
            return false;
        }

        return true;
    }

    public function index()
    {
        if (!$this->Auth_Model->current_user()) {
            redirect(site_url('activities/authentication/login'));
            exit;
        }

        if (!$this->guard_menu_access(108, 'view')) {
            return;
        }

        $this->load->view('activities/dashboard', $this->_widget_permissions());
    }

    private function _widget_permissions()
    {
        $menus = [];

        $data = [];
        foreach ($menus as $key => $menuid) {
            $check = $this->Setmenu_Model->check_menu($menuid, 'view');
            $data[$key] = $check['success'] && $check['allowed'];
        }

        return $data;
    }

    public function data_dashboard()
    {
        if (!$this->guard_menu_access(108, 'view')) {
            return;
        }

        $this->load->model('Dashboard_Model');
        $result = $this->Dashboard_Model->data_summary();

        $this->output->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function data_print()
    {
        if (!$this->guard_menu_access(108, 'print')) {
            return;
        }

        $pages = site_url('activities/dashboard/data_printhtml');
        $head = site_url('activities/dashboard/data_printhead');
        $current_user = $this->Auth_Model->current_user();
        $username = $current_user ? $current_user->username : 'Unknown';
        topdf($pages, $head, 20, 0, 0, 0, $username);
    }

    public function data_printhead()
    {
        if (!$this->guard_menu_access(108, 'print')) {
            return;
        }

        $table = '<table border="0" width="970" class="tablerep">' . $this->print_header_row() . '</table>';

        $data['title'] = 'Rekap Data Pendaftaran Natal 2026';
        $data['table'] = $table;

        $this->load->view('act/act_common_head', $data);
    }

    private function print_header_row()
    {
        return '
			<tr>
                <td class="headertd" width="670"></td>
                <td class="headertd" width="150" style="text-align:right;">Lantai 1</td>
                <td class="headertd" width="150" style="text-align:right;">Lantai 2</td>
            </tr>';
    }

    public function data_printhtml()
    {
        if (!$this->guard_menu_access(108, 'print')) {
            return;
        }

        $this->load->model('Dashboard_Model');
        $result = $this->Dashboard_Model->data_summary();
        if (empty($result['success'])) {
            show_error(isset($result['message']) ? $result['message'] : 'Gagal memuat rekap', 500);
            return;
        }
        $d = $result['data'];

        $f1 = null;
        $f2 = null;
        foreach (isset($d['floors']) ? $d['floors'] : [] as $f) {
            if ((int) $f['floor'] === 1) {
                $f1 = $f;
            }
            if ((int) $f['floor'] === 2) {
                $f2 = $f;
            }
        }
        $num = function ($f, $key) {
            return $f !== null && isset($f[$key]) ? (int) $f[$key] : 0;
        };
        $cap1 = $num($f1, 'capacity');
        $cap2 = $num($f2, 'capacity');
        $reg1 = $num($f1, 'registered');
        $reg2 = $num($f2, 'registered');
        $bkd1 = $num($f1, 'booked');
        $bkd2 = $num($f2, 'booked');
        $used1 = $reg1 + $bkd1;
        $used2 = $reg2 + $bkd2;
        $rem1 = $num($f1, 'remaining');
        $rem2 = $num($f2, 'remaining');

        $e = function ($v) {
            return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
        };

        $rows = '';
        $rows .= "<tr><td width='670' style='font-weight:bold;'>Registration</td><td width='150'></td><td width='150'></td></tr>";
        $rows .= "<tr><td width='670' style='padding-left:40px;'>Jumlah Pendaftar</td>"
            . "<td width='150' style='text-align:right;'>{$reg1}</td>"
            . "<td width='150' style='text-align:right;'>{$reg2}</td></tr>";

        $rows .= "<tr><td width='670' style='font-weight:bold;'>Booking &amp; Invitation</td><td width='150'></td><td width='150'></td></tr>";
        $booking_list = isset($d['booking_list']) ? $d['booking_list'] : [];
        if (count($booking_list) === 0) {
            $rows .= "<tr><td width='670' style='padding-left:40px;color:#777;'>Tidak ada booking aktif</td>"
                . "<td width='150' style='text-align:right;color:#777;'>-</td>"
                . "<td width='150' style='text-align:right;color:#777;'>-</td></tr>";
        } else {
            foreach ($booking_list as $b) {
                $is_f2 = (int) $b['floor'] === 2;
                $seats = (int) $b['seats'];
                $name = $e($b['name'] !== '' ? $b['name'] : '-');
                $c1 = $is_f2 ? '' : (string) $seats;
                $c2 = $is_f2 ? (string) $seats : '';
                $rows .= "<tr>
                    <td width='670' style='padding-left:40px;'>{$name}</td>
                    <td width='150' style='text-align:right;'>{$c1}</td>
                    <td width='150' style='text-align:right;'>{$c2}</td>
                </tr>";
            }
        }

        $rows .= "<tr><td colspan='3' style='border-top:3px solid #343a40;padding:0;height:0;'></td></tr>";
        $rows .= "<tr style='font-weight:bold;'><td width='670'>Total Kursi</td>"
            . "<td width='150' style='text-align:right;'>{$cap1}</td>"
            . "<td width='150' style='text-align:right;'>{$cap2}</td></tr>";
        $rows .= "<tr style='font-weight:bold;'><td width='670'>Total Terisi</td>"
            . "<td width='150' style='text-align:right;'>{$used1}</td>"
            . "<td width='150' style='text-align:right;'>{$used2}</td></tr>";
        $rows .= "<tr style='font-weight:bold;'><td width='670'>Sisa Kursi</td>"
            . "<td width='150' style='text-align:right;'>{$rem1}</td>"
            . "<td width='150' style='text-align:right;'>{$rem2}</td></tr>";

        $table = '<table border="0" width="970" class="tablerep">' . $rows . '</table>';

        $output['title'] = 'Rekap Data Pendaftaran Natal 2026';
        $output['table'] = $table;
        $output['ex'] = 0;
        $output['filename'] = '';

        $this->load->view('act/common_print', $output);
    }
}
