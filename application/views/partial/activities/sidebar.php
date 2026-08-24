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
$nav_layout = nav_layout();

// ===== Sidebar mode helpers =====

if (!function_exists('sidebar_menu_is_active')) {
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
}

if (!function_exists('sidebar_menu_icon')) {
    function sidebar_menu_icon(array $item, $fallback = 'far fa-circle')
    {
        $icon = trim((string) ($item['icon'] ?? ''));

        return $icon !== '' ? $icon : $fallback;
    }
}

if (!function_exists('render_sidebar_menu_items')) {
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

// ===== Topnav mode helpers =====

if (!function_exists('topnav_menu_is_active')) {
    function topnav_menu_is_active(array $item, $current_uri)
    {
        $item_path = trim((string) $item['path'], '/');
        if ($item_path !== '' && $item_path !== '#' && $item_path === $current_uri) {
            return true;
        }

        if (empty($item['children'])) {
            return false;
        }

        foreach ($item['children'] as $child) {
            if (topnav_menu_is_active($child, $current_uri)) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('render_topnav_menu_items')) {
    /**
     * Render topnav menu items.
     * @param int $depth Internal depth counter for nested submenus
     */
    function render_topnav_menu_items(array $items, $current_uri, $depth = 0)
    {
        foreach ($items as $item) {
            if (isset($item['sort_order']) && (int) $item['sort_order'] >= 9998) {
                continue;
            }

            $has_children = !empty($item['children']);
            $is_active = topnav_menu_is_active($item, $current_uri);
            $icon_class = sidebar_menu_icon($item, 'far fa-circle');
            $href = (!empty($item['path']) && trim((string) $item['path']) !== '#')
                ? site_url($item['path'])
                : '#';

            $link_class = 'dropdown-item';
            if ($is_active) {
                $link_class .= ' active';
            }

            if ($has_children) {
                echo '<li class="dropdown-submenu">';
                echo '<a href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '" class="' . $link_class . ' dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');
                echo '</a>';
                echo '<ul class="dropdown-menu border-0 shadow">';
                render_topnav_menu_items($item['children'], $current_uri, $depth + 1);
                echo '</ul>';
                echo '</li>';
                continue;
            }

            echo '<li>';
            echo '<a href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '" class="' . $link_class . '">';
            echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');
            echo '</a>';
            echo '</li>';
        }
    }
}
?>

<?php if ($nav_layout === 'topnav'): ?>
    <!-- ===== TOP NAV LAYOUT ===== -->
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
            <a href="<?php echo site_url('activities/dashboard'); ?>" class="navbar-brand">
                <!-- <img src="<?php echo base_url('assets/icons/logo.png'); ?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
                <span class="brand-text font-weight-light">Admin</span>
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <!-- Left navbar links (dynamic menu) -->
                <ul class="navbar-nav">
                    <?php if (!empty($sidebar_menus)): ?>
                        <?php foreach ($sidebar_menus as $item): ?>
                            <?php if (isset($item['sort_order']) && (int) $item['sort_order'] >= 9998) continue; ?>
                            <?php
                            $has_children = !empty($item['children']);
                            $is_active = topnav_menu_is_active($item, $current_uri);
                            $href = (!empty($item['path']) && trim((string) $item['path']) !== '#')
                                ? site_url($item['path'])
                                : '#';
                            ?>
                            <?php if ($has_children): ?>
                                <li class="nav-item dropdown">
                                    <a href="<?php echo htmlspecialchars($href, ENT_QUOTES, 'UTF-8'); ?>" class="nav-link dropdown-toggle <?php echo $is_active ? 'active' : ''; ?>" data-toggle="dropdown">
                                        <?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                    <ul class="dropdown-menu border-0 shadow">
                                        <?php render_topnav_menu_items($item['children'], $current_uri); ?>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a href="<?php echo htmlspecialchars($href, ENT_QUOTES, 'UTF-8'); ?>" class="nav-link <?php echo $is_active ? 'active' : ''; ?>">
                                        <?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="<?php echo site_url('activities/dashboard'); ?>" class="nav-link">
                                <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a href="<?php echo site_url('activities/userguide'); ?>" class="nav-link">
                            <i class="fas fa-book-open mr-1"></i> Guides
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Right navbar links -->
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <li class="nav-item text-muted" id="dbSelectorNavbar" style="display:none">
                    <a class="nav-link">
                        <i class="fas fa-database mr-1"></i> <span id="currentDBName" class="font-italic">--</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
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
                    <a class="nav-link" data-toggle="dropdown" href="#">
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
        </div>
    </nav>

<?php else: ?>
    <!-- ===== SIDEBAR LAYOUT ===== -->
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
            <img src="<?php echo base_url('assets/icons/logo.png'); ?>" alt="Logo" class="brand-image"
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
<?php endif; ?>