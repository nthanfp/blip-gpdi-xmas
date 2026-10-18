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
                        <span class="text-muted font-italic">FAQ untuk section Pertanyaan Umum di landing page</span>
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
                        <div class="col-6 col-md-6 mb-1">
                            <label class="mb-0">Search</label>
                            <input type="text" class="form-control form-control-sm" id="search"
                                placeholder="question/answer..." autocomplete="off">
                        </div>
                        <div class="col-6 col-md-2 mb-1">
                            <label class="mb-0">Show</label>
                            <select class="form-control form-control-sm" id="perPage">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
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
                                <th>Question</th>
                                <th style="width: 70px;">Sort</th>
                                <th style="width: 90px;">Status</th>
                                <th>Modified</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBodyFaq">
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
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">New FAQ</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formFaq">
                            <input type="hidden" name="faq_id" id="set_faqid" value="">

                            <div class="form-group">
                                <label>Question <span class="text-danger">*</span></label>
                                <input type="text" name="question" id="question" class="form-control" autocomplete="off" placeholder="e.g. Apakah acara ini gratis?">
                            </div>

                            <div class="form-group">
                                <label>Answer <span class="text-danger">*</span></label>
                                <textarea name="answer" id="answer" class="form-control" autocomplete="off" placeholder="Jawaban yang tampil di accordion landing" rows="4"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Sort Order</label>
                                        <input type="number" name="sort_order" id="sort_order" class="form-control" min="0" step="1" value="0">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <div class="form-check">
                                            <input type="checkbox" name="suspended" id="suspended" class="form-check-input" value="1">
                                            <label class="form-check-label" for="suspended">Sembunyikan dari landing</label>
                                        </div>
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
        $(function() {
            const endpoints = {
                list: '<?= site_url("activities/faq/data_list") ?>',
                create: '<?= site_url("activities/faq/data_new") ?>',
                edit: '<?= site_url("activities/faq/data_edit") ?>',
                update: '<?= site_url("activities/faq/data_update") ?>',
                delete: '<?= site_url("activities/faq/data_delete") ?>'
            }

            const state = {
                page: 1,
                perPage: 10,
                search: ''
            }

            const modal = $('#modalForm')
            const form = $('#formFaq')
            const tableBody = $('#tableBodyFaq')
            const pagination = $('#pagination')
            const tableInfo = $('#tableInfo')

            const fields = {
                id: $('#set_faqid'),
                question: $('#question'),
                answer: $('#answer'),
                sort_order: $('#sort_order'),
                suspended: $('#suspended')
            }

            const escapeHtml = (value) => $('<div>').text(value == null ? '' : String(value)).html()

            const formatDate = (value) => {
                if (!value) return '-'
                const d = new Date(value)
                if (isNaN(d)) return value
                const pad = (n) => String(n).padStart(2, '0')
                return `${pad(d.getDate())} ${d.toLocaleString('en-US', { month: 'short' })} ${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}`
            }

            const resetForm = () => {
                form[0].reset()
                fields.id.val('')
                fields.sort_order.val('0')
                fields.suspended.prop('checked', false)
                $('#modalTitle').text('New FAQ')
            }

            const renderRows = (rows) => {
                if (!rows || !rows.length) {
                    tableBody.html('<tr><td colspan="6" class="text-center text-muted py-4">No data found</td></tr>')
                    return
                }

                const html = rows.map((row) => `
                    <tr>
                        <td class="d-none">${escapeHtml(row.set_faqid)}</td>
                        <td style="max-width: 340px; word-break: break-word;">${escapeHtml(row.question)}</td>
                        <td>${escapeHtml(row.sort_order)}</td>
                        <td>${Number(row.suspended) === 1
                            ? '<span class="badge badge-secondary">Hidden</span>'
                            : '<span class="badge badge-success">Active</span>'}</td>
                        <td>${escapeHtml(formatDate(row.modified_date || row.created_date))}</td>
                        <td class="text-right">
                            <button type="button" class="btn btn-xs btn-outline-primary btn-edit" data-id="${escapeHtml(row.set_faqid)}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-outline-danger btn-delete" data-id="${escapeHtml(row.set_faqid)}" data-name="${escapeHtml(row.question)}">
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
                        search: state.search
                    },
                    beforeSend: function() {
                        $('input, select, textarea, button').prop('disabled', true);
                        $.LoadingOverlay('show', {
                            background: 'rgba(0, 0, 0, 0.25)'
                        });
                    },
                    success: function(res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load FAQ data', 'error')
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
                            Swal.fire('Error', res.message || 'Failed to load FAQ', 'error')
                            return
                        }

                        const item = res.data || {}
                        fields.id.val(item.set_faqid || '')
                        fields.question.val(item.question || '')
                        fields.answer.val(item.answer || '')
                        fields.sort_order.val(item.sort_order || 0)
                        fields.suspended.prop('checked', Number(item.suspended) === 1)
                        $('#modalTitle').text('Edit FAQ')
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
                state.perPage = parseInt($('#perPage').val(), 10) || 10
                loadData()
            })

            $('#btnReset').on('click', function() {
                $('#search').val('')
                $('#perPage').val('10')
                state.page = 1
                state.perPage = 10
                state.search = ''
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
                    title: 'Delete this FAQ?',
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
                                Swal.fire('Error', response.message || 'Failed to delete FAQ', 'error')
                                return
                            }

                            Swal.fire('Success', response.message || 'FAQ deleted successfully', 'success')
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
                const payload = {
                    id: fields.id.val(),
                    question: fields.question.val(),
                    answer: fields.answer.val(),
                    sort_order: fields.sort_order.val(),
                    suspended: fields.suspended.is(':checked') ? 1 : 0
                }

                if (!payload.question.trim()) {
                    Swal.fire('Validation', 'Question is required', 'warning')
                    return
                }
                if (!payload.answer.trim()) {
                    Swal.fire('Validation', 'Answer is required', 'warning')
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
                            Swal.fire('Error', res.message || 'Failed to save FAQ', 'error')
                            return
                        }

                        Swal.fire('Success', res.message || 'Saved successfully', 'success')
                        modal.modal('hide')
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

            modal.on('hidden.bs.modal', function() {
                resetForm()
            })

            loadData()
        })
    </script>
</body>

</html>
