<?php

class RegionCity_Model extends CI_Model
{
    private $_table = 'mst_reg_city';
    private $_pk = 'mst_reg_cityid';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Global_Model');
    }

    public function rules()
    {
        return [
            [
                'field' => 'mst_reg_provinceid',
                'label' => 'Province',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'city_name',
                'label' => 'City Name',
                'rules' => 'required|trim|max_length[100]'
            ]
        ];
    }

    public function data_list($page = 1, $per_page = 10, $search = '', $sort_by = 'city_name', $sort_dir = 'ASC', $provinceid = '')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;

        $this->db->from($this->_table);

        if ($provinceid !== '') {
            $this->db->where('mst_reg_provinceid', (int) $provinceid);
        }

        if ($search !== '') {
            $this->db->like('city_name', $search);
        }

        $total = $this->db->count_all_results('', false);

        $allowed_sort = [
            'mst_reg_cityid' => 'mst_reg_cityid',
            'city_name' => 'city_name',
            'mst_reg_provinceid' => 'mst_reg_provinceid',
        ];

        $sort_column = isset($allowed_sort[$sort_by]) ? $allowed_sort[$sort_by] : 'city_name';
        $sort_dir = strtolower(trim((string) $sort_dir)) === 'desc' ? 'DESC' : 'ASC';

        $this->db->order_by($sort_column, $sort_dir);
        $this->db->limit($per_page, $offset);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'City data retrieved successfully',
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
            $this->db->like('city_name', $search);
        }

        $this->db->order_by('city_name', 'ASC');
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'City data retrieved successfully',
            'data' => $rows
        ];
    }

    public function data_new(array $input)
    {
        $mst_reg_provinceid = trim((string) ($input['mst_reg_provinceid'] ?? ''));
        $city_name = trim((string) ($input['city_name'] ?? ''));

        if ($mst_reg_provinceid === '') {
            return [
                'success' => false,
                'message' => 'Province is required'
            ];
        }

        if ($city_name === '') {
            return [
                'success' => false,
                'message' => 'City name is required'
            ];
        }

        $mst_reg_cityid = $this->Global_Model->get_autoid_seq('seq_mst_reg_city');
        if ($mst_reg_cityid === null) {
            return [
                'success' => false,
                'message' => 'Failed to generate city ID'
            ];
        }

        $data = [
            'mst_reg_cityid' => $mst_reg_cityid,
            'mst_reg_provinceid' => (int) $mst_reg_provinceid,
            'city_name' => $city_name,
        ];

        $insert = $this->db->insert($this->_table, $data);

        return [
            'success' => (bool) $insert,
            'message' => $insert ? 'City created successfully' : 'Failed to create city'
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
                'message' => 'City not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'City retrieved successfully',
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
                'message' => 'City not found'
            ];
        }

        $mst_reg_provinceid = trim((string) ($input['mst_reg_provinceid'] ?? ''));
        $city_name = trim((string) ($input['city_name'] ?? ''));

        if ($mst_reg_provinceid === '') {
            return [
                'success' => false,
                'message' => 'Province is required'
            ];
        }

        if ($city_name === '') {
            return [
                'success' => false,
                'message' => 'City name is required'
            ];
        }

        $data = [
            'mst_reg_provinceid' => (int) $mst_reg_provinceid,
            'city_name' => $city_name,
        ];

        $this->db->where($this->_pk, (int) $id);
        $update = $this->db->update($this->_table, $data);

        return [
            'success' => (bool) $update,
            'message' => $update ? 'City updated successfully' : 'Failed to update city'
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
                'message' => 'City not found'
            ];
        }

        $this->db->where($this->_pk, (int) $id);
        $delete = $this->db->delete($this->_table);

        return [
            'success' => (bool) $delete,
            'message' => $delete ? 'City deleted successfully' : 'Failed to delete city'
        ];
    }

    public function data_option($search = '')
    {
        $this->db->from($this->_table);

        if ($search !== '') {
            $this->db->like('city_name', $search);
        }

        $this->db->order_by('city_name', 'ASC');
        $rows = $this->db->get()->result();

        $options = [];
        foreach ($rows as $row) {
            $options[] = [
                'value' => $row->mst_reg_cityid,
                'label' => $row->city_name,
            ];
        }

        return [
            'success' => true,
            'data' => $options
        ];
    }
}
