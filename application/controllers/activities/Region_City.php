<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Region_City extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('RegionCity_Model');
        $this->load->model('RegionProvince_Model');

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
        $this->load->view('activities/region-city');
    }

    public function data_list()
    {
        $page = $this->input->post('page', true) ?: $this->input->get('page', true) ?: 1;
        $per_page = $this->input->post('per_page', true) ?: $this->input->get('per_page', true) ?: 10;
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';
        $sort_by = $this->input->post('sort_by', true) ?: $this->input->get('sort_by', true) ?: 'city_name';
        $sort_dir = $this->input->post('sort_dir', true) ?: $this->input->get('sort_dir', true) ?: 'ASC';
        $provinceid = $this->input->post('provinceid', true) ?: $this->input->get('provinceid', true) ?: '';

        $result = $this->RegionCity_Model->data_list($page, $per_page, $search, $sort_by, $sort_dir, $provinceid);
        $this->respond([
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => $result['data'],
            'pagination' => $result['pagination']
        ]);
    }

    public function data_list_all()
    {
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';
        $result = $this->RegionCity_Model->data_list_all($search);
        $this->respond($result);
    }

    public function data_option()
    {
        $search = $this->input->post('search', true) ?: $this->input->get('search', true) ?: '';
        $result = $this->RegionCity_Model->data_option($search);
        $this->respond($result);
    }

    public function data_province_option()
    {
        $result = $this->RegionProvince_Model->data_option();
        $this->respond($result);
    }

    public function data_new()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->RegionCity_Model->rules());

        if ($this->form_validation->run() == FALSE) {
            $this->respond(['success' => false, 'message' => validation_errors()]);
            return;
        }

        $input = [
            'mst_reg_provinceid' => $this->input->post('mst_reg_provinceid', true),
            'city_name' => $this->input->post('city_name', true),
        ];

        $result = $this->RegionCity_Model->data_new($input);
        $this->respond($result);
    }

    public function data_edit()
    {
        $id = $this->input->post('id', true) ?: $this->input->get('id', true);

        if (!$id) {
            $this->respond(['success' => false, 'message' => 'City ID is required']);
            return;
        }

        $result = $this->RegionCity_Model->data_edit($id);
        $this->respond([
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => isset($result['data']) ? $result['data'] : null
        ]);
    }

    public function data_update()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->RegionCity_Model->rules());

        if ($this->form_validation->run() == FALSE) {
            $this->respond(['success' => false, 'message' => validation_errors()]);
            return;
        }

        $id = $this->input->post('id', true);
        if (!$id) {
            $this->respond(['success' => false, 'message' => 'City ID is required']);
            return;
        }

        $input = [
            'mst_reg_provinceid' => $this->input->post('mst_reg_provinceid', true),
            'city_name' => $this->input->post('city_name', true),
        ];

        $result = $this->RegionCity_Model->data_update($id, $input);
        $this->respond($result);
    }

    public function data_delete()
    {
        $id = $this->input->post('id', true);

        if (!$id) {
            $this->respond(['success' => false, 'message' => 'City ID is required']);
            return;
        }

        $result = $this->RegionCity_Model->data_delete($id);
        $this->respond($result);
    }
}
