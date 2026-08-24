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
                        <button type="button" class="btn btn-sm btn-danger mr-1" id="btnPrint">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button type="button" class="btn btn-sm btn-success" id="btnExport">
                            <i class="fas fa-file-export"></i> Export
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-secondary" id="btnAdd">
                            <i class="fas fa-plus"></i> New
                        </button>
                    </div>
                </div>
            </div>

            <div class="card card-outline card-secondary mb-0">
                <div class="card-body py-2 px-2 border-bottom">
                    <div class="row">
                        <div class="col-12 col-md-4 mb-2">
                            <label class="mb-0">Search</label>
                            <input type="text" class="form-control form-control-sm" id="search"
                                placeholder="Username..." autocomplete="off">
                        </div>
                        <div class="col-6 col-md-4 mb-2">
                            <label class="mb-0">Suspended</label>
                            <select class="form-control form-control-sm" id="filterSuspended">
                                <option value="">-- ALL --</option>
                                <option value="0" selected>NO</option>
                                <option value="1">YES</option>
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
                            <label class="mb-0 d-none d-md-block">&nbsp;</label>
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
                    <table class="table table-sm table-striped mb-0 ">
                        <thead>
                            <tr>
                                <th class="d-none">ID</th>
                                <th class="text-nowrap sort-header" data-sort="username" role="button">Username <span
                                        class="sort-indicator" data-sort-indicator="username"><i
                                            class="fas fa-sort text-secondary"></i></span></th>
                                <th class="text-nowrap sort-header" data-sort="email" role="button">Email <span
                                        class="sort-indicator" data-sort-indicator="email"><i
                                            class="fas fa-sort text-secondary"></i></span></th>
                                <th class="text-nowrap sort-header" data-sort="suspended" role="button">Suspended <span
                                        class="sort-indicator" data-sort-indicator="suspended"><i
                                            class="fas fa-sort text-secondary"></i></span></th>
                                <th class="text-nowrap sort-header" data-sort="created_date" role="button">Created At
                                    <span class="sort-indicator" data-sort-indicator="created_date"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="modified_date" role="button">Modified At
                                    <span class="sort-indicator" data-sort-indicator="modified_date"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Loading...</td>
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
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modalTitle">New User</h6>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formUser">
                            <input type="hidden" name="id" id="userId" value="">

                            <div class="row">
                                <div class="col-6 form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" id="username" class="form-control"
                                        autocomplete="off">
                                </div>

                                <div class="col-6 form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        autocomplete="off">
                                </div>

                                <div class="col-6 form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        autocomplete="new-password">
                                    <small class="form-text text-muted" id="passwordHint">Required for new user.</small>
                                </div>

                                <div class="col-6 form-group">
                                    <label>Suspended</label>
                                    <select name="suspended" id="suspended" class="form-control">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>

                                <div class="col-12 form-group mb-0">
                                    <label>Permissions</label>
                                    <div class="border rounded p-2 table-responsive" style="max-height: 340px; overflow:auto;">
                                        <table class="table table-sm table-borderless mb-0" id="menuPermissionTable">
                                            <thead>
                                                <tr>
                                                    <th style="width:28%">Menu</th>
                                                    <th class="text-center" style="width:30px">All</th>
                                                    <th class="text-center">View</th>
                                                    <th class="text-center">New</th>
                                                    <th class="text-center">Update</th>
                                                    <th class="text-center">Delete</th>
                                                    <th class="text-center">Print</th>
                                                    <th class="text-center">Export</th>
                                                </tr>
                                            </thead>
                                            <tbody id="menuPermissionList">
                                                <tr><td colspan="8" class="text-muted">Loading menu permissions...</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
        $(function () {
            const endpoints = {
                list: '<?= site_url("activities/user/data_list") ?>',
                create: '<?= site_url("activities/user/data_new") ?>',
                edit: '<?= site_url("activities/user/data_edit") ?>',
                update: '<?= site_url("activities/user/data_update") ?>',
                delete: '<?= site_url("activities/user/data_delete") ?>',
                forceLogout: '<?= site_url("activities/user/data_force_logout") ?>',
                menuOptions: '<?= site_url("activities/setmenu/data_option") ?>'
            }

            const state = {
                page: 1,
                perPage: 10,
                search: '',
                suspended: 0,
                sort_by: 'username',
                sort_dir: 'DESC'
            }

            const modal = $('#modalForm')
            const form = $('#formUser')
            const tableBody = $('#userTableBody')
            const pagination = $('#pagination')
            const tableInfo = $('#tableInfo')

            const fields = {
                id: $('#userId'),
                username: $('#username'),
                email: $('#email'),
                password: $('#password'),
                suspended: $('#suspended')
            }

            const menuState = {
                optionsLoaded: false,
                selectedPermissions: {}
            }

            const escapeHtml = (value) => $('<div>').text(value == null ? '' : String(value)).html()

            const buildPrintQuery = () => {
                const params = []

                if (state.search !== '') {
                    params.push(`search=${encodeURIComponent(state.search)}`)
                }

                if (state.suspended !== '' && state.suspended !== null && state.suspended !== undefined) {
                    params.push(`suspended=${encodeURIComponent(state.suspended)}`)
                }

                if (state.sort_by !== '') {
                    params.push(`sort_by=${encodeURIComponent(state.sort_by)}`)
                }

                if (state.sort_dir !== '') {
                    params.push(`sort_dir=${encodeURIComponent(state.sort_dir)}`)
                }

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
                        $(this).html('<i class="fas fa-sort text-secondary ml-1"></i>')
                        return
                    }

                    $(this).html(state.sort_dir === 'ASC'
                        ? ' <i class="fas fa-sort-up ml-1"></i>'
                        : ' <i class="fas fa-sort-down ml-1"></i>')
                })
            }


            const defaultPerms = () => ({ view: 0, new: 0, update: 0, delete: 0, print: 0, export: 0 })

            const renderPermissionList = (menus) => {
                const list = $('#menuPermissionList')
                if (!menus || !menus.length) {
                    list.html('<tr><td colspan="8" class="text-muted text-center">No menu options available.</td></tr>')
                    return
                }

                const parentIds = new Set()
                menus.forEach((m) => {
                    const pid = parseInt(m.parent_set_menuid, 10)
                    if (pid > 0) parentIds.add(pid)
                })

                const allChecked = (p) => p.view && p.new && p.update && p.delete && p.print && p.export

                const indentSize = 24
                const html = menus.map((menu) => {
                    const id = String(menu.set_menuid)
                    const label = menu.name || ''
                    const depth = Number(menu.depth) || 0
                    const isRoot = depth === 0
                    const hasChildren = parentIds.has(parseInt(menu.set_menuid, 10))
                    const p = menuState.selectedPermissions[id] || defaultPerms()

                    let nameHtml = escapeHtml(label)
                    if (isRoot) {
                        nameHtml = `<strong>${nameHtml}</strong>`
                    }

                    const prefix = depth > 0
                        ? '<span style="display:inline-block;width:' + (depth * indentSize) + 'px"></span><i class="fas fa-angle-right text-muted mr-1" style="font-size:10px"></i>'
                        : ''

                    const cell = (key) => {
                        if (hasChildren) return '-'
                        const checked = p[key] ? 'checked' : ''
                        return `<input type="checkbox" class="perm-${key}" data-key="${key}" ${checked}>`
                    }

                    const allCb = hasChildren
                        ? '-'
                        : `<input type="checkbox" class="perm-all" ${allChecked(p) ? 'checked' : ''}>`

                    return `
                        <tr data-menuid="${escapeHtml(id)}">
                            <td>${prefix}${nameHtml}</td>
                            <td class="text-center">${allCb}</td>
                            <td class="text-center">${cell('view')}</td>
                            <td class="text-center">${cell('new')}</td>
                            <td class="text-center">${cell('update')}</td>
                            <td class="text-center">${cell('delete')}</td>
                            <td class="text-center">${cell('print')}</td>
                            <td class="text-center">${cell('export')}</td>
                        </tr>
                    `
                }).join('')

                list.html(html)
            }

            const allPermKeys = ['view', 'new', 'update', 'delete', 'print', 'export']

            $('#menuPermissionList').on('change', '.perm-all', function () {
                const checked = $(this).is(':checked')
                $(this).closest('tr').find(allPermKeys.map((k) => '.perm-' + k).join(',')).prop('checked', checked)
            })

            const collectPermissions = () => {
                const perms = []
                $('#menuPermissionList tr').each(function () {
                    const menuid = $(this).data('menuid')
                    if (!menuid) return
                    perms.push({
                        set_menuid: parseInt(menuid, 10),
                        view:   $(this).find('.perm-view').is(':checked') ? 1 : 0,
                        new:    $(this).find('.perm-new').is(':checked') ? 1 : 0,
                        update: $(this).find('.perm-update').is(':checked') ? 1 : 0,
                        delete: $(this).find('.perm-delete').is(':checked') ? 1 : 0,
                        print:  $(this).find('.perm-print').is(':checked') ? 1 : 0,
                        export: $(this).find('.perm-export').is(':checked') ? 1 : 0,
                    })
                })
                return perms
            }

            const resetForm = () => {
                form[0].reset()
                fields.id.val('')
                fields.suspended.val('0')
                $('#modalTitle').text('New User')
                $('#passwordHint').text('Required for new user.')
                menuState.selectedPermissions = {}
                renderPermissionList(menuState.menuData || [])
            }

            const renderSuspended = (value) => Number(value) === 1
                ? '<span class="badge badge-danger">YES</span>'
                : '<span class="badge badge-success">NO</span>'

            const renderRows = (rows) => {
                if (!rows || !rows.length) {
                    tableBody.html('<tr><td colspan="7" class="text-center text-muted py-4">No data found</td></tr>')
                    return
                }

                const html = rows.map((row) => `
                    <tr>
                        <td class="d-none">${escapeHtml(row.mst_adminid)}</td>
                        <td class="text-nowrap">${escapeHtml(row.username)}</td>
                        <td class="text-nowrap">${escapeHtml(row.email || '-')}</td>
                        <td class="text-nowrap">${renderSuspended(row.suspended)}</td>
                        <td class="text-nowrap" title="Created by: ${escapeHtml(row.created_by)}">
                            ${escapeHtml(formatDate(row.created_date))}
                        </td>
                        <td class="text-nowrap" title="Modified by: ${escapeHtml(row.modified_by)}">
                            ${escapeHtml(formatDate(row.modified_date))}
                        </td>
                        <td class="text-nowrap text-right">
                            <button type="button" class="btn btn-xs btn-outline-primary btn-edit" data-id="${escapeHtml(row.mst_adminid)}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-outline-danger btn-force-logout" data-id="${escapeHtml(row.mst_adminid)}" data-username="${escapeHtml(row.username)}">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-outline-danger btn-delete" data-id="${escapeHtml(row.mst_adminid)}" data-username="${escapeHtml(row.username)}">
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

                let items = []

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
                        suspended: state.suspended,
                        sort_by: state.sort_by,
                        sort_dir: state.sort_dir
                    },
                    beforeSend: function () {
                        $('input, select, textarea, button').prop('disabled', true);
                        $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' });
                    },
                    success: function (res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load data', 'error')
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
                            : `Showing ${start} to ${end} of ${total} entries`)
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                    },
                    complete: function () {
                        $('input, select, textarea, button').prop('disabled', false);
                        $.LoadingOverlay('hide');
                    },
                })
            }

            $('#btnAdd').on('click', function () {
                resetForm()
                renderPermissionList(menuState.menuData || [])
                modal.modal('show')
            })

            $('#btnPrint').on('click', function () {
                const query = buildPrintQuery()
                const url = '<?= site_url("activities/user/data_print") ?>' + (query ? `?${query}` : '')
                openReportUrl(url)
            })

            $('#btnExport').on('click', function () {
                const query = buildPrintQuery()
                const timestamp = getTimestamp()
                const filename = `user_admin_${timestamp}`

                const url = '<?= site_url("activities/user/data_printhtml") ?>/' + filename + '/1' + (query ? `?${query}` : '')
                openReportUrl(url)
            })

            $(document).on('click', '.sort-header', function () {
                const sortKey = $(this).data('sort')
                if (!sortKey) {
                    return
                }

                if (state.sort_by === sortKey) {
                    state.sort_dir = state.sort_dir === 'ASC' ? 'DESC' : 'ASC'
                } else {
                    state.sort_by = sortKey
                    state.sort_dir = 'ASC'
                }

                state.page = 1
                loadData()
            })

            $('#btnApply').on('click', function () {
                state.page = 1
                state.search = $('#search').val().trim()
                state.suspended = $('#filterSuspended').val()
                state.perPage = parseInt($('#perPage').val(), 10) || 10
                loadData()
            })

            $('#btnReset').on('click', function () {
                $('#search').val('')
                $('#filterSuspended').val('0')
                $('#perPage').val('10')
                state.page = 1
                state.perPage = 10
                state.search = ''
                state.suspended = 0
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

            $(document).on('click', '.btn-edit', function () {
                const id = $(this).data('id')
                $.ajax({
                    url: endpoints.edit,
                    type: 'POST',
                    dataType: 'json',
                    data: { id: id },
                    beforeSend: function () {
                        $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' });
                        $('input, select, textarea, button').prop('disabled', true);
                    },
                    success: function (res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load user', 'error')
                            return
                        }

                        const user = res.data || {}
                        fields.id.val(user.mst_adminid || '')
                        fields.username.val(user.username || '')
                        fields.email.val(user.email || '')
                        fields.password.val('')
                        fields.suspended.val(String(user.suspended || 0))
                        $('#modalTitle').text('Edit User')
                        $('#passwordHint').text('Leave blank to keep current password.')
                        menuState.selectedPermissions = (res.permissions && typeof res.permissions === 'object') ? res.permissions : {}
                        renderPermissionList(menuState.menuData || [])
                        modal.modal('show')
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                    },
                    complete: function () {
                        $.LoadingOverlay('hide');
                        $('input, select, textarea, button').prop('disabled', false);
                    },
                })
            })

            $(document).on('click', '.btn-delete', function () {
                const id = $(this).data('id')
                const username = $(this).data('username')

                Swal.fire({
                    title: 'Delete this user?',
                    text: username,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Delete'
                }).then(function (res) {
                    if (!res.isConfirmed) {
                        return
                    }

                    $.ajax({
                        url: endpoints.delete,
                        type: 'POST',
                        dataType: 'json',
                        data: { id: id },
                        beforeSend: function () {
                            $('input, select, textarea, button').prop('disabled', true);
                            $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' });
                        },
                        success: function (response) {
                            if (!response.success) {
                                Swal.fire('Error', response.message || 'Failed to delete user', 'error')
                                return
                            }

                            Swal.fire('Success', response.message || 'User deleted successfully', 'success')
                            loadData()
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                        },
                        complete: function () {
                            $('input, select, textarea, button').prop('disabled', false);
                            $.LoadingOverlay('hide');
                        },
                    })
                })
            })

            $(document).on('click', '.btn-force-logout', function () {
                const id = $(this).data('id')
                const username = $(this).data('username')

                Swal.fire({
                    title: 'Force Logout?',
                    text: 'User "' + username + '" akan di-logout paksa. User harus login ulang.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Force Logout'
                }).then(function (res) {
                    if (!res.isConfirmed) return

                    $.ajax({
                        url: endpoints.forceLogout,
                        type: 'POST',
                        dataType: 'json',
                        data: { id: id },
                        beforeSend: function () {
                            $('input, select, textarea, button').prop('disabled', true);
                            $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' });
                        },
                        success: function (response) {
                            if (!response.success) {
                                Swal.fire('Error', response.message || 'Failed to force logout', 'error')
                                return
                            }
                            Swal.fire('Success', response.message || 'User force logged out', 'success')
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                        },
                        complete: function () {
                            $('input, select, textarea, button').prop('disabled', false);
                            $.LoadingOverlay('hide');
                        },
                    })
                })
            })

            $('#btnSave').on('click', function () {
                const payload = {
                    id: fields.id.val(),
                    username: fields.username.val(),
                    email: fields.email.val(),
                    password: fields.password.val(),
                    suspended: fields.suspended.val(),
                    permissions: JSON.stringify(collectPermissions())
                }

                const isEdit = payload.id !== ''
                const url = isEdit ? endpoints.update : endpoints.create

                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: payload,
                    beforeSend: function () {
                        $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' });
                        $('input, select, textarea, button').prop('disabled', true);
                    },
                    success: function (res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to save user', 'error')
                            return
                        }

                        Swal.fire('Success', res.message || 'Saved successfully', 'success')
                        modal.modal('hide')
                        loadData()
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                    },
                    complete: function () {
                        $.LoadingOverlay('hide');
                        $('input, select, textarea, button').prop('disabled', false);
                    },
                })
            })

            modal.on('hidden.bs.modal', function () {
                resetForm()
            })

            $.ajax({
                url: endpoints.menuOptions,
                type: 'GET',
                dataType: 'json'
            }).then(function (res) {
                if (!res.success) {
                    $('#menuPermissionList').html('<tr><td colspan="8" class="text-danger text-center">Failed to load menu permissions.</td></tr>')
                    return
                }
                menuState.menuData = res.data || []
                menuState.optionsLoaded = true
                renderPermissionList(menuState.menuData)
                loadData()
            }).catch(function () {
                $('#menuPermissionList').html('<tr><td colspan="8" class="text-danger text-center">Failed to load menu permissions.</td></tr>')
                loadData()
            })
        })
    </script>
</body>

</html>