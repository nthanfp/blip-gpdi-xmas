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

<body class="<?php $this->load->view('partial/activities/body-class'); ?>">
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
                                placeholder="Username, menu, action, IP..." autocomplete="off">
                        </div>
                        <div class="col-6 col-md-4 mb-2">
                            <label class="mb-0">Admin</label>
                            <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                id="filterAdminId">
                                <option value="">-- ALL --</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 mb-2">
                            <label class="mb-0">Menu</label>
                            <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                id="filterMenuId">
                                <option value="">-- ALL --</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 mb-2">
                            <label class="mb-0">Action</label>
                            <select class="form-control form-control-sm" id="filterAction">
                                <option value="">-- ALL --</option>
                                <option value="VIEW">VIEW</option>
                                <option value="NEW">NEW</option>
                                <option value="EDIT">EDIT</option>
                                <option value="SUSPEND">SUSPEND</option>
                                <option value="DELETE">DELETE</option>
                                <option value="PRINT">PRINT</option>
                                <option value="EXPORT">EXPORT</option>
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
                        <div class="col-12 col-md-7 mb-2">
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
                                <th class="d-none">ID</th>
                                <th class="d-none text-nowrap sort-header" data-sort="act_log_adminid" role="button">Log
                                    ID
                                    <span class="sort-indicator" data-sort-indicator="act_log_adminid"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="d-none text-nowrap sort-header" data-sort="mst_adminid" role="button">Admin
                                    ID
                                    <span class="sort-indicator" data-sort-indicator="mst_adminid"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="created_date" role="button">Created Date
                                    <span class="sort-indicator" data-sort-indicator="created_date"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="username" role="button">Username
                                    <span class="sort-indicator" data-sort-indicator="username"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="d-none text-nowrap sort-header" data-sort="set_menuid" role="button">Menu ID
                                    <span class="sort-indicator" data-sort-indicator="set_menuid"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="menu_name" role="button">Menu Name
                                    <span class="sort-indicator" data-sort-indicator="menu_name"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="action" role="button">Action
                                    <span class="sort-indicator" data-sort-indicator="action"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="action" role="button">Description
                                    <span class="sort-indicator" data-sort-indicator="action"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="ip_address" role="button">IP Address
                                    <span class="sort-indicator" data-sort-indicator="ip_address"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header d-none" data-sort="mac" role="button">Mac Address
                                    <span class="sort-indicator" data-sort-indicator="mac"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tableBodyLogAdmin">
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
                list: '<?= site_url("activities/logAdmin/data_list") ?>',
                adminOptions: '<?= site_url("activities/logAdmin/data_option_admin") ?>',
                menuOptions: '<?= site_url("activities/logAdmin/data_option_menu") ?>'
            }

            const state = {
                page: 1,
                perPage: 10,
                search: '',
                mst_adminid: '',
                set_menuid: '',
                action: '',
                sort_by: 'created_date',
                sort_dir: 'DESC'
            }

            const tableBody = $('#tableBodyLogAdmin')
            const pagination = $('#pagination')
            const tableInfo = $('#tableInfo')
            const filterAdminId = $('#filterAdminId')
            const filterMenuId = $('#filterMenuId')

            const optionState = {
                adminLoaded: false,
                menuLoaded: false
            }

            const escapeHtml = (value) => $('<div>').text(value == null ? '' : String(value)).html()

            const buildPrintQuery = () => {
                const params = []

                if (state.search !== '') params.push(`search=${encodeURIComponent(state.search)}`)
                if (state.mst_adminid !== '') params.push(`mst_adminid=${encodeURIComponent(state.mst_adminid)}`)
                if (state.set_menuid !== '') params.push(`set_menuid=${encodeURIComponent(state.set_menuid)}`)
                if (state.action !== '') params.push(`action=${encodeURIComponent(state.action)}`)
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

                const html = rows.map((row) => `
                    <tr>
                        <td class="d-none">${escapeHtml(row.act_log_adminid)}</td>
                        <td class="d-none text-nowrap">${escapeHtml(row.act_log_adminid)}</td>
                        <td class="d-none text-nowrap">${escapeHtml(row.mst_adminid)}</td>
                        <td class="text-nowrap">${escapeHtml(formatDate(row.created_date) || '-')}</td>
                        <td class="text-nowrap">${escapeHtml(row.username || '-')}</td>
                        <td class="d-none text-nowrap">${escapeHtml(row.set_menuid)}</td>
                        <td class="text-nowrap">${escapeHtml(row.menu_name || '-')}</td>
                        <td class="text-nowrap">${escapeHtml(row.action || '-')}</td>
                        <td class="text-nowrap text-muted">${escapeHtml(row.description || '-')}</td>
                        <td class="text-nowrap">${escapeHtml(row.ip_address || '-')}</td>
                        <td class="text-nowrap d-none">${escapeHtml(row.mac || '-')}</td>
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
                        mst_adminid: state.mst_adminid,
                        set_menuid: state.set_menuid,
                        action: state.action,
                        sort_by: state.sort_by,
                        sort_dir: state.sort_dir
                    },
                    beforeSend: function () {
                        $('input, select, textarea, button').prop('disabled', true);
                        $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' });
                    },
                    success: function (res) {
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

            const loadAdminOptions = () => {
                return $.ajax({
                    url: endpoints.adminOptions,
                    type: 'GET',
                    dataType: 'json'
                }).then(function (res) {
                    if (!res.success) return

                    filterAdminId.empty().append('<option value="">-- ALL --</option>')
                        ; (res.data || []).forEach(function (row) {
                            const id = String(row.mst_adminid)
                            const label = row.display_name || row.username || id
                            filterAdminId.append(`<option value="${escapeHtml(id)}">${escapeHtml(label)}</option>`)
                        })

                    filterAdminId.selectpicker('refresh')
                    optionState.adminLoaded = true
                })
            }

            const loadMenuOptions = () => {
                return $.ajax({
                    url: endpoints.menuOptions,
                    type: 'GET',
                    dataType: 'json'
                }).then(function (res) {
                    if (!res.success) return

                    let html = '<option value="">-- ALL --</option>'

                        ; (res.data || []).forEach(function (item) {
                            if (item.children && item.children.length) {
                                const groupLabel = item.display_name || item.name || item.label || String(item.set_menuid)
                                html += `<optgroup label="${escapeHtml(groupLabel)}">`

                                item.children.forEach(function (child) {
                                    const childId = String(child.set_menuid)
                                    const childLabel = child.display_name || child.name || childId
                                    html += `<option value="${escapeHtml(childId)}">${escapeHtml(childLabel)}</option>`
                                })

                                html += '</optgroup>'
                                return
                            }

                            const id = String(item.set_menuid)
                            const label = item.display_name || item.name || id
                            html += `<option value="${escapeHtml(id)}">${escapeHtml(label)}</option>`
                        })

                    filterMenuId.html(html)
                    filterMenuId.selectpicker('refresh')
                    optionState.menuLoaded = true
                })
            }

            $('#btnApply').on('click', function () {
                state.page = 1
                state.search = $('#search').val().trim()
                state.mst_adminid = filterAdminId.val()
                state.set_menuid = filterMenuId.val()
                state.action = $('#filterAction').val()
                state.perPage = parseInt($('#perPage').val(), 10) || 10
                loadData()
            })

            $('#btnReset').on('click', function () {
                $('#search').val('')
                filterAdminId.selectpicker('val', '')
                filterMenuId.selectpicker('val', '')
                $('#filterAction').val('')
                $('#perPage').val('10')
                state.page = 1
                state.perPage = 10
                state.search = ''
                state.mst_adminid = ''
                state.set_menuid = ''
                state.action = ''
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
                const url = '<?= site_url("activities/logAdmin/data_print") ?>' + (query ? `?${query}` : '')
                openReportUrl(url)
            })

            $('#btnExport').on('click', function () {
                const query = buildPrintQuery()
                const timestamp = getTimestamp()
                const filename = `log_admin_${timestamp}`
                const url = '<?= site_url("activities/logAdmin/data_printhtml") ?>/' + filename + '/1' + (query ? `?${query}` : '')
                openReportUrl(url)
            })

            loadAdminOptions().always(function () {
                loadMenuOptions().always(function () {
                    loadData()
                })
            })
        })
    </script>
</body>

</html>