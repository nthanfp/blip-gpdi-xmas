<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller
{
    private $_menuid = 135;

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('Booking_Model');
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

    private function guard_menu_access($subperm = null)
    {
        $result = $this->Setmenu_Model->check_menu($this->_menuid, $subperm);

        if (!$result['success'] || !$result['allowed']) {
            show_404();
            return false;
        }

        return true;
    }

    public function index()
    {
        if (!$this->guard_menu_access('view')) {
            return;
        }

        $this->load->view('activities/booking');
    }

    public function data_list()
    {
        if (!$this->guard_menu_access('view')) {
            return;
        }
        $page = $this->input->post('page', true) ?: $this->input->get('page', true) ?: 1;
        $per_page = $this->input->post('per_page', true) ?: $this->input->get('per_page', true) ?: 10;
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';
        $floor = $this->input->post('floor', true) ?: $this->input->get('floor', true) ?: '';

        $result = $this->Booking_Model->data_list($page, $per_page, $search, $floor);
        $this->respond([
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => $result['data'],
            'pagination' => $result['pagination']
        ]);
    }

    public function data_stats()
    {
        if (!$this->guard_menu_access('view')) {
            return;
        }

        $result = $this->Registration_Model->data_stats();
        $this->respond([
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => $result['data']
        ]);
    }

    public function data_new()
    {
        if (!$this->guard_menu_access('new')) {
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->Booking_Model->rules('create'));

        if ($this->form_validation->run() == FALSE) {
            $this->respond(['success' => false, 'message' => validation_errors()]);
            return;
        }

        $input = [
            'name' => $this->input->post('name', true),
            'phone' => $this->input->post('phone', true),
            'floor' => $this->input->post('floor', true),
            'seats' => $this->input->post('seats', true),
            'keterangan' => $this->input->post('keterangan', true),
            'status' => $this->input->post('status', true)
        ];

        $result = $this->Booking_Model->data_new($input);
        $this->respond($result);
    }

    public function data_edit()
    {
        if (!$this->guard_menu_access('view')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond(['success' => false, 'message' => 'Booking ID is required']);
            return;
        }

        $result = $this->Booking_Model->data_edit($id);
        $this->respond([
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => isset($result['data']) ? $result['data'] : null
        ]);
    }

    public function data_update()
    {
        if (!$this->guard_menu_access('update')) {
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->Booking_Model->rules('update'));

        if ($this->form_validation->run() == FALSE) {
            $this->respond(['success' => false, 'message' => validation_errors()]);
            return;
        }

        $id = $this->input->post('id', true);
        if (!$id) {
            $this->respond(['success' => false, 'message' => 'Booking ID is required']);
            return;
        }

        $input = [
            'name' => $this->input->post('name', true),
            'phone' => $this->input->post('phone', true),
            'floor' => $this->input->post('floor', true),
            'seats' => $this->input->post('seats', true),
            'keterangan' => $this->input->post('keterangan', true),
            'status' => $this->input->post('status', true)
        ];

        $result = $this->Booking_Model->data_update($id, $input);
        $this->respond($result);
    }

    public function data_delete()
    {
        if (!$this->guard_menu_access('delete')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond(['success' => false, 'message' => 'Booking ID is required']);
            return;
        }

        $result = $this->Booking_Model->data_delete($id);
        $this->respond($result);
    }
}
