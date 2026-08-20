<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Region extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Region_Model');

        // if (!$this->Auth_Model->current_user()) {
        //     redirect(site_url('activities/authentication/login'));
        //     exit;
        // }
    }

    private function respond(array $response)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function data_option_province()
    {
        $result = $this->Region_Model->data_option_province();
        $this->respond($result);
    }

    public function data_option_city()
    {
        $mst_reg_provinceid = $this->input->get('mst_reg_provinceid', true);
        if ($mst_reg_provinceid === null) {
            $mst_reg_provinceid = $this->input->post('mst_reg_provinceid', true);
        }

        $result = $this->Region_Model->data_option_city($mst_reg_provinceid);
        $this->respond($result);
    }

    public function data_option_district()
    {
        $mst_reg_cityid = $this->input->get('mst_reg_cityid', true);
        if ($mst_reg_cityid === null) {
            $mst_reg_cityid = $this->input->post('mst_reg_cityid', true);
        }

        $result = $this->Region_Model->data_option_district($mst_reg_cityid);
        $this->respond($result);
    }

    public function data_option_village()
    {
        $mst_reg_districtid = $this->input->get('mst_reg_districtid', true);
        if ($mst_reg_districtid === null) {
            $mst_reg_districtid = $this->input->post('mst_reg_districtid', true);
        }

        $result = $this->Region_Model->data_option_village($mst_reg_districtid);
        $this->respond($result);
    }
}
