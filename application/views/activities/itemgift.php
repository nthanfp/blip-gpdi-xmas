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
                    <div>
                        <button type="button" class="btn btn-sm btn-secondary" id="btnAdd">
                            <i class="fas fa-plus"></i> New
                        </button>
                    </div>
                </div>
            </div>

            <div class="row mb-2 d-none">
                <div class="col-12">
                    <div class="alert alert-info">
                    </div>
                </div>
            </div>

            <div class="card card-outline card-secondary mb-0">
                <div class="card-body py-2 px-2 border-bottom">
                    <div class="row">
                        <div class="col-12 col-md-4 mb-2">
                            <label class="mb-0">Search</label>
                            <input type="text" class="form-control form-control-sm" id="search"
                                placeholder="Item name..." autocomplete="off">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="mb-0">Item Type</label>
                            <select class="form-control form-control-sm" name="itemtype" id="filterItemtype">
                                <option value="">-- ALL --</option>
                                <option value="1">POINT</option>
                                <option value="2">OTHER</option>
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
                        <div class="col-6 col-md-2 mb-2">
                            <label class="mb-0">Show</label>
                            <select class="form-control form-control-sm" id="perPage">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 offset-md-9 mb-2">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn px-3 btn-sm btn-secondary w-100 mr-1" id="btnReset">
                                    <i class="fas fa-undo mr-1"></i> Reset
                                </button>
                                <button type="button" class="btn px-3 btn-sm btn-primary w-100" id="btnApply">
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
                                <th class="text-nowrap sort-header" data-sort="itemname" role="button">Item Name <span
                                        class="sort-indicator" data-sort-indicator="itemname"><i
                                            class="fas fa-sort text-secondary ml-1"></i></span></th>
                                <th class="text-nowrap sort-header" data-sort="itemtype" role="button">Item Type <span
                                        class="sort-indicator" data-sort-indicator="itemtype"><i
                                            class="fas fa-sort text-secondary ml-1"></i></span></th>
                                <th class="text-nowrap sort-header" data-sort="value" role="button">Value <span
                                        class="sort-indicator" data-sort-indicator="value"><i
                                            class="fas fa-sort text-secondary ml-1"></i></span></th>
                                <th class="text-nowrap sort-header" data-sort="suspended" role="button">Suspended <span
                                        class="sort-indicator" data-sort-indicator="suspended"><i
                                            class="fas fa-sort text-secondary ml-1"></i></span></th>
                                <th class="text-nowrap sort-header" data-sort="created_date" role="button">Created At
                                    <span class="sort-indicator" data-sort-indicator="created_date"><i
                                            class="fas fa-sort text-secondary ml-1"></i></span>
                                </th>
                                <th class="text-nowrap sort-header d-none" data-sort="modified_date" role="button">
                                    Modified At <span class="sort-indicator" data-sort-indicator="modified_date"><i
                                            class="fas fa-sort text-secondary ml-1"></i></span></th>
                                <th class="text-nowrap text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemgiftTableBody">
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer px-2 py-2">
                    <div class="row align-items-center text-center text-md-left">
                        <div class="col-md-6 col-md-6 mb-2 mb-md-0">
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

        <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">New Item Gift</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formItemgift">
                            <input type="hidden" name="id" id="itemgiftId" value="">

                            <div class="form-group">
                                <label>Item Name</label>
                                <input type="text" name="itemname" id="itemname" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Item Type</label>
                                <select name="itemtype" id="itemtype" class="form-control">
                                    <option value="1">POINT</option>
                                    <option value="2">OTHER</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Value</label>
                                <input type="number" name="value" id="value" class="form-control"
                                    autocomplete="off" placeholder="0">
                            </div>

                            <div class="form-group mb-0">
                                <label>Suspended</label>
                                <select name="suspended" id="suspended" class="form-control">
                                    <option value="0">No</option>
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
        $(function() {
            const endpoints = {
                list: '<?= site_url("activities/itemgift/data_list") ?>',
                create: '<?= site_url("activities/itemgift/data_new") ?>',
                edit: '<?= site_url("activities/itemgift/data_edit") ?>',
                update: '<?= site_url("activities/itemgift/data_update") ?>',
                delete: '<?= site_url("activities/itemgift/data_delete") ?>'
            }

            const state = {
                page: 1,
                perPage: 10,
                search: '',
                itemtype: '',
                suspended: 0,
                sort_by: 'itemname',
                sort_dir: 'ASC'
            }

            const modal = $('#modalForm')
            const form = $('#formItemgift')
            const tableBody = $('#itemgiftTableBody')
            const pagination = $('#pagination')
            const tableInfo = $('#tableInfo')

            const fields = {
                id: $('#itemgiftId'),
                itemname: $('#itemname'),
                itemtype: $('#itemtype'),
                value: $('#value'),
                suspended: $('#suspended')
            }

            const escapeHtml = (value) => $('<div>').text(value == null ? '' : String(value)).html()

            const buildPrintQuery = () => {
                const params = []

                if (state.search !== '') {
                    params.push(`search=${encodeURIComponent(state.search)}`)
                }

                if (state.itemtype !== '' && state.itemtype !== null && state.itemtype !== undefined) {
                    params.push(`itemtype=${encodeURIComponent(state.itemtype)}`)
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
                $('.sort-indicator').each(function() {
                    const key = $(this).data('sort-indicator')
                    if (state.sort_by !== key) {
                        $(this).html('<i class="fas fa-sort text-secondary ml-1"></i>')
                        return
                    }

                    $(this).html(state.sort_dir === 'ASC' ?
                        ' <i class="fas fa-sort-up ml-1"></i>' :
                        ' <i class="fas fa-sort-down ml-1"></i>')
                })
            }


            const resetForm = () => {
                form[0].reset()
                fields.id.val('')
                fields.itemtype.val('0')
                fields.value.val('')
                fields.suspended.val('0')
                $('#modalTitle').text('New Item Gift')
            }

            const itemTypeLabel = (value) => Number(value) === 1 ?
                'POINT' :
                'OTHER'

            const suspendedLabel = (value) => Number(value) === 1 ?
                '<span class="badge badge-danger">YES</span>' :
                '<span class="badge badge-success">NO</span>'

            const formatValue = (value) => {
                if (value === null || value === undefined || value === '') return '-'
                return Number(value).toLocaleString('id-ID')
            }

            const renderRows = (rows) => {
                if (!rows || !rows.length) {
                    tableBody.html('<tr><td colspan="7" class="text-center text-muted py-4">No data found</td></tr>')
                    return
                }

                const html = rows.map((row) => `
                    <tr>
                        <td class="text-nowrap d-none">${escapeHtml(row.mst_itemgiftid)}</td>
                        <td class="text-nowrap">${escapeHtml(row.itemname)}</td>
                        <td class="text-nowrap">${itemTypeLabel(row.itemtype)}</td>
                        <td class="text-nowrap">${formatValue(row.value)}</td>
                        <td class="text-nowrap">${suspendedLabel(row.suspended)}</td>
                        <td class="text-nowrap" title="Created by: ${escapeHtml(row.created_by)}">
                            ${escapeHtml(formatDate(row.created_date))}
                        </td>
                        <td class="text-nowrap d-none" title="Modified by: ${escapeHtml(row.modified_by)}">
                            ${escapeHtml(formatDate(row.modified_date))}
                        </td>
                        <td class="text-nowrap text-right">
                            <button type="button" class="btn btn-xs btn-outline-primary btn-edit" data-id="${escapeHtml(row.mst_itemgiftid)}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-outline-danger btn-delete" data-id="${escapeHtml(row.mst_itemgiftid)}" data-itemname="${escapeHtml(row.itemname)}">
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

                const isMobile = window.innerWidth < 576
                const maxVisible = isMobile ? 3 : 7

                let start = Math.max(1, currentPage - Math.floor(maxVisible / 2))
                let end = Math.min(totalPages, start + maxVisible - 1)

                // adjust kalau mentok
                if (end - start + 1 < maxVisible) {
                    start = Math.max(1, end - maxVisible + 1)
                }

                const items = []

                // First + Prev
                items.push(`
                    <li class="page-item ${hasPrev ? '' : 'disabled'} ${isMobile ? 'd-none' : ''}">
                        <a class="page-link" href="#" data-page="1">First</a>
                    </li>
                `)

                items.push(`
                    <li class="page-item ${hasPrev ? '' : 'disabled'}">
                        <a class="page-link" href="#" data-page="${Math.max(1, currentPage - 1)}">Prev</a>
                    </li>
                `)

                // Ellipsis awal
                if (start > 1) {
                    items.push('<li class="page-item disabled"><span class="page-link">...</span></li>')
                }

                // Page numbers
                for (let i = start; i <= end; i++) {
                    items.push(`
                        <li class="page-item ${i === currentPage ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `)
                }

                // Ellipsis akhir
                if (end < totalPages) {
                    items.push('<li class="page-item disabled"><span class="page-link">...</span></li>')
                }

                // Next + Last
                items.push(`
                    <li class="page-item ${hasNext ? '' : 'disabled'}">
                        <a class="page-link" href="#" data-page="${Math.min(totalPages, currentPage + 1)}">Next</a>
                    </li>
                `)

                items.push(`
                    <li class="page-item ${hasNext ? '' : 'disabled'} ${isMobile ? 'd-none' : ''}">
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
                        itemtype: state.itemtype,
                        suspended: state.suspended,
                        sort_by: state.sort_by,
                        sort_dir: state.sort_dir
                    },
                    beforeSend: function() {
                        $.LoadingOverlay('show', {
                            background: 'rgba(0, 0, 0, 0.25)'
                        });
                        $('input, select, textarea, button').prop('disabled', true);
                    },
                    success: function(res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load item gift data', 'error')
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
                            `Showing ${start} to ${end} of ${total} entries`)
                    },
                    complete: function() {
                        $.LoadingOverlay('hide');
                        $('input, select, textarea, button').prop('disabled', false);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
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
                        $.LoadingOverlay('show', {
                            background: 'rgba(0, 0, 0, 0.25)'
                        });
                        $('input, select, textarea, button').prop('disabled', true);
                    },
                    success: function(res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load item gift', 'error')
                            return
                        }

                        const item = res.data || {}
                        fields.id.val(item.mst_itemgiftid || '')
                        fields.itemname.val(item.itemname || '')
                        fields.itemtype.val(String(item.itemtype || 0))
                        fields.value.val(item.value !== null ? item.value : '')
                        fields.suspended.val(String(item.suspended || 0))
                        $('#modalTitle').text('Edit Item Gift')
                        modal.modal('show')
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                    },
                    complete: function() {
                        $.LoadingOverlay('hide');
                        $('input, select, textarea, button').prop('disabled', false);
                    },
                })
            }

            $('#btnAdd').on('click', openCreateModal)

            $('#btnPrint').on('click', function() {
                const query = buildPrintQuery()
                const url = '<?= site_url("activities/itemgift/data_print") ?>' + (query ? `?${query}` : '')
                openReportUrl(url)
            })

            $('#btnExport').on('click', function() {
                const query = buildPrintQuery()
                const timestamp = getTimestamp()
                const filename = `itemgift_${timestamp}`

                const url = '<?= site_url("activities/itemgift/data_printhtml") ?>/' + filename + '/1' + (query ? `?${query}` : '')
                openReportUrl(url)
            })

            $('#btnApply').on('click', function() {
                state.page = 1
                state.search = $('#search').val().trim()
                state.itemtype = $('#filterItemtype').val()
                state.suspended = $('#filterSuspended').val()
                state.perPage = parseInt($('#perPage').val(), 10) || 10
                loadData()
            })

            $('#btnReset').on('click', function() {
                $('#search').val('')
                $('#filterItemtype').val('')
                $('#filterSuspended').val(0)
                $('#perPage').val('10')
                state.page = 1
                state.perPage = 10
                state.search = ''
                state.itemtype = ''
                state.suspended = 0
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
                const itemname = $(this).data('itemname')

                Swal.fire({
                    title: 'Delete this item gift?',
                    text: itemname,
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
                            $.LoadingOverlay('show', {
                                background: 'rgba(0, 0, 0, 0.25)'
                            });
                            $('input, select, textarea, button').prop('disabled', true);
                        },
                        success: function(response) {
                            if (!response.success) {
                                Swal.fire('Error', response.message || 'Failed to delete item gift', 'error')
                                return
                            }

                            Swal.fire('Success', response.message || 'Item gift deleted successfully', 'success')
                            loadData()
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                        },
                        complete: function() {
                            $.LoadingOverlay('hide');
                            $('input, select, textarea, button').prop('disabled', false);
                        }
                    })
                })
            })

            $('#btnSave').on('click', function() {
                const payload = {
                    id: fields.id.val(),
                    itemname: fields.itemname.val(),
                    itemtype: fields.itemtype.val(),
                    value: fields.value.val(),
                    suspended: fields.suspended.val()
                }

                const isEdit = payload.id !== ''
                const url = isEdit ? endpoints.update : endpoints.create

                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: payload,
                    beforeSend: function() {
                        $.LoadingOverlay('show', {
                            background: 'rgba(0, 0, 0, 0.25)'
                        });
                        $('input, select, textarea, button').prop('disabled', true);
                    },
                    success: function(res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to save item gift', 'error')
                            return
                        }

                        Swal.fire('Success', res.message || 'Saved successfully', 'success')
                        modal.modal('hide')
                        loadData()
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                    },
                    complete: function() {
                        $.LoadingOverlay('hide');
                        $('input, select, textarea, button').prop('disabled', false);
                    }
                })
            })

            $(document).on('click', '.sort-header', function() {
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

            modal.on('hidden.bs.modal', function() {
                resetForm()
            })

            loadData()
        })
    </script>
</body>

</html>