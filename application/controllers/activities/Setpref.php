<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setpref extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('Setpref_Model');

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
        if (!$this->guard_menu_access(116, 'view')) {
            return;
        }

        $this->load->view('activities/setpref');
    }

    public function data_list()
    {
        if (!$this->guard_menu_access(116, 'view')) {
            return;
        }
        $page = $this->input->post('page', true) ?: $this->input->get('page', true) ?: 1;
        $per_page = $this->input->post('per_page', true) ?: $this->input->get('per_page', true) ?: 10;
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';

        $result = $this->Setpref_Model->data_list($page, $per_page, $search);
        $this->respond([
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => $result['data'],
            'pagination' => $result['pagination']
        ]);
    }

    public function data_new()
    {
        if (!$this->guard_menu_access(116, 'new')) {
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->Setpref_Model->rules('create'));

        if ($this->form_validation->run() == FALSE) {
            $this->respond(['success' => false, 'message' => validation_errors()]);
            return;
        }

        $input = [
            'pref_name' => $this->input->post('pref_name', true),
            'pref_label' => $this->input->post('pref_label', true),
            'pref_value' => $this->input->post('pref_value', true)
        ];

        $result = $this->Setpref_Model->data_new($input);
        $this->respond($result);
    }

    public function data_edit()
    {
        if (!$this->guard_menu_access(116, 'view')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond(['success' => false, 'message' => 'Preference ID is required']);
            return;
        }

        $result = $this->Setpref_Model->data_edit($id);
        $this->respond([
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => isset($result['data']) ? $result['data'] : null
        ]);
    }

    public function data_update()
    {
        if (!$this->guard_menu_access(116, 'update')) {
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->Setpref_Model->rules('update'));

        if ($this->form_validation->run() == FALSE) {
            $this->respond(['success' => false, 'message' => validation_errors()]);
            return;
        }

        $id = $this->input->post('id', true);
        if (!$id) {
            $this->respond(['success' => false, 'message' => 'Preference ID is required']);
            return;
        }

        $input = [
            'pref_name' => $this->input->post('pref_name', true),
            'pref_label' => $this->input->post('pref_label', true),
            'pref_value' => $this->input->post('pref_value', true)
        ];

        $result = $this->Setpref_Model->data_update($id, $input);
        $this->respond($result);
    }

    public function data_delete()
    {
        if (!$this->guard_menu_access(116, 'delete')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond(['success' => false, 'message' => 'Preference ID is required']);
            return;
        }

        $result = $this->Setpref_Model->data_delete($id);
        $this->respond($result);
    }
}
