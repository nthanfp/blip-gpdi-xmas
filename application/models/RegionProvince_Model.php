<?php

class RegionProvince_Model extends CI_Model
{
    private $_table = 'mst_reg_province';
    private $_pk = 'mst_reg_provinceid';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Global_Model');
    }

    public function rules()
    {
        return [
            [
                'field' => 'province_name',
                'label' => 'Province Name',
                'rules' => 'required|trim|max_length[100]'
            ]
        ];
    }

    public function data_list($page = 1, $per_page = 10, $search = '', $sort_by = 'province_name', $sort_dir = 'ASC')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;

        $this->db->from($this->_table);

        if ($search !== '') {
            $this->db->like('province_name', $search);
        }

        $total = $this->db->count_all_results('', false);

        $allowed_sort = [
            'mst_reg_provinceid' => 'mst_reg_provinceid',
            'province_name' => 'province_name',
        ];

        $sort_column = isset($allowed_sort[$sort_by]) ? $allowed_sort[$sort_by] : 'province_name';
        $sort_dir = strtolower(trim((string) $sort_dir)) === 'desc' ? 'DESC' : 'ASC';

        $this->db->order_by($sort_column, $sort_dir);
        $this->db->limit($per_page, $offset);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Province data retrieved successfully',
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

    public function data_list_all($search = '')
    {
        $this->db->from($this->_table);

        if ($search !== '') {
            $this->db->like('province_name', $search);
        }

        $this->db->order_by('province_name', 'ASC');
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Province data retrieved successfully',
            'data' => $rows
        ];
    }

    public function data_new(array $input)
    {
        $province_name = trim((string) ($input['province_name'] ?? ''));

        if ($province_name === '') {
            return [
                'success' => false,
                'message' => 'Province name is required'
            ];
        }

        $mst_reg_provinceid = $this->Global_Model->get_autoid_seq('seq_mst_reg_province');
        if ($mst_reg_provinceid === null) {
            return [
                'success' => false,
                'message' => 'Failed to generate province ID'
            ];
        }

        $data = [
            'mst_reg_provinceid' => $mst_reg_provinceid,
            'province_name' => $province_name,
        ];

        $insert = $this->db->insert($this->_table, $data);

        return [
            'success' => (bool) $insert,
            'message' => $insert ? 'Province created successfully' : 'Failed to create province'
        ];
    }

    public function data_edit($id)
    {
        $row = $this->db->get_where($this->_table, [
            $this->_pk => (int) $id
        ])->row();

        if (!$row) {
            return [
                'success' => false,
                'message' => 'Province not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Province retrieved successfully',
            'data' => $row
        ];
    }

    public function data_update($id, array $input)
    {
        $row = $this->db->get_where($this->_table, [
            $this->_pk => (int) $id
        ])->row();

        if (!$row) {
            return [
                'success' => false,
                'message' => 'Province not found'
            ];
        }

        $province_name = trim((string) ($input['province_name'] ?? ''));

        if ($province_name === '') {
            return [
                'success' => false,
                'message' => 'Province name is required'
            ];
        }

        $data = [
            'province_name' => $province_name,
        ];

        $this->db->where($this->_pk, (int) $id);
        $update = $this->db->update($this->_table, $data);

        return [
            'success' => (bool) $update,
            'message' => $update ? 'Province updated successfully' : 'Failed to update province'
        ];
    }

    public function data_delete($id)
    {
        $row = $this->db->get_where($this->_table, [
            $this->_pk => (int) $id
        ])->row();

        if (!$row) {
            return [
                'success' => false,
                'message' => 'Province not found'
            ];
        }

        $this->db->where($this->_pk, (int) $id);
        $delete = $this->db->delete($this->_table);

        return [
            'success' => (bool) $delete,
            'message' => $delete ? 'Province deleted successfully' : 'Failed to delete province'
        ];
    }

    public function data_option($search = '')
    {
        $this->db->from($this->_table);

        if ($search !== '') {
            $this->db->like('province_name', $search);
        }

        $this->db->order_by('province_name', 'ASC');
        $rows = $this->db->get()->result();

        $options = [];
        foreach ($rows as $row) {
            $options[] = [
                'value' => $row->mst_reg_provinceid,
                'label' => $row->province_name,
            ];
        }

        return [
            'success' => true,
            'data' => $options
        ];
    }
}
