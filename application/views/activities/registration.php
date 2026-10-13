<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('partial/activities/head.php') ?>
</head>

<body class="<?php $this->load->view('partial/activities/body-class'); ?>">
    <div class="wrapper">
        <?php $this->load->view('partial/activities/sidebar.php') ?>

        <div class="content-wrapper py-4 px-4 text-sm">

            <!-- Atur Kuota (trigger modal) -->
            <div class="d-flex justify-content-end mb-2">
                <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modalKuota">
                    <i class="fas fa-sliders-h mr-1"></i> Set Quota
                </button>
            </div>

            <!-- Stats -->
            <div class="row" id="statsRow">
                <div class="col-12 col-md-3 mb-2">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-layer-group"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Floor 1</span>
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
                            <span class="info-box-text">Floor 2</span>
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
                            <span class="info-box-text">Total Registrations</span>
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
                            <span class="info-box-text">Pending Confirmation</span>
                            <span class="info-box-number" id="statPending">-</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>

            <div class="card card-outline card-secondary mb-0">
                <div class="card-header py-1 px-2 view-header">
                    <h3 class="card-title text-sm py-1 mb-0"><i class="fas fa-list mr-1"></i> <span id="viewTitle">Registration List</span></h3>
                    <div class="view-toggle" role="group" aria-label="View switcher">
                        <button type="button" class="view-btn active" id="btnViewGroup" title="Group view">
                            <i class="fas fa-layer-group"></i><span class="d-none d-md-inline">Group</span>
                        </button>
                        <button type="button" class="view-btn" id="btnViewPeople" title="Individual view">
                            <i class="fas fa-user"></i><span class="d-none d-md-inline">Individual</span>
                        </button>
                    </div>
                </div>
                <div class="card-body py-2 px-2 border-bottom">
                    <div class="row">
                        <div class="col-12 col-md-4 mb-2">
                            <label class="mb-0">Search</label>
                            <input type="text" class="form-control form-control-sm" id="search"
                                placeholder="Phone / code / attendee name..." autocomplete="off">
                        </div>
                        <div class="col-12 col-md-2 mb-2">
                            <label class="mb-0">Floor</label>
                            <select class="form-control form-control-sm" id="filterFloor">
                                <option value="">All</option>
                                <option value="1">Floor 1</option>
                                <option value="2">Floor 2</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2 mb-2">
                            <label class="mb-0">Status</label>
                            <select class="form-control form-control-sm" id="filterStatus">
                                <option value="">All</option>
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
                    <table class="table table-sm table-striped mb-0 text-nowrap">
                        <thead>
                            <tr id="tableHead">
                                <th class="d-none">ID</th>
                                <th>Code</th>
                                <th>Phone</th>
                                <th>Floor</th>
                                <th>Attendees</th>
                                <th class="text-center">Status</th>
                                <th>Date</th>
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

        <!-- Modal Kuota -->
        <div class="modal fade" id="modalKuota" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-sliders-h mr-1"></i> Floor Quota Settings</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label>Floor 1 Capacity</label>
                            <input type="number" class="form-control form-control-sm" id="capFloor1"
                                min="0" max="10000" placeholder="e.g. 120" autocomplete="off">
                        </div>
                        <div class="form-group mb-0">
                            <label>Floor 2 Capacity</label>
                            <input type="number" class="form-control form-control-sm" id="capFloor2"
                                min="0" max="10000" placeholder="e.g. 85" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-sm" id="btnSaveCap">
                            <i class="fas fa-save mr-1"></i> Save Quota
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirm/Cancel (pilih attendee) -->
        <div class="modal fade" id="modalStatus" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalStatusTitle"></h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="custom-control custom-checkbox mb-2 pb-2 border-bottom">
                            <input type="checkbox" class="custom-control-input" id="statusCheckAll" checked>
                            <label class="custom-control-label font-weight-bold" for="statusCheckAll">Select all attendees</label>
                        </div>
                        <div id="statusAttendeeList"></div>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-sm" id="btnStatusSubmit"></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-clipboard-list mr-1"></i> Registration Detail</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="detailBody">
                        <div class="text-center text-muted py-3">Loading...</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('partial/activities/footer.php') ?>
    </div>

    <?php $this->load->view('partial/activities/foot.php') ?>

    <style>
        .card-header.view-header {
            display: flex;
            align-items: center;
            min-height: 34px;
        }

        .card-header.view-header .card-title {
            flex: 1 1 0;
            margin-bottom: 0;
            line-height: 1.2;
        }

        .view-toggle {
            flex: 0 0 auto;
            display: inline-flex;
            gap: 4px;
            align-items: center;
        }

        .view-toggle .view-btn {
            width: auto;
            min-width: 26px;
            height: 26px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            background: #fff;
            color: #6c757d;
            padding: 0 8px;
            margin: 0;
            line-height: 1;
            font-size: 12px;
        }

        .view-toggle .view-btn:hover {
            border-color: #6c757d;
            color: #6c757d;
        }

        .view-toggle .view-btn.active {
            background: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }
    </style>

    <script>
        $(function () {
            const endpoints = {
                list: '<?= site_url("activities/registration/data_list") ?>',
                people: '<?= site_url("activities/registration/data_list_people") ?>',
                stats: '<?= site_url("activities/registration/data_stats") ?>',
                detail: '<?= site_url("activities/registration/data_detail") ?>',
                status: '<?= site_url("activities/registration/data_status") ?>',
                delete: '<?= site_url("activities/registration/data_delete") ?>',
                deleteAttendee: '<?= site_url("activities/registration/data_delete_attendee") ?>',
                capacity: '<?= site_url("activities/registration/data_capacity") ?>'
            }

            const state = {
                page: 1,
                perPage: 10,
                search: '',
                floor: '',
                status: '',
                view: 'group',
                sortBy: 'date',
                sortOrder: 'desc'
            }

            const tableBody = $('#tableBody')
            const pagination = $('#pagination')
            const tableInfo = $('#tableInfo')

            const escapeHtml = (value) => $('<div>').text(value == null ? '' : String(value)).html()
            const upperName = (value) => String(value == null ? '' : value).toUpperCase()

            const formatDate = (value) => {
                if (!value) return '-'
                const d = new Date(value)
                if (isNaN(d)) return value
                const pad = (n) => String(n).padStart(2, '0')
                return `${pad(d.getDate())} ${d.toLocaleString('en-US', { month: 'short' })} ${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}`
            }

            const statusBadge = (s) => {
                s = Number(s)
                if (s === 1) return '<span class="badge badge-success">CONFIRMED</span>'
                if (s === 2) return '<span class="badge badge-danger">CANCELLED</span>'
                return '<span class="badge badge-warning">PENDING</span>'
            }

            const confirmedCount = (confirmed, total) => {
                const x = Number(confirmed || 0)
                const y = Number(total || 0)
                return `${x}/${y}`
            }

            const truncateNames = (names) => {
                if (!names) return '-'
                const u = String(names).toUpperCase()
                return u.length > 60 ? u.substring(0, 60) + '...' : u
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
                            el.html(`${f.remaining} <span class="text-muted font-weight-normal">/ ${f.capacity} Seats</span>`)

                            const capInput = f.floor === 1 ? $('#capFloor1') : $('#capFloor2')
                            capInput.val(f.capacity)
                        })

                        $('#statTotal').html(`${Number(t.people || 0)}  <span class="text-muted font-weight-normal"> People</span>`)
                        $('#statPending').text(Number(t.pending || 0))
                    }
                })
            }

            const thSort = (key, label, align) => {
                const active = state.sortBy === key
                const icon = active ? (state.sortOrder === 'asc' ? 'fa-sort-up' : 'fa-sort-down') : 'fa-sort'
                const iconCls = active ? 'text-secondary' : 'text-muted'
                return `<th class="th-sort${align ? ' ' + align : ''}" data-sort="${key}" style="cursor:pointer; user-select:none;" title="Sort by ${label}">
                    ${label} <i class="fas ${icon} ml-1 ${iconCls}"></i>
                </th>`
            }

            const renderHead = () => {
                const people = state.view === 'people'
                $('#tableHead').html(`
                    <th class="d-none">ID</th>
                    ${thSort('code', 'Code')}
                    ${thSort('phone', 'Phone')}
                    ${thSort('floor', 'Floor')}
                    ${thSort(people ? 'name' : 'attendees', people ? 'Name' : 'Attendees')}
                    ${thSort('status', 'Status', 'text-center')}
                    ${thSort('date', 'Date')}
                    <th class="text-right">Action</th>`)
            }

            const setView = (view) => {
                if (state.view === view) return
                state.view = view
                state.page = 1
                state.sortBy = 'date'
                state.sortOrder = 'desc'
                const toPeople = view === 'people'
                $('#btnViewGroup').toggleClass('active', !toPeople)
                $('#btnViewPeople').toggleClass('active', toPeople)
                renderHead()
                loadData()
            }

            $('#btnViewGroup').on('click', function () {
                setView('group')
            })

            $('#btnViewPeople').on('click', function () {
                setView('people')
            })

            $(document).on('click', '.th-sort', function () {
                const key = String($(this).data('sort') || '')
                if (!key) return
                if (state.sortBy === key) {
                    state.sortOrder = state.sortOrder === 'asc' ? 'desc' : 'asc'
                } else {
                    state.sortBy = key
                    state.sortOrder = key === 'date' ? 'desc' : 'asc'
                }
                state.page = 1
                renderHead()
                loadData()
            })

            const renderActions = (id) => `
                <button type="button" class="btn btn-xs btn-outline-info btn-detail" data-id="${escapeHtml(id)}" title="Detail">
                    <i class="fas fa-eye"></i>
                </button>
                <button type="button" class="btn btn-xs btn-outline-success btn-confirm" data-id="${escapeHtml(id)}" title="Confirm">
                    <i class="fas fa-check"></i>
                </button>
                <button type="button" class="btn btn-xs btn-outline-warning btn-cancel" data-id="${escapeHtml(id)}" title="Cancel">
                    <i class="fas fa-ban"></i>
                </button>
                <button type="button" class="btn btn-xs btn-outline-danger btn-delete" data-id="${escapeHtml(id)}" title="Delete">
                    <i class="fas fa-trash"></i>
                </button>`

            const renderPersonActions = (row) => `
                <button type="button" class="btn btn-xs btn-outline-info btn-detail" data-id="${escapeHtml(row.registrationid)}" title="Detail">
                    <i class="fas fa-eye"></i>
                </button>
                <button type="button" class="btn btn-xs btn-outline-success btn-person-confirm" data-reg="${escapeHtml(row.registrationid)}" data-att="${escapeHtml(row.attendeeid)}" data-status="${escapeHtml(row.status)}" title="Confirm">
                    <i class="fas fa-check"></i>
                </button>
                <button type="button" class="btn btn-xs btn-outline-warning btn-person-cancel" data-reg="${escapeHtml(row.registrationid)}" data-att="${escapeHtml(row.attendeeid)}" data-status="${escapeHtml(row.status)}" title="Cancel">
                    <i class="fas fa-ban"></i>
                </button>
                <button type="button" class="btn btn-xs btn-outline-danger btn-person-delete" data-reg="${escapeHtml(row.registrationid)}" data-att="${escapeHtml(row.attendeeid)}" data-name="${escapeHtml(row.name)}" title="Delete">
                    <i class="fas fa-trash"></i>
                </button>`

            const loadData = () => {
                $.ajax({
                    url: state.view === 'people' ? endpoints.people : endpoints.list,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        page: state.page,
                        per_page: state.perPage,
                        search: state.search,
                        floor: state.floor,
                        status: state.status,
                        sort_by: state.sortBy,
                        sort_order: state.sortOrder
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
                                if (state.view === 'people') {
                                    const actions = renderPersonActions(row)
                                    return `
                                <tr>
                                    <td class="d-none">${escapeHtml(row.attendeeid)}</td>
                                    <td><code>${escapeHtml(row.ref_code || '-')}</code></td>
                                    <td>${escapeHtml(row.phone || '-')}</td>
                                    <td>${escapeHtml('Floor ' + row.floor)}</td>
                                    <td>${escapeHtml(upperName(row.name))}</td>
                                    <td class="text-center">${statusBadge(row.status)}</td>
                                    <td class="text-nowrap">${escapeHtml(formatDate(row.created_date))}</td>
                                    <td class="text-right text-nowrap">${actions}</td>
                                </tr>`
                                }

                                const actions = renderActions(row.registrationid)
                                return `
                                <tr>
                                    <td class="d-none">${escapeHtml(row.registrationid)}</td>
                                    <td><code>${escapeHtml(row.ref_code || '-')}</code></td>
                                    <td>${escapeHtml(row.phone || '-')}</td>
                                    <td>${escapeHtml('Floor ' + row.floor)}</td>
                                    <td style="max-width: 240px; font-size: 11px;">
                                        <strong>${escapeHtml(row.attendee_count)} people</strong><br>
                                        <span class="text-muted">${escapeHtml(truncateNames(row.attendee_names))}</span>
                                    </td>
                                    <td class="text-center">${confirmedCount(row.confirmed_count, row.attendee_count)}</td>
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
                            $('#detailBody').html('<div class="alert alert-warning mb-0 py-2 text-sm"><i class="fas fa-exclamation-triangle mr-1"></i> Data not found.</div>')
                            return
                        }
                        const d = res.data
                        const attendees = d.attendees || []
                        const seatBadge = (a) => {
                            if (a.seat_number) return `<span class="badge badge-success">Seat ${a.seat_number}</span>`
                            if (a.status == 1) return `<span class="badge badge-warning">No seat</span>`
                            return `<span class="text-muted">&mdash;</span>`
                        }
                        const rows = attendees.map((a, i) => `
                            <tr>
                                <td class="text-center text-muted" style="width:36px">${i + 1}</td>
                                <td>${escapeHtml(upperName(a.name))}</td>
                                <td class="text-right text-nowrap" style="width:80px">${escapeHtml(a.age)} yrs</td>
                                <td class="text-center text-nowrap" style="width:100px">${statusBadge(a.status)}</td>
                                <td class="text-center text-nowrap" style="width:90px">${seatBadge(a)}</td>
                            </tr>`).join('')

                        $('#detailBody').html(`
                            <div class="row text-sm mb-2">
                                <div class="col-6 mb-1"><span class="text-muted">Code:</span> <code class="text-dark">${escapeHtml(d.ref_code || '-')}</code></div>
                                <div class="col-6 mb-1"><span class="text-muted">Phone:</span> <a href="tel:${escapeHtml(d.phone || '')}">${escapeHtml(d.phone || '-')}</a></div>
                                <div class="col-6 mb-1"><span class="text-muted">Floor:</span> ${escapeHtml('Floor ' + d.floor)}</div>
                                <div class="col-6 mb-1"><span class="text-muted">Registered:</span> ${escapeHtml(formatDate(d.created_date))}</div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 text-sm"><i class="fas fa-users mr-1 text-muted"></i> Attendee List</h6>
                                <span class="badge badge-secondary">${attendees.length} PEOPLE</span>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered mb-0 text-sm">
                                    <thead><tr><th class="text-center" style="width:36px">#</th><th>Name</th><th class="text-right" style="width:80px">Age</th><th class="text-center" style="width:100px">Status</th><th class="text-center" style="width:90px">Seat</th></tr></thead>
                                    <tbody>${rows || '<tr><td colspan="5" class="text-center text-muted py-3">No attendees yet</td></tr>'}</tbody>
                                </table>
                            </div>`)
                    }
                })
            })

            /* Confirm/Cancel via modal: default hanya centang yang sudah berstatus sama */
            const statusAction = { id: null, status: null }

            const renderStatusAttendees = (attendees, status) => {
                const target = Number(status)

                if (!attendees.length) {
                    $('#statusAttendeeList').html('<div class="text-center text-muted py-3">No attendees yet</div>')
                    $('#statusCheckAll').prop('checked', false).prop('disabled', true)
                    return
                }

                let allChecked = true
                const html = attendees.map((a) => {
                    const same = Number(a.status) === target
                    if (!same) allChecked = false
                    const doneLabel = target === 1 ? 'already confirmed' : 'already cancelled'
                    return `
                    <div class="custom-control custom-checkbox mb-1">
                        <input type="checkbox" class="custom-control-input status-att" id="stat-att-${escapeHtml(a.attendeeid)}" value="${escapeHtml(a.attendeeid)}"${same ? ' checked disabled' : ''}>
                        <label class="custom-control-label${same ? ' text-muted' : ''}" for="stat-att-${escapeHtml(a.attendeeid)}">
                            ${escapeHtml(upperName(a.name))} <span class="text-muted">(${escapeHtml(a.age)} yrs)</span>${same ? ` <span class="text-xs">(${doneLabel})</span>` : ''}
                        </label>
                    </div>`
                }).join('')
                $('#statusAttendeeList').html(html)
                $('#statusCheckAll').prop('disabled', false).prop('checked', allChecked)
            }

            const openStatusModal = (id, status) => {
                statusAction.id = id
                statusAction.status = Number(status)
                const isConfirm = statusAction.status === 1

                $('#modalStatusTitle').html(isConfirm
                    ? '<i class="fas fa-check-circle mr-1"></i> Confirm Registration'
                    : '<i class="fas fa-ban mr-1"></i> Cancel Registration')
                $('#btnStatusSubmit')
                    .removeClass('btn-success btn-danger')
                    .addClass(isConfirm ? 'btn-success' : 'btn-danger')
                    .html(isConfirm
                        ? '<i class="fas fa-check mr-1"></i> Confirm'
                        : '<i class="fas fa-ban mr-1"></i> Cancel')
                $('#statusAttendeeList').html('<div class="text-center text-muted py-3">Loading...</div>')
                $('#statusCheckAll').prop('checked', false).prop('disabled', true)
                $('#modalStatus').modal('show')

                $.ajax({
                    url: endpoints.detail,
                    type: 'GET',
                    dataType: 'json',
                    data: { id: id },
                    success: function (res) {
                        if (!res.success) {
                            $('#statusAttendeeList').html('<div class="alert alert-warning mb-0 py-2 text-sm"><i class="fas fa-exclamation-triangle mr-1"></i> Data not found.</div>')
                            return
                        }
                        renderStatusAttendees(res.data.attendees || [], statusAction.status)
                    },
                    error: function () {
                        $('#statusAttendeeList').html('<div class="alert alert-danger mb-0 py-2 text-sm">Failed to load attendees.</div>')
                    }
                })
            }

            $('#statusCheckAll').on('change', function () {
                const checked = $(this).is(':checked')
                $('.status-att:not(:disabled)').prop('checked', checked)
            })

            $('#btnStatusSubmit').on('click', function () {
                const selected = $('.status-att:checked').map(function () { return $(this).val() }).get()

                if (!selected.length) {
                    Swal.fire('Warning', 'Select at least one attendee.', 'warning')
                    return
                }

                $.ajax({
                    url: endpoints.status,
                    type: 'POST',
                    dataType: 'json',
                    data: { id: statusAction.id, status: statusAction.status, attendees: selected },
                    beforeSend: function () {
                        $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' });
                    },
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire('Error', response.message || 'Failed to update status', 'error')
                            return
                        }
                        $('#modalStatus').modal('hide')
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

            $(document).on('click', '.btn-confirm', function () {
                openStatusModal($(this).data('id'), 1)
            })

            $(document).on('click', '.btn-cancel', function () {
                openStatusModal($(this).data('id'), 2)
            })

            /* Individual: confirm/cancel/delete hanya untuk 1 orang */
            const personStatus = (attendeeid, registrationid, status) => {
                const isConfirm = Number(status) === 1
                Swal.fire({
                    title: isConfirm ? 'Confirm this attendee?' : 'Cancel this attendee?',
                    text: isConfirm
                        ? 'Only this person will be marked as confirmed.'
                        : 'Only this person will be marked as cancelled.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then(function (res) {
                    if (!res.isConfirmed) return

                    $.ajax({
                        url: endpoints.status,
                        type: 'POST',
                        dataType: 'json',
                        data: { id: registrationid, status: status, attendees: [attendeeid] },
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

            $(document).on('click', '.btn-person-confirm', function () {
                if (Number($(this).data('status')) === 1) {
                    Swal.fire('Already confirmed', 'This attendee is already confirmed.', 'info')
                    return
                }
                personStatus($(this).data('att'), $(this).data('reg'), 1)
            })

            $(document).on('click', '.btn-person-cancel', function () {
                if (Number($(this).data('status')) === 2) {
                    Swal.fire('Already cancelled', 'This attendee is already cancelled.', 'info')
                    return
                }
                personStatus($(this).data('att'), $(this).data('reg'), 2)
            })

            $(document).on('click', '.btn-person-delete', function () {
                const attendeeid = $(this).data('att')
                const name = $(this).data('name')

                Swal.fire({
                    title: 'Delete this attendee?',
                    text: (name ? upperName(name) + ' will be removed from the registration.' : 'Only this person will be removed from the registration.'),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Delete'
                }).then(function (res) {
                    if (!res.isConfirmed) return

                    $.ajax({
                        url: endpoints.deleteAttendee,
                        type: 'POST',
                        dataType: 'json',
                        data: { id: attendeeid },
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

            /* Delete */
            $(document).on('click', '.btn-delete', function () {
                const id = $(this).data('id')

                Swal.fire({
                    title: 'Delete this registration?',
                    text: 'All attendees in this registration will also be deleted.',
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

            /* Simpan kuota */
            $('#btnSaveCap').on('click', function () {
                const cap1 = $('#capFloor1').val()
                const cap2 = $('#capFloor2').val()

                if (cap1 === '' || cap2 === '' || Number(cap1) < 0 || Number(cap2) < 0) {
                    Swal.fire('Warning', 'Fill both floor quotas with a number >= 0.', 'warning')
                    return
                }

                Swal.fire({
                    title: 'Save floor quota?',
                    text: `Floor 1 = ${Number(cap1)}, Floor 2 = ${Number(cap2)}`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, save'
                }).then(function (res) {
                    if (!res.isConfirmed) return

                    $.ajax({
                        url: endpoints.capacity,
                        type: 'POST',
                        dataType: 'json',
                        data: { capacity1: cap1, capacity2: cap2 },
                        beforeSend: function () {
                            $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' });
                        },
                        success: function (response) {
                            if (!response.success) {
                                Swal.fire('Error', response.message || 'Failed to save quota', 'error')
                                loadStats()
                                return
                            }
                            Swal.fire('Success', response.message || 'Quota saved', 'success')
                            $('#modalKuota').modal('hide')
                            loadStats()
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

            renderHead()
            refresh()
        })
    </script>
</body>

</html>