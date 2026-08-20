<?php

class Budget_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function budget_summary($itemtype = '', $search = '', $bulk_code = '')
    {
        $this->db->select("
            g.mst_itemgiftid,
            g.itemname,
            g.itemtype,
            g.value AS unit_value,
            COUNT(v.mst_voucherid) AS total_vouchers,
            COUNT(v.mst_voucherid) * g.value AS allocated_budget,
            SUM(CASE WHEN v.status IN (1,2) AND (v.expired_date IS NULL OR v.expired_date >= NOW()) THEN 1 ELSE 0 END) AS available_count,
            SUM(CASE WHEN v.status IN (1,2) AND (v.expired_date IS NULL OR v.expired_date >= NOW()) THEN 1 ELSE 0 END) * g.value AS available_budget,
            SUM(CASE WHEN v.status = 3 THEN 1 ELSE 0 END) AS pending_count,
            SUM(CASE WHEN v.status = 3 THEN 1 ELSE 0 END) * g.value AS pending_budget,
            SUM(CASE WHEN v.status = 4 THEN 1 ELSE 0 END) AS completed_count,
            SUM(CASE WHEN v.status = 4 THEN 1 ELSE 0 END) * g.value AS completed_budget,
            SUM(CASE WHEN v.status IN (3,4) THEN 1 ELSE 0 END) AS distributed_count,
            SUM(CASE WHEN v.status IN (3,4) THEN 1 ELSE 0 END) * g.value AS distributed_budget,
            SUM(CASE WHEN v.status = 5 THEN 1 ELSE 0 END) AS rejected_count,
            SUM(CASE WHEN v.status = 5 THEN 1 ELSE 0 END) * g.value AS rejected_budget,
            SUM(CASE WHEN v.status IN (1,2) AND v.expired_date IS NOT NULL AND v.expired_date < NOW() THEN 1 ELSE 0 END) AS expired_count,
            SUM(CASE WHEN v.status IN (1,2) AND v.expired_date IS NOT NULL AND v.expired_date < NOW() THEN 1 ELSE 0 END) * g.value AS expired_budget,
            CASE WHEN COUNT(v.mst_voucherid) > 0
                 THEN ROUND(SUM(CASE WHEN v.status IN (3,4) THEN 1 ELSE 0 END)::NUMERIC / COUNT(v.mst_voucherid) * 100, 1)
                 ELSE 0
            END AS utilization_pct
        ", false);

        $this->db->from('mst_itemgift g');
        $this->db->join('mst_voucher v', 'v.mst_itemgiftid = g.mst_itemgiftid', 'left');
        $this->db->where('g.suspended', 0);

        if ($itemtype !== '') {
            $this->db->where('g.itemtype', (int) $itemtype);
        }

        if ($search !== '') {
            $this->db->like('LOWER(g.itemname)', strtolower($search));
        }

        if ($bulk_code !== '') {
            $this->db->where('v.bulk_code', $bulk_code);
        }

        $this->db->group_by('g.mst_itemgiftid, g.itemname, g.itemtype, g.value');
        $this->db->order_by('g.itemname', 'ASC');

        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Budget data retrieved successfully',
            'data' => $rows
        ];
    }

    public function budget_totals($itemtype = '', $bulk_code = '')
    {
        $summary = $this->budget_summary($itemtype, '', $bulk_code);

        $totals = [
            'total_allocated' => 0,
            'total_distributed' => 0,
            'total_available' => 0,
            'total_expired' => 0,
            'total_vouchers' => 0,
            'total_distributed_count' => 0,
            'total_available_count' => 0,
            'total_expired_count' => 0,
        ];

        foreach ($summary['data'] as $row) {
            $totals['total_allocated'] += (float) $row->allocated_budget;
            $totals['total_distributed'] += (float) $row->distributed_budget;
            $totals['total_available'] += (float) $row->available_budget;
            $totals['total_expired'] += (float) $row->expired_budget;
            $totals['total_vouchers'] += (int) $row->total_vouchers;
            $totals['total_distributed_count'] += (int) $row->distributed_count;
            $totals['total_available_count'] += (int) $row->available_count;
            $totals['total_expired_count'] += (int) $row->expired_count;
        }

        return [
            'success' => true,
            'message' => 'Budget totals retrieved successfully',
            'data' => $totals
        ];
    }

    public function budget_ewallet_accumulation(){
        $this->db->select("UPPER(a.description) AS wallet_name, COUNT(*) AS redeem_qty, SUM(c.value) AS total_value");
        $this->db->from("act_redeem a");
        $this->db->join("mst_voucher b", "a.mst_voucherid = b.mst_voucherid", "left");
        $this->db->join("mst_itemgift c", "b.mst_itemgiftid = c.mst_itemgiftid", "left");
        $this->db->where("a.description <> ''");
        $this->db->where("b.status IN (3,4)");
        $this->db->group_by("a.description");
        $this->db->order_by("a.description", "ASC");

        $rows = $this->db->get()->result();

        return $rows;
    }

    public function budget_ewallet_itemgift(){
        $this->db->select("UPPER(c.itemname) AS itemname, UPPER(a.description) AS wallet_name, COUNT(*) AS redeem_qty, SUM(c.value) AS total_value");
        $this->db->from("act_redeem a");
        $this->db->join("mst_voucher b", "a.mst_voucherid = b.mst_voucherid", "left");
        $this->db->join("mst_itemgift c", "b.mst_itemgiftid = c.mst_itemgiftid", "left");
        $this->db->where("a.description <> ''");
        $this->db->where("b.status IN (3,4)");
        $this->db->group_by(array("a.description", "c.itemname"));
        $this->db->order_by("CAST(REPLACE(REGEXP_REPLACE(itemname, '[^0-9.]', '', 'g'), '.', '') AS INTEGER) ASC, a.description ASC");

        $rows = $this->db->get()->result();

        return $rows;
    }

    public function data_option_bulk_code()
    {
        $rows = $this->db->select('v.bulk_code, MAX(v.created_date) AS max_created')
            ->from('mst_voucher v')
            ->where('v.bulk_code IS NOT NULL', null, false)
            ->where('v.bulk_code !=', '')
            ->group_by('v.bulk_code')
            ->order_by('max_created', 'DESC')
            ->get()
            ->result();

        $data = [];
        foreach ($rows as $row) {
            $data[] = ['bulk_code' => $row->bulk_code];
        }

        return [
            'success' => true,
            'message' => 'Bulk code options retrieved successfully',
            'data' => $data
        ];
    }
}
