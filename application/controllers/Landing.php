<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (file_exists(APPPATH . 'config/db_bypass.php')) {
            return;
        }
        $this->load->model('Setpref_Model');
        $this->load->library('user_agent');
    }

    private function _is_maintenance()
    {
        if (!isset($this->Setpref_Model)) return false;
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

    public function index()
    {
        if ($this->_is_maintenance()) {
            $this->load->view('landing/maintenance');
            return;
        }

        $this->load->view('landing/index');
    }

    public function complete()
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
    }

    public function invite($slug = null)
    {
        if ($this->_is_maintenance()) {
            $this->load->view('landing/maintenance');
            return;
        }

        $this->load->view('landing/invite', ['slug' => $slug]);
    }
}
