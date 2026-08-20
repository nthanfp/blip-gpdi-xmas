<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'third_party/phpqrcode/qrlib.php';

class Voucher extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('session');

        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('LogAdmin_Model');
        $this->load->model('Voucher_Model');

        $current_method = $this->router->fetch_method();
        $public_methods = ['api_qr_list'];

        if (
            !in_array($current_method, $public_methods) &&
            !$this->Auth_Model->current_user()
        ) {
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
            'set_menuid' => 107,
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
        if (!$this->guard_menu_access(107, 'view')) {
            return;
        }

        $this->load->view('activities/voucher');
    }

    public function data_list()
    {
        if (!$this->guard_menu_access(107, 'view')) {
            return;
        }

        $page = $this->input->post('page', true) ?: $this->input->get('page', true) ?: 1;
        $per_page = $this->input->post('per_page', true) ?: $this->input->get('per_page', true) ?: 10;
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';
        $mst_itemgiftid = $this->input->post('mst_itemgiftid', true) ?: $this->input->get('mst_itemgiftid', true) ?: '';
        $itemgift_type = $this->input->post('itemgift_type', true) ?: $this->input->get('itemgift_type', true) ?: '';
        $status = $this->input->post('status', true);
        if ($status === null) {
            $status = $this->input->get('status', true);
        }
        $bulk_code = $this->input->post('bulk_code', true) ?: $this->input->get('bulk_code', true) ?: '';
        $bulk_seq = $this->input->post('bulk_seq', true) ?: $this->input->get('bulk_seq', true) ?: '';
        $sort_by = $this->input->post('sort_by', true) ?: $this->input->get('sort_by', true) ?: 'username';
        $sort_dir = $this->input->post('sort_dir', true) ?: $this->input->get('sort_dir', true) ?: 'ASC';

        $result = $this->Voucher_Model->data_list($page, $per_page, $search, $mst_itemgiftid, $itemgift_type, $status, $sort_by, $sort_dir, $bulk_code, $bulk_seq);
        $response = [
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => $result['data'],
            'pagination' => $result['pagination']
        ];
        $this->respond($response);
    }

    public function data_option_itemgift()
    {
        if (!$this->guard_menu_access(107, 'view')) {
            return;
        }

        $result = $this->Voucher_Model->data_option_itemgift();
        $this->respond($result);
    }

    public function data_option_bulk_code()
    {
        if (!$this->guard_menu_access(107, 'view')) {
            return;
        }

        $result = $this->Voucher_Model->data_option_bulk_code();
        $this->respond($result);
    }

    public function data_bulk_new()
    {
        if (!$this->guard_menu_access(107, 'new')) {
            return;
        }

        $payload = $this->input->raw_input_stream;
        $input = json_decode($payload, true);

        if (!is_array($input)) {
            $pos = strrpos($payload, '}');
            if ($pos !== false) {
                $json = substr($payload, 0, $pos + 1);
                $input = json_decode($json, true);
            }
        }

        if (!is_array($input)) {
            $input = [
                'bulk_prefix' => $this->input->post('bulk_prefix', true),
                'status' => $this->input->post('status', true),
                'expired_date' => $this->input->post('expired_date', true),
                'items' => $this->input->post('items', true)
            ];

            if (is_string($input['items'])) {
                $decoded = json_decode($input['items'], true);
                if (is_array($decoded)) {
                    $input['items'] = $decoded;
                }
            }
        }

        $items = isset($input['items']) && is_array($input['items']) ? $input['items'] : [];

        if (empty($items)) {
            $this->respond([
                'success' => false,
                'message' => 'Bulk item list is required'
            ]);
            return;
        }

        if (count($items) > 100) {
            $this->respond([
                'success' => false,
                'message' => 'Maximum 100 items per bulk creation'
            ]);
            return;
        }

        $seen_itemgiftids = [];
        foreach ($items as $i => $item) {
            $itemgiftid = isset($item['mst_itemgiftid']) ? trim((string) $item['mst_itemgiftid']) : '';
            $qty = isset($item['qty']) ? (int) $item['qty'] : 0;

            if ($itemgiftid === '') {
                $this->respond([
                    'success' => false,
                    'message' => 'Item gift is required for row ' . ($i + 1)
                ]);
                return;
            }

            if ($qty < 1) {
                $this->respond([
                    'success' => false,
                    'message' => 'Quantity must be at least 1 for row ' . ($i + 1)
                ]);
                return;
            }

            if ($qty > 100000) {
                $this->respond([
                    'success' => false,
                    'message' => 'Maximum quantity per item is 100000 for row ' . ($i + 1)
                ]);
                return;
            }

            if (in_array($itemgiftid, $seen_itemgiftids)) {
                $this->respond([
                    'success' => false,
                    'message' => 'Duplicate item gift found in row ' . ($i + 1)
                ]);
                return;
            }

            $seen_itemgiftids[] = $itemgiftid;
        }

        $result = $this->Voucher_Model->data_bulk_new($input);
        if (!empty($result['success'])) {
            $this->log_activity('NEW', 'Create voucher BULK');
        }
        $this->respond($result);
    }

    public function data_new()
    {
        if (!$this->guard_menu_access(107, 'new')) {
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->Voucher_Model->rules('create'));

        if ($this->form_validation->run() == FALSE) {
            $this->respond([
                'success' => false,
                'message' => validation_errors()
            ]);
            return;
        }

        $input = [
            'mst_itemgiftid' => $this->input->post('mst_itemgiftid', true),
            'voucher_code' => $this->input->post('voucher_code', true),
            'status' => $this->input->post('status', true),
            'expired_date' => $this->input->post('expired_date', true),
            'redeemed_date' => $this->input->post('redeemed_date', true)
        ];

        $result = $this->Voucher_Model->data_new($input);
        if (!empty($result['success'])) {
            $this->log_activity('NEW', 'Create voucher ' . ($input['voucher_code'] ?? ''));
        }
        $this->respond($result);
    }

    public function data_edit()
    {
        if (!$this->guard_menu_access(107, 'view')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond([
                'success' => false,
                'message' => 'Voucher ID is required'
            ]);
            return;
        }

        $result = $this->Voucher_Model->data_edit($id);
        $response = [
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => isset($result['data']) ? $result['data'] : null
        ];
        $this->respond($response);
    }

    public function data_update()
    {
        if (!$this->guard_menu_access(107, 'update')) {
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->Voucher_Model->rules('update'));

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
                'message' => 'Voucher ID is required'
            ]);
            return;
        }

        $input = [
            'mst_itemgiftid' => $this->input->post('mst_itemgiftid', true),
            'voucher_code' => $this->input->post('voucher_code', true),
            'status' => $this->input->post('status', true),
            'expired_date' => $this->input->post('expired_date', true),
            'redeemed_date' => $this->input->post('redeemed_date', true)
        ];

        $result = $this->Voucher_Model->data_update($id, $input);
        if (!empty($result['success'])) {
            $this->log_activity('EDIT', 'Update voucher ' . $id);
        }
        $this->respond($result);
    }

    public function data_delete()
    {
        if (!$this->guard_menu_access(107, 'delete')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond([
                'success' => false,
                'message' => 'Voucher ID is required'
            ]);
            return;
        }

        $result = $this->Voucher_Model->data_delete($id);
        if (!empty($result['success'])) {
            $this->log_activity('DELETE', 'Delete voucher ' . $id);
        }
        $this->respond($result);
    }

    public function data_print()
    {
        if (!$this->guard_menu_access(107, 'print')) {
            return;
        }

        $search = $this->input->get('search', true);
        if ($search === null) {
            $search = '';
        }

        $mst_itemgiftid = $this->input->get('mst_itemgiftid', true);
        if ($mst_itemgiftid === null) {
            $mst_itemgiftid = '';
        }

        $status = $this->input->get('status', true);
        if ($status === null) {
            $status = '';
        }

        $bulk_code = $this->input->get('bulk_code', true);
        if ($bulk_code === null) {
            $bulk_code = '';
        }

        $bulk_seq = $this->input->get('bulk_seq', true);
        if ($bulk_seq === null) {
            $bulk_seq = '';
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
        if ($mst_itemgiftid !== '') {
            $params[] = '$mst_itemgiftid=' . urlencode($mst_itemgiftid);
        }
        if ($status !== '') {
            $params[] = 'status=' . urlencode($status);
        }
        if ($bulk_code !== '') {
            $params[] = 'bulk_code=' . urlencode($bulk_code);
        }
        if ($bulk_seq !== '') {
            $params[] = 'bulk_seq=' . urlencode($bulk_seq);
        }
        if ($sort_by !== '') {
            $params[] = 'sort_by=' . urlencode($sort_by);
        }
        if ($sort_dir !== '') {
            $params[] = 'sort_dir=' . urlencode($sort_dir);
        }

        $query_string = !empty($params) ? implode('&', $params) : '';

        $pages = site_url('activities/voucher/data_printhtml' . (!empty($query_string) ? '?' . $query_string : ''));
        $head = site_url('activities/voucher/data_printhead');
        $current_user = $this->Auth_Model->current_user();
        $username = $current_user ? $current_user->username : 'Unknown';

        topdf($pages, $head, 20, 0, 0, 0, $username);
    }

    public function data_printhead()
    {
        if (!$this->guard_menu_access(107, 'print')) {
            return;
        }

        $table = '<table border="0" width="970" class="tablerep">
        <tr>
			<td class="headertd" width="300">Voucher Code</td>
            <td class="headertd" width="300">Item Gift</td>
            <td class="headertd" width="200">Status</td>
        </tr>
		</table>';

        $data['title'] = 'Voucher';
        $data['table'] = $table;

        $this->load->view('act/act_common_head', $data);
    }

    public function data_printhtml($filename = '', $ex = 0, $withQR = 0, $withKey = 1)
    {
        $subperm = ((int) $ex === 1) ? 'export' : 'print';
        if (!$this->guard_menu_access(107, $subperm)) {
            return;
        }

        $search = $this->input->get('search', true);
        if ($search === null) {
            $search = '';
        }

        $mst_itemgiftid = $this->input->get('mst_itemgiftid', true);
        if ($mst_itemgiftid === null) {
            $mst_itemgiftid = '';
        }

        $itemgift_type = $this->input->get('itemgift_type', true);
        if ($itemgift_type === null) {
            $itemgift_type = '';
        }

        $status = $this->input->get('status', true);
        if ($status === null) {
            $status = '';
        }

        $bulk_code = $this->input->get('bulk_code', true);
        if ($bulk_code === null) {
            $bulk_code = '';
        }

        $bulk_seq = $this->input->get('bulk_seq', true);
        if ($bulk_seq === null) {
            $bulk_seq = '';
        }

        $sort_by = $this->input->get('sort_by', true);
        if ($sort_by === null || $sort_by === '') {
            $sort_by = 'mst_adminid';
        }

        $sort_dir = $this->input->get('sort_dir', true);
        if ($sort_dir === null || $sort_dir === '') {
            $sort_dir = 'DESC';
        }

        $result = $this->Voucher_Model->data_list_print($search, $mst_itemgiftid, $itemgift_type, $status, $sort_by, $sort_dir, $bulk_code, $bulk_seq);
        if (!$result['success']) {
            show_error($result['message']);
            return;
        }

        $rows = isset($result['data']) ? $result['data'] : [];
        $table = '<table border="0" width="970" class="tablerep">';

        if ($ex == 1) {
            $table .= '
            <tr>
                <td class="headertd" width="450">Voucher Code</td>
                <td class="headertd" width="350">Item Gift</td>
                <td class="headertd" width="100">Status</td>';
                if ($withKey == 1) {
                $table .= '<td class="headertd" width="250">Key</td>';
                }
                if ($withQR == 1) {
                $table .= '<td class="headertd" width="120">QR Code</td>';
                }
            $table .= '
            </tr>';
        }

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

            $voucher_url = site_url('landing/' . $row->voucher_key);
            $qr_dir = FCPATH . 'assets/qrcode/';
            if (!is_dir($qr_dir)) {
                mkdir($qr_dir, 0755, true);
            }

            $qr_url = '';
            if ($withQR == 1) {
                $qr_file = 'voucher_' . $row->mst_voucherid . '.png';
                $qr_path = $qr_dir . $qr_file;
                if (!file_exists($qr_path)) {
                    QRcode::png($voucher_url, $qr_path, QR_ECLEVEL_L, 4, 1);
                }

                $qr_url = base_url('assets/qrcode/' . $qr_file);
            }

            if ($ex == 1) {
                $voucher_url = site_url('/landing/' . $row->voucher_key);
                $table .= "
                <tr valign='top'>
                    <td class='text' width='450'>{$row->voucher_code}</td>
                    <td class='text' width='350'>{$row->itemname}</td>
                    <td class='text' width='100'>{$status_label}</td>";
                if ($withKey == 1) {
                    $table .= "<td class='text' width='250'>{$row->voucher_key}</td>";
                }
                if ($withQR == 1) {
                    $table .= "
                    <td class='text' width='120' style='height:95px; vertical-align:middle;'>
                        <img src='{$qr_url}' width='90' height='90'>
                    </td>";
                }
                $table .= '
                </tr>';
            } else {
                $table .= "
                <tr valign='top'>
                    <td class='text' width='300'>{$row->voucher_code}</td>
                    <td class='text' width='300'>{$row->itemname}</td>
                    <td class='text' width='200'>{$status_label}</td>
                </tr>";
            }
        }

        $table .= "</table>";

        $output['title'] = 'Voucher';
        $output['table'] = $table;
        $output['ex'] = $ex;
        $output['filename'] = $filename;

        if ($ex == 1) {
            $this->log_activity('EXPORT', 'Export voucher report');
        }

        $this->load->view('act/common_print', $output);
    }

    public function download_qr_zip()
    {
        if (!$this->guard_menu_access(107, 'print')) {
            return;
        }

        ini_set('memory_limit', '1024M');

        set_time_limit(0);

        ignore_user_abort(true);

        $search = $this->input->get('search', true) ?: '';
        $mst_itemgiftid = $this->input->get('mst_itemgiftid', true) ?: '';
        $itemgift_type = $this->input->get('itemgift_type', true) ?: '';
        $status = $this->input->get('status', true) ?: '';
        $bulk_code = $this->input->get('bulk_code', true) ?: '';
        $bulk_seq = $this->input->get('bulk_seq', true) ?: '';

        $result = $this->Voucher_Model->data_list_print($search, $mst_itemgiftid, $itemgift_type, $status, 'mst_voucherid', 'DESC', $bulk_code, $bulk_seq);
        if (!$result['success']) {
            show_error($result['message']);
            return;
        }

        $rows = isset($result['data']) ? $result['data'] : [];
        if (empty($rows)) {
            show_error('No voucher data found');
            return;
        }

        $qr_dir = FCPATH . 'assets/qrcode/';
        if (!is_dir($qr_dir)) {
            mkdir($qr_dir, 0755, true);
        }

        $zip_dir = FCPATH . 'assets/temp_zip/';
        if (!is_dir($zip_dir)) {
            mkdir($zip_dir, 0755, true);
        }

        $zip_name = 'voucher_qr_' . date('Ymd_His') . '.zip';
        $zip_path = $zip_dir . $zip_name;
        if (file_exists($zip_path)) {
            @unlink($zip_path);
        }

        $zip = new ZipArchive();
        if ($zip->open($zip_path, ZipArchive::CREATE) !== TRUE) {
            show_error('Failed to create ZIP');
            return;
        }

        foreach ($rows as $row) {
            $voucher_url = site_url('landing/' . $row->voucher_key);
            $qr_filename = 'QR_' . $row->voucher_code . '.png';
            $qr_filepath = $qr_dir . $qr_filename;
            if (!file_exists($qr_filepath)) {
                QRcode::png($voucher_url, $qr_filepath, QR_ECLEVEL_L, 8, 1);
            }

            if (file_exists($qr_filepath)) {
                $item_folder = preg_replace('/[^A-Za-z0-9_\- ]/', '', $row->itemname);
                $item_folder = trim($item_folder);

                if ($item_folder === '') {
                    $item_folder = 'UNKNOWN_ITEM';
                }

                $zip_internal_path = $item_folder . '/' . $qr_filename;

                $zip->addFile($qr_filepath, $zip_internal_path);
                $zip->setCompressionName($qr_filename, ZipArchive::CM_STORE);
            }
        }

        $zip->close();

        if (!file_exists($zip_path)) {
            show_error('ZIP not found');
            return;
        }

        while (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $zip_name . '"');
        header('Content-Length: ' . filesize($zip_path));
        header('Pragma: public');
        header('Cache-Control: must-revalidate');

        readfile($zip_path);

        @unlink($zip_path);

        exit;
    }

    public function api_qr_list()
    {
        $api_key = 'itg-qr-api-2026-jaya-jaya-jaya';
        $request_key = $this->input->get('key', true) ?: '';
        if ($request_key !== $api_key) {
            return $this->respond([
                'success' => false,
                'message' => 'Invalid API key'
            ]);
        }

        $search = $this->input->get('search', true) ?: '';
        $mst_itemgiftid = $this->input->get('mst_itemgiftid', true) ?: '';
        $itemgift_type = $this->input->get('itemgift_type', true) ?: '';
        $status = $this->input->get('status', true) ?: '';
        $bulk_code = $this->input->get('bulk_code', true) ?: '';
        $bulk_seq = $this->input->get('bulk_seq', true) ?: '';

        $result = $this->Voucher_Model->data_list_print($search, $mst_itemgiftid, $itemgift_type, $status, 'mst_voucherid', 'DESC', $bulk_code, $bulk_seq);
        if (!$result['success']) {
            return $this->respond([
                'success' => false,
                'message' => $result['message'],
                'data' => []
            ]);
        }

        $rows = isset($result['data']) ? $result['data'] : [];
        $output = [];

        foreach ($rows as $row) {
            $output[] = [
                'id' => (int) $row->mst_voucherid,
                'bulk_code' => $row->bulk_code,
                'bulk_seq' => (int) $row->bulk_seq,
                'itemgift_name' => (string) $row->itemname,
                'voucher_link' => site_url(
                    'landing/' . $row->voucher_key
                )
            ];
        }

        return $this->respond([
            'success' => true,
            'total' => count($output),
            'data' => $output
        ]);
    }

    public function data_bulk_list()
    {
        if (!$this->guard_menu_access(107, 'new')) {
            return;
        }

        $result = $this->Voucher_Model->data_bulk_list();
        foreach ($result as &$row) {
            $row->bulk_count = (int) $row->bulk_count;
            if (!empty($row->bulk_created_date)) {
                $row->bulk_created_date = date(
                    'd M Y H:i',
                    strtotime($row->bulk_created_date)
                );
            }
        }
        unset($row);

        if (count($result) > 0) {
            $this->respond([
                'success' => true,
                'message' => 'Bulk list load successfully',
                'data' => $result
            ]);
        } else {
            $this->respond([
                'success' => false,
                'message' => validation_errors()
            ]);
        }
    }
}
