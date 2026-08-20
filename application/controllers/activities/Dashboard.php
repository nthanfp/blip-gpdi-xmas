<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');
        $this->load->model('Itemgift_Model');
        $this->load->model('Customer_Model');
        $this->load->model('Voucher_Model');
        $this->load->model('Redeem_Model');
    }

    private function guard_menu_access($menuid, $subperm = null)
    {
        $result = $this->Setmenu_Model->check_menu($menuid, $subperm);

        if (!$result['success'] || !$result['allowed']) {
            show_404();
            return false;
        }

        return true;
    }

    public function index()
    {
        if (!$this->Auth_Model->current_user()) {
            redirect(site_url('activities/authentication/login'));
            exit;
        }

        if (!$this->guard_menu_access(108, 'view')) {
            return;
        }

        $this->load->view('activities/dashboard', $this->_widget_permissions());
    }

    private function _widget_permissions()
    {
        $menus = [
            'can_itemgift' => 104,
            'can_customer' => 112,
            'can_voucher'  => 107,
            'can_redeem'   => 113,
        ];

        $data = [];
        foreach ($menus as $key => $menuid) {
            $check = $this->Setmenu_Model->check_menu($menuid, 'view');
            $data[$key] = $check['success'] && $check['allowed'];
        }

        return $data;
    }

    public function data_dashboard()
    {
        if (!$this->guard_menu_access(108, 'view')) {
            return;
        }
        $itemGiftData = $this->Itemgift_Model->data_list();
        $customerData = $this->Customer_Model->data_list();
        $voucherData = $this->Voucher_Model->data_list();
        $redeemData = $this->Redeem_Model->data_list();

        $this->Customer_Model->data_list_print();

        // Item Gift summary per item
        // Status =
        // 1 = Active
        // 2 = Printed
        // 3 = Redeemed
        // 4 = Completed
        // 5 = Rejected

        $this->db->select("
            v.mst_itemgiftid,
            g.itemname,
            COUNT(*) as total,
            SUM(CASE WHEN v.status IN (1,2) AND (v.expired_date IS NULL OR v.expired_date >= NOW()) THEN 1 ELSE 0 END) as available,
            SUM(CASE WHEN v.status IN (3,4,5) THEN 1 ELSE 0 END) as redeemed,
            SUM(CASE WHEN v.status = 4 THEN 1 ELSE 0 END) as completed,
            SUM(CASE WHEN v.status = 5 THEN 1 ELSE 0 END) as rejected,
            SUM(CASE WHEN v.status IN (1,2) AND (v.expired_date IS NOT NULL AND v.expired_date < NOW()) THEN 1 ELSE 0 END) as expired
        ");
        $this->db->from('mst_voucher v');
        $this->db->join('mst_itemgift g', 'g.mst_itemgiftid = v.mst_itemgiftid', 'left');
        $this->db->group_by('v.mst_itemgiftid, g.itemname');
        $this->db->order_by('g.itemname', 'ASC');
        $query = $this->db->get();
        $itemgift_summary = $query->result_array();

        // Chart data: redeemed by date (last 7 days)
        $this->db->select("DATE(r.redeemed_date) as redeem_date, COUNT(*) as count");
        $this->db->from('act_redeem r');
        $this->db->where("r.redeemed_date >= NOW() - INTERVAL '15 days'");
        $this->db->group_by('DATE(r.redeemed_date)');
        $this->db->order_by('redeem_date', 'ASC');
        $redeemed_by_date_raw = $this->db->get()->result_array();

        // Fill missing days with 0
        $redeemed_by_date = array();
        for ($i = 14; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $found = false;
            foreach ($redeemed_by_date_raw as $row) {
                if ($row['redeem_date'] === $date) {
                    $redeemed_by_date[] = array('redeem_date' => $date, 'count' => (int) $row['count']);
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $redeemed_by_date[] = array('redeem_date' => $date, 'count' => 0);
            }
        }

        // Chart data: overall status distribution
        $this->db->select("
            SUM(CASE WHEN v.status IN (1,2) AND (v.expired_date IS NULL OR v.expired_date >= NOW()) THEN 1 ELSE 0 END) as available,
            SUM(CASE WHEN v.status = 3 THEN 1 ELSE 0 END) as redeemed,
            SUM(CASE WHEN v.status = 4 THEN 1 ELSE 0 END) as completed,
            SUM(CASE WHEN v.status = 5 THEN 1 ELSE 0 END) as rejected,
            SUM(CASE WHEN v.status IN (1,2) AND (v.expired_date IS NOT NULL AND v.expired_date < NOW()) THEN 1 ELSE 0 END) as expired
        ");
        $this->db->from('mst_voucher v');
        $chart_total = $this->db->get()->row_array();

        // Average process time: redeemed → completed/rejected
        $processTimeQuery = $this->db->query("
            SELECT
                AVG(EXTRACT(EPOCH FROM (
                    COALESCE(r.completed_date, r.rejected_date) - r.redeemed_date
                )) / 3600.0) AS avg_hours,
                COUNT(CASE WHEN r.redeemed_date IS NOT NULL THEN 1 END) AS total_redeemed,
                COUNT(CASE WHEN r.completed_date IS NOT NULL OR r.rejected_date IS NOT NULL THEN 1 END) AS total_processed,
                COUNT(CASE WHEN r.completed_date IS NOT NULL THEN 1 END) AS total_completed,
                COUNT(CASE WHEN r.rejected_date IS NOT NULL THEN 1 END) AS total_rejected
            FROM act_redeem r
            WHERE r.redeemed_date IS NOT NULL
        ");
        $processTime = $processTimeQuery->row_array();

        $totalRedeemed = (int) ($processTime['total_redeemed'] ?? 0);
        $totalCompleted = (int) ($processTime['total_completed'] ?? 0);
        $utilizationPct = ($totalRedeemed > 0)
            ? round(($totalCompleted / $totalRedeemed) * 100, 1)
            : 0;

        $data = array(
            'widget_count' => array(
                'itemgift' => $itemGiftData['pagination']['total'] ?? 0,
                'customer' => $customerData['pagination']['total'] ?? 0,
                'voucher' => $voucherData['pagination']['total'] ?? 0,
                'redeem' => $redeemData['pagination']['total'] ?? 0
            ),
            'itemgift_summary' => $itemgift_summary,
            'chart_total' => $chart_total,
            'redeemed_by_date' => $redeemed_by_date,
            'process_time' => array(
                'avg_hours' => round((float) ($processTime['avg_hours'] ?? 0), 1),
                'total_processed' => (int) ($processTime['total_processed'] ?? 0),
                'total_completed' => (int) ($processTime['total_completed'] ?? 0),
                'total_rejected' => (int) ($processTime['total_rejected'] ?? 0),
                'utilization_pct' => $utilizationPct
            )
        );

        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
    }
}
