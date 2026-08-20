<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('partial/activities/head.php') ?>
    <style>
        .bootstrap-select .dropdown-menu.inner .dropdown-header {
            padding: .35rem .75rem;
            font-size: .85rem;
            font-weight: 600;
            color: #495057;
            background: #f8f9fa;
            white-space: nowrap;
            text-align: left;
        }

        .bootstrap-select .dropdown-menu.inner .dropdown-divider {
            margin: .25rem 0;
        }

        .bootstrap-select .dropdown-menu.inner .dropdown-item.opt {
            padding-left: 1.5rem;
        }
    </style>
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
                        <div class="col-md-4 mb-2">
                            <label class="mb-0">Keyword</label>
                            <input type="text" id="filterSearch" class="form-control form-control-sm" placeholder="Search IP, endpoint, message...">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="mb-0">Endpoint</label>
                            <select id="filterEndpoint" class="form-control form-control-sm selectpicker" data-live-search="true">
                                <option value="">-- All --</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="mb-0">Key Name</label>
                            <select id="filterApiKey" class="form-control form-control-sm selectpicker" data-live-search="true">
                                <option value="">-- All --</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="mb-0">HTTP Status</label>
                            <select id="filterHttpStatus" class="form-control form-control-sm selectpicker" data-live-search="true">
                                <option value="">-- All --</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="mb-0">Status</label>
                            <select id="filterSuccess" class="form-control form-control-sm selectpicker" data-live-search="true">
                                <option value="">-- All --</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <label class="mb-0">Show</label>
                            <select id="perPage" class="form-control form-control-sm">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="mb-0 d-none d-md-block">&nbsp;</label>
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
                                <th class="d-none text-nowrap sort-header" data-sort="act_api_logid" role="button">
                                    Log ID <span class="sort-indicator" data-sort-indicator="act_api_logid"><i class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="created_date" role="button">
                                    Created Date <span class="sort-indicator" data-sort-indicator="created_date"><i class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="method" role="button">
                                    Method <span class="sort-indicator" data-sort-indicator="method"><i class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="http_status" role="button">
                                    HTTP Status <span class="sort-indicator" data-sort-indicator="http_status"><i class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="endpoint" role="button">
                                    Endpoint <span class="sort-indicator" data-sort-indicator="endpoint"><i class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="ip_address" role="button">
                                    IP Address <span class="sort-indicator" data-sort-indicator="ip_address"><i class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="exection_time" role="button">
                                    Exec Time <span class="sort-indicator" data-sort-indicator="exection_time"><i class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBodyLogApi">
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Loading...</td>
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

        <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header py-2">
                        <h6 class="modal-title" id="modalDetailLabel">API Log Detail</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-sm">
                        <div class="row mb-3">
                            <div class="mb-3 col-md-6">
                                <strong>Key Name</strong>
                                <div id="detailKeyName">-</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <strong>Created Date</strong>
                                <div id="detailCreated">-</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <strong>Status</strong>
                                <div id="detailStatus">-</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <strong>Endpoint</strong>
                                <div id="detailEndpoint">-</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <strong>Method</strong>
                                <div id="detailMethod">-</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <strong>HTTP Status</strong>
                                <div id="detailHttpStatus">-</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <strong>IP Address</strong>
                                <div id="detailIp">-</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <strong>Exec Time</strong>
                                <div id="detailExec">-</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <strong>User Agent</strong>
                                <div id="detailUseragent">-</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <strong>Query String</strong>
                                <pre class="bg-light p-2 rounded mb-0" id="detailQuery" style="max-height:150px;overflow:auto;white-space:pre-wrap;word-break:break-all;"></pre>
                            </div>
                            <div class="mb-3 col-md-12">
                                <strong>Request Body</strong>
                                <pre class="bg-light p-2 rounded mb-0" id="detailRequest" style="max-height:200px;overflow:auto;white-space:pre-wrap;word-break:break-all;"></pre>
                            </div>
                            <div class="mb-3 col-md-12">
                                <strong>Response Message</strong>
                                <pre class="bg-light p-2 rounded mb-0" id="detailResponse" style="max-height:200px;overflow:auto;white-space:pre-wrap;word-break:break-all;"></pre>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
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
                list: '<?= site_url("activities/logApi/data_list") ?>',
                endpointSuccess: '<?= site_url("activities/logApi/data_option_success") ?>',
                endpointOptions: '<?= site_url("activities/logApi/data_option_endpoint") ?>',
                endpointHttpStatus: '<?= site_url("activities/logApi/data_option_http_status") ?>',
                endpointApiKey: '<?= site_url("activities/logApi/data_option_api_key") ?>',
            }

            const state = {
                page: 1,
                perPage: 10,
                search: '',
                endpoint: '',
                http_status: '',
                is_success: '',
                set_api_keyid: '',
                sort_by: 'created_date',
                sort_dir: 'DESC'
            }

            const tableBody = $('#tableBodyLogApi')
            const pagination = $('#pagination')
            const tableInfo = $('#tableInfo')
            const filterEndpoint = $('#filterEndpoint')
            const filterHttpStatus = $('#filterHttpStatus')
            const filterSuccess = $('#filterSuccess')
            const filterApiKey = $('#filterApiKey')

            const escapeHtml = (value) => $('<div>').text(value == null ? '' : String(value)).html()

            const escapeAttr = (value) => {
                if (value == null) return ''
                return String(value)
                    .replace(/&/g, '&amp;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#39;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
            }

            const tryParseJson = (str) => {
                if (str == null) return ''
                if (typeof str === 'object') {
                    try {
                        return JSON.stringify(str, null, 2)
                    } catch (e) {
                        return ''
                    }
                }
                str = String(str)
                if (str.trim() === '') return ''
                try {
                    return JSON.stringify(JSON.parse(str), null, 2)
                } catch (e) {
                    return str
                }
            }

            const buildPrintQuery = () => {
                const params = []

                if (state.search !== '') params.push(`search=${encodeURIComponent(state.search)}`)
                if (state.endpoint !== '') params.push(`endpoint=${encodeURIComponent(state.endpoint)}`)
                if (state.http_status !== '') params.push(`http_status=${encodeURIComponent(state.http_status)}`)
                if (state.is_success !== '') params.push(`is_success=${encodeURIComponent(state.is_success)}`)
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
                $('.sort-indicator').each(function() {
                    const key = $(this).data('sort-indicator')
                    if (state.sort_by !== key) {
                        $(this).html('<i class="fas fa-sort text-secondary"></i>')
                        return
                    }

                    $(this).html(state.sort_dir === 'ASC' ?
                        ' <i class="fas fa-sort-up"></i>' :
                        ' <i class="fas fa-sort-down"></i>')
                })
            }

            const renderRows = (rows) => {
                if (!rows || !rows.length) {
                    tableBody.html('<tr><td colspan="8" class="text-center text-muted py-4">No data found</td></tr>')
                    return
                }

                const html = rows.map((row) => `
                    <tr>
                        <td class="d-none text-nowrap">${escapeHtml(row.act_api_logid)}</td>
                        <td class="text-nowrap">${escapeHtml(formatDate(row.created_date) || '-')}</td>
                        <td class="text-nowrap">${escapeHtml(row.request_method || '-')}</td>
                        <td class="text-nowrap">${escapeHtml(row.http_status)}</td>
                        <td class="text-nowrap">${escapeHtml(row.endpoint || '-')}</td>
                        <td class="text-nowrap">${escapeHtml(row.ip_address || '-')}</td>
                        <td class="text-nowrap">${row.execution_time != null ? (Number(row.execution_time) / 1000).toFixed(4) + ' s' : '-'}</td>
                        <td class="text-nowrap">
                            <button type="button" class="btn btn-xs btn-info btn-detail"
                                data-id="${escapeAttr(row.act_api_logid)}"
                                data-method="${escapeAttr(row.request_method)}"
                                data-endpoint="${escapeAttr(row.endpoint)}"
                                data-http="${escapeAttr(row.http_status)}"
                                data-ip="${escapeAttr(row.ip_address)}"
                                data-exec="${escapeAttr(row.execution_time != null ? (Number(row.execution_time) / 1000).toFixed(4) + ' s' : '-')}"
                                data-created="${escapeAttr(formatDate(row.created_date))}"
                                data-status="${escapeAttr(row.is_success)}"
                                data-request_body="${escapeAttr(row.request_body)}"
                                data-query_string="${escapeAttr(row.query_string)}"
                                data-response_message="${escapeAttr(row.response_message)}"
                                data-useragent="${escapeAttr(row.useragent)}"
                                data-mac="${escapeAttr(row.mac_address)}"
                                data-keyname="${escapeAttr(row.key_name)}"
                                title="Detail">
                                <i class="fas fa-eye"></i>
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
                        endpoint: state.endpoint,
                        http_status: state.http_status,
                        is_success: state.is_success,
                        set_api_keyid: state.set_api_keyid,
                        sort_by: state.sort_by,
                        sort_dir: state.sort_dir
                    },
                    beforeSend: function() {
                        $('input, select, textarea, button').prop('disabled', true);
                        $.LoadingOverlay('show', {
                            background: 'rgba(0, 0, 0, 0.25)'
                        });
                    },
                    success: function(res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load log data', 'error')
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

                        tableInfo.text(total === 0 ?
                            'Showing 0 to 0 of 0 entries' :
                            `Showing ${start} to ${end} of ${total.toLocaleString('en-US')} entries`)
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

            const loadEndpointOptions = () => {
                return $.ajax({
                    url: endpoints.endpointOptions,
                    type: 'GET',
                    dataType: 'json'
                }).then(function(res) {
                    if (!res.success) return

                    filterEndpoint.empty().append('<option value="">-- ALL --</option>');
                    (res.data || []).forEach(function(row) {
                        const label = row.endpoint || ''
                        filterEndpoint.append(`<option value="${escapeHtml(label)}">${escapeHtml(label)}</option>`)
                    })

                    filterEndpoint.selectpicker('refresh')
                    filterEndpoint.selectpicker('val', '')
                })
            }

            const loadHttpStatus = () => {
                return $.ajax({
                    url: endpoints.endpointHttpStatus,
                    type: 'GET',
                    dataType: 'json'
                }).then(function(res) {
                    if (!res.success) return

                    filterHttpStatus.empty().append('<option value="">-- ALL --</option>');
                    (res.data || []).forEach(function(row) {
                        const label = row.http_status || ''
                        filterHttpStatus.append(`<option value="${escapeHtml(label)}">${escapeHtml(label)}</option>`)
                    })

                    filterHttpStatus.selectpicker('refresh')
                    filterHttpStatus.selectpicker('val', '')
                })
            }

            const loadSuccess = () => {
                return $.ajax({
                    url: endpoints.endpointSuccess,
                    type: 'GET',
                    dataType: 'json'
                }).then(function(res) {
                    if (!res.success) return

                    filterSuccess.empty().append('<option value="">-- ALL --</option>');
                    (res.data || []).forEach(function(row) {
                        const label = row.label || ''
                        filterSuccess.append(`<option value="${escapeHtml(row.is_success)}">${escapeHtml(label)}</option>`)
                    })

                    filterSuccess.selectpicker('refresh')
                    filterSuccess.selectpicker('val', '')
                })
            }

            const loadApiKeyOptions = () => {
                return $.ajax({
                    url: endpoints.endpointApiKey,
                    type: 'GET',
                    dataType: 'json'
                }).then(function(res) {
                    if (!res.success) return

                    filterApiKey.empty().append('<option value="">-- ALL --</option>');
                    (res.data || []).forEach(function(row) {
                        filterApiKey.append(`<option value="${escapeAttr(row.set_api_keyid)}">${escapeHtml(row.key_name)}</option>`)
                    })

                    filterApiKey.selectpicker('refresh')
                    filterApiKey.selectpicker('val', '')
                })
            }

            $('#btnApply').on('click', function() {
                state.page = 1
                state.search = $('#filterSearch').val()
                state.endpoint = filterEndpoint.val()
                state.http_status = filterHttpStatus.val()
                state.is_success = filterSuccess.val()
                state.set_api_keyid = filterApiKey.val()
                state.perPage = parseInt($('#perPage').val(), 10) || 10
                loadData()
            })

            $('#btnReset').on('click', function() {
                $('#filterSearch').val('')
                filterEndpoint.selectpicker('val', '')
                filterHttpStatus.selectpicker('val', '')
                filterSuccess.selectpicker('val', '')
                filterApiKey.selectpicker('val', '')
                $('#perPage').val('10')
                state.page = 1
                state.perPage = 10
                state.search = ''
                state.endpoint = ''
                state.http_status = ''
                state.is_success = ''
                state.set_api_keyid = ''
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

            $(document).on('click', '.sort-header', function() {
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

            $('#btnPrint').on('click', function() {
                const query = buildPrintQuery()
                const url = '<?= site_url("activities/logApi/data_print") ?>' + (query ? `?${query}` : '')
                openReportUrl(url)
            })

            $('#btnExport').on('click', function() {
                const query = buildPrintQuery()
                const timestamp = getTimestamp()
                const filename = `log_api_${timestamp}`
                const url = '<?= site_url("activities/logApi/data_printhtml") ?>/' + filename + '/1' + (query ? `?${query}` : '')
                openReportUrl(url)
            })

            loadEndpointOptions().always(function() {
                loadHttpStatus().always(function() {
                    loadSuccess().always(function() {
                        loadApiKeyOptions().always(function() {
                            loadData();
                        })
                    })
                })
            })

            $(document).on('click', '.btn-detail', function() {
                const btn = $(this)
                $('#detailId').text(btn.data('id') || '-')
                $('#detailKeyName').text(btn.data('keyname') || '-')
                $('#detailCreated').text(btn.data('created') || '-')
                $('#detailMethod').text(btn.data('method') || '-')
                $('#detailHttpStatus').text(btn.data('http') || '-')
                const isSuccess = btn.data('status')
                const statusLabel = isSuccess === 't' || isSuccess === true ? 'Success' : 'Failed'
                const statusBadge = statusLabel === 'Success' ?
                    '<span class="badge badge-success">Success</span>' :
                    '<span class="badge badge-danger">Failed</span>'
                $('#detailStatus').html(statusBadge)
                $('#detailEndpoint').text(btn.data('endpoint') || '-')
                $('#detailIp').text(btn.data('ip') || '-')
                $('#detailExec').text(btn.data('exec') || '-')
                $('#detailUseragent').text(btn.data('useragent') || '-')
                $('#detailQuery').text(tryParseJson(btn.data('query_string')))
                $('#detailRequest').text(tryParseJson(btn.data('request_body')))
                $('#detailResponse').text(tryParseJson(btn.data('response_message')))
                $('#modalDetail').modal('show')
            })
        })
    </script>
</body>

</html>