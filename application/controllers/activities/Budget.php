<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Budget extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('Budget_Model');

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

        $this->load->view('activities/budget');
    }

    public function data_budget()
    {
        if (!$this->guard_menu_access(121, 'view')) {
            return;
        }

        $itemtype = $this->input->get('itemtype', true) ?? '';
        $search = $this->input->get('search', true) ?? '';
        $bulk_code = $this->input->get('bulk_code', true) ?? '';

        $result = $this->Budget_Model->budget_summary($itemtype, $search, $bulk_code);
        $this->respond($result);
    }

    public function data_totals()
    {
        if (!$this->guard_menu_access(121, 'view')) {
            return;
        }

        $itemtype = $this->input->get('itemtype', true) ?? '';
        $bulk_code = $this->input->get('bulk_code', true) ?? '';

        $result = $this->Budget_Model->budget_totals($itemtype, $bulk_code);
        $this->respond($result);
    }

    public function data_ewallet($type){
        if (!$this->guard_menu_access(121, 'view')) {
            return;
        }

        if($type === 'accumulation'){
            $result = $this->Budget_Model->budget_ewallet_accumulation();

            if($result === FALSE){
                $this->respond(array('success' => false, 'msg' => 'Failed to load budgeting e-wallet accumulation'));
            }

            $this->respond(array('success' => true, 'msg' => '', 'data' => $result));
        } else if($type === 'itemgift') {
            $result = $this->Budget_Model->budget_ewallet_itemgift();

            if($result === FALSE){
                $this->respond(array('success' => false, 'msg' => 'Failed to load budgeting e-wallet per itemgift'));
            }

            $output = array();
            foreach ($result as $row) {
                $wallet = $row->wallet_name;

                if (!isset($output[$wallet])) {
                    $output[$wallet] = array(
                        'wallet_name' => $wallet,
                        'items' => array()
                    );
                }

                $output[$wallet]['items'][] = array(
                    'itemname'    => $row->itemname,
                    'redeem_qty'  => (int)$row->redeem_qty,
                    'total_value' => (int)$row->total_value
                );
            }

            $output = array_values($output);

            $this->respond(array(
                'success' => true,
                'msg' => '',
                'data' => $output
            ));
        }
    }

    public function data_option_bulk_code()
    {
        if (!$this->guard_menu_access(121, 'view')) {
            return;
        }

        $result = $this->Budget_Model->data_option_bulk_code();
        $this->respond($result);
    }
}
