<?php
/* Database selector: hanya tampil di lokal (localhost/127.0.0.1), di server production disembunyikan */
$isLocalEnv = (isset($_SERVER['HTTP_HOST']) &&
    (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Login - GPdI Kopo Permai</title>

    <meta name="theme-color" content="#450a0a">
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

    <!-- Sweetalert CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/plugins/sweetalert2/sweetalert2.min.css'); ?>" />

    <style type="text/css">
        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Playfair Display', serif;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        .login-stars {
            background-image:
                radial-gradient(1px 1px at 20% 30%, rgba(245, 158, 11, 0.4) 0%, transparent 100%),
                radial-gradient(1px 1px at 80% 20%, rgba(245, 158, 11, 0.3) 0%, transparent 100%),
                radial-gradient(1px 1px at 40% 70%, rgba(245, 158, 11, 0.25) 0%, transparent 100%),
                radial-gradient(1px 1px at 60% 50%, rgba(255, 255, 255, 0.15) 0%, transparent 100%),
                radial-gradient(1px 1px at 10% 80%, rgba(245, 158, 11, 0.2) 0%, transparent 100%),
                radial-gradient(1.5px 1.5px at 90% 60%, rgba(245, 158, 11, 0.3) 0%, transparent 100%),
                radial-gradient(1px 1px at 50% 10%, rgba(255, 255, 255, 0.2) 0%, transparent 100%),
                radial-gradient(1px 1px at 30% 90%, rgba(245, 158, 11, 0.15) 0%, transparent 100%),
                radial-gradient(1.5px 1.5px at 70% 85%, rgba(245, 158, 11, 0.25) 0%, transparent 100%),
                radial-gradient(1px 1px at 15% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
        }

        #selectedDatabase option {
            background: #ffffff;
            color: #1c1917;
        }
    </style>
</head>

<body class="bg-red-950 text-stone-200 antialiased">

    <div class="relative min-h-[100dvh] flex items-center justify-center px-5 py-10 overflow-hidden">

        <!-- Background image -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: url('<?php echo site_url('assets/images/christmas/hero.webp'); ?>');"></div>
        <!-- Maroon overlay -->
        <div class="absolute inset-0 bg-red-950/75"></div>
        <!-- Depth gradient -->
        <div class="absolute inset-0 bg-gradient-to-b from-red-950/80 via-red-950/50 to-red-950/90"></div>
        <!-- Soft glow -->
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(245,158,11,0.08)_0%,_transparent_70%)]">
        </div>

        <!-- Decorative stars (CSS) -->
        <div class="login-stars absolute inset-0 pointer-events-none"></div>

        <!-- Soft bokeh dots -->
        <div class="absolute top-[10%] left-[15%] w-2 h-2 rounded-full bg-gold-400/20 blur-[1px] animate-pulse"></div>
        <div class="absolute top-[25%] right-[20%] w-1.5 h-1.5 rounded-full bg-gold-300/15 blur-[1px] animate-pulse"
            style="animation-delay: 1s;"></div>
        <div class="absolute bottom-[30%] left-[10%] w-1 h-1 rounded-full bg-gold-400/25 blur-[1px] animate-pulse"
            style="animation-delay: 2s;"></div>
        <div class="absolute bottom-[20%] right-[25%] w-2 h-2 rounded-full bg-gold-300/15 blur-[1px] animate-pulse"
            style="animation-delay: 0.5s;"></div>
        <div class="absolute top-[60%] left-[30%] w-1 h-1 rounded-full bg-gold-400/20 blur-[1px] animate-pulse"
            style="animation-delay: 1.5s;"></div>

        <!-- Card -->
        <div class="relative z-10 w-full max-w-sm sm:max-w-md">
            <div id="card-login" class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6 sm:p-8 space-y-6">

                <!-- Header -->
                <div class="text-center space-y-3">
                    <img src="<?php echo site_url('assets/images/christmas/gpdi.webp'); ?>" alt="GPdI Kopo Permai"
                        class="w-12 h-auto mx-auto drop-shadow-[0_4px_12px_rgba(0,0,0,0.3)]">

                    <p class="text-[11px] font-semibold tracking-[0.25em] uppercase text-gold-600">
                        GPdI Kopo Permai
                    </p>

                    <div class="flex items-center justify-center gap-3">
                        <span class="block w-8 h-px bg-gold-400/50"></span>
                        <span class="block w-1.5 h-1.5 rounded-full bg-gold-400/60"></span>
                        <span class="block w-8 h-px bg-gold-400/50"></span>
                    </div>

                    <h1 class="text-2xl font-bold text-stone-800 leading-snug">
                        Admin Login
                    </h1>
                </div>

                <!-- Form -->
                <form action="" id="form-login" method="POST" class="space-y-4">

                    <!-- Username -->
                    <div class="space-y-1.5">
                        <label for="login-username" class="block text-xs font-semibold text-stone-700 tracking-wide">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 pointer-events-none">
                                <i class="fas fa-user text-sm"></i>
                            </span>
                            <input type="text" id="login-username" name="username" placeholder="Username"
                                autocomplete="off" required
                                class="login-field w-full pl-10 pr-4 py-3 rounded-xl border border-stone-200 text-sm text-stone-800 placeholder-stone-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gold-400/50 focus:border-gold-400">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="space-y-1.5">
                        <label for="login-password" class="block text-xs font-semibold text-stone-700 tracking-wide">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 pointer-events-none">
                                <i class="fas fa-lock text-sm"></i>
                            </span>
                            <input type="password" id="login-password" name="password" placeholder="Password"
                                autocomplete="off" required
                                class="login-field w-full pl-10 pr-12 py-3 rounded-xl border border-stone-200 text-sm text-stone-800 placeholder-stone-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gold-400/50 focus:border-gold-400">
                            <button type="button"
                                class="toggle-pw absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center rounded-lg text-stone-400 hover:text-gold-600 hover:bg-gold-50 transition-colors"
                                data-target="login-password" title="Show password">
                                <i class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <?php if ($isLocalEnv) : ?>
                    <!-- Database (hanya lokal) -->
                    <div class="space-y-1.5">
                        <label for="selectedDatabase" class="block text-xs font-semibold text-stone-700 tracking-wide">
                            Database <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 pointer-events-none">
                                <i class="fas fa-database text-sm"></i>
                            </span>
                            <select name="selected_database" id="selectedDatabase" required
                                class="login-field w-full pl-10 pr-4 py-3 rounded-xl border border-stone-200 text-sm text-stone-800 bg-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gold-400/50 focus:border-gold-400 appearance-none">
                                <option value="">Loading databases...</option>
                            </select>
                            <span
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-400 pointer-events-none">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full py-3 rounded-xl bg-gold-500 hover:bg-gold-600 text-red-950 font-semibold text-sm tracking-wide transition-all duration-300 hover:shadow-lg hover:shadow-gold-500/25 mt-2">
                        <i class="fas fa-arrow-right-to-bracket mr-2"></i> Login
                    </button>

                </form>
            </div>

            <!-- Footer credit -->
            <p class="text-center text-[11px] text-stone-400 mt-6 tracking-wide">
                From Glory to Glory &mdash; Christmas Celebration 2026
            </p>
        </div>

    </div>

    <!-- Jquery -->
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

    <!-- SweetAlert2 -->
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/sweetalert2/sweetalert2.min.js'); ?>"></script>

    <!-- Loading Overlay -->
    <script type="text/javascript" src="<?php echo base_url('assets/js/loadingoverlay.min.js'); ?>"></script>

    <!-- CSRF: auto-include token in all AJAX POST -->
    <script type="text/javascript">
        (function() {
            function getCookie(name) {
                var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
                return match ? decodeURIComponent(match[2]) : null;
            }

            $(document).ajaxSend(function(e, xhr, settings) {
                if (settings.type.toUpperCase() !== 'POST') return;

                var tokenName = $('meta[name="csrf-token-name"]').attr('content') || 'csrf_test_name';
                var tokenValue = $('meta[name="csrf-token-value"]').attr('content') || getCookie('csrf_cookie_name');
                if (!tokenValue) {
                    console.warn('[CSRF] Token not found, skipping');
                    return;
                }

                if (settings.data instanceof FormData) {
                    if (!settings.data.has(tokenName)) {
                        settings.data.append(tokenName, tokenValue);
                    }
                    return;
                }

                if (typeof settings.data === 'string') {
                    if (settings.data.indexOf(tokenName + '=') !== -1) return;
                    settings.data += '&' + tokenName + '=' + encodeURIComponent(tokenValue);
                } else if (settings.data) {
                    settings.data[tokenName] = tokenValue;
                } else {
                    settings.data = tokenName + '=' + encodeURIComponent(tokenValue);
                }
            });
        })();
    </script>

    <script type="text/javascript">
        var urlParams = new URLSearchParams(window.location.search)
        var preselectedDB = urlParams.get('db')

        function loadDatabases() {
            if (!$('#selectedDatabase').length) return
            $.getJSON('<?= site_url("activities/authentication/get_databases") ?>')
                .done(function(res) {
                    if (res.success && res.data && res.data.length > 0) {
                        var $select = $('#selectedDatabase')
                        $select.empty()

                        res.data.forEach(function(db) {
                            var selected = ''
                            if (preselectedDB && db.name === preselectedDB) {
                                selected = 'selected'
                            } else if (db.is_selected) {
                                selected = 'selected'
                            } else if (db.is_default && !selected) {
                                selected = 'selected'
                            }
                            $select.append('<option value="' + db.name + '" ' + selected + '>' + db.name + '</option>')
                        })
                    }
                })
                .fail(function() {
                    console.error('Failed to load databases')
                })
        }

        $(document).ready(function() {
            loadDatabases()
        })

        $(document).on('click', '.toggle-pw', function() {
            const target = $(this).data('target')
            const $input = $('#' + target)
            const $icon = $(this).find('i')
            if ($input.attr('type') === 'password') {
                $input.attr('type', 'text')
                $icon.removeClass('fa-eye').addClass('fa-eye-slash')
            } else {
                $input.attr('type', 'password')
                $icon.removeClass('fa-eye-slash').addClass('fa-eye')
            }
        })

        $('#form-login').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '<?= site_url("activities/authentication/login_process") ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('input, select, textarea, button').prop('disabled', true);
                    $("#card-login").LoadingOverlay('show', {
                        background: 'rgba(0, 0, 0, 0.25)'
                    });
                },
                success: function(res) {
                    if (res.success) {
                        window.location.href = res.redirect;
                    } else {
                        Swal.fire({
                            title: 'Failed',
                            text: res.message,
                            icon: 'error',
                        });
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: 'Failed',
                        text: 'Server error (' + xhr.status + ')',
                        icon: 'error',
                    });
                },
                complete: function() {
                    $('input, select, textarea, button').prop('disabled', false);
                    $("#card-login").LoadingOverlay('hide');
                }
            });
        });
    </script>
</body>

</html>
