<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Userguide extends CI_Controller
{
    private $modules = array(
        'dashboard' => array(
            'menuid'   => 108,
            'title'    => 'Dashboard',
            'icon'     => 'fas fa-tachometer-alt',
            'desc'     => 'Overview data dan statistik sistem.',
            'color'    => 'blue',
        ),
        'itemgift' => array(
            'menuid'   => 104,
            'title'    => 'Item Gift',
            'icon'     => 'fas fa-gift',
            'desc'     => 'Kelola daftar item hadiah yang tersedia.',
            'color'    => 'green',
        ),
        'voucher' => array(
            'menuid'   => 107,
            'title'    => 'Voucher',
            'icon'     => 'fas fa-ticket-alt',
            'desc'     => 'Buat dan kelola voucher hadiah.',
            'color'    => 'purple',
        ),
        'redeem' => array(
            'menuid'   => 113,
            'title'    => 'Redeem',
            'icon'     => 'fas fa-hand-holding-usd',
            'desc'     => 'Proses klaim dan verifikasi hadiah.',
            'color'    => 'red',
        ),
        'customer' => array(
            'menuid'   => 112,
            'title'    => 'Customer',
            'icon'     => 'fas fa-users',
            'desc'     => 'Kelola data pelanggan.',
            'color'    => 'cyan',
        ),
        'user' => array(
            'menuid'   => 103,
            'title'    => 'User',
            'icon'     => 'fas fa-user-cog',
            'desc'     => 'Kelola akun admin dan hak akses.',
            'color'    => 'yellow',
        ),
        'setmenu' => array(
            'menuid'   => 102,
            'title'    => 'Menu',
            'icon'     => 'fas fa-bars',
            'desc'     => 'Kelola struktur menu dan permission.',
            'color'    => 'teal',
        ),
        'setpref' => array(
            'menuid'   => 116,
            'title'    => 'Preferences',
            'icon'     => 'fas fa-cog',
            'desc'     => 'Pengaturan sistem dan konfigurasi.',
            'color'    => 'orange',
        ),
        'logadmin' => array(
            'menuid'   => 111,
            'title'    => 'Log Admin',
            'icon'     => 'fas fa-clipboard-list',
            'desc'     => 'Riwayat aktivitas admin.',
            'color'    => 'gray',
        ),
        'notification' => array(
            'menuid'   => 118,
            'title'    => 'Notification',
            'icon'     => 'fas fa-bell',
            'desc'     => 'Kelola notifikasi dan push notification.',
            'color'    => 'pink',
        ),
        'fcmtoken' => array(
            'menuid'   => 119,
            'title'    => 'FCM Token',
            'icon'     => 'fas fa-mobile-alt',
            'desc'     => 'Kelola token perangkat untuk push notification.',
            'color'    => 'indigo',
        ),
        'logemail' => array(
            'menuid'   => 120,
            'title'    => 'Log Email',
            'icon'     => 'fas fa-envelope-open-text',
            'desc'     => 'Lihat riwayat pengiriman email notifikasi.',
            'color'    => 'lime',
        ),
        'logapi' => array(
            'menuid'   => 122,
            'title'    => 'Log API',
            'icon'     => 'fas fa-exchange-alt',
            'desc'     => 'Lihat riwayat request API beserta status dan waktu eksekusi.',
            'color'    => 'red',
        ),
        'apikey' => array(
            'menuid'   => 123,
            'title'    => 'API Key',
            'icon'     => 'fas fa-key',
            'desc'     => 'Kelola API key untuk autentikasi eksternal.',
            'color'    => 'amber',
        ),
        'sync' => array(
            'menuid'   => 121,
            'title'    => 'Sync',
            'icon'     => 'fas fa-sync-alt',
            'desc'     => 'Sinkronisasi data proof of purchase dan proof completed.',
            'color'    => 'cyan',
        ),
    );

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_Model');
        $this->load->model('Setmenu_Model');

        if (!$this->Auth_Model->current_user()) {
            redirect(site_url('activities/authentication/login'));
            exit;
        }
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
        $available = array();

        foreach ($this->modules as $slug => $mod) {
            $check = $this->Setmenu_Model->check_menu($mod['menuid'], 'view');
            if ($check['success'] && $check['allowed']) {
                $available[$slug] = $mod;
            }
        }

        $data = array(
            'modules' => $available,
        );

        $this->load->view('user_guides/index', $data);
    }

    public function module($slug = '')
    {
        if (!isset($this->modules[$slug])) {
            show_404();
            return;
        }

        $mod = $this->modules[$slug];

        if (!$this->guard_menu_access($mod['menuid'], 'view')) {
            return;
        }

        $accessible = array();
        foreach ($this->modules as $key => $item) {
            $check = $this->Setmenu_Model->check_menu($item['menuid'], 'view');
            if ($check['success'] && $check['allowed']) {
                $accessible[] = $key;
            }
        }

        $current_index = array_search($slug, $accessible);

        $prev_slug = null;
        $prev_title = '';
        $next_slug = null;
        $next_title = '';

        if ($current_index !== false && $current_index > 0) {
            $prev_key = $accessible[$current_index - 1];
            $prev_slug = $prev_key;
            $prev_title = $this->modules[$prev_key]['title'];
        }

        if ($current_index !== false && $current_index < count($accessible) - 1) {
            $next_key = $accessible[$current_index + 1];
            $next_slug = $next_key;
            $next_title = $this->modules[$next_key]['title'];
        }

        $data = array(
            'slug'       => $slug,
            'title'      => $mod['title'],
            'icon'       => $mod['icon'],
            'menuid'     => $mod['menuid'],
            'prev_slug'  => $prev_slug,
            'prev_title' => $prev_title,
            'next_slug'  => $next_slug,
            'next_title' => $next_title,
        );

        $this->load->view('user_guides/module', $data);
    }
}
