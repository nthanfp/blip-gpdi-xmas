<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setmenu extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');

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
        if (!$this->guard_menu_access(102, 'view')) {
            return;
        }

        $this->load->view('activities/setmenu');
    }

    public function data_list()
    {
        if (!$this->guard_menu_access(102, 'view')) {
            return;
        }

        $page = $this->input->post('page', true) ?: $this->input->get('page', true) ?: 1;
        $per_page = $this->input->post('per_page', true) ?: $this->input->get('per_page', true) ?: 10;
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';
        $parent_set_menuid = $this->input->post('parent_set_menuid', true) ?: $this->input->get('parent_set_menuid', true) ?: '';
        $suspended = $this->input->post('suspended', true);
        if ($suspended === null) {
            $suspended = $this->input->get('suspended', true);
        }

        $result = $this->Setmenu_Model->data_list($page, $per_page, $search, $parent_set_menuid, $suspended);
        $response = [
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => $result['data'],
            'pagination' => $result['pagination']
        ];
        $this->respond($response);
    }

    public function data_new()
    {
        if (!$this->guard_menu_access(102, 'new')) {
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->Setmenu_Model->rules('create'));

        if ($this->form_validation->run() == FALSE) {
            $this->respond([
                'success' => false,
                'message' => validation_errors()
            ]);
            return;
        }

        $input = [
            'name' => $this->input->post('name', true),
            'path' => $this->input->post('path', true),
            'order' => $this->input->post('order', true),
            'icon' => $this->input->post('icon', true),
            'parent_set_menuid' => $this->input->post('parent_set_menuid', true),
            'suspended' => $this->input->post('suspended', true)
        ];

        $result = $this->Setmenu_Model->data_new($input);
        $this->respond($result);
    }

    public function data_edit()
    {
        if (!$this->guard_menu_access(102, 'view')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond([
                'success' => false,
                'message' => 'Menu ID is required'
            ]);
            return;
        }

        $result = $this->Setmenu_Model->data_edit($id);
        $response = [
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => isset($result['data']) ? $result['data'] : null
        ];
        $this->respond($response);
    }

    public function data_update()
    {
        if (!$this->guard_menu_access(102, 'update')) {
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->Setmenu_Model->rules('update'));

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
                'message' => 'Menu ID is required'
            ]);
            return;
        }

        $input = [
            'name' => $this->input->post('name', true),
            'path' => $this->input->post('path', true),
            'order' => $this->input->post('order', true),
            'icon' => $this->input->post('icon', true),
            'parent_set_menuid' => $this->input->post('parent_set_menuid', true),
            'suspended' => $this->input->post('suspended', true)
        ];

        $result = $this->Setmenu_Model->data_update($id, $input);
        $this->respond($result);
    }

    public function data_delete()
    {
        if (!$this->guard_menu_access(102, 'delete')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond([
                'success' => false,
                'message' => 'Menu ID is required'
            ]);
            return;
        }

        $result = $this->Setmenu_Model->data_delete($id);
        $this->respond($result);
    }

    public function data_option_parent(){
        if (!$this->guard_menu_access(102, 'view')) {
            return;
        }

        $result = $this->Setmenu_Model->data_option_parent();
        $this->respond($result);
    }

    public function data_option(){
        if (!$this->guard_menu_access(102, 'view')) {
            return;
        }

        $exclude_set_menuid = $this->input->post('exclude_set_menuid', true);
        if ($exclude_set_menuid === null || $exclude_set_menuid === '') {
            $exclude_set_menuid = $this->input->get('exclude_set_menuid', true);
        }

        $result = $this->Setmenu_Model->data_option($exclude_set_menuid);
        $this->respond($result);
    }

    public function check_menu(){
        if (!$this->guard_menu_access(102, 'view')) {
            return;
        }

        $menuid = $this->input->post('menuid', true);
        if ($menuid === null || $menuid === '') {
            $menuid = $this->input->get('menuid', true);
        }

        $result = $this->Setmenu_Model->check_menu($menuid);
        $this->respond($result);
    }
}
