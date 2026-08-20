<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('partial/activities/head.php') ?>
    <style>
        .code-key {
            font-family: SFMono-Regular, Menlo, Consolas, monospace;
            font-size: .8rem;
            letter-spacing: .02em;
            word-break: break-all;
            white-space: nowrap;
        }
    </style>
</head>

<body class="sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">
        <?php $this->load->view('partial/activities/sidebar.php') ?>

        <div class="content-wrapper py-4 px-4 text-sm">
            <div class="row mb-2">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div class="text-muted font-italic">
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-secondary" id="btnAdd">
                            <i class="fas fa-plus mr-1"></i> New API Key
                        </button>
                    </div>
                </div>
            </div>

            <div class="card card-outline card-secondary mb-0">
                <div class="card-body py-2 px-2 border-bottom">
                    <div class="row">
                        <div class="col-12 col-md-4 mb-2">
                            <label class="mb-0">Search</label>
                            <input type="text" id="filterSearch" class="form-control form-control-sm"
                                placeholder="Key name, notes, api key..." autocomplete="off">
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <label class="mb-0">Status</label>
                            <select id="filterStatus" class="form-control form-control-sm">
                                <option value="">-- All --</option>
                                <option value="true">Active</option>
                                <option value="false">Inactive</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2 mb-2">
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
                                <th class="d-none text-nowrap sort-header" data-sort="set_api_keyid" role="button">
                                    ID <span class="sort-indicator" data-sort-indicator="set_api_keyid"><i class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="key_name" role="button">
                                    Key Name <span class="sort-indicator" data-sort-indicator="key_name"><i class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap d-none">API Key</th>
                                <th class="text-nowrap">Notes</th>
                                <th class="text-nowrap sort-header" data-sort="is_active" role="button">
                                    Status <span class="sort-indicator" data-sort-indicator="is_active"><i class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="created_date" role="button">
                                    Created Date <span class="sort-indicator" data-sort-indicator="created_date"><i class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap">Last Used</th>
                                <th class="text-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBodyApiKey">
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

        <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header py-2">
                        <h6 class="modal-title" id="modalTitle">New API Key</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-sm">
                        <form id="formApiKey">
                            <input type="hidden" id="set_api_keyid" value="">

                            <div class="form-group">
                                <label>Key Name</label>
                                <input type="text" id="key_name" class="form-control form-control-sm" autocomplete="off"
                                    placeholder="e.g. Internal Service">
                            </div>

                            <div class="form-group mb-2">
                                <label>Notes</label>
                                <textarea id="notes" class="form-control form-control-sm" rows="2" autocomplete="off"
                                    placeholder="optional description"></textarea>
                            </div>

                            <div class="form-group mb-0 d-none" id="fieldIsActive">
                                <label>Status</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_active" value="true">
                                    <label class="custom-control-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-sm btn-secondary mr-auto" data-dismiss="modal">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-sm btn-primary d-none" id="btnRegenerate">
                            <i class="fas fa-sync-alt mr-1"></i> Regenerate Key
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" id="btnSave">
                            <i class="fas fa-save mr-1"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalCreated" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header py-2">
                        <h6 class="modal-title">API Key Created</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-sm">
                        <p class="mb-2">Copy the API key now. For security, it is only shown once.</p>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control code-key" id="createdKey" readonly>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" id="btnCopyKey">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header py-2">
                        <h6 class="modal-title">API Key Detail</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-sm">
                        <div class="row mb-2">
                            <div class="mb-3 col-md-6">
                                <strong>Key Name</strong>
                                <div id="detailName">-</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <strong>Status</strong>
                                <div id="detailStatus">-</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <strong>Created Date</strong>
                                <div id="detailCreated">-</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <strong>Created By</strong>
                                <div id="detailCreatedBy">-</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <strong>Last Used</strong>
                                <div id="detailLastUsed">-</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <strong>Notes</strong>
                                <div id="detailNotes">-</div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <strong>API Key</strong>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control code-key" id="detailKey" readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" id="btnCopyDetailKey">
                                            <i class="fas fa-copy"></i> Copy
                                        </button>
                                    </div>
                                </div>
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
                list: '<?= site_url("activities/apikey/data_list") ?>',
                create: '<?= site_url("activities/apikey/data_create") ?>',
                detail: '<?= site_url("activities/apikey/data_detail") ?>',
                update: '<?= site_url("activities/apikey/data_update") ?>',
                delete: '<?= site_url("activities/apikey/data_delete") ?>',
                regenerate: '<?= site_url("activities/apikey/data_regenerate") ?>',
            }

            const state = {
                page: 1,
                perPage: 10,
                search: '',
                is_active: '',
                sort_by: 'created_date',
                sort_dir: 'DESC'
            }

            const modalForm = $('#modalForm')
            const modalCreated = $('#modalCreated')
            const modalDetail = $('#modalDetail')
            const form = $('#formApiKey')
            const tableBody = $('#tableBodyApiKey')
            const pagination = $('#pagination')
            const tableInfo = $('#tableInfo')

            const fields = {
                id: $('#set_api_keyid'),
                key_name: $('#key_name'),
                notes: $('#notes'),
                is_active: $('#is_active')
            }

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

            const formatDate = (value) => {
                if (!value) return '-'
                const d = new Date(value)
                if (isNaN(d)) return value
                const pad = (n) => String(n).padStart(2, '0')
                return `${pad(d.getDate())} ${d.toLocaleString('en-US', { month: 'short' })} ${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}`
            }

            const isActive = (value) => value === true || value === 't' || value === 'true' || value === '1' || value === 1

            const statusBadge = (value) => {
                return isActive(value) ?
                    '<span class="badge badge-success">Active</span>' :
                    '<span class="badge badge-secondary">Inactive</span>'
            }

            const copyText = (text) => {
                const target = text || ''
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(target).then(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Copied',
                            text: 'API key copied to clipboard',
                            timer: 1500,
                            showConfirmButton: false
                        })
                    }).catch(() => {
                        fallbackCopy(target)
                    })
                    return
                }
                fallbackCopy(target)
            }

            const fallbackCopy = (text) => {
                const tmp = $('<textarea>').val(text).appendTo('body').select()
                let ok = false
                try {
                    ok = document.execCommand('copy')
                } catch (e) {
                    ok = false
                }
                tmp.remove()
                if (ok) {
                    Swal.fire('Copied', 'API key copied to clipboard', 'success')
                } else {
                    Swal.fire('Error', 'Failed to copy API key', 'error')
                }
            }

            const resetForm = () => {
                form[0].reset()
                fields.id.val('')
                fields.is_active.prop('checked', false)
                $('#fieldIsActive').addClass('d-none')
                $('#modalTitle').text('New API Key')
                $('#btnRegenerate').addClass('d-none')
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
                        <td class="d-none text-nowrap">${escapeHtml(row.set_api_keyid)}</td>
                        <td class="text-nowrap">${escapeHtml(row.key_name || '-')}</td>
                        <td class="text-nowrap code-key d-none">${escapeHtml(row.api_key || '-')}</td>
                        <td style="max-width: 220px; word-break: break-word;">${escapeHtml(row.notes || '-')}</td>
                        <td class="text-nowrap">${statusBadge(row.is_active)}</td>
                        <td class="text-nowrap">${escapeHtml(formatDate(row.created_date))}</td>
                        <td class="text-nowrap">${escapeHtml(formatDate(row.last_used))}</td>
                        <td class="text-nowrap">
                            <button type="button" class="btn btn-xs btn-secondary btn-detail"
                                data-id="${escapeAttr(row.set_api_keyid)}"
                                data-key="${escapeAttr(row.api_key)}"
                                data-name="${escapeAttr(row.key_name)}"
                                data-notes="${escapeAttr(row.notes)}"
                                data-active="${escapeAttr(row.is_active)}"
                                data-created="${escapeAttr(formatDate(row.created_date))}"
                                data-created-by="${escapeAttr(row.created_by)}"
                                data-last-used="${escapeAttr(formatDate(row.last_used))}"
                                title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-outline-secondary btn-edit"
                                data-id="${escapeAttr(row.set_api_keyid)}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-outline-danger btn-delete"
                                data-id="${escapeAttr(row.set_api_keyid)}"
                                data-name="${escapeAttr(row.key_name)}" title="Deactivate">
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
                        is_active: state.is_active,
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
                            Swal.fire('Error', res.message || 'Failed to load API key data', 'error')
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

            const openCreateModal = () => {
                resetForm()
                modalForm.modal('show')
            }

            const openEditModal = (id) => {
                $.ajax({
                    url: endpoints.detail,
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
                            Swal.fire('Error', res.message || 'Failed to load API key', 'error')
                            return
                        }

                        const item = res.data || {}
                        fields.id.val(item.set_api_keyid || '')
                        fields.key_name.val(item.key_name || '')
                        fields.notes.val(item.notes || '')
                        fields.is_active.prop('checked', isActive(item.is_active))
                        $('#fieldIsActive').removeClass('d-none')
                        $('#btnRegenerate').removeClass('d-none')
                        $('#modalTitle').text('Edit API Key')
                        modalForm.modal('show')
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

            $('#btnRegenerate').on('click', function() {
                const id = fields.id.val()
                if (!id) return

                Swal.fire({
                    title: 'Regenerate this API key?',
                    text: 'The current key will stop working immediately.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Regenerate'
                }).then(function(res) {
                    if (!res.isConfirmed) return

                    $.ajax({
                        url: endpoints.regenerate + '?id=' + encodeURIComponent(id),
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
                            if (!response.success || !response.data) {
                                Swal.fire('Error', response.message || 'Failed to regenerate API key', 'error')
                                return
                            }

                            modalForm.modal('hide')
                            $('#modalCreatedTitle').text('API Key Regenerated')
                            $('#createdKey').val(response.data.api_key)
                            modalCreated.modal('show')
                            loadData()
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

            $('#btnAdd').on('click', openCreateModal)

            $('#btnApply').on('click', function() {
                state.page = 1
                state.search = $('#filterSearch').val().trim()
                state.is_active = $('#filterStatus').val()
                state.perPage = parseInt($('#perPage').val(), 10) || 10
                loadData()
            })

            $('#btnReset').on('click', function() {
                $('#filterSearch').val('')
                $('#filterStatus').val('')
                $('#perPage').val('10')
                state.page = 1
                state.perPage = 10
                state.search = ''
                state.is_active = ''
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

            $(document).on('click', '.btn-detail', function() {
                const btn = $(this)
                $('#detailName').text(btn.data('name') || '-')
                $('#detailStatus').html(statusBadge(btn.data('active')))
                $('#detailKey').val(btn.data('key') || '')
                $('#detailNotes').text(btn.data('notes') || '-')
                $('#detailCreated').text(btn.data('created') || '-')
                $('#detailCreatedBy').text(btn.data('created-by') || '-')
                $('#detailLastUsed').text(btn.data('last-used') || '-')
                modalDetail.modal('show')
            })

            $(document).on('click', '.btn-edit', function() {
                openEditModal($(this).data('id'))
            })

            $(document).on('click', '.btn-delete', function() {
                const id = $(this).data('id')
                const name = $(this).data('name')

                Swal.fire({
                    title: 'Delete this API key?',
                    text: name ? `"${name}" will no longer be accepted by the API.` : 'It will no longer be accepted by the API.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Delete'
                }).then(function(res) {
                    if (!res.isConfirmed) {
                        return
                    }

                    $.ajax({
                        url: endpoints.delete + '?id=' + encodeURIComponent(id),
                        type: 'POST',
                        dataType: 'json',
                        beforeSend: function() {
                            $('input, select, textarea, button').prop('disabled', true);
                            $.LoadingOverlay('show', {
                                background: 'rgba(0, 0, 0, 0.25)'
                            });
                        },
                        success: function(response) {
                            if (!response.success) {
                                Swal.fire('Error', response.message || 'Failed to deactivate API key', 'error')
                                return
                            }

                            Swal.fire('Success', response.message || 'API key deactivated', 'success')
                            loadData()
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
                const id = fields.id.val()
                const isEdit = id !== ''
                const payload = {
                    key_name: fields.key_name.val(),
                    notes: fields.notes.val()
                }

                if (isEdit) {
                    payload.is_active = fields.is_active.prop('checked') ? 'true' : 'false'
                }

                $.ajax({
                    url: isEdit ? endpoints.update + '?id=' + encodeURIComponent(id) : endpoints.create,
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
                            Swal.fire('Error', res.message || 'Failed to save API key', 'error')
                            return
                        }

                        modalForm.modal('hide')

                        if (!isEdit && res.data && res.data.api_key) {
                            $('#createdKey').val(res.data.api_key)
                            modalCreated.modal('show')
                        } else {
                            Swal.fire('Success', res.message || 'Saved successfully', 'success')
                        }

                        loadData()
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

            $('#btnCopyKey').on('click', function() {
                copyText($('#createdKey').val())
            })

            $('#btnCopyDetailKey').on('click', function() {
                copyText($('#detailKey').val())
            })

            modalForm.on('hidden.bs.modal', function() {
                resetForm()
            })

            loadData()
        })
    </script>
</body>

</html>