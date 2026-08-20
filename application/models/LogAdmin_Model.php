<?php

class LogAdmin_Model extends CI_Model
{
    private $_table = 'act_log_admin';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Global_Model');
    }

    private function normalize_id($value)
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

    public function data_option_admin()
    {
        $rows = $this->db->select('mst_adminid, username')
            ->from('mst_admin')
            ->where('suspended', 0)
            ->order_by('username', 'ASC')
            ->get()
            ->result();

        foreach ($rows as $row) {
            $row->display_name = !empty($row->username)
                ? $row->username . ' (' . $row->mst_adminid . ')'
                : (string) $row->mst_adminid;
        }

        return [
            'success' => true,
            'message' => 'Admin options retrieved successfully',
            'data' => $rows
        ];
    }

    public function data_option_menu()
    {
        $rows = $this->db->select('set_menuid, parent_set_menuid, name, path, "order" AS sort_order')
            ->from('set_menu')
            ->where('suspended', 0)
            ->order_by('"sort_order"', 'ASC')
            ->get()
            ->result();

        $menus_by_id = [];
        $children_by_parent = [];

        foreach ($rows as $row) {
            $menuid = (int) $row->set_menuid;
            $parent_id = ($row->parent_set_menuid !== null && $row->parent_set_menuid !== '' && (int) $row->parent_set_menuid > 0)
                ? (int) $row->parent_set_menuid
                : null;

            $row->display_name = !empty($row->name)
                ? $row->name . ''
                : (string) $row->set_menuid;

            $row->is_parent = false;
            $row->is_child = $parent_id !== null;

            $menus_by_id[$menuid] = $row;

            if ($parent_id !== null) {
                if (!isset($children_by_parent[$parent_id])) {
                    $children_by_parent[$parent_id] = [];
                }
                $children_by_parent[$parent_id][] = $row;
            }
        }

        $options = [];
        foreach ($rows as $row) {
            $menuid = (int) $row->set_menuid;

            if (isset($children_by_parent[$menuid])) {
                $row->is_parent = true;
                $group = [
                    'label' => $row->display_name,
                    'value' => $menuid,
                    'children' => []
                ];

                foreach ($children_by_parent[$menuid] as $child) {
                    $group['children'][] = [
                        'set_menuid' => (int) $child->set_menuid,
                        'display_name' => $child->display_name,
                        'name' => $child->name,
                        'path' => $child->path,
                        'parent_set_menuid' => $child->parent_set_menuid,
                        'sort_order' => isset($child->sort_order) ? (int) $child->sort_order : 0
                    ];
                }

                $options[] = $group;
                continue;
            }

            if ($row->is_child) {
                continue;
            }

            $options[] = [
                'set_menuid' => $menuid,
                'display_name' => $row->display_name,
                'name' => $row->name,
                'path' => $row->path,
                'parent_set_menuid' => $row->parent_set_menuid,
                'sort_order' => isset($row->sort_order) ? (int) $row->sort_order : 0
            ];
        }

        usort($options, function ($a, $b) {
            $order_a = isset($a['sort_order']) ? (int) $a['sort_order'] : 0;
            $order_b = isset($b['sort_order']) ? (int) $b['sort_order'] : 0;
            $label_a = isset($a['display_name']) ? $a['display_name'] : (isset($a['label']) ? $a['label'] : '');
            $label_b = isset($b['display_name']) ? $b['display_name'] : (isset($b['label']) ? $b['label'] : '');

            if ($order_a !== $order_b) {
                return $order_a <=> $order_b;
            }

            return strcasecmp($label_a, $label_b);
        });

        return [
            'success' => true,
            'message' => 'Menu options retrieved successfully',
            'data' => $options
        ];
    }

    public function data_list($page = 1, $per_page = 10, $search = '', $mst_adminid = '', $set_menuid = '', $action = '', $sort_by = 'created_date', $sort_dir = 'DESC')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;

        $this->db->from($this->_table . ' l');
        $this->db->select('l.*, a.username, m.name AS menu_name, m.path AS menu_path');
        $this->db->join('mst_admin a', 'a.mst_adminid = l.mst_adminid', 'left');
        $this->db->join('set_menu m', 'm.set_menuid = l.set_menuid', 'left');

        if ($search !== '') {
            $this->db->group_start()
                ->like('a.username', $search)
                ->or_like('m.name', $search)
                ->or_like('l.action', $search)
                ->or_like('l.description', $search)
                ->or_like('l.ip_address', $search)
                ->or_like('l.mac', $search)
                ->group_end();
        }

        $this->db->where('l.created_date >=', '2026-05-20 08:29:18');

        $mst_adminid = $this->normalize_id($mst_adminid);
        if ($mst_adminid !== null) {
            $this->db->where('l.mst_adminid', $mst_adminid);
        }

        $set_menuid = $this->normalize_id($set_menuid);
        if ($set_menuid !== null) {
            $this->db->where('l.set_menuid', $set_menuid);
        }

        $action = $this->normalize_text($action);
        if ($action !== '') {
            $this->db->where('l.action', $action);
        }

        $total = $this->db->count_all_results('', false);

        $allowed_sort_columns = [
            'act_log_adminid' => 'l.act_log_adminid',
            'mst_adminid' => 'l.mst_adminid',
            'username' => 'a.username',
            'set_menuid' => 'l.set_menuid',
            'menu_name' => 'm.name',
            'action' => 'l.action',
            'description' => 'l.description',
            'ip_address' => 'l.ip_address',
            'mac' => 'l.mac',
            'created_date' => 'l.created_date'
        ];

        $sort_by = trim((string) $sort_by);
        $sort_dir = strtolower(trim((string) $sort_dir)) === 'asc' ? 'ASC' : 'DESC';
        $sort_column = isset($allowed_sort_columns[$sort_by]) ? $allowed_sort_columns[$sort_by] : 'l.created_date';

        $this->db->order_by($sort_column, $sort_dir);
        $this->db->limit($per_page, $offset);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Admin log data retrieved successfully',
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

    public function data_list_print($search = '', $mst_adminid = '', $set_menuid = '', $action = '', $sort_by = 'created_date', $sort_dir = 'DESC')
    {
        $this->db->from($this->_table . ' l');
        $this->db->select('l.*, a.username, m.name AS menu_name, m.path AS menu_path');
        $this->db->join('mst_admin a', 'a.mst_adminid = l.mst_adminid', 'left');
        $this->db->join('set_menu m', 'm.set_menuid = l.set_menuid', 'left');

        if ($search !== '') {
            $this->db->group_start()
                ->like('a.username', $search)
                ->or_like('m.name', $search)
                ->or_like('l.action', $search)
                ->or_like('l.description', $search)
                ->or_like('l.ip_address', $search)
                ->or_like('l.mac', $search)
                ->group_end();
        }

        $this->db->where('l.created_date >=', '2026-05-20 08:29:18');
        
        $mst_adminid = $this->normalize_id($mst_adminid);
        if ($mst_adminid !== null) {
            $this->db->where('l.mst_adminid', $mst_adminid);
        }

        $set_menuid = $this->normalize_id($set_menuid);
        if ($set_menuid !== null) {
            $this->db->where('l.set_menuid', $set_menuid);
        }

        $action = $this->normalize_text($action);
        if ($action !== '') {
            $this->db->where('l.action', $action);
        }

        $allowed_sort_columns = [
            'act_log_adminid' => 'l.act_log_adminid',
            'mst_adminid' => 'l.mst_adminid',
            'username' => 'a.username',
            'set_menuid' => 'l.set_menuid',
            'menu_name' => 'm.name',
            'action' => 'l.action',
            'description' => 'l.description',
            'ip_address' => 'l.ip_address',
            'mac' => 'l.mac',
            'created_date' => 'l.created_date'
        ];

        $sort_by = trim((string) $sort_by);
        $sort_dir = strtolower(trim((string) $sort_dir)) === 'asc' ? 'ASC' : 'DESC';
        $sort_column = isset($allowed_sort_columns[$sort_by]) ? $allowed_sort_columns[$sort_by] : 'l.created_date';

        $this->db->order_by($sort_column, $sort_dir);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Admin log data retrieved successfully',
            'data' => $rows
        ];
    }

    public function data_new(array $input)
    {
        $act_log_adminid = $this->Global_Model->get_autoid_seq('seq_act_log_admin');
        $mst_adminid = $this->normalize_id($input['mst_adminid'] ?? null);
        $set_menuid = $this->normalize_id($input['set_menuid'] ?? null);
        $action = $this->normalize_text($input['action'] ?? '');
        $description = $this->normalize_text($input['description'] ?? '');
        $ip_address = $this->normalize_text($input['ip_address'] ?? '');
        $ua = $this->normalize_text($input['ua'] ?? '');
        $mac = $this->normalize_text($input['mac'] ?? '');

        if ($act_log_adminid === null) {
            return [
                'success' => false,
                'message' => 'Failed to generate log ID'
            ];
        }

        if ($mst_adminid === null) {
            return [
                'success' => false,
                'message' => 'Admin ID is required'
            ];
        }

        if ($set_menuid === null) {
            return [
                'success' => false,
                'message' => 'Menu ID is required'
            ];
        }

        if ($action === '') {
            return [
                'success' => false,
                'message' => 'Action is required'
            ];
        }

        $data = [
            'act_log_adminid' => $act_log_adminid,
            'mst_adminid' => $mst_adminid,
            'set_menuid' => $set_menuid,
            'action' => $action,
            'description' => $description,
            'created_date' => date('Y-m-d H:i:s'),
            'ip_address' => $ip_address,
            'ua' => $ua,
            'mac' => $mac
        ];

        $insert = $this->db->insert($this->_table, $data);

        return [
            'success' => (bool) $insert,
            'message' => $insert ? 'Admin log created successfully' : 'Failed to create admin log'
        ];
    }

    public function data_edit($id)
    {
        $item = $this->db->select('l.*, a.username, m.name AS menu_name, m.path AS menu_path')
            ->from($this->_table . ' l')
            ->join('mst_admin a', 'a.mst_adminid = l.mst_adminid', 'left')
            ->join('set_menu m', 'm.set_menuid = l.set_menuid', 'left')
            ->where('l.act_log_adminid', (int) $id)
            ->get()
            ->row();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'Admin log data not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Admin log data retrieved successfully',
            'data' => $item
        ];
    }

    public function data_delete($id)
    {
        $item = $this->db->get_where($this->_table, [
            'act_log_adminid' => (int) $id
        ])->row();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'Admin log data not found'
            ];
        }

        $delete = $this->db->delete($this->_table, [
            'act_log_adminid' => (int) $id
        ]);

        return [
            'success' => (bool) $delete,
            'message' => $delete ? 'Admin log deleted successfully' : 'Failed to delete admin log'
        ];
    }
}
