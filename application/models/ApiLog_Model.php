<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApiLog_Model extends CI_Model
{
    private $_table = 'act_api_log';

    public function __construct()
    {
        parent::__construct();
    }

    public function normalize_id($value)
    {
        if ($value === '' || $value === null || is_array($value)) {
            return null;
        }

        $value = trim((string) $value);
        if ($value === '' || !ctype_digit($value)) {
            return null;
        }

        return (int) $value;
    }

    private function normalize_text($value)
    {
        if ($value === '' || $value === null || is_array($value)) {
            return '';
        }

        return trim((string) $value);
    }

    public function data_new(array $input)
    {
        $act_api_logid = $this->Global_Model->get_autoid_seq('seq_act_api_log');
        if ($act_api_logid === null) {
            $act_api_logid = 1;
        }

        $data = [
            'act_api_logid'    => $act_api_logid,
            'request_method'   => trim(strtoupper($input['request_method'] ?? 'GET')),
            'endpoint'         => trim($input['endpoint'] ?? ''),
            'request_body'     => $input['request_body'] ?? null,
            'query_string'     => trim($input['query_string'] ?? ''),
            'http_status'      => (int) ($input['http_status'] ?? 200),
            'response_message' => trim($input['response_message'] ?? ''),
            'ip_address'       => trim($input['ip_address'] ?? ''),
            'useragent'        => trim($input['useragent'] ?? ''),
            'mac_address'      => trim($input['mac_address'] ?? ''),
            'execution_time'   => (int) ($input['execution_time'] ?? 0),
            'is_success'       => (bool) ($input['is_success'] ?? true),
            'created_date'     => date('Y-m-d H:i:s'),
            'set_api_keyid'    => isset($input['set_api_keyid']) ? (int) $input['set_api_keyid'] : null,
        ];

        $insert = $this->db->insert($this->_table, $data);

        return [
            'success' => (bool) $insert,
            'message' => $insert ? 'API log created successfully' : 'Failed to create API log',
        ];
    }

    public function data_list($page = 1, $per_page = 10, $search = '', $endpoint = '', $http_status = '', $is_success = '', $set_api_keyid = '', $sort_by = 'created_date', $sort_dir = 'DESC')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;

        $this->db->select('l.*, sk."key_name"', false);
        $this->db->from($this->_table . ' l');
        $this->db->join('"set_api_key" sk', 'sk."set_api_keyid" = l."set_api_keyid"', 'left');

        if ($search !== '') {
            $this->db->group_start()
                ->like('l.ip_address', $search)
                ->or_like('l.useragent', $search)
                ->or_like('l.response_message', $search)
                ->or_like('l.endpoint', $search)
                ->group_end();
        }

        $endpoint = $this->normalize_text($endpoint);
        if ($endpoint !== '') {
            $this->db->where('l.endpoint', $endpoint);
        }

        $http_status = $this->normalize_id($http_status);
        if ($http_status !== null) {
            $this->db->where('l.http_status', $http_status);
        }

        $is_success = $this->normalize_text($is_success);
        if ($is_success !== '') {
            $this->db->where('l.is_success', $is_success === 'true');
        }

        $set_api_keyid = $this->normalize_id($set_api_keyid);
        if ($set_api_keyid !== null) {
            $this->db->where('l."set_api_keyid"', $set_api_keyid);
        }

        $total = $this->db->count_all_results('', false);

        $allowed_sort_columns = [
            'act_api_logid'    => 'l.act_api_logid',
            'request_method'   => 'l.request_method',
            'endpoint'         => 'l.endpoint',
            'http_status'      => 'l.http_status',
            'response_message' => 'l.response_message',
            'ip_address'       => 'l.ip_address',
            'execution_time'   => 'l.execution_time',
            'is_success'       => 'l.is_success',
            'created_date'     => 'l.created_date',
        ];

        $sort_by = trim((string) $sort_by);
        $sort_dir = strtolower(trim((string) $sort_dir)) === 'asc' ? 'ASC' : 'DESC';
        $sort_column = isset($allowed_sort_columns[$sort_by]) ? $allowed_sort_columns[$sort_by] : 'l.created_date';

        $this->db->order_by($sort_column, $sort_dir);
        $this->db->limit($per_page, $offset);
        $rows = $this->db->get()->result();

        return [
            'success'   => true,
            'message'   => 'API log data retrieved successfully',
            'data'      => $rows,
            'pagination' => [
                'page'        => $page,
                'per_page'    => $per_page,
                'total'       => (int) $total,
                'total_pages' => (int) ceil($total / $per_page),
                'has_prev'    => $page > 1,
                'has_next'    => ($page * $per_page) < $total,
            ],
        ];
    }

    public function data_list_print($search = '', $endpoint = '', $http_status = '', $is_success = '', $set_api_keyid = '', $sort_by = 'created_date', $sort_dir = 'DESC')
    {
        $this->db->select('l.*, sk."key_name"', false);
        $this->db->from($this->_table . ' l');
        $this->db->join('"set_api_key" sk', 'sk."set_api_keyid" = l."set_api_keyid"', 'left');

        if ($search !== '') {
            $this->db->group_start()
                ->like('l.ip_address', $search)
                ->or_like('l.useragent', $search)
                ->or_like('l.response_message', $search)
                ->or_like('l.endpoint', $search)
                ->group_end();
        }

        $endpoint = $this->normalize_text($endpoint);
        if ($endpoint !== '') {
            $this->db->where('l.endpoint', $endpoint);
        }

        $http_status = $this->normalize_id($http_status);
        if ($http_status !== null) {
            $this->db->where('l.http_status', $http_status);
        }

        $is_success = $this->normalize_text($is_success);
        if ($is_success !== '') {
            $this->db->where('l.is_success', $is_success === 'true');
        }

        $set_api_keyid = $this->normalize_id($set_api_keyid);
        if ($set_api_keyid !== null) {
            $this->db->where('l."set_api_keyid"', $set_api_keyid);
        }

        $allowed_sort_columns = [
            'act_api_logid'    => 'l.act_api_logid',
            'request_method'   => 'l.request_method',
            'endpoint'         => 'l.endpoint',
            'http_status'      => 'l.http_status',
            'response_message' => 'l.response_message',
            'ip_address'       => 'l.ip_address',
            'execution_time'   => 'l.execution_time',
            'is_success'       => 'l.is_success',
            'created_date'     => 'l.created_date',
        ];

        $sort_by = trim((string) $sort_by);
        $sort_dir = strtolower(trim((string) $sort_dir)) === 'asc' ? 'ASC' : 'DESC';
        $sort_column = isset($allowed_sort_columns[$sort_by]) ? $allowed_sort_columns[$sort_by] : 'l.created_date';

        $this->db->order_by($sort_column, $sort_dir);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'API log data retrieved successfully',
            'data'    => $rows,
        ];
    }

    public function data_edit($id)
    {
        $item = $this->db->where('act_api_logid', (int) $id)
            ->get($this->_table)
            ->row();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'API log data not found',
            ];
        }

        return [
            'success' => true,
            'message' => 'API log data retrieved successfully',
            'data'    => $item,
        ];
    }

    public function data_option_endpoint()
    {
        $rows = $this->db->select('DISTINCT "endpoint"', false)
            ->from($this->_table)
            ->where('endpoint IS NOT NULL')
            ->where('endpoint !=', '')
            ->order_by('endpoint', 'ASC')
            ->get()
            ->result();

        $data = [];
        foreach ($rows as $row) {
            $data[] = [
                'endpoint' => $row->endpoint,
            ];
        }

        return [
            'success' => true,
            'message' => 'Endpoint options retrieved successfully',
            'data'    => $data,
        ];
    }

    public function data_option_http_status()
    {
        $rows = $this->db->select('DISTINCT "http_status"', false)
            ->from($this->_table)
            ->where('http_status IS NOT NULL')
            ->order_by('http_status', 'ASC')
            ->get()
            ->result();

        $data = [];
        foreach ($rows as $row) {
            $data[] = [
                'http_status' => (int) $row->http_status,
            ];
        }

        return [
            'success' => true,
            'message' => 'HTTP status options retrieved successfully',
            'data'    => $data,
        ];
    }

    public function data_option_success()
    {
        $data = [
            ['is_success' => 'true', 'label' => 'Success'],
            ['is_success' => 'false', 'label' => 'Failed'],
        ];

        return [
            'success' => true,
            'message' => 'Success options retrieved successfully',
            'data'    => $data,
        ];
    }

    public function data_option_api_key()
    {
        $rows = $this->db->select('sk."set_api_keyid", sk."key_name"', false)
            ->from('"set_api_key" sk')
            ->where('sk."is_active"', true)
            ->order_by('sk."key_name"', 'ASC')
            ->get()
            ->result();

        $data = [];
        foreach ($rows as $row) {
            $data[] = [
                'set_api_keyid' => (int) $row->set_api_keyid,
                'key_name'      => $row->key_name,
            ];
        }

        return [
            'success' => true,
            'message' => 'API key options retrieved successfully',
            'data'    => $data,
        ];
    }
}
