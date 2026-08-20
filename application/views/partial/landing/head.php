<meta charset="UTF-8" />
<title>Internal Grup</title>

<meta name="theme-color" content="#ffffff">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="referrer" content="strict-origin-when-cross-origin">
<meta name="csrf-token-value" content="<?php echo $this->security->get_csrf_hash(); ?>">
<meta name="csrf-token-name" content="<?php echo $this->security->get_csrf_token_name(); ?>">

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="<?php echo site_url('assets/icons/favicon.ico'); ?>" />

<!-- Tailwind CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/tailwind.css'); ?>">

<!-- Fontawesome Icons -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>" />

<style type="text/css">
    html,
    body {
        width: 100%;
        min-height: 100dvh;
        overflow-x: hidden;
        -webkit-text-size-adjust: 100%;
        -webkit-font-smoothing: antialiased;
    }

    body {
        font-family: 'Inter', sans-serif;
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }
</style>
