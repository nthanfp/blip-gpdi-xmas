<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher extends CI_Controller
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

    private function respond(array $response)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }


    public function index()
    {
        show_404();
        return;
    }

    public function verification()
    {
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
                ]);
                return;
            } else {
                $rate['count']++;
            }
        } else {
            $rate = ['count' => 1, 'start' => time()];
        }

        $this->session->set_userdata($rate_key, $rate);

        $voucher_key = $this->input->post('voucher_key', true);
        if ($voucher_key === null) {
            $voucher_key = $this->input->get('voucher_key', true);
        }

        $result = $this->Voucher_Model->verification($voucher_key);
        $this->respond($result);
    }

    public function claim_gift()
    {
        $captcha_input = $this->input->post('captcha_code', true);
        if ($captcha_input === null) {
            $captcha_input = $this->input->get('captcha_code', true);
        }

        $captcha_session = $this->session->userdata('claim_captcha_word');
        if ($captcha_session === null || strcasecmp(trim((string) $captcha_input), trim((string) $captcha_session)) !== 0) {
            $this->respond([
                'success' => false,
                'message' => 'Captcha tidak valid'
            ]);
            return;
        }

        $voucher_key = $this->input->post('voucher_key', true);
        if ($voucher_key === null) {
            $voucher_key = $this->input->get('voucher_key', true);
        }

        $idempotency_key = $this->input->post('idempotency_key', true);
        if ($idempotency_key === null) {
            $idempotency_key = $this->input->get('idempotency_key', true);
        }

        $mst_customerid = $this->input->post('mst_customerid', true);
        if ($mst_customerid === null) {
            $mst_customerid = $this->input->get('mst_customerid', true);
        }

        $customer_payload = [
            'custname' => $this->input->post('custname', true) ?? $this->input->get('custname', true),
            'phone_number' => $this->input->post('phone_number', true) ?? $this->input->get('phone_number', true),
            'email' => $this->input->post('email', true) ?? $this->input->get('email', true),
            'mst_reg_provinceid' => $this->input->post('mst_reg_provinceid', true) ?? $this->input->get('mst_reg_provinceid', true),
            'mst_reg_cityid' => $this->input->post('mst_reg_cityid', true) ?? $this->input->get('mst_reg_cityid', true),
            'mst_reg_districtid' => $this->input->post('mst_reg_districtid', true) ?? $this->input->get('mst_reg_districtid', true),
            'mst_reg_villageid' => $this->input->post('mst_reg_villageid', true) ?? $this->input->get('mst_reg_villageid', true)
        ];

        $uploaded_file = null;
        if (isset($_FILES['purchase_proof']) && $_FILES['purchase_proof']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploaded_file = $_FILES['purchase_proof'];
        }

        $context = [
            'idempotency_key' => $idempotency_key,
            'description' => $this->input->post('wallet', true) ?? $this->input->get('wallet', true),
            'ip_address' => $this->Global_Model->get_ip_address() ?? '',
            'mac_address' => $this->Global_Model->get_mac() ?? '',
            'useragent' => $this->Global_Model->get_useragent() ?? '',
            'geo_lat' => $this->input->post('geo_lat', true) ?? $this->input->get('geo_lat', true),
            'geo_long' => $this->input->post('geo_long', true) ?? $this->input->get('geo_long', true),
            'customer' => $customer_payload,
            'uploaded_file' => $uploaded_file
        ];

        $result = $this->Voucher_Model->claim_gift($voucher_key, $mst_customerid, $context);
        $this->session->unset_userdata('claim_captcha_word');
        $this->respond($result);
    }

    public function captcha()
    {
        $vals = [
            'img_path' => FCPATH . 'assets/captcha/',
            'img_url' => base_url('assets/captcha/'),
            'img_width' => 180,
            'img_height' => 56,
            'expiration' => 300,
            'word_length' => 5,
            'font_size' => 22,
            'pool' => '23456789',
            'colors' => [
                'background' => [255, 248, 248],
                'border' => [214, 170, 180],
                'text' => [122, 16, 40],
                'grid' => [240, 220, 225]
            ]
        ];

        if (!is_dir($vals['img_path'])) {
            @mkdir($vals['img_path'], 0755, true);
        }

        $cap = create_captcha($vals);
        if (!$cap) {
            $this->respond([
                'success' => false,
                'message' => 'Failed to generate captcha'
            ]);
            return;
        }

        $this->session->set_userdata('claim_captcha_word', $cap['word']);
        $this->respond([
            'success' => true,
            'message' => 'Captcha generated',
            'data' => [
                'image' => $cap['image']
            ]
        ]);
    }
}
