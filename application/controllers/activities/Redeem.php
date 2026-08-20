<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Redeem extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('LogAdmin_Model');
        $this->load->model('Redeem_Model');

        if (!$this->Auth_Model->current_user()) {
            redirect(site_url('activities/authentication/login'));
            exit;
        }
    }

    private function respond(array $response)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
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
            'set_menuid' => 113,
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
        if (!$this->guard_menu_access(113, 'view')) {
            return;
        }
        $this->load->view('activities/redeem');
    }

    public function data_list()
    {
        if (!$this->guard_menu_access(113, 'view')) {
            return;
        }

        $page = $this->input->post('page', true) ?: $this->input->get('page', true) ?: 1;
        $per_page = $this->input->post('per_page', true) ?: $this->input->get('per_page', true) ?: 10;
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';
        $mst_customerid = $this->input->post('mst_customerid', true) ?: $this->input->get('mst_customerid', true) ?: '';
        $voucher_search = $this->input->post('voucher_search', true) ?: $this->input->get('voucher_search', true) ?: '';
        $status = $this->input->post('status', true);
        if ($status === null) {
            $status = $this->input->get('status', true);
        }
        $sort_by = $this->input->post('sort_by', true) ?: $this->input->get('sort_by', true) ?: 'redeemed_date';
        $sort_dir = $this->input->post('sort_dir', true) ?: $this->input->get('sort_dir', true) ?: 'DESC';
        $date_from = $this->input->post('date_from', true) ?: $this->input->get('date_from', true) ?: '';
        $date_to = $this->input->post('date_to', true) ?: $this->input->get('date_to', true) ?: '';
        $itemtype = $this->input->post('itemtype', true) ?: $this->input->get('itemtype', true) ?: '';

        $result = $this->Redeem_Model->data_list($page, $per_page, $search, $mst_customerid, $voucher_search, $status, $sort_by, $sort_dir, $date_from, $date_to, $itemtype);
        $this->respond($result);
    }

    public function data_option_customer()
    {
        if (!$this->guard_menu_access(113, 'view')) {
            return;
        }

        $result = $this->Redeem_Model->data_option_customer();
        $this->respond($result);
    }

    public function data_option_voucher()
    {
        if (!$this->guard_menu_access(113, 'view')) {
            return;
        }

        $mst_customerid = $this->input->get('mst_customerid', true);
        if ($mst_customerid === null) {
            $mst_customerid = $this->input->post('mst_customerid', true);
        }

        $result = $this->Redeem_Model->data_option_voucher($mst_customerid);
        $this->respond($result);
    }

    public function data_edit()
    {
        if (!$this->guard_menu_access(113, 'view')) {
            return;
        }

        $id = $this->input->post('id', true);
        if (!$id) {
            $this->respond(['success' => false, 'message' => 'Redeem ID is required']);
            return;
        }
        $result = $this->Redeem_Model->data_edit($id);
        $this->respond($result);
    }

    public function data_information()
    {
        if (!$this->guard_menu_access(113, 'view')) {
            return;
        }

        $id = $this->input->post('id', true);
        if (!$id) {
            $this->respond(['success' => false, 'message' => 'Redeem ID is required']);
            return;
        }

        $result = $this->Redeem_Model->data_information($id);
        $this->respond($result);
    }

    public function data_confirm()
    {
        if (!$this->guard_menu_access(113, 'update')) {
            return;
        }

        $id = $this->input->post('id', true);
        if (!$id) {
            $this->respond(['success' => false, 'message' => 'Redeem ID is required']);
            return;
        }

        $current_user = $this->Auth_Model->current_user();
        if (!$current_user) {
            $this->respond(['success' => false, 'message' => 'Session expired']);
            return;
        }

        $notes = $this->input->post('notes', true);
        if ($notes === null) {
            $notes = '';
        }

        $fileInfo = null;
        if (!empty($_FILES['proof_file']['name'])) {
            $uploadDir = FCPATH . 'uploads/redeem-proof/';
            if (!is_dir($uploadDir)) {
                @mkdir($uploadDir, 0777, true);
            }

            $config = [
                'upload_path' => $uploadDir,
                'allowed_types' => 'jpg|jpeg|png|pdf',
                'max_size' => 2048,
                'encrypt_name' => true,
                'remove_spaces' => true
            ];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('proof_file')) {
                $this->respond(['success' => false, 'message' => strip_tags($this->upload->display_errors())]);
                return;
            }

            $uploadData = $this->upload->data();
            $fileInfo = [
                'filename' => $uploadData['file_name'],
                'filepath' => 'uploads/redeem-proof/' . $uploadData['file_name']
            ];
        }

        $result = $this->Redeem_Model->data_confirm(
            $id,
            $current_user->mst_username ?? $current_user->username ?? '',
            $notes,
            $fileInfo
        );
        if (!empty($result['success'])) {
            $this->log_activity('CONFIRM', 'Confirm redeem ' . $id);
        }
        $this->respond($result);
    }

    public function data_reject()
    {
        if (!$this->guard_menu_access(113, 'update')) {
            return;
        }

        $id = $this->input->post('id', true);
        if (!$id) {
            $this->respond(['success' => false, 'message' => 'Redeem ID is required']);
            return;
        }

        $current_user = $this->Auth_Model->current_user();
        if (!$current_user) {
            $this->respond(['success' => false, 'message' => 'Session expired']);
            return;
        }

        $notes = $this->input->post('notes', true);
        if ($notes === null) {
            $notes = '';
        }

        $result = $this->Redeem_Model->data_reject(
            $id,
            $current_user->mst_username ?? $current_user->username ?? '',
            $notes
        );
        if (!empty($result['success'])) {
            $this->log_activity('REJECT', 'Reject redeem ' . $id);
        }
        $this->respond($result);
    }

    public function data_update()
    {
        if (!$this->guard_menu_access(113, 'update')) {
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->Redeem_Model->rules('update'));

        if ($this->form_validation->run() == FALSE) {
            $this->respond(['success' => false, 'message' => validation_errors()]);
            return;
        }

        $id = $this->input->post('id', true);
        if (!$id) {
            $this->respond(['success' => false, 'message' => 'Redeem ID is required']);
            return;
        }

        $input = [
            'mst_customerid' => $this->input->post('mst_customerid', true),
            'mst_voucherid' => $this->input->post('mst_voucherid', true),
            'description' => $this->input->post('description', true),
            'ip_address' => $this->input->post('ip_address', true),
            'mac_address' => $this->input->post('mac_address', true),
            'geo_lat' => $this->input->post('geo_lat', true),
            'geo_long' => $this->input->post('geo_long', true),
            'redeemed_date' => $this->input->post('redeemed_date', true),
            'confirmed_by' => $this->input->post('confirmed_by', true),
            'confirmed_date' => $this->input->post('confirmed_date', true),
            'completed_by' => $this->input->post('completed_by', true),
            'completed_date' => $this->input->post('completed_date', true)
        ];

        $result = $this->Redeem_Model->data_update($id, $input);
        if (!empty($result['success'])) {
            $this->log_activity('EDIT', 'Update redeem ' . $id);
        }
        $this->respond($result);
    }

    public function data_delete()
    {
        if (!$this->guard_menu_access(113, 'delete')) {
            return;
        }

        $id = $this->input->post('id', true);
        if (!$id) {
            $this->respond(['success' => false, 'message' => 'Redeem ID is required']);
            return;
        }

        $result = $this->Redeem_Model->data_delete($id);
        if (!empty($result['success'])) {
            $this->log_activity('DELETE', 'Delete redeem ' . $id);
        }
        $this->respond($result);
    }

    public function data_print()
    {
        if (!$this->guard_menu_access(113, 'print')) {
            return;
        }

        $search = $this->input->get('search', true);
        if ($search === null) {
            $search = '';
        }

        $voucher_search = $this->input->get('voucher_search', true);
        if ($voucher_search === null) {
            $voucher_search = '';
        }

        $mst_customerid = $this->input->get('mst_customerid', true);
        if ($mst_customerid === null) {
            $mst_customerid = '';
        }

        $status = $this->input->get('status', true);
        if ($status === null) {
            $status = '';
        }

        $sort_by = $this->input->get('sort_by', true);
        if ($sort_by === null || $sort_by === '') {
            $sort_by = 'mst_adminid';
        }

        $sort_dir = $this->input->get('sort_dir', true);
        if ($sort_dir === null || $sort_dir === '') {
            $sort_dir = 'DESC';
        }

        $date_from = $this->input->get('date_from', true) ?: '';
        $date_to = $this->input->get('date_to', true) ?: '';

        $itemtype = $this->input->get('itemtype', true);
        if ($itemtype === null) {
            $itemtype = '';
        }

        $params = [];
        if ($search !== '') {
            $params[] = 'search=' . urlencode($search);
        }
        if ($voucher_search !== '') {
            $params[] = 'voucher_search=' . urlencode($voucher_search);
        }
        if ($mst_customerid !== '') {
            $params[] = 'mst_customerid=' . urlencode($mst_customerid);
        }
        if ($status !== '') {
            $params[] = 'status=' . urlencode($status);
        }
        if ($sort_by !== '') {
            $params[] = 'sort_by=' . urlencode($sort_by);
        }
        if ($sort_dir !== '') {
            $params[] = 'sort_dir=' . urlencode($sort_dir);
        }
        if ($date_from !== '') {
            $params[] = 'date_from=' . urlencode($date_from);
        }
        if ($date_to !== '') {
            $params[] = 'date_to=' . urlencode($date_to);
        }
        if ($itemtype !== '') {
            $params[] = 'itemtype=' . urlencode($itemtype);
        }

        $query_string = !empty($params) ? implode('&', $params) : '';

        $pages = site_url('activities/redeem/data_printhtml' . (!empty($query_string) ? '?' . $query_string : ''));
        $head = site_url('activities/redeem/data_printhead');
        $current_user = $this->Auth_Model->current_user();
        $username = $current_user ? $current_user->username : 'Unknown';

        topdf($pages, $head, 20, 0, 0, 0, $username);
    }

    public function data_printhead()
    {
        if (!$this->guard_menu_access(113, 'print')) {
            return;
        }

        $table = '<table border="0" width="970" class="tablerep">
        <tr>
			<td class="headertd" width="150">Redeemed Date</td>
			<td class="headertd" width="150">Completed Date</td>
            <td class="headertd" width="200">Customer</td>
            <td class="headertd" width="250">Item Gift</td>
            <td class="headertd" width="90">Status</td>
        </tr>
		</table>';

        $data['title'] = 'Redeem';
        $data['table'] = $table;

        $this->load->view('act/act_common_head', $data);
    }

    public function data_printhtml($filename = '', $ex = 0)
    {
        $subperm = ((int) $ex === 1) ? 'export' : 'print';
        if (!$this->guard_menu_access(113, $subperm)) {
            return;
        }

        $search = $this->input->get('search', true);
        if ($search === null) {
            $search = '';
        }

        $voucher_search = $this->input->get('voucher_search', true);
        if ($voucher_search === null) {
            $voucher_search = '';
        }

        $mst_customerid = $this->input->get('mst_customerid', true);
        if ($mst_customerid === null) {
            $mst_customerid = '';
        }

        $status = $this->input->get('status', true);
        if ($status === null) {
            $status = '';
        }

        $sort_by = $this->input->get('sort_by', true);
        if ($sort_by === null || $sort_by === '') {
            $sort_by = 'mst_adminid';
        }

        $sort_dir = $this->input->get('sort_dir', true);
        if ($sort_dir === null || $sort_dir === '') {
            $sort_dir = 'DESC';
        }

        $date_from = $this->input->get('date_from', true) ?: '';
        $date_to = $this->input->get('date_to', true) ?: '';

        $itemtype = $this->input->get('itemtype', true);
        if ($itemtype === null) {
            $itemtype = '';
        }

        $result = $this->Redeem_Model->data_list_print($search, $mst_customerid, $voucher_search, $status, $sort_by, $sort_dir, $date_from, $date_to, $itemtype);
        if (!$result['success']) {
            show_error($result['message']);
            return;
        }

        $rows = isset($result['data']) ? $result['data'] : [];
        $table = '<table border="0" width="970" class="tablerep">';

        if ($ex == 1) {
            $table = $table . '
			<tr>
                <td class="headertd" width="200">Redeemed Date</td>
                <td class="headertd" width="200">Completed Date</td>
                <td class="headertd" width="250">Customer</td>
                <td class="headertd" width="220">Item Gift</td>
                <td class="headertd" width="90">Status</td>
                <td class="headertd" width="100" align="right">Value</td>
            </tr>';
        }

        $total_value = 0;
        foreach ($rows as $row) {
            $status_label = '-';
            switch ($row->status) {
                case 1:
                    $status_label = 'CREATED';
                    break;
                case 2:
                    $status_label = 'PRINTED';
                    break;
                case 3:
                    $status_label = 'REDEEMED';
                    break;
                case 4:
                    $status_label = 'COMPLETED';
                    break;
                case 5:
                    $status_label = 'REJECTED';
                    break;
                default:
                    $status_label = '-';
                    break;
            }

            if ($ex == 1) {
                // $voucher_url = site_url('/landing/' . $row->voucher_key);
                $total_value += $row->value;
                $value = money_to_view($row->value, 'Rp');

                $table .= "
                <tr valign='top'>
                    <td width='200' class='text'>
                        " . date('d M Y H:i:s', strtotime($row->redeemed_date)) . "
                    </td>
                    <td width='200' class='text'>
                        " . (!empty($row->completed_date) ? date('d M Y H:i:s', strtotime($row->completed_date)) : '-') . "
                    </td>
                    <td width='250' class='text'>
                        {$row->custname}
                    </td>
                    <td width='220' class='text'>
                        {$row->itemname}
                    </td>
                    <td width='90' class='text' >
                        {$status_label}
                    </td>
                    <td width='120' class='excel_num' style='border:none;' align='right'>
                        {$value}
                    </td>
                </tr>";
            } else {
                $table .= "
                <tr valign='top'>
                    <td class='text' width='150'>" . date('d M Y H:i:s', strtotime($row->redeemed_date)) . "</td>
                    <td class='text' width='150'>" . (!empty($row->completed_date) ? date('d M Y H:i:s', strtotime($row->completed_date)) : '-') . "</td>
                    <td class='text' width='200'>{$row->custname}</td>
                    <td class='text' width='250'>{$row->itemname}</td>
                    <td class='text' width='90'>{$status_label}</td>
                </tr>";

                // $table = '<table border="0" width="970" class="tablerep">
                // <tr>
                //     <td class="headertd" width="150">Redeemed Date</td>
                //     <td class="headertd" width="150">Completed Date</td>
                //     <td class="headertd" width="250">Item Gift</td>
                //     <td class="headertd" width="250">Code</td>
                //     <td class="headertd" width="90">Status</td>
                // </tr>
                // </table>';
            }
        }

        if ($ex == 1) {
            $table = $table . "
			<tr>
                <td class='foottd' width='200'>Total</td>
                <td class='foottd' width='200'></td>
                <td class='foottd' width='250'></td>
                <td class='foottd' width='220'></td>
                <td class='foottd' width='90'></td>
                <td class='foottd' width='120' align='right'>" . money_to_view($total_value, 'Rp') . "</td>
            </tr>";
        }

        $table .= "</table>";

        $output['title'] = 'Redeem';
        $output['table'] = $table;
        $output['ex'] = $ex;
        $output['filename'] = $filename;

        if ($ex == 1) {
            $this->log_activity('EXPORT', 'Export redeem report');
        }

        $this->load->view('act/common_print', $output);
    }
}
