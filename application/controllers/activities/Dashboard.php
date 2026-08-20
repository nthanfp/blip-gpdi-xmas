<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
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
        if (!$this->Auth_Model->current_user()) {
            redirect(site_url('activities/authentication/login'));
            exit;
        }

        if (!$this->guard_menu_access(108, 'view')) {
            return;
        }

        $this->load->view('activities/dashboard', $this->_widget_permissions());
    }

    private function _widget_permissions()
    {
        $menus = [];

        $data = [];
        foreach ($menus as $key => $menuid) {
            $check = $this->Setmenu_Model->check_menu($menuid, 'view');
            $data[$key] = $check['success'] && $check['allowed'];
        }

        return $data;
    }

    public function data_dashboard()
    {
        if (!$this->guard_menu_access(108, 'view')) {
            return;
        }

        echo json_encode([
            'success' => true,
            'data' => []
        ]);
    }
}
