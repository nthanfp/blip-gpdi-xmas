<?php

class Itemgift_Model extends CI_Model
{
    private $_table = 'mst_itemgift';

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

        return $current_user ? $current_user : null;
    }

    private function has_voucher($itemgiftid)
    {
        $itemgiftid = (int) $itemgiftid;
        if ($itemgiftid <= 0) {
            return false;
        }

        return $this->db->where('mst_itemgiftid', $itemgiftid)
            ->count_all_results('mst_voucher') > 0;
    }

    public function rules($mode = 'create')
    {
        return [
            [
                'field' => 'itemname',
                'label' => 'Item Name',
                'rules' => 'required|max_length[100]'
            ],
            [
                'field' => 'itemtype',
                'label' => 'Item Type',
                'rules' => 'required|in_list[1,2]'
            ],
            [
                'field' => 'suspended',
                'label' => 'Suspended',
                'rules' => 'required|in_list[0,1]'
            ]
        ];
    }

    public function data_list($page = 1, $per_page = 10, $search = '', $itemtype = '', $suspended = '', $sort_by = 'created_date', $sort_dir = 'DESC')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;

        $this->db->from($this->_table);

        if ($search !== '') {
            $this->db->group_start()
                ->like('LOWER(itemname)', strtolower($search))
                ->or_like('created_by', $search)
                ->group_end();
        }

        if ($itemtype !== '') {
            $this->db->where('itemtype', (int) $itemtype);
        }

        if ($suspended !== '') {
            $this->db->where('suspended', (int) $suspended);
        }

        $total = $this->db->count_all_results('', false);

        $sort_by = trim((string) $sort_by);
        $sort_dir = strtolower(trim((string) $sort_dir));

        $allowed_sort_columns = [
            'mst_itemgiftid' => 'mst_itemgiftid',
            'itemname' => 'itemname',
            'itemtype' => 'itemtype',
            'value' => 'value',
            'suspended' => 'suspended',
            'created_date' => 'created_date',
            'modified_date' => 'modified_date'
        ];

        $sort_column = isset($allowed_sort_columns[$sort_by]) ? $allowed_sort_columns[$sort_by] : 'mst_itemgiftid';
        $sort_dir = $sort_dir === 'asc' ? 'ASC' : 'DESC';

        $this->db->order_by($sort_column, $sort_dir);
        $this->db->limit($per_page, $offset);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Item gift data retrieved successfully',
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

    public function data_list_print($search = '', $itemtype = '', $suspended = '', $sort_by = 'created_date', $sort_dir = 'DESC')
    {

        $this->db->from($this->_table);

        if ($search !== '') {
            $this->db->group_start()
                ->like('LOWER(itemname)', strtolower($search))
                ->or_like('created_by', $search)
                ->group_end();
        }

        if ($itemtype !== '') {
            $this->db->where('itemtype', (int) $itemtype);
        }

        if ($suspended !== '') {
            $this->db->where('suspended', (int) $suspended);
        }

        $total = $this->db->count_all_results('', false);

        $sort_by = trim((string) $sort_by);
        $sort_dir = strtolower(trim((string) $sort_dir));

        $allowed_sort_columns = [
            'mst_itemgiftid' => 'mst_itemgiftid',
            'itemname' => 'itemname',
            'itemtype' => 'itemtype',
            'value' => 'value',
            'suspended' => 'suspended',
            'created_date' => 'created_date',
            'modified_date' => 'modified_date'
        ];

        $sort_column = isset($allowed_sort_columns[$sort_by]) ? $allowed_sort_columns[$sort_by] : 'mst_itemgiftid';
        $sort_dir = $sort_dir === 'asc' ? 'ASC' : 'DESC';

        $this->db->order_by($sort_column, $sort_dir);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Item gift data retrieved successfully',
            'data' => $rows
        ];
    }

    public function data_new(array $input)
    {
        $itemname = trim((string) ($input['itemname'] ?? ''));
        $itemtype = isset($input['itemtype']) ? (int) $input['itemtype'] : 0;
        $suspended = array_key_exists('suspended', $input) ? (int) $input['suspended'] : 0;
        $value = isset($input['value']) && $input['value'] !== '' ? (int) $input['value'] : null;
        $current_user = $this->current_user_id()->username;
        $mst_itemgiftid = $this->Global_Model->get_autoid($this->_table, 'mst_itemgiftid');

        if ($mst_itemgiftid === null) {
            return [
                'success' => false,
                'message' => 'Failed to generate item gift ID'
            ];
        }

        $this->db->where('itemname', $itemname);
        if ($this->db->count_all_results($this->_table) > 0) {
            return [
                'success' => false,
                'message' => 'Item name is already in use'
            ];
        }

        $data = [
            'mst_itemgiftid' => $mst_itemgiftid,
            'itemname' => $itemname,
            'itemtype' => $itemtype,
            'suspended' => $suspended,
            'value' => $value,
            'created_by' => $current_user,
            'created_date' => date('Y-m-d H:i:s')
        ];

        $insert = $this->db->insert($this->_table, $data);

        return [
            'success' => (bool) $insert,
            'message' => $insert ? 'Item gift data created successfully' : 'Failed to create item gift data'
        ];
    }

    public function data_edit($id)
    {
        $item = $this->db->get_where($this->_table, [
            'mst_itemgiftid' => (int) $id
        ])->row();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'Item gift data not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Item gift data retrieved successfully',
            'data' => $item
        ];
    }

    public function data_update($id, array $input)
    {
        $item = $this->db->get_where($this->_table, [
            'mst_itemgiftid' => (int) $id
        ])->row();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'Item gift data not found'
            ];
        }

        $itemname = trim((string) ($input['itemname'] ?? ''));
        $itemtype = isset($input['itemtype']) ? (int) $input['itemtype'] : (int) $item->itemtype;
        $suspended = array_key_exists('suspended', $input) ? (int) $input['suspended'] : (int) $item->suspended;
        $value = array_key_exists('value', $input) ? ($input['value'] !== '' ? (int) $input['value'] : null) : $item->value;
        $current_user = $this->current_user_id()->username;

        $this->db->where('itemname', $itemname);
        $this->db->where('mst_itemgiftid !=', (int) $id);
        if ($this->db->count_all_results($this->_table) > 0) {
            return [
                'success' => false,
                'message' => 'Item name is already in use'
            ];
        }

        $this->db->reset_query();

        $data = [
            'itemname' => $itemname,
            'itemtype' => $itemtype,
            'suspended' => $suspended,
            'value' => $value,
            'modified_by' => $current_user,
            'modified_date' => date('Y-m-d H:i:s')
        ];

        $this->db->where('mst_itemgiftid', (int) $id);
        $update = $this->db->update($this->_table, $data);

        return [
            'success' => (bool) $update,
            'message' => $update ? 'Item gift data updated successfully' : 'Failed to update item gift data'
        ];
    }

    public function data_delete($id)
    {
        $item = $this->db->get_where($this->_table, [
            'mst_itemgiftid' => (int) $id
        ])->row();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'Item gift data not found'
            ];
        }

        if ($this->has_voucher($id)) {
            return [
                'success' => false,
                'message' => 'Item gift already has voucher data and cannot be suspended'
            ];
        }

        $current_user = $this->current_user_id()->username;
        $update = $this->db->update($this->_table, [
            'suspended' => 1,
            'modified_by' => $current_user,
            'modified_date' => date('Y-m-d H:i:s')
        ], [
            'mst_itemgiftid' => (int) $id
        ]);

        return [
            'success' => (bool) $update,
            'message' => $update ? 'Item gift data deleted successfully' : 'Failed to delete item gift data'
        ];
    }

    public function data_suspend($id)
    {
        $item = $this->db->get_where($this->_table, [
            'mst_itemgiftid' => (int) $id
        ])->row();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'Item gift data not found'
            ];
        }

        if ($this->has_voucher($id)) {
            return [
                'success' => false,
                'message' => 'Item gift already has voucher data and cannot be suspended'
            ];
        }

        $current_user = $this->current_user_id()->username;
        $update = $this->db->update($this->_table, [
            'suspended' => 1,
            'modified_by' => $current_user,
            'modified_date' => date('Y-m-d H:i:s')
        ], [
            'mst_itemgiftid' => (int) $id
        ]);

        return [
            'success' => (bool) $update,
            'message' => $update ? 'Item gift suspended successfully' : 'Failed to suspend item gift'
        ];
    }
}
