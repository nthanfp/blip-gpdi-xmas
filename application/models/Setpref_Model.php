<?php

class Setpref_Model extends CI_Model
{
    private $_table = 'set_pref';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Global_Model');
        $this->load->helper('global');
    }

    private function current_user_id()
    {
        $CI =& get_instance();
        if (!isset($CI->Auth_Model)) {
            $CI->load->model('Auth_Model');
        }
        $current_user = $CI->Auth_Model->current_user();
        return $current_user ? $current_user->mst_adminid : null;
    }

    public function rules($mode = 'create')
    {
        return [
            [
                'field' => 'pref_name',
                'label' => 'Preference Name',
                'rules' => 'required|max_length[100]'
            ],
            [
                'field' => 'pref_label',
                'label' => 'Preference Label',
                'rules' => 'required|max_length[100]'
            ],
            [
                'field' => 'pref_value',
                'label' => 'Preference Value',
                'rules' => 'required'
            ]
        ];
    }

    public function data_list($page = 1, $per_page = 10, $search = '')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;

        $this->db->from($this->_table);

        if ($search !== '') {
            $this->db->group_start()
                ->like('pref_name', $search)
                ->or_like('pref_label', $search)
                ->or_like('pref_value', $search)
                ->group_end();
        }

        $total = $this->db->count_all_results('', false);

        $this->db->order_by('pref_name', 'ASC');
        $this->db->limit($per_page, $offset);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Preferences retrieved successfully',
            'data' => $rows,
            'pagination' => [
                'page' => $page,
                'per_page' => $per_page,
                'total' => (int) $total,
                'total_pages' => (int) ceil($total / $per_page),
                'has_prev' => $page > 1,
                'has_next' => ($page * $per_page) < $total
            ]
        ];
    }

    public function data_new(array $input)
    {
        $pref_name = trim((string) ($input['pref_name'] ?? ''));
        $pref_label = trim((string) ($input['pref_label'] ?? ''));
        $pref_value = trim((string) ($input['pref_value'] ?? ''));

        if ($pref_name === '' || $pref_label === '' || $pref_value === '') {
            return ['success' => false, 'message' => 'All fields are required'];
        }

        $this->db->where('pref_name', $pref_name);
        if ($this->db->count_all_results($this->_table) > 0) {
            return ['success' => false, 'message' => 'Preference name is already in use'];
        }

        $set_prefid = $this->Global_Model->get_autoid_seq('set_pref');
        if ($set_prefid === null) {
            return ['success' => false, 'message' => 'Failed to generate preference ID'];
        }

        $data = [
            'set_prefid' => $set_prefid,
            'pref_name' => $pref_name,
            'pref_label' => $pref_label,
            'pref_value' => $pref_value,
            'created_by' => $this->current_user_id(),
            'created_date' => date('Y-m-d H:i:s')
        ];

        $insert = $this->db->insert($this->_table, $data);

        return [
            'success' => (bool) $insert,
            'message' => $insert ? 'Preference created successfully' : 'Failed to create preference'
        ];
    }

    public function data_edit($id)
    {
        $item = $this->db->get_where($this->_table, ['set_prefid' => (int) $id])->row();

        if (!$item) {
            return ['success' => false, 'message' => 'Preference not found'];
        }

        return ['success' => true, 'message' => 'Preference retrieved successfully', 'data' => $item];
    }

    public function data_update($id, array $input)
    {
        $item = $this->db->get_where($this->_table, ['set_prefid' => (int) $id])->row();
        if (!$item) {
            return ['success' => false, 'message' => 'Preference not found'];
        }

        $pref_name = trim((string) ($input['pref_name'] ?? ''));
        $pref_label = trim((string) ($input['pref_label'] ?? ''));
        $pref_value = trim((string) ($input['pref_value'] ?? ''));

        if ($pref_name === '' || $pref_label === '' || $pref_value === '') {
            return ['success' => false, 'message' => 'All fields are required'];
        }

        $this->db->where('pref_name', $pref_name);
        $this->db->where('set_prefid !=', (int) $id);
        if ($this->db->count_all_results($this->_table) > 0) {
            return ['success' => false, 'message' => 'Preference name is already in use'];
        }

        $data = [
            'pref_name' => $pref_name,
            'pref_label' => $pref_label,
            'pref_value' => $pref_value,
            'modified_by' => $this->current_user_id(),
            'modified_date' => date('Y-m-d H:i:s')
        ];

        $this->db->where('set_prefid', (int) $id);
        $update = $this->db->update($this->_table, $data);

        return [
            'success' => (bool) $update,
            'message' => $update ? 'Preference updated successfully' : 'Failed to update preference'
        ];
    }

    public function get_pref($pref_name)
    {
        $pref_name = trim((string) $pref_name);
        if ($pref_name === '') {
            return null;
        }

        $row = $this->db->select('pref_value')
            ->from($this->_table)
            ->where('pref_name', $pref_name)
            ->get()
            ->row();

        return $row ? $row->pref_value : null;
    }

    public function data_delete($id)
    {
        $item = $this->db->get_where($this->_table, ['set_prefid' => (int) $id])->row();
        if (!$item) {
            return ['success' => false, 'message' => 'Preference not found'];
        }

        $delete = $this->db->delete($this->_table, ['set_prefid' => (int) $id]);

        return [
            'success' => (bool) $delete,
            'message' => $delete ? 'Preference deleted successfully' : 'Failed to delete preference'
        ];
    }
}
