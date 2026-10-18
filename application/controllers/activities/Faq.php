<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller
{
    private $_menuid = 134;

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('Faq_Model');

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

        $this->load->view('activities/faq');
    }

    public function data_list()
    {
        if (!$this->guard_menu_access('view')) {
            return;
        }
        $page = $this->input->post('page', true) ?: $this->input->get('page', true) ?: 1;
        $per_page = $this->input->post('per_page', true) ?: $this->input->get('per_page', true) ?: 10;
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';

        $result = $this->Faq_Model->data_list($page, $per_page, $search);
        $this->respond([
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => $result['data'],
            'pagination' => $result['pagination']
        ]);
    }

    public function data_new()
    {
        if (!$this->guard_menu_access('new')) {
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->Faq_Model->rules('create'));

        if ($this->form_validation->run() == FALSE) {
            $this->respond(['success' => false, 'message' => validation_errors()]);
            return;
        }

        $input = [
            'question' => $this->input->post('question', true),
            'answer' => $this->input->post('answer', true),
            'sort_order' => $this->input->post('sort_order', true),
            'suspended' => $this->input->post('suspended', true)
        ];

        $result = $this->Faq_Model->data_new($input);
        $this->respond($result);
    }

    public function data_edit()
    {
        if (!$this->guard_menu_access('view')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond(['success' => false, 'message' => 'FAQ ID is required']);
            return;
        }

        $result = $this->Faq_Model->data_edit($id);
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
        $this->form_validation->set_rules($this->Faq_Model->rules('update'));

        if ($this->form_validation->run() == FALSE) {
            $this->respond(['success' => false, 'message' => validation_errors()]);
            return;
        }

        $id = $this->input->post('id', true);
        if (!$id) {
            $this->respond(['success' => false, 'message' => 'FAQ ID is required']);
            return;
        }

        $input = [
            'question' => $this->input->post('question', true),
            'answer' => $this->input->post('answer', true),
            'sort_order' => $this->input->post('sort_order', true),
            'suspended' => $this->input->post('suspended', true)
        ];

        $result = $this->Faq_Model->data_update($id, $input);
        $this->respond($result);
    }

    public function data_delete()
    {
        if (!$this->guard_menu_access('delete')) {
            return;
        }

        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond(['success' => false, 'message' => 'FAQ ID is required']);
            return;
        }

        $result = $this->Faq_Model->data_delete($id);
        $this->respond($result);
    }
}
