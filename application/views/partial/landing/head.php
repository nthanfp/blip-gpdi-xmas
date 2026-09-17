<meta charset="UTF-8" />
<title>Internal Grup</title>

<meta name="theme-color" content="#ffffff">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="referrer" content="strict-origin-when-cross-origin">
<meta name="csrf-token-value" content="<?php echo $this->security->get_csrf_hash(); ?>">
<meta name="csrf-token-name" content="<?php echo $this->security->get_csrf_token_name(); ?>">

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="<?php echo site_url('assets/icons/favicon.ico'); ?>" />

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

<!-- Tailwind CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/tailwind.css'); ?>">

<!-- Fontawesome Icons -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>" />

<style type="text/css">
    html,
    body {
        width: 100%;
        -webkit-text-size-adjust: 100%;
        -webkit-font-smoothing: antialiased;
        scroll-behavior: smooth;
        scroll-padding-top: 0;
    }

    /* Desktop: lock body scroll — only right panel scrolls */
    @media (min-width: 1024px) {
        html, body {
            overflow: hidden;
            height: 100vh;
        }
    }

    body {
        font-family: 'Inter', sans-serif;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Playfair Display', serif;
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    /* ── Fade-in on scroll ── */
    .fi {
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.6s cubic-bezier(0.22, 1, 0.36, 1),
                    transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .fi.fi-visible {
        opacity: 1;
        transform: translateY(0);
    }
    .fi.fi-delay-1 { transition-delay: 0.1s; }
    .fi.fi-delay-2 { transition-delay: 0.2s; }
    .fi.fi-delay-3 { transition-delay: 0.3s; }
    .fi.fi-delay-4 { transition-delay: 0.4s; }

    /* ── Card hover lift ── */
    .card-hover {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.08),
                    0 4px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* ── Desktop right-panel scroll ── */
    .xmas-scroll {
        -webkit-overflow-scrolling: touch;
        overscroll-behavior: contain;
    }

    /* ── Reduced motion ── */
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
            scroll-behavior: auto !important;
        }
        .fi {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }
    }
</style>
