<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('partial/activities/head.php') ?>
</head>

<body class="<?php $this->load->view('partial/activities/body-class'); ?>">
    <div class="wrapper">
        <?php $this->load->view('partial/activities/sidebar.php') ?>

        <div class="content-wrapper py-4 px-4 text-sm">
            <div class="row mb-2">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted font-italic">Tahan kuota kursi per lantai — penentuan seat dilakukan belakangan di Seating Layout</span>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-secondary" id="btnAdd">
                            <i class="fas fa-plus"></i> New
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="row" id="statsRow">
                <div class="col-12 col-md-4 mb-2">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-layer-group"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Lantai 1 — Sisa Kuota</span>
                            <span class="info-box-number" id="statFloor1">-</span>
                            <span class="info-box-description" id="subFloor1"></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-2">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-layer-group"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Lantai 2 — Sisa Kuota</span>
                            <span class="info-box-number" id="statFloor2">-</span>
                            <span class="info-box-description" id="subFloor2"></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-2">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-warning"><i class="fas fa-bookmark"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Dibooking (Aktif)</span>
                            <span class="info-box-number" id="statBooked">-</span>
                            <span class="info-box-description">kursi ditahan semua lantai</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-outline card-secondary mb-0">
                <div class="card-body py-2 px-2 border-bottom">
                    <div class="row">
                        <div class="col-6 col-md-5 mb-1">
                            <label class="mb-0">Search</label>
                            <input type="text" class="form-control form-control-sm" id="search"
                                placeholder="keterangan / lantai..." autocomplete="off">
                        </div>
                        <div class="col-6 col-md-2 mb-1">
                            <label class="mb-0">Floor</label>
                            <select class="form-control form-control-sm" id="filterFloor">
                                <option value="">All</option>
                                <option value="1">Lantai 1</option>
                                <option value="2">Lantai 2</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2 mb-1">
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
                                <button type="button" class="btn px-3 mr-1 btn-sm btn-secondary" id="btnReset">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                                <button type="button" class="btn px-3 btn-sm btn-primary" id="btnApply">
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
                                <th style="width: 90px;">Floor</th>
                                <th style="width: 70px;">Kursi</th>
                                <th>Keterangan</th>
                                <th style="width: 80px;">Status</th>
                                <th>Modified</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBodyBooking">
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Loading...</td>
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

        <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">New Booking</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formBooking">
                            <input type="hidden" name="booking_id" id="bookingid" value="">

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Floor <span class="text-danger">*</span></label>
                                        <select name="floor" id="floor" class="form-control">
                                            <option value="">-- Pilih --</option>
                                            <option value="1">Lantai 1</option>
                                            <option value="2">Lantai 2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Jumlah Kursi <span class="text-danger">*</span></label>
                                        <input type="number" name="seats" id="seats" class="form-control" min="1" step="1" value="1">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Keterangan <span class="text-danger">*</span></label>
                                <textarea name="keterangan" id="keterangan" class="form-control" autocomplete="off"
                                    placeholder="e.g. Reserved untuk panitia vocalia (6 orang)" rows="3"></textarea>
                                <small class="text-muted font-italic">Alasan penahanan kuota — kursi ini akan dipakai saat pendaftar nyata masuk.</small>
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="0">Aktif — menahan kuota</option>
                                    <option value="1">Batal — tidak menahan kuota</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="btnSave">
                            <i class="fas fa-save"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('partial/activities/footer.php') ?>
    </div>

    <?php $this->load->view('partial/activities/foot.php') ?>

    <script>
        $(function() {
            const endpoints = {
                list: '<?= site_url("activities/booking/data_list") ?>',
                stats: '<?= site_url("activities/booking/data_stats") ?>',
                create: '<?= site_url("activities/booking/data_new") ?>',
                edit: '<?= site_url("activities/booking/data_edit") ?>',
                update: '<?= site_url("activities/booking/data_update") ?>',
                delete: '<?= site_url("activities/booking/data_delete") ?>'
            }

            const state = {
                page: 1,
                perPage: 10,
                search: '',
                floor: ''
            }

            const modal = $('#modalForm')
            const form = $('#formBooking')
            const tableBody = $('#tableBodyBooking')
            const pagination = $('#pagination')
            const tableInfo = $('#tableInfo')

            const fields = {
                id: $('#bookingid'),
                floor: $('#floor'),
                seats: $('#seats'),
                keterangan: $('#keterangan'),
                status: $('#status')
            }

            const escapeHtml = (value) => $('<div>').text(value == null ? '' : String(value)).html()

            const formatDate = (value) => {
                if (!value) return '-'
                const d = new Date(value)
                if (isNaN(d)) return value
                const pad = (n) => String(n).padStart(2, '0')
                return `${pad(d.getDate())} ${d.toLocaleString('en-US', { month: 'short' })} ${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}`
            }

            const floorName = (floor) => Number(floor) === 2 ? 'Lantai 2' : 'Lantai 1'

            const statusBadge = (s) => Number(s) === 1
                ? '<span class="badge badge-secondary">Batal</span>'
                : '<span class="badge badge-success">Aktif</span>'

            const resetForm = () => {
                form[0].reset()
                fields.id.val('')
                fields.seats.val('1')
                fields.status.val('0')
                $('#modalTitle').text('New Booking')
            }

            const loadStats = () => {
                $.ajax({
                    url: endpoints.stats,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        if (!res.success || !res.data) return
                        const floors = res.data.floors || []
                        let totalBooked = 0

                        floors.forEach((f) => {
                            const el = f.floor === 1 ? $('#statFloor1') : $('#statFloor2')
                            const sub = f.floor === 1 ? $('#subFloor1') : $('#subFloor2')
                            el.html(`${f.remaining} <span class="text-muted font-weight-normal">/ ${f.capacity} Seats</span>`)
                            sub.text(`${f.registered} terdaftar · ${f.booked || 0} dibooking`)
                            totalBooked += Number(f.booked || 0)
                        })

                        $('#statBooked').text(totalBooked)
                    }
                })
            }

            const renderRows = (rows) => {
                if (!rows || !rows.length) {
                    tableBody.html('<tr><td colspan="7" class="text-center text-muted py-4">No data found</td></tr>')
                    return
                }

                const html = rows.map((row) => `
                    <tr>
                        <td class="d-none">${escapeHtml(row.bookingid)}</td>
                        <td>${escapeHtml(floorName(row.floor))}</td>
                        <td><span class="badge badge-info">${escapeHtml(row.seats)}</span></td>
                        <td style="max-width: 340px; word-break: break-word;">${escapeHtml(row.keterangan)}</td>
                        <td>${statusBadge(row.status)}</td>
                        <td>${escapeHtml(formatDate(row.modified_date || row.created_date))}</td>
                        <td class="text-right">
                            <button type="button" class="btn btn-xs btn-outline-primary btn-edit" data-id="${escapeHtml(row.bookingid)}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-outline-danger btn-delete" data-id="${escapeHtml(row.bookingid)}" data-name="${escapeHtml(row.keterangan)}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `).join('')

                tableBody.html(html)
            }

            const renderPagination = (paginationData) => {
                const totalPages = Number(paginationData.total_pages || 0)
                const currentPage = Number(paginationData.page || 1)
                const hasPrev = !!paginationData.has_prev
                const hasNext = !!paginationData.has_next

                if (totalPages <= 1) {
                    pagination.html('')
                    return
                }

                const items = []

                items.push(`
                    <li class="page-item ${hasPrev ? '' : 'disabled'}">
                        <a class="page-link" href="#" data-page="1">First</a>
                    </li>
                `)
                items.push(`
                    <li class="page-item ${hasPrev ? '' : 'disabled'}">
                        <a class="page-link" href="#" data-page="${Math.max(1, currentPage - 1)}">Prev</a>
                    </li>
                `)

                for (let i = 1; i <= totalPages; i++) {
                    if (i > 3 && i < totalPages - 1 && Math.abs(i - currentPage) > 1) {
                        if (items[items.length - 1] !== '<li class="page-item disabled"><span class="page-link">...</span></li>') {
                            items.push('<li class="page-item disabled"><span class="page-link">...</span></li>')
                        }
                        continue
                    }

                    items.push(`
                        <li class="page-item ${i === currentPage ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `)
                }

                items.push(`
                    <li class="page-item ${hasNext ? '' : 'disabled'}">
                        <a class="page-link" href="#" data-page="${Math.min(totalPages, currentPage + 1)}">Next</a>
                    </li>
                `)
                items.push(`
                    <li class="page-item ${hasNext ? '' : 'disabled'}">
                        <a class="page-link" href="#" data-page="${totalPages}">Last</a>
                    </li>
                `)

                pagination.html(items.join(''))
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
                        floor: state.floor
                    },
                    beforeSend: function() {
                        $('input, select, textarea, button').prop('disabled', true);
                        $.LoadingOverlay('show', {
                            background: 'rgba(0, 0, 0, 0.25)'
                        });
                    },
                    success: function(res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load booking data', 'error')
                            return
                        }

                        renderRows(res.data || [])
                        renderPagination(res.pagination || {})

                        const total = Number((res.pagination && res.pagination.total) || 0)
                        const page = Number((res.pagination && res.pagination.page) || 1)
                        const perPage = Number((res.pagination && res.pagination.per_page) || state.perPage)
                        const start = total === 0 ? 0 : ((page - 1) * perPage) + 1
                        const end = Math.min(total, page * perPage)

                        tableInfo.text(total === 0 ?
                            'Showing 0 to 0 of 0 entries' :
                            `Showing ${start} to ${end} of ${total} entries`)
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
            }

            const openCreateModal = () => {
                resetForm()
                modal.modal('show')
            }

            const openEditModal = (id) => {
                $.ajax({
                    url: endpoints.edit,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    beforeSend: function() {
                        $('input, select, textarea, button').prop('disabled', true);
                        $.LoadingOverlay('show', {
                            background: 'rgba(0, 0, 0, 0.25)'
                        });
                    },
                    success: function(res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load booking', 'error')
                            return
                        }

                        const item = res.data || {}
                        fields.id.val(item.bookingid || '')
                        fields.floor.val(String(item.floor || ''))
                        fields.seats.val(item.seats || 1)
                        fields.keterangan.val(item.keterangan || '')
                        fields.status.val(String(item.status || 0))
                        $('#modalTitle').text('Edit Booking')
                        modal.modal('show')
                    },
                    complete: function() {
                        $('input, select, textarea, button').prop('disabled', false);
                        $.LoadingOverlay('hide');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                    }
                })
            }

            $('#btnAdd').on('click', openCreateModal)

            $('#btnApply').on('click', function() {
                state.page = 1
                state.search = $('#search').val().trim()
                state.floor = $('#filterFloor').val()
                state.perPage = parseInt($('#perPage').val(), 10) || 10
                loadData()
            })

            $('#btnReset').on('click', function() {
                $('#search').val('')
                $('#filterFloor').val('')
                $('#perPage').val('10')
                state.page = 1
                state.perPage = 10
                state.search = ''
                state.floor = ''
                loadData()
            })

            $('#pagination').on('click', '.page-link', function(e) {
                e.preventDefault()
                const page = parseInt($(this).data('page'), 10)
                if (!page || $(this).closest('.page-item').hasClass('disabled') || $(this).closest('.page-item').hasClass('active')) {
                    return
                }
                state.page = page
                loadData()
            })

            $(document).on('click', '.btn-edit', function() {
                openEditModal($(this).data('id'))
            })

            $(document).on('click', '.btn-delete', function() {
                const id = $(this).data('id')
                const name = $(this).data('name')

                Swal.fire({
                    title: 'Delete this booking?',
                    text: name,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Delete'
                }).then(function(res) {
                    if (!res.isConfirmed) {
                        return
                    }

                    $.ajax({
                        url: endpoints.delete,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id: id
                        },
                        beforeSend: function() {
                            $('input, select, textarea, button').prop('disabled', true);
                            $.LoadingOverlay('show', {
                                background: 'rgba(0, 0, 0, 0.25)'
                            });
                        },
                        success: function(response) {
                            if (!response.success) {
                                Swal.fire('Error', response.message || 'Failed to delete booking', 'error')
                                return
                            }

                            Swal.fire('Success', response.message || 'Booking deleted successfully', 'success')
                            loadData()
                            loadStats()
                        },
                        complete: function() {
                            $('input, select, textarea, button').prop('disabled', false);
                            $.LoadingOverlay('hide');
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                        }
                    })
                })
            })

            $('#btnSave').on('click', function() {
                const payload = {
                    id: fields.id.val(),
                    floor: fields.floor.val(),
                    seats: fields.seats.val(),
                    keterangan: fields.keterangan.val(),
                    status: fields.status.val()
                }

                if (!payload.floor) {
                    Swal.fire('Validation', 'Floor wajib dipilih', 'warning')
                    return
                }
                if (!payload.seats || parseInt(payload.seats, 10) < 1) {
                    Swal.fire('Validation', 'Jumlah kursi minimal 1', 'warning')
                    return
                }
                if (!payload.keterangan.trim()) {
                    Swal.fire('Validation', 'Keterangan wajib diisi', 'warning')
                    return
                }

                const isEdit = payload.id !== ''
                const url = isEdit ? endpoints.update : endpoints.create

                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: payload,
                    beforeSend: function() {
                        $('input, select, textarea, button').prop('disabled', true);
                        $.LoadingOverlay('show', {
                            background: 'rgba(0, 0, 0, 0.25)'
                        });
                    },
                    success: function(res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to save booking', 'error')
                            return
                        }

                        Swal.fire('Success', res.message || 'Saved successfully', 'success')
                        modal.modal('hide')
                        loadData()
                        loadStats()
                    },
                    complete: function() {
                        $('input, select, textarea, button').prop('disabled', false);
                        $.LoadingOverlay('hide');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                    }
                })
            })

            modal.on('hidden.bs.modal', function() {
                resetForm()
            })

            loadStats()
            loadData()
        })
    </script>
</body>

</html>
