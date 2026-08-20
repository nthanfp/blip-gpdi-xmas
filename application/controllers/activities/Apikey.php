<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Apikey extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('ApiKey_Model');

        if (!$this->Auth_Model->current_user()) {
            redirect(site_url('activities/authentication/login'));
            exit;
        }
    }

    public function respond(array $response)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function guard_menu_access($menuid, $subperm = null)
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
        if (!$this->guard_menu_access(111, 'view')) {
            return;
        }

        $this->load->view('activities/apikey');
    }

    public function data_list()
    {
        if (!$this->guard_menu_access(123, 'view')) {
            return;
        }

        $page = $this->input->post('page', true) ?: $this->input->get('page', true) ?: 1;
        $per_page = $this->input->post('per_page', true) ?: $this->input->get('per_page', true) ?: 10;
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';
        $is_active = $this->input->post('is_active', true) ?: $this->input->get('is_active', true) ?: '';
        $sort_by = $this->input->post('sort_by', true) ?: $this->input->get('sort_by', true) ?: 'created_date';
        $sort_dir = $this->input->post('sort_dir', true) ?: $this->input->get('sort_dir', true) ?: 'DESC';

        $result = $this->ApiKey_Model->data_list($page, $per_page, $search, $is_active, $sort_by, $sort_dir);
        $this->respond([
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => $result['data'],
            'pagination' => $result['pagination']
        ]);
    }

    public function data_create()
    {
        if (!$this->guard_menu_access(123, 'view')) {
            return;
        }

        $key_name = $this->input->post('key_name', true) ?: $this->input->get('key_name', true) ?: '';
        $notes = $this->input->post('notes', true) ?: $this->input->get('notes', true) ?: '';

        $result = $this->ApiKey_Model->data_new([
            'key_name' => $key_name,
            'notes' => $notes
        ]);

        $this->respond($result);
    }

    public function data_detail()
    {
        if (!$this->guard_menu_access(123, 'view')) {
            return;
        }

        $id = $this->input->get('id', true);
        if ($id === null) {
            $id = $this->input->post('id', true);
        }

        $id = $this->ApiKey_Model->normalize_id($id);
        if ($id === null) {
            return [
                'success' => false,
                'message' => 'ID is required',
            ];
        }

        $this->respond($this->ApiKey_Model->data_edit($id));
    }

    public function data_update()
    {
        if (!$this->guard_menu_access(123, 'view')) {
            return;
        }

        $id = $this->input->get('id', true) ?: $this->input->get('id', true) ?: '';
        $input = [
            'key_name' => $this->input->post('key_name', true),
            'notes' => $this->input->post('notes', true),
            'is_active' => $this->input->post('is_active', true),
        ];

        $input = array_filter($input, function ($v) {
            return $v !== null;
        });

        $this->respond($this->ApiKey_Model->data_update($id, $input));
    }

    public function data_delete()
    {
        if (!$this->guard_menu_access(123, 'view')) {
            return;
        }

        $id = $this->input->get('id', true) ?: $this->input->get('id', true) ?: '';
        $this->respond($this->ApiKey_Model->data_delete($id));
    }

    public function data_regenerate()
    {
        if (!$this->guard_menu_access(123, 'view')) {
            return;
        }

        $id = $this->input->get('id', true) ?: $this->input->get('id', true) ?: '';
        $this->respond($this->ApiKey_Model->data_regenerate_key($id));
    }
}
