<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('partial/activities/head.php') ?>
</head>

<body class="sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">
        <?php $this->load->view('partial/activities/sidebar.php') ?>

        <div class="content-wrapper py-4 px-4 text-sm">
            <div class="row mb-3 d-none">
                <div class="col-12">
                    <h5 class="font-weight-bold mb-1"><i class="fas fa-paper-plane text-primary mr-2"></i>Custom Push Notification</h5>
                    <p class="text-muted small mb-0">Send a push notification to all registered admin devices</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-secondary card-outline">
                        <div class="card-header">
                            <h6 class="card-title"><i class="fas fa-edit mr-1"></i>Compose Message</h6>
                        </div>
                        <div class="card-body">
                            <form id="pushForm">
                                <div class="form-group">
                                    <label for="pushTitle">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" id="pushTitle" name="title" placeholder="e.g. Announcement" maxlength="255" required>
                                </div>
                                <div class="form-group">
                                    <label for="pushBody">Body <span class="text-danger">*</span></label>
                                    <textarea class="form-control form-control-sm" id="pushBody" name="body" rows="4" placeholder="Type your message here..." maxlength="500" required></textarea>
                                    <small class="text-muted"><span id="charCount">0</span>/500</small>
                                </div>
                                <div class="form-group">
                                    <label for="pushUrl">Click URL</label>
                                    <input type="text" class="form-control form-control-sm" id="pushUrl" name="click_url" placeholder="index.php/activities/dashboard" value="index.php/activities/redeem">
                                    <small class="text-muted">Page to open when notification is clicked</small>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary px-4" id="btnSendPush">
                                <i class="fas fa-paper-plane mr-1"></i> Send
                            </button>
                            <button type="button" class="btn btn-outline-secondary px-3 ml-1" id="btnTestPush">
                                <i class="fas fa-flask mr-1"></i> Test
                            </button>
                            <span id="pushStatus" class="ml-2 small"></span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card card-secondary card-outline">
                        <div class="card-header">
                            <h6 class="card-title"><i class="fas fa-info-circle mr-1"></i>Recipients</h6>
                        </div>
                        <div class="card-body text-center py-5" id="recipientInfo">
                            <i class="fas fa-mobile-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Push will be sent to all registered admin devices</p>
                            <small class="text-muted">Including mobile users who have granted notification permission</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('partial/activities/foot.php') ?>
    </div>

    <script>
        $(function() {
            var csrfName = $('meta[name="csrf-token-name"]').attr('content') || 'csrf_test_name'
            var csrfToken = $('meta[name="csrf-token-value"]').attr('content')

            var $btn = $('#btnSendPush')
            var $testBtn = $('#btnTestPush')
            var $status = $('#pushStatus')

            function setLoading(loading) {
                $btn.prop('disabled', loading)
                $testBtn.prop('disabled', loading)
                $btn.html(loading ? '<i class="fas fa-spinner fa-spin mr-1"></i> Sending...' : '<i class="fas fa-paper-plane mr-1"></i> Send')
            }

            function pushData(extra) {
                var data = extra || {}
                if (csrfToken) data[csrfName] = csrfToken
                return data
            }

            function sendPush(title, body, url, cb) {
                setLoading(true)
                $.post('<?php echo site_url('activities/notification/send_custom'); ?>', pushData({
                        title: title,
                        body: body,
                        click_url: url
                    }))
                    .done(function(res) {
                        if (res.success) {
                            $status.html('<span class="text-success"><i class="fas fa-check-circle mr-1"></i> ' + res.message + '</span>')
                        } else {
                            $status.html('<span class="text-danger"><i class="fas fa-exclamation-circle mr-1"></i> ' + res.message + '</span>')
                        }
                        if (cb) cb(res)
                    })
                    .fail(function(xhr) {
                        console.error(xhr.responseText);
                        $status.html('<span class="text-danger"><i class="fas fa-exclamation-circle mr-1"></i> Server error (' + xhr.status + ')</span>')
                        if (cb) cb({
                            success: false
                        })
                    })
                    .always(function() {
                        setLoading(false)
                    })
            }

            $('#btnSendPush').on('click', function() {
                var title = $('#pushTitle').val().trim()
                var body = $('#pushBody').val().trim()
                var url = $('#pushUrl').val().trim() || 'index.php/activities/dashboard'

                if (!title) {
                    $('#pushTitle').focus();
                    return
                }
                if (!body) {
                    $('#pushBody').focus();
                    return
                }

                $status.html('')
                sendPush(title, body, url)
            })

            $('#btnTestPush').on('click', function() {
                $status.html('')
                $.post('<?php echo site_url('activities/notification/test_push'); ?>', pushData())
                    .done(function(res) {
                        if (res.success) {
                            $status.html('<span class="text-success"><i class="fas fa-check-circle mr-1"></i> ' + res.message + '</span>')
                        } else {
                            $status.html('<span class="text-danger"><i class="fas fa-exclamation-circle mr-1"></i> ' + res.message + '</span>')
                        }
                    })
                    .fail(function(xhr) {
                        console.error(xhr.responseText);
                        $status.html('<span class="text-danger"><i class="fas fa-exclamation-circle mr-1"></i> Server error (' + xhr.status + ')</span>')
                    })
            })

            $('#pushBody').on('input', function() {
                $('#charCount').text($(this).val().length)
            })
        })
    </script>

</body>

</html>