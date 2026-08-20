<?php

class Email_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
        $this->load->model('Setpref_Model');
        $this->load->model('Global_Model');
    }

    private function pref_enabled($pref_name)
    {
        return $this->Setpref_Model->get_pref($pref_name) === '1';
    }

    private function get_admin_emails()
    {
        $rows = $this->db->select('a.email')
            ->from('mst_admin a')
            ->join('set_menu_admin sm', 'sm.mst_adminid = a.mst_adminid')
            ->where('a.suspended', 0)
            ->where('a.email IS NOT NULL')
            ->where("a.email != ''")
            ->where('sm.set_menuid', 114)
            ->get()
            ->result();

        $emails = array_filter(array_map(function ($row) {
            return trim((string) ($row->email ?? ''));
        }, $rows));

        return !empty($emails) ? array_values($emails) : ['ntnferry1505@gmail.com'];
    }

    private function configure_email()
    {
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => getenv('SMTP_HOST') ?: '',
            'smtp_port' => getenv('SMTP_PORT') ?: '',
            'smtp_user' => getenv('SMTP_USER') ?: '',
            'smtp_pass' => getenv('SMTP_PASS') ?: '',
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n",
            'wordwrap'  => true
        );
        $this->email->initialize($config);
    }

    private function load_view($view, $data = [])
    {
        return $this->load->view($view, $data, true);
    }

    private function log_email(array $data)
    {
        $next_id = $this->Global_Model->get_autoid('act_email_log', 'act_email_logid');

        $this->db->insert('act_email_log', [
            'act_email_logid' => $next_id,
            'email_type' => (string) ($data['email_type'] ?? ''),
            'recipient_email' => (string) ($data['recipient_email'] ?? ''),
            'recipient_name' => $data['recipient_name'] !== null ? (string) $data['recipient_name'] : null,
            'subject' => (string) ($data['subject'] ?? ''),
            'status' => (string) ($data['status'] ?? 'failed'),
            'error_message' => $data['error_message'] !== null ? (string) $data['error_message'] : null,
            'related_redeemid' => isset($data['related_redeemid']) ? (int) $data['related_redeemid'] : null,
            'related_adminid' => isset($data['related_adminid']) ? (int) $data['related_adminid'] : null,
            'created_at' => date('Y-m-d H:i:sP'),
        ]);
    }

    private function get_email_error()
    {
        $debugger = $this->email->print_debugger(['headers']);
        $debugger = trim(strip_tags((string) $debugger));

        if ($debugger === '') {
            return 'Unknown email error';
        }

        return $debugger;
    }

    public function emailRedeemToAdmin($redeemId)
    {
        $redeem = $this->db->select("
                r.*, c.custname, c.phone_number, c.email as customer_email,
                v.voucher_code, v.expired_date,
                g.itemname, g.itemtype
            ")
            ->from('act_redeem r')
            ->join('mst_customer c', 'c.mst_customerid = r.mst_customerid', 'left')
            ->join('mst_voucher v', 'v.mst_voucherid = r.mst_voucherid', 'left')
            ->join('mst_itemgift g', 'g.mst_itemgiftid = v.mst_itemgiftid', 'left')
            ->where('r.act_redeemid', (int) $redeemId)
            ->get()
            ->row_array();

        if (!$redeem) {
            return ['success' => false, 'message' => 'Redeem data not found'];
        }

        if (!$this->pref_enabled('send_email_admin_redeem')) {
            return ['success' => false, 'message' => 'Send email admin redeem is disabled'];
        }

        $admins = $this->get_admin_emails();
        $this->configure_email();

        $redeemedDate = !empty($redeem['redeemed_date'])
            ? date('d M Y H:i', strtotime($redeem['redeemed_date']))
            : '-';

        $message = $this->load_view('emails/redeem_admin', [
            'itemname'       => $redeem['itemname'] ?? '-',
            'itemtype_label' => $redeem['itemtype'] == '1' ? 'POINT' : 'OTHER',
            'voucher_code'   => $redeem['voucher_code'] ?? '-',
            'custname'       => $redeem['custname'] ?? '-',
            'phone_number'   => !empty($redeem['phone_number']) ? '0' . ltrim($redeem['phone_number'], '0') : '-',
            'description'    => $redeem['description'] ?? '-',
            'customer_email' => $redeem['customer_email'] ?? '-',
            'redeemed_date'  => $redeemedDate,
            'ip_address'     => $redeem['ip_address'] ?? '-',
        ]);

        $subject = '[Redeem] ' . ($redeem['itemname'] ?? 'Gift') . ' — ' . ($redeem['custname'] ?? 'Customer');

        $this->email->from(getenv('EMAIL_FROM_ADDRESS') ?: 'no-reply@internalgroup.id', getenv('EMAIL_FROM_NAME') ?: 'Hoki Beli Illusions');
        $this->email->to($admins[0] ?? 'it@internalgrup.id');
        if (count($admins) > 1) {
            $this->email->bcc(array_slice($admins, 1));
        }
        $this->email->subject($subject);
        $this->email->message($message);

        $sent = $this->email->send();
        $error_message = $sent ? null : $this->get_email_error();
        $this->email->clear(true);

        foreach ($admins as $admin_email) {
            $admin_email = trim((string) $admin_email);
            if ($admin_email === '') {
                continue;
            }

            $this->log_email([
                'email_type' => 'redeem_admin',
                'recipient_email' => $admin_email,
                'recipient_name' => 'Admin',
                'subject' => $subject,
                'status' => $sent ? 'sent' : 'failed',
                'error_message' => $error_message,
                'related_redeemid' => (int) $redeemId,
            ]);
        }

        return [
            'success' => $sent,
            'message' => $sent ? 'Email sent to admin' : 'Failed to send email to admin'
        ];
    }

    public function emailConfirmToCustomer($redeemId)
    {
        $redeem = $this->db->select("
                r.*, c.custname, c.email as customer_email, 
                c.phone_number as customer_phone,
                g.itemname, g.itemtype,
                v.voucher_code
            ")
            ->from('act_redeem r')
            ->join('mst_customer c', 'c.mst_customerid = r.mst_customerid', 'left')
            ->join('mst_voucher v', 'v.mst_voucherid = r.mst_voucherid', 'left')
            ->join('mst_itemgift g', 'g.mst_itemgiftid = v.mst_itemgiftid', 'left')
            ->where('r.act_redeemid', (int) $redeemId)
            ->get()
            ->row_array();

        if (!$redeem) {
            return ['success' => false, 'message' => 'Redeem data not found'];
        }

        if (empty($redeem['customer_email'])) {
            return ['success' => false, 'message' => 'Customer email not found'];
        }

        if (!$this->pref_enabled('send_email_customer_redeem_confirmed')) {
            return ['success' => false, 'message' => 'Send email customer redeem confirmed is disabled'];
        }

        $this->configure_email();

        $this->load->model('Setpref_Model');
        $cs_email = $this->Setpref_Model->get_pref('cs_email') ?: 'support@internalgroup.id';
        $cs_phone = $this->Setpref_Model->get_pref('cs_phone') ?: '6285646877046';

        $redeemedDate = !empty($redeem['redeemed_date'])
            ? date('d M Y H:i', strtotime($redeem['redeemed_date']))
            : '-';

        if ($redeem['itemtype'] == '1') {
            $message = $this->load_view('emails/confirm_customer_wallet', [
                'itemname'       => $redeem['itemname'] ?? '-',
                'itemtype_label' => $redeem['itemtype'] == '1' ? 'POINT' : 'OTHER',
                'voucher_code'   => $redeem['voucher_code'] ?? '-',
                'customer_phone' => !empty($redeem['customer_phone']) ? '0' . ltrim($redeem['customer_phone'], '0') : '-',
                'description'    => $redeem['description'] ?? '-',
                'custname'       => $redeem['custname'] ?? '-',
                'redeemed_date'  => $redeemedDate,
                'cs_email'       => $cs_email,
                'cs_phone'       => $cs_phone,
            ]);
        } else if ($redeem['itemtype'] == '2') {
            $message = $this->load_view('emails/confirm_customer_shopee', [
                'itemname'       => $redeem['itemname'] ?? '-',
                'itemtype_label' => $redeem['itemtype'] == '1' ? 'POINT' : 'OTHER',
                'voucher_code'   => $redeem['voucher_code'] ?? '-',
                'custname'       => $redeem['custname'] ?? '-',
                'redeemed_date'  => $redeemedDate,
                'cs_email'       => $cs_email,
                'cs_phone'       => $cs_phone,
            ]);
        }

        $this->email->from(getenv('EMAIL_FROM_ADDRESS') ?: 'no-reply@internalgroup.id', getenv('EMAIL_FROM_NAME') ?: 'Hoki Beli Illusions');
        $this->email->to($redeem['customer_email']);
        $this->email->subject('Klaim Hadiah "' . ($redeem['itemname'] ?? 'Gift') . '" Berhasil');
        $this->email->message($message);

        $sent = $this->email->send();
        $error_message = $sent ? null : $this->get_email_error();
        $this->email->clear(true);

        $this->log_email([
            'email_type' => 'confirm_customer',
            'recipient_email' => $redeem['customer_email'] ?? '',
            'recipient_name' => $redeem['custname'] ?? null,
            'subject' => 'Klaim Hadiah "' . ($redeem['itemname'] ?? 'Gift') . '" Berhasil',
            'status' => $sent ? 'sent' : 'failed',
            'error_message' => $error_message,
            'related_redeemid' => (int) $redeemId,
        ]);

        return [
            'success' => $sent,
            'message' => $sent ? 'Confirmation email sent to customer' : 'Failed to send confirmation email'
        ];
    }

    public function emailCompleteToCustomer($redeemId)
    {
        $redeem = $this->db->select("
                r.*, c.custname, c.email as customer_email,
                c.phone_number as customer_phone,
                g.itemname, g.itemtype,
                v.voucher_code
            ")
            ->from('act_redeem r')
            ->join('mst_customer c', 'c.mst_customerid = r.mst_customerid', 'left')
            ->join('mst_voucher v', 'v.mst_voucherid = r.mst_voucherid', 'left')
            ->join('mst_itemgift g', 'g.mst_itemgiftid = v.mst_itemgiftid', 'left')
            ->where('r.act_redeemid', (int) $redeemId)
            ->get()
            ->row_array();

        if (!$redeem) {
            return ['success' => false, 'message' => 'Redeem data not found'];
        }

        if (empty($redeem['customer_email'])) {
            return ['success' => false, 'message' => 'Customer email not found'];
        }

        if (!$this->pref_enabled('send_email_customer_redeem_success')) {
            return ['success' => false, 'message' => 'Send email customer redeem success is disabled'];
        }

        $this->configure_email();

        $this->load->model('Setpref_Model');
        $cs_email = $this->Setpref_Model->get_pref('cs_email') ?: 'support@internalgroup.id';
        $cs_phone = $this->Setpref_Model->get_pref('cs_phone') ?: '+62 812-xxxx-xxxx';

        $completedDate = !empty($redeem['completed_date'])
            ? date('d M Y H:i', strtotime($redeem['completed_date']))
            : '-';

        $message = $this->load_view('emails/complete_customer', [
            'itemname'       => $redeem['itemname'] ?? '-',
            'itemtype_label' => $redeem['itemtype'] == '1' ? 'POINT' : 'OTHER',
            'customer_phone' => !empty($redeem['customer_phone']) ? '0' . ltrim($redeem['customer_phone'], '0') : '-',
            'description'    => $redeem['description'] ?? '-',
            'voucher_code'   => $redeem['voucher_code'] ?? '-',
            'custname'       => $redeem['custname'] ?? '-',
            'completed_date' => $completedDate ?? '-',
            'cs_email'       => $cs_email,
            'cs_phone'       => $cs_phone,
        ]);

        $this->email->from(getenv('EMAIL_FROM_ADDRESS') ?: 'no-reply@internalgroup.id', getenv('EMAIL_FROM_NAME') ?: 'Hoki Beli Illusions');
        $this->email->to($redeem['customer_email']);
        $this->email->subject('Hadiah "' . ($redeem['itemname'] ?? 'Gift') . '" Telah Dikirim');
        $this->email->message($message);

        $sent = $this->email->send();
        $error_message = $sent ? null : $this->get_email_error();
        $this->email->clear(true);

        $this->log_email([
            'email_type' => 'complete_customer',
            'recipient_email' => $redeem['customer_email'] ?? '',
            'recipient_name' => $redeem['custname'] ?? null,
            'subject' => 'Hadiah "' . ($redeem['itemname'] ?? 'Gift') . '" Telah Dikirim',
            'status' => $sent ? 'sent' : 'failed',
            'error_message' => $error_message,
            'related_redeemid' => (int) $redeemId,
        ]);

        return [
            'success' => $sent,
            'message' => $sent ? 'Email sent to customer' : 'Failed to send email to customer'
        ];
    }
}
