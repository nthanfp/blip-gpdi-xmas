<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('partial/activities/head.php') ?>

    <style>
        .budget-card .info-box {
            border-radius: 6px;
        }

        .budget-card .info-box-number {
            font-size: 20px;
            font-weight: 700;
        }

        .budget-card .info-box-text {
            font-size: 12px;
        }

        .progress-budget {
            height: 8px;
            border-radius: 4px;
        }

        .progress-budget .progress-bar {
            transition: width 0.4s ease;
        }
    </style>
</head>

<body class="sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">
        <?php $this->load->view('partial/activities/sidebar.php') ?>
        <div class="content-wrapper pt-2 pb-4 px-4 text-sm">

            <!-- Filter Row -->
            <div class="row mb-2">
                <div class="col-6 col-md-3 mb-2">
                    <label class="mb-0">Search</label>
                    <input type="text" class="form-control form-control-sm" id="search"
                        placeholder="Item name..." autocomplete="off">
                </div>
                <div class="col-6 col-md-3 mb-2">
                    <label class="mb-0">Item Type</label>
                    <select class="form-control form-control-sm" id="filterItemtype">
                        <option value="">-- ALL --</option>
                        <option value="1">POINT</option>
                        <option value="2">OTHER</option>
                    </select>
                </div>
                <div class="col-6 col-md-3 mb-2">
                    <label class="mb-0">Bulk Code</label>
                    <select class="form-control form-control-sm" id="filterBulkCode">
                        <option value="">-- ALL --</option>
                    </select>
                </div>
                <div class="col-6 col-md-3 mb-2">
                    <label class="mb-0">&nbsp;</label>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn w-100 mr-1 btn-sm btn-secondary" id="btnReset">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <button type="button" class="btn w-100 btn-sm btn-primary" id="btnApply">
                            <i class="fas fa-check"></i> Apply
                        </button>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-1">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-coins"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Allocated</span>
                            <span class="info-box-number" id="totalAllocated">-</span>
                            <span class="info-box-text" id="totalAllocatedCount">-</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-1">
                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Distributed</span>
                            <span class="info-box-number" id="totalDistributed">-</span>
                            <span class="info-box-text" id="totalDistributedCount">-</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-1">
                    <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-hourglass-half"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Remaining</span>
                            <span class="info-box-number" id="totalRemaining">-</span>
                            <span class="info-box-text" id="totalRemainingCount">-</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Expired</span>
                            <span class="info-box-number" id="totalExpired">-</span>
                            <span class="info-box-text" id="totalExpiredCount">-</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <h6 class="mt-2 mb-2">Budget Overview</h6>
            <div class="card card-outline card-secondary mb-3">
                <div class="table-responsive">
                    <table class="table table-sm table-striped mb-0">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Type</th>
                                <th class="text-nowrap">Item Gift Name</th>
                                <th class="d-none text-nowrap text-right">Unit Value</th>
                                <th class="text-nowrap text-right">Total Vouchers</th>
                                <th class="text-nowrap text-right">Allocated</th>
                                <th class="text-nowrap text-right">Remaining</th>
                                <th class="text-nowrap text-right">Distributed</th>
                                <th class="text-nowrap text-center">Utilization</th>
                                <th class="text-nowrap text-right">Pending</th>
                                <th class="text-nowrap text-right">Completed</th>
                                <th class="text-nowrap text-right">Rejected</th>
                                <th class="text-nowrap text-right">Expired</th>
                            </tr>
                        </thead>
                        <tbody id="tableBodyBudget">
                            <tr>
                                <td colspan="12" class="text-center text-muted py-4">Loading...</td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-light font-weight-bold">
                            <tr>
                                <td colspan="2" class="text-right text-uppercase">Total</td>
                                <td class="text-right text-nowrap" id="tfootTotalVouchers">-</td>
                                <td class="text-right text-nowrap" id="tfootTotalAllocated">-</td>
                                <td class="text-right text-nowrap" id="tfootTotalRemaining">-</td>
                                <td class="text-right text-nowrap" id="tfootTotalDistributed">-</td>
                                <td class="text-center text-nowrap" id="tfootTotalUtilization">-</td>
                                <td class="text-right text-nowrap" id="tfootTotalPending">-</td>
                                <td class="text-right text-nowrap" id="tfootTotalCompleted">-</td>
                                <td class="text-right text-nowrap text-danger" id="tfootTotalRejected">-</td>
                                <td class="text-right text-nowrap text-muted" id="tfootTotalExpired">-</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Table E-Wallet per Item Gift -->
            <h6 class="mt-2 mb-2">Budget Overview per E-Wallet</h6>
            <div class="card card-outline card-secondary mb-3">
                <div class="table-responsive">
                    <table class="table table-sm table-striped mb-0">
                        <thead id="tableEWalletItemgiftHeader">
                        </thead>
                        <tbody id="tableEWalletItemgiftBody">
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">Loading...</td>
                            </tr>
                        </tbody>
                        <tfoot id="tableEWalletItemgiftFooter">
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <?php $this->load->view('partial/activities/footer.php') ?>
    </div>

    <?php $this->load->view('partial/activities/foot.php') ?>

    <script type="text/javascript">
        $(function() {
            const endpoints = {
                budget: '<?= site_url("activities/budget/data_budget") ?>',
                totals: '<?= site_url("activities/budget/data_totals") ?>',
                bulkCode: '<?= site_url("activities/budget/data_option_bulk_code") ?>',
                eWalletItemgift: '<?= site_url("activities/budget/data_ewallet/itemgift") ?>',
                eWalletAccumulation: '<?= site_url("activities/budget/data_ewallet/accumulation") ?>',
            }

            const escapeHtml = (value) => $('<div>').text(value == null ? '' : String(value)).html()

            const formatCurrency = (val) => {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(Number(val || 0))
            }

            const formatNumber = (val) => {
                return new Intl.NumberFormat('id-ID').format(Number(val || 0))
            }

            const loadTotals = (itemtype, bulkCode) => {
                $.ajax({
                    url: endpoints.totals,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        itemtype: itemtype,
                        bulk_code: bulkCode
                    },
                    success: function(res) {
                        if (!res.success) return

                        const t = res.data
                        $('#totalAllocated').text(formatCurrency(t.total_allocated))
                        $('#totalAllocatedCount').text(formatNumber(t.total_vouchers) + ' voucher')
                        $('#totalDistributed').text(formatCurrency(t.total_distributed))
                        $('#totalDistributedCount').text(formatNumber(t.total_distributed_count) + ' voucher')
                        $('#totalRemaining').text(formatCurrency(t.total_available))
                        $('#totalRemainingCount').text(formatNumber(t.total_available_count) + ' voucher')
                        $('#totalExpired').text(formatCurrency(t.total_expired))
                        $('#totalExpiredCount').text(formatNumber(t.total_expired_count) + ' voucher')
                    }
                })
            }

            const loadData = (itemtype, search, bulkCode) => {
                $.ajax({
                    url: endpoints.budget,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        itemtype: itemtype,
                        search: search,
                        bulk_code: bulkCode
                    },
                    beforeSend: function() {
                        $.LoadingOverlay('show', {
                            background: 'rgba(0, 0, 0, 0.25)'
                        })
                    },
                    success: function(res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load budget data', 'error')
                            return
                        }

                        const rows = res.data || []
                        const tbody = $('#tableBodyBudget')

                        if (!rows.length) {
                            tbody.html('<tr><td colspan="12" class="text-center text-muted py-4">No data found</td></tr>')
                            return
                        }

                        let totalVouchers = 0
                        let totalAllocated = 0
                        let totalDistributed = 0
                        let totalRemaining = 0
                        let totalPending = 0
                        let totalCompleted = 0
                        let totalRejected = 0
                        let totalExpired = 0

                        tbody.html(rows.map(function(row) {
                            const typeName = Number(row.itemtype) === 1 ? 'POINT' : 'OTHER'
                            const pct = Number(row.utilization_pct || 0)
                            let barColor = 'bg-success'
                            if (pct >= 80) barColor = 'bg-danger'
                            else if (pct >= 50) barColor = 'bg-warning'

                            totalVouchers += Number(row.total_vouchers || 0)
                            totalAllocated += Number(row.allocated_budget || 0)
                            totalDistributed += Number(row.distributed_budget || 0)
                            totalRemaining += Number(row.available_budget || 0)
                            totalPending += Number(row.pending_budget || 0)
                            totalCompleted += Number(row.completed_budget || 0)
                            totalRejected += Number(row.rejected_budget || 0)
                            totalExpired += Number(row.expired_budget || 0)

                            return `
                                <tr>
                                    <td class="text-nowrap"><span class="badge badge-light">${escapeHtml(typeName)}</span></td>
                                    <td class="text-nowrap">${escapeHtml(row.itemname)}</td>
                                    <td class="d-none text-nowrap text-right">${formatCurrency(row.unit_value)}</td>
                                    <td class="text-nowrap text-right font-weight-semibold">${formatNumber(row.total_vouchers)}</td>
                                    <td class="text-nowrap text-right font-weight-semibold">${formatCurrency(row.allocated_budget)}</td>
                                    <td class="text-nowrap text-right font-weight-semibold">${formatCurrency(row.available_budget)}</td>
                                    <td class="text-nowrap text-right font-weight-semibold">${formatCurrency(row.distributed_budget)}</td>
                                    <td class="text-nowrap text-center" style="min-width:100px">
                                        <small class="d-block mb-1 font-weight-bold">${pct}%</small>
                                        <div class="progress progress-budget">
                                            <div class="progress-bar ${barColor}" style="width: ${pct}%"></div>
                                        </div>
                                    </td>
                                    <td class="text-nowrap text-right">${formatCurrency(row.pending_budget)}</td>
                                    <td class="text-nowrap text-right">${formatCurrency(row.completed_budget)}</td>
                                    <td class="text-nowrap text-right text-danger">${formatCurrency(row.rejected_budget)}</td>
                                    <td class="text-nowrap text-right text-muted">${formatCurrency(row.expired_budget)}</td>
                                </tr>
                            `
                        }).join(''))

                        const utilization = totalAllocated > 0 ? ((totalDistributed / totalAllocated) * 100) : 0
                        $('#tfootTotalVouchers').text(formatNumber(totalVouchers))
                        $('#tfootTotalAllocated').text(formatCurrency(totalAllocated))
                        $('#tfootTotalDistributed').text(formatCurrency(totalDistributed))
                        $('#tfootTotalRemaining').text(formatCurrency(totalRemaining))
                        $('#tfootTotalUtilization').text(utilization.toFixed(1) + '%')
                        $('#tfootTotalPending').text(formatCurrency(totalPending))
                        $('#tfootTotalCompleted').text(formatCurrency(totalCompleted))
                        $('#tfootTotalRejected').text(formatCurrency(totalRejected))
                        $('#tfootTotalExpired').text(formatCurrency(totalExpired))
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText)
                        Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                    },
                    complete: function() {
                        $.LoadingOverlay('hide')
                    }
                })
            }

            const getItemtype = () => $('#filterItemtype').val() || ''
            const getSearch = () => $('#search').val().trim() || ''
            const getBulkCode = () => $('#filterBulkCode').val() || ''

            const refresh = () => {
                const itemtype = getItemtype()
                const search = getSearch()
                const bulkCode = getBulkCode()
                loadTotals(itemtype, bulkCode)
                loadData(itemtype, search, bulkCode)
                loadeWalletItemgift()
                loadeWalletAccumulation()
            }

            const loadBulkCodeOptions = () => {
                return $.ajax({
                    url: endpoints.bulkCode,
                    type: 'GET',
                    dataType: 'json'
                }).then(function(res) {
                    if (!res.success) return

                    const $sel = $('#filterBulkCode')
                    $sel.empty().append('<option value="">-- ALL --</option>')

                    ;
                    (res.data || []).forEach(function(row) {
                        $sel.append(
                            '<option value="' + escapeHtml(row.bulk_code) + '">' + escapeHtml(row.bulk_code) + '</option>'
                        )
                    })
                })
            }

            const loadeWalletItemgift = () => {
                $.ajax({
                    url: endpoints.eWalletItemgift,
                    type: 'GET',
                    dataType: 'json',
                    data: {},
                    beforeSend: function(){
                        $.LoadingOverlay('show', {
                            background: 'rgba(0, 0, 0, 0.25)'
                        })
                    },
                    success: function(res){
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load budget data', 'error')
                            return
                        }

                        const rows = res.data || []
                        const tbody = $('#tableEWalletItemgiftBody')
                        const thead = $('#tableEWalletItemgiftHeader')
                        const tfoot = $('#tableEWalletItemgiftFooter')

                        // Header
                        let header1 = '<tr><th rowspan="2" class="align-middle">Item Name</th>'
                        let header2 = '<tr>'
                        rows.forEach(row => {
                            header1 += `<th class="text-right" colspan="2">${row.wallet_name}</th>`
                            header2 += `
                                <th class="text-right">Voucher</th>
                                <th class="text-right">Value</th>
                            `
                        })
                        header1 += '</tr>'
                        header2 += '</tr>'
                        $('#tableEWalletItemgiftHeader').html(header1 + header2)

                        // Body
                        const itemNames = []
                        rows.forEach(wallet => {
                            wallet.items.forEach(item => {
                                if (!itemNames.includes(item.itemname)) {
                                    itemNames.push(item.itemname)
                                }
                            })
                        })
                        
                        itemNames.sort((a, b) => {
                            const getNominal = text => parseInt(text.replace(/[^\d]/g, ''))

                            const aValue = getNominal(a)
                            const bValue = getNominal(b)

                            // Paksa 100000 ke posisi terakhir
                            if (aValue === 100000) return 1
                            if (bValue === 100000) return -1

                            return aValue - bValue
                        })

                        let body = ''
                        itemNames.forEach(itemName => {
                            body += `
                                <tr>
                                    <td>${itemName}</td>
                            `
                            rows.forEach(wallet => {
                                const item = wallet.items.find(x => x.itemname === itemName)
                                body += `
                                    <td class="text-right">
                                        ${item ? item.redeem_qty : '-'}
                                    </td>
                                    <td class="text-right">
                                        ${item ? formatCurrency(item.total_value) : '-'}
                                    </td>
                                `
                            })
                            body += `
                                </tr>
                            `
                        })
                        tbody.html(body)

                        // Footer
                        let footer = `
                            <tr class="font-weight-bold bg-light">
                                <td class="text-right">TOTAL</td>`

                        rows.forEach(wallet => {
                            const totalQty = wallet.items.reduce((sum, item) => {
                                return sum + Number(item.redeem_qty)
                            }, 0)

                            const totalValue = wallet.items.reduce((sum, item) => {
                                return sum + Number(item.total_value)
                            }, 0)

                            footer += `
                                <td class="text-right">
                                    ${(totalQty)}
                                </td>
                                <td class="text-right">
                                    ${formatCurrency(totalValue)}
                                </td>
                            `
                        })
                        footer += '</tr>'

                        tfoot.html(footer)
                    },
                    error: function(){
                    },
                    complete: function(){
                        $.LoadingOverlay('hide')
                    }
                });
            }

            const loadeWalletAccumulation = () => {
                $.ajax({
                    url: endpoints.eWalletAccumulation,
                    type: 'GET',
                    dataType: 'json',
                    data: {},
                    beforeSend: function(){

                    },
                    success: function(){

                    },
                    error: function(){

                    },
                    complete: function(){
                        
                    }
                });
            }

            $('#btnApply').on('click', refresh)

            $('#btnReset').on('click', function() {
                $('#search').val('')
                $('#filterItemtype').val('')
                $('#filterBulkCode').val('')
                refresh()
            })

            $('#search').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault()
                    refresh()
                }
            })

            $.when(loadBulkCodeOptions()).then(function() {
                refresh()
            })
        })
    </script>
</body>

</html>