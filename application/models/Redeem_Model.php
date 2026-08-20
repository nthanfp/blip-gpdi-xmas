<?php

class Redeem_Model extends CI_Model
{
    private $_table = 'act_redeem';

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

    public function rules($mode = 'create')
    {
        return [
            ['field' => 'mst_customerid', 'label' => 'Customer', 'rules' => 'required'],
            ['field' => 'mst_voucherid', 'label' => 'Voucher', 'rules' => 'required']
        ];
    }

    public function data_option_customer()
    {
        $rows = $this->db->select('mst_customerid, custname, phone_number, email')
            ->from('mst_customer')
            ->order_by('custname', 'ASC')
            ->get()
            ->result();

        foreach ($rows as $row) {
            $row->display_name = trim(($row->custname ?: '') . ' (' . $row->phone_number . ')');
        }

        return ['success' => true, 'message' => 'Customer options retrieved successfully', 'data' => $rows];
    }

    public function data_option_voucher($mst_customerid = null)
    {
        $mst_customerid = $this->normalize_id($mst_customerid);
        $this->db->select('v.mst_voucherid, v.voucher_code, v.status, i.itemname')
            ->from('mst_voucher v')
            ->join('mst_itemgift i', 'i.mst_itemgiftid = v.mst_itemgiftid', 'left');

        if ($mst_customerid !== null) {
            $used = $this->db->select('mst_voucherid')->from('act_redeem')->where('mst_customerid', $mst_customerid)->get()->result_array();
            $used_ids = array_map(function ($row) {
                return (int) $row['mst_voucherid'];
            }, $used);
            if (!empty($used_ids)) {
                $this->db->where_not_in('v.mst_voucherid', $used_ids);
            }
        }

        $rows = $this->db->order_by('v.voucher_code', 'ASC')->get()->result();
        foreach ($rows as $row) {
            $row->display_name = !empty($row->voucher_code)
                ? $row->voucher_code . ' - ' . ($row->itemname ?: 'Item')
                : (string) $row->mst_voucherid;
        }

        return ['success' => true, 'message' => 'Voucher options retrieved successfully', 'data' => $rows];
    }

    public function data_list($page = 1, $per_page = 10, $search = '', $mst_customerid = '', $voucher_search = '', $status = '', $sort_by = 'redeemed_date', $sort_dir = 'DESC', $date_from = '', $date_to = '', $itemtype = '')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;

        $this->db->from($this->_table . ' r');
        $this->db->select('r.*, c.custname, c.phone_number, c.email, v.voucher_code, v.status, i.itemname');
        $this->db->join('mst_customer c', 'c.mst_customerid = r.mst_customerid', 'left');
        $this->db->join('mst_voucher v', 'v.mst_voucherid = r.mst_voucherid', 'left');
        $this->db->join('mst_itemgift i', 'i.mst_itemgiftid = v.mst_itemgiftid', 'left');

        if ($search !== '') {
            $search = strtolower($search);
            $searchPhone = preg_replace('/^(0|62)/', '', trim($search));
            $s = $this->db->escape('%' . $search . '%');
            $sp = $this->db->escape('%' . $searchPhone . '%');
            $this->db->group_start()
                ->where("LOWER(c.custname) LIKE $s")
                ->or_where("LOWER(c.phone_number) LIKE $sp")
                ->or_where("LOWER(c.email) LIKE $s")
                ->or_where("LOWER(v.voucher_code) LIKE $s")
                ->or_where("LOWER(i.itemname) LIKE $s")
                ->or_where("LOWER(r.description) LIKE $s")
                ->or_where("LOWER(r.ip_address) LIKE $s")
                ->or_where("LOWER(r.mac_address) LIKE $s")
                ->group_end();
        }

        $mst_customerid = $this->normalize_id($mst_customerid);
        if ($mst_customerid !== null) {
            $this->db->where('r.mst_customerid', $mst_customerid);
        }

        $voucher_search = $this->normalize_text($voucher_search);
        if ($voucher_search !== '') {
            $this->db->group_start()
                ->like('v.voucher_code', $voucher_search)
                ->or_like('i.itemname', $voucher_search)
                ->or_like('r.description', $voucher_search)
                ->group_end();
        }

        $status = $this->normalize_id($status);
        if ($status !== null) {
            $this->db->where('v.status', $status);
        }

        $itemtype = trim((string) $itemtype);
        if ($itemtype !== '') {
            $this->db->where('i.itemtype', (int) $itemtype);
        }

        $date_from = $this->normalize_text($date_from);
        $date_to = $this->normalize_text($date_to);
        if ($date_from !== '' && $date_to !== '') {
            $this->db->where("r.redeemed_date BETWEEN " . $this->db->escape($date_from . ' 00:00:00') . " AND " . $this->db->escape($date_to . ' 23:59:59'));
        } elseif ($date_from !== '') {
            $this->db->where('r.redeemed_date >=', $date_from . ' 00:00:00');
        } elseif ($date_to !== '') {
            $this->db->where('r.redeemed_date <=', $date_to . ' 23:59:59');
        }

        $total = $this->db->count_all_results('', false);

        $allowed_sort_columns = [
            'act_redeemid' => 'r.act_redeemid',
            'mst_customerid' => 'r.mst_customerid',
            'custname' => 'c.custname',
            'voucher_code' => 'v.voucher_code',
            'itemname' => 'i.itemname',
            'description' => 'r.description',
            'ip_address' => 'r.ip_address',
            'mac_address' => 'r.mac_address',
            'geo_lat' => 'r.geo_lat',
            'geo_long' => 'r.geo_long',
            'redeemed_date' => 'r.redeemed_date'
        ];

        $sort_by = trim((string) $sort_by);
        $sort_dir = strtolower(trim((string) $sort_dir)) === 'asc' ? 'ASC' : 'DESC';
        $sort_column = isset($allowed_sort_columns[$sort_by]) ? $allowed_sort_columns[$sort_by] : 'r.redeemed_date';

        $this->db->order_by($sort_column, $sort_dir);
        $this->db->limit($per_page, $offset);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Redeem data retrieved successfully',
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

    public function data_list_print($search = '', $mst_customerid = '', $voucher_search = '', $status = '', $sort_by = 'redeemed_date', $sort_dir = 'DESC', $date_from = '', $date_to = '', $itemtype = '')
    {
        $this->db->from($this->_table . ' r');
        $this->db->select('r.*, c.custname, c.phone_number, c.email, v.voucher_code, v.status, i.itemname, i.value');
        $this->db->join('mst_customer c', 'c.mst_customerid = r.mst_customerid', 'left');
        $this->db->join('mst_voucher v', 'v.mst_voucherid = r.mst_voucherid', 'left');
        $this->db->join('mst_itemgift i', 'i.mst_itemgiftid = v.mst_itemgiftid', 'left');

        if ($search !== '') {
            $this->db->group_start()
                ->like('c.custname', $search)
                ->or_like('c.phone_number', $search)
                ->or_like('c.email', $search)
                ->or_like('v.voucher_code', $search)
                ->or_like('i.itemname', $search)
                ->or_like('r.description', $search)
                ->or_like('r.ip_address', $search)
                ->or_like('r.mac_address', $search)
                ->group_end();
        }

        $mst_customerid = $this->normalize_id($mst_customerid);
        if ($mst_customerid !== null) {
            $this->db->where('r.mst_customerid', $mst_customerid);
        }

        $voucher_search = $this->normalize_text($voucher_search);
        if ($voucher_search !== '') {
            $this->db->group_start()
                ->like('v.voucher_code', $voucher_search)
                ->or_like('i.itemname', $voucher_search)
                ->or_like('r.description', $voucher_search)
                ->group_end();
        }

        $status = $this->normalize_id($status);
        if ($status !== null) {
            $this->db->where('v.status', $status);
        }

        $itemtype = trim((string) $itemtype);
        if ($itemtype !== '') {
            $this->db->where('i.itemtype', (int) $itemtype);
        }

        $date_from = $this->normalize_text($date_from);
        $date_to = $this->normalize_text($date_to);
        if ($date_from !== '' && $date_to !== '') {
            $this->db->where("r.redeemed_date BETWEEN " . $this->db->escape($date_from . ' 00:00:00') . " AND " . $this->db->escape($date_to . ' 23:59:59'));
        } elseif ($date_from !== '') {
            $this->db->where('r.redeemed_date >=', $date_from . ' 00:00:00');
        } elseif ($date_to !== '') {
            $this->db->where('r.redeemed_date <=', $date_to . ' 23:59:59');
        }

        $total = $this->db->count_all_results('', false);

        $allowed_sort_columns = [
            'act_redeemid' => 'r.act_redeemid',
            'mst_customerid' => 'r.mst_customerid',
            'custname' => 'c.custname',
            'voucher_code' => 'v.voucher_code',
            'itemname' => 'i.itemname',
            'description' => 'r.description',
            'ip_address' => 'r.ip_address',
            'mac_address' => 'r.mac_address',
            'geo_lat' => 'r.geo_lat',
            'geo_long' => 'r.geo_long',
            'redeemed_date' => 'r.redeemed_date'
        ];

        $sort_by = trim((string) $sort_by);
        $sort_dir = strtolower(trim((string) $sort_dir)) === 'asc' ? 'ASC' : 'DESC';
        $sort_column = isset($allowed_sort_columns[$sort_by]) ? $allowed_sort_columns[$sort_by] : 'r.redeemed_date';

        $this->db->order_by($sort_column, $sort_dir);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Redeem data retrieved successfully',
            'data' => $rows,
        ];
    }

    public function data_new(array $input)
    {
        $act_redeemid = $this->Global_Model->get_autoid_seq('seq_act_redeem');
        $mst_customerid = $this->normalize_id($input['mst_customerid'] ?? null);
        $mst_voucherid = $this->normalize_id($input['mst_voucherid'] ?? null);
        $description = $this->normalize_text($input['description'] ?? '');
        $ip_address = $this->normalize_text($input['ip_address'] ?? '');
        $mac_address = $this->normalize_text($input['mac_address'] ?? '');
        $geo_lat = $this->normalize_text($input['geo_lat'] ?? '');
        $geo_long = $this->normalize_text($input['geo_long'] ?? '');
        $redeemed_date = $this->normalize_text($input['redeemed_date'] ?? '');
        $confirmed_by = $this->normalize_text($input['confirmed_by'] ?? '');
        $confirmed_date = $this->normalize_text($input['confirmed_date'] ?? '');
        $completed_by = $this->normalize_text($input['completed_by'] ?? '');
        $completed_date = $this->normalize_text($input['completed_date'] ?? '');

        if ($act_redeemid === null) {
            return ['success' => false, 'message' => 'Failed to generate redeem ID'];
        }

        if ($mst_customerid === null) {
            return ['success' => false, 'message' => 'Customer is required'];
        }

        if ($mst_voucherid === null) {
            return ['success' => false, 'message' => 'Voucher is required'];
        }

        $data = [
            'act_redeemid' => $act_redeemid,
            'mst_customerid' => $mst_customerid,
            'mst_voucherid' => $mst_voucherid,
            'description' => $description,
            'ip_address' => $ip_address,
            'mac_address' => $mac_address,
            'geo_lat' => $geo_lat,
            'geo_long' => $geo_long,
            'redeemed_date' => $redeemed_date !== '' ? $redeemed_date : date('Y-m-d H:i:s'),
            'confirmed_by' => $confirmed_by,
            'confirmed_date' => $confirmed_date !== '' ? $confirmed_date : null,
            'completed_by' => $completed_by,
            'completed_date' => $completed_date !== '' ? $completed_date : null
        ];

        $insert = $this->db->insert($this->_table, $data);

        return [
            'success' => (bool) $insert,
            'message' => $insert ? 'Redeem data created successfully' : 'Failed to create redeem data'
        ];
    }

    public function data_edit($id)
    {
        $item = $this->db->select('r.*, c.custname, c.phone_number, c.email, v.voucher_code, i.itemname')
            ->from($this->_table . ' r')
            ->join('mst_customer c', 'c.mst_customerid = r.mst_customerid', 'left')
            ->join('mst_voucher v', 'v.mst_voucherid = r.mst_voucherid', 'left')
            ->join('mst_itemgift i', 'i.mst_itemgiftid = v.mst_itemgiftid', 'left')
            ->where('r.act_redeemid', (int) $id)
            ->get()
            ->row();

        if (!$item) {
            return ['success' => false, 'message' => 'Redeem data not found'];
        }

        return ['success' => true, 'message' => 'Redeem data retrieved successfully', 'data' => $item];
    }

    public function data_information($id)
    {
        $item = $this->db->select('r.*, c.custname, c.phone_number, c.email, v.voucher_code, v.status as voucher_status, i.itemname')
            ->from($this->_table . ' r')
            ->join('mst_customer c', 'c.mst_customerid = r.mst_customerid', 'left')
            ->join('mst_voucher v', 'v.mst_voucherid = r.mst_voucherid', 'left')
            ->join('mst_itemgift i', 'i.mst_itemgiftid = v.mst_itemgiftid', 'left')
            ->where('r.act_redeemid', (int) $id)
            ->get()
            ->row();

        if (!$item) {
            return ['success' => false, 'message' => 'Redeem data not found'];
        }

        $purchase_proof = $this->db->select('act_redeem_purchase_proofid, act_redeemid, filename, filepath')
            ->from('act_redeem_purchase_proof')
            ->where('act_redeemid', (int) $id)
            ->order_by('created_date', 'DESC')
            ->order_by('act_redeem_purchase_proofid', 'DESC')
            ->limit(1)
            ->get()
            ->row();

        $proof = $this->db->select('act_redeem_proofid, act_redeemid, filename, filepath, notes, created_by, created_date')
            ->from('act_redeem_proof')
            ->where('act_redeemid', (int) $id)
            ->order_by('created_date', 'DESC')
            ->order_by('act_redeem_proofid', 'DESC')
            ->limit(1)
            ->get()
            ->row();

        if ($purchase_proof) {
            $item->purchase_proof = $purchase_proof;
        } else {
            $item->purchase_proof = null;
        }

        if ($proof) {
            $item->proof = $proof;
        } else {
            $item->proof = null;
        }

        return ['success' => true, 'message' => 'Redeem information retrieved successfully', 'data' => $item];
    }

    public function data_confirm($id, $confirmedBy, $notes = '', array $fileInfo = null)
    {
        $this->db->trans_begin();

        try {
            $sql = $this->db->select('*')
                ->from($this->_table)
                ->where('act_redeemid', (int) $id)
                ->get_compiled_select();
            $sql .= ' FOR UPDATE';
            $item = $this->db->query($sql)->row();

            if (!$item) {
                throw new Exception('Redeem data not found');
            }

            $voucherSql = $this->db->select('status')
                ->from('mst_voucher')
                ->where('mst_voucherid', (int) $item->mst_voucherid)
                ->get_compiled_select();
            $voucherSql .= ' FOR UPDATE';
            $voucher = $this->db->query($voucherSql)->row();

            if (!$voucher) {
                throw new Exception('Voucher data not found');
            }

            if ((int) $voucher->status !== 3) {
                throw new Exception('Only REDEEMED vouchers can be confirmed');
            }

            $proofId = $this->Global_Model->get_autoid('act_redeem_proof', 'act_redeem_proofid');
            if ($proofId === null) {
                throw new Exception('Failed to generate redeem proof ID');
            }

            $this->db->where('act_redeemid', (int) $id)->update($this->_table, [
                'completed_by' => $this->normalize_text($confirmedBy),
                'completed_date' => date('Y-m-d H:i:s')
            ]);

            $this->db->insert('act_redeem_proof', [
                'act_redeem_proofid' => $proofId,
                'act_redeemid' => (int) $id,
                'filename' => $fileInfo['filename'] ?? null,
                'filepath' => $fileInfo['filepath'] ?? null,
                'notes' => $this->normalize_text($notes),
                'created_by' => $this->normalize_text($confirmedBy),
                'created_date' => date('Y-m-d H:i:s')
            ]);

            $this->db->where('mst_voucherid', (int) $item->mst_voucherid)
                ->where('status', 3)
                ->update('mst_voucher', [
                    'status' => 4,
                    'modified_by' => $this->normalize_text($confirmedBy),
                    'modified_date' => date('Y-m-d H:i:s')
                ]);

            if ($this->db->affected_rows() === 0) {
                throw new Exception('Voucher already confirmed by another request');
            }

            if ($this->db->trans_status() === false) {
                throw new Exception('Transaction failed');
            }

            $this->db->trans_commit();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return ['success' => false, 'message' => $e->getMessage()];
        }

        $this->load->model('Email_Model');
        $this->Email_Model->emailCompleteToCustomer((int) $id);

        return [
            'success' => true,
            'message' => 'Redeem confirmed successfully',
            'data' => [
                'act_redeem_proofid' => $proofId,
                'act_redeemid' => (int) $id
            ]
        ];
    }

    public function data_update($id, array $input)
    {
        $item = $this->db->get_where($this->_table, ['act_redeemid' => (int) $id])->row();
        if (!$item) {
            return ['success' => false, 'message' => 'Redeem data not found'];
        }

        $data = [
            'mst_customerid' => $this->normalize_id($input['mst_customerid'] ?? null),
            'mst_voucherid' => $this->normalize_id($input['mst_voucherid'] ?? null),
            'description' => $this->normalize_text($input['description'] ?? ''),
            'ip_address' => $this->normalize_text($input['ip_address'] ?? ''),
            'mac_address' => $this->normalize_text($input['mac_address'] ?? ''),
            'geo_lat' => $this->normalize_text($input['geo_lat'] ?? ''),
            'geo_long' => $this->normalize_text($input['geo_long'] ?? '')
        ];

        $this->db->where('act_redeemid', (int) $id);
        $update = $this->db->update($this->_table, $data);

        return [
            'success' => (bool) $update,
            'message' => $update ? 'Redeem data updated successfully' : 'Failed to update redeem data'
        ];
    }

    public function data_reject($id, $rejectedBy, $notes = '')
    {
        $this->db->trans_begin();

        try {
            $sql = $this->db->select('*')
                ->from($this->_table)
                ->where('act_redeemid', (int) $id)
                ->get_compiled_select();
            $sql .= ' FOR UPDATE';
            $item = $this->db->query($sql)->row();

            if (!$item) {
                throw new Exception('Redeem data not found');
            }

            $voucherSql = $this->db->select('status')
                ->from('mst_voucher')
                ->where('mst_voucherid', (int) $item->mst_voucherid)
                ->get_compiled_select();
            $voucherSql .= ' FOR UPDATE';
            $voucher = $this->db->query($voucherSql)->row();

            if (!$voucher) {
                throw new Exception('Voucher data not found');
            }

            if ((int) $voucher->status !== 3) {
                throw new Exception('Only REDEEMED vouchers can be rejected');
            }

            $this->db->where('act_redeemid', (int) $id)->update($this->_table, [
                'rejected_by' => $this->normalize_text($rejectedBy),
                'rejected_date' => date('Y-m-d H:i:s'),
                'rejected_notes' => $notes
            ]);

            $this->db->where('mst_voucherid', (int) $item->mst_voucherid)
                ->where('status', 3)
                ->update('mst_voucher', [
                    'status' => 5,
                    'modified_by' => $this->normalize_text($rejectedBy),
                    'modified_date' => date('Y-m-d H:i:s')
                ]);

            if ($this->db->affected_rows() === 0) {
                throw new Exception('Voucher already rejected by another request');
            }

            if ($this->db->trans_status() === false) {
                throw new Exception('Transaction failed');
            }

            $this->db->trans_commit();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return ['success' => false, 'message' => $e->getMessage()];
        }

        return [
            'success' => true,
            'message' => 'Redeem rejected successfully'
        ];
    }

    public function data_delete($id)
    {
        $item = $this->db->get_where($this->_table, ['act_redeemid' => (int) $id])->row();
        if (!$item) {
            return ['success' => false, 'message' => 'Redeem data not found'];
        }

        $delete = $this->db->delete($this->_table, ['act_redeemid' => (int) $id]);
        return [
            'success' => (bool) $delete,
            'message' => $delete ? 'Redeem data deleted successfully' : 'Failed to delete redeem data'
        ];
    }
}
