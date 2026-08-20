<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApiLog
{
    private $CI;
    private $start_time;
    private $request_data = [];

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function start()
    {
        $this->start_time = microtime(true);

        $this->request_data = [
            'request_method' => $_SERVER['REQUEST_METHOD'] ?? 'GET',
            'endpoint'       => $_SERVER['REQUEST_URI'] ?? '',
            'query_string'   => $_SERVER['QUERY_STRING'] ?? '',
            'ip_address'     => $this->CI->input->ip_address(),
            'useragent'      => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'mac_address'    => '',
            'request_body'   => null,
            'created_date'   => date('Y-m-d H:i:s'),
        ];

        if (function_exists('get_mac_address')) {
            $this->request_data['mac_address'] = get_mac_address();
        }
    }

    public function set_request_body($data)
    {
        if (!is_array($data)) {
            return;
        }

        $this->request_data['request_body'] = json_encode($this->mask_sensitive($data));
    }

    public function set_api_key($set_api_keyid) {
        $this->request_data['set_api_keyid'] = (int) $set_api_keyid;
    }

    public function end($http_status, $response_message, $is_success)
    {
        $execution_time = ((microtime(true) - $this->start_time) * 1000);

        $log_data = $this->request_data;
        $log_data['http_status']      = (int) $http_status;
        $log_data['response_message'] = trim((string) $response_message);
        $log_data['execution_time']   = $execution_time;
        $log_data['is_success']       = (bool) $is_success;

        $this->insert_log($log_data);
    }

    private function insert_log(array $data)
    {
        $this->CI->load->model('Global_Model');

        $act_api_logid = $this->CI->Global_Model->get_autoid('act_api_log', 'act_api_logid');
        if ($act_api_logid === null) {
            $act_api_logid = 1;
        }

        $data['act_api_logid'] = $act_api_logid;

        $this->CI->db->insert('act_api_log', $data);
    }

    private function mask_sensitive(array $data)
    {
        $masked_keys = ['password', 'token', 'secret', 'api_key', 'authorization'];

        foreach ($data as $key => $value) {
            $lower_key = strtolower($key);

            if (in_array($lower_key, $masked_keys, true)) {
                $data[$key] = '***MASKED***';
                continue;
            }

            if ($lower_key === 'code' && is_string($value) && strlen($value) > 4) {
                $data[$key] = substr($value, 0, 4) . '****';
                continue;
            }

            if ($lower_key === 'voucher_key' && is_string($value) && strlen($value) > 8) {
                $data[$key] = substr($value, 0, 8) . '****';
                continue;
            }
        }

        return $data;
    }
}
