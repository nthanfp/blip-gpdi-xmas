<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('partial/activities/head.php') ?>
</head>

<body class="sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">
        <?php $this->load->view('partial/activities/sidebar.php') ?>

        <div class="content-wrapper py-4 px-4 text-sm">
            <div class="row justify-content-center">
                <div class="col-12 col-md-7 col-lg-5">
                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Change Password</h3>
                        </div>
                        <div class="card-body">
                            <form id="formChangePassword" autocomplete="off">
                                <div class="form-group">
                                    <label for="current_password">Current Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="current_password"
                                            name="current_password" autocomplete="current-password">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-pw" type="button" data-target="current_password">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="new_password" name="new_password"
                                            autocomplete="new-password">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-pw" type="button" data-target="new_password">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <label for="confirm_password">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_password"
                                            name="confirm_password" autocomplete="new-password">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-pw" type="button" data-target="confirm_password">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary mr-2" id="btnReset">Reset</button>
                            <button type="button" class="btn btn-primary" id="btnSave">
                                <i class="fas fa-save mr-1"></i> Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('partial/activities/footer.php') ?>
    </div>

    <?php $this->load->view('partial/activities/foot.php') ?>

    <script>
        $(function () {
            const endpoint = '<?= site_url("activities/authentication/change_password") ?>'
            const form = $('#formChangePassword')

            $(document).on('click', '.toggle-pw', function () {
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

            const resetForm = () => {
                form[0].reset()
                $('#current_password').focus()
            }

            $('#btnReset').on('click', function () {
                resetForm()
            })

            $('#btnSave').on('click', function () {
                const payload = {
                    current_password: $('#current_password').val(),
                    new_password: $('#new_password').val(),
                    confirm_password: $('#confirm_password').val()
                }

                $.ajax({
                    url: endpoint,
                    type: 'POST',
                    dataType: 'json',
                    data: payload,
                    beforeSend: function () {
                        $('input, select, textarea, button').prop('disabled', true);
                        $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' });
                    },
                    success: function (res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to change password', 'error')
                            return
                        }

                        Swal.fire('Success', res.message || 'Password updated successfully', 'success')
                            .then(function () {
                                if (res.redirect) {
                                    window.location.href = res.redirect
                                    return
                                }

                                resetForm()
                            })
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                    },
                    complete: function () {
                        $('input, select, textarea, button').prop('disabled', false);
                        $.LoadingOverlay('hide');
                    }   
                })
            })
        })
    </script>
</body>

</html>