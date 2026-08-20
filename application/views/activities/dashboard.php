<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head -->
    <?php $this->load->view('partial/activities/head.php') ?>

    <!-- Additional Style (Global) -->
    <style>
        .content-wrapper {
            position: relative;
            /* background: transparent !important; */
        }

        .content-wrapper::before {
            content: "";
            position: absolute;
            inset: 0;

            background: url('<?= base_url("assets/icons/logo.png") ?>') no-repeat center;
            background-size: 150px;

            opacity: 0.10;
            pointer-events: none;

            z-index: 0;
        }

        .dashboard-card {
            height: 100%;
        }

        .dashboard-card .card-body {
            padding: 0;
        }

        .dashboard-card .table th {
            border-top: 0;
            padding: 10px 12px;
            white-space: nowrap;
        }

        .dashboard-card .table td {
            padding: 8px 12px;
            vertical-align: middle;
            font-size: 13px;
            white-space: nowrap;
        }

        .dashboard-card .chart-wrap {
            padding: 16px;
            height: 310px;
        }

        .dashboard-card .chart-wrap canvas {
            width: 100% !important;
            height: 100% !important;
        }

        .info-box-wrap {
            display: block;
            cursor: pointer;
        }

        .info-box-wrap:hover .info-box {
            filter: brightness(1.08);
        }
    </style>
</head>

<body class="sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">

        <?php $this->load->view('partial/activities/sidebar.php') ?>

        <div class="content-wrapper py-4 px-4 text-sm">
            <div class="row d-none">
                <div class="col-md-3 col-sm-6 col-12 d-none">
                    <div class="info-box bg-secondary" title="Average time from when a voucher is redeemed to when it is completed or rejected.">
                        <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text mb-0">Avg Process Time</span>
                            <span class="info-box-number mt-0" id="Widget-Avg-Time">-</span>
                            <small class="text-muted d-none" id="Widget-Processed">-</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12 d-none">
                    <?php if (!empty($can_customer)): ?><a href="<?= site_url('activities/customer') ?>" class="info-box-wrap"><?php endif; ?>
                        <div class="info-box bg-secondary">
                            <span class="info-box-icon"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text mb-0">Customer</span>
                                <span class="info-box-number mt-0" id="Widget-Count-Customer">-</span>
                            </div>
                        </div>
                        <?php if (!empty($can_customer)): ?>
                        </a><?php endif; ?>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <?php if (!empty($can_voucher)): ?><a href="<?= site_url('activities/voucher') ?>" class="info-box-wrap"><?php endif; ?>
                        <div class="info-box bg-secondary">
                            <span class="info-box-icon"><i class="fas fa-gifts"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text mb-0">Item Point</span>
                                <span class="info-box-number mt-0" id="Widget-Count-Voucher">-</span>
                            </div>
                        </div>
                        <?php if (!empty($can_voucher)): ?>
                        </a><?php endif; ?>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <?php if (!empty($can_redeem)): ?><a href="<?= site_url('activities/redeem') ?>" class="info-box-wrap"><?php endif; ?>
                        <div class="info-box bg-secondary">
                            <span class="info-box-icon"><i class="fas fa-mail-bulk"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text mb-0">Redeem</span>
                                <span class="info-box-number mt-0" id="Widget-Count-Redeem">-</span>
                            </div>
                        </div>
                        <?php if (!empty($can_redeem)): ?>
                        </a><?php endif; ?>
                </div>
            </div>

            <!-- Charts + Item Gift Summary -->
            <div class="row">
                <div class="col-md-8 mb-3">
                    <div class="card card-outline card-secondary dashboard-card">
                        <div class="card-header">
                            <i class="fas fa-chart-line mr-1"></i> Redeemed Point by Date
                        </div>
                        <div class="card-body">
                            <div class="chart-wrap">
                                <canvas id="chartVoucher"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card card-outline card-secondary dashboard-card">
                        <div class="card-header">
                            <i class="fas fa-chart-pie mr-1"></i> Overall Status
                        </div>
                        <div class="card-body">
                            <div class="chart-wrap">
                                <canvas id="chartOverall"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="card card-outline card-secondary dashboard-card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Item Gift</th>
                                            <th class="text-nowrap text-right">Total</th>
                                            <th class="text-nowrap text-right">Available</th>
                                            <th class="text-nowrap text-right d-none">Redeemed</th>
                                            <th class="text-nowrap text-right">Completed</th>
                                            <th class="text-nowrap text-right d-none">Rejected</th>
                                            <th class="text-nowrap text-right">Expired</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemgift-summary-body">
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">Loading...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php $this->load->view('partial/activities/footer.php') ?>
    </div>

    <!-- Foot (js/library) -->
    <?php $this->load->view('partial/activities/foot.php') ?>

    <script type="text/javascript">
        let chartInstance = null;
        let chartOverallInstance = null;

        $(function() {
            $.ajax({
                url: '<?php echo base_url('activities/dashboard/data_dashboard'); ?>',
                type: 'GET',
                dataType: 'json',
                data: {},
                beforeSend: function() {
                    $('input, select, textarea, button').prop('disabled', true);
                    $.LoadingOverlay('show', {
                        background: 'rgba(0, 0, 0, 0.25)'
                    });
                },
                success: function(res) {
                    if (!res.success) {
                        Swal.fire('Error', res.message || 'Failed to load voucher data', 'error')
                        return
                    }

                    // Widget counts
                    const pt = res.data.process_time || {}
                    const avgHours = Number(pt.avg_hours || 0)
                    const h = Math.floor(avgHours)
                    const m = Math.round((avgHours - h) * 60)
                    $('#Widget-Avg-Time').html(h > 0 ? h + ' hour ' + m + ' minutes' : m + ' minutes')
                    $('#Widget-Processed').html(
                        new Intl.NumberFormat("id-ID").format(pt.total_processed ?? 0) +
                        ' diproses (' + (pt.utilization_pct ?? 0) + '% selesai)'
                    )
                    $('#Widget-Count-Customer').html(new Intl.NumberFormat("id-ID").format(res.data.widget_count.customer ?? 0))
                    $('#Widget-Count-Voucher').html(new Intl.NumberFormat("id-ID").format(res.data.widget_count.voucher ?? 0))
                    $('#Widget-Count-Redeem').html(new Intl.NumberFormat("id-ID").format(res.data.widget_count.redeem ?? 0))

                    // Item Gift Summary table
                    const summary = res.data.itemgift_summary || []
                    const tbody = $('#itemgift-summary-body')
                    if (summary.length) {
                        tbody.html(summary.map(function(row) {
                            return '<tr>' +
                                '<td>' + $('<div>').text(row.itemname || '-').html() + '</td>' +
                                '<td class="text-nowrap text-right font-weight-bold">' + new Intl.NumberFormat("id-ID").format(Number(row.total || 0)) + '</td>' +
                                '<td class="text-nowrap text-right text-success font-weight-bold">' + new Intl.NumberFormat("id-ID").format(Number(row.available || 0)) + '</td>' +
                                '<td class="text-nowrap text-right text-orange font-weight-bold d-none">' + new Intl.NumberFormat("id-ID").format(Number(row.redeemed || 0)) + '</td>' +
                                '<td class="text-nowrap text-right text-primary font-weight-bold">' + new Intl.NumberFormat("id-ID").format(Number(row.completed || 0)) + '</td>' +
                                '<td class="text-nowrap text-right text-danger font-weight-bold d-none">' + new Intl.NumberFormat("id-ID").format(Number(row.rejected || 0)) + '</td>' +
                                '<td class="text-nowrap text-right text-muted font-weight-bold">' + new Intl.NumberFormat("id-ID").format(Number(row.expired || 0)) + '</td>' +
                                '</tr>'
                        }).join(''))
                    } else {
                        tbody.html('<tr><td colspan="7" class="text-center text-muted py-3">No data</td></tr>')
                    }

                    // Chart - Line (Redeemed by Date)
                    if (chartInstance) chartInstance.destroy()
                    const redeemedByDate = res.data.redeemed_by_date || []
                    const ctx = document.getElementById('chartVoucher').getContext('2d')

                    var gradient = ctx.createLinearGradient(0, 0, 0, 400);
                    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.30)')
                    gradient.addColorStop(1, 'rgba(96, 165, 250, 0.03)')

                    var lineGradient = ctx.createLinearGradient(0, 0, 800, 0);
                    lineGradient.addColorStop(0, '#2563eb');
                    lineGradient.addColorStop(1, '#60a5fa');

                    var values = redeemedByDate.map(r => Number(r.count || 0));
                    var maxValue = Math.max.apply(null, values);

                    chartInstance = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: redeemedByDate.map(function(r) {
                                var d = new Date(r.redeem_date + 'T00:00:00')
                                var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                                return d.getDate() + ' ' + (months[d.getMonth()] || '')
                            }),
                            datasets: [{
                                label: 'Redeemed',
                                data: redeemedByDate.map(function(r) {
                                    return Number(r.count || 0)
                                }),
                                borderColor: lineGradient,
                                backgroundColor: gradient,
                                borderWidth: 3,
                                pointBackgroundColor: '#2563eb',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 8,
                                pointHitRadius: 20,
                                lineTension: 0.35,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 14,
                                    padding: 14,
                                    fontSize: 11
                                }
                            },
                            tooltips: {
                                backgroundColor: '#111827',
                                titleFontSize: 13,
                                bodyFontSize: 12,
                                cornerRadius: 12,
                                displayColors: false,
                                xPadding: 12,
                                yPadding: 10,
                                callbacks: {
                                    title: function(items) {
                                        var idx = items[0].index
                                        var raw = redeemedByDate[idx]
                                        return raw ? raw.redeem_date : ''
                                    },
                                    label: function(tooltipItem) {
                                        var v = tooltipItem.yLabel || 0
                                        return 'Redeemed: ' +
                                            String(v).replace(/\B(?=(\d{3})+(?!\d))/g, '.') +
                                            ' Item Point' + (v > 1 ? 's' : '')
                                    }
                                }
                            },
                            scales: {
                                xAxes: [{
                                    gridLines: {
                                        display: false
                                    },
                                    ticks: {
                                        fontSize: 11
                                    }
                                }],
                                yAxes: [{
                                    gridLines: {
                                        color: 'rgba(0,0,0,0.04)',
                                        drawBorder: false
                                    },
                                    ticks: {
                                        beginAtZero: true,
                                        precision: 0,
                                        fontSize: 11,
                                        callback: function(val) {
                                            return String(val).replace(/\B(?=(\d{3})+(?!\d))/g, '.')
                                        }
                                    }
                                }]
                            }
                        }
                    })

                    // Chart - Donut (Overall Status)
                    if (chartOverallInstance) chartOverallInstance.destroy()
                    const overall = res.data.chart_total || {}
                    const overallLabels = [
                        'Available',
                        // 'Redeemed',
                        'Completed',
                        // 'Rejected',
                        // 'Expired'
                    ]
                    const overallData = [
                        Number(overall.available || 0),
                        Number(overall.redeemed || 0),
                        Number(overall.completed || 0),
                        Number(overall.rejected || 0),
                        Number(overall.expired || 0)
                    ]
                    const overallColors = [
                        '#22c55e', // Available
                        // '#f59e0b',  // Redeemed
                        '#3b82f6', // Completed
                        // '#ef4444',  // Rejected
                        // '#94a3b8'   // Expired
                    ];
                    const ctxOverall = document.getElementById('chartOverall').getContext('2d');
                    chartOverallInstance = new Chart(ctxOverall, {
                        type: 'doughnut',
                        data: {
                            labels: overallLabels,
                            datasets: [{
                                data: overallData,
                                backgroundColor: overallColors,
                                borderWidth: 2,
                                borderColor: '#fff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutoutPercentage: 70,
                            hoverOffset: 10,
                            hoverBorderWidth: 4,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        boxWidth: 14,
                                        padding: 14,
                                        font: {
                                            size: 11
                                        }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: '#111827',
                                    titleFontSize: 13,
                                    bodyFontSize: 12,
                                    cornerRadius: 12,
                                    displayColors: false,
                                    callbacks: {
                                        label: function(context) {
                                            var total = context.dataset.data.reduce(function(a, b) {
                                                return a + b
                                            }, 0)
                                            var val = context.raw || 0
                                            var pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0
                                            var fmt = String(val).replace(/\B(?=(\d{3})+(?!\d))/g, '.')
                                            return context.label + ': ' + fmt + ' (' + pct + '%)'
                                        }
                                    }
                                }
                            }
                        }
                    });

                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                },
                complete: function() {
                    $('input, select, textarea, button').prop('disabled', false);
                    $.LoadingOverlay('hide');
                }
            })
        })
    </script>

</body>

</html>