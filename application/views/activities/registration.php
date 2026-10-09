<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('partial/activities/head.php') ?>
</head>

<body class="<?php $this->load->view('partial/activities/body-class'); ?>">
    <div class="wrapper">
        <?php $this->load->view('partial/activities/sidebar.php') ?>

        <div class="content-wrapper py-4 px-4 text-sm">

            <!-- Stats -->
            <div class="row" id="statsRow">
                <div class="col-12 col-md-3 mb-2">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-layer-group"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Lantai 1</span>
                            <span class="info-box-number" id="statFloor1">-</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-md-3 mb-2">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-layer-group"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Lantai 2</span>
                            <span class="info-box-number" id="statFloor2">-</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-md-3 mb-2">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Pendaftar</span>
                            <span class="info-box-number" id="statTotal">-</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-md-3 mb-2">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-hourglass-half"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Menunggu Konfirmasi</span>
                            <span class="info-box-number" id="statPending">-</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>

            <div class="card card-outline card-secondary mb-0">
                <div class="card-body py-2 px-2 border-bottom">
                    <div class="row">
                        <div class="col-12 col-md-4 mb-2">
                            <label class="mb-0">Search</label>
                            <input type="text" class="form-control form-control-sm" id="search"
                                placeholder="No. HP / kode / nama jemaat..." autocomplete="off">
                        </div>
                        <div class="col-6 col-md-2 mb-2">
                            <label class="mb-0">Lantai</label>
                            <select class="form-control form-control-sm" id="filterFloor">
                                <option value="">Semua</option>
                                <option value="1">Lantai 1</option>
                                <option value="2">Lantai 2</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2 mb-2">
                            <label class="mb-0">Status</label>
                            <select class="form-control form-control-sm" id="filterStatus">
                                <option value="">Semua</option>
                                <option value="0">Pending</option>
                                <option value="1">Confirmed</option>
                                <option value="2">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-1 mb-2">
                            <label class="mb-0">Show</label>
                            <select class="form-control form-control-sm" id="perPage">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="mb-0">&nbsp;</label>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn px-3 mr-1 btn-sm btn-secondary w-100" id="btnReset">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                                <button type="button" class="btn px-3 btn-sm btn-primary w-100" id="btnApply">
                                    <i class="fas fa-check"></i> Apply
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-striped mb-0">
                        <thead>
                            <tr>
                                <th class="d-none">ID</th>
                                <th>Kode</th>
                                <th>No. HP</th>
                                <th>Lantai</th>
                                <th>Jemaat</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer px-2 py-2">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="dataTables_info font-italic" id="tableInfo">No data</div>
                        </div>
                        <div class="col-md-6">
                            <nav>
                                <ul class="pagination pagination-sm justify-content-end mb-0" id="pagination"></ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-clipboard-list mr-1"></i> Detail Pendaftaran</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="detailBody">
                        <div class="text-center text-muted py-3">Loading...</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('partial/activities/footer.php') ?>
    </div>

    <?php $this->load->view('partial/activities/foot.php') ?>

    <script>
        $(function () {
            const endpoints = {
                list: '<?= site_url("activities/registration/data_list") ?>',
                stats: '<?= site_url("activities/registration/data_stats") ?>',
                detail: '<?= site_url("activities/registration/data_detail") ?>',
                status: '<?= site_url("activities/registration/data_status") ?>',
                delete: '<?= site_url("activities/registration/data_delete") ?>'
            }

            const state = {
                page: 1,
                perPage: 10,
                search: '',
                floor: '',
                status: ''
            }

            const tableBody = $('#tableBody')
            const pagination = $('#pagination')
            const tableInfo = $('#tableInfo')

            const escapeHtml = (value) => $('<div>').text(value == null ? '' : String(value)).html()

            const formatDate = (value) => {
                if (!value) return '-'
                const d = new Date(value)
                if (isNaN(d)) return value
                const pad = (n) => String(n).padStart(2, '0')
                return `${pad(d.getDate())} ${d.toLocaleString('en-US', { month: 'short' })} ${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}`
            }

            const statusBadge = (s) => {
                s = Number(s)
                if (s === 1) return '<span class="badge badge-success">Confirmed</span>'
                if (s === 2) return '<span class="badge badge-danger">Cancelled</span>'
                return '<span class="badge badge-warning">Pending</span>'
            }

            const truncateNames = (names) => {
                if (!names) return '-'
                return names.length > 60 ? names.substring(0, 60) + '...' : names
            }

            const loadStats = () => {
                $.ajax({
                    url: endpoints.stats,
                    type: 'GET',
                    dataType: 'json',
                    success: function (res) {
                        if (!res.success || !res.data) return
                        const floors = res.data.floors || []
                        const t = res.data.totals || {}

                        floors.forEach((f) => {
                            const el = f.floor === 1 ? $('#statFloor1') : $('#statFloor2')
                            el.html(`${f.remaining} <span class="text-muted font-weight-normal">/ ${f.capacity} Kursi</span>`)
                        })

                        $('#statTotal').html(`${Number(t.people || 0)}  <span class="text-muted font-weight-normal"> Orang</span>`)
                        $('#statPending').text(Number(t.pending || 0))
                    }
                })
            }

            const loadData = () => {
                $.ajax({
                    url: endpoints.list,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        page: state.page,
                        per_page: state.perPage,
                        search: state.search,
                        floor: state.floor,
                        status: state.status
                    },
                    beforeSend: function () {
                        $.LoadingOverlay('show', {
                            background: 'rgba(0, 0, 0, 0.25)'
                        });
                    },
                    success: function (res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load data', 'error')
                            return
                        }

                        const rows = res.data || []
                        const pag = res.pagination || {}

                        if (!rows.length) {
                            tableBody.html('<tr><td colspan="8" class="text-center text-muted py-4">No data found</td></tr>')
                        } else {
                            const html = rows.map((row) => {
                                const s = Number(row.status)
                                let actions = `
                                    <button type="button" class="btn btn-xs btn-outline-info btn-detail" data-id="${escapeHtml(row.registrationid)}" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>`
                                if (s === 0) {
                                    actions += `
                                    <button type="button" class="btn btn-xs btn-outline-success btn-confirm" data-id="${escapeHtml(row.registrationid)}" title="Confirm">
                                        <i class="fas fa-check"></i>
                                    </button>`
                                }
                                if (s !== 2) {
                                    actions += `
                                    <button type="button" class="btn btn-xs btn-outline-warning btn-cancel" data-id="${escapeHtml(row.registrationid)}" title="Cancel">
                                        <i class="fas fa-ban"></i>
                                    </button>`
                                }
                                actions += `
                                    <button type="button" class="btn btn-xs btn-outline-danger btn-delete" data-id="${escapeHtml(row.registrationid)}" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>`

                                return `
                                <tr>
                                    <td class="d-none">${escapeHtml(row.registrationid)}</td>
                                    <td><code>${escapeHtml(row.ref_code || '-')}</code></td>
                                    <td>${escapeHtml(row.phone || '-')}</td>
                                    <td>${escapeHtml(row.floor_name || ('Lantai ' + row.floor))}</td>
                                    <td style="max-width: 240px; font-size: 11px;">
                                        <strong>${escapeHtml(row.attendee_count)} orang</strong><br>
                                        <span class="text-muted">${escapeHtml(truncateNames(row.attendee_names))}</span>
                                    </td>
                                    <td>${statusBadge(s)}</td>
                                    <td class="text-nowrap">${escapeHtml(formatDate(row.created_date))}</td>
                                    <td class="text-right text-nowrap">${actions}</td>
                                </tr>`
                            }).join('')
                            tableBody.html(html)
                        }

                        const total = Number(pag.total || 0)
                        const page = Number(pag.page || 1)
                        const perPage = Number(pag.per_page || state.perPage)
                        const start = total === 0 ? 0 : ((page - 1) * perPage) + 1
                        const end = Math.min(total, page * perPage)

                        tableInfo.text(total === 0 ?
                            'Showing 0 to 0 of 0 entries' :
                            `Showing ${start} to ${end} of ${total} entries`)

                        const totalPages = Number(pag.total_pages || 0)
                        const currentPage = Number(pag.page || 1)
                        const hasPrev = !!pag.has_prev
                        const hasNext = !!pag.has_next

                        if (totalPages <= 1) {
                            pagination.html('')
                            return
                        }

                        const items = []
                        items.push(`<li class="page-item ${hasPrev ? '' : 'disabled'}"><a class="page-link" href="#" data-page="1">First</a></li>`)
                        items.push(`<li class="page-item ${hasPrev ? '' : 'disabled'}"><a class="page-link" href="#" data-page="${Math.max(1, currentPage - 1)}">Prev</a></li>`)

                        for (let i = 1; i <= totalPages; i++) {
                            if (i > 3 && i < totalPages - 1 && Math.abs(i - currentPage) > 1) {
                                if (items[items.length - 1] !== '<li class="page-item disabled"><span class="page-link">...</span></li>') {
                                    items.push('<li class="page-item disabled"><span class="page-link">...</span></li>')
                                }
                                continue
                            }
                            items.push(`<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`)
                        }

                        items.push(`<li class="page-item ${hasNext ? '' : 'disabled'}"><a class="page-link" href="#" data-page="${Math.min(totalPages, currentPage + 1)}">Next</a></li>`)
                        items.push(`<li class="page-item ${hasNext ? '' : 'disabled'}"><a class="page-link" href="#" data-page="${totalPages}">Last</a></li>`)

                        pagination.html(items.join(''))
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                    },
                    complete: function () {
                        $.LoadingOverlay('hide');
                    }
                })
            }

            const refresh = () => {
                loadData()
                loadStats()
            }

            $('#btnApply').on('click', function () {
                state.page = 1
                state.search = $('#search').val().trim()
                state.floor = $('#filterFloor').val()
                state.status = $('#filterStatus').val()
                state.perPage = parseInt($('#perPage').val(), 10) || 10
                refresh()
            })

            $('#btnReset').on('click', function () {
                $('#search').val('')
                $('#filterFloor').val('')
                $('#filterStatus').val('')
                $('#perPage').val('10')
                state.page = 1
                state.perPage = 10
                state.search = ''
                state.floor = ''
                state.status = ''
                refresh()
            })

            $('#pagination').on('click', '.page-link', function (e) {
                e.preventDefault()
                const page = parseInt($(this).data('page'), 10)
                if (!page || $(this).closest('.page-item').hasClass('disabled') || $(this).closest('.page-item').hasClass('active')) {
                    return
                }
                state.page = page
                loadData()
            })

            /* Detail */
            $(document).on('click', '.btn-detail', function () {
                const id = $(this).data('id')
                $('#detailBody').html('<div class="text-center text-muted py-3">Loading...</div>')
                $('#modalDetail').modal('show')

                $.ajax({
                    url: endpoints.detail,
                    type: 'GET',
                    dataType: 'json',
                    data: { id: id },
                    success: function (res) {
                        if (!res.success) {
                            $('#detailBody').html('<div class="alert alert-warning mb-0 py-2 text-sm"><i class="fas fa-exclamation-triangle mr-1"></i> Data tidak ditemukan.</div>')
                            return
                        }
                        const d = res.data
                        const attendees = d.attendees || []
                        const rows = attendees.map((a, i) => `
                            <tr>
                                <td class="text-center text-muted" style="width:36px">${i + 1}</td>
                                <td>${escapeHtml(a.name)} ${Number(a.is_primary) === 1 ? '<span class="badge badge-info">Pendaftar</span>' : ''}</td>
                                <td class="text-right text-nowrap" style="width:90px">${escapeHtml(a.age)} th</td>
                            </tr>`).join('')

                        $('#detailBody').html(`
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 text-sm"><i class="fas fa-clipboard-list mr-1 text-muted"></i> Data Pendaftaran</h6>
                                ${statusBadge(d.status)}
                            </div>
                            <table class="table table-sm table-bordered mb-3 bg-white text-sm">
                                <tr><th class="bg-light" style="width:38%">Kode</th><td><code class="text-dark">${escapeHtml(d.ref_code || '-')}</code></td></tr>
                                <tr><th class="bg-light">No. Handphone</th><td><a href="tel:${escapeHtml(d.phone || '')}">${escapeHtml(d.phone || '-')}</a></td></tr>
                                <tr><th class="bg-light">Lantai</th><td>${escapeHtml(d.floor_name || ('Lantai ' + d.floor))}</td></tr>
                                <tr><th class="bg-light">Tanggal Daftar</th><td>${escapeHtml(formatDate(d.created_date))}</td></tr>
                                <tr><th class="bg-light">Jumlah Jemaat</th><td><strong>${attendees.length}</strong> orang</td></tr>
                            </table>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 text-sm"><i class="fas fa-users mr-1 text-muted"></i> Daftar Jemaat</h6>
                                <span class="badge badge-secondary">${attendees.length} orang</span>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered mb-0 text-sm">
                                    <thead><tr><th class="text-center" style="width:36px">#</th><th>Nama</th><th class="text-right" style="width:90px">Umur</th></tr></thead>
                                    <tbody>${rows || '<tr><td colspan="3" class="text-center text-muted py-3">Belum ada data jemaat</td></tr>'}</tbody>
                                </table>
                            </div>`)
                    }
                })
            })

            /* Status change */
            const changeStatus = (id, status, title, text) => {
                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya'
                }).then(function (res) {
                    if (!res.isConfirmed) return

                    $.ajax({
                        url: endpoints.status,
                        type: 'POST',
                        dataType: 'json',
                        data: { id: id, status: status },
                        beforeSend: function () {
                            $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' });
                        },
                        success: function (response) {
                            if (!response.success) {
                                Swal.fire('Error', response.message || 'Failed to update status', 'error')
                                return
                            }
                            Swal.fire('Success', response.message || 'Status updated', 'success')
                            refresh()
                        },
                        complete: function () {
                            $.LoadingOverlay('hide');
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                        }
                    })
                })
            }

            $(document).on('click', '.btn-confirm', function () {
                changeStatus($(this).data('id'), 1, 'Confirm this registration?', 'Pendaftaran akan ditandai Confirmed.')
            })

            $(document).on('click', '.btn-cancel', function () {
                changeStatus($(this).data('id'), 2, 'Cancel this registration?', 'Pendaftaran akan ditandai Cancelled dan kursi dilepas.')
            })

            /* Delete */
            $(document).on('click', '.btn-delete', function () {
                const id = $(this).data('id')

                Swal.fire({
                    title: 'Delete this registration?',
                    text: 'Semua data jemaat pada pendaftaran ini ikut terhapus.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Delete'
                }).then(function (res) {
                    if (!res.isConfirmed) return

                    $.ajax({
                        url: endpoints.delete,
                        type: 'POST',
                        dataType: 'json',
                        data: { id: id },
                        beforeSend: function () {
                            $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' });
                        },
                        success: function (response) {
                            if (!response.success) {
                                Swal.fire('Error', response.message || 'Failed to delete', 'error')
                                return
                            }
                            Swal.fire('Success', response.message || 'Deleted', 'success')
                            refresh()
                        },
                        complete: function () {
                            $.LoadingOverlay('hide');
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                        }
                    })
                })
            })

            refresh()
        })
    </script>
</body>

</html>