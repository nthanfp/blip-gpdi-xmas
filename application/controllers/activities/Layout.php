<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Layout extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('Seating_Model');
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

    private function json_response($success, $message, $data = null)
    {
        $payload = ['success' => (bool) $success, 'message' => (string) $message];
        if ($data !== null) {
            $payload['data'] = $data;
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($payload));
    }

    private function current_admin_id()
    {
        $user = $this->Auth_Model->current_user();
        return $user ? (int) $user->mst_adminid : null;
    }

    private function post_array($key)
    {
        $v = $this->input->post($key);
        if (is_array($v)) {
            return $v;
        }
        $v = trim((string) $v);
        if ($v === '') {
            return [];
        }
        $j = json_decode($v, true);
        if (is_array($j)) {
            return $j;
        }
        return array_filter(array_map('trim', explode(',', $v)), 'strlen');
    }

    public function index()
    {
        if (!$this->Auth_Model->current_user()) {
            redirect(site_url('activities/authentication/login'));
            exit;
        }

        if (!$this->guard_menu_access(133, 'view')) {
            return;
        }

        $this->load->view('activities/layout');
    }

    public function seat_search()
    {
        if (!$this->Auth_Model->current_user()) {
            $this->json_response(false, 'Unauthorized');
            return;
        }
        if (!$this->guard_menu_access(133, 'view')) {
            return;
        }

        $q = $this->input->get('q');
        $res = $this->Seating_Model->search_registrations($q);
        $this->json_response($res['success'], $res['message'], $res['data'] ?? null);
    }

    public function seat_attendees()
    {
        if (!$this->Auth_Model->current_user()) {
            $this->json_response(false, 'Unauthorized');
            return;
        }
        if (!$this->guard_menu_access(133, 'view')) {
            return;
        }

        $registrationid = $this->input->get('registrationid');
        $res = $this->Seating_Model->registration_attendees($registrationid);
        $this->json_response($res['success'], $res['message'], $res['data'] ?? null);
    }

    public function seat_assign()
    {
        if (!$this->Auth_Model->current_user()) {
            $this->json_response(false, 'Unauthorized');
            return;
        }
        if (!$this->guard_menu_access(133, 'update')) {
            return;
        }

        $registrationid = $this->input->post('registrationid');
        $floor_id = $this->input->post('floor_id');

        $res = $this->Seating_Model->assign_seats(
            $registrationid,
            $this->post_array('attendees'),
            $this->post_array('seats'),
            $floor_id,
            $this->current_admin_id()
        );
        $this->json_response($res['success'], $res['message'], $res['data'] ?? null);
    }

    public function seat_release()
    {
        if (!$this->Auth_Model->current_user()) {
            $this->json_response(false, 'Unauthorized');
            return;
        }
        if (!$this->guard_menu_access(133, 'update')) {
            return;
        }

        $floor_id = $this->input->post('floor_id');
        $registrationid = $this->input->post('registrationid');

        $res = $this->Seating_Model->release_seats(
            $floor_id,
            $this->post_array('seats'),
            $registrationid !== null && $registrationid !== '' ? (int) $registrationid : null
        );
        $this->json_response($res['success'], $res['message'], $res['data'] ?? null);
    }
}
