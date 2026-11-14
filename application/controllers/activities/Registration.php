<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registration extends CI_Controller
{
    private $_menuid = 120;

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('Registration_Model');

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

    public function index()
    {
        if (!$this->guard_menu_access($this->_menuid, 'view')) {
            return;
        }

        $this->load->view('activities/registration');
    }

    public function data_list()
    {
        if (!$this->guard_menu_access($this->_menuid, 'view')) {
            return;
        }

        $page = $this->input->post('page', true) ?: $this->input->get('page', true) ?: 1;
        $per_page = $this->input->post('per_page', true) ?: $this->input->get('per_page', true) ?: 10;
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';
        $floor = $this->input->post('floor', true) ?: $this->input->get('floor', true) ?: '';
        $status = $this->input->post('status', true) ?: $this->input->get('status', true) ?: '';
        $sort_by = $this->input->post('sort_by', true) ?: $this->input->get('sort_by', true) ?: 'date';
        $sort_order = $this->input->post('sort_order', true) ?: $this->input->get('sort_order', true) ?: 'desc';

        $result = $this->Registration_Model->data_list($page, $per_page, $search, $floor, $status, $sort_by, $sort_order);
        $this->respond([
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => $result['data'],
            'pagination' => $result['pagination']
        ]);
    }

    public function data_stats()
    {
        if (!$this->guard_menu_access($this->_menuid, 'view')) {
            return;
        }

        $this->respond($this->Registration_Model->data_stats());
    }

    public function data_list_people()
    {
        if (!$this->guard_menu_access($this->_menuid, 'view')) {
            return;
        }

        $page = $this->input->post('page', true) ?: $this->input->get('page', true) ?: 1;
        $per_page = $this->input->post('per_page', true) ?: $this->input->get('per_page', true) ?: 10;
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';
        $floor = $this->input->post('floor', true) ?: $this->input->get('floor', true) ?: '';
        $status = $this->input->post('status', true) ?: $this->input->get('status', true) ?: '';
        $sort_by = $this->input->post('sort_by', true) ?: $this->input->get('sort_by', true) ?: 'date';
        $sort_order = $this->input->post('sort_order', true) ?: $this->input->get('sort_order', true) ?: 'desc';

        $result = $this->Registration_Model->data_list_people($page, $per_page, $search, $floor, $status, $sort_by, $sort_order);
        $this->respond($result);
    }

    public function data_list_duplicates()
    {
        if (!$this->guard_menu_access($this->_menuid, 'view')) {
            return;
        }

        $page = $this->input->post('page', true) ?: $this->input->get('page', true) ?: 1;
        $per_page = $this->input->post('per_page', true) ?: $this->input->get('per_page', true) ?: 10;
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';
        $floor = $this->input->post('floor', true) ?: $this->input->get('floor', true) ?: '';
        $status = $this->input->post('status', true) ?: $this->input->get('status', true) ?: '';
        $sort_by = $this->input->post('sort_by', true) ?: $this->input->get('sort_by', true) ?: 'phone';
        $sort_order = $this->input->post('sort_order', true) ?: $this->input->get('sort_order', true) ?: 'asc';

        $result = $this->Registration_Model->data_list_duplicates($page, $per_page, $search, $floor, $status, $sort_by, $sort_order);
        $this->respond($result);
    }

    public function data_detail()
    {
        if (!$this->guard_menu_access($this->_menuid, 'view')) {
            return;
        }

        $id = $this->input->post('id', true) ?: $this->input->get('id', true);
        $this->respond($this->Registration_Model->data_detail($id));
    }

    public function data_status()
    {
        if (!$this->guard_menu_access($this->_menuid, 'update')) {
            return;
        }

        $id = $this->input->post('id', true);
        $status = $this->input->post('status', true);
        $attendees = $this->input->post('attendees', true);

        if ($id === null || $id === '' || $status === null || $status === '') {
            $this->respond(['success' => false, 'message' => 'ID and status are required']);
            return;
        }

        if (!is_array($attendees)) {
            $attendees = [];
        }

        $this->respond($this->Registration_Model->data_status($id, $status, $attendees));
    }

    public function data_delete()
    {
        if (!$this->guard_menu_access($this->_menuid, 'delete')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond(['success' => false, 'message' => 'Registration ID is required']);
            return;
        }

        $this->respond($this->Registration_Model->data_delete($id));
    }

    public function data_delete_attendee()
    {
        if (!$this->guard_menu_access($this->_menuid, 'delete')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond(['success' => false, 'message' => 'Attendee ID is required']);
            return;
        }

        $this->respond($this->Registration_Model->data_delete_attendee($id));
    }

    public function data_capacity()
    {
        if (!$this->guard_menu_access($this->_menuid, 'update')) {
            return;
        }

        $cap1 = $this->input->post('capacity1', true);
        $cap2 = $this->input->post('capacity2', true);

        if ($cap1 === null || $cap1 === '' || $cap2 === null || $cap2 === '') {
            $this->respond(['success' => false, 'message' => 'Floor 1 and Floor 2 quota are required.']);
            return;
        }

        $this->respond($this->Registration_Model->data_update_capacity($cap1, $cap2));
    }

    private function print_params()
    {
        $search = $this->input->get('search', true);
        if ($search === null) {
            $search = '';
        }

        $floor = $this->input->get('floor', true);
        if ($floor === null) {
            $floor = '';
        }

        $status = $this->input->get('status', true);
        if ($status === null) {
            $status = '';
        }

        $sort_by = $this->input->get('sort_by', true);
        if ($sort_by === null || $sort_by === '') {
            $sort_by = 'date';
        }

        $sort_order = $this->input->get('sort_order', true);
        if ($sort_order === null || $sort_order === '') {
            $sort_order = 'desc';
        }

        return compact('search', 'floor', 'status', 'sort_by', 'sort_order');
    }

    private function print_query_string(array $params)
    {
        $parts = [];
        if ($params['search'] !== '') {
            $parts[] = 'search=' . urlencode($params['search']);
        }
        if ($params['floor'] !== '') {
            $parts[] = 'floor=' . urlencode($params['floor']);
        }
        if ($params['status'] !== '') {
            $parts[] = 'status=' . urlencode($params['status']);
        }
        $parts[] = 'sort_by=' . urlencode($params['sort_by']);
        $parts[] = 'sort_order=' . urlencode($params['sort_order']);

        return implode('&', $parts);
    }

    public function data_print()
    {
        if (!$this->guard_menu_access($this->_menuid, 'print')) {
            return;
        }

        $params = $this->print_params();

        /* Filter lantai wajib untuk print */
        if ($params['floor'] !== '1' && $params['floor'] !== '2') {
            show_error('Filter lantai wajib dipilih untuk print (Floor 1 atau Floor 2).', 400);
            return;
        }

        $query_string = $this->print_query_string($params);

        $pages = site_url('activities/registration/data_printhtml' . (!empty($query_string) ? '?' . $query_string : ''));
        $head = site_url('activities/registration/data_printhead');
        $current_user = $this->Auth_Model->current_user();
        $username = $current_user ? $current_user->username : 'Unknown';
        topdf($pages, $head, 20, 0, 0, 0, $username);
    }

    public function data_printhead()
    {
        if (!$this->guard_menu_access($this->_menuid, 'print')) {
            return;
        }

        $table = '<table border="0" width="970" class="tablerep">
        <tr>
			<td class="headertd" width="150">No. HP</td>
			<td class="headertd" width="90">Lantai</td>
			<td class="headertd" width="430">Nama</td>
			<td class="headertd" width="300">Terdaftar Pada</td>
        </tr>
		</table>';

        $data['title'] = 'Daftar Pendaftaran (Individual)';
        $data['table'] = $table;

        $this->load->view('act/act_common_head', $data);
    }

    private function mask_phone($phone)
    {
        $digits = preg_replace('/\D/', '', (string) $phone);
        if ($digits === '') {
            return '-';
        }
        $len = strlen($digits);
        if ($len <= 4) {
            return str_repeat('x', $len);
        }
        return str_repeat('x', $len - 4) . substr($digits, -4);
    }

    private function format_registered_date($value)
    {
        if (empty($value)) {
            return '-';
        }
        $ts = strtotime($value);
        if ($ts === false) {
            return '-';
        }
        return date('d M Y H:i', $ts);
    }

    public function data_printhtml($filename = '', $ex = 0)
    {
        $subperm = ((int) $ex === 1) ? 'export' : 'print';
        if (!$this->guard_menu_access($this->_menuid, $subperm)) {
            return;
        }

        $result = $this->Registration_Model->data_list_print_people(
            $this->input->get('search', true) ?: '',
            $this->input->get('floor', true) ?: '',
            $this->input->get('status', true) ?: '',
            $this->input->get('sort_by', true) ?: 'date',
            $this->input->get('sort_order', true) ?: 'desc'
        );

        if (!$result['success']) {
            show_error($result['message']);
            return;
        }

        $rows = isset($result['data']) ? $result['data'] : [];
        $table = '<table border="0" width="970" class="tablerep">';

        if ($ex == 1) {
            $table .= '
			<tr>
                <td class="headertd" width="150">No. HP</td>
                <td class="headertd" width="90">Lantai</td>
                <td class="headertd" width="430">Nama</td>
                <td class="headertd" width="300">Terdaftar Pada</td>
            </tr>';
        }

        foreach ($rows as $row) {
            $name = htmlspecialchars(strtoupper($row->name), ENT_QUOTES, 'UTF-8');
            $phone = htmlspecialchars($this->mask_phone($row->phone), ENT_QUOTES, 'UTF-8');
            $created_date = htmlspecialchars($this->format_registered_date($row->created_date), ENT_QUOTES, 'UTF-8');

            $table .= "
            <tr valign='top'>
                <td class='text' width='150'>{$phone}</td>
                <td class='text' width='90'>{$row->floor}</td>
                <td class='text' width='430'>{$name}</td>
                <td class='text' width='300'>{$created_date}</td>
            </tr>";
        }

        $table .= '</table>';

        $output['title'] = 'Daftar Pendaftaran (Individual)';
        $output['table'] = $table;
        $output['ex'] = $ex;
        $output['filename'] = $filename;

        $this->load->view('act/common_print', $output);
    }
}
