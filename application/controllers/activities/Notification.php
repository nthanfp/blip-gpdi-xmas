<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller
{
    private $_current_admin_id = null;

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('Notification_Model');
        $this->load->model('Setpref_Model');

        if (!$this->Auth_Model->current_user()) {
            redirect(site_url('activities/authentication/login'));
            exit;
        }

        $current_user = $this->Auth_Model->current_user();
        $this->_current_admin_id = $current_user ? (int) $current_user->mst_adminid : null;
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

    public function check()
    {
        $enabled = $this->Setpref_Model->get_pref('push_notification_enabled') === '1';
        $count = 0;
        $items = [];

        if ($enabled) {
            $count = $this->Notification_Model->data_unread_count($this->_current_admin_id);
            $items = $this->Notification_Model->data_recent(10, $this->_current_admin_id);
        }

        $this->respond([
            'success' => true,
            'data' => [
                'enabled' => $enabled,
                'count' => $count,
                'items' => $items
            ]
        ]);
    }

    public function mark_read()
    {
        $id = $this->input->post('id', true);
        if (!$id) {
            $this->respond(['success' => false, 'message' => 'Notification ID is required']);
            return;
        }

        $this->Notification_Model->data_mark_read($id, $this->_current_admin_id);
        $this->respond(['success' => true]);
    }

    public function mark_all_read()
    {
        $this->Notification_Model->data_mark_all_read($this->_current_admin_id);
        $this->respond(['success' => true]);
    }

    public function save_token()
    {
        $token = $this->input->post('token', true);
        if (!$token) {
            $this->respond(['success' => false, 'message' => 'FCM token is required']);
            return;
        }

        $current_user = $this->Auth_Model->current_user();
        if (!$current_user || !isset($current_user->mst_adminid)) {
            $this->respond(['success' => false, 'message' => 'User not found']);
            return;
        }

        $this->Notification_Model->save_token($current_user->mst_adminid, $token);
        $this->respond(['success' => true]);
    }

    public function remove_token()
    {
        $token = $this->input->post('token', true);
        if (!$token) {
            $this->respond(['success' => false, 'message' => 'FCM token is required']);
            return;
        }

        $this->Notification_Model->remove_token($token);
        $this->respond(['success' => true]);
    }

    public function test_push()
    {
        if (!$this->guard_menu_access(118, 'new')) {
            return;
        }

        $current_user = $this->Auth_Model->current_user();
        $username = $current_user->mst_username ?? $current_user->username ?? 'Admin';

        $result = $this->Notification_Model->send_push(
            'Test Notification',
            'Halo ' . strtoupper($username) . ', ini notifikasi percobaan dari INTERNAL QR TAG Admin',
            'index.php/activities/redeem'
        );

        if ($result['success']) {
            $this->respond(['success' => true, 'message' => $result['message']]);
        } else {
            $this->respond(['success' => false, 'message' => $result['message']]);
        }
    }

    public function push()
    {
        if (!$this->guard_menu_access(118, 'view')) {
            return;
        }

        $this->load->view('activities/notification/push');
    }

    public function send_custom()
    {
        if (!$this->guard_menu_access(118, 'new')) {
            return;
        }
        $title = $this->input->post('title', true);
        $body = $this->input->post('body', true);
        $click_url = $this->input->post('click_url', true);

        if (!$title || !$body) {
            $this->respond(['success' => false, 'message' => 'Title and body are required']);
            return;
        }

        if (empty($click_url)) {
            $click_url = 'index.php/activities/redeem';
        }

        $result = $this->Notification_Model->send_push($title, $body, $click_url);

        if ($result['success']) {
            $this->respond(['success' => true, 'message' => $result['message']]);
        } else {
            $this->respond(['success' => false, 'message' => $result['message']]);
        }
    }
}
