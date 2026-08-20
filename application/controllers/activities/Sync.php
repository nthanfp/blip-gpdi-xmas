<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sync extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('Sync_Model');

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
        if (!$this->guard_menu_access(121, 'view')) {
            return;
        }

        $this->load->view('activities/sync');
    }

    public function sync_proof_purchase()
    {
        if (!$this->guard_menu_access(121, 'view')) {
            return;
        }

        $start_date = $this->input->get('start_date', true) ?? '';
        $end_date = $this->input->get('end_date', true) ?? '';

        $result = $this->Sync_Model->sync_proof_purchase($start_date, $end_date);
        $this->respond($result);
    }

    public function sync_proof_completed()
    {
        if (!$this->guard_menu_access(121, 'view')) {
            return;
        }

        $start_date = $this->input->get('start_date', true) ?? '';
        $end_date = $this->input->get('end_date', true) ?? '';

        $result = $this->Sync_Model->sync_proof_completed($start_date, $end_date);
        $this->respond($result);
    }
}
