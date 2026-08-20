<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LogAdmin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('LogAdmin_Model');

        if (!$this->Auth_Model->current_user()) {
            redirect(site_url('activities/authentication/login'));
            exit;
        }
    }

    private function respond(array $response)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
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

    private function log_activity($action, $description = '')
    {
        $current_user = $this->Auth_Model->current_user();

        if (!$current_user) {
            return false;
        }

        $result = $this->LogAdmin_Model->data_new([
            'mst_adminid' => $current_user->mst_adminid,
            'set_menuid' => 111,
            'action' => strtoupper(trim((string) $action)),
            'description' => trim((string) $description),
            'ip_address' => $this->input->ip_address(),
            'ua' => $this->session->userdata('user_agent') ?: '',
            'mac' => $this->session->userdata('mac_address') ?: ''
        ]);

        return isset($result['success']) ? (bool) $result['success'] : false;
    }

    public function index()
    {
        if (!$this->guard_menu_access(111, 'view')) {
            return;
        }

        $this->load->view('activities/logadmin');
    }

    public function data_list()
    {
        if (!$this->guard_menu_access(111, 'view')) {
            return;
        }
        $page = $this->input->post('page', true) ?: $this->input->get('page', true) ?: 1;
        $per_page = $this->input->post('per_page', true) ?: $this->input->get('per_page', true) ?: 10;
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';
        $mst_adminid = $this->input->post('mst_adminid', true) ?: $this->input->get('mst_adminid', true) ?: '';
        $set_menuid = $this->input->post('set_menuid', true) ?: $this->input->get('set_menuid', true) ?: '';
        $action = $this->input->post('action', true) ?: $this->input->get('action', true) ?: '';
        $sort_by = $this->input->post('sort_by', true) ?: $this->input->get('sort_by', true) ?: 'created_date';
        $sort_dir = $this->input->post('sort_dir', true) ?: $this->input->get('sort_dir', true) ?: 'DESC';

        $result = $this->LogAdmin_Model->data_list($page, $per_page, $search, $mst_adminid, $set_menuid, $action, $sort_by, $sort_dir);
        $this->respond([
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => $result['data'],
            'pagination' => $result['pagination']
        ]);
    }

    public function data_option_admin()
    {
        if (!$this->guard_menu_access(111, 'view')) {
            return;
        }

        $result = $this->LogAdmin_Model->data_option_admin();
        $this->respond($result);
    }

    public function data_option_menu()
    {
        if (!$this->guard_menu_access(111, 'view')) {
            return;
        }

        $result = $this->LogAdmin_Model->data_option_menu();
        $this->respond($result);
    }

    public function data_print()
    {
        if (!$this->guard_menu_access(111, 'print')) {
            return;
        }

        $search = $this->input->get('search', true);
        if ($search === null) {
            $search = '';
        }

        $mst_adminid = $this->input->get('mst_adminid', true);
        if ($mst_adminid === null) {
            $mst_adminid = '';
        }

        $set_menuid = $this->input->get('set_menuid', true);
        if ($set_menuid === null) {
            $set_menuid = '';
        }

        $action = $this->input->get('action', true);
        if ($action === null) {
            $action = '';
        }

        $sort_by = $this->input->get('sort_by', true);
        if ($sort_by === null || $sort_by === '') {
            $sort_by = 'created_date';
        }

        $sort_dir = $this->input->get('sort_dir', true);
        if ($sort_dir === null || $sort_dir === '') {
            $sort_dir = 'DESC';
        }

        $params = [];
        if ($search !== '') {
            $params[] = 'search=' . urlencode($search);
        }
        if ($mst_adminid !== '') {
            $params[] = 'mst_adminid=' . urlencode($mst_adminid);
        }
        if ($set_menuid !== '') {
            $params[] = 'set_menuid=' . urlencode($set_menuid);
        }
        if ($action !== '') {
            $params[] = 'action=' . urlencode($action);
        }
        if ($sort_by !== '') {
            $params[] = 'sort_by=' . urlencode($sort_by);
        }
        if ($sort_dir !== '') {
            $params[] = 'sort_dir=' . urlencode($sort_dir);
        }

        $query_string = !empty($params) ? implode('&', $params) : '';

        $pages = site_url('activities/logadmin/data_printhtml' . (!empty($query_string) ? '?' . $query_string : ''));
        $head = site_url('activities/logadmin/data_printhead');
        $current_user = $this->Auth_Model->current_user();
        $username = $current_user ? $current_user->username : 'Unknown';
        topdf($pages, $head, 20, 0, 0, 0, $username);
    }

    public function data_printhead()
    {
        if (!$this->guard_menu_access(111, 'print')) {
            return;
        }
        $table = '<table border="0" width="970" class="tablerep">
        <tr>
            <td class="headertd" width="120">Username</td>
            <td class="headertd" width="150">Menu Name</td>
            <td class="headertd" width="90">Action</td>
            <td class="headertd" width="160">Created Date</td>
            <td class="headertd" width="150">IP Address</td>
        </tr>
		</table>';

        $data['title'] = 'Log Admin';
        $data['table'] = $table;

        $this->load->view('act/act_common_head', $data);
    }

    public function data_printhtml($filename = '', $ex = 0)
    {
        $subperm = ((int) $ex === 1) ? 'export' : 'print';
        if (!$this->guard_menu_access(111, $subperm)) {
            return;
        }

        $search = $this->input->get('search', true);
        if ($search === null) {
            $search = '';
        }

        $mst_adminid = $this->input->get('mst_adminid', true);
        if ($mst_adminid === null) {
            $mst_adminid = '';
        }

        $set_menuid = $this->input->get('set_menuid', true);
        if ($set_menuid === null) {
            $set_menuid = '';
        }

        $action = $this->input->get('action', true);
        if ($action === null) {
            $action = '';
        }

        $sort_by = $this->input->get('sort_by', true);
        if ($sort_by === null || $sort_by === '') {
            $sort_by = 'created_date';
        }

        $sort_dir = $this->input->get('sort_dir', true);
        if ($sort_dir === null || $sort_dir === '') {
            $sort_dir = 'DESC';
        }

        $result = $this->LogAdmin_Model->data_list_print($search, $mst_adminid, $set_menuid, $action, $sort_by, $sort_dir);
        if (!$result['success']) {
            show_error($result['message']);
            return;
        }

        $rows = isset($result['data']) ? $result['data'] : [];
        $table = '<table border="0" width="970" class="tablerep">';

        if ($ex == 1) {
            $table .= '
            <tr>
                <td class="headertd" width="120">Username</td>
                <td class="headertd" width="150">Menu Name</td>
                <td class="headertd" width="90">Action</td>
                <td class="headertd" width="160">Created Date</td>
                <td class="headertd" width="150">IP Address</td>
            </tr>';
        }

        foreach ($rows as $row) {
            $menu_name = !empty($row->menu_name) ? $row->menu_name : '-';
            $ip_address = !empty($row->ip_address) ? $row->ip_address : '-';
            $created_date = !empty($row->created_date) ? $row->created_date : '-';
            $username = !empty($row->username) ? $row->username : '-';
            $action_label = !empty($row->action) ? $row->action : '-';

            $table .= "
            <tr valign='top'>
                <td class='text' width='120'>{$username}</td>
                <td class='text' width='150'>{$menu_name}</td>
                <td class='text' width='90'>{$action_label}</td>
                <td class='text' width='160'>{$created_date}</td>
                <td class='text' width='150'>{$ip_address}</td>
            </tr>";
        }

        $table .= "</table>";

        $output['title'] = 'Log Admin';
        $output['table'] = $table;
        $output['ex'] = $ex;
        $output['filename'] = $filename;

        $this->log_activity('EXPORT', 'Export admin log report');
        $this->load->view('act/common_print', $output);
    }
}
