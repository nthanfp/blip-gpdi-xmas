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
                        <button type="button" class="btn btn-sm btn-danger mr-1" id="btnPrint" disabled>
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button type="button" class="btn btn-sm btn-success" id="btnExport" disabled>
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
                        <div class="col-12 col-md-3 mb-2">
                            <label class="mb-0">Search</label>
                            <input type="text" class="form-control form-control-sm" id="search"
                                placeholder="Menu name/path..." autocomplete="off">
                        </div>
                        <div class="col-12 col-md-2 mb-2">
                            <label class="mb-0">Parent Menu</label>
                            <select class="form-control form-control-sm" id="filterParent">
                                <option value="">-- ALL --</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
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
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="0" selected>ALL</option>
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
                                <th class="text-center" style="width:50px"></th>
                                <th>Menu Name</th>
                                <th>Path</th>
                                <th>Parent Menu</th>
                                <th class="d-none">Order</th>
                                <th>Icon</th>
                                <th>Suspended</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBodySetmenu">
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">Loading...</td>
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
                        <h5 class="modal-title" id="modalTitle">New Set Menu</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formSetmenu">
                            <input type="hidden" name="id" id="set_menuid" value="">

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" id="name" class="form-control" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Path</label>
                                <input type="text" name="path" id="path" class="form-control" autocomplete="off">
                            </div>

                            <div class="form-row d-none">
                                <div class="form-group col-md-4">
                                    <label>Order</label>
                                    <input type="number" name="order" id="order" class="form-control" min="0" step="1"
                                        autocomplete="off">
                                </div>
                                <div class="form-group col-md-8">
                                    <label>Icon</label>
                                    <div class="input-group">
                                        <input type="text" name="icon" id="icon" class="form-control" autocomplete="off"
                                            placeholder="far fa-circle">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="iconPreview"><i
                                                    class="far fa-circle"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Parent Menu</label>
                                <select name="parent_set_menuid" id="parent_set_menuid" class="form-control">
                                    <option value="">No Parent</option>
                                </select>
                            </div>

                            <div class="form-group mb-0">
                                <label>Suspended</label>
                                <select name="suspended" id="suspended" class="form-control">
                                    <option value="0" selected>No</option>
                                    <option value="1">Yes</option>
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
        $(function () {
            const endpoints = {
                list: '<?= site_url("activities/setmenu/data_list") ?>',
                create: '<?= site_url("activities/setmenu/data_new") ?>',
                edit: '<?= site_url("activities/setmenu/data_edit") ?>',
                update: '<?= site_url("activities/setmenu/data_update") ?>',
                delete: '<?= site_url("activities/setmenu/data_delete") ?>',
                move: '<?= site_url("activities/setmenu/data_move") ?>',
                optionParent: '<?= site_url("activities/setmenu/data_option_parent") ?>'
            }

            const state = {
                page: 1,
                perPage: 0,
                search: '',
                parent_set_menuid: '',
                suspended: 0
            }

            const modal = $('#modalForm')
            const form = $('#formSetmenu')
            const tableBody = $('#tableBodySetmenu')
            const pagination = $('#pagination')
            const tableInfo = $('#tableInfo')

            const fields = {
                id: $('#set_menuid'),
                parent_set_menuid: $('#parent_set_menuid'),
                name: $('#name'),
                path: $('#path'),
                order: $('#order'),
                icon: $('#icon'),
                suspended: $('#suspended')
            }

            const escapeHtml = (value) => $('<div>').text(value == null ? '' : String(value)).html()


            const parentOptions = new Map()

            const resetForm = () => {
                form[0].reset()
                fields.id.val('')
                fields.parent_set_menuid.val('')
                fields.order.val('')
                fields.icon.val('')
                fields.suspended.val(0)
                $('#iconPreview').html('<i class="far fa-circle"></i>')
                $('#modalTitle').text('New Set Menu')
            }

            const suspendedLabel = (value) => Number(value) === 1
                ? '<span class="badge badge-danger">Yes</span>'
                : '<span class="badge badge-success">No</span>'

            const parentLabel = (value) => {
                const key = value == null ? '' : String(value)
                if (!key || key === '0') return 'No Parent'
                return parentOptions.get(key) || key
            }

            const renderRows = (rows) => {
                if (!rows || !rows.length) {
                    tableBody.html('<tr><td colspan="9" class="text-center text-muted py-4">No data found</td></tr>')
                    return
                }

                const isShowingAll = state.search === '' && state.parent_set_menuid === ''

                const nodeMap = {}
                const childrenMap = {}

                rows.forEach(function (row) {
                    const id = String(row.set_menuid)
                    nodeMap[id] = row
                    if (!childrenMap[id]) {
                        childrenMap[id] = []
                    }
                })

                rows.forEach(function (row) {
                    const pid = row.parent_set_menuid ? String(row.parent_set_menuid) : null
                    if (pid && nodeMap[pid]) {
                        if (!childrenMap[pid]) childrenMap[pid] = []
                        childrenMap[pid].push(row)
                    }
                })

                const rootIds = rows.filter(function (row) {
                    const pid = row.parent_set_menuid ? String(row.parent_set_menuid) : null
                    return !pid || !nodeMap[pid]
                }).map(function (row) {
                    return String(row.set_menuid)
                })

                const html = []

                function renderBranch(id, depth, sibIndex, sibCount) {
                    const row = nodeMap[id]
                    if (!row) return

                    const indent = depth * 24
                    const prefix = depth > 0 ? '<span style="display:inline-block;width:' + indent + 'px"></span><i class="fas fa-angle-right text-muted mr-1" style="font-size:10px"></i>' : ''
                    const nameHtml = (depth === 0 ? '<strong>' : '') + prefix + escapeHtml(row.name) + (depth === 0 ? '</strong>' : '')
                    const order = row.sort_order || row.order || 0

                    const canMoveUp = isShowingAll && sibIndex > 0
                    const canMoveDown = isShowingAll && sibIndex < sibCount - 1

                    html.push('<tr>')
                    html.push('<td class="d-none">' + escapeHtml(row.set_menuid) + '</td>')
                    const moveBtnClass = depth === 0 ? 'btn-secondary' : 'btn-outline-secondary'
                    html.push('<td class="text-left text-nowrap" style="padding-left:12px">')
                    if (canMoveUp) {
                        html.push('<button type="button" class="btn btn-xs ' + moveBtnClass + ' btn-move" data-id="' + escapeHtml(row.set_menuid) + '" data-direction="up"><i class="fas fa-arrow-up"></i></button> ')
                    }
                    if (canMoveDown) {
                        html.push('<button type="button" class="btn btn-xs ' + moveBtnClass + ' btn-move" data-id="' + escapeHtml(row.set_menuid) + '" data-direction="down"><i class="fas fa-arrow-down"></i></button>')
                    }
                    html.push('</td>')
                    html.push('<td>' + nameHtml + '</td>')
                    html.push('<td>' + escapeHtml(row.path) + '</td>')
                    html.push('<td>' + escapeHtml(parentLabel(row.parent_set_menuid)) + '</td>')
                    html.push('<td class="d-none">' + escapeHtml(order) + '</td>')
                    html.push('<td><i class="' + escapeHtml(row.icon || 'far fa-circle') + '"></i> <span class="ml-1">' + escapeHtml(row.icon || '-') + '</span></td>')
                    html.push('<td>' + suspendedLabel(row.suspended) + '</td>')
                    html.push('<td class="text-right text-nowrap">')
                    html.push('<button type="button" class="btn btn-xs btn-outline-primary btn-edit" data-id="' + escapeHtml(row.set_menuid) + '"><i class="fas fa-edit"></i></button> ')
                    html.push('<button type="button" class="btn btn-xs btn-outline-danger btn-delete" data-id="' + escapeHtml(row.set_menuid) + '" data-name="' + escapeHtml(row.name) + '"><i class="fas fa-trash"></i></button>')
                    html.push('</td>')
                    html.push('</tr>')

                    const children = childrenMap[id] || []
                    children.sort(function (a, b) {
                        const oa = a.sort_order || a.order || 0
                        const ob = b.sort_order || b.order || 0
                        if (oa !== ob) return oa - ob
                        return (a.name || '').localeCompare(b.name || '')
                    })
                    children.forEach(function (child, i) {
                        renderBranch(String(child.set_menuid), depth + 1, i, children.length)
                    })
                }

                rootIds.sort(function (a, b) {
                    const ra = nodeMap[a], rb = nodeMap[b]
                    const oa = ra.sort_order || ra.order || 0
                    const ob = rb.sort_order || rb.order || 0
                    if (oa !== ob) return oa - ob
                    return (ra.name || '').localeCompare(rb.name || '')
                })

                rootIds.forEach(function (id, i) {
                    renderBranch(id, 0, i, rootIds.length)
                })

                tableBody.html(html.join(''))
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

            const loadParentOptions = () => {
                return $.ajax({
                    url: endpoints.optionParent,
                    type: 'GET',
                    dataType: 'json'
                }).then(function (res) {
                    if (!res.success) {
                        return
                    }

                    parentOptions.clear()
                    fields.parent_set_menuid.empty().append('<option value="">No Parent</option>')
                    $('#filterParent').empty().append('<option value="">-- ALL --</option>')

                        ; (res.data || []).forEach(function (row) {
                            const id = String(row.set_menuid)
                            const label = row.name + (row.path ? ' - ' + row.path : '')
                            parentOptions.set(id, label)
                            fields.parent_set_menuid.append(`<option value="${escapeHtml(id)}">${escapeHtml(label)}</option>`)
                            $('#filterParent').append(`<option value="${escapeHtml(id)}">${escapeHtml(label)}</option>`)
                        })
                })
            }

            const loadData = () => {
                const perPage = state.perPage === 0 ? 99999 : state.perPage
                $.ajax({
                    url: endpoints.list,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        page: state.page,
                        per_page: perPage,
                        search: state.search,
                        parent_set_menuid: state.parent_set_menuid,
                        suspended: state.suspended
                    },
                    beforeSend: function () {
                        $('input, select, textarea, button').prop('disabled', true);
                        $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' });
                    },
                    success: function (res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load menu data', 'error')
                            return
                        }

                        renderRows(res.data || [])
                        renderPagination(res.pagination || {})

                        const p = res.pagination || {}
                        const total = Number(p.total || 0)
                        const pagPage = Number(p.page || 1)
                        const pagPerPage = Number(p.per_page || state.perPage)
                        const showingAll = pagPerPage >= total

                        tableInfo.text(showingAll
                            ? 'Showing all ' + total + ' entries'
                            : 'Showing ' + (total === 0 ? 0 : ((pagPage - 1) * pagPerPage) + 1) + ' to ' + Math.min(total, pagPage * pagPerPage) + ' of ' + total + ' entries')
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

            const openCreateModal = () => {
                resetForm()
                modal.modal('show')
            }

            const openEditModal = (id) => {
                $.ajax({
                    url: endpoints.edit,
                    type: 'POST',
                    dataType: 'json',
                    data: { id: id },
                    beforeSend: function () {
                        $('input, select, textarea, button').prop('disabled', true);
                        $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' });
                    },
                    success: function (res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load menu', 'error')
                            return
                        }

                        const item = res.data || {}
                        fields.id.val(item.set_menuid || '')
                        fields.name.val(item.name || '')
                        fields.path.val(item.path || '')
                        fields.order.val(item.order || item.sort_order || 0)
                        fields.icon.val(item.icon || '')
                        $('#iconPreview').html(`<i class="${escapeHtml(item.icon || 'far fa-circle')}"></i>`)
                        fields.parent_set_menuid.val(item.parent_set_menuid || '')
                        fields.suspended.val(String(item.suspended || 0))
                        $('#modalTitle').text('Edit Set Menu')
                        modal.modal('show')
                    },
                    complete: function () {
                        $('input, select, textarea, button').prop('disabled', false);
                        $.LoadingOverlay('hide');
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                    }
                })
            }

            $('#btnAdd').on('click', openCreateModal)

            $('#btnApply').on('click', function () {
                state.page = 1
                state.search = $('#search').val().trim()
                state.parent_set_menuid = $('#filterParent').val()
                state.suspended = $('#filterSuspended').val()
                state.perPage = $('#perPage').val() === '0' ? 0 : (parseInt($('#perPage').val(), 10) || 25)
                loadData()
            })

            $('#btnReset').on('click', function () {
                $('#search').val('')
                $('#filterParent').val('')
                $('#filterSuspended').val(0)
                $('#perPage').val('0')
                state.page = 1
                state.perPage = 0
                state.search = ''
                state.parent_set_menuid = ''
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
                openEditModal($(this).data('id'))
            })

            $(document).on('click', '.btn-move', function () {
                const id = $(this).data('id')
                const direction = $(this).data('direction')

                $.ajax({
                    url: endpoints.move,
                    type: 'POST',
                    dataType: 'json',
                    data: { id: id, direction: direction },
                    beforeSend: function () {
                        $('input, select, textarea, button').prop('disabled', true);
                        $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' });
                    },
                    success: function (res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to move menu', 'error')
                            return
                        }
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

            $(document).on('click', '.btn-delete', function () {
                const id = $(this).data('id')
                const name = $(this).data('name')

                Swal.fire({
                    title: 'Delete this menu?',
                    text: name,
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
                                Swal.fire('Error', response.message || 'Failed to delete menu', 'error')
                                return
                            }

                            Swal.fire('Success', response.message || 'Menu deleted successfully', 'success')
                            loadData()
                        },
                        complete: function () {
                            $('input, select, textarea, button').prop('disabled', false);
                            $.LoadingOverlay('hide');
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                        }
                    })
                })
            })

            $('#btnSave').on('click', function () {
                const payload = {
                    id: fields.id.val(),
                    name: fields.name.val(),
                    path: fields.path.val(),
                    order: fields.order.val(),
                    icon: fields.icon.val(),
                    parent_set_menuid: fields.parent_set_menuid.val(),
                    suspended: fields.suspended.val()
                }

                const isEdit = payload.id !== ''
                const url = isEdit ? endpoints.update : endpoints.create

                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: payload,
                    beforeSend: function () {
                        $('input, select, textarea, button').prop('disabled', true);
                        $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' });
                    },
                    success: function (res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to save menu', 'error')
                            return
                        }

                        Swal.fire('Success', res.message || 'Saved successfully', 'success')
                        modal.modal('hide')
                        loadData()
                    },
                    complete: function () {
                        $('input, select, textarea, button').prop('disabled', false);
                        $.LoadingOverlay('hide');
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                    }
                })
            })

            fields.icon.on('input', function () {
                const icon = $(this).val().trim() || 'far fa-circle'
                $('#iconPreview').html(`<i class="${escapeHtml(icon)}"></i>`)
            })

            modal.on('hidden.bs.modal', function () {
                resetForm()
            })

            loadParentOptions().always(function () {
                loadData()
            })
        })
    </script>
</body>

</html>