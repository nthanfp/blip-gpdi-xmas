<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fcmtoken extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('Notification_Model');

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
        if (!$this->guard_menu_access(119, 'view')) {
            return;
        }

        $this->load->view('activities/fcmtoken');
    }

    public function data_list()
    {
        if (!$this->guard_menu_access(119, 'view')) {
            return;
        }

        $page = $this->input->post('page', true) ?: $this->input->get('page', true) ?: 1;
        $per_page = $this->input->post('per_page', true) ?: $this->input->get('per_page', true) ?: 10;
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';

        $result = $this->Notification_Model->data_list($page, $per_page, $search);
        $this->respond([
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => $result['data'],
            'pagination' => $result['pagination']
        ]);
    }

    public function data_delete()
    {
        if (!$this->guard_menu_access(119, 'delete')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond(['success' => false, 'message' => 'Token ID is required']);
            return;
        }

        $result = $this->Notification_Model->data_delete_token($id);
        $this->respond($result);
    }
}
