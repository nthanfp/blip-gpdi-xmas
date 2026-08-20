<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    private $check_phone_limit = 20;
    private $check_phone_window = 60;

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Customer_Model');
    }

    private function respond(array $response)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    private function check_phone_rate_limit()
    {
        $key = 'check_phone_rl_' . $this->input->ip_address();
        $now = time();
        $bucket = $this->session->userdata($key);

        if (!is_array($bucket) || !isset($bucket['start'], $bucket['count'])) {
            $bucket = array('start' => $now, 'count' => 0);
        }

        if (($now - (int) $bucket['start']) >= $this->check_phone_window) {
            $bucket = array('start' => $now, 'count' => 0);
        }

        if ((int) $bucket['count'] >= $this->check_phone_limit) {
            return false;
        }

        $bucket['count'] = (int) $bucket['count'] + 1;
        $this->session->set_userdata($key, $bucket);
        return true;
    }

    public function index()
    {
        show_404();
        return;
    }

    public function check_phone()
    {
        if (!$this->check_phone_rate_limit()) {
            $this->output->set_status_header(429);
            $this->respond(array(
                'success' => false,
                'message' => 'Terlalu banyak permintaan. Coba lagi nanti.',
            ));
            return;
        }

        $phone_number = $this->input->post('phone_number', true);
        if ($phone_number === null) {
            $phone_number = $this->input->get('phone_number', true);
        }

        $result = $this->Customer_Model->check_phone($phone_number);
        $this->respond($result);
    }

    public function update_email() {}

    public function update_region() {}
}
