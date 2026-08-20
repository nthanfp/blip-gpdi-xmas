<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Itemgift extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('LogAdmin_Model');
        $this->load->model('Itemgift_Model');

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
            'set_menuid' => 104,
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
        if (!$this->guard_menu_access(104, 'view')) {
            return;
        }

        $this->load->view('activities/itemgift');
    }

    public function data_list()
    {
        if (!$this->guard_menu_access(104, 'view')) {
            return;
        }

        $page = $this->input->post('page', true) ?: $this->input->get('page', true) ?: 1;
        $per_page = $this->input->post('per_page', true) ?: $this->input->get('per_page', true) ?: 10;
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';
        $itemtype = $this->input->post('itemtype', true) ?: $this->input->get('itemtype', true) ?: '';
        $suspended = $this->input->post('suspended', true);
        if ($suspended === null) {
            $suspended = $this->input->get('suspended', true);
        }
        $sort_by = $this->input->post('sort_by', true) ?: $this->input->get('sort_by', true) ?: 'created_date';
        $sort_dir = $this->input->post('sort_dir', true) ?: $this->input->get('sort_dir', true) ?: 'ASC';

        $result = $this->Itemgift_Model->data_list($page, $per_page, $search, $itemtype, $suspended, $sort_by, $sort_dir);
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
        if (!$this->guard_menu_access(104, 'new')) {
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->Itemgift_Model->rules('create'));

        if ($this->form_validation->run() == FALSE) {
            $this->respond([
                'success' => false,
                'message' => validation_errors()
            ]);
            return;
        }

        $input = [
            'value' => $this->input->post('value', true),
            'itemname' => $this->input->post('itemname', true),
            'itemtype' => $this->input->post('itemtype', true),
            'suspended' => $this->input->post('suspended', true)
        ];

        $result = $this->Itemgift_Model->data_new($input);
        if (!empty($result['success'])) {
            $this->log_activity('NEW', 'Create item gift ' . ($input['itemname'] ?? ''));
        }
        $this->respond($result);
    }

    public function data_edit()
    {
        if (!$this->guard_menu_access(104, 'view')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond([
                'success' => false,
                'message' => 'Item gift ID is required'
            ]);
            return;
        }

        $result = $this->Itemgift_Model->data_edit($id);
        $response = [
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => isset($result['data']) ? $result['data'] : null
        ];
        $this->respond($response);
    }

    public function data_update()
    {
        if (!$this->guard_menu_access(104, 'update')) {
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->Itemgift_Model->rules('update'));

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
                'message' => 'Item gift ID is required'
            ]);
            return;
        }

        $input = [
            'value' => $this->input->post('value', true),
            'itemname' => $this->input->post('itemname', true),
            'itemtype' => $this->input->post('itemtype', true),
            'suspended' => $this->input->post('suspended', true)
        ];

        $result = $this->Itemgift_Model->data_update($id, $input);
        if (!empty($result['success'])) {
            $this->log_activity('EDIT', 'Update item gift ' . $id);
        }
        $this->respond($result);
    }

    public function data_delete()
    {
        if (!$this->guard_menu_access(104, 'delete')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond([
                'success' => false,
                'message' => 'Item gift ID is required'
            ]);
            return;
        }

        $result = $this->Itemgift_Model->data_delete($id);
        if (!empty($result['success'])) {
            $this->log_activity('DELETE', 'Delete item gift ' . $id);
        }
        $this->respond($result);
    }

    public function data_suspend()
    {
        if (!$this->guard_menu_access(104, 'update')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond([
                'success' => false,
                'message' => 'Item gift ID is required'
            ]);
            return;
        }

        $result = $this->Itemgift_Model->data_suspend($id);
        if (!empty($result['success'])) {
            $this->log_activity('SUSPEND', 'Suspend item gift ' . $id);
        }
        $this->respond($result);
    }

    public function data_print()
    {
        if (!$this->guard_menu_access(104, 'print')) {
            return;
        }

        $search = $this->input->get('search', true);
        if ($search === null) {
            $search = '';
        }

        $itemtype = $this->input->get('itemtype', true);
        if ($itemtype === null) {
            $itemtype = '';
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
        if ($itemtype !== '') {
            $params[] = '$itemtype=' . urlencode($itemtype);
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

        $pages = site_url('activities/itemgift/data_printhtml' . (!empty($query_string) ? '?' . $query_string : ''));
        $head = site_url('activities/itemgift/data_printhead');
        $current_user = $this->Auth_Model->current_user();
        $username = $current_user ? $current_user->username : 'Unknown';
        topdf($pages, $head, 20, 0, 0, 0, $username);
    }

    public function data_printhead()
    {
        if (!$this->guard_menu_access(104, 'print')) {
            return;
        }

        $table = '<table border="0" width="970" class="tablerep">
        <tr>
			<td class="headertd" width="200">Item Name</td>
			<td class="headertd" width="120">Item Type</td>
			<td class="headertd" width="100">Suspended</td>
        </tr>
		</table>';

        $data['title'] = 'Item Gift';
        $data['table'] = $table;

        $this->load->view('act/act_common_head', $data);
    }

    public function data_printhtml($filename = '', $ex = 0)
    {
        $subperm = ((int) $ex === 1) ? 'export' : 'print';
        if (!$this->guard_menu_access(104, $subperm)) {
            return;
        }

        $search = $this->input->get('search', true);
        if ($search === null) {
            $search = '';
        }

        $itemtype = $this->input->get('itemtype', true);
        if ($itemtype === null) {
            $itemtype = '';
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

        $result = $this->Itemgift_Model->data_list_print($search, $itemtype, $suspended, $sort_by, $sort_dir);

        if (!$result['success']) {
            show_error($result['message']);
            return;
        }

        $rows = isset($result['data']) ? $result['data'] : [];
        $table = '<table border="0" width="970" class="tablerep">';

        if ($ex == 1) {
            $table = $table . '
			<tr>
                <td class="headertd" width="200">Item Name</td>
                <td class="headertd" width="120">Item Type</td>
                <td class="headertd" width="100">Suspended</td>
            </tr>';
        }

        foreach ($rows as $row) {
            $suspended_label = ((int) $row->suspended === 1) ? 'YES' : 'NO';
            $itemtype_label = ((int) $row->itemtype === 1) ? 'POINT' : 'OTHER';

            $table .= "
            <tr valign='top'>
                <td class='text' width='200'>{$row->itemname}</td>
                <td class='text' width='120'>{$itemtype_label}</td>
                <td class='text' width='100'>{$suspended_label}</td>
            </tr>";
        }

        $table .= "</table>";

        $output['title'] = 'Item Gift';
        $output['table'] = $table;
        $output['ex'] = $ex;
        $output['filename'] = $filename;

        if ($ex == 1) {
            $this->log_activity('EXPORT', 'Export item gift report');
        }

        $this->load->view('act/common_print', $output);
    }
}
