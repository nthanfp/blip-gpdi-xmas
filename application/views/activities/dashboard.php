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

            background: url('<?= base_url("assets/images/christmas/gpdi.webp") ?>') no-repeat center;
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
            text-decoration: none;
        }

        .info-box-wrap:hover .info-box {
            filter: brightness(1.08);
        }
    </style>
</head>

<body class="<?php $this->load->view('partial/activities/body-class'); ?>">
    <div class="wrapper">

        <?php $this->load->view('partial/activities/sidebar.php') ?>

        <div class="content-wrapper py-4 px-4 text-sm">

            <!-- Ringkasan -->
            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <a class="info-box-wrap text-dark" href="<?= site_url('activities/registration') ?>">
                        <div class="info-box shadow-sm">
                            <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">People Registered</span>
                                <span class="info-box-number" id="dashPeople">-</span>
                                <span class="info-box-description" id="dashPeopleSub"></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-xl-3">
                    <a class="info-box-wrap text-dark" href="<?= site_url('activities/registration') ?>">
                        <div class="info-box shadow-sm">
                            <span class="info-box-icon bg-secondary" id="dashFloor1Icon"><i class="fas fa-layer-group"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Floor 1 — Remaining</span>
                                <span class="info-box-number" id="dashFloor1">-</span>
                                <span class="info-box-description" id="dashFloor1Sub"></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-xl-3">
                    <a class="info-box-wrap text-dark" href="<?= site_url('activities/registration') ?>">
                        <div class="info-box shadow-sm">
                            <span class="info-box-icon bg-secondary" id="dashFloor2Icon"><i class="fas fa-layer-group"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Floor 2 — Remaining</span>
                                <span class="info-box-number" id="dashFloor2">-</span>
                                <span class="info-box-description" id="dashFloor2Sub"></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-xl-3">
                    <a class="info-box-wrap text-dark" href="<?= site_url('activities/registration') ?>">
                        <div class="info-box shadow-sm">
                            <span class="info-box-icon bg-warning"><i class="fas fa-hourglass-half"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Pending Confirmation</span>
                                <span class="info-box-number" id="dashPending">-</span>
                                <span class="info-box-description">awaiting confirmation</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Booking & Seating -->
            <div class="row mt-3">
                <div class="col-lg-4" id="cardBooking">
                    <div class="card card-outline card-secondary dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-envelope-open-text mr-1"></i>Booking &amp; Invitation</h3>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                <span class="text-muted">Active bookings</span>
                                <b id="bkBookings">-</b>
                            </div>
                            <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                <span class="text-muted">Seats held</span>
                                <b id="bkSeats">-</b>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Invitations confirmed</span>
                                <b id="bkConfirmed">-</b>
                            </div>
                            <a class="btn btn-sm btn-outline-primary btn-block" href="<?= site_url('activities/booking') ?>">
                                Open Booking &amp; Invitation
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card card-outline card-secondary dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chair mr-1"></i>Seating Occupancy</h3>
                        </div>
                        <div class="card-body p-3" id="seatingBox">
                            <div class="text-muted text-center py-3">Loading...</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart & pendaftar terbaru -->
            <div class="row mt-3">
                <div class="col-lg-7">
                    <div class="card card-outline card-secondary dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-bar mr-1"></i>Registrations — Last 30 Days</h3>
                        </div>
                        <div class="card-body chart-wrap">
                            <canvas id="chartDaily"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card card-outline card-secondary dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-clock mr-1"></i>Latest Registrations</h3>
                            <div class="card-tools">
                                <a href="<?= site_url('activities/registration') ?>">View all</a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th class="text-center">Floor</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="latestBody">
                                        <tr><td colspan="4" class="text-center text-muted py-4">Loading...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer d-none" id="dupesFooter">
                            <a href="<?= site_url('activities/registration') ?>" id="dupesLink"></a>
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
        $(function () {
            const endpoints = {
                summary: '<?= site_url("activities/dashboard/data_dashboard") ?>'
            };

            const escapeHtml = (v) => $('<div>').text(v == null ? '' : String(v)).html()

            const MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']

            const fmtDate = (s) => {
                if (!s) return ''
                const mo = parseInt(String(s).substr(5, 2), 10)
                const d = parseInt(String(s).substr(8, 2), 10)
                if (isNaN(mo) || isNaN(d)) return ''
                return `${d} ${MONTHS[mo - 1] || ''}`
            }

            const shortName = (n) => {
                const w = String(n).trim().split(/\s+/).filter(Boolean)
                if (w.length <= 2) return w.join(' ')
                return `${w[0]} ${w[1]} ${w[2].charAt(0).toUpperCase()}`
            }

            const displayName = (name, people) => {
                const base = name ? escapeHtml(shortName(name)) : '-'
                const p = Number(people || 0)
                if (p > 1) {
                    const extra = p - 1
                    return `${base} &amp; ${extra} person${extra > 1 ? 's' : ''}`
                }
                return base
            };

            const statusBadge = (s) => {
                s = Number(s)
                if (s === 1) return '<span class="badge badge-success">CONFIRMED</span>'
                if (s === 2) return '<span class="badge badge-danger">CANCELLED</span>'
                return '<span class="badge badge-warning">PENDING</span>'
            }

            const last30Labels = () => {
                const labels = []
                    const keys = []
                    const now = new Date()
                    for (let i = 29; i >= 0; i--) {
                        const d = new Date(now.getFullYear(), now.getMonth(), now.getDate() - i)
                        const y = d.getFullYear()
                        const m = String(d.getMonth() + 1).padStart(2, '0')
                        const day = String(d.getDate()).padStart(2, '0')
                        keys.push(`${y}-${m}-${day}`)
                        labels.push(`${parseInt(day, 10)} ${MONTHS[d.getMonth()]}`)
                    }
                    return { labels, keys }
            }

            let dailyChart = null

            const renderChart = (daily) => {
                const { labels, keys } = last30Labels()
                const data = keys.map(k => Number(daily[k] || 0))
                const ctx = document.getElementById('chartDaily').getContext('2d')
                if (dailyChart) dailyChart.destroy()
                dailyChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Registrations',
                            data: data,
                            backgroundColor: 'rgba(220, 53, 69, 0.75)',
                            hoverBackgroundColor: 'rgba(220, 53, 69, 0.95)',
                            borderWidth: 0
                        }]
                    },
                    options: {
                        legend: { display: false },
                        title: { display: false },
                        maintainAspectRatio: false,
                        scales: {
                            xAxes: [{
                                gridLines: { display: false },
                                ticks: { maxRotation: 0, autoSkip: true, maxTicksLimit: 10, fontColor: '#6c757d' },
                                barPercentage: 0.7,
                                categoryPercentage: 0.8
                            }],
                            yAxes: [{
                                ticks: { beginAtZero: true, precision: 0, fontColor: '#6c757d', suggestedMin: 0 },
                                gridLines: { color: 'rgba(0, 0, 0, 0.06)' }
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: (item) => ` ${item.yLabel} registration(s)`
                            }
                        }
                    }
                })
            }

            const renderSeating = (seating, floors) => {
                const map = {}
                ;(seating || []).forEach(s => { map[Number(s.floor_id)] = s })
                const html = (floors || []).map(f => {
                    const s = map[Number(f.floor)] || { seats: 0, assigned: 0, reserved: 0 }
                    const total = Number(s.seats) || 0
                    const assigned = Number(s.assigned) || 0
                    const reserved = Number(s.reserved) || 0
                    const pct = (n) => total > 0 ? Math.min(100, (n / total) * 100).toFixed(1) : 0
                    return `
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span><b>${escapeHtml(f.name || ('Floor ' + f.floor))}</b></span>
                                <small class="text-muted">${assigned + reserved} / ${total} seats occupied</small>
                            </div>
                            <div class="progress" style="height: 14px;">
                                <div class="progress-bar bg-info" style="width: ${pct(assigned)}%" title="Assigned to registrants"></div>
                                <div class="progress-bar bg-warning" style="width: ${pct(reserved)}%" title="Reserved for booking"></div>
                            </div>
                            <small class="text-muted">${assigned} assigned · ${reserved} reserved (booking)</small>
                        </div>`
                }).join('')
                $('#seatingBox').html(html || '<div class="text-muted text-center py-3">No floor data</div>')
            }

            const renderLatest = (latest) => {
                if (!latest || !latest.length) {
                    $('#latestBody').html('<tr><td colspan="4" class="text-center text-muted py-4">No registrations yet</td></tr>')
                    return
                }
                const html = latest.map(r => {
                    const date = fmtDate(r.created_date)
                    return `
                        <tr>
                            <td><code>${escapeHtml(r.ref_code)}</code><br><small class="text-muted">${escapeHtml(date)}</small></td>
                            <td>${displayName(r.name, r.people)}</td>
                            <td class="text-center">${Number(r.floor)}</td>
                            <td class="text-center">${statusBadge(r.status)}</td>
                        </tr>`
                }).join('')
                $('#latestBody').html(html)
            }

            const loadSummary = () => {
                $.ajax({
                    url: endpoints.summary,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' })
                    },
                    complete: function () {
                        $.LoadingOverlay('hide')
                    },
                    success: function (res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load dashboard', 'error')
                            return
                        }
                        const d = res.data || {}
                        const floors = d.floors || []
                        const t = d.totals || {}

                        $('#dashPeople').text(Number(t.people || 0))
                        $('#dashPeopleSub').text(`${Number(t.registration || 0)} registrations`)
                        $('#dashPending').text(Number(t.pending || 0))

                        floors.forEach(f => {
                            const n = Number(f.floor)
                            if (n !== 1 && n !== 2) return
                            const remaining = Number(f.remaining || 0)
                            const used = Number(f.registered || 0) + Number(f.booked || 0)
                            $(`#dashFloor${n}`).text(remaining)
                            $(`#dashFloor${n}Sub`).text(`${used}/${Number(f.capacity || 0)} used`)
                            const icon = $(`#dashFloor${n}Icon`)
                            icon.removeClass('bg-secondary bg-success bg-danger')
                            icon.addClass(remaining > 0 ? 'bg-success' : 'bg-danger')
                        })

                        if (d.booking) {
                            $('#bkBookings').text(Number(d.booking.bookings || 0))
                            $('#bkSeats').text(Number(d.booking.seats || 0))
                            $('#bkConfirmed').text(Number(d.booking.confirmed || 0))
                        } else {
                            $('#cardBooking').hide()
                        }

                        renderSeating(d.seating, floors)
                        renderChart(d.daily || {})
                        renderLatest(d.latest)

                        const dupes = Number(d.dupes || 0)
                        if (dupes > 0) {
                            $('#dupesLink').html(
                                `<i class="fas fa-clone mr-1"></i>${dupes} duplicate group(s) found (same phone + name) &rarr;`
                            )
                            $('#dupesFooter').removeClass('d-none')
                        } else {
                            $('#dupesFooter').addClass('d-none')
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Failed to reach server', 'error')
                    }
                })
            }

            loadSummary()
        })
    </script>

</body>

</html>