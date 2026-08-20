<?php

class EmailLog_Model extends CI_Model
{
    private $_table = 'act_email_log';

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

    private function normalize_text($value)
    {
        if ($value === '' || $value === null || is_array($value)) {
            return '';
        }

        return trim((string) $value);
    }

    public function data_option_admin_recipient()
    {
        $rows = $this->db->select('DISTINCT recipient_email')
            ->from($this->_table)
            ->where('recipient_email IS NOT NULL')
            ->where("recipient_email != ''")
            ->order_by('recipient_email', 'ASC')
            ->get()
            ->result();

        $data = [];
        foreach ($rows as $row) {
            $data[] = [
                'recipient_email' => $row->recipient_email
            ];
        }

        return [
            'success' => true,
            'message' => 'Recipient options retrieved successfully',
            'data' => $data
        ];
    }

    public function data_option_type()
    {
        $types = [
            ['email_type' => 'redeem_admin'],
            ['email_type' => 'confirm_customer'],
            ['email_type' => 'complete_customer'],
        ];

        return [
            'success' => true,
            'message' => 'Email type options retrieved successfully',
            'data' => $types
        ];
    }

    public function data_option_status()
    {
        $statuses = [
            ['status' => 'sent'],
            ['status' => 'failed'],
        ];

        return [
            'success' => true,
            'message' => 'Status options retrieved successfully',
            'data' => $statuses
        ];
    }

    public function data_list($page = 1, $per_page = 10, $search = '', $email_type = '', $status = '', $recipient_email = '', $sort_by = 'created_at', $sort_dir = 'DESC')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;

        $this->db->from($this->_table . ' l');

        if ($search !== '') {
            $this->db->group_start()
                ->like('l.recipient_email', $search)
                ->or_like('l.subject', $search)
                ->or_like('l.error_message', $search)
                ->or_like('l.related_redeemid', $search)
                ->group_end();
        }

        $email_type = $this->normalize_text($email_type);
        if ($email_type !== '') {
            $this->db->where('l.email_type', $email_type);
        }

        $status = $this->normalize_text($status);
        if ($status !== '') {
            $this->db->where('l.status', $status);
        }

        $recipient_email = $this->normalize_text($recipient_email);
        if ($recipient_email !== '') {
            $this->db->where('l.recipient_email', $recipient_email);
        }

        $total = $this->db->count_all_results('', false);

        $allowed_sort_columns = [
            'act_email_logid' => 'l.act_email_logid',
            'email_type' => 'l.email_type',
            'recipient_email' => 'l.recipient_email',
            'recipient_name' => 'l.recipient_name',
            'subject' => 'l.subject',
            'status' => 'l.status',
            'related_redeemid' => 'l.related_redeemid',
            'related_adminid' => 'l.related_adminid',
            'created_at' => 'l.created_at',
        ];

        $sort_by = trim((string) $sort_by);
        $sort_dir = strtolower(trim((string) $sort_dir)) === 'asc' ? 'ASC' : 'DESC';
        $sort_column = isset($allowed_sort_columns[$sort_by]) ? $allowed_sort_columns[$sort_by] : 'l.created_at';

        $this->db->order_by($sort_column, $sort_dir);
        $this->db->limit($per_page, $offset);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Email log data retrieved successfully',
            'data' => $rows,
            'pagination' => [
                'page' => $page,
                'per_page' => $per_page,
                'total' => (int) $total,
                'total_pages' => (int) ceil($total / $per_page),
                'has_prev' => $page > 1,
                'has_next' => ($page * $per_page) < $total,
            ]
        ];
    }

    public function data_list_print($search = '', $email_type = '', $status = '', $recipient_email = '', $sort_by = 'created_at', $sort_dir = 'DESC')
    {
        $this->db->from($this->_table . ' l');

        if ($search !== '') {
            $this->db->group_start()
                ->like('l.recipient_email', $search)
                ->or_like('l.subject', $search)
                ->or_like('l.error_message', $search)
                ->or_like('l.related_redeemid', $search)
                ->group_end();
        }

        $email_type = $this->normalize_text($email_type);
        if ($email_type !== '') {
            $this->db->where('l.email_type', $email_type);
        }

        $status = $this->normalize_text($status);
        if ($status !== '') {
            $this->db->where('l.status', $status);
        }

        $recipient_email = $this->normalize_text($recipient_email);
        if ($recipient_email !== '') {
            $this->db->where('l.recipient_email', $recipient_email);
        }

        $allowed_sort_columns = [
            'act_email_logid' => 'l.act_email_logid',
            'email_type' => 'l.email_type',
            'recipient_email' => 'l.recipient_email',
            'recipient_name' => 'l.recipient_name',
            'subject' => 'l.subject',
            'status' => 'l.status',
            'related_redeemid' => 'l.related_redeemid',
            'related_adminid' => 'l.related_adminid',
            'created_at' => 'l.created_at',
        ];

        $sort_by = trim((string) $sort_by);
        $sort_dir = strtolower(trim((string) $sort_dir)) === 'asc' ? 'ASC' : 'DESC';
        $sort_column = isset($allowed_sort_columns[$sort_by]) ? $allowed_sort_columns[$sort_by] : 'l.created_at';

        $this->db->order_by($sort_column, $sort_dir);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Email log data retrieved successfully',
            'data' => $rows,
        ];
    }
}