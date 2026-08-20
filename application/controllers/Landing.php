<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Setpref_Model');
        $this->load->library('user_agent');
    }

    private function _is_maintenance()
    {
        return $this->Setpref_Model->get_pref('maintenance_mode') === '1';
    }

    private function _require_mobile()
    {
        if (!$this->agent->is_mobile()) {
            $this->load->view('landing/mobile_only');
            return false;
        }
        return true;
    }

    public function index($voucher_key = null)
    {
        if ($this->_is_maintenance()) {
            $this->load->view('landing/maintenance');
            return;
        }

        if (!$this->_require_mobile()) return;

        if (!$voucher_key) {
            $this->load->view('landing/starter');
            return;
        }

        $this->load->view('landing/index');
    }

    public function complete($voucher_key)
    {
        if ($this->_is_maintenance()) {
            $this->load->view('landing/maintenance');
            return;
        }

        if (!$this->_require_mobile()) return;

        $this->load->view('landing/complete');
    }

    public function example()
    {
        if ($this->_is_maintenance()) {
            $this->load->view('landing/maintenance');
            return;
        }

        if (!$this->_require_mobile()) return;

        $this->load->view('landing/starter');
    }
}