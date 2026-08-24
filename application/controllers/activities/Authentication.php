<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authentication extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Global_Model');
        $this->load->model('LogAdmin_Model');
        $this->load->model('Database_Scanner');
    }

    private function log_activity($action, $description = '')
    {
        $current_user = $this->Auth_Model->current_user();

        if (!$current_user) {
            return false;
        }

        $result = $this->LogAdmin_Model->data_new([
            'mst_adminid' => $current_user->mst_adminid,
            'set_menuid' => 109,
            'action' => strtoupper(trim((string) $action)),
            'description' => trim((string) $description),
            'ip_address' => $this->input->ip_address(),
            'ua' => $this->session->userdata('user_agent') ?: $this->session->userdata('user_agent') ?: '',
            'mac' => $this->session->userdata('mac_address') ?: $this->session->userdata('mac_address') ?: ''
        ]);

        return isset($result['success']) ? (bool) $result['success'] : false;
    }

    public function index()
    {
        show_404();
    }

    public function login()
    {
        $this->load->view('activities/login');
    }

    public function get_databases()
    {
        $databases = $this->Database_Scanner->get_available_databases();
        $default_db = getenv('DB_NAME_PROD') ?: getenv('DB_NAME_DEV');
        $user_selected = $this->session->userdata('selected_database');

        $formatted = array_map(function ($db) use ($default_db, $user_selected) {
            $db['is_default'] = $db['name'] === $default_db;
            $db['is_selected'] = $db['name'] === $user_selected;
            return $db;
        }, $databases);

        usort($formatted, function ($a, $b) {
            if ($a['is_selected']) return -1;
            if ($b['is_selected']) return 1;
            if ($a['is_default']) return -1;
            if ($b['is_default']) return 1;
            return strcmp($a['display'], $b['display']);
        });

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => true, 'data' => $formatted]));
    }

    public function login_process()
    {
        $rate_key = 'login_rate_' . $this->input->ip_address();
        $rate = $this->session->userdata($rate_key) ?: ['count' => 0, 'locked_until' => 0];

        if ($rate['locked_until'] > time()) {
            $remaining = $rate['locked_until'] - time();
            echo json_encode([
                'success' => false,
                'message' => "Too many login attempts. Try again in {$remaining}s."
            ]);
            return;
        }

        $this->load->model('Auth_Model');
        $this->load->library('form_validation');

        $rules = $this->Auth_Model->rules();
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'success' => false,
                'message' => validation_errors()
            ]);
            return;
        }

        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $selected_database = $this->input->post('selected_database', true);

        if (!empty($selected_database)) {
            if (!$this->Database_Scanner->validate_database($selected_database)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid database selection'
                ]);
                return;
            }
            $this->session->set_userdata('selected_database', $selected_database);
        }

        if ($this->Auth_Model->login($username, $password)) {
            $this->session->sess_regenerate(TRUE);
            $this->session->unset_userdata($rate_key);
            $this->log_activity('LOGIN', 'Login user');
            echo json_encode([
                'success' => true,
                'redirect' => site_url('activities/dashboard')
            ]);
        } else {
            $rate['count']++;
            if ($rate['count'] >= 3) {
                $rate['locked_until'] = time() + 30;
            }
            $this->session->set_userdata($rate_key, $rate);
            echo json_encode([
                'success' => false,
                'message' => 'Username/Password not match!'
            ]);
        }
    }

    public function logout()
    {
        $this->load->model('Auth_Model');
        $this->load->model('Notification_Model');

        $current_user = $this->Auth_Model->current_user();
        if ($current_user && isset($current_user->mst_adminid)) {
            $this->Notification_Model->remove_tokens_by_admin($current_user->mst_adminid);
        }

        $this->Auth_Model->logout();
        redirect(site_url('activities/authentication/login'));
        exit;
    }

    public function password()
    {
        if (!$this->Auth_Model->current_user()) {
            redirect(site_url('activities/authentication/login'));
            exit;
        }

        $this->load->view('activities/change-password');
    }

    public function change_password()
    {
        if (!$this->Auth_Model->current_user()) {
            redirect(site_url('activities/authentication/login'));
            exit;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules([
            [
                'field' => 'current_password',
                'label' => 'Current Password',
                'rules' => 'required'
            ],
            [
                'field' => 'new_password',
                'label' => 'New Password',
                'rules' => 'required|min_length[6]|max_length[255]'
            ],
            [
                'field' => 'confirm_password',
                'label' => 'Confirm Password',
                'rules' => 'required|matches[new_password]'
            ]
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => validation_errors()
                ]));
            return;
        }

        $current_user = $this->Auth_Model->current_user();
        $result = $this->Auth_Model->change_password(
            $current_user->mst_adminid,
            $this->input->post('current_password', true),
            $this->input->post('new_password', true)
        );

        if (!empty($result['success'])) {
            $this->log_activity('EDIT', 'Change password');
            $this->Auth_Model->logout();
            $result['redirect'] = site_url('activities/authentication/login');
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
}
