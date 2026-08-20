<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApiKey_Model extends CI_Model
{
    private $_table = 'set_api_key';

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

    public function normalize_text($value)
    {
        if ($value === '' || $value === null || is_array($value)) {
            return '';
        }

        return trim((string) $value);
    }

    private function current_user_id()
    {
        $CI = &get_instance();

        if (!isset($CI->Auth_Model)) {
            $CI->load->model('Auth_Model');
        }

        $current_user = $CI->Auth_Model->current_user();

        return $current_user ? $current_user->username : null;
    }

    public function generate_key()
    {
        return bin2hex(random_bytes(16));
    }

    public function find_by_key($plain_key)
    {
        $key = strtolower($this->normalize_text($plain_key));
        if ($key === '') {
            return [
                'success' => false,
                'message' => 'API key required',
                'response_code' => 'API_KEY_REQUIRED',
            ];
        }

        $row = $this->db->where('api_key', $key)
            ->get($this->_table)
            ->row();

        if (!$row) {
            return [
                'success' => false,
                'message' => 'Invalid API key',
                'response_code' => 'API_KEY_INVALID',
            ];
        }

        return ['success' => true, 'data' => $row];
    }

    public function data_new($input)
    {
        $api_key = $this->generate_key();
        $current_user = $this->current_user_id();

        $set_api_keyid = $this->Global_Model->get_autoid_seq('seq_set_api_key');
        if ($set_api_keyid === null) {
            $set_api_keyid = 1;
        }

        $data = [
            'set_api_keyid' => $set_api_keyid,
            'api_key' => $api_key,
            'key_name' => $this->normalize_text($input['key_name'] ?? ''),
            'notes' => $this->normalize_text($input['notes'] ?? ''),
            'is_active' => true,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $current_user
        ];

        $insert = $this->db->insert($this->_table, $data);
        if (!$insert) {
            return ['success' => false, 'message' => 'Failed to create API key'];
        }

        return [
            'success' => true,
            'message' => 'API key created successfully',
            'data' => [
                'set_api_keyid' => (int) $set_api_keyid,
                'api_key' => $api_key,
                'key_name' => $data['key_name'],
                'notes' => $data['notes'],
            ],
        ];
    }

    public function data_list($page = 1, $per_page = 10, $search = '', $is_active = '', $sort_by = 'set_api_keyid', $sort_dir = 'DESC')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;

        $this->db->from($this->_table . ' a');

        $search = $this->normalize_text($search);
        if ($search !== '') {
            $this->db->group_start()
                ->like('a.key_name', $search)
                ->or_like('a.notes', $search)
                ->or_like('a.api_key', $search)
                ->group_end();
        }

        $is_active = $this->normalize_text($is_active);
        if ($is_active !== '') {
            $active = in_array(strtolower($is_active), ['true', '1', 'yes'], true);
            $this->db->where('a.is_active', $active);
        }

        $total = $this->db->count_all_results('', false);
        $this->db->select('a.*, (SELECT MAX("created_date") FROM "act_api_log" WHERE "set_api_keyid" = a.set_api_keyid) as "last_used"', false);
        $allowed_sort_columns = [
            'set_api_keyid' => 'a.set_api_keyid',
            'api_key' => 'a.api_key',
            'key_name' => 'a.key_name',
            'is_active' => 'a.is_active',
            'created_date' => 'a.created_date'
        ];

        $sort_by = trim((string) $sort_by);
        $sort_dir = strtolower(trim((string) $sort_dir)) === 'asc' ? 'ASC' : 'DESC';
        $sort_column = isset($allowed_sort_columns[$sort_by]) ? $allowed_sort_columns[$sort_by] : 'a.set_api_keyid';

        $this->db->order_by($sort_column, $sort_dir);
        $this->db->limit($per_page, $offset);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'API key data retrived successfully',
            'data' => $rows,
            'pagination' => [
                'page' => $page,
                'per_page' => $per_page,
                'total' => (int) $total,
                'total_pages' => (int) ceil($total / $per_page),
                'has_prev' => $page > 1,
                'has_next' => ($page * $per_page) < $total,
            ]
        ];
    }

    public function data_edit($id)
    {
        $item = $this->db->where('set_api_keyid', (int) $id)
            ->get($this->_table)
            ->row();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'API key data not found',
            ];
        }

        return [
            'success' => true,
            'message' => 'API key data retrived successfully',
            'data' => $item
        ];
    }

    public function data_update($id, $input)
    {
        $id = $this->normalize_id($id);
        if ($id === null) {
            return [
                'success' => false,
                'message' => 'Invalid ID',
            ];
        }

        $data = [];

        if (array_key_exists('key_name', $input)) {
            $data['key_name'] = $this->normalize_text($input['key_name']);
        }

        if (array_key_exists('notes', $input)) {
            $data['notes'] = $this->normalize_text($input['notes']);
        }

        if (array_key_exists('is_active', $input)) {
            $active = strtolower($this->normalize_text($input['is_active']));
            $data['is_active'] = in_array($active, ['true', '1', 'yes'], true);
        }

        if (empty($data)) {
            return ['success' => false, 'message' => 'Nothing to update'];
        }

        $update = $this->db->where('set_api_keyid', $id)->update($this->_table, $data);

        return [
            'success' => (bool) $update,
            'message' => $update ? 'API key updated successfully' : 'Failed to update API key',
        ];
    }

    public function data_delete($id)
    {
        $id = $this->normalize_id($id);
        if ($id === null) {
            return [
                'success' => false,
                'message' => 'Invalid ID',
            ];
        }

        $item = $this->db->where('set_api_keyid', $id)
            ->get($this->_table)
            ->row();
        if (!$item) {
            return [
                'success' => false,
                'message' => 'API key data not found'
            ];
        }

        $log = $this->db->where('set_api_keyid', $id)
            ->get('act_api_log')
            ->row();
        if (!$log) {
            $delete = $this->db->where('set_api_keyid', $id)->delete($this->_table);
            return [
                'success' => (bool) $delete,
                'message' => $delete ? 'API key deleted permanently' : 'Failed to delete API key',
            ];
        } else {
            return [
                'success' => false,
                'message' => 'API key is have log'
            ];
        }
    }

    public function data_regenerate_key($id)
    {
        $id = $this->normalize_id((int) $id);
        if ($id == null) {
            return [
                'success' => false,
                'message' => 'Invalid ID',
            ];
        }

        $item = $this->db->where('set_api_keyid', $id)
            ->get($this->_table)
            ->row();
        if (!$item) {
            return [
                'success' => false,
                'message' => 'API key data not found',
            ];
        }

        $new_key = $this->generate_key();
        $update = $this->db->where('set_api_keyid', $id)
            ->update($this->_table, ['api_key' => $new_key]);

        return [
            'success' => (bool) $update,
            'message' => $update ? 'API key regenerated successfully' : 'Failed to regenerate API key',
            'data' => $update ? [
                'set_api_keyid' => (int) $id,
                'api_key' => $new_key,
            ] : null,
        ];
    }
}
