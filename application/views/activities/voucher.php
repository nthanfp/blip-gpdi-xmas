<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('partial/activities/head.php') ?>

    <style type="text/css">
        .table-bulk {
            width: 100%;
            table-layout: fixed;
        }

        .table-bulk th,
        .table-bulk td {
            vertical-align: top;
        }

        .table-bulk th:nth-child(1),
        .table-bulk td:nth-child(1) {
            width: auto;
        }

        .table-bulk th:nth-child(2),
        .table-bulk td:nth-child(2) {
            width: 120px;
        }

        .table-bulk th:nth-child(3),
        .table-bulk td:nth-child(3) {
            width: 70px;
            white-space: nowrap;
        }

        .bulk-qty {
            width: 100% !important;
        }

        .no-select {
            pointer-events: none;
            background-color: #e9ecef;
        }

        .bootstrap-select.disabled>.dropdown-toggle,
        .bootstrap-select>.dropdown-toggle.disabled {
            background-color: #e9ecef !important;
            color: #495057 !important;
            opacity: 1 !important;
        }

        .bootstrap-select.disabled>.dropdown-toggle,
        .bootstrap-select>.dropdown-toggle.disabled {
            background-color: #e9ecef !important;
            color: #495057 !important;
            opacity: 1 !important;
        }

        .btn.disabled,
        .btn:disabled {
            pointer-events: none;
        }
    </style>
</head>

<body class="sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">
        <?php $this->load->view('partial/activities/sidebar.php') ?>

        <div class="content-wrapper pt-4 pb-2 px-4 text-sm">
            <div class="row mb-2">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        <button type="button" class="btn btn-sm btn-danger mr-1 disabled d-none" id="btnPrint" disabled>
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success" id="btnExport">
                            <i class="fas fa-file-export"></i> Export
                        </button>
                        <button type="button" class="btn btn-info btn-sm d-none" onclick="downloadQRZip()">
                            <i class="fas fa-qrcode mr-1"></i>
                            Download QR ZIP
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-secondary mr-1" id="btnGetBulkCode">
                            <i class="fas fa-code mr-1"></i> Get Bulk Code
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary mr-1" id="btnBulkAdd">
                            <i class="fas fa-clone mr-1"></i> Bulk Create
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary d-none" id="btnAdd">
                            <i class="fas fa-plus mr-1"></i> New
                        </button>
                    </div>
                </div>
            </div>
            <div class="card card-outline card-secondary mb-3">
                <div class="card-body py-2 px-2 border-bottom">
                    <div class="row">
                        <div class="col-12 col-md-4 mb-2">
                            <label class="mb-0">Voucher Code</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-sm" id="search" placeholder="Voucher Code or Key" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-2">
                            <label class="mb-0">Item Gift</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-gift"></i></span>
                                </div>
                                <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                    id="filterItemgift">
                                    <option value="" selected>-- ALL --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 mb-2">
                            <label class="mb-0">Item Gift Type</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                </div>
                                <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                    id="filterItemgiftType">
                                    <option value="" selected>-- ALL --</option>
                                    <option value="1">POINT</option>
                                    <option value="2">OTHER</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <label class="mb-0">Status</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-folder-open"></i></span>
                                </div>
                                <select class="form-control form-control-sm" id="filterStatus">
                                    <option value="">-- ALL --</option>
                                    <option value="available" selected>AVAILABLE</option>
                                    <option value="redeemed">REDEEMED</option>
                                    <option value="completed">COMPLETED</option>
                                    <option value="rejected">REJECTED</option>
                                    <option value="expired">EXPIRED</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="mb-0">Bulk Code</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                </div>
                                <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                    id="filterBulkCode">
                                    <option value="" selected>-- ALL --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <label class="mb-0">Bulk Sequence</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-list-ol"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-sm" id="filterBulkSeq"
                                    placeholder="Bulk Sequence" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <label class="mb-0">Show</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-table"></i></span>
                                </div>
                                <select class="form-control form-control-sm" id="perPage">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2 mt-1">
                            <label class="mb-0 d-none d-md-none">&nbsp;</label>
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
                                <th class="text-nowrap sort-header" data-sort="voucher_code" role="button">
                                    Voucher Code
                                    <span class="sort-indicator" data-sort-indicator="voucher_code">
                                        <i class="fas fa-sort text-secondary ml-1"></i>
                                    </span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="itemname" role="button">
                                    Item Gift Name
                                    <span class="sort-indicator" data-sort-indicator="itemname"><i
                                            class="fas fa-sort text-secondary ml-1"></i>
                                    </span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="status" role="button">
                                    Status
                                    <span class="sort-indicator" data-sort-indicator="status"><i
                                            class="fas fa-sort text-secondary ml-1"></i>
                                    </span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="created_date" role="button">
                                    Created Date
                                    <span class="sort-indicator" data-sort-indicator="created_date"><i
                                            class="fas fa-sort text-secondary ml-1"></i>
                                    </span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="expired_date" role="button">
                                    Expired Date
                                    <span class="sort-indicator" data-sort-indicator="expired_date"><i
                                            class="fas fa-sort text-secondary ml-1"></i>
                                    </span>
                                </th>
                                <th class="text-nowrap sort-header" data-sort="redeemed_date" role="button">
                                    Redeemed Date
                                    <span class="sort-indicator" data-sort-indicator="redeemed_date"><i
                                            class="fas fa-sort text-secondary ml-1"></i>
                                    </span>
                                </th>
                                <th class="text-nowrap text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBodyVoucher">
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
            <div class="row mb-0">
                <div class="col-12">
                    <div class="text-muted font-italic">
                        <span class="d-inline-flex align-items-center mr-2 mb-1">
                            <span class="d-inline-block rounded-sm mr-1 bg-success" style="width:20px;height:14px;"></span> Available
                        </span>
                        <span class="d-inline-flex align-items-center mr-2 mb-1">
                            <span class="d-inline-block rounded-sm mr-1 bg-warning" style="width:20px;height:14px;"></span> Redeemed
                        </span>
                        <span class="d-inline-flex align-items-center mr-2 mb-1">
                            <span class="d-inline-block rounded-sm mr-1 bg-primary" style="width:20px;height:14px;"></span> Completed
                        </span>
                        <span class="d-inline-flex align-items-center mr-2 mb-1">
                            <span class="d-inline-block rounded-sm mr-1 bg-danger" style="width:20px;height:14px;"></span> Rejected
                        </span>
                        <span class="d-inline-flex align-items-center mr-2 mb-1">
                            <span class="d-inline-block rounded-sm mr-1 bg-secondary" style="width:20px;height:14px;"></span> Expired
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modalTitle">New Voucher</h6>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formVoucher">
                            <input type="hidden" name="id" id="mst_voucherid" value="">

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Voucher Code <span class="text-danger">*</span></label>
                                    <input type="text" name="voucher_code" id="voucher_code" class="form-control"
                                        autocomplete="off">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Item Gift <span class="text-danger">*</span></label>
                                    <select name="mst_itemgiftid" id="mst_itemgiftid" class="form-control selectpicker"
                                        data-live-search="true">
                                        <option value="">Select item gift</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" selected>CREATED</option>
                                        <option value="3">REDEEMED</option>
                                        <option value="4">COMPLETED</option>
                                        <option value="5">REJECTED</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Expired Date</label>
                                    <input type="date" name="expired_date" id="expired_date"
                                        class="form-control">
                                </div>
                                <div class="form-group col-md-4 d-none">
                                    <label>Redeemed Date</label>
                                    <input type="date" name="redeemed_date" id="redeemed_date" class="form-control">
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

        <div class="modal fade" id="modalBulkForm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modalBulkTitle">Bulk Create Voucher</h6>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formVoucherBulk">
                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <label>Voucher Code Prefix </label>
                                    <input type="text" name="bulk_prefix" id="bulk_prefix" class="form-control"
                                        autocomplete="off" placeholder="Optional prefix">
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Expired Date</label>
                                    <input type="date" name="bulk_expired_date" id="bulk_expired_date"
                                        class="form-control">
                                </div>
                                <div class="form-group col-12 col-md-4 d-none">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="bulk_status" id="bulk_status" class="form-control">
                                        <option value="1" selected>CREATED</option>
                                        <!-- <option value="2" disabled>PRINTED</option> -->
                                        <option value="3" disabled>REDEEMED</option>
                                        <option value="4" disabled>COMPLETED</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="text-muted font-italic">Add multiple item gift rows and set quantity for
                                    each row.</div>
                                <button type="button" class="btn btn-sm btn-outline-primary mx-2" id="btnAddBulkRow">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm table-borderless table-bulk mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Item Gift <span class="text-danger">*</span></th>
                                            <th width="60px;">Qty <span class="text-danger">*</span></th>
                                            <th width="100px;" class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bulkRows">
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-3">No rows added</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <span class="text-muted mr-auto" id="bulkTotalQty">Total: 0 vouchers</span>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="btnBulkSave">
                            <i class="fas fa-save"></i> Save Bulk
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalGetBulkCode" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h6 class="modal-title" id="modalGetBulkCodeTitle">
                            Get Bulk Code
                        </h6>

                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="table-responsive">
                            <table class="table table-hover table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Bulk Code</th>
                                        <th style="width: 180px;">Created</th>
                                        <th style="width: 130px;" class="text-center"> Voucher</th>
                                    </tr>
                                </thead>

                                <tbody id="bulkCodeTableBody">
                                </tbody>
                            </table>
                        </div>

                        <div id="bulkCodeEmpty"
                            class="text-center text-muted py-5 d-none">
                            No bulk code available.
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <?php $this->load->view('partial/activities/footer.php') ?>
    </div>

    <?php $this->load->view('partial/activities/foot.php') ?>

    <script type="text/javascript">
        function downloadQRZip() {
            const params = new URLSearchParams({
                search: $('#search').val(),
                mst_itemgiftid: $('#filterItemgift').val(),
                itemgiftType: $('#filterItemgiftType').val(),
                status: $('#filterStatus').val(),
                bulk_code: $('#filterBulkCode').val(),
                bulk_seq: $('#filterBulkSeq').val()
            });
            window.open(
                '<?php echo base_url('activities/voucher/download_qr_zip') ?>?' + params.toString(),
                '_blank'
            );
        }

        $(function() {
            const endpoints = {
                list: '<?= site_url("activities/voucher/data_list") ?>',
                create: '<?= site_url("activities/voucher/data_new") ?>',
                edit: '<?= site_url("activities/voucher/data_edit") ?>',
                update: '<?= site_url("activities/voucher/data_update") ?>',
                delete: '<?= site_url("activities/voucher/data_delete") ?>',
                itemgiftOption: '<?= site_url("activities/voucher/data_option_itemgift") ?>',
                bulkCodeOption: '<?= site_url("activities/voucher/data_option_bulk_code") ?>',
                bulkCreate: '<?= site_url("activities/voucher/data_bulk_new") ?>',
                getBulkCode: '<?= site_url("activities/voucher/data_bulk_list") ?>'
            }

            const state = {
                page: 1,
                perPage: 10,
                search: '',
                mst_itemgiftid: '',
                itemgiftType: '',
                status: 'available',
                bulkCode: '',
                bulkSeq: '',
                sort_by: 'created_date',
                sort_dir: 'DESC'
            }

            const modal = $('#modalForm')
            const bulkModal = $('#modalBulkForm')
            const modalGetBulkCode = $('#modalGetBulkCode')
            const form = $('#formVoucher')
            const bulkForm = $('#formVoucherBulk')
            const tableBody = $('#tableBodyVoucher')
            const pagination = $('#pagination')
            const tableInfo = $('#tableInfo')
            const bulkRows = $('#bulkRows')
            const bulkTotalQty = $('#bulkTotalQty')

            const updateBulkTotalQty = () => {
                let total = 0
                bulkRows.find('.bulk-qty').each(function() {
                    const val = parseFormattedNumber($(this).val())
                    if (!isNaN(val) && val > 0) {
                        total += val
                    }
                })
                bulkTotalQty.text(`Total: ${total.toLocaleString('id-ID')} voucher${total !== 1 ? 's' : ''}`)
            }

            const fields = {
                id: $('#mst_voucherid'),
                voucher_code: $('#voucher_code'),
                mst_itemgiftid: $('#mst_itemgiftid'),
                status: $('#status'),
                expired_date: $('#expired_date'),
                redeemed_date: $('#redeemed_date'),
                payment_reference: $('#payment_reference'),
                payment_attachment: $('#payment_attachment')
            }

            const escapeHtml = (value) => $('<div>').text(value == null ? '' : String(value)).html()

            let disableCounter = 0;
            const disableControls = () => {
                if (disableCounter === 0) {
                    $('input, select, textarea, button').each(function() {
                        $(this).data('orig-disabled', $(this).prop('disabled'))
                    }).prop('disabled', true)
                    $.LoadingOverlay('show', {
                        background: 'rgba(0, 0, 0, 0.25)'
                    })
                }
                disableCounter++;
            }

            const enableControls = () => {
                disableCounter--
                if (disableCounter <= 0) {
                    disableCounter = 0
                    $('input, select, textarea, button').each(function() {
                        $(this).prop('disabled', $(this).data('orig-disabled'))
                    })
                    $.LoadingOverlay('hide')
                }
            }

            const formatNumber = (value) => {
                const num = parseInt(String(value).replace(/[^0-9]/g, ''), 10)
                return isNaN(num) ? '' : num.toLocaleString('id-ID')
            }

            const parseFormattedNumber = (value) => {
                return parseInt(String(value).replace(/[^0-9]/g, ''), 10)
            }

            const buildPrintQuery = () => {
                const params = []

                if (state.search !== '') {
                    params.push(`search=${encodeURIComponent(state.search)}`)
                }

                if (state.mst_itemgiftid !== '' && state.mst_itemgiftid !== null && state.mst_itemgiftid !== undefined) {
                    params.push(`mst_itemgiftid=${encodeURIComponent(state.mst_itemgiftid)}`)
                }

                if (state.status !== '' && state.status !== null && state.status !== undefined) {
                    params.push(`status=${encodeURIComponent(state.status)}`)
                }

                if (state.bulkCode !== '') {
                    params.push(`bulk_code=${encodeURIComponent(state.bulkCode)}`)
                }

                if (state.bulkSeq !== '') {
                    params.push(`bulk_seq=${encodeURIComponent(state.bulkSeq)}`)
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

            const isExpired = (row) => {
                const s = Number(row.status)
                if (s !== 1 && s !== 2) return false
                if (!row.expired_date) return false
                return new Date(row.expired_date) < new Date()
            }

            const getDisplayStatus = (row) => {
                const s = Number(row.status)
                if ((s === 1 || s === 2) && isExpired(row)) return 'expired'
                if (s === 1) return 'available'
                if (s === 2) return 'printed'
                if (s === 3) return 'redeemed'
                if (s === 4) return 'completed'
                if (s === 5) return 'rejected'
                return 'unknown'
            }

            const statusLabel = (value, row) => {
                if (row) {
                    const ds = getDisplayStatus(row)
                    const map = {
                        available: '<span class="badge badge-success">AVAILABLE</span>',
                        printed: '<span class="badge badge-success">PRINTED</span>',
                        redeemed: '<span class="badge badge-warning">REDEEMED</span>',
                        completed: '<span class="badge badge-primary">COMPLETED</span>',
                        rejected: '<span class="badge badge-danger">REJECTED</span>',
                        expired: '<span class="badge badge-secondary">EXPIRED</span>'
                    }
                    return map[ds] || '<span class="badge badge-light">UNKNOWN</span>'
                }
                return '<span class="badge badge-light">UNKNOWN</span>'
            }

            const itemGiftOptions = new Map()
            let bulkRowSeq = 0

            const resetForm = () => {
                form[0].reset()
                fields.id.val('')
                fields.status.val('1')
                fields.expired_date.val('')
                fields.redeemed_date.val('')
                fields.payment_reference.val('')
                fields.payment_attachment.val('')
                fields.mst_itemgiftid.selectpicker('val', '')
                fields.mst_itemgiftid.selectpicker('refresh')
                fields.status.val('1')
                $('#modalTitle').text('New Voucher')
            }

            const renderBulkEmpty = () => {
                bulkRows.html('<tr><td colspan="3" class="text-center text-muted py-3">No rows added</td></tr>')
            }

            const createBulkRow = () => {
                bulkRowSeq += 1
                const rowId = `bulk_row_${bulkRowSeq}`
                const options = ['<option value="">Select item gift</option>']

                itemGiftOptions.forEach(function(label, id) {
                    options.push(`<option value="${escapeHtml(id)}">${escapeHtml(label)}</option>`)
                })

                return `
                    <tr id="${rowId}" data-row="${bulkRowSeq}">
                        <td>
                            <select class="form-control form-control-sm selectpicker bulk-itemgift"
                                data-live-search="true"
                                data-container="body"
                                name="bulk_itemgiftid[]"
                                required>
                                ${options.join('')}
                            </select>
                        </td>
                        <td>
                            <input type="text" inputmode="numeric" class="form-control form-control-sm bulk-qty" name="bulk_qty[]" value="1" required>
                        </td>
                        <td class="text-right">
                            <button type="button" class="btn btn-sm btn-outline-danger btn-bulk-remove" title="Remove row">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `
            }

            const addBulkRow = () => {
                const emptyRow = bulkRows.find('tr td[colspan="3"]').length > 0
                if (emptyRow) {
                    bulkRows.empty()
                }
                const rowHtml = createBulkRow()
                bulkRows.append(rowHtml)

                const $newRow = bulkRows.find('tr').last()
                const $picker = $newRow.find('.bulk-itemgift')
                if ($picker.length) {
                    $picker.selectpicker()
                    $picker.selectpicker('refresh')
                }

                updateBulkTotalQty()
            }

            const resetBulkForm = () => {
                bulkForm[0].reset()
                $('#bulk_prefix').val('')
                $('#bulk_status').val('1')
                $('#bulk_expired_date').val('')
                bulkRowSeq = 0
                renderBulkEmpty()
                $('#bulkRows .bulk-itemgift').selectpicker('destroy')
                updateBulkTotalQty()
            }

            const renderRows = (rows) => {
                if (!rows || !rows.length) {
                    tableBody.html('<tr><td colspan="7" class="text-center text-muted py-4">No data found</td></tr>')
                    return
                }

                const html = rows.map((row) => {
                    const ds = getDisplayStatus(row)
                    const rowColorMap = {
                        available: 'table-success',
                        printed: 'table-success',
                        redeemed: 'table-warning',
                        completed: 'table-primary',
                        rejected: 'table-danger',
                        expired: 'table-secondary'
                    }
                    const rowClass = rowColorMap[ds] || ''
                    return `
                    <tr class="${rowClass}">
                        <td class="text-nowrap d-none">${escapeHtml(row.mst_voucherid)}</td>
                        <td class="text-nowrap">${escapeHtml(row.voucher_code)}</td>
                        <td class="text-nowrap">${escapeHtml(row.itemname || '-')}</td>
                        <td class="text-nowrap">${statusLabel(row.status, row)}</td>
                        <td class="text-nowrap">${escapeHtml(formatDate(row.created_date))}</td>
                        <td class="text-nowrap">${escapeHtml(formatDate(row.expired_date))}</td>
                        <td class="text-nowrap">${escapeHtml(formatDate(row.redeemed_date))}</td>
                        <td class="text-nowrap text-right">
                            <button type="button" class="btn btn-xs btn-primary btn-edit ${Number(row.status) !== 1 || isExpired(row) ? 'disabled' : ''}" data-id="${escapeHtml(row.mst_voucherid)}" ${Number(row.status) !== 1 || isExpired(row) ? 'disabled' : ''}>
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-danger btn-delete ${Number(row.status) !== 1 || isExpired(row) ? 'disabled' : ''}" data-id="${escapeHtml(row.mst_voucherid)}" data-name="${escapeHtml(row.voucher_code)}" ${Number(row.status) !== 1 || isExpired(row) ? 'disabled' : ''}>
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `
                }).join('')

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

            const loadItemGiftOptions = () => {
                return $.ajax({
                    url: endpoints.itemgiftOption,
                    type: 'GET',
                    dataType: 'json'
                }).then(function(res) {
                    if (!res.success) return

                    itemGiftOptions.clear()

                    fields.mst_itemgiftid
                        .empty()
                        .append('<option value="">-- ALL --</option>')

                    $('#filterItemgift')
                        .empty()
                        .append('<option value="">-- ALL --</option>')

                    ;
                    (res.data || []).forEach(function(row) {
                        const id = String(row.mst_itemgiftid)
                        const label = row.display_name || row.itemname || id

                        itemGiftOptions.set(id, label)

                        fields.mst_itemgiftid.append(
                            `<option value="${escapeHtml(id)}">${escapeHtml(label)}</option>`
                        )

                        $('#filterItemgift').append(
                            `<option value="${escapeHtml(id)}">${escapeHtml(label)}</option>`
                        )
                    })

                    fields.mst_itemgiftid.selectpicker('refresh')
                    $('#filterItemgift').selectpicker('refresh')

                    fields.mst_itemgiftid.selectpicker('val', '')
                    $('#filterItemgift').selectpicker('val', '')
                })
            }

            const loadBulkCodeOptions = () => {
                return $.ajax({
                    url: endpoints.bulkCodeOption,
                    type: 'GET',
                    dataType: 'json'
                }).then(function(res) {
                    if (!res.success) return

                    $('#filterBulkCode')
                        .empty()
                        .append('<option value="" selected>-- ALL --</option>')

                    ;
                    (res.data || []).forEach(function(row) {
                        $('#filterBulkCode').append(
                            `<option value="${escapeHtml(row.bulk_code)}">${escapeHtml(row.bulk_code)}</option>`
                        )
                    })

                    $('#filterBulkCode').selectpicker('refresh')
                    $('#filterBulkCode').selectpicker('val', '')
                })
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
                        mst_itemgiftid: state.mst_itemgiftid,
                        itemgift_type: state.itemgiftType,
                        status: state.status,
                        bulk_code: state.bulkCode,
                        bulk_seq: state.bulkSeq,
                        sort_by: state.sort_by,
                        sort_dir: state.sort_dir
                    },
                    beforeSend: function() {
                        disableControls()
                    },
                    success: function(res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load voucher data', 'error')
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
                        enableControls()
                    }
                })
            }

            const openCreateModal = () => {
                resetForm()
                modal.modal('show')
            }

            const openBulkModal = () => {
                resetBulkForm()
                addBulkRow()
                bulkModal.modal('show')
            }

            const openGetBulkModal = () => {
                $.ajax({
                    url: endpoints.getBulkCode,
                    type: 'GET',
                    dataType: 'json',
                    data: {},
                    beforeSend: function() {
                        disableControls()
                    },
                    success: function(res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load voucher data', 'error')
                            return
                        }

                        renderBulkCodeTable(res.data)
                        modalGetBulkCode.modal('show')
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                    },
                    complete: function() {
                        enableControls()
                    }
                })
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
                        disableControls()
                    },
                    success: function(res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load voucher data', 'error')
                            return
                        }

                        const item = res.data || {}
                        fields.id.val(item.mst_voucherid || '')
                        fields.voucher_code.val(item.voucher_code || '')
                        fields.mst_itemgiftid.selectpicker('val', item.mst_itemgiftid ? String(item.mst_itemgiftid) : '')
                        fields.mst_itemgiftid.selectpicker('refresh')
                        fields.status.val(String(item.status || 1))
                        fields.expired_date.val(item.expired_date ? item.expired_date.substring(0, 10) : '')
                        fields.redeemed_date.val(item.redeemed_date ? item.redeemed_date.replace(' ', 'T').substring(0, 16) : '')
                        fields.payment_reference.val('')
                        fields.payment_attachment.val('')
                        fields.voucher_code.prop('readonly', true)
                        fields.expired_date.prop('readonly', false)
                        fields.redeemed_date.prop('readonly', true)
                        fields.status.addClass('no-select')
                        $('#modalTitle').text('Edit Voucher')
                        modal.modal('show')
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                    },
                    complete: function() {
                        enableControls()
                    }
                })
            }

            const renderBulkCodeTable = (data) => {

                const tbody = $('#bulkCodeTableBody');
                const empty = $('#bulkCodeEmpty');

                tbody.empty();

                if (!data || data.length === 0) {
                    empty.removeClass('d-none');
                    return;
                }

                empty.addClass('d-none');

                data.forEach((item, index) => {

                    const bulkCode = item.bulk_code || '-';
                    const createdDate = item.bulk_created_date || '-';
                    const count = Number(item.bulk_count || 0);

                    const row = `
                    <tr>
                        <td class="align-middle text-muted">
                            ${index + 1}
                        </td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <code class="bulk-code-text mr-2">
                                    ${bulkCode}
                                </code>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-light btn-copy-bulk"
                                    data-code="${bulkCode}"
                                    title="Copy Bulk Code">
                                    <i class="fa fa-copy"></i>
                                </button>
                            </div>
                        </td>
                        <td class="align-middle text-muted text-nowrap">
                            ${createdDate}
                        </td>
                        <td class="align-middle text-center">
                            <span class="badge badge-secondary px-3 py-2">
                                ${count}
                            </span>
                        </td>
                    </tr>
                `;

                    tbody.append(row);
                });
            };

            $('#btnAdd').on('click', openCreateModal)
            $('#btnBulkAdd').on('click', openBulkModal)
            $('#btnGetBulkCode').on('click', openGetBulkModal)

            $('#btnAddBulkRow').on('click', function() {
                addBulkRow()
            })

            $(document).on('click', '.btn-bulk-remove', function() {
                $(this).closest('tr').remove()
                if (bulkRows.find('tr').length === 0) {
                    renderBulkEmpty()
                }
                updateBulkTotalQty()
            })

            $(document).on('input change', '.bulk-qty', function() {
                const $this = $(this)
                const cursorPos = $this[0].selectionStart
                const rawValue = $this.val()
                const formatted = formatNumber(rawValue)
                $this.val(formatted)
                const newCursorPos = Math.max(0, cursorPos + (formatted.length - rawValue.length))
                $this[0].setSelectionRange(newCursorPos, newCursorPos)
                updateBulkTotalQty()
            })

            $('#btnApply').on('click', function() {
                state.page = 1
                state.search = $('#search').val().trim()
                state.mst_itemgiftid = $('#filterItemgift').val()
                state.itemgiftType = $('#filterItemgiftType').val()
                state.status = $('#filterStatus').val()
                state.bulkCode = $('#filterBulkCode').val()
                state.bulkSeq = $('#filterBulkSeq').val().trim()
                state.perPage = parseInt($('#perPage').val(), 10) || 10
                loadData()
            })

            $('#btnReset').on('click', function() {
                $('#search').val('')
                fields.mst_itemgiftid.selectpicker('val', '')
                $('#filterItemgift').selectpicker('val', '')
                $('#filterItemgiftType').selectpicker('val', '')
                $('#filterStatus').val('available')
                $('#filterBulkCode').selectpicker('val', '')
                $('#filterBulkSeq').val('')
                $('#perPage').val('10')
                state.page = 1
                state.perPage = 10
                state.search = ''
                state.mst_itemgiftid = ''
                state.itemgiftType = ''
                state.status = 'available'
                state.bulkCode = ''
                state.bulkSeq = ''
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
                if ($(this).prop('disabled')) return
                openEditModal($(this).data('id'))
            })

            $(document).on('click', '.btn-delete', function() {
                if ($(this).prop('disabled')) return
                const id = $(this).data('id')
                const name = $(this).data('name')

                Swal.fire({
                    title: 'Delete this voucher?',
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
                            disableControls()
                        },
                        success: function(response) {
                            if (!response.success) {
                                Swal.fire('Error', response.message || 'Failed to delete voucher', 'error')
                                return
                            }

                            Swal.fire('Success', response.message || 'Voucher deleted successfully', 'success')
                            loadData()
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                        },
                        complete: function() {
                            enableControls()
                        }
                    })
                })
            })

            $('#btnSave').on('click', function() {
                const payload = {
                    id: fields.id.val(),
                    mst_itemgiftid: fields.mst_itemgiftid.val(),
                    voucher_code: fields.voucher_code.val(),
                    status: fields.status.val(),
                    expired_date: fields.expired_date.val(),
                    redeemed_date: fields.redeemed_date.val(),
                    payment_reference: fields.payment_reference.val(),
                    payment_attachment: fields.payment_attachment.val()
                }

                if (payload.expired_date) {
                    const today = new Date()
                    today.setHours(0, 0, 0, 0)
                    const selected = new Date(payload.expired_date)
                    if (selected <= today) {
                        Swal.fire('Error', 'Expired date must be greater than today', 'error')
                        return
                    }
                }

                const isEdit = payload.id !== ''
                const url = isEdit ? endpoints.update : endpoints.create

                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: payload,
                    beforeSend: function() {
                        disableControls()
                    },
                    success: function(res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to save voucher', 'error')
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
                        enableControls()
                    }
                })
            })

            $('#btnBulkSave').on('click', function() {
                const rows = []
                let hasError = false

                bulkRows.find('tr').each(function() {
                    const $select = $(this).find('.bulk-itemgift')
                    const itemgiftid = $select.length ? ($select.selectpicker('val') || $select.val()) : ''
                    const qty = parseFormattedNumber($(this).find('.bulk-qty').val())

                    if (!itemgiftid || !qty || qty < 1) {
                        hasError = true
                        return false
                    }

                    rows.push({
                        mst_itemgiftid: itemgiftid,
                        qty: qty
                    })
                })

                if (hasError || rows.length === 0) {
                    Swal.fire('Error', 'Please complete all bulk rows before saving.', 'error')
                    return
                }

                const payload = {
                    bulk_prefix: $('#bulk_prefix').val().trim(),
                    status: $('#bulk_status').val(),
                    expired_date: $('#bulk_expired_date').val(),
                    items: rows
                }

                $.ajax({
                    url: endpoints.bulkCreate,
                    type: 'POST',
                    dataType: 'json',
                    contentType: 'application/json; charset=utf-8',
                    data: JSON.stringify(payload),
                    beforeSend: function() {
                        disableControls()
                    },
                    success: function(res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to save bulk vouchers', 'error')
                            return
                        }

                        Swal.fire('Success', res.message || 'Bulk vouchers submitted successfully', 'success')
                        bulkModal.modal('hide')
                        loadData()
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                    },
                    complete: function() {
                        enableControls()
                    }
                })
            })

            $('#btnPrint').on('click', function() {
                const query = buildPrintQuery()
                const url = '<?= site_url("activities/voucher/data_print") ?>' + (query ? `?${query}` : '')
                openReportUrl(url)
            })

            $('#btnExport').on('click', function() {
                const query = buildPrintQuery()
                const timestamp = getTimestamp()
                const filename = `voucher_${timestamp}`

                const url = '<?= site_url("activities/voucher/data_printhtml") ?>/' + filename + '/1/0' + (query ? `?${query}` : '')
                openReportUrl(url)
            })

            $(document).on('click', '.btn-copy-bulk', function() {
                const button = $(this);
                const code = button.data('code');
                navigator.clipboard.writeText(code)
                    .then(function() {
                        const original = button.html();
                        button.html(
                            '<i class="fa fa-check text-success"></i>'
                        );
                        setTimeout(function() {
                            button.html(original);
                        }, 1200);
                    })
                    .catch(function() {
                        Swal.fire(
                            'Error',
                            'Failed to copy bulk code',
                            'error'
                        );
                    });
            });

            modal.on('hidden.bs.modal', function() {
                resetForm()
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

            bulkModal.on('hidden.bs.modal', function() {
                resetBulkForm()
            })

            loadItemGiftOptions().always(function() {
                loadBulkCodeOptions().always(function() {
                    loadData()
                })
            })
        })
    </script>
</body>

</html>