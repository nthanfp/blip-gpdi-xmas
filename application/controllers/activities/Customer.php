<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('LogAdmin_Model');
        $this->load->model('Customer_Model');

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
            'set_menuid' => 112,
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
        if (!$this->guard_menu_access(112, 'view')) {
            return;
        }

        $this->load->view('activities/customer');
    }

    public function data_list()
    {
        if (!$this->guard_menu_access(112, 'view')) {
            return;
        }

        $page = $this->input->post('page', true) ?: $this->input->get('page', true) ?: 1;
        $per_page = $this->input->post('per_page', true) ?: $this->input->get('per_page', true) ?: 10;
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';
        $mst_reg_provinceid = $this->input->post('mst_reg_provinceid', true) ?: $this->input->get('mst_reg_provinceid', true) ?: '';
        $mst_reg_cityid = $this->input->post('mst_reg_cityid', true) ?: $this->input->get('mst_reg_cityid', true) ?: '';
        $mst_reg_districtid = $this->input->post('mst_reg_districtid', true) ?: $this->input->get('mst_reg_districtid', true) ?: '';
        $mst_reg_villageid = $this->input->post('mst_reg_villageid', true) ?: $this->input->get('mst_reg_villageid', true) ?: '';
        $sort_by = $this->input->post('sort_by', true) ?: $this->input->get('sort_by', true) ?: 'created_date';
        $sort_dir = $this->input->post('sort_dir', true) ?: $this->input->get('sort_dir', true) ?: 'DESC';

        $result = $this->Customer_Model->data_list($page, $per_page, $search, $mst_reg_provinceid, $mst_reg_cityid, $mst_reg_districtid, $mst_reg_villageid, $sort_by, $sort_dir);
        $this->respond($result);
    }

    public function data_new()
    {
        if (!$this->guard_menu_access(112, 'new')) {
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->Customer_Model->rules('create'));

        if ($this->form_validation->run() == FALSE) {
            $this->respond([
                'success' => false,
                'message' => validation_errors()
            ]);
            return;
        }

        $input = [
            'custname' => $this->input->post('custname', true),
            'phone_number' => $this->input->post('phone_number', true),
            'email' => $this->input->post('email', true),
            'mst_reg_provinceid' => $this->input->post('mst_reg_provinceid', true),
            'mst_reg_cityid' => $this->input->post('mst_reg_cityid', true),
            'mst_reg_districtid' => $this->input->post('mst_reg_districtid', true),
            'mst_reg_villageid' => $this->input->post('mst_reg_villageid', true)
        ];

        $result = $this->Customer_Model->data_new($input);
        if (!empty($result['success'])) {
            $this->log_activity('NEW', 'Create customer ' . ($input['custname'] ?? ''));
        }
        $this->respond($result);
    }

    public function data_edit()
    {
        if (!$this->guard_menu_access(112, 'view')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond([
                'success' => false,
                'message' => 'Customer ID is required'
            ]);
            return;
        }

        $result = $this->Customer_Model->data_edit($id);
        $this->respond($result);
    }

    public function data_update()
    {
        if (!$this->guard_menu_access(112, 'update')) {
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->Customer_Model->rules('update'));

        if ($this->form_validation->run() == FALSE) {
            $this->respond([
                'success' => false,
                'message' => validation_errors()
            ]);
            return;
        }

        $id = $this->input->post('id', true);
        if (!$id) {
            $this->respond([
                'success' => false,
                'message' => 'Customer ID is required'
            ]);
            return;
        }

        $input = [
            'custname' => $this->input->post('custname', true),
            'phone_number' => $this->input->post('phone_number', true),
            'email' => $this->input->post('email', true),
            'mst_reg_provinceid' => $this->input->post('mst_reg_provinceid', true),
            'mst_reg_cityid' => $this->input->post('mst_reg_cityid', true),
            'mst_reg_districtid' => $this->input->post('mst_reg_districtid', true),
            'mst_reg_villageid' => $this->input->post('mst_reg_villageid', true)
        ];

        $result = $this->Customer_Model->data_update($id, $input);
        if (!empty($result['success'])) {
            $this->log_activity('EDIT', 'Update customer ' . $id);
        }
        $this->respond($result);
    }

    public function data_delete()
    {
        if (!$this->guard_menu_access(112, 'delete')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond([
                'success' => false,
                'message' => 'Customer ID is required'
            ]);
            return;
        }

        $result = $this->Customer_Model->data_delete($id);
        if (!empty($result['success'])) {
            $this->log_activity('DELETE', 'Delete customer ' . $id);
        }
        $this->respond($result);
    }

    public function data_print()
    {
        if (!$this->guard_menu_access(112, 'print')) {
            return;
        }

        $search = $this->input->get('search', true);
        if ($search === null) {
            $search = '';
        }

        $mst_reg_provinceid = $this->input->get('mst_reg_provinceid', true);
        if ($mst_reg_provinceid === null) {
            $mst_reg_provinceid = '';
        }

        $mst_reg_cityid = $this->input->get('mst_reg_cityid', true);
        if ($mst_reg_cityid === null) {
            $mst_reg_cityid = '';
        }

        $mst_reg_districtid = $this->input->get('mst_reg_districtid', true);
        if ($mst_reg_districtid === null) {
            $mst_reg_districtid = '';
        }

        $mst_reg_villageid = $this->input->get('mst_reg_villageid', true);
        if ($mst_reg_villageid === null) {
            $mst_reg_villageid = '';
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
        if ($mst_reg_provinceid !== '') {
            $params[] = 'mst_reg_provinceid=' . urlencode($mst_reg_provinceid);
        }
        if ($mst_reg_cityid !== '') {
            $params[] = 'mst_reg_cityid=' . urlencode($mst_reg_cityid);
        }
        if ($mst_reg_districtid !== '') {
            $params[] = 'mst_reg_districtid=' . urlencode($mst_reg_districtid);
        }
        if ($mst_reg_villageid !== '') {
            $params[] = 'mst_reg_villageid=' . urlencode($mst_reg_villageid);
        }
        if ($sort_by !== '') {
            $params[] = 'sort_by=' . urlencode($sort_by);
        }
        if ($sort_dir !== '') {
            $params[] = 'sort_dir=' . urlencode($sort_dir);
        }

        $query_string = !empty($params) ? implode('&', $params) : '';

        $pages = site_url('activities/customer/data_printhtml' . (!empty($query_string) ? '?' . $query_string : ''));
        $head = site_url('activities/customer/data_printhead');
        $current_user = $this->Auth_Model->current_user();
        $username = $current_user ? $current_user->username : 'Unknown';
        topdf($pages, $head, 20, 0, 0, 0, $username);
    }

    public function data_printhead()
    {
        if (!$this->guard_menu_access(112, 'print')) {
            return;
        }

        $table = '<table border="0" width="970" class="tablerep">
        <tr>
            <td class="headertd" width="80">ID</td>
            <td class="headertd" width="220">Customer Name</td>
            <td class="headertd" width="180">Phone Number</td>
            <td class="headertd" width="220">Email</td>
            <td class="headertd" width="160">Created Date</td>
        </tr>
		</table>';

        $data['title'] = 'Customer';
        $data['table'] = $table;

        $this->load->view('act/act_common_head', $data);
    }

    public function data_printhtml($filename = '', $ex = 0)
    {
        $subperm = ((int) $ex === 1) ? 'export' : 'print';
        if (!$this->guard_menu_access(112, $subperm)) {
            return;
        }

        $search = $this->input->get('search', true);
        if ($search === null) {
            $search = '';
        }

        $mst_reg_provinceid = $this->input->get('mst_reg_provinceid', true);
        if ($mst_reg_provinceid === null) {
            $mst_reg_provinceid = '';
        }

        $mst_reg_cityid = $this->input->get('mst_reg_cityid', true);
        if ($mst_reg_cityid === null) {
            $mst_reg_cityid = '';
        }

        $mst_reg_districtid = $this->input->get('mst_reg_districtid', true);
        if ($mst_reg_districtid === null) {
            $mst_reg_districtid = '';
        }

        $mst_reg_villageid = $this->input->get('mst_reg_villageid', true);
        if ($mst_reg_villageid === null) {
            $mst_reg_villageid = '';
        }

        $sort_by = $this->input->get('sort_by', true);
        if ($sort_by === null || $sort_by === '') {
            $sort_by = 'created_date';
        }

        $sort_dir = $this->input->get('sort_dir', true);
        if ($sort_dir === null || $sort_dir === '') {
            $sort_dir = 'DESC';
        }

        $result = $this->Customer_Model->data_list_print($search, $mst_reg_provinceid, $mst_reg_cityid, $mst_reg_districtid, $mst_reg_villageid, $sort_by, $sort_dir);
        if (!$result['success']) {
            show_error($result['message']);
            return;
        }

        $rows = isset($result['data']) ? $result['data'] : [];
        $table = '<table border="0" width="970" class="tablerep">';

        if ($ex == 1) {
            $table .= '
            <tr>
                <td class="headertd" width="80">ID</td>
                <td class="headertd" width="220">Customer Name</td>
                <td class="headertd" width="180">Phone Number</td>
                <td class="headertd" width="220">Email</td>
                <td class="headertd" width="160">Created Date</td>
            </tr>';
        }

        foreach ($rows as $row) {
            $table .= "
            <tr valign='top'>
                <td class='text' width='80'>{$row->mst_customerid}</td>
                <td class='text' width='220'>{$row->custname}</td>
                <td class='text' width='180'>{$row->phone_number}</td>
                <td class='text' width='220'>{$row->email}</td>
                <td class='text' width='160'>{$row->created_date}</td>
            </tr>";
        }

        $table .= "</table>";

        $output['title'] = 'Customer';
        $output['table'] = $table;
        $output['ex'] = $ex;
        $output['filename'] = $filename;

        $this->load->view('act/common_print', $output);
    }
}
