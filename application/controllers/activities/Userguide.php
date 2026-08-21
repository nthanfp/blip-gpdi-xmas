<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Userguide extends CI_Controller
{
    private $modules = array(
        'dashboard' => array(
            'menuid'   => 108,
            'title'    => 'Dashboard',
            'icon'     => 'fas fa-home',
            'desc'     => 'Overview data dan statistik sistem.',
            'color'    => 'blue',
        ),
        'user' => array(
            'menuid'   => 103,
            'title'    => 'Admin',
            'icon'     => 'fas fa-users-cog',
            'desc'     => 'Kelola akun admin dan hak akses.',
            'color'    => 'yellow',
        ),
        'setmenu' => array(
            'menuid'   => 102,
            'title'    => 'Set Menu',
            'icon'     => 'fas fa-bars',
            'desc'     => 'Kelola struktur menu dan permission.',
            'color'    => 'teal',
        ),
        'setpref' => array(
            'menuid'   => 116,
            'title'    => 'Set Pref',
            'icon'     => 'fas fa-cog',
            'desc'     => 'Pengaturan sistem dan konfigurasi.',
            'color'    => 'orange',
        ),
        'logadmin' => array(
            'menuid'   => 111,
            'title'    => 'Log Admin',
            'icon'     => 'fas fa-clipboard-list',
            'desc'     => 'Lihat dan cetak log aktivitas admin.',
            'color'    => 'red',
        ),
        'apikey' => array(
            'menuid'   => 123,
            'title'    => 'API Key',
            'icon'     => 'fas fa-key',
            'desc'     => 'Kelola API key untuk autentikasi eksternal.',
            'color'    => 'purple',
        ),
        'region_province' => array(
            'menuid'   => 125,
            'title'    => 'Province',
            'icon'     => 'fas fa-map',
            'desc'     => 'Kelola data provinsi.',
            'color'    => 'green',
        ),
        'region_city' => array(
            'menuid'   => 126,
            'title'    => 'City',
            'icon'     => 'fas fa-city',
            'desc'     => 'Kelola data kota/kabupaten.',
            'color'    => 'green',
        ),
        'region_district' => array(
            'menuid'   => 127,
            'title'    => 'District',
            'icon'     => 'fas fa-building',
            'desc'     => 'Kelola data kecamatan.',
            'color'    => 'green',
        ),
        'region_village' => array(
            'menuid'   => 128,
            'title'    => 'Village',
            'icon'     => 'fas fa-home',
            'desc'     => 'Kelola data kelurahan.',
            'color'    => 'green',
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
