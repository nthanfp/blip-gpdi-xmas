<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('partial/activities/head.php') ?>

    <style>
        .sync-card {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .sync-result {
            display: none;
            margin-top: 15px;
            padding: 15px;
            border-radius: 6px;
            background: #f8f9fa;
        }

        .sync-result.show {
            display: block;
        }

        .sync-result .result-label {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .sync-result .result-value {
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        .error-list {
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
</head>

<body class="sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">
        <?php $this->load->view('partial/activities/sidebar.php') ?>

        <div class="content-wrapper py-4 px-4 text-sm">
            <div class="row mb-3">
                <div class="col-12">
                    <h5 class="mb-0"><i class="fas fa-sync-alt mr-2"></i>Sync Proof Files</h5>
                    <small class="text-muted">Download missing proof files from remote server</small>
                </div>
            </div>

            <div class="row">
                <!-- Sync Purchase Proof -->
                <div class="col-md-6 mb-3">
                    <div class="card sync-card">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0"><i class="fas fa-receipt mr-2"></i>Purchase Proof</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" class="form-control form-control-sm" id="purchaseStartDate" value="<?= date('Y-m-d', strtotime('-7 days')) ?>">
                            </div>
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" class="form-control form-control-sm" id="purchaseEndDate" value="<?= date('Y-m-d') ?>">
                            </div>
                            <button type="button" class="btn btn-secondary" id="btnSyncPurchase">
                                <i class="fas fa-download mr-2"></i>Sync Purchase Proof
                            </button>

                            <div class="sync-result" id="purchaseResult">
                                <div class="result-label text-primary">Results:</div>
                                <div class="result-value">
                                    <i class="fas fa-check-circle text-success mr-1"></i>
                                    <span id="purchaseProcessed">0</span> processed
                                </div>
                                <div class="result-value">
                                    <i class="fas fa-download text-info mr-1"></i>
                                    <span id="purchaseDownloaded">0</span> downloaded
                                </div>
                                <div class="result-value" id="purchaseErrorContainer" style="display:none">
                                    <i class="fas fa-exclamation-triangle text-warning mr-1"></i>
                                    <span id="purchaseErrors">0</span> errors
                                </div>
                                <div class="error-list" id="purchaseErrorList"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sync Completed Proof -->
                <div class="col-md-6 mb-3">
                    <div class="card sync-card">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0"><i class="fas fa-check-double mr-2"></i>Completed Proof</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" class="form-control form-control-sm" id="completedStartDate" value="<?= date('Y-m-d', strtotime('-7 days')) ?>">
                            </div>
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" class="form-control form-control-sm" id="completedEndDate" value="<?= date('Y-m-d') ?>">
                            </div>
                            <button type="button" class="btn btn-secondary" id="btnSyncCompleted">
                                <i class="fas fa-download mr-2"></i>Sync Completed Proof
                            </button>

                            <div class="sync-result" id="completedResult">
                                <div class="result-label text-success">Results:</div>
                                <div class="result-value">
                                    <i class="fas fa-check-circle text-success mr-1"></i>
                                    <span id="completedProcessed">0</span> processed
                                </div>
                                <div class="result-value">
                                    <i class="fas fa-download text-info mr-1"></i>
                                    <span id="completedDownloaded">0</span> downloaded
                                </div>
                                <div class="result-value" id="completedErrorContainer" style="display:none">
                                    <i class="fas fa-exclamation-triangle text-warning mr-1"></i>
                                    <span id="completedErrors">0</span> errors
                                </div>
                                <div class="error-list" id="completedErrorList"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('partial/activities/footer.php') ?>
    </div>

    <?php $this->load->view('partial/activities/foot.php') ?>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#btnSyncPurchase').on('click', function() {
                var $btn = $(this)
                var startDate = $('#purchaseStartDate').val()
                var endDate = $('#purchaseEndDate').val()

                if (!startDate || !endDate) {
                    Swal.fire('Error', 'Please select start and end date', 'error')
                    return
                }

                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Syncing...')

                $.getJSON('<?= site_url("activities/sync/sync_proof_purchase") ?>', {
                    start_date: startDate,
                    end_date: endDate
                })
                .done(function(res) {
                    if (res.success) {
                        $('#purchaseProcessed').text(res.total_processed)
                        $('#purchaseDownloaded').text(res.downloaded)
                        $('#purchaseErrors').text(res.errors.length)
                        
                        if (res.errors.length > 0) {
                            $('#purchaseErrorContainer').show()
                            var errorHtml = '<ul class="mb-0 pl-3">'
                            res.errors.forEach(function(err) {
                                errorHtml += '<li class="small">' + err.filepath + ' - ' + err.reason + '</li>'
                            })
                            errorHtml += '</ul>'
                            $('#purchaseErrorList').html(errorHtml)
                        } else {
                            $('#purchaseErrorContainer').hide()
                            $('#purchaseErrorList').html('')
                        }
                        
                        $('#purchaseResult').addClass('show')
                        
                        Swal.fire('Success', 'Purchase proof sync completed!', 'success')
                    } else {
                        Swal.fire('Error', res.message || 'Sync failed', 'error')
                    }
                })
                .fail(function() {
                    Swal.fire('Error', 'Server error', 'error')
                })
                .always(function() {
                    $btn.prop('disabled', false).html('<i class="fas fa-download mr-2"></i>Sync Purchase Proof')
                })
            })

            $('#btnSyncCompleted').on('click', function() {
                var $btn = $(this)
                var startDate = $('#completedStartDate').val()
                var endDate = $('#completedEndDate').val()

                if (!startDate || !endDate) {
                    Swal.fire('Error', 'Please select start and end date', 'error')
                    return
                }

                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Syncing...')

                $.getJSON('<?= site_url("activities/sync/sync_proof_completed") ?>', {
                    start_date: startDate,
                    end_date: endDate
                })
                .done(function(res) {
                    if (res.success) {
                        $('#completedProcessed').text(res.total_processed)
                        $('#completedDownloaded').text(res.downloaded)
                        $('#completedErrors').text(res.errors.length)
                        
                        if (res.errors.length > 0) {
                            $('#completedErrorContainer').show()
                            var errorHtml = '<ul class="mb-0 pl-3">'
                            res.errors.forEach(function(err) {
                                errorHtml += '<li class="small">' + err.filepath + ' - ' + err.reason + '</li>'
                            })
                            errorHtml += '</ul>'
                            $('#completedErrorList').html(errorHtml)
                        } else {
                            $('#completedErrorContainer').hide()
                            $('#completedErrorList').html('')
                        }
                        
                        $('#completedResult').addClass('show')
                        
                        Swal.fire('Success', 'Completed proof sync completed!', 'success')
                    } else {
                        Swal.fire('Error', res.message || 'Sync failed', 'error')
                    }
                })
                .fail(function() {
                    Swal.fire('Error', 'Server error', 'error')
                })
                .always(function() {
                    $btn.prop('disabled', false).html('<i class="fas fa-download mr-2"></i>Sync Completed Proof')
                })
            })
        })
    </script>
</body>

</html>
