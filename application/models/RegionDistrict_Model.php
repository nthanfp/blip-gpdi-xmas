<?php

class RegionDistrict_Model extends CI_Model
{
    private $_table = 'mst_reg_district';
    private $_pk = 'mst_reg_districtid';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Global_Model');
    }

    public function rules()
    {
        return [
            [
                'field' => 'mst_reg_cityid',
                'label' => 'City',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'district_name',
                'label' => 'District Name',
                'rules' => 'required|trim|max_length[100]'
            ]
        ];
    }

    public function data_list($page = 1, $per_page = 10, $search = '', $sort_by = 'district_name', $sort_dir = 'ASC', $cityid = '', $provinceid = '')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;

        $this->db->from($this->_table . ' d');

        if ($provinceid !== '') {
            $this->db->join('mst_reg_city c', 'c.mst_reg_cityid = d.mst_reg_cityid', 'left');
            $this->db->where('c.mst_reg_provinceid', (int) $provinceid);
        }

        if ($cityid !== '') {
            $this->db->where('d.mst_reg_cityid', (int) $cityid);
        }

        if ($search !== '') {
            $this->db->like('d.district_name', $search);
        }

        $total = $this->db->count_all_results('', false);

        $allowed_sort = [
            'mst_reg_districtid' => 'd.mst_reg_districtid',
            'district_name' => 'd.district_name',
            'mst_reg_cityid' => 'd.mst_reg_cityid',
        ];

        $sort_column = isset($allowed_sort[$sort_by]) ? $allowed_sort[$sort_by] : 'district_name';
        $sort_dir = strtolower(trim((string) $sort_dir)) === 'desc' ? 'DESC' : 'ASC';

        $this->db->order_by($sort_column, $sort_dir);
        $this->db->limit($per_page, $offset);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'District data retrieved successfully',
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
            $this->db->like('district_name', $search);
        }

        $this->db->order_by('district_name', 'ASC');
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'District data retrieved successfully',
            'data' => $rows
        ];
    }

    public function data_new(array $input)
    {
        $mst_reg_cityid = trim((string) ($input['mst_reg_cityid'] ?? ''));
        $district_name = trim((string) ($input['district_name'] ?? ''));

        if ($mst_reg_cityid === '') {
            return [
                'success' => false,
                'message' => 'City is required'
            ];
        }

        if ($district_name === '') {
            return [
                'success' => false,
                'message' => 'District name is required'
            ];
        }

        $mst_reg_districtid = $this->Global_Model->get_autoid_seq('seq_mst_reg_district');
        if ($mst_reg_districtid === null) {
            return [
                'success' => false,
                'message' => 'Failed to generate district ID'
            ];
        }

        $data = [
            'mst_reg_districtid' => $mst_reg_districtid,
            'mst_reg_cityid' => (int) $mst_reg_cityid,
            'district_name' => $district_name,
        ];

        $insert = $this->db->insert($this->_table, $data);

        return [
            'success' => (bool) $insert,
            'message' => $insert ? 'District created successfully' : 'Failed to create district'
        ];
    }

    public function data_edit($id)
    {
        $row = $this->db
            ->select('d.*, c.mst_reg_provinceid')
            ->from($this->_table . ' d')
            ->join('mst_reg_city c', 'c.mst_reg_cityid = d.mst_reg_cityid', 'left')
            ->where('d.' . $this->_pk, (int) $id)
            ->get()
            ->row();

        if (!$row) {
            return [
                'success' => false,
                'message' => 'District not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'District retrieved successfully',
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
                'message' => 'District not found'
            ];
        }

        $mst_reg_cityid = trim((string) ($input['mst_reg_cityid'] ?? ''));
        $district_name = trim((string) ($input['district_name'] ?? ''));

        if ($mst_reg_cityid === '') {
            return [
                'success' => false,
                'message' => 'City is required'
            ];
        }

        if ($district_name === '') {
            return [
                'success' => false,
                'message' => 'District name is required'
            ];
        }

        $data = [
            'mst_reg_cityid' => (int) $mst_reg_cityid,
            'district_name' => $district_name,
        ];

        $this->db->where($this->_pk, (int) $id);
        $update = $this->db->update($this->_table, $data);

        return [
            'success' => (bool) $update,
            'message' => $update ? 'District updated successfully' : 'Failed to update district'
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
                'message' => 'District not found'
            ];
        }

        $this->db->where($this->_pk, (int) $id);
        $delete = $this->db->delete($this->_table);

        return [
            'success' => (bool) $delete,
            'message' => $delete ? 'District deleted successfully' : 'Failed to delete district'
        ];
    }

    public function data_option($search = '')
    {
        $this->db->from($this->_table);

        if ($search !== '') {
            $this->db->like('district_name', $search);
        }

        $this->db->order_by('district_name', 'ASC');
        $rows = $this->db->get()->result();

        $options = [];
        foreach ($rows as $row) {
            $options[] = [
                'value' => $row->mst_reg_districtid,
                'label' => $row->district_name,
            ];
        }

        return [
            'success' => true,
            'data' => $options
        ];
    }

    public function data_option_by_city($cityid, $search = '')
    {
        $this->db->from($this->_table);
        $this->db->where('mst_reg_cityid', (int) $cityid);

        if ($search !== '') {
            $this->db->like('district_name', $search);
        }

        $this->db->order_by('district_name', 'ASC');
        $rows = $this->db->get()->result();

        $options = [];
        foreach ($rows as $row) {
            $options[] = [
                'value' => $row->mst_reg_districtid,
                'label' => $row->district_name,
            ];
        }

        return [
            'success' => true,
            'data' => $options
        ];
    }
}
