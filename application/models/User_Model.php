<?php

class User_Model extends CI_Model
{
    private $_table = 'mst_admin';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Global_Model');
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

    private function normalize_permissions($raw)
    {
        if (!is_array($raw)) {
            return [];
        }

        $result = [];
        foreach ($raw as $item) {
            if (!is_array($item)) {
                continue;
            }

            $menuid = isset($item['set_menuid']) ? (int) $item['set_menuid'] : 0;
            if ($menuid <= 0) {
                continue;
            }

            $p = [
                'set_menuid' => $menuid,
                'view'   => !empty($item['view']) ? 1 : 0,
                'new'    => !empty($item['new']) ? 1 : 0,
                'update' => !empty($item['update']) ? 1 : 0,
                'delete' => !empty($item['delete']) ? 1 : 0,
                'print'  => !empty($item['print']) ? 1 : 0,
                'export' => !empty($item['export']) ? 1 : 0,
            ];

            if ($p['view'] + $p['new'] + $p['update'] + $p['delete'] + $p['print'] + $p['export'] === 0) {
                continue;
            }

            $result[] = $p;
        }

        return $result;
    }

    private function sync_permissions($adminid, array $permissions)
    {
        $adminid = (int) $adminid;
        $permissions = $this->normalize_permissions($permissions);

        $this->db->delete('set_menu_admin', [
            'mst_adminid' => $adminid
        ]);

        if (empty($permissions)) {
            return true;
        }

        $rows = [];
        foreach ($permissions as $p) {
            $rows[] = [
                'mst_adminid' => $adminid,
                'set_menuid'  => $p['set_menuid'],
                'view'        => $p['view'],
                'new'         => $p['new'],
                'update'      => $p['update'],
                'delete'      => $p['delete'],
                'print'       => $p['print'],
                'export'      => $p['export'],
            ];
        }

        return $this->db->insert_batch('set_menu_admin', $rows);
    }

    private function get_permissions($adminid)
    {
        $adminid = (int) $adminid;

        $rows = $this->db->select('set_menuid, view, new, update, delete, print, export')
            ->from('set_menu_admin')
            ->where('mst_adminid', $adminid)
            ->get()
            ->result();

        $permissions = [];
        foreach ($rows as $row) {
            $permissions[(int) $row->set_menuid] = [
                'view'   => (int) ($row->view ?? 1),
                'new'    => (int) ($row->new ?? 1),
                'update' => (int) ($row->update ?? 1),
                'delete' => (int) ($row->delete ?? 1),
                'print'  => (int) ($row->print ?? 1),
                'export' => (int) ($row->export ?? 1),
            ];
        }

        return $permissions;
    }

    public function rules($mode = 'create')
    {
        $rules = [
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|max_length[30]'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'valid_email|max_length[50]'
            ]
        ];

        if ($mode === 'create') {
            $rules[] = [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|max_length[200]'
            ];
        } else {
            $rules[] = [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'max_length[200]'
            ];
        }

        return $rules;
    }

    public function data_list($page = 1, $per_page = 10, $search = '', $suspended = '', $sort_by = 'mst_adminid', $sort_dir = 'DESC')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;

        $this->db->from($this->_table);

        if ($search !== '') {
            $this->db->group_start()
                ->like('username', $search)
                ->or_like('created_by', $search)
                ->group_end();
        }

        if ($suspended !== '') {
            $this->db->where('suspended', (int) $suspended);
        }

        $total = $this->db->count_all_results('', false);

        $sort_by = trim((string) $sort_by);
        $sort_dir = strtolower(trim((string) $sort_dir));

        $allowed_sort_columns = [
            'mst_adminid' => 'mst_adminid',
            'username' => 'username',
            'email' => 'email',
            'suspended' => 'suspended',
            'created_date' => 'created_date',
            'modified_date' => 'modified_date'
        ];

        $sort_column = isset($allowed_sort_columns[$sort_by]) ? $allowed_sort_columns[$sort_by] : 'mst_adminid';
        $sort_dir = $sort_dir === 'asc' ? 'ASC' : 'DESC';

        $this->db->order_by($sort_column, $sort_dir);
        $this->db->limit($per_page, $offset);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'User data retrieved successfully',
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

    public function data_list_print($search = '', $suspended = '', $sort_by = 'mst_adminid', $sort_dir = 'DESC'){
        $this->db->from($this->_table);

        if ($search !== '') {
            $this->db->group_start()
                ->like('username', $search)
                ->or_like('created_by', $search)
                ->group_end();
        }

        if ($suspended !== '') {
            $this->db->where('suspended', (int) $suspended);
        }

        $allowed_sort_columns = [
            'mst_adminid' => 'mst_adminid',
            'username' => 'username',
            'email' => 'email',
            'suspended' => 'suspended',
            'created_date' => 'created_date',
            'modified_date' => 'modified_date'
        ];

        $sort_column = isset($allowed_sort_columns[$sort_by]) ? $allowed_sort_columns[$sort_by] : 'mst_adminid';
        $sort_dir = strtolower(trim((string) $sort_dir)) === 'asc' ? 'ASC' : 'DESC';

        $this->db->order_by($sort_column, $sort_dir);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'User data retrieved successfully',
            'data' => $rows
        ];
    }

    public function data_new(array $input)
    {
        $username = trim((string) ($input['username'] ?? ''));
        $email = trim((string) ($input['email'] ?? ''));
        $password = (string) ($input['password'] ?? '');
        $suspended = array_key_exists('suspended', $input) ? (int) $input['suspended'] : 0;
        $permissions = $this->normalize_permissions($input['permissions'] ?? []);
        $current_user = $this->current_user_id()->username;
        $mst_adminid = $this->Global_Model->get_autoid_seq('seq_mst_admin');

        if ($mst_adminid === null) {
            return [
                'success' => false,
                'message' => 'Failed to generate user ID'
            ];
        }

        $this->db->where('username', $username);
        if ($this->db->count_all_results($this->_table) > 0) {
            return [
                'success' => false,
                'message' => 'Username is already in use'
            ];
        }

        $data = [
            'mst_adminid' => $mst_adminid,
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'suspended' => $suspended,
            'created_by' => $current_user,
            'created_date' => date('Y-m-d H:i:s')
        ];

        $this->db->trans_begin();
        $insert = $this->db->insert($this->_table, $data);
        $permissions_ok = true;
        if ($insert) {
            $permissions_ok = $this->sync_permissions($mst_adminid, $permissions);
        }

        if ($insert === false || $permissions_ok === false || $this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return [
                'success' => false,
                'message' => 'Failed to create user data'
            ];
        }

        $this->db->trans_commit();

        return [
            'success' => (bool) $insert,
            'message' => $insert ? 'User data created successfully' : 'Failed to create user data'
        ];
    }

    public function data_edit($id)
    {
        $user = $this->db->get_where($this->_table, [
            'mst_adminid' => (int) $id
        ])->row();

        if (!$user) {
            return [
                'success' => false,
                'message' => 'User data not found'
            ];
        }

        $permissions = $this->get_permissions($user->mst_adminid);
        $user->password = '';

        return [
            'success' => true,
            'message' => 'User data retrieved successfully',
            'data' => $user,
            'permissions' => $permissions
        ];
    }

    public function data_update($id, array $input)
    {
        $user = $this->db->get_where($this->_table, [
            'mst_adminid' => (int) $id
        ])->row();

        if (!$user) {
            return [
                'success' => false,
                'message' => 'User data not found'
            ];
        }

        $username = trim((string) ($input['username'] ?? ''));
        $email = trim((string) ($input['email'] ?? ''));
        $password = (string) ($input['password'] ?? '');
        $suspended = array_key_exists('suspended', $input) ? (int) $input['suspended'] : (int) $user->suspended;
        $permissions = $this->normalize_permissions($input['permissions'] ?? []);
        $current_user = $this->current_user_id()->username;

        $this->db->where('username', $username);
        $this->db->where('mst_adminid !=', (int) $id);
        if ($this->db->count_all_results($this->_table) > 0) {
            return [
                'success' => false,
                'message' => 'Username is already in use'
            ];
        }

        $data = [
            'username' => $username,
            'email' => $email,
            'suspended' => $suspended,
            'modified_by' => $current_user,
            'modified_date' => date('Y-m-d H:i:s')
        ];

        if ($password !== '') {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->db->trans_begin();
        $this->db->where('mst_adminid', (int) $id);
        $update = $this->db->update($this->_table, $data);

        $permissions_ok = true;
        if ($update) {
            $permissions_ok = $this->sync_permissions($id, $permissions);
        }

        if ($update === false || $permissions_ok === false || $this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return [
                'success' => false,
                'message' => 'Failed to update user data'
            ];
        }

        $this->db->trans_commit();

        return [
            'success' => (bool) $update,
            'message' => $update ? 'User data updated successfully' : 'Failed to update user data'
        ];
    }

    public function data_delete($id)
    {
        $user = $this->db->get_where($this->_table, [
            'mst_adminid' => (int) $id
        ])->row();

        if (!$user) {
            return [
                'success' => false,
                'message' => 'User data not found'
            ];
        }

        $current_user = $this->current_user_id()->username;
        $update = $this->db->update($this->_table, [
            'suspended' => 1,
            'modified_by' => $current_user,
            'modified_date' => date('Y-m-d H:i:s')
        ], [
            'mst_adminid' => (int) $id
        ]);

        return [
            'success' => (bool) $update,
            'message' => $update ? 'User data deleted successfully' : 'Failed to delete user data'
        ];
    }
}
