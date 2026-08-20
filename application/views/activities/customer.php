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
                        <button type="button" class="btn btn-sm btn-secondary d-none" id="btnAdd">
                            <i class="fas fa-plus mr-1"></i> New
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
                                placeholder="Name, phone, email..." autocomplete="off">
                        </div>
                        <div class="col-12 col-md-4 mb-2">
                            <label class="mb-0">Province</label>
                            <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                id="filterProvince">
                                <option value="">-- ALL --</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 mb-2">
                            <label class="mb-0">City</label>
                            <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                id="filterCity">
                                <option value="">-- ALL --</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 mb-2">
                            <label class="mb-0">District</label>
                            <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                id="filterDistrict">
                                <option value="">-- ALL --</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 mb-2">
                            <label class="mb-0">Village</label>
                            <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                id="filterVillage">
                                <option value="">-- ALL --</option>
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
                                <th class="text-nowrap sort-header" data-sort="custname" role="button">Customer Name
                                    <span class="sort-indicator" data-sort-indicator="custname"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="phone_number" role="button">Phone Number
                                    <span class="sort-indicator" data-sort-indicator="phone_number"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="email" role="button">Email <span
                                        class="sort-indicator" data-sort-indicator="email"><i
                                            class="fas fa-sort text-secondary"></i></span></th>
                                <th class="text-nowrap sort-header" data-sort="province_name" role="button">Province
                                    <span class="sort-indicator" data-sort-indicator="province_name"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="city_name" role="button">City <span
                                        class="sort-indicator" data-sort-indicator="city_name"><i
                                            class="fas fa-sort text-secondary"></i></span></th>
                                <th class="text-nowrap sort-header" data-sort="district_name" role="button">District
                                    <span class="sort-indicator" data-sort-indicator="district_name"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="d-none text-nowrap sort-header" data-sort="village_name" role="button">Village <span
                                        class="sort-indicator" data-sort-indicator="village_name"><i
                                            class="fas fa-sort text-secondary"></i></span></th>
                                <th class="text-nowrap sort-header" data-sort="created_date" role="button">Created Date
                                    <span class="sort-indicator" data-sort-indicator="created_date"><i
                                            class="fas fa-sort text-secondary"></i></span>
                                </th>
                                <th class="text-nowrap text-right d-none">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBodyCustomer">
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">Loading...</td>
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
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">New Customer</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formCustomer">
                            <input type="hidden" name="id" id="customerId" value="">

                            <div class="form-group">
                                <label>Customer Name</label>
                                <input type="text" name="custname" id="custname" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="form-group mb-0">
                                <label>Email</label>
                                <input type="email" name="email" id="email" class="form-control" autocomplete="off">
                            </div>

                            <div class="form-row mt-3">
                                <div class="col-12 col-md-12 form-group">
                                    <label>Province</label>
                                    <select name="mst_reg_provinceid" id="mst_reg_provinceid"
                                        class="form-control selectpicker" data-live-search="true">
                                        <option value="">-- Select Province --</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 form-group">
                                    <label>City</label>
                                    <select name="mst_reg_cityid" id="mst_reg_cityid" class="form-control selectpicker"
                                        data-live-search="true">
                                        <option value="">-- Select City --</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 form-group mb-0">
                                    <label>District</label>
                                    <select name="mst_reg_districtid" id="mst_reg_districtid"
                                        class="form-control selectpicker" data-live-search="true">
                                        <option value="">-- Select District --</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 form-group mb-0 d-none">
                                    <label>Village</label>
                                    <select name="mst_reg_villageid" id="mst_reg_villageid"
                                        class="form-control selectpicker" data-live-search="true">
                                        <option value="">-- Select Village --</option>
                                    </select>
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
                list: '<?= site_url("activities/customer/data_list") ?>',
                create: '<?= site_url("activities/customer/data_new") ?>',
                edit: '<?= site_url("activities/customer/data_edit") ?>',
                update: '<?= site_url("activities/customer/data_update") ?>',
                delete: '<?= site_url("activities/customer/data_delete") ?>',
                provinceOptions: '<?= site_url("activities/region/data_option_province") ?>',
                cityOptions: '<?= site_url("activities/region/data_option_city") ?>',
                districtOptions: '<?= site_url("activities/region/data_option_district") ?>',
                villageOptions: '<?= site_url("activities/region/data_option_village") ?>'
            }

            const state = {
                page: 1,
                perPage: 10,
                search: '',
                province: '',
                city: '',
                district: '',
                village: '',
                sort_by: 'created_date',
                sort_dir: 'DESC'
            }

            const modal = $('#modalForm')
            const form = $('#formCustomer')
            const tableBody = $('#tableBodyCustomer')
            const pagination = $('#pagination')
            const tableInfo = $('#tableInfo')
            const filterProvince = $('#filterProvince')
            const filterCity = $('#filterCity')
            const filterDistrict = $('#filterDistrict')
            const filterVillage = $('#filterVillage')
            const fields = {
                id: $('#customerId'),
                custname: $('#custname'),
                phone_number: $('#phone_number'),
                email: $('#email'),
                province: $('#mst_reg_provinceid'),
                city: $('#mst_reg_cityid'),
                district: $('#mst_reg_districtid'),
                village: $('#mst_reg_villageid')
            }

            const escapeHtml = (value) => $('<div>').text(value == null ? '' : String(value)).html()

            const buildPrintQuery = () => {
                const params = []
                if (state.search !== '') params.push(`search=${encodeURIComponent(state.search)}`)
                if (state.province !== '') params.push(`mst_reg_provinceid=${encodeURIComponent(state.province)}`)
                if (state.city !== '') params.push(`mst_reg_cityid=${encodeURIComponent(state.city)}`)
                if (state.district !== '') params.push(`mst_reg_districtid=${encodeURIComponent(state.district)}`)
                if (state.village !== '') params.push(`mst_reg_villageid=${encodeURIComponent(state.village)}`)
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

            const resetForm = () => {
                form[0].reset()
                fields.id.val('')
                $('#modalTitle').text('New Customer')
                fields.province.selectpicker('val', '')
                fields.city.html('<option value="">-- Select City --</option>').selectpicker('refresh')
                fields.district.html('<option value="">-- Select District --</option>').selectpicker('refresh')
                fields.village.html('<option value="">-- Select Village --</option>').selectpicker('refresh')
            }

            const resetFilters = () => {
                filterProvince.selectpicker('val', '')
                filterCity.html('<option value="">-- ALL --</option>').selectpicker('refresh')
                filterDistrict.html('<option value="">-- ALL --</option>').selectpicker('refresh')
                filterVillage.html('<option value="">-- ALL --</option>').selectpicker('refresh')
                state.province = ''
                state.city = ''
                state.district = ''
                state.village = ''
            }

            const setSelectOptions = ($select, placeholder, rows, valueKey, labelKey) => {
                let html = `<option value="">${placeholder}</option>`
                    ; (rows || []).forEach(function (row) {
                        const value = String(row[valueKey] || '')
                        const label = row.display_name || row[labelKey] || value
                        html += `<option value="${escapeHtml(value)}">${escapeHtml(label)}</option>`
                    })
                $select.html(html)
                $select.selectpicker('refresh')
            }

            const loadProvinceOptions = () => {
                return $.ajax({
                    url: endpoints.provinceOptions,
                    type: 'GET',
                    dataType: 'json'
                }).then(function (res) {
                    if (!res.success) return

                    const rows = res.data || []
                    setSelectOptions(fields.province, '-- Select Province --', rows, 'mst_reg_provinceid', 'province_name')
                    setSelectOptions(filterProvince, '-- ALL --', rows, 'mst_reg_provinceid', 'province_name')
                })
            }

            const loadCityOptions = (provinceId, selectedId = '') => {
                fields.city.html('<option value="">-- Select City --</option>')
                fields.district.html('<option value="">-- Select District --</option>')
                fields.village.html('<option value="">-- Select Village --</option>')
                fields.city.selectpicker('refresh')
                fields.district.selectpicker('refresh')
                fields.village.selectpicker('refresh')

                if (!provinceId) return $.Deferred().resolve().promise()

                return $.ajax({
                    url: endpoints.cityOptions,
                    type: 'GET',
                    dataType: 'json',
                    data: { mst_reg_provinceid: provinceId }
                }).then(function (res) {
                    if (!res.success) return

                    const rows = res.data || []
                    setSelectOptions(fields.city, '-- Select City --', rows, 'mst_reg_cityid', 'city_name')
                    if (selectedId) fields.city.selectpicker('val', String(selectedId))
                })
            }

            const loadDistrictOptions = (cityId, selectedId = '') => {
                fields.district.html('<option value="">-- Select District --</option>')
                fields.village.html('<option value="">-- Select Village --</option>')
                fields.district.selectpicker('refresh')
                fields.village.selectpicker('refresh')

                if (!cityId) return $.Deferred().resolve().promise()

                return $.ajax({
                    url: endpoints.districtOptions,
                    type: 'GET',
                    dataType: 'json',
                    data: { mst_reg_cityid: cityId }
                }).then(function (res) {
                    if (!res.success) return

                    const rows = res.data || []
                    setSelectOptions(fields.district, '-- Select District --', rows, 'mst_reg_districtid', 'district_name')
                    if (selectedId) fields.district.selectpicker('val', String(selectedId))
                })
            }

            const loadVillageOptions = (districtId, selectedId = '') => {
                fields.village.html('<option value="">-- Select Village --</option>')
                fields.village.selectpicker('refresh')

                if (!districtId) return $.Deferred().resolve().promise()

                return $.ajax({
                    url: endpoints.villageOptions,
                    type: 'GET',
                    dataType: 'json',
                    data: { mst_reg_districtid: districtId }
                }).then(function (res) {
                    if (!res.success) return

                    const rows = res.data || []
                    setSelectOptions(fields.village, '-- Select Village --', rows, 'mst_reg_villageid', 'village_name')
                    if (selectedId) fields.village.selectpicker('val', String(selectedId))
                })
            }

            const renderRows = (rows) => {
                if (!rows || !rows.length) {
                    tableBody.html('<tr><td colspan="10" class="text-center text-muted py-4">No data found</td></tr>')
                    return
                }

                const html = rows.map((row) => `
                    <tr>
                        <td class="d-none">${escapeHtml(row.mst_customerid)}</td>
                        <td class="text-nowrap">${escapeHtml(row.custname || '-')}</td>
                        <td class="text-nowrap">${escapeHtml(row.phone_number || '-')}</td>
                        <td class="text-nowrap">${escapeHtml(row.email || '-')}</td>
                        <td class="text-nowrap">${escapeHtml(row.province_name || '-')}</td>
                        <td class="text-nowrap">${escapeHtml(row.city_name || '-')}</td>
                        <td class="text-nowrap">${escapeHtml(row.district_name || '-')}</td>
                        <td class="text-nowrap d-none">${escapeHtml(row.village_name || '-')}</td>
                        <td class="text-nowrap">${escapeHtml(row.created_date || row.created_at || '-')}</td>
                        <td class="text-nowrap text-right d-none">
                            <button type="button" class="btn btn-xs btn-primary btn-edit" data-id="${escapeHtml(row.mst_customerid)}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-danger btn-delete" data-id="${escapeHtml(row.mst_customerid)}" data-name="${escapeHtml(row.custname || '')}">
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
                        mst_reg_provinceid: state.province,
                        mst_reg_cityid: state.city,
                        mst_reg_districtid: state.district,
                        mst_reg_villageid: state.village,
                        sort_by: state.sort_by,
                        sort_dir: state.sort_dir
                    },
                    beforeSend: function () {
                        $('input, select, textarea, button').prop('disabled', true);
                        $.LoadingOverlay('show', { background: 'rgba(0, 0, 0, 0.25)' });
                    },
                    success: function (res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load customer data', 'error')
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
                            Swal.fire('Error', res.message || 'Failed to load customer data', 'error')
                            return
                        }

                        const item = res.data || {}
                        fields.id.val(item.mst_customerid || '')
                        fields.custname.val(item.custname || '')
                        fields.phone_number.val(item.phone_number || '')
                        fields.email.val(item.email || '')
                        $('#modalTitle').text('Edit Customer')
                        modal.modal('show')
                        const provinceId = item.mst_reg_provinceid || ''
                        const cityId = item.mst_reg_cityid || ''
                        const districtId = item.mst_reg_districtid || ''
                        const villageId = item.mst_reg_villageid || ''

                        fields.province.selectpicker('val', provinceId)
                        loadCityOptions(provinceId, cityId).then(function () {
                            return loadDistrictOptions(cityId, districtId)
                        }).then(function () {
                            return loadVillageOptions(districtId, villageId)
                        })
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

            $('#btnAdd').on('click', openCreateModal)

            $('#btnApply').on('click', function () {
                state.page = 1
                state.search = $('#search').val().trim()
                state.province = filterProvince.val()
                state.city = filterCity.val()
                state.district = filterDistrict.val()
                state.village = filterVillage.val()
                state.perPage = parseInt($('#perPage').val(), 10) || 10
                loadData()
            })

            $('#btnReset').on('click', function () {
                $('#search').val('')
                $('#perPage').val('10')
                resetFilters()
                state.page = 1
                state.perPage = 10
                state.search = ''
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

            $(document).on('click', '.btn-edit', function () {
                openEditModal($(this).data('id'))
            })

            $(document).on('click', '.btn-delete', function () {
                const id = $(this).data('id')
                const name = $(this).data('name')

                Swal.fire({
                    title: 'Delete this customer?',
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
                                Swal.fire('Error', response.message || 'Failed to delete customer', 'error')
                                return
                            }

                            Swal.fire('Success', response.message || 'Customer deleted successfully', 'success')
                            loadData()
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
                })
            })

            $('#btnSave').on('click', function () {
                const payload = {
                    id: fields.id.val(),
                    custname: fields.custname.val(),
                    phone_number: fields.phone_number.val(),
                    email: fields.email.val(),
                    mst_reg_provinceid: fields.province.val(),
                    mst_reg_cityid: fields.city.val(),
                    mst_reg_districtid: fields.district.val(),
                    mst_reg_villageid: fields.village.val()
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
                            Swal.fire('Error', res.message || 'Failed to save customer', 'error')
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
                        $('input, select, textarea, button').prop('disabled', false);
                        $.LoadingOverlay('hide');
                    }
                })
            })

            $('#btnPrint').on('click', function () {
                const query = buildPrintQuery()
                const url = '<?= site_url("activities/customer/data_print") ?>' + (query ? `?${query}` : '')
                openReportUrl(url)
            })

            $('#btnExport').on('click', function () {
                const query = buildPrintQuery()
                const timestamp = getTimestamp()
                const filename = `customer_${timestamp}`
                const url = '<?= site_url("activities/customer/data_printhtml") ?>/' + filename + '/1' + (query ? `?${query}` : '')
                openReportUrl(url)
            })

            modal.on('hidden.bs.modal', function () {
                resetForm()
            })

            fields.province.on('changed.bs.select change', function () {
                const provinceId = $(this).val()
                loadCityOptions(provinceId)
            })

            fields.city.on('changed.bs.select change', function () {
                const cityId = $(this).val()
                loadDistrictOptions(cityId)
            })

            fields.district.on('changed.bs.select change', function () {
                const districtId = $(this).val()
                loadVillageOptions(districtId)
            })

            filterProvince.on('changed.bs.select change', function () {
                const provinceId = $(this).val()
                state.province = provinceId
                state.city = ''
                state.district = ''
                state.village = ''
                filterCity.selectpicker('val', '')
                filterDistrict.selectpicker('val', '')
                filterVillage.selectpicker('val', '')
                loadCityOptions(provinceId)
                if (provinceId) {
                    $.ajax({
                        url: endpoints.cityOptions,
                        type: 'GET',
                        dataType: 'json',
                        data: { mst_reg_provinceid: provinceId }
                    }).then(function (res) {
                        if (!res.success) return
                        setSelectOptions(filterCity, '-- ALL --', res.data || [], 'mst_reg_cityid', 'city_name')
                    })
                } else {
                    filterCity.html('<option value="">-- ALL --</option>').selectpicker('refresh')
                    filterDistrict.html('<option value="">-- ALL --</option>').selectpicker('refresh')
                    filterVillage.html('<option value="">-- ALL --</option>').selectpicker('refresh')
                }
            })

            filterCity.on('changed.bs.select change', function () {
                const cityId = $(this).val()
                state.city = cityId
                state.district = ''
                state.village = ''
                filterDistrict.selectpicker('val', '')
                filterVillage.selectpicker('val', '')
                loadDistrictOptions(cityId)
                if (cityId) {
                    $.ajax({
                        url: endpoints.districtOptions,
                        type: 'GET',
                        dataType: 'json',
                        data: { mst_reg_cityid: cityId }
                    }).then(function (res) {
                        if (!res.success) return
                        setSelectOptions(filterDistrict, '-- ALL --', res.data || [], 'mst_reg_districtid', 'district_name')
                    })
                } else {
                    filterDistrict.html('<option value="">-- ALL --</option>').selectpicker('refresh')
                    filterVillage.html('<option value="">-- ALL --</option>').selectpicker('refresh')
                }
            })

            filterDistrict.on('changed.bs.select change', function () {
                const districtId = $(this).val()
                state.district = districtId
                state.village = ''
                filterVillage.selectpicker('val', '')
                loadVillageOptions(districtId)
                if (districtId) {
                    $.ajax({
                        url: endpoints.villageOptions,
                        type: 'GET',
                        dataType: 'json',
                        data: { mst_reg_districtid: districtId }
                    }).then(function (res) {
                        if (!res.success) return
                        setSelectOptions(filterVillage, '-- ALL --', res.data || [], 'mst_reg_villageid', 'village_name')
                    })
                } else {
                    filterVillage.html('<option value="">-- ALL --</option>').selectpicker('refresh')
                }
            })

            filterVillage.on('changed.bs.select change', function () {
                state.village = $(this).val()
            })

            loadProvinceOptions().always(function () {
                filterProvince.selectpicker('refresh')
                filterCity.selectpicker('refresh')
                filterDistrict.selectpicker('refresh')
                filterVillage.selectpicker('refresh')
                loadData()
            })
        })
    </script>
</body>

</html>