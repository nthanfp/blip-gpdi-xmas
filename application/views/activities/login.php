<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head -->
    <?php $this->load->view('partial/activities/head.php') ?>

    <!-- Additional Style (Global) -->
    <style>
        html,
        body {
            height: 100dvh;
            overflow: hidden;
        }

        body {
            background:
                linear-gradient(180deg,
                    rgba(30, 30, 30, 0.72) 0%,
                    rgba(10, 10, 10, 0.88) 100%),
                url('<?php echo site_url('assets/images/bg-warehouse.jpg'); ?>') no-repeat center center fixed;

            background-size: cover;
            background-position: center;
        }

        body.swal2-height-auto {
            height: 100dvh !important;
        }

        .login-shell {
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
        }

        .login-shell::before {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .login-card-wrap {
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 1;
        }

        .login-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .login-brand-mark {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg,
                    #4a4a4a,
                    #222222);
            color: #fff;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
        }

        .login-brand-text {
            color: #fff;
            line-height: 1;
        }

        .login-brand-text .title {
            font-size: 1.2rem;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .login-brand-text .subtitle {
            font-size: .78rem;
            color: rgba(255, 255, 255, 0.72);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .login-panel {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.16);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-radius: 24px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.34);
            overflow: hidden;
        }

        .login-panel .card-header {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.03));
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 22px 20px 16px;
        }

        .login-panel .card-header a {
            color: #fff;
            text-decoration: none;
        }

        .login-panel .card-body {
            padding: 22px 20px 24px;
        }

        .login-help {
            color: rgba(255, 255, 255, 0.78);
            font-size: .85rem;
            line-height: 1.55;
            margin-bottom: 18px;
        }

        .login-field .input-group-text {
            background: rgba(255, 255, 255, 0.10);
            color: rgba(255, 255, 255, 0.95);
            border-color: rgba(255, 255, 255, 0.12);
        }

        .login-field .form-control {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.12);
        }

        .login-field .form-control::placeholder {
            color: rgba(255, 255, 255, 0.62);
        }

        .login-field .form-control:focus {
            background: rgba(255, 255, 255, 0.16);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.28);
            box-shadow: 0 0 0 .2rem rgba(255, 255, 255, 0.10);
        }

        .login-button {
            background: linear-gradient(90deg,
                    #1c1c1c 0%,
                    #303030 50%,
                    #1c1c1c 100%);
            border: 0;
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.35);
            transition: all 0.25s ease;
        }

        .login-button:hover {
            background: linear-gradient(90deg,
                    #262626 0%,
                    #3a3a3a 50%,
                    #262626 100%);
            transform: translateY(-1px);
        }

        #error-login {
            color: #e0e0e0 !important;
            font-size: .85rem;
            margin-bottom: 12px;
            min-height: 18px;
        }

        #selectedDatabase option {
            background: #2d2d2d;
            color: #fff;
        }

        .qrtag-logo {
            height: 70px;

            background-color: #fff;

            -webkit-mask-image: url("<?php echo site_url(); ?>assets/images/qrtag-landscape.png");
            mask-image: url("<?php echo site_url(); ?>assets/images/qrtag-landscape.png");

            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;

            -webkit-mask-position: center;
            mask-position: center;

            -webkit-mask-size: contain;
            mask-size: contain;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-shell">
        <div class="login-card-wrap">
            <div class="card card-outline card-secondary border-0 login-panel" id="card-login">
                <div class="card-header text-center">
                    <div class="qrtag-logo">
                    </div>
                </div>
                <div class="card-body">
                    <form action="" id="form-login" method="POST">
                        <div class="input-group mb-3 login-field">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="border-radius:12px 0 0 12px"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" name="username" placeholder="Username"
                                autocomplete="off" required style="border-radius:0 12px 12px 0">
                        </div>
                        <div class="input-group mb-3 login-field">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="border-radius:12px 0 0 12px"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" name="password" id="login-password" placeholder="Password"
                                autocomplete="off" required style="border-radius:0">
                            <div class="input-group-append">
                                <button class="btn btn-outline-light toggle-pw" type="button" data-target="login-password" style="border-radius:0 12px 12px 0;border-color:rgba(255,255,255,0.12);background:rgba(255,255,255,0.10);color:rgba(255,255,255,0.95)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="input-group mb-3 login-field">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="border-radius:12px 0 0 12px"><i class="fas fa-database"></i></span>
                            </div>
                            <select class="form-control" name="selected_database" id="selectedDatabase" style="background:rgba(255,255,255,0.12);color:#fff;border:none">
                                <option value="">Loading databases...</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-block text-white font-weight-semibold btn-login login-button">
                            <i class="fas fa-arrow-right-to-bracket mr-2"></i> Login
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Foot (js/library) -->
    <?php $this->load->view('partial/activities/foot.php') ?>

    <script type="text/javascript">
        var urlParams = new URLSearchParams(window.location.search)
        var preselectedDB = urlParams.get('db')

        function loadDatabases() {
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