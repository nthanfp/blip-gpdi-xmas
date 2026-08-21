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
                            <label class="mb-0">Province</label>
                            <select class="form-control form-control-sm" id="filterProvince">
                                <option value="">All Provinces</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="mb-0">City</label>
                            <select class="form-control form-control-sm" id="filterCity" disabled>
                                <option value="">All Cities</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="mb-0">Search</label>
                            <input type="text" class="form-control form-control-sm" id="search"
                                placeholder="District name..." autocomplete="off">
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <label class="mb-0">Show</label>
                            <div class="d-flex">
                                <select class="form-control form-control-sm mr-1" id="perPage">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                                <button type="button" class="btn px-2 mr-1 btn-sm btn-secondary" id="btnReset">
                                    <i class="fas fa-undo"></i>
                                </button>
                                <button type="button" class="btn px-2 btn-sm btn-primary" id="btnApply">
                                    <i class="fas fa-check"></i>
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
                                <th class="text-nowrap sort-header" data-sort="mst_reg_districtid" role="button">ID <span
                                        class="sort-indicator" data-sort-indicator="mst_reg_districtid"><i
                                            class="fas fa-sort text-secondary"></i></span></th>
                                <th class="text-nowrap sort-header" data-sort="district_name" role="button">District Name <span
                                        class="sort-indicator" data-sort-indicator="district_name"><i
                                            class="fas fa-sort text-secondary"></i></span></th>
                                <th class="text-nowrap sort-header" data-sort="mst_reg_cityid" role="button">City <span
                                        class="sort-indicator" data-sort-indicator="mst_reg_cityid"><i
                                            class="fas fa-sort text-secondary"></i></span></th>
                                <th class="text-nowrap text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Loading...</td>
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
            <div class="modal-dialog modal-md modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modalTitle">New District</h6>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formDistrict">
                            <input type="hidden" name="id" id="recordId" value="">
                            <div class="form-group">
                                <label>Province <span class="text-danger">*</span></label>
                                <select name="mst_reg_provinceid" id="mst_reg_provinceid" class="form-control">
                                    <option value="">-- Select Province --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>City <span class="text-danger">*</span></label>
                                <select name="mst_reg_cityid" id="mst_reg_cityid" class="form-control" disabled>
                                    <option value="">-- Select City --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>District Name <span class="text-danger">*</span></label>
                                <input type="text" name="district_name" id="district_name" class="form-control"
                                    autocomplete="off" maxlength="100">
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
                list: '<?= site_url("activities/region_district/data_list") ?>',
                create: '<?= site_url("activities/region_district/data_new") ?>',
                edit: '<?= site_url("activities/region_district/data_edit") ?>',
                update: '<?= site_url("activities/region_district/data_update") ?>',
                delete: '<?= site_url("activities/region_district/data_delete") ?>',
                provinceOption: '<?= site_url("activities/region_district/data_province_option") ?>',
                cityOption: '<?= site_url("activities/region_district/data_city_option") ?>'
            }

            const state = {
                page: 1,
                perPage: 10,
                search: '',
                sort_by: 'district_name',
                sort_dir: 'ASC',
                cityid: ''
            }

            let provinceMap = {}
            let cityMap = {}

            const modal = $('#modalForm')
            const form = $('#formDistrict')
            const tableBody = $('#tableBody')
            const pagination = $('#pagination')
            const tableInfo = $('#tableInfo')

            const fields = {
                id: $('#recordId'),
                mst_reg_provinceid: $('#mst_reg_provinceid'),
                mst_reg_cityid: $('#mst_reg_cityid'),
                district_name: $('#district_name')
            }

            const escapeHtml = (value) => $('<div>').text(value == null ? '' : String(value)).html()

            const loadProvinces = () => {
                return $.ajax({
                    url: endpoints.provinceOption,
                    type: 'GET',
                    dataType: 'json'
                }).then(function (res) {
                    if (!res.success || !res.data) return
                    provinceMap = {}
                    const filterSelect = $('#filterProvince')
                    const formSelect = fields.mst_reg_provinceid

                    filterSelect.find('option:gt(0)').remove()
                    formSelect.find('option:gt(0)').remove()

                    res.data.forEach(function (item) {
                        provinceMap[item.value] = item.label
                        filterSelect.append(`<option value="${escapeHtml(item.value)}">${escapeHtml(item.label)}</option>`)
                        formSelect.append(`<option value="${escapeHtml(item.value)}">${escapeHtml(item.label)}</option>`)
                    })
                })
            }

            const loadCities = (provinceid, target) => {
                if (!provinceid) {
                    target.find('option:gt(0)').remove()
                    target.prop('disabled', true)
                    return $.Deferred().resolve()
                }

                return $.ajax({
                    url: endpoints.cityOption,
                    type: 'POST',
                    dataType: 'json',
                    data: { provinceid: provinceid }
                }).then(function (res) {
                    cityMap = {}
                    target.find('option:gt(0)').remove()

                    if (res.success && res.data) {
                        res.data.forEach(function (item) {
                            cityMap[item.value] = item.label
                            target.append(`<option value="${escapeHtml(item.value)}">${escapeHtml(item.label)}</option>`)
                        })
                        target.prop('disabled', false)
                    } else {
                        target.prop('disabled', true)
                    }
                })
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

            const resetForm = () => {
                form[0].reset()
                fields.id.val('')
                fields.mst_reg_cityid.prop('disabled', true).find('option:gt(0)').remove()
                $('#modalTitle').text('New District')
            }

            const renderRows = (rows) => {
                if (!rows || !rows.length) {
                    tableBody.html('<tr><td colspan="4" class="text-center text-muted py-4">No data found</td></tr>')
                    return
                }

                const html = rows.map((row) => `
                    <tr>
                        <td class="d-none">${escapeHtml(row.mst_reg_districtid)}</td>
                        <td class="text-nowrap">${escapeHtml(row.mst_reg_districtid)}</td>
                        <td class="text-nowrap">${escapeHtml(row.district_name)}</td>
                        <td class="text-nowrap">${escapeHtml(cityMap[row.mst_reg_cityid] || row.mst_reg_cityid)}</td>
                        <td class="text-nowrap text-right">
                            <button type="button" class="btn btn-xs btn-outline-primary btn-edit" data-id="${escapeHtml(row.mst_reg_districtid)}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-outline-danger btn-delete" data-id="${escapeHtml(row.mst_reg_districtid)}" data-name="${escapeHtml(row.district_name)}">
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

                const addPage = (page, label, active, disabled) => {
                    items.push(`<li class="page-item ${active ? 'active' : ''} ${disabled ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${page}">${label || page}</a></li>`)
                }

                const addEllipsis = () => {
                    items.push('<li class="page-item disabled"><span class="page-link">...</span></li>')
                }

                addPage(1, '1', currentPage === 1, false)

                const start = Math.max(2, currentPage - 1)
                const end = Math.min(totalPages - 1, currentPage + 1)

                if (start > 2) addEllipsis()

                for (let i = start; i <= end; i++) {
                    addPage(i, String(i), i === currentPage, false)
                }

                if (end < totalPages - 1) addEllipsis()

                if (totalPages > 1) {
                    addPage(totalPages, String(totalPages), currentPage === totalPages, false)
                }

                items.unshift('<li class="page-item' + (currentPage === 1 ? ' disabled' : '') + '"><a class="page-link" href="#" data-page="' + (currentPage - 1) + '">Prev</a></li>')
                items.push('<li class="page-item' + (currentPage === totalPages ? ' disabled' : '') + '"><a class="page-link" href="#" data-page="' + (currentPage + 1) + '">Next</a></li>')

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
                        sort_by: state.sort_by,
                        sort_dir: state.sort_dir,
                        cityid: state.cityid
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
                modal.modal('show')
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

            $('#btnApply').on('click', function () {
                state.page = 1
                state.search = $('#search').val().trim()
                state.perPage = parseInt($('#perPage').val(), 10) || 10
                state.cityid = $('#filterCity').val()
                loadData()
            })

            $('#btnReset').on('click', function () {
                $('#search').val('')
                $('#perPage').val('10')
                $('#filterProvince').val('')
                $('#filterCity').val('').prop('disabled', true).find('option:gt(0)').remove()
                state.page = 1
                state.perPage = 10
                state.search = ''
                state.cityid = ''
                loadData()
            })

            $('#filterProvince').on('change', function () {
                const provinceid = $(this).val()
                state.cityid = ''
                $('#filterCity').val('')
                loadCities(provinceid, $('#filterCity'))
            })

            $('#pagination').on('click', '.page-link', function (e) {
                e.preventDefault()
                const page = parseInt($(this).data('page'), 10)
                if (!page || $(this).closest('.page-item').hasClass('disabled') || $(this).closest('.page-item').hasClass('active')) return
                state.page = page
                loadData()
            })

            fields.mst_reg_provinceid.on('change', function () {
                const provinceid = $(this).val()
                fields.mst_reg_cityid.val('')
                loadCities(provinceid, fields.mst_reg_cityid)
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
                            Swal.fire('Error', res.message || 'Failed to load district', 'error')
                            return
                        }
                        const data = res.data || {}
                        fields.id.val(data.mst_reg_districtid || '')
                        fields.district_name.val(data.district_name || '')

                        const provinceid = data.mst_reg_provinceid || ''
                        const cityid = data.mst_reg_cityid || ''

                        fields.mst_reg_provinceid.val(provinceid)
                        loadCities(provinceid, fields.mst_reg_cityid).then(function () {
                            fields.mst_reg_cityid.val(cityid)
                        })

                        $('#modalTitle').text('Edit District')
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
                const name = $(this).data('name')

                Swal.fire({
                    title: 'Delete this district?',
                    text: name,
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
                            $('input, select, textarea, button').prop('disabled', true);
                            $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' });
                        },
                        success: function (response) {
                            if (!response.success) {
                                Swal.fire('Error', response.message || 'Failed to delete district', 'error')
                                return
                            }
                            Swal.fire('Success', response.message || 'District deleted successfully', 'success')
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

            $('#btnSave').on('click', function () {
                const payload = {
                    id: fields.id.val(),
                    mst_reg_cityid: fields.mst_reg_cityid.val(),
                    district_name: fields.district_name.val().trim()
                }

                if (!payload.mst_reg_cityid) {
                    Swal.fire('Error', 'City is required', 'error')
                    return
                }

                if (!payload.district_name) {
                    Swal.fire('Error', 'District name is required', 'error')
                    return
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
                            Swal.fire('Error', res.message || 'Failed to save district', 'error')
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

            loadProvinces().then(function () {
                loadData()
            })
        })
    </script>
</body>

</html>
