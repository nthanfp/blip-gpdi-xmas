<?php

class Region_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
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

    private function build_response($rows, $message)
    {
        return [
            'success' => true,
            'message' => $message,
            'data' => $rows
        ];
    }

    public function data_option_province()
    {
        $rows = $this->db->select('mst_reg_provinceid, province_name')
            ->from('mst_reg_province')
            ->order_by('province_name', 'ASC')
            ->get()
            ->result();

        foreach ($rows as $row) {
            $row->display_name = !empty($row->province_name)
                ? $row->province_name
                : (string) $row->mst_reg_provinceid;
        }

        return $this->build_response($rows, 'Province options retrieved successfully');
    }

    public function data_option_city($mst_reg_provinceid = null)
    {
        $mst_reg_provinceid = $this->normalize_id($mst_reg_provinceid);

        $this->db->select('mst_reg_cityid, mst_reg_provinceid, city_name')
            ->from('mst_reg_city');

        if ($mst_reg_provinceid !== null) {
            $this->db->where('mst_reg_provinceid', $mst_reg_provinceid);
        }

        $rows = $this->db->order_by('city_name', 'ASC')->get()->result();

        foreach ($rows as $row) {
            $row->display_name = !empty($row->city_name)
                ? $row->city_name
                : (string) $row->mst_reg_cityid;
        }

        return $this->build_response($rows, 'City options retrieved successfully');
    }

    public function data_option_district($mst_reg_cityid = null)
    {
        $mst_reg_cityid = $this->normalize_id($mst_reg_cityid);

        $this->db->select('mst_reg_districtid, mst_reg_cityid, district_name')
            ->from('mst_reg_district');

        if ($mst_reg_cityid !== null) {
            $this->db->where('mst_reg_cityid', $mst_reg_cityid);
        }

        $rows = $this->db->order_by('district_name', 'ASC')->get()->result();

        foreach ($rows as $row) {
            $row->display_name = !empty($row->district_name)
                ? $row->district_name
                : (string) $row->mst_reg_districtid;
        }

        return $this->build_response($rows, 'District options retrieved successfully');
    }

    public function data_option_village($mst_reg_districtid = null)
    {
        $mst_reg_districtid = $this->normalize_id($mst_reg_districtid);

        $this->db->select('mst_reg_villageid, mst_reg_districtid, village_name')
            ->from('mst_reg_village');

        if ($mst_reg_districtid !== null) {
            $this->db->where('mst_reg_districtid', $mst_reg_districtid);
        }

        $rows = $this->db->order_by('village_name', 'ASC')->get()->result();

        foreach ($rows as $row) {
            $row->display_name = !empty($row->village_name)
                ? $row->village_name
                : (string) $row->mst_reg_villageid;
        }

        return $this->build_response($rows, 'Village options retrieved successfully');
    }
}
