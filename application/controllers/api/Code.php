<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Code extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('captcha');
        $this->load->model('Customer_Model');
        $this->load->model('Voucher_Model');
        $this->load->model('Global_Model');
    }

    private function respond(array $response, $http_code = 500)
    {
        $this->output
            ->set_status_header($http_code)
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function index()
    {
        show_404();
        return;
    }

    public function verify()
    {
        $this->load->library('ApiLog');
        $this->apilog->start();

        $this->load->library('ApiAuth');
        $auth = $this->apiauth->validate();
        if (!$auth['success']) {
            $this->apilog->end(401, $auth['message'], false);
            $this->respond([
                'success' => false,
                'message' => $auth['message']
            ], 401);
            return;
        }
        $this->apilog->set_api_key($auth['key_id']);

        $ip = $this->input->ip_address();
        $rate_key = 'rate_verif_' . $ip;
        $rate = $this->session->userdata($rate_key);

        $limit = 20;
        $window = 60;
        if ($rate) {
            $elapsed = time() - $rate['start'];
            if ($elapsed > $window) {
                $rate = ['count' => 1, 'start' => time()];
            } else if ($rate['count'] >= $limit) {
                $this->respond([
                    'success' => false,
                    'message' => 'Too many requests. Silakan coba lagi nanti.'
                ], 429);
                return;
            } else {
                $rate['count']++;
            }
        } else {
            $rate = ['count' => 1, 'start' => time()];
        }
        $this->session->set_userdata($rate_key, $rate);

        $json = $this->input->raw_input_stream;
        $data = json_decode($json, true);
        $code = isset($data['code']) ? trim($data['code']) : null;
        $this->apilog->set_request_body(['code' => $code]);

        $result = $this->Voucher_Model->api_verification($code);
        if ($result['success'] == false && $result['response_code'] == 'CODE_REQUIRED') {
            $this->apilog->end(400, $result['message'], false);
            $this->respond($result, 400);
        } else if ($result['success'] == false && $result['response_code'] == 'CODE_NOT_FOUND') {
            $this->apilog->end(404, $result['message'], false);
            $this->respond($result, 404);
        } else if ($result['success'] == false && $result['response_code'] == 'CODE_EXPIRED') {
            $this->apilog->end(410, $result['message'], false);
            $this->respond($result, 410);
        } else if ($result['success'] == false && $result['response_code'] == 'CODE_ALREADY_CLAIM') {
            $this->apilog->end(400, $result['message'], false);
            $this->respond($result, 400);
        } else if ($result['success'] == true && $result['response_code'] == 'CODE_VERIFIED') {
            $this->apilog->end(200, $result['message'], true);
            $this->respond($result, 200);
        }
    }

    public function claim()
    {
        $this->load->library('ApiLog');
        $this->apilog->start();

        $this->load->library('ApiAuth');
        $auth = $this->apiauth->validate();
        if (!$auth['success']) {
            $this->apilog->end(401, $auth['message'], false);
            $this->respond([
                'success' => false,
                'message' => $auth['message']
            ], 401);
            return;
        }
        $this->apilog->set_api_key($auth['key_id']);

        $json = $this->input->raw_input_stream;
        $data = json_decode($json, true);

        $code = array_key_exists('code', $data) ? trim($data['code']) : null;
        if ($code === null || $code === '') {
            $code = $this->input->post('code', true);
        }
        if ($code === null || $code === '') {
            $code = $this->input->get('code', true);
        }

        $this->apilog->set_request_body(['code' => $code]);

        $context = [
            'ip_address' => $this->Global_Model->get_ip_address() ?? '',
            'mac_address' => $this->Global_Model->get_mac() ?? '',
            'useragent' => $this->Global_Model->get_useragent() ?? ''
        ];

        $result = $this->Voucher_Model->api_claim($code, null, $context);

        if ($result['success'] == false && $result['response_code'] == 'CLAIM_KEY_REQUIRED') {
            $this->apilog->end(400, $result['message'], false);
            $this->respond($result, 400);
        } else if ($result['success'] == false && $result['response_code'] == 'CLAIM_NOT_FOUND') {
            $this->apilog->end(404, $result['message'], false);
            $this->respond($result, 404);
        } else if ($result['success'] == false && $result['response_code'] == 'CLAIM_EXPIRED') {
            $this->apilog->end(410, $result['message'], false);
            $this->respond($result, 410);
        } else if ($result['success'] == false && $result['response_code'] == 'CLAIM_RACE_CONDITION') {
            $this->apilog->end(409, $result['message'], false);
            $this->respond($result, 409);
        } else if ($result['success'] == false && $result['response_code'] == 'CLAIM_FAILED') {
            $this->apilog->end(500, $result['message'], false);
            $this->respond($result, 500);
        } else if ($result['success'] == true && $result['response_code'] == 'CLAIM_SUCCESS') {
            $this->apilog->end(200, $result['message'], true);
            $this->respond($result, 200);
        }
    }
}
