<?php

class Customer_Model extends CI_Model
{
    private $_table = 'mst_customer';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Global_Model');
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

    private function email_exists($email, $exclude_id = null)
    {
        $email = $this->normalize_text($email);
        if ($email === '') {
            return false;
        }

        $this->db->from($this->_table);
        $this->db->where('LOWER(email) =', strtolower($email));

        $exclude_id = $this->normalize_id($exclude_id);
        if ($exclude_id !== null) {
            $this->db->where('mst_customerid !=', $exclude_id);
        }

        return $this->db->count_all_results() > 0;
    }

    private function phone_exists($phone_number, $exclude_id = null)
    {
        $phone_number = $this->normalize_text($phone_number);
        if ($phone_number === '') {
            return false;
        }

        $this->db->from($this->_table);
        $this->db->where('phone_number', $phone_number);

        $exclude_id = $this->normalize_id($exclude_id);
        if ($exclude_id !== null) {
            $this->db->where('mst_customerid !=', $exclude_id);
        }

        return $this->db->count_all_results() > 0;
    }

    public function rules($mode = 'create')
    {
        return [
            [
                'field' => 'custname',
                'label' => 'Customer Name',
                'rules' => 'required|max_length[100]'
            ],
            [
                'field' => 'phone_number',
                'label' => 'Phone Number',
                'rules' => 'required|max_length[30]'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email|max_length[100]'
            ],
            [
                'field' => 'mst_reg_provinceid',
                'label' => 'Province',
                'rules' => 'required'
            ],
            [
                'field' => 'mst_reg_cityid',
                'label' => 'City',
                'rules' => 'required'
            ],
            [
                'field' => 'mst_reg_districtid',
                'label' => 'District',
                'rules' => 'required'
            ]
        ];
    }

    public function data_list($page = 1, $per_page = 10, $search = '', $mst_reg_provinceid = '', $mst_reg_cityid = '', $mst_reg_districtid = '', $mst_reg_villageid = '', $sort_by = 'created_date', $sort_dir = 'DESC')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;

        $this->db->from($this->_table . ' c');
        $this->db->select('c.*, p.province_name, ci.city_name, d.district_name, v.village_name');
        $this->db->join('mst_reg_province p', 'p.mst_reg_provinceid = c.mst_reg_provinceid', 'left');
        $this->db->join('mst_reg_city ci', 'ci.mst_reg_cityid = c.mst_reg_cityid', 'left');
        $this->db->join('mst_reg_district d', 'd.mst_reg_districtid = c.mst_reg_districtid', 'left');
        $this->db->join('mst_reg_village v', 'v.mst_reg_villageid = c.mst_reg_villageid', 'left');

        if ($search !== '') {
            $search = strtolower($search);
            $s = $this->db->escape('%' . $search . '%');
            $this->db->group_start()
                ->where("LOWER(c.custname) LIKE $s")
                ->or_where("LOWER(c.phone_number) LIKE $s")
                ->or_where("LOWER(c.email) LIKE $s")
                ->or_where("LOWER(p.province_name) LIKE $s")
                ->or_where("LOWER(ci.city_name) LIKE $s")
                ->or_where("LOWER(d.district_name) LIKE $s")
                ->or_where("LOWER(v.village_name) LIKE $s")
                ->group_end();
        }

        $mst_reg_provinceid = $this->normalize_id($mst_reg_provinceid);
        if ($mst_reg_provinceid !== null) {
            $this->db->where('c.mst_reg_provinceid', $mst_reg_provinceid);
        }

        $mst_reg_cityid = $this->normalize_id($mst_reg_cityid);
        if ($mst_reg_cityid !== null) {
            $this->db->where('c.mst_reg_cityid', $mst_reg_cityid);
        }

        $mst_reg_districtid = $this->normalize_id($mst_reg_districtid);
        if ($mst_reg_districtid !== null) {
            $this->db->where('c.mst_reg_districtid', $mst_reg_districtid);
        }

        $mst_reg_villageid = $this->normalize_id($mst_reg_villageid);
        if ($mst_reg_villageid !== null) {
            $this->db->where('c.mst_reg_villageid', $mst_reg_villageid);
        }

        $total = $this->db->count_all_results('', false);

        $allowed_sort_columns = [
            'mst_customerid' => 'c.mst_customerid',
            'custname' => 'c.custname',
            'phone_number' => 'c.phone_number',
            'email' => 'c.email',
            'province_name' => 'p.province_name',
            'city_name' => 'ci.city_name',
            'district_name' => 'd.district_name',
            'village_name' => 'v.village_name',
            'created_date' => 'c.created_date'
        ];

        $sort_by = trim((string) $sort_by);
        $sort_dir = strtolower(trim((string) $sort_dir)) === 'asc' ? 'ASC' : 'DESC';
        $sort_column = isset($allowed_sort_columns[$sort_by]) ? $allowed_sort_columns[$sort_by] : 'created_date';

        $this->db->order_by($sort_column, $sort_dir);
        $this->db->limit($per_page, $offset);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Customer data retrieved successfully',
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

    public function data_list_print($search = '', $mst_reg_provinceid = '', $mst_reg_cityid = '', $mst_reg_districtid = '', $mst_reg_villageid = '', $sort_by = 'created_date', $sort_dir = 'DESC')
    {
        $this->db->from($this->_table . ' c');
        $this->db->select('c.*, p.province_name, ci.city_name, d.district_name, v.village_name');
        $this->db->join('mst_reg_province p', 'p.mst_reg_provinceid = c.mst_reg_provinceid', 'left');
        $this->db->join('mst_reg_city ci', 'ci.mst_reg_cityid = c.mst_reg_cityid', 'left');
        $this->db->join('mst_reg_district d', 'd.mst_reg_districtid = c.mst_reg_districtid', 'left');
        $this->db->join('mst_reg_village v', 'v.mst_reg_villageid = c.mst_reg_villageid', 'left');

        if ($search !== '') {
            $search = strtolower($search);
            $s = $this->db->escape('%' . $search . '%');
            $this->db->group_start()
                ->where("LOWER(c.custname) LIKE $s")
                ->or_where("LOWER(c.phone_number) LIKE $s")
                ->or_where("LOWER(c.email) LIKE $s")
                ->or_where("LOWER(p.province_name) LIKE $s")
                ->or_where("LOWER(ci.city_name) LIKE $s")
                ->or_where("LOWER(d.district_name) LIKE $s")
                ->or_where("LOWER(v.village_name) LIKE $s")
                ->group_end();
        }

        $mst_reg_provinceid = $this->normalize_id($mst_reg_provinceid);
        if ($mst_reg_provinceid !== null) {
            $this->db->where('c.mst_reg_provinceid', $mst_reg_provinceid);
        }

        $mst_reg_cityid = $this->normalize_id($mst_reg_cityid);
        if ($mst_reg_cityid !== null) {
            $this->db->where('c.mst_reg_cityid', $mst_reg_cityid);
        }

        $mst_reg_districtid = $this->normalize_id($mst_reg_districtid);
        if ($mst_reg_districtid !== null) {
            $this->db->where('c.mst_reg_districtid', $mst_reg_districtid);
        }

        $mst_reg_villageid = $this->normalize_id($mst_reg_villageid);
        if ($mst_reg_villageid !== null) {
            $this->db->where('c.mst_reg_villageid', $mst_reg_villageid);
        }

        $allowed_sort_columns = [
            'mst_customerid' => 'c.mst_customerid',
            'custname' => 'c.custname',
            'phone_number' => 'c.phone_number',
            'email' => 'c.email',
            'province_name' => 'p.province_name',
            'city_name' => 'ci.city_name',
            'district_name' => 'd.district_name',
            'village_name' => 'v.village_name',
            'created_date' => 'c.created_date'
        ];

        $sort_by = trim((string) $sort_by);
        $sort_dir = strtolower(trim((string) $sort_dir)) === 'asc' ? 'ASC' : 'DESC';
        $sort_column = isset($allowed_sort_columns[$sort_by]) ? $allowed_sort_columns[$sort_by] : 'created_date';

        $this->db->order_by($sort_column, $sort_dir);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Customer data retrieved successfully',
            'data' => $rows
        ];
    }

    public function data_new(array $input)
    {
        $mst_customerid = $this->Global_Model->get_autoid($this->_table, 'mst_customerid');
        $custname = $this->normalize_text($input['custname'] ?? '');
        $phone_number = $this->normalize_text($input['phone_number'] ?? '');
        $email = $this->normalize_text($input['email'] ?? '');
        $mst_reg_provinceid = $this->normalize_id($input['mst_reg_provinceid'] ?? null);
        $mst_reg_cityid = $this->normalize_id($input['mst_reg_cityid'] ?? null);
        $mst_reg_districtid = $this->normalize_id($input['mst_reg_districtid'] ?? null);
        $mst_reg_villageid = $this->normalize_id($input['mst_reg_villageid'] ?? null);
        $current_user = $this->current_user_id();

        if ($mst_customerid === null) {
            return [
                'success' => false,
                'message' => 'Failed to generate customer ID'
            ];
        }

        if ($this->phone_exists($phone_number)) {
            return [
                'success' => false,
                'message' => 'Phone number already exists'
            ];
        }

        if ($this->email_exists($email)) {
            return [
                'success' => false,
                'message' => 'Email already exists'
            ];
        }

        $data = [
            'mst_customerid' => $mst_customerid,
            'custname' => $custname,
            'phone_number' => $phone_number,
            'email' => $email,
            'mst_reg_provinceid' => $mst_reg_provinceid,
            'mst_reg_cityid' => $mst_reg_cityid,
            'mst_reg_districtid' => $mst_reg_districtid,
            'mst_reg_villageid' => $mst_reg_villageid,
            'created_by' => $current_user,
            'created_date' => date('Y-m-d H:i:s')
        ];

        $insert = $this->db->insert($this->_table, $data);

        return [
            'success' => (bool) $insert,
            'message' => $insert ? 'Customer data created successfully' : 'Failed to create customer data'
        ];
    }

    public function data_edit($id)
    {
        $item = $this->db->get_where($this->_table, [
            'mst_customerid' => (int) $id
        ])->row();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'Customer data not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Customer data retrieved successfully',
            'data' => $item
        ];
    }

    public function data_update($id, array $input)
    {
        $item = $this->db->get_where($this->_table, [
            'mst_customerid' => (int) $id
        ])->row();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'Customer data not found'
            ];
        }

        $data = [
            'custname' => $this->normalize_text($input['custname'] ?? ''),
            'phone_number' => $this->normalize_text($input['phone_number'] ?? ''),
            'email' => $this->normalize_text($input['email'] ?? ''),
            'mst_reg_provinceid' => $this->normalize_id($input['mst_reg_provinceid'] ?? null),
            'mst_reg_cityid' => $this->normalize_id($input['mst_reg_cityid'] ?? null),
            'mst_reg_districtid' => $this->normalize_id($input['mst_reg_districtid'] ?? null),
            'mst_reg_villageid' => $this->normalize_id($input['mst_reg_villageid'] ?? null)
        ];

        if ($this->phone_exists($data['phone_number'], $id)) {
            return [
                'success' => false,
                'message' => 'Phone number already exists'
            ];
        }

        if ($this->email_exists($data['email'], $id)) {
            return [
                'success' => false,
                'message' => 'Email already exists'
            ];
        }

        $this->db->where('mst_customerid', (int) $id);
        $update = $this->db->update($this->_table, $data);

        return [
            'success' => (bool) $update,
            'message' => $update ? 'Customer data updated successfully' : 'Failed to update customer data'
        ];
    }

    public function data_delete($id)
    {
        $item = $this->db->get_where($this->_table, [
            'mst_customerid' => (int) $id
        ])->row();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'Customer data not found'
            ];
        }

        $redeem_count = $this->db
            ->from('act_redeem')
            ->where('mst_customerid', (int) $id)
            ->count_all_results();

        if ($redeem_count > 0) {
            return [
                'success' => false,
                'message' => 'Cannot delete customer. Customer has ' . $redeem_count . ' redeem record(s).'
            ];
        }

        $delete = $this->db->delete($this->_table, [
            'mst_customerid' => (int) $id
        ]);

        return [
            'success' => (bool) $delete,
            'message' => $delete ? 'Customer data deleted successfully' : 'Failed to delete customer data'
        ];
    }

    public function check_phone($phone_number)
    {
        $phone_number = $this->normalize_text($phone_number);
        if ($phone_number === '') {
            return [
                'success' => false,
                'message' => 'Phone number is required',
                'exists' => false,
                'data' => null
            ];
        }

        $item = $this->db->select('mst_customerid, custname, phone_number, email, mst_reg_provinceid, mst_reg_cityid, mst_reg_districtid, mst_reg_villageid')
            ->from($this->_table)
            ->where('phone_number', $phone_number)
            ->get()
            ->row();

        return [
            'success' => true,
            'message' => $item ? 'Phone number exists' : 'Phone number not found',
            'exists' => (bool) $item,
            'data' => $item
        ];
    }
}
