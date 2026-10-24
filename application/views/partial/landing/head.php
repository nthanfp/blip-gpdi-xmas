<meta charset="UTF-8" />
<title>From Glory to Glory - Christmas GPdI Kopo Permai 2026</title>

<!-- Open Graph / WhatsApp / Facebook / Telegram -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="GPdI Kopo Permai">
<meta property="og:title" content="From Glory to Glory — Christmas Celebration 2026 | GPdI Kopo Permai">
<meta property="og:description" content="Perayaan Natal GPdI Kopo Permai — Minggu, 20 Desember 2026 pukul 17.00 WIB di GPdI Kopo Permai, Bandung. Amankan kursi Anda dan keluarga untuk merayakan Natal bersama kami.">
<meta property="og:url" content="<?php echo site_url(); ?>">
<meta property="og:image" content="<?php echo site_url('assets/images/christmas/og-hero-16x9.jpg'); ?>">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:width" content="1920">
<meta property="og:image:height" content="1080">
<meta property="og:image:alt" content="Christmas Celebration 2026 — From Glory to Glory, GPdI Kopo Permai">

<!-- Twitter / X -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="From Glory to Glory — Christmas Celebration 2026 | GPdI Kopo Permai">
<meta name="twitter:description" content="Perayaan Natal GPdI Kopo Permai — Minggu, 20 Desember 2026 pukul 17.00 WIB. Amankan kursi Anda dan keluarga.">
<meta name="twitter:image" content="<?php echo site_url('assets/images/christmas/og-hero-16x9.jpg'); ?>">

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

<!-- AOS (Animate On Scroll) -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/plugins/aos/aos.css'); ?>">

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

    /* AOS: paksa tampil normal jika user minta reduce motion */
    @media (prefers-reduced-motion: reduce) {
        [data-aos] {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
            animation: none !important;
        }
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

    /* ══════════════════════════════════════════════
       Luxurious gold gradient accents (Christmas)
       ══════════════════════════════════════════════ */

    /* Gold solid (button/CTA) → gradient bercahaya */
    .bg-gold-400,
    .bg-gold-500,
    .bg-gold-600 {
        background-image: linear-gradient(135deg, #f9e7ad 0%, #e8d48b 22%, #d4af37 48%, #b8912f 72%, #eedd9b 100%) !important;
    }

    /* Hover state tombol gold */
    .hover\:bg-gold-600:hover {
        background-image: linear-gradient(135deg, #eedd9b 0%, #d4af37 30%, #a8893b 62%, #dcc764 100%) !important;
    }

    /* Garis/dot dekorasi emas → gradient lembut */
    .bg-gold-400\/50,
    .bg-gold-400\/60 {
        background-image: linear-gradient(90deg, transparent 0%, #e8d48b 25%, #d4af37 50%, #e8d48b 75%, transparent 100%) !important;
    }
</style>
