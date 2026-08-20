<?php
$CI = &get_instance();
if (!isset($CI->Setmenu_Model)) {
    $CI->load->model('Setmenu_Model');
}

if (!isset($CI->Auth_Model)) {
    $CI->load->model('Auth_Model');
}

$sidebar_menus = $CI->Setmenu_Model->get_sidebar_menu_tree();
$username_user = $CI->Auth_Model->current_user()->username;
$current_uri = trim(uri_string(), '/');

if (!function_exists('render_sidebar_menu_items')) {
    function sidebar_menu_is_active(array $item, $current_uri)
    {
        $item_path = trim((string) $item['path'], '/');
        if ($item_path !== '' && $item_path !== '#' && $item_path === $current_uri) {
            return true;
        }

        if (empty($item['children'])) {
            return false;
        }

        foreach ($item['children'] as $child) {
            if (sidebar_menu_is_active($child, $current_uri)) {
                return true;
            }
        }

        return false;
    }

    function sidebar_menu_icon(array $item, $fallback = 'far fa-circle')
    {
        $icon = trim((string) ($item['icon'] ?? ''));

        return $icon !== '' ? $icon : $fallback;
    }

    function render_sidebar_menu_items(array $items, $current_uri)
    {
        foreach ($items as $item) {
            if (isset($item['sort_order']) && (int) $item['sort_order'] >= 9998) {
                continue;
            }
            $has_children = !empty($item['children']);
            $is_active = sidebar_menu_is_active($item, $current_uri);
            $icon_class = sidebar_menu_icon($item, $has_children ? 'far fa-list-alt' : 'far fa-circle');
            $href = (!empty($item['path']) && trim((string) $item['path']) !== '#')
                ? site_url($item['path'])
                : '#';

            $li_class = 'nav-item';
            if ($has_children && $is_active) {
                $li_class .= ' menu-open';
            }

            $link_class = 'nav-link';
            if ($is_active) {
                $link_class .= ' active';
            }

            if ($has_children) {
                echo '<li class="' . $li_class . '">';
                echo '<a href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '" class="' . $link_class . '">';
                echo '<i class="nav-icon ' . htmlspecialchars($icon_class, ENT_QUOTES, 'UTF-8') . '"></i>';
                echo '<p>' . htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') . '<i class="right fas fa-angle-left"></i></p>';
                echo '</a>';
                echo '<ul class="nav nav-treeview">';
                render_sidebar_menu_items($item['children'], $current_uri);
                echo '</ul>';
                echo '</li>';
                continue;
            }

            echo '<li class="' . $li_class . '">';
            echo '<a href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '" class="' . $link_class . '">';
            echo '<i class="nav-icon ' . htmlspecialchars($icon_class, ENT_QUOTES, 'UTF-8') . '"></i>';
            echo '<p>' . htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') . '</p>';
            echo '</a>';
            echo '</li>';
        }
    }
}
?>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block"></li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item text-muted" id="dbSelectorNavbar" style="display:none">
            <a class="nav-link">
                <i class="fas fa-database mr-1"></i> <span id="currentDBName" class="font-italic">--</span>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                <i class="fas fa-user"></i> <?php echo $username_user; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header"><?php echo $username_user; ?></span>
                <div class="dropdown-divider"></div>
                <a href="<?php echo site_url('activities/authentication/password'); ?>" class="dropdown-item">
                    <i class="fas fa-lock"></i> Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo site_url('activities/authentication/logout'); ?>" class="dropdown-item">
                    <i class="fas fa-sign-out-alt"></i> Sign Out
                </a>
            </div>
        </li>
        <li class="nav-item dropdown" id="notifDropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                <i class="far fa-bell"></i>
                <span id="notifBadge" class="badge badge-warning navbar-badge d-none">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0">
                <span class="dropdown-item dropdown-header" id="notifSubtitle">0 unread</span>
                <div class="dropdown-divider"></div>
                <div id="notifList" style="max-height: 420px; overflow-y: auto;">
                    <div class="dropdown-item text-muted text-center py-3 small">No notifications</div>
                </div>
                <div class="dropdown-divider m-0"></div>
                <div class="d-flex">
                    <a href="#" class="dropdown-item text-center small py-2 flex-grow-1 border-right" id="notifMarkAllRead">
                        <i class="fas fa-check-double mr-1"></i> Mark all read
                    </a>
                    <a href="<?php echo site_url('activities/notification/push'); ?>" class="d-none dropdown-item text-center small py-2 flex-grow-1 border-right text-info">
                        <i class="fas fa-paper-plane mr-1"></i> Custom Push
                    </a>
                    <a href="#" class="d-none dropdown-item text-center small py-2 flex-grow-1 text-primary" id="notifTestPush">
                        <i class="fas fa-flask mr-1"></i> Test
                    </a>
                </div>
            </div>
        </li>
    </ul>
</nav>

<aside class="main-sidebar sidebar-dark-secondary elevation-4">
    <a href="<?= site_url('activities/dashboard') ?>" class="brand-link">
        <img src="<?php echo base_url('assets/icons/logo.png'); ?>" alt="ITG Logo" class="brand-image"
            style="opacity: .8; filter: brightness(0) invert(1);">
        <span class="brand-text font-weight-bold mx-2">INTERNAL GRUP</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php if (!empty($sidebar_menus)): ?>
                    <?php render_sidebar_menu_items($sidebar_menus, $current_uri); ?>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="<?= site_url('activities/dashboard') ?>" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-header mt-3">Help</li>
                <li class="nav-item">
                    <a href="<?= site_url('activities/userguide') ?>" class="nav-link">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>User Guides</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>