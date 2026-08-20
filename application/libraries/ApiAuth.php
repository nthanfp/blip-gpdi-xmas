<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApiAuth
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function extract_key()
    {
        $header = $this->CI->input->get_request_header('X-API-Key', true);
        if ($header !== null && $header !==  '') {
            return trim($header);
        }

        $query = $this->CI->input->get('key', true);
        if ($query !== null && $query !== '') {
            return trim($query);
        }

        $auth = $this->CI->input->get_request_header('Authorization', true);
        if ($auth !== null && strpos($auth, 'Bearer ') === 0) {
            $token = trim(substr($auth, 7));
            if ($token !== '') {
                return $token;
            }
        }

        return null;
    }

    public function validate()
    {
        $key = $this->extract_key();
        if ($key === null || $key === '') {
            return [
                'success' => false,
                'message' => 'API key required',
                'response_code' => 'API_KEY_REQUIRED',
            ];
        }

        $this->CI->load->model('ApiKey_Model');
        $result = $this->CI->ApiKey_Model->find_by_key($key);

        if (!$result['success']) {
            return [
                'success' => false,
                'message' => 'Invalid API key',
                'response_code' => 'API_KEY_INVALID',
            ];
        }

        $row = $result['data'];
        if (!$row->is_active) {
            return [
                'success' => false,
                'message' => 'API key inactive',
                'response_code' => 'API_KEY_INACTIVE',
            ];
        }

        // $this->record_usage((int) $row->set_api_keyid);

        return [
            'success' => true,
            'key_id' => (int) $row->set_api_keyid,
            'key_name' => $row->key_name,
        ];
    }

    public function record_usage($key_id)
    {
        $this->CI->db->set('last_used', date('Y-m-d H:i:s'))
            ->where('set_api_keyid', (int) $key_id)
            ->update('set_api_key');
    }
}
