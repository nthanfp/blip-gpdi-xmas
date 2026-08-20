<?php

class Setmenu_Model extends CI_Model
{
    private $_table = 'set_menu';

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

    private function normalize_menuid($menuid)
    {
        if ($menuid === '' || $menuid === null) {
            return null;
        }

        if (is_array($menuid)) {
            return null;
        }

        $menuid = trim((string) $menuid);

        if ($menuid === '' || !ctype_digit($menuid)) {
            return null;
        }

        return (int) $menuid;
    }

    public function rules($mode = 'create')
    {
        return [
            [
                'field' => 'name',
                'label' => 'Menu Name',
                'rules' => 'required|max_length[30]'
            ],
            [
                'field' => 'path',
                'label' => 'Path',
                'rules' => 'required|max_length[30]'
            ],
            [
                'field' => 'order',
                'label' => 'Order',
                'rules' => 'required|integer'
            ],
            [
                'field' => 'icon',
                'label' => 'Icon',
                'rules' => 'required|max_length[100]'
            ]
        ];
    }

    public function data_list($page = 1, $per_page = 10, $search = '', $parentmenu = '', $suspended = '')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;

        $this->db->from($this->_table);

        if ($search !== '') {
            $this->db->group_start()
                ->like('name', $search)
                ->or_like('path', $search)
                ->or_like('icon', $search)
                ->group_end();
        }

        if ($parentmenu !== '') {
            $this->db->where('parent_set_menuid', (int) $parentmenu);
        }

        if ($suspended !== '') {
            $this->db->where('suspended', (int) $suspended);
        }

        $total = $this->db->count_all_results('', false);

        $this->db->order_by('"order"', 'ASC');
        $this->db->order_by('set_menuid', 'ASC');
        $this->db->limit($per_page, $offset);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Setmenu data retrieved successfully',
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
        $parent_set_menuid = array_key_exists('parent_set_menuid', $input) && $input['parent_set_menuid'] !== '' && $input['parent_set_menuid'] !== null
            ? (int) $input['parent_set_menuid']
            : null;
        $name = trim((string) ($input['name'] ?? ''));
        $path = trim((string) ($input['path'] ?? ''));
        $order = array_key_exists('order', $input) && $input['order'] !== '' && $input['order'] !== null ? (int) $input['order'] : 0;
        $icon = trim((string) ($input['icon'] ?? ''));
        $suspended = array_key_exists('suspended', $input) ? (int) $input['suspended'] : 0;
        $set_menuid = $this->Global_Model->get_autoid($this->_table, 'set_menuid');

        if ($set_menuid === null) {
            return [
                'success' => false,
                'message' => 'Failed to generate menu ID'
            ];
        }

        $this->db->where('name', $name);
        if ($this->db->count_all_results($this->_table) > 0) {
            return [
                'success' => false,
                'message' => 'Menu name is already in use'
            ];
        }

        $data = [
            'set_menuid' => $set_menuid,
            'parent_set_menuid' => $parent_set_menuid,
            'name' => $name,
            'path' => $path,
            'order' => $order,
            'icon' => $icon,
            'suspended' => $suspended
        ];

        $insert = $this->db->insert($this->_table, $data);

        return [
            'success' => (bool) $insert,
            'message' => $insert ? 'Menu data created successfully' : 'Failed to create menu data'
        ];
    }

    public function data_edit($id)
    {
        $item = $this->db->get_where($this->_table, [
            'set_menuid' => (int) $id
        ])->row();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'Menu data not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Menu data retrieved successfully',
            'data' => $item
        ];
    }

    public function data_update($id, array $input)
    {
        $item = $this->db->get_where($this->_table, [
            'set_menuid' => (int) $id
        ])->row();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'Menu data not found'
            ];
        }

        $name = trim((string) ($input['name'] ?? ''));
        $path = trim((string) ($input['path'] ?? ''));
        $order = array_key_exists('order', $input) && $input['order'] !== '' && $input['order'] !== null ? (int) $input['order'] : (int) ($item->order ?? 0);
        $icon = trim((string) ($input['icon'] ?? ($item->icon ?? '')));
        $parent_set_menuid = array_key_exists('parent_set_menuid', $input) && $input['parent_set_menuid'] !== '' && $input['parent_set_menuid'] !== null
            ? (int) $input['parent_set_menuid']
            : null;
        $suspended = array_key_exists('suspended', $input) ? (int) $input['suspended'] : 0;

        $this->db->where('name', $name);
        $this->db->where('set_menuid !=', (int) $id);
        if ($this->db->count_all_results($this->_table) > 0) {
            return [
                'success' => false,
                'message' => 'Menu name is already in use'
            ];
        }

        $data = [
            'set_menuid' => $id,
            'parent_set_menuid' => $parent_set_menuid,
            'name' => $name,
            'path' => $path,
            'order' => $order,
            'icon' => $icon,
            'suspended' => $suspended
        ];

        $this->db->where('set_menuid', (int) $id);
        $update = $this->db->update($this->_table, $data);

        return [
            'success' => (bool) $update,
            'message' => $update ? 'Menu data updated successfully' : 'Failed to update Menu data'
        ];
    }

    public function data_delete($id)
    {
        $item = $this->db->get_where($this->_table, [
            'set_menuid' => (int) $id
        ])->row();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'Menu data not found'
            ];
        }

        $assigned = $this->db->where('set_menuid', (int) $id)
            ->count_all_results('set_menu_admin');

        if ($assigned > 0) {
            return [
                'success' => false,
                'message' => 'Cannot delete menu — it is assigned to ' . $assigned . ' user(s). Remove all user assignments first.'
            ];
        }

        $child_ids = $this->db->select('set_menuid')
            ->from($this->_table)
            ->where('parent_set_menuid', (int) $id)
            ->get()
            ->result();

        if (!empty($child_ids)) {
            $ids = array_map(function($r) { return (int) $r->set_menuid; }, $child_ids);
            $this->db->where_in('set_menuid', $ids);
            $child_assigned = $this->db->count_all_results('set_menu_admin');

            if ($child_assigned > 0) {
                return [
                    'success' => false,
                    'message' => 'Cannot delete menu — it has child menus assigned to ' . $child_assigned . ' user(s). Remove all child user assignments first.'
                ];
            }
        }

        $update = $this->db->update($this->_table, [
            'suspended' => 1
        ], [
            'set_menuid' => (int) $id
        ]);

        return [
            'success' => (bool) $update,
            'message' => $update ? 'Menu data deleted successfully' : 'Failed to delete Menu data'
        ];
    }

    public function data_option_parent()
    {
        $rows = $this->db->select('set_menuid, name, path, "order" AS sort_order, icon')
            ->from($this->_table)
            ->where('suspended', 0)
            ->order_by('"order"', 'ASC')
            ->order_by('name', 'ASC')
            ->get()
            ->result();

        return [
            'success' => true,
            'message' => 'Parent options retrieved successfully',
            'data' => $rows
        ];
    }

    public function data_option($exclude_set_menuid = null)
    {
        $exclude_set_menuid = $this->normalize_menuid($exclude_set_menuid);

        $rows = $this->db->select('set_menuid, parent_set_menuid, name, path, "order" AS sort_order')
            ->from($this->_table)
            ->where('suspended', 0)
            ->order_by('"order"', 'ASC')
            ->order_by('name', 'ASC')
            ->get()
            ->result();

        $children_map = [];
        foreach ($rows as $row) {
            $menuid = (int) $row->set_menuid;
            $parent_id = ($row->parent_set_menuid !== null && $row->parent_set_menuid !== '' && (int) $row->parent_set_menuid > 0)
                ? (int) $row->parent_set_menuid
                : null;

            $parent_key = $parent_id === null ? 'null' : (string) $parent_id;
            if (!isset($children_map[$parent_key])) {
                $children_map[$parent_key] = [];
            }
            $children_map[$parent_key][] = $menuid;
        }

        $nodes = [];
        foreach ($rows as $row) {
            $nodes[(int) $row->set_menuid] = $row;
        }

        $menus = [];
        $this->flatten_menu_tree($nodes, $children_map, null, 0, $menus, $exclude_set_menuid);

        return [
            'success' => true,
            'message' => 'Menu options retrieved successfully',
            'data' => $menus
        ];
    }

    private function flatten_menu_tree(&$nodes, &$children_map, $parent_id, $depth, &$result, $exclude_set_menuid = null)
    {
        $parent_key = $parent_id === null ? 'null' : (string) $parent_id;
        $child_ids = isset($children_map[$parent_key]) ? $children_map[$parent_key] : [];

        foreach ($child_ids as $child_id) {
            if (!isset($nodes[$child_id])) {
                continue;
            }

            $exclude = $exclude_set_menuid !== null && $child_id === $exclude_set_menuid;
            if (!$exclude) {
                $row = $nodes[$child_id];
                $row->depth = $depth;
                $result[] = $row;
            }

            $this->flatten_menu_tree($nodes, $children_map, $child_id, $depth + 1, $result, $exclude_set_menuid);
        }
    }

    public function get_menuid_by_path($path)
    {
        $path = trim((string) $path);

        if ($path === '') {
            return null;
        }

        $row = $this->db->select('set_menuid')
            ->from($this->_table)
            ->where('path', $path)
            ->where('suspended', 0)
            ->get()
            ->row();

        return $row ? (int) $row->set_menuid : null;
    }

    public function check_menu($menuid, $subperm = null){
        $menuid = $this->normalize_menuid($menuid);
        $current_user_id = $this->current_user_id();

        if ($menuid === null || $current_user_id === null) {
            return [
                'success' => false,
                'allowed' => false,
                'message' => 'Menu access check failed'
            ];
        }

        $row = $this->db->get_where('set_menu_admin', [
            'set_menuid' => $menuid,
            'mst_adminid' => $current_user_id
        ])->row();

        $allowed = (bool) $row;
        if ($row && $subperm !== null) {
            $subperm = strtolower(trim((string) $subperm));
            $allowed = in_array($subperm, ['view', 'new', 'update', 'delete', 'print', 'export'])
                ? (intval($row->$subperm ?? 1) === 1)
                : (bool) $row;
        }

        return [
            'success' => true,
            'allowed' => $allowed,
            'message' => $allowed ? 'Menu access granted' : 'Menu access denied',
            'data' => [
                'set_menuid' => $menuid,
                'mst_adminid' => $current_user_id
            ]
        ];
    }

    private function build_sidebar_branch(array $nodes, array $children_map, array $allowed_map, $parent_id = null)
    {
        $branch = [];
        $parent_key = $parent_id === null ? 'null' : (string) (int) $parent_id;
        $child_ids = isset($children_map[$parent_key]) ? $children_map[$parent_key] : [];

        foreach ($child_ids as $child_id) {
            if (!isset($nodes[$child_id])) {
                continue;
            }

            $children = $this->build_sidebar_branch($nodes, $children_map, $allowed_map, $child_id);
            $is_allowed = isset($allowed_map[$child_id]);

            if (!$is_allowed && empty($children)) {
                continue;
            }

            $node = $nodes[$child_id];
            $node['children'] = $children;
            $node['has_children'] = !empty($children);
            $node['is_allowed'] = $is_allowed;
            $branch[] = $node;
        }

        usort($branch, function ($a, $b) {
            $order_a = isset($a['sort_order']) ? (int) $a['sort_order'] : 0;
            $order_b = isset($b['sort_order']) ? (int) $b['sort_order'] : 0;

            if ($order_a !== $order_b) {
                return $order_a <=> $order_b;
            }

            return strcasecmp($a['name'], $b['name']);
        });

        return $branch;
    }

    public function get_sidebar_menu_tree()
    {
        $current_user_id = $this->current_user_id();

        if ($current_user_id === null) {
            return [];
        }

        $allowed_rows = $this->db->select('b.set_menuid, b.parent_set_menuid, b.name, b.path, b."order" AS sort_order, b.icon')
            ->from('set_menu_admin a')
            ->join('set_menu b', 'b.set_menuid = a.set_menuid', 'inner')
            ->where('a.mst_adminid', (int) $current_user_id)
            ->where('b.suspended', 0)
            ->where("COALESCE(a.view, 1) = 1", null, false)
            ->order_by('b.parent_set_menuid', 'ASC')
            ->order_by('b."order"', 'ASC')
            ->order_by('b.name', 'ASC')
            ->get()
            ->result();

        if (!$allowed_rows) {
            return [];
        }

        $all_rows = $this->db->select('set_menuid, parent_set_menuid, name, path, "order" AS sort_order, icon')
            ->from($this->_table)
            ->where('suspended', 0)
            ->order_by('parent_set_menuid', 'ASC')
            ->order_by('"order"', 'ASC')
            ->order_by('name', 'ASC')
            ->get()
            ->result();

        $nodes = [];
        $children_map = [];
        foreach ($all_rows as $row) {
            $menuid = (int) $row->set_menuid;
            $parent_id = $this->normalize_menuid($row->parent_set_menuid);

            $nodes[$menuid] = [
                'set_menuid' => $menuid,
                'parent_set_menuid' => $parent_id,
                'name' => $row->name,
                'path' => $row->path,
                'sort_order' => isset($row->sort_order) ? (int) $row->sort_order : 0,
                'icon' => isset($row->icon) ? $row->icon : '',
                'children' => [],
                'has_children' => false,
                'is_allowed' => false
            ];

            $parent_key = $parent_id === null ? 'null' : (string) $parent_id;
            if (!isset($children_map[$parent_key])) {
                $children_map[$parent_key] = [];
            }
            $children_map[$parent_key][] = $menuid;
        }

        $allowed_map = [];
        foreach ($allowed_rows as $row) {
            $allowed_map[(int) $row->set_menuid] = true;
        }

        return $this->build_sidebar_branch($nodes, $children_map, $allowed_map, null);
    }
}
