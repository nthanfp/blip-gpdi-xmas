<meta charset="UTF-8" />
<title>Hoki Beli Illusions — INTERNAL GRUP</title>

<meta name="theme-color" content="#730A13">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

<meta name="referrer" content="strict-origin-when-cross-origin">
<meta name="csrf-token-value" content="<?php echo $this->security->get_csrf_hash(); ?>">
<meta name="csrf-token-name" content="<?php echo $this->security->get_csrf_token_name(); ?>">

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="<?php echo site_url('assets/icons/favicon.ico'); ?>" />

<!-- Self-hosted Fonts -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/font.css'); ?>" />

<!-- Tailwind CSS CDN -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/tailwind.css'); ?>">

<!-- Fontawesome Icons -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>" />


<!-- Custom Styles -->
<style type="text/css">
    html,
    body {
        width: 100%;
        min-height: 100dvh;
        overflow-x: hidden;
        scroll-behavior: smooth;
        -webkit-text-size-adjust: 100%;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-rendering: optimizeLegibility;
    }

    body {
        font-family: 'Inter', sans-serif;

        background:
            linear-gradient(to bottom,
                rgba(0, 0, 0, 0.28),
                rgba(0, 0, 0, 0.12)),

            linear-gradient(180deg,
                rgba(115, 10, 19, 0.90) 0%,
                rgba(136, 19, 21, 0.72) 38%,
                rgba(95, 10, 16, 0.78) 68%,
                rgba(45, 2, 8, 0.90) 100%),

            url("<?php echo site_url('assets/images/liqua.jpg'); ?>");

        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        background-attachment: scroll;
    }

    /* Safari Fix */
    @supports (-webkit-touch-callout: none) {
        body {
            min-height: -webkit-fill-available;
        }
    }

    /* Prevent overflow Safari */
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    .page {
        display: none;
    }

    .page.active {
        display: block;
        animation: fadeUp .3s ease;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%238B5E3C' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 32px !important;
        appearance: none;
        -webkit-appearance: none;
    }

    .font-serif-italic {
        font-family: 'Playfair Display', serif;
        font-style: italic;
    }

    .safari-fix-height {
        min-height: calc(100dvh - 72px);
    }

    .safari-blur-fix {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);

        transform: translateZ(0);
        -webkit-transform: translateZ(0);

        will-change: transform;
        isolation: isolate;
    }

    input,
    select,
    textarea {
        font-size: 16px !important;
    }

    @supports (-webkit-touch-callout: none) {
        .safari-blur-fix {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    }
</style>