<?php

class RegionVillage_Model extends CI_Model
{
    private $_table = 'mst_reg_village';
    private $_pk = 'mst_reg_villageid';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Global_Model');
    }

    public function rules()
    {
        return [
            [
                'field' => 'mst_reg_districtid',
                'label' => 'District',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'village_name',
                'label' => 'Village Name',
                'rules' => 'required|trim|max_length[100]'
            ]
        ];
    }

    public function data_list($page = 1, $per_page = 10, $search = '', $sort_by = 'village_name', $sort_dir = 'ASC', $districtid = '', $cityid = '', $provinceid = '')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;

        $this->db->from($this->_table . ' v');
        $this->db->join('mst_reg_district dist', 'dist.mst_reg_districtid = v.mst_reg_districtid', 'left');

        if ($provinceid !== '' || $cityid !== '') {
            $this->db->join('mst_reg_city c', 'c.mst_reg_cityid = dist.mst_reg_cityid', 'left');
            if ($provinceid !== '') {
                $this->db->where('c.mst_reg_provinceid', (int) $provinceid);
            }
            if ($cityid !== '') {
                $this->db->where('dist.mst_reg_cityid', (int) $cityid);
            }
        }

        if ($districtid !== '') {
            $this->db->where('v.mst_reg_districtid', (int) $districtid);
        }

        if ($search !== '') {
            $this->db->like('v.village_name', $search);
        }

        $total = $this->db->count_all_results('', false);

        $allowed_sort = [
            'mst_reg_villageid' => 'v.mst_reg_villageid',
            'village_name' => 'v.village_name',
            'mst_reg_districtid' => 'v.mst_reg_districtid',
        ];

        $sort_column = isset($allowed_sort[$sort_by]) ? $allowed_sort[$sort_by] : 'village_name';
        $sort_dir = strtolower(trim((string) $sort_dir)) === 'desc' ? 'DESC' : 'ASC';

        $this->db->order_by($sort_column, $sort_dir);
        $this->db->limit($per_page, $offset);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Village data retrieved successfully',
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
            $this->db->like('village_name', $search);
        }

        $this->db->order_by('village_name', 'ASC');
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Village data retrieved successfully',
            'data' => $rows
        ];
    }

    public function data_new(array $input)
    {
        $mst_reg_districtid = trim((string) ($input['mst_reg_districtid'] ?? ''));
        $village_name = trim((string) ($input['village_name'] ?? ''));

        if ($mst_reg_districtid === '') {
            return [
                'success' => false,
                'message' => 'District is required'
            ];
        }

        if ($village_name === '') {
            return [
                'success' => false,
                'message' => 'Village name is required'
            ];
        }

        $mst_reg_villageid = $this->Global_Model->get_autoid_seq('mst_reg_village');
        if ($mst_reg_villageid === null) {
            return [
                'success' => false,
                'message' => 'Failed to generate village ID'
            ];
        }

        $data = [
            'mst_reg_villageid' => $mst_reg_villageid,
            'mst_reg_districtid' => (int) $mst_reg_districtid,
            'village_name' => $village_name,
        ];

        $insert = $this->db->insert($this->_table, $data);

        return [
            'success' => (bool) $insert,
            'message' => $insert ? 'Village created successfully' : 'Failed to create village'
        ];
    }

    public function data_edit($id)
    {
        $row = $this->db
            ->select('v.*, d.mst_reg_cityid, c.mst_reg_provinceid')
            ->from($this->_table . ' v')
            ->join('mst_reg_district d', 'd.mst_reg_districtid = v.mst_reg_districtid', 'left')
            ->join('mst_reg_city c', 'c.mst_reg_cityid = d.mst_reg_cityid', 'left')
            ->where('v.' . $this->_pk, (int) $id)
            ->get()
            ->row();

        if (!$row) {
            return [
                'success' => false,
                'message' => 'Village not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Village retrieved successfully',
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
                'message' => 'Village not found'
            ];
        }

        $mst_reg_districtid = trim((string) ($input['mst_reg_districtid'] ?? ''));
        $village_name = trim((string) ($input['village_name'] ?? ''));

        if ($mst_reg_districtid === '') {
            return [
                'success' => false,
                'message' => 'District is required'
            ];
        }

        if ($village_name === '') {
            return [
                'success' => false,
                'message' => 'Village name is required'
            ];
        }

        $data = [
            'mst_reg_districtid' => (int) $mst_reg_districtid,
            'village_name' => $village_name,
        ];

        $this->db->where($this->_pk, (int) $id);
        $update = $this->db->update($this->_table, $data);

        return [
            'success' => (bool) $update,
            'message' => $update ? 'Village updated successfully' : 'Failed to update village'
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
                'message' => 'Village not found'
            ];
        }

        $this->db->where($this->_pk, (int) $id);
        $delete = $this->db->delete($this->_table);

        return [
            'success' => (bool) $delete,
            'message' => $delete ? 'Village deleted successfully' : 'Failed to delete village'
        ];
    }

    public function data_option($search = '')
    {
        $this->db->from($this->_table);

        if ($search !== '') {
            $this->db->like('village_name', $search);
        }

        $this->db->order_by('village_name', 'ASC');
        $rows = $this->db->get()->result();

        $options = [];
        foreach ($rows as $row) {
            $options[] = [
                'value' => $row->mst_reg_villageid,
                'label' => $row->village_name,
            ];
        }

        return [
            'success' => true,
            'data' => $options
        ];
    }
}
