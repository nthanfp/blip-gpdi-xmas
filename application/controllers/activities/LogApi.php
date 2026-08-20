<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logapi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('ApiLog_Model');

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
        if (!$this->guard_menu_access(122, 'view')) {
            return;
        }

        $this->load->view('activities/logapi');
    }

    public function data_list()
    {
        if (!$this->guard_menu_access(122, 'view')) {
            return;
        }

        $page = $this->input->post('page', true) ?: $this->input->get('page', true) ?: 1;
        $per_page = $this->input->post('per_page', true) ?: $this->input->get('per_page', true) ?: 10;
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';
        $endpoint = $this->input->post('endpoint', true) ?: $this->input->get('endpoint', true) ?: '';
        $http_status = $this->input->post('http_status', true) ?: $this->input->get('http_status', true) ?: '';
        $is_success = $this->input->post('is_success', true) ?: $this->input->get('is_success', true) ?: '';
        $set_api_keyid = $this->input->post('set_api_keyid', true) ?: $this->input->get('set_api_keyid', true) ?: '';
        $sort_by = $this->input->post('sort_by', true) ?: $this->input->get('sort_by', true) ?: 'created_date';
        $sort_dir = $this->input->post('sort_dir', true) ?: $this->input->get('sort_dir', true) ?: 'DESC';

        $result = $this->ApiLog_Model->data_list($page, $per_page, $search, $endpoint, $http_status, $is_success, $set_api_keyid, $sort_by, $sort_dir);
        $this->respond([
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => $result['data'],
            'pagination' => $result['pagination'],
        ]);
    }

    public function data_option_endpoint()
    {
        if (!$this->guard_menu_access(122, 'view')) {
            return;
        }

        $this->respond($this->ApiLog_Model->data_option_endpoint());
    }

    public function data_option_http_status()
    {
        if (!$this->guard_menu_access(122, 'view')) {
            return;
        }

        $this->respond($this->ApiLog_Model->data_option_http_status());
    }

    public function data_option_success()
    {
        if (!$this->guard_menu_access(122, 'view')) {
            return;
        }

        $this->respond($this->ApiLog_Model->data_option_success());
    }

    public function data_option_api_key()
    {
        if (!$this->guard_menu_access(122, 'view')) {
            return;
        }

        $this->respond($this->ApiLog_Model->data_option_api_key());
    }

    public function data_detail()
    {
        if (!$this->guard_menu_access(122, 'view')) {
            return;
        }

        $id = $this->input->get('id', true);
        if ($id === null) {
            $id = $this->input->post('id', true);
        }

        $id = $this->ApiLog_Model->normalize_id($id);
        if ($id === null) {
            $this->respond([
                'success' => false,
                'message' => 'ID is required',
            ]);
            return;
        }

        $result = $this->ApiLog_Model->data_edit($id);
        $this->respond($result);
    }

    public function data_print()
    {
        if (!$this->guard_menu_access(122, 'print')) {
            return;
        }

        $search = $this->input->get('search', true);
        if ($search === null) $search = '';

        $endpoint = $this->input->get('endpoint', true);
        if ($endpoint === null) $endpoint = '';

        $http_status = $this->input->get('http_status', true);
        if ($http_status === null) $http_status = '';

        $is_success = $this->input->get('is_success', true);
        if ($is_success === null) $is_success = '';

        $sort_by = $this->input->get('sort_by', true);
        if ($sort_by === null || $sort_by === '') $sort_by = 'created_date';

        $sort_dir = $this->input->get('sort_dir', true);
        if ($sort_dir === null || $sort_dir === '') $sort_dir = 'DESC';

        $params = [];
        if ($search !== '') $params[] = 'search=' . urlencode($search);
        if ($endpoint !== '') $params[] = 'endpoint=' . urlencode($endpoint);
        if ($http_status !== '') $params[] = 'http_status=' . urlencode($http_status);
        if ($is_success !== '') $params[] = 'is_success=' . urlencode($is_success);
        if ($sort_by !== '') $params[] = 'sort_by=' . urlencode($sort_by);
        if ($sort_dir !== '') $params[] = 'sort_dir=' . urlencode($sort_dir);

        $query_string = !empty($params) ? implode('&', $params) : '';

        $body = site_url('activities/logapi/data_printhtml' . (!empty($query_string) ? '?' . $query_string : ''));
        $head = site_url('activities/logapi/data_printhead');

        $current_user = $this->Auth_Model->current_user();
        $username = $current_user ? $current_user->username : 'Unknown';
        topdf($body, $head, 20, 0, 0, 0, $username);
    }

    public function data_printhead()
    {
        if (!$this->guard_menu_access(122, 'print')) {
            return;
        }

        $table = '<table border="0" width="970" class="tablerep">
        <tr>
            <td class="headertd" width="80">Method</td>
            <td class="headertd" width="200">Endpoint</td>
            <td class="headertd" width="80">HTTP Code</td>
            <td class="headertd" width="100">IP Address</td>
            <td class="headertd" width="100">Exec Time</td>
            <td class="headertd" width="150">Created Date</td>
            <td class="headertd" width="80">Status</td>
        </tr>
		</table>';

        $data['title'] = 'Log API';
        $data['table'] = $table;

        $this->load->view('act/act_common_head', $data);
    }

    public function data_printhtml($filename = '', $ex = 0)
    {
        $subperm = ((int) $ex === 1) ? 'export' : 'print';
        if (!$this->guard_menu_access(122, $subperm)) {
            return;
        }

        $search = $this->input->get('search', true);
        if ($search === null) $search = '';

        $endpoint = $this->input->get('endpoint', true);
        if ($endpoint === null) $endpoint = '';

        $http_status = $this->input->get('http_status', true);
        if ($http_status === null) $http_status = '';

        $is_success = $this->input->get('is_success', true);
        if ($is_success === null) $is_success = '';

        $sort_by = $this->input->get('sort_by', true);
        if ($sort_by === null || $sort_by === '') $sort_by = 'created_date';

        $sort_dir = $this->input->get('sort_dir', true);
        if ($sort_dir === null || $sort_dir === '') $sort_dir = 'DESC';

        $set_api_keyid = $this->input->get('set_api_keyid', true);
        if ($set_api_keyid === null) $set_api_keyid = '';

        $result = $this->ApiLog_Model->data_list_print($search, $endpoint, $http_status, $is_success, $set_api_keyid, $sort_by, $sort_dir);
        if (!$result['success']) {
            show_error($result['message']);
            return;
        }

        $rows = isset($result['data']) ? $result['data'] : [];
        $table = '<table border="0" width="970" class="tablerep">';

        if ($ex == 1) {
            $table .= '
            <tr>
                <td class="headertd" width="80">Method</td>
                <td class="headertd" width="200">Endpoint</td>
                <td class="headertd" width="80">HTTP Code</td>
                <td class="headertd" width="115">IP Address</td>
                <td class="headertd" width="100">Exec Time</td>
                <td class="headertd" width="150">Created Date</td>
                <td class="headertd" width="80">Status</td>
            </tr>';
        }

        foreach ($rows as $row) {
            $method = !empty($row->request_method) ? $row->request_method : '-';
            $endpoint_val = !empty($row->endpoint) ? $row->endpoint : '-';
            $http = !empty($row->http_status) ? $row->http_status : '-';
            $ip = !empty($row->ip_address) ? $row->ip_address : '-';
            $exec = isset($row->execution_time) ? number_format($row->execution_time / 1000, 4) . ' s' : '-';
            $created = !empty($row->created_date) ? $row->created_date : '-';
            $status = !empty($row->is_success) ? 'Success' : 'Failed';

            if ($ex == 1) {
                $table .= "
                <tr valign='top'>
                    <td class='text' width='80'>{$method}</td>
                    <td class='text' width='200'>{$endpoint_val}</td>
                    <td class='text' width='80'>{$http}</td>
                    <td class='text' width='115'>{$ip}</td>
                    <td class='text' width='100'>{$exec}</td>
                    <td class='text' width='150'>{$created}</td>
                    <td class='text' width='80'>{$status}</td>
                </tr>";
            } else {
                $table .= "
                <tr valign='top'>
                    <td class='text' width='80'>{$method}</td>
                    <td class='text' width='200'>{$endpoint_val}</td>
                    <td class='text' width='80'>{$http}</td>
                    <td class='text' width='100'>{$ip}</td>
                    <td class='text' width='100'>{$exec}</td>
                    <td class='text' width='150'>{$created}</td>
                    <td class='text' width='80'>{$status}</td>
                </tr>";
            }
        }

        $table .= "</table>";

        $output['title'] = 'Log API';
        $output['table'] = $table;
        $output['ex'] = $ex;
        $output['filename'] = $filename;

        $this->load->view('act/common_print', $output);
    }
}
