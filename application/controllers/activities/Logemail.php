<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logemail extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('EmailLog_Model');

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
        if (!$this->guard_menu_access(120, 'view')) {
            return;
        }

        $this->load->view('activities/logemail');
    }

    public function data_list()
    {
        if (!$this->guard_menu_access(120, 'view')) {
            return;
        }

        $page = $this->input->post('page', true) ?: $this->input->get('page', true) ?: 1;
        $per_page = $this->input->post('per_page', true) ?: $this->input->get('per_page', true) ?: 10;
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';
        $email_type = $this->input->post('email_type', true) ?: $this->input->get('email_type', true) ?: '';
        $status = $this->input->post('status', true) ?: $this->input->get('status', true) ?: '';
        $recipient_email = $this->input->post('recipient_email', true) ?: $this->input->get('recipient_email', true) ?: '';
        $sort_by = $this->input->post('sort_by', true) ?: $this->input->get('sort_by', true) ?: 'created_at';
        $sort_dir = $this->input->post('sort_dir', true) ?: $this->input->get('sort_dir', true) ?: 'DESC';

        $result = $this->EmailLog_Model->data_list($page, $per_page, $search, $email_type, $status, $recipient_email, $sort_by, $sort_dir);
        $this->respond([
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => $result['data'],
            'pagination' => $result['pagination']
        ]);
    }

    public function data_option_admin_recipient()
    {
        if (!$this->guard_menu_access(120, 'view')) {
            return;
        }

        $this->respond($this->EmailLog_Model->data_option_admin_recipient());
    }

    public function data_option_type()
    {
        if (!$this->guard_menu_access(120, 'view')) {
            return;
        }

        $this->respond($this->EmailLog_Model->data_option_type());
    }

    public function data_option_status()
    {
        if (!$this->guard_menu_access(120, 'view')) {
            return;
        }

        $this->respond($this->EmailLog_Model->data_option_status());
    }

    public function data_print()
    {
        if (!$this->guard_menu_access(120, 'print')) {
            return;
        }

        $search = $this->input->get('search', true) ?: '';
        $email_type = $this->input->get('email_type', true) ?: '';
        $status = $this->input->get('status', true) ?: '';
        $recipient_email = $this->input->get('recipient_email', true) ?: '';
        $sort_by = $this->input->get('sort_by', true) ?: 'created_at';
        $sort_dir = $this->input->get('sort_dir', true) ?: 'DESC';

        $params = [];
        if ($search !== '') $params[] = 'search=' . urlencode($search);
        if ($email_type !== '') $params[] = 'email_type=' . urlencode($email_type);
        if ($status !== '') $params[] = 'status=' . urlencode($status);
        if ($recipient_email !== '') $params[] = 'recipient_email=' . urlencode($recipient_email);
        if ($sort_by !== '') $params[] = 'sort_by=' . urlencode($sort_by);
        if ($sort_dir !== '') $params[] = 'sort_dir=' . urlencode($sort_dir);

        $query = implode('&', $params);
        $body = site_url('activities/logemail/data_printhtml/print/0') . ($query !== '' ? '?' . $query : '');
        $head = site_url('activities/logemail/data_printhead');

        $username = $this->Auth_Model->current_user()->mst_username ?? $this->Auth_Model->current_user()->username ?? 'Admin';
        topdf($body, $head, 20, 0, 0, 0, $username);
    }

    public function data_printhead()
    {
        if (!$this->guard_menu_access(120, 'print')) {
            return;
        }

        $data = [
            'lebarhead' => 970,
            'title' => 'Log Email'
        ];

        $this->load->view('act/act_common_head', $data);
    }

    public function data_printhtml($filename = '', $ex = 0)
    {
        $subperm = ((int) $ex === 1) ? 'export' : 'print';
        if (!$this->guard_menu_access(120, $subperm)) {
            return;
        }

        $search = $this->input->get('search', true) ?: '';
        $email_type = $this->input->get('email_type', true) ?: '';
        $status = $this->input->get('status', true) ?: '';
        $recipient_email = $this->input->get('recipient_email', true) ?: '';
        $sort_by = $this->input->get('sort_by', true) ?: 'created_at';
        $sort_dir = $this->input->get('sort_dir', true) ?: 'DESC';

        $result = $this->EmailLog_Model->data_list_print($search, $email_type, $status, $recipient_email, $sort_by, $sort_dir);
        if (!$result['success']) {
            show_error($result['message']);
            return;
        }

        $data = [
            'title' => 'Log Email',
            'table' => $this->_build_table($result['data']),
            'ex' => (int) $ex,
            'filename' => $filename ?: 'log_email',
        ];

        $this->load->view('act/common_print', $data);
    }

    private function _build_table(array $rows)
    {
        $html = '<table class="table table-bordered table-sm"><thead><tr>'
            . '<th>Created</th><th>Type</th><th>Recipient</th><th>Subject</th><th>Status</th><th>Error</th><th>Redeem ID</th>'
            . '</tr></thead><tbody>';

        foreach ($rows as $row) {
            $status = htmlspecialchars((string) ($row->status ?? ''), ENT_QUOTES, 'UTF-8');
            $badge = $status === 'sent' ? 'success' : 'danger';
            $html .= '<tr>'
                . '<td>' . htmlspecialchars((string) ($row->created_at ?? '-'), ENT_QUOTES, 'UTF-8') . '</td>'
                . '<td>' . htmlspecialchars((string) ($row->email_type ?? '-'), ENT_QUOTES, 'UTF-8') . '</td>'
                . '<td>' . htmlspecialchars((string) ($row->recipient_email ?? '-'), ENT_QUOTES, 'UTF-8') . '</td>'
                . '<td>' . htmlspecialchars((string) ($row->subject ?? '-'), ENT_QUOTES, 'UTF-8') . '</td>'
                . '<td><span class="badge badge-' . $badge . '">' . $status . '</span></td>'
                . '<td>' . htmlspecialchars((string) ($row->error_message ?? '-'), ENT_QUOTES, 'UTF-8') . '</td>'
                . '<td>' . htmlspecialchars((string) ($row->related_redeemid ?? '-'), ENT_QUOTES, 'UTF-8') . '</td>'
                . '</tr>';
        }

        $html .= '</tbody></table>';
        return $html;
    }
}