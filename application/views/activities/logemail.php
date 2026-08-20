<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('partial/activities/head.php') ?>
</head>

<body class="sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">
        <?php $this->load->view('partial/activities/sidebar.php') ?>

        <div class="content-wrapper py-4 px-4 text-sm">
            <div class="row mb-2">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        <button type="button" class="btn btn-sm btn-danger mr-1" id="btnPrint">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button type="button" class="btn btn-sm btn-success" id="btnExport">
                            <i class="fas fa-file-export"></i> Export
                        </button>
                    </div>
                    <div class="text-muted font-italic">
                    </div>
                </div>
            </div>

            <div class="card card-outline card-secondary mb-0">
                <div class="card-body py-2 px-2 border-bottom">
                    <div class="row">
                        <div class="col-12 col-md-4 mb-2">
                            <label class="mb-0">Search</label>
                            <input type="text" class="form-control form-control-sm" id="search"
                                placeholder="Recipient, subject, error, redeem ID..." autocomplete="off">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="mb-0">Email Type</label>
                            <select class="form-control form-control-sm" id="filterEmailType">
                                <option value="">-- ALL --</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <label class="mb-0">Status</label>
                            <select class="form-control form-control-sm" id="filterStatus">
                                <option value="">-- ALL --</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2 mb-2">
                            <label class="mb-0">Show</label>
                            <select class="form-control form-control-sm" id="perPage">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-12 mb-2">
                            <label class="mb-0 d-none">&nbsp;</label>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn px-3 mr-1 btn-sm btn-secondary" id="btnReset">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                                <button type="button" class="btn px-3 btn-sm btn-primary" id="btnApply">
                                    <i class="fas fa-check mr-1"></i> Apply
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-striped mb-0">
                        <thead>
                            <tr>
                                <th class="d-none text-nowrap sort-header" data-sort="act_email_logid" role="button">Log ID
                                    <span class="sort-indicator" data-sort-indicator="act_email_logid"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="created_at" role="button">Created Date
                                    <span class="sort-indicator" data-sort-indicator="created_at"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="email_type" role="button">Type
                                    <span class="sort-indicator" data-sort-indicator="email_type"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="recipient_email" role="button">Recipient
                                    <span class="sort-indicator" data-sort-indicator="recipient_email"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="subject" role="button">Subject
                                    <span class="sort-indicator" data-sort-indicator="subject"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="status" role="button">Status
                                    <span class="sort-indicator" data-sort-indicator="status"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap">Error Message</th>
                                <th class="text-nowrap sort-header" data-sort="related_redeemid" role="button">Redeem ID
                                    <span class="sort-indicator" data-sort-indicator="related_redeemid"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tableBodyEmailLog">
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer px-2 py-2">
                    <div class="row align-items-center text-center text-md-left">
                        <div class="col-md-6 mb-2 mb-md-0">
                            <div class="dataTables_info font-italic" id="tableInfo">No data</div>
                        </div>
                        <div class="col-12 col-md-6">
                            <nav>
                                <ul class="pagination pagination-sm justify-content-center justify-content-md-end mb-0 flex-wrap"
                                    id="pagination"></ul>
                            </nav>
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
            const endpoints = {
                list: '<?= site_url("activities/logemail/data_list") ?>',
                typeOptions: '<?= site_url("activities/logemail/data_option_type") ?>',
                statusOptions: '<?= site_url("activities/logemail/data_option_status") ?>'
            }

            const state = {
                page: 1,
                perPage: 10,
                search: '',
                emailType: '',
                status: '',
                sort_by: 'created_at',
                sort_dir: 'DESC'
            }

            const tableBody = $('#tableBodyEmailLog')
            const pagination = $('#pagination')
            const tableInfo = $('#tableInfo')
            const filterEmailType = $('#filterEmailType')
            const filterStatus = $('#filterStatus')

            const escapeHtml = (value) => $('<div>').text(value == null ? '' : String(value)).html()

            const normalizeTypeLabel = (value) => {
                return String(value || '').toUpperCase().replace(/_/g, ' ')
            }

            const normalizeStatusLabel = (value) => {
                return String(value || '').toUpperCase()
            }

            const buildPrintQuery = () => {
                const params = []
                if (state.search !== '') params.push(`search=${encodeURIComponent(state.search)}`)
                if (state.emailType !== '') params.push(`email_type=${encodeURIComponent(state.emailType)}`)
                if (state.status !== '') params.push(`status=${encodeURIComponent(state.status)}`)
                if (state.sort_by !== '') params.push(`sort_by=${encodeURIComponent(state.sort_by)}`)
                if (state.sort_dir !== '') params.push(`sort_dir=${encodeURIComponent(state.sort_dir)}`)
                return params.join('&')
            }

            const openReportUrl = (url) => {
                window.open(url, '_blank', 'noopener,noreferrer')
            }

            const getTimestamp = () => {
                const d = new Date()
                const pad = (n) => String(n).padStart(2, '0')
                return `${pad(d.getDate())}-${pad(d.getMonth() + 1)}-${d.getFullYear()}_${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}`
            }

            const updateSortIndicators = () => {
                $('.sort-indicator').each(function () {
                    const key = $(this).data('sort-indicator')
                    if (state.sort_by !== key) {
                        $(this).html('<i class="fas fa-sort text-secondary"></i>')
                        return
                    }
                    $(this).html(state.sort_dir === 'ASC'
                        ? ' <i class="fas fa-sort-up"></i>'
                        : ' <i class="fas fa-sort-down"></i>')
                })
            }

            const renderRows = (rows) => {
                if (!rows || !rows.length) {
                    tableBody.html('<tr><td colspan="8" class="text-center text-muted py-4">No data found</td></tr>')
                    return
                }

                const html = rows.map((row) => {
                    const statusLabel = normalizeStatusLabel(row.status)
                    const statusClass = row.status === 'sent' ? 'success' : 'danger'
                    return `<tr>
                        <td class="d-none text-nowrap">${escapeHtml(row.act_email_logid)}</td>
                        <td class="text-nowrap">${escapeHtml(formatDate(row.created_at) || '-')}</td>
                        <td class="text-nowrap">${escapeHtml(normalizeTypeLabel(row.email_type) || '-')}</td>
                        <td class="text-nowrap">${escapeHtml(row.recipient_email || '-')}</td>
                        <td class="text-nowrap">${escapeHtml(row.subject || '-')}</td>
                        <td class="text-nowrap"><span class="badge badge-${statusClass}">${statusLabel}</span></td>
                        <td class="text-nowrap text-muted">${escapeHtml(row.error_message || '-')}</td>
                        <td class="text-nowrap">${escapeHtml(row.related_redeemid || '-')}</td>
                    </tr>`
                }).join('')

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
                items.push(`<li class="page-item ${hasPrev ? '' : 'disabled'}"><a class="page-link" href="#" data-page="1">First</a></li>`)
                items.push(`<li class="page-item ${hasPrev ? '' : 'disabled'}"><a class="page-link" href="#" data-page="${Math.max(1, currentPage - 1)}">Prev</a></li>`)

                const start = Math.max(1, currentPage - 2)
                const end = Math.min(totalPages, currentPage + 2)

                if (start > 1) items.push('<li class="page-item disabled"><span class="page-link">...</span></li>')
                for (let i = start; i <= end; i++) {
                    items.push(`<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`)
                }
                if (end < totalPages) items.push('<li class="page-item disabled"><span class="page-link">...</span></li>')

                items.push(`<li class="page-item ${hasNext ? '' : 'disabled'}"><a class="page-link" href="#" data-page="${Math.min(totalPages, currentPage + 1)}">Next</a></li>`)
                items.push(`<li class="page-item ${hasNext ? '' : 'disabled'}"><a class="page-link" href="#" data-page="${totalPages}">Last</a></li>`)

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
                        email_type: state.emailType,
                        status: state.status,
                        sort_by: state.sort_by,
                        sort_dir: state.sort_dir
                    },
                    beforeSend: function () {
                        $('input, select, textarea, button').prop('disabled', true);
                        $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' });
                    },
                    success: function (res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load email log data', 'error')
                            return
                        }

                        renderRows(res.data || [])
                        renderPagination(res.pagination || {})
                        updateSortIndicators()

                        const total = Number((res.pagination && res.pagination.total) || 0)
                        const page = Number((res.pagination && res.pagination.page) || 1)
                        const perPage = Number((res.pagination && res.pagination.per_page) || state.perPage)
                        const start = total === 0 ? 0 : ((page - 1) * perPage) + 1
                        const end = Math.min(total, page * perPage)

                        tableInfo.text(total === 0
                            ? 'Showing 0 to 0 of 0 entries'
                            : `Showing ${start} to ${end} of ${total.toLocaleString('en-US')} entries`)
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
            }

            const loadTypeOptions = () => {
                return $.ajax({
                    url: endpoints.typeOptions,
                    type: 'GET',
                    dataType: 'json'
                }).then(function (res) {
                    if (!res.success) return
                    filterEmailType.empty().append('<option value="">-- ALL --</option>');
                    (res.data || []).forEach(function (row) {
                        filterEmailType.append(`<option value="${escapeHtml(row.email_type)}">${escapeHtml(normalizeTypeLabel(row.email_type))}</option>`)
                    })
                })
            }

            const loadStatusOptions = () => {
                return $.ajax({
                    url: endpoints.statusOptions,
                    type: 'GET',
                    dataType: 'json'
                }).then(function (res) {
                    if (!res.success) return
                    filterStatus.empty().append('<option value="">-- ALL --</option>');
                    (res.data || []).forEach(function (row) {
                        filterStatus.append(`<option value="${escapeHtml(row.status)}">${escapeHtml(normalizeStatusLabel(row.status))}</option>`)
                    })
                })
            }

            $('#btnApply').on('click', function () {
                state.page = 1
                state.search = $('#search').val().trim()
                state.emailType = filterEmailType.val()
                state.status = filterStatus.val()
                state.perPage = parseInt($('#perPage').val(), 10) || 10
                loadData()
            })

            $('#btnReset').on('click', function () {
                $('#search').val('')
                filterEmailType.val('')
                filterStatus.val('')
                $('#perPage').val('10')
                state.page = 1
                state.perPage = 10
                state.search = ''
                state.emailType = ''
                state.status = ''
                loadData()
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

            $(document).on('click', '.sort-header', function () {
                const sortKey = $(this).data('sort')
                if (!sortKey) return

                if (state.sort_by === sortKey) {
                    state.sort_dir = state.sort_dir === 'ASC' ? 'DESC' : 'ASC'
                } else {
                    state.sort_by = sortKey
                    state.sort_dir = 'ASC'
                }

                state.page = 1
                loadData()
            })

            $('#btnPrint').on('click', function () {
                const query = buildPrintQuery()
                const url = '<?= site_url("activities/logemail/data_print") ?>' + (query ? `?${query}` : '')
                openReportUrl(url)
            })

            $('#btnExport').on('click', function () {
                const query = buildPrintQuery()
                const timestamp = getTimestamp()
                const filename = `log_email_${timestamp}`
                const url = '<?= site_url("activities/logemail/data_printhtml") ?>/' + filename + '/1' + (query ? `?${query}` : '')
                openReportUrl(url)
            })

            loadTypeOptions().always(function () {
                loadStatusOptions().always(function () {
                    loadData()
                })
            })
        })
    </script>
</body>

</html>