<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('LogAdmin_Model');
        $this->load->model('User_Model');

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
            'set_menuid' => 103,
            'action' => strtoupper(trim((string) $action)),
            'description' => trim((string) $description),
            'ip_address' => $this->input->ip_address(),
            'ua' => $this->session->userdata('user_agent') ?: $this->session->userdata('user_agent') ?: '',
            'mac' => $this->session->userdata('mac_address') ?: $this->session->userdata('mac_address') ?: ''
        ]);

        return isset($result['success']) ? (bool) $result['success'] : false;
    }

    public function index()
    {
        if (!$this->guard_menu_access(103, 'view')) {
            return;
        }
 
        $this->load->view('activities/user');
    }

    public function data_list()
    {
        if (!$this->guard_menu_access(103, 'view')) {
            return;
        }

        $page = $this->input->post('page', true) ?: $this->input->get('page', true) ?: 1;
        $per_page = $this->input->post('per_page', true) ?: $this->input->get('per_page', true) ?: 10;
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';
        $suspended = $this->input->post('suspended', true);
        if ($suspended === null) {
            $suspended = $this->input->get('suspended', true);
        }
        $sort_by = $this->input->post('sort_by', true) ?: $this->input->get('sort_by', true) ?: 'username';
        $sort_dir = $this->input->post('sort_dir', true) ?: $this->input->get('sort_dir', true) ?: 'ASC';

        $result = $this->User_Model->data_list($page, $per_page, $search, $suspended, $sort_by, $sort_dir);
        $response = [
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => $result['data'],
            'pagination' => $result['pagination']
        ];
        $this->respond($response);
    }

    public function data_new()
    {
        if (!$this->guard_menu_access(103, 'new')) {
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->User_Model->rules('create'));

        if ($this->form_validation->run() == FALSE) {
            $this->respond([
                'success' => false,
                'message' => validation_errors()
            ]);
            return;
        }

        $input = [
            'username' => $this->input->post('username', true),
            'email' => $this->input->post('email', true),
            'password' => $this->input->post('password', true),
            'suspended' => $this->input->post('suspended', true),
            'permissions' => json_decode($this->input->post('permissions'), true) ?: []
        ];

        $result = $this->User_Model->data_new($input);
        if (!empty($result['success'])) {
            $this->log_activity('NEW', 'Create user ' . ($input['username'] ?? ''));
        }
        $this->respond($result);
    }

    public function data_edit()
    {
        if (!$this->guard_menu_access(103, 'view')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $response = [
                'success' => false,
                'message' => 'User ID is required'
            ];
            $this->respond($response);
            return;
        }

        $result = $this->User_Model->data_edit($id);
        $response = [
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => isset($result['data']) ? $result['data'] : null,
            'permissions' => isset($result['permissions']) ? $result['permissions'] : []
        ];
        $this->respond($response);
    }

    public function data_update()
    {
        if (!$this->guard_menu_access(103, 'update')) {
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->User_Model->rules('update'));

        if ($this->form_validation->run() == FALSE) {
            $response = [
                'success' => false,
                'message' => validation_errors()
            ];
            $this->respond($response);
            return;
        }

        $id = $this->input->post('id', true);
        $input = [
            'username' => $this->input->post('username', true),
            'email' => $this->input->post('email', true),
            'password' => $this->input->post('password', true),
            'suspended' => $this->input->post('suspended', true),
            'permissions' => json_decode($this->input->post('permissions'), true) ?: []
        ];

        if (!$id) {
            $this->respond([
                'success' => false,
                'message' => 'User ID is required'
            ]);
            return;
        }

        $current_user = $this->Auth_Model->current_user();
        if ($current_user && (int) $id === (int) $current_user->mst_adminid) {
            if (!empty($input['suspended'])) {
                $this->respond([
                    'success' => false,
                    'message' => 'You cannot suspend your own account'
                ]);
                return;
            }
        }

        $result = $this->User_Model->data_update($id, $input);
        if (!empty($result['success'])) {
            $this->log_activity('EDIT', 'Update user ' . $id);
        }

        $this->respond($result);
    }

    public function data_delete()
    {
        if (!$this->guard_menu_access(103, 'delete')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $response = [
                'success' => false,
                'message' => 'User ID is required'
            ];
            $this->respond($response);
            return;
        }

        $current_user = $this->Auth_Model->current_user();
        if ($current_user && (int) $id === (int) $current_user->mst_adminid) {
            $this->respond([
                'success' => false,
                'message' => 'You cannot suspend/delete your own account'
            ]);
            return;
        }

        $result = $this->User_Model->data_delete($id);
        if (!empty($result['success'])) {
            $this->log_activity('SUSPEND', 'Suspend user ' . $id);
        }
        $this->respond($result);
    }

    public function data_force_logout()
    {
        if (!$this->guard_menu_access(103, 'update')) {
            return;
        }

        $id = $this->input->post('id', true);
        if (!$id) {
            $this->respond(['success' => false, 'message' => 'User ID is required']);
            return;
        }

        $current_user = $this->Auth_Model->current_user();
        if ($current_user && (int) $id === (int) $current_user->mst_adminid) {
            $this->respond(['success' => false, 'message' => 'You cannot force logout your own account']);
            return;
        }

        $result = $this->Auth_Model->force_logout($id);
        if (!empty($result['success'])) {
            $this->log_activity('FORCE_LOGOUT', 'Force logout user ' . $id);
        }
        $this->respond($result);
    }

    public function data_print()
    {
        if (!$this->guard_menu_access(103, 'print')) {
            return;
        }

        $search = $this->input->get('search', true);
        if ($search === null) {
            $search = '';
        }

        $suspended = $this->input->get('suspended', true);
        if ($suspended === null) {
            $suspended = '';
        }

        $sort_by = $this->input->get('sort_by', true);
        if ($sort_by === null || $sort_by === '') {
            $sort_by = 'mst_adminid';
        }

        $sort_dir = $this->input->get('sort_dir', true);
        if ($sort_dir === null || $sort_dir === '') {
            $sort_dir = 'DESC';
        }

        $params = [];
        if ($search !== '') {
            $params[] = 'search=' . urlencode($search);
        }
        if ($suspended !== '') {
            $params[] = 'suspended=' . urlencode($suspended);
        }
        if ($sort_by !== '') {
            $params[] = 'sort_by=' . urlencode($sort_by);
        }
        if ($sort_dir !== '') {
            $params[] = 'sort_dir=' . urlencode($sort_dir);
        }

        $query_string = !empty($params) ? implode('&', $params) : '';

        $pages = site_url('activities/user/data_printhtml' . (!empty($query_string) ? '?' . $query_string : ''));
        $head = site_url('activities/user/data_printhead');
        $current_user = $this->Auth_Model->current_user();
        $username = $current_user ? $current_user->username : 'Unknown';
        topdf($pages, $head, 20, 0, 0, 0, $username);
    }

    public function data_printhead()
    {
        if (!$this->guard_menu_access(103, 'print')) {
            return;
        }

        $table = '<table border="0" width="970" class="tablerep">
        <tr>
			<td class="headertd" width="60">ID</td>
			<td class="headertd" width="180">Username</td>
			<td class="headertd" width="180">Email</td>
			<td class="headertd" width="100">Suspended</td>
			<td class="headertd" width="180">Created At</td>
			<td class="headertd" width="180">Modified At</td>
        </tr>
		</table>';

        $data['title'] = 'User (Admin)';
        $data['table'] = $table;

        $this->load->view('act/act_common_head', $data);
    }

    public function data_printhtml($filename = '', $ex = 0)
    {
        $subperm = ((int) $ex === 1) ? 'export' : 'print';
        if (!$this->guard_menu_access(103, $subperm)) {
            return;
        }

        $search = $this->input->get('search', true);
        if ($search === null) {
            $search = '';
        }

        $suspended = $this->input->get('suspended', true);
        if ($suspended === null) {
            $suspended = '';
        }

        $sort_by = $this->input->get('sort_by', true);
        if ($sort_by === null || $sort_by === '') {
            $sort_by = 'mst_adminid';
        }

        $sort_dir = $this->input->get('sort_dir', true);
        if ($sort_dir === null || $sort_dir === '') {
            $sort_dir = 'DESC';
        }

        $result = $this->User_Model->data_list_print($search, $suspended, $sort_by, $sort_dir);

        if (!$result['success']) {
            show_error($result['message']);
            return;
        }

        $this->log_activity('EXPORT', 'Export user report');
        $rows = isset($result['data']) ? $result['data'] : [];
        $table = '<table border="0" width="970" class="tablerep">';

        if ($ex == 1) {
            $table = $table . '
			<tr>
                <td class="headertd" width="60">ID</td>
                <td class="headertd" width="180">Username</td>
                <td class="headertd" width="180">Email</td>
                <td class="headertd" width="100">Suspended</td>
                <td class="headertd" width="180">Created At</td>
                <td class="headertd" width="180">Modified At</td>
            </tr>';
        }

        foreach ($rows as $row) {
            $suspended_label = ((int) $row->suspended === 1) ? 'YES' : 'NO';
            $created_date = !empty($row->created_date) ? $row->created_date : '-';
            $modified_date = !empty($row->modified_date) ? $row->modified_date : '-';

            $table .= "
            <tr valign='top'>
                <td class='text' width='60'>{$row->mst_adminid}</td>
                <td class='text' width='180'>{$row->username}</td>
                <td class='text' width='180'>" . htmlspecialchars($row->email ?? '-', ENT_QUOTES, 'UTF-8') . "</td>
                <td class='text' width='100'>{$suspended_label}</td>
                <td class='text' width='180'>{$created_date}</td>
                <td class='text' width='180'>{$modified_date}</td>
            </tr>";
        }

        $table .= "</table>";

        $output['title'] = 'User (Admin)';
        $output['table'] = $table;
        $output['ex'] = $ex;
        $output['filename'] = $filename;

        $this->load->view('act/common_print', $output);
    }
}
