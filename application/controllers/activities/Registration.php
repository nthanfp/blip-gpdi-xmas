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

        $result = $this->Registration_Model->data_list($page, $per_page, $search, $floor, $status);
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

        if ($id === null || $id === '' || $status === null || $status === '') {
            $this->respond(['success' => false, 'message' => 'ID and status are required']);
            return;
        }

        $this->respond($this->Registration_Model->data_status($id, $status));
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
}
