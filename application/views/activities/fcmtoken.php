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
                        <button type="button" class="btn btn-sm btn-danger mr-1" id="btnPrint" disabled>
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button type="button" class="btn btn-sm btn-success" id="btnExport" disabled>
                            <i class="fas fa-file-export"></i> Export
                        </button>
                    </div>
                    <div>
                        <span class="text-muted text-xs">FCM Tokens</span>
                    </div>
                </div>
            </div>

            <div class="card card-outline card-secondary mb-0">
                <div class="card-body py-2 px-2 border-bottom">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-2">
                            <label class="mb-0">Search</label>
                            <input type="text" class="form-control form-control-sm" id="search"
                                placeholder="username/token/user agent..." autocomplete="off">
                        </div>
                        <div class="col-6 col-md-2 mb-2">
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
                                <th>Admin</th>
                                <th>FCM Token</th>
                                <th>User Agent</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
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

        <?php $this->load->view('partial/activities/footer.php') ?>
    </div>

    <?php $this->load->view('partial/activities/foot.php') ?>

    <script>
        $(function() {
            const endpoints = {
                list: '<?= site_url("activities/fcmtoken/data_list") ?>',
                delete: '<?= site_url("activities/fcmtoken/data_delete") ?>'
            }

            const state = {
                page: 1,
                perPage: 10,
                search: ''
            }

            const tableBody = $('#tableBody')
            const pagination = $('#pagination')
            const tableInfo = $('#tableInfo')

            const escapeHtml = (value) => $('<div>').text(value == null ? '' : String(value)).html()

            const formatDate = (value) => {
                if (!value) return '-'
                const d = new Date(value)
                if (isNaN(d)) return value
                const pad = (n) => String(n).padStart(2, '0')
                return `${pad(d.getDate())} ${d.toLocaleString('en-US', { month: 'short' })} ${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}`
            }

            const truncateToken = (token) => {
                if (!token) return '-'
                return token.length > 48 ? token.substring(0, 48) + '...' : token
            }

            const truncateUA = (ua) => {
                if (!ua) return '-'
                return ua.length > 64 ? ua.substring(0, 64) + '...' : ua
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
                            Swal.fire('Error', res.message || 'Failed to load token data', 'error')
                            return
                        }

                        const rows = res.data || []
                        const pag = res.pagination || {}

                        if (!rows.length) {
                            tableBody.html('<tr><td colspan="7" class="text-center text-muted py-4">No data found</td></tr>')
                        } else {
                            const html = rows.map((row) => `
                                <tr>
                                    <td class="d-none">${escapeHtml(row.id)}</td>
                                    <td><strong>${escapeHtml(row.username || '-')}</strong></td>
                                    <td><code style="font-size: 11px;">${escapeHtml(truncateToken(row.fcm_token))}</code></td>
                                    <td style="max-width: 200px; word-break: break-word; font-size: 11px;">${escapeHtml(truncateUA(row.user_agent))}</td>
                                    <td>${escapeHtml(formatDate(row.created_date))}</td>
                                    <td>${escapeHtml(formatDate(row.updated_date))}</td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-outline-danger btn-delete" data-id="${escapeHtml(row.id)}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `).join('')
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

            $(document).on('click', '.btn-delete', function() {
                const id = $(this).data('id')

                Swal.fire({
                    title: 'Delete this token?',
                    text: 'This will remove the FCM token and the admin will stop receiving push notifications',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Delete'
                }).then(function(res) {
                    if (!res.isConfirmed) return

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
                                Swal.fire('Error', response.message || 'Failed to delete token', 'error')
                                return
                            }
                            Swal.fire('Success', response.message || 'Token deleted successfully', 'success')
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

            loadData()
        })
    </script>
</body>

</html>