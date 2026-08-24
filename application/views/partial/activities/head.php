<meta charset="utf-8">
<title>Activities - INTERNAL GRUP</title>

<link rel="manifest" href="<?php echo base_url('manifest.json'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<meta name="theme-color" content="#343a40">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

<meta name="referrer" content="strict-origin-when-cross-origin">
<meta name="csrf-token-value" content="<?php echo $this->security->get_csrf_hash(); ?>">
<meta name="csrf-token-name" content="<?php echo $this->security->get_csrf_token_name(); ?>">

<!-- Favicon -->
<link href="<?php echo base_url('assets/icons/favicon.ico'); ?>" rel="icon" type="image/x-icon" />
<link href="<?php echo base_url('assets/icons/apple-touch-icon.png');  ?>" rel="apple-touch-icon">

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/fonts.css'); ?>">

<!-- Admin LTE CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/adminlte.min.css'); ?>" />

<!-- Sweeetalert CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/sweetalert2/sweetalert2.min.css'); ?>" />

<!-- Fontawesome Icons -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>" />

<!-- iCheck -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>" />

<!-- Boostrap Select -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css'); ?>" />

<!-- Bootstrap Select Custom -->
<style type="text/css">
    .bootstrap-select .dropdown-toggle {
        background-color: #fff !important;
        border: 1px solid #ced4da !important;
        height: calc(1.8125rem + 2px) !important;
        padding: .25rem .5rem !important;
        font-size: .875rem !important;
        line-height: 1.5 !important;
        border-radius: .2rem !important;
    }

    .bootstrap-select .dropdown-toggle:focus {
        outline: none !important;
        box-shadow: none !important;
    }

    .bootstrap-select .dropdown-toggle .filter-option {
        color: #495057;
    }

    .bootstrap-select .dropdown-menu {
        border-radius: .25rem;
    }

    .bootstrap-select .filter-option {
        display: flex;
        align-items: center;
    }

    .input-group .input-group-text {
        border-right: 0;
    }

    .input-group .bootstrap-select .dropdown-toggle {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
        margin-left: -1px;
    }

    .input-group.input-group-sm>.bootstrap-select>.dropdown-toggle {
        height: calc(1.8125rem + 2px) !important;
        padding: .25rem .5rem !important;
        font-size: .875rem !important;
        line-height: 1.5 !important;
    }

    .input-group.input-group-sm>.bootstrap-select {
        flex: 1 1 auto;
    }

    .input-group.input-group-sm .input-group-text {
        min-width: 38px;
        padding-left: 0;
        padding-right: 0;
        justify-content: center;
    }
</style>
<!-- Topnav Layout (only applies when body.layout-top-nav) -->
<style>
    /* ===== Dropdown submenu (nested menus) ===== */
    body.layout-top-nav .dropdown-submenu {
        position: relative;
    }

    body.layout-top-nav .dropdown-submenu>.dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -1px;
        margin-left: -1px;
        border-radius: 0 .375rem .375rem .375rem;
    }

    body.layout-top-nav .dropdown-submenu:hover>.dropdown-menu {
        display: block;
    }

    /* Arrow indicator for submenu items */
    body.layout-top-nav .dropdown-submenu>a::after {
        display: inline-block;
        width: 0;
        height: 0;
        margin-left: .5rem;
        vertical-align: middle;
        border-top: .3em solid transparent;
        border-right: 0;
        border-bottom: .3em solid transparent;
        border-left: .3em solid;
        content: "";
    }

    /* Reverse arrow for RTL or left-positioned submenus */
    body.layout-top-nav .dropdown-submenu.pull-left {
        float: none;
    }

    body.layout-top-nav .dropdown-submenu.pull-left>.dropdown-menu {
        left: -100%;
        margin-left: 10px;
        border-radius: .375rem 0 .375rem .375rem;
    }

    /* ===== Content: full width, no sidebar offset ===== */
    body.layout-top-nav .content-wrapper {
        margin-left: 0;
    }

    body.layout-top-nav .content-wrapper .container {
        max-width: 100%;
    }

    /* ===== Brand link (hidden in topnav — brand is in navbar) ===== */
    body.layout-top-nav .main-sidebar .brand-link {
        display: none;
    }

    /* ===== Sidebar hidden ===== */
    body.layout-top-nav .main-sidebar {
        display: none;
    }

    /* ===== Responsive: stack menu on mobile ===== */
    @media (max-width: 767.98px) {
        body.layout-top-nav .main-header.navbar .navbar-nav .nav-item {
            border-bottom: 1px solid rgba(0, 0, 0, .05);
        }

        body.layout-top-nav .main-header.navbar .navbar-nav .dropdown-menu {
            border-top: 0;
            box-shadow: none;
        }

        /* Submenu opens inline on mobile */
        body.layout-top-nav .dropdown-submenu>.dropdown-menu {
            position: static !important;
            float: none;
            width: auto;
            margin: 0 .5rem;
            border: 0;
            box-shadow: none;
        }
    }
</style>