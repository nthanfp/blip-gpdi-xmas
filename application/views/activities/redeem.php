<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('partial/activities/head.php') ?>

    <style>
        .redeem-summary {
            border: 1px solid #dce3eb;
            border-radius: 8px;
            background: linear-gradient(180deg, #f8fbff 0%, #eef4fb 100%);
            padding: 14px 16px;
        }

        .redeem-summary__label,
        .redeem-panel__title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: #6c757d;
            margin-bottom: 8px;
        }

        .redeem-summary__value {
            font-size: 18px;
            font-weight: 700;
            line-height: 1.2;
            color: #1f2d3d;
        }

        .redeem-summary__meta {
            font-size: 13px;
            margin-top: 2px;
        }

        .redeem-panel {
            border: 1px solid #dce3eb;
            border-radius: 8px;
            background: #fff;
            padding: 14px 16px;
        }

        .detail-list {
            display: grid;
            gap: 10px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            padding-bottom: 8px;
            border-bottom: 1px dashed #e6edf3;
        }

        .detail-row:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .detail-row span {
            color: #6c757d;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .detail-row strong {
            color: #1f2d3d;
            font-weight: 500;
            text-align: right;
            font-size: 14px;
            word-break: break-word;
        }

        .redeem-modal-footer {
            background: #f8f9fb;
            border-top: 1px solid #e3e7ee;
            border-radius: 0 0 0.3rem 0.3rem;
        }

        #btnConfirm {
            box-shadow: 0 6px 14px rgba(40, 167, 69, .15);
        }

        @media (max-width: 767.98px) {
            .content-wrapper {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }

            .modal-dialog {
                margin: 0.5rem;
            }

            .modal-content {
                border-radius: 10px;
            }

            .modal-header,
            .modal-body,
            .modal-footer {
                padding-left: 14px;
                padding-right: 14px;
            }

            .redeem-summary,
            .redeem-panel {
                padding: 12px 12px;
            }

            .redeem-summary__value {
                font-size: 16px;
                word-break: break-word;
            }

            .detail-row {
                flex-direction: column;
                gap: 1px;
            }

            .detail-row span,
            .detail-row strong {
                white-space: normal;
                text-align: left;
            }

            .redeem-modal-footer {
                align-items: stretch;
                gap: 4px;
            }

            .redeem-summary .text-right {
                text-align: left !important;
                margin-top: 10px;
            }

            .redeem-summary .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .alert.alert-light.border.mb-3.py-2 {
                word-break: break-word;
            }

            #tableBodyRedeem tr {
                cursor: pointer;
            }

            #tableBodyRedeem tr:hover td {
                background-color: #d4e6ff;
            }

            .mobile-w-50 {
                width: 50% !important;
            }

        }

        @media (min-width: 768px) {
            .btn-group-order-1 {
                order: 2;
            }

            .btn-group-order-2 {
                order: 1;
            }
        }
    </style>

    <link rel="stylesheet" href="<?= base_url('assets/plugins/viewerjs/viewer.min.css') ?>">
</head>

<body class="sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">
        <?php $this->load->view('partial/activities/sidebar.php') ?>

        <div class="content-wrapper pt-4 pb-2 px-4 text-sm">
            <div class="row mb-2">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-danger mr-1" id="btnPrint">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success" id="btnExport">
                            <i class="fas fa-file-export"></i> Export
                        </button>
                    </div>
                </div>
            </div>
            <div class="card card-outline card-secondary mb-2">
                <div class="card-body py-2 px-2 border-bottom">
                    <div class="row">
                        <!-- Date Filter -->
                        <div class="col-12 col-md-8 mb-2">
                            <label class="mb-0 d-inline-flex align-items-center gap-1" style="gap:4px; cursor:pointer">
                                <input class="mt-0 mb-0" type="checkbox" id="filterDateEnable" style="position:static">
                                Filter by Date (From - To)
                            </label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" id="filterDateFrom" disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" id="filterDateTo" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Voucher -->
                        <div class="col-12 col-md-4 mb-2"> <label class="mb-0">Voucher</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend"> <span class="input-group-text"> <i
                                            class="fas fa-ticket-alt"></i> </span> </div> <input type="text"
                                    class="form-control" id="filterVoucherSearch" placeholder="Voucher code..."
                                    autocomplete="off">
                            </div>
                        </div>
                        <!-- Search -->
                        <div class="col-12 col-md-4 mb-2"> <label class="mb-0">Search</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" class="form-control" id="search"
                                    placeholder="Customer, voucher, item..." autocomplete="off">
                            </div>
                        </div>
                        <!-- Customer -->
                        <div class="d-none col-12 col-md-3 mb-2"> <label class="mb-0">Customer</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend"> <span class="input-group-text"> <i
                                            class="fas fa-user"></i> </span> </div> <select class="selectpicker"
                                    data-style="form-control form-control-sm" data-live-search="true"
                                    id="filterCustomer">
                                    <option value="">-- ALL --</option>
                                </select>
                            </div>
                        </div>
                        <!-- Item Type -->
                        <div class="col-12 col-md-3 mb-2"> <label class="mb-0">Item Type</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-tag"></i>
                                    </span>
                                </div>
                                <select class="form-control" id="filterItemtype">
                                    <option value="">-- ALL --</option>
                                    <option value="1">POINT</option>
                                    <option value="2">OTHER</option>
                                </select>
                            </div>
                        </div>
                        <!-- Status -->
                        <div class="col-6 col-md-3 mb-2"> <label class="mb-0">Status</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend"> <span class="input-group-text"> <i
                                            class="fas fa-info-circle"></i> </span> </div> <select class="form-control"
                                    id="filterStatus">
                                    <option value="" selected>-- ALL --</option>
                                    <option value="3">REDEEMED</option>
                                    <option value="4">COMPLETED</option>
                                    <option value="5">REJECTED</option>
                                </select>
                            </div>
                        </div>
                        <!-- Show -->
                        <div class="col-6 col-md-2 mb-2"> <label class="mb-0">Show</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend"> <span class="input-group-text"> <i
                                            class="fas fa-list"></i> </span> </div> <select class="form-control"
                                    id="perPage">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="col-12 mb-2 mt-1">
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="d-flex gap-1 mb-2 btn-group-order-1">
                                    <button type="button" class="btn px-2 mr-1 btn-sm btn-danger" id="btnReset">
                                        <i class="fas fa-undo mr-1"></i> Reset
                                    </button>
                                    <button type="button" class="btn px-2 btn-sm btn-primary" id="btnApply">
                                        <i class="fas fa-filter mr-1"></i> Filter
                                    </button>
                                </div>
                                <div class="d-flex gap-1 mb-2 btn-group-order-2">
                                    <button type="button" class="btn mr-1 btn-sm btn-primary" id="btnDetail">
                                        <i class="fas fa-info-circle"></i> Detail
                                    </button>
                                    <button type="button" class="btn mr-1 btn-sm btn-success d-none" id="btnComplete">
                                        <i class="fas fa-check-circle mr-1"></i> Confirm
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger d-none" id="btnReject" disabled>
                                        <i class="fas fa-times-circle mr-1"></i> Reject
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="d-none">ID</th>
                                <th class="d-none text-nowrap">Customer</th>
                                <th class="text-nowrap">Voucher</th>
                                <th class="text-nowrap">Item</th>
                                <th class="d-none text-nowrap">Description</th>
                                <th class="d-none text-nowrap">Confirmed By</th>
                                <th class="d-none text-nowrap">Confirmed Date</th>
                                <th class="d-none text-nowrap">Completed By</th>
                                <th class="d-none text-nowrap">Completed Date</th>
                                <th class="text-nowrap sort-header" data-sort="redeemed_date" role="button">
                                    Redeemed Date
                                    <span class="sort-indicator" data-sort-indicator="redeemed_date">
                                        <i class="fas fa-sort text-secondary"></i>
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tableBodyRedeem">
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">Loading...</td>
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
            <div class="row mb-2">
                <div class="col-12">
                    <div class="text-muted font-italic">
                        <span class="d-inline-flex align-items-center mr-2 mb-1">
                            <span class="d-inline-block rounded-sm mr-1 bg-white border" style="width:20px;height:14px;"></span> Redeemed
                        </span>
                        <span class="d-inline-flex align-items-center mr-2 mb-1">
                            <span class="d-inline-block rounded-sm mr-1 bg-success" style="width:20px;height:14px;"></span> Completed
                        </span>
                        <span class="d-inline-flex align-items-center mr-2 mb-1">
                            <span class="d-inline-block rounded-sm mr-1 bg-danger" style="width:20px;height:14px;"></span> Rejected
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header align-items-start">
                        <div>
                            <div class="text-muted small text-uppercase font-weight-bold mb-1 d-none">Redeem Detail
                            </div>
                            <h6 class="modal-title mb-0" id="modalTitle">Redeem Information</h6>
                        </div>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="redeemId" value="">
                        <div class="redeem-summary mb-3">
                            <div class="redeem-summary__label d-none">Current Voucher</div>
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <div class="mr-3">
                                    <div class="redeem-summary__meta text-muted" id="infoVoucher">-</div>
                                    <div class="redeem-summary__value" id="infoItemGift">-</div>
                                </div>
                                <div class="text-right">
                                    <div class="small text-muted">Status</div>
                                    <span class="font-weight-bold" id="infoVoucherStatus">-</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-7 mb-2">
                                <div class="redeem-panel mb-3">
                                    <div class="d-none redeem-panel__title">Customer & Redeem</div>
                                    <div class="detail-list">
                                        <div class="detail-row">
                                            <span>Item Description</span>
                                            <strong id="infoItemDescription">-</strong>
                                        </div>
                                        <div class="detail-row d-none">
                                            <span>Customer</span>
                                            <strong id="infoCustomer">-</strong>
                                        </div>
                                        <div class="detail-row d-none">
                                            <span>Phone</span>
                                            <strong id="infoPhone">-</strong>
                                        </div>
                                        <div class="detail-row d-none">
                                            <span>Email</span>
                                            <strong id="infoEmail">-</strong>
                                        </div>
                                        <div class="detail-row d-none">
                                            <span>Redeemed Date</span>
                                            <strong id="infoRedeemedDate">-</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="redeem-panel mb-3">
                                    <div class="d-none redeem-panel__title">Confirmed Redeem</div>
                                    <div class="detail-list">
                                        <div class="detail-row d-none">
                                            <span>Completed By</span>
                                            <strong id="infoCompletedByWrap">
                                                <span id="infoCompletedBy">-</span>
                                                <a id="infoProofPreview" href="#" target="_blank" class="d-none ml-2">
                                                    <i class="fas fa-external-link-alt mr-1"></i> View File
                                                </a>
                                            </strong>
                                        </div>
                                        <div class="detail-row d-none">
                                            <span>Completed Date</span>
                                            <strong id="infoCompletedDate">-</strong>
                                        </div>
                                        <div class="detail-row d-none" id="infoRejectedByRow" style="display:none">
                                            <span>Rejected By</span>
                                            <strong id="infoRejectedBy">-</strong>
                                        </div>
                                        <div class="detail-row d-none" id="infoRejectedDateRow" style="display:none">
                                            <span>Rejected Date</span>
                                            <strong id="infoRejectedDate">-</strong>
                                        </div>
                                        <div class="detail-row d-none" id="infoRejectedNotesRow" style="display:none">
                                            <span>Rejected Notes</span>
                                            <strong id="infoRejectedNotes">-</strong>
                                        </div>
                                        <div class="detail-row">
                                            <span>IP Address</span>
                                            <strong id="infoIpAddress">-</strong>
                                        </div>
                                        <div class="detail-row d-none d-none">
                                            <span>MAC Address</span>
                                            <strong id="infoMacAddress">-</strong>
                                        </div>
                                        <div class="detail-row d-none">
                                            <span>Location</span>
                                            <strong id="infoGeo">-</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-5 text-sm">
                                <div class="card card-secondary card-outline card-outline-tabs">
                                    <div class="card-header p-0 border-bottom-0">
                                        <ul class="nav nav-tabs" id="proof-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="proof-purchase" data-toggle="pill" href="#tabs-proof-purchase" role="tab" aria-controls="tabs-proof-purchase" aria-selected="true">Purchase Proof</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="proof-completed" data-toggle="pill" href="#tabs-proof-completed" role="tab" aria-controls="tabs-proof-completed" aria-selected="false">Completed Proof</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="proof-tabsContent">
                                            <div class="tab-pane fade active show" id="tabs-proof-purchase" role="tabpanel" aria-labelledby="proof-purchase">
                                                <div class="justify-items-center">
                                                    <div class="alert alert-info text-center p-2 mb-2 d-none" style="font-size:12px;line-height:1.3" id="proofPurchaseHint">
                                                        <i class="fas fa-search-plus"></i> Tap image to view full detail
                                                    </div>
                                                    <img class="img img-fluid" id="proofPurchaseImg" src="" alt="Purchase proof" />
                                                    <div class="text-right mt-2 d-none" id="proofPurchaseDownload">
                                                        <a href="#" download class="btn btn-sm btn-outline-secondary" id="proofPurchaseDownloadLink">
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    </div>
                                                    <p class="text-muted text-center mt-3" id="proofPurchaseEmpty">No purchase proof uploaded</p>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tabs-proof-completed" role="tabpanel" aria-labelledby="proof-completed">
                                                <div class="justify-items-center">
                                                    <div class="alert alert-info text-center p-2 mb-2 d-none" style="font-size:12px;line-height:1.3" id="proofCompletedHint">
                                                        <i class="fas fa-search-plus"></i> Tap image to view full detail
                                                    </div>
                                                    <img class="img img-fluid" id="proofCompletedImg" src="" alt="Completed proof" />
                                                    <p class="text-muted text-center mt-2 mb-0" id="proofCompletedNotes" style="font-size:12px;line-height:1.3"></p>
                                                    <p class="text-muted text-center mt-3" id="proofCompletedEmpty">No completed proof uploaded</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer redeem-modal-footer d-flex w-100">
                        <button type="button" class="btn btn-secondary btn-sm px-2" data-dismiss="modal">
                            <i class="fas fa-times-circle"></i> Close
                        </button>
                        <button type="button" class="btn btn-danger btn-sm px-2" id="btnRejectFooter">
                            <i class="fas fa-times-circle mr-1"></i> Reject
                        </button>
                        <button type="button" class="btn btn-success btn-sm px-2" id="btnRedeemFooter">
                            <i class="fas fa-arrow-circle-right"></i> Continue Redeem
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-body">
                        <input type="hidden" id="confirmRedeemId" value="">
                        <div class="redeem-summary mb-3">
                            <div class="redeem-summary__label d-none">Current Voucher</div>
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <div class="mr-3">
                                    <div class="redeem-summary__meta text-muted" id="confirmInfoVoucher">-</div>
                                    <div class="redeem-summary__value" id="confirmInfoItemGift">-</div>
                                </div>
                                <div class="text-right">
                                    <div class="small text-muted">Status</div>
                                    <span class="font-weight-bold" id="confirmInfoVoucherStatus">-</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="redeem-panel mb-3">
                                    <div class="detail-list">
                                        <div class="detail-row"><span>Customer</span><strong
                                                id="confirmInfoCustomer">-</strong>
                                        </div>
                                        <div class="detail-row"><span>Phone</span><strong
                                                id="confirmInfoPhone">-</strong>
                                        </div>
                                        <div class="detail-row"><span>Email</span><strong
                                                id="confirmInfoEmail">-</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 d-none">
                                <div class="redeem-panel mb-3">
                                    <div class="detail-list">
                                        <div class="detail-row"><span>Redeem Notes</span><strong
                                                id="confirmInfoNotesDescription">-</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="redeem-panel mb-3">
                            <div class="row">
                                <div class="col-12 col-md-6 form-group mb-3">
                                    <label class="small font-weight-bold mb-1">
                                        Proof of Payment <span class="text-danger">*</span>
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input form-control-sm" id="paymentProof"
                                            accept=".jpg,.jpeg,.png,.pdf">
                                        <label class="custom-file-label" for="paymentProof">Choose file...</label>
                                    </div>
                                    <small class="form-text text-muted">Format: .JPG, .PNG, .PDF. Maximum 2MB.</small>
                                </div>
                                <div class="col-12 col-md-6 form-group mb-3">
                                    <label class="small font-weight-bold mb-1">Notes</label>
                                    <textarea class="form-control form-control-sm" id="paymentNote" rows="2"
                                        placeholder="Notes..."></textarea>
                                    <small class="form-text text-muted">Isi notes untuk dokumentasi, seperti: kejanggalan yang ditemukan, konfirmasi pembelian dengan pelanggan, atau informasi tambahan lainnya.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer redeem-modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm px-2 mb-1 mb-sm-0" data-dismiss="modal">
                            <i class="fas fa-times-circle"></i> Close
                        </button>
                        <button type="button" class="btn btn-success btn-sm px-2" id="btnConfirm">
                            <i class="fas fa-check-circle ml-1"></i> Confirm Redeem
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalReject" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <input type="hidden" id="rejectRedeemId" value="">
                        <div class="redeem-summary mb-3">
                            <div class="redeem-summary__label d-none">Current Voucher</div>
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <div class="mr-3">
                                    <div class="redeem-summary__meta text-muted" id="rejectInfoVoucher">-</div>
                                    <div class="redeem-summary__value" id="rejectInfoItemGift">-</div>
                                </div>
                                <div class="text-right">
                                    <div class="small text-muted">Status</div>
                                    <span class="font-weight-bold" id="rejectInfoVoucherStatus">-</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="redeem-panel mb-3">
                                    <div class="detail-list">
                                        <div class="detail-row"><span>Customer</span><strong
                                                id="rejectInfoCustomer">-</strong>
                                        </div>
                                        <div class="detail-row"><span>Phone</span><strong
                                                id="rejectInfoPhone">-</strong>
                                        </div>
                                        <div class="detail-row"><span>Email</span><strong
                                                id="rejectInfoEmail">-</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="redeem-panel mb-3">
                                    <div class="form-group mb-0">
                                        <label class="small font-weight-bold mb-1">Rejection Reason</label>
                                        <textarea class="form-control form-control-sm" id="rejectNote" rows="3"
                                            placeholder="Enter reason for rejection..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer redeem-modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm px-2" data-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-danger btn-sm px-2" id="btnRejectConfirm">
                            <i class="fas fa-times-circle mr-1"></i> Reject Voucher
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('partial/activities/footer.php') ?>
    </div>
    <?php $this->load->view('partial/activities/foot.php') ?>

    <script type="text/javascript" src="<?= base_url('assets/plugins/viewerjs/viewer.min.js') ?>"></script>

    <script type="text/javascript">
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text)
                .then(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Copied',
                        text: text,
                        timer: 1500,
                        showConfirmButton: false
                    });
                })
                .catch(function() {
                    const temp = document.createElement('input');
                    temp.value = text;
                    document.body.appendChild(temp);
                    temp.select();
                    document.execCommand('copy');
                    document.body.removeChild(temp);
                    Swal.fire({
                        icon: 'success',
                        title: 'Copied',
                        text: text,
                        timer: 1500,
                        showConfirmButton: false
                    });
                });
        }

        $(function() {
            const endpoints = {
                list: '<?= site_url("activities/redeem/data_list") ?>',
                information: '<?= site_url("activities/redeem/data_information") ?>',
                confirm: '<?= site_url("activities/redeem/data_confirm") ?>',
                reject: '<?= site_url("activities/redeem/data_reject") ?>',
                delete: '<?= site_url("activities/redeem/data_delete") ?>',
                customerOptions: '<?= site_url("activities/redeem/data_option_customer") ?>'
            }

            const state = {
                page: 1,
                perPage: 10,
                search: '',
                customer: '',
                voucher_search: '',
                status: 3,
                sort_by: 'redeemed_date',
                sort_dir: 'DESC',
                date_enabled: false,
                date_from: '',
                date_to: '',
                itemtype: ''
            }
            let selectedRedeemId = null;
            let selectedIsCompleted = false;
            let modalBackStack = 0;
            const modal = $('#modalForm')
            const confirmModal = $('#modalConfirm')
            const tableBody = $('#tableBodyRedeem')
            const pagination = $('#pagination')
            const tableInfo = $('#tableInfo')
            const filterCustomer = $('#filterCustomer')
            const filterStatus = $('#filterStatus')
            const filterVoucherSearch = $('#filterVoucherSearch')
            const filterDateEnable = $('#filterDateEnable')
            const filterDateFrom = $('#filterDateFrom')
            const filterDateTo = $('#filterDateTo')
            const filterItemtype = $('#filterItemtype')

            const info = {
                id: $('#redeemId'),
                customer: $('#infoCustomer'),
                phone: $('#infoPhone'),
                email: $('#infoEmail'),
                redeemed_date: $('#infoRedeemedDate'),
                description: $('#infoDescription'),
                confirmed_by: $('#infoConfirmedBy'),
                confirmed_date: $('#infoConfirmedDate'),
                completed_by: $('#infoCompletedBy'),
                completed_date: $('#infoCompletedDate'),
                ip_address: $('#infoIpAddress'),
                mac_address: $('#infoMacAddress'),
                geo: $('#infoGeo'),
                rejected_by: $('#infoRejectedBy'),
                rejected_date: $('#infoRejectedDate'),
                rejected_notes: $('#infoRejectedNotes'),
                voucher: $('#infoVoucher'),
                voucher_status: $('#infoVoucherStatus'),
                itemgift: $('#infoItemGift'),
                item_description: $('#infoItemDescription'),
                proof_preview: $('#infoProofPreview')
            }
            const confirmInfo = {
                voucher: $('#confirmInfoVoucher'),
                itemgift: $('#confirmInfoItemGift'),
                voucher_status: $('#confirmInfoVoucherStatus'),
                item_description: $('#confirmInfoItemDescription'),
                customer: $('#confirmInfoCustomer'),
                notes: $('#confirmInfoNotesDescription'),
                phone: $('#confirmInfoPhone'),
                email: $('#confirmInfoEmail')
            }
            const voucherStatusMap = {
                '1': 'CREATED',
                '2': 'PRINTED',
                '3': 'REDEEMED',
                '4': 'COMPLETED',
                '5': 'REJECTED'
            }

            const buildPrintQuery = () => {
                /*
                page: state.page,
                per_page: state.perPage,
                search: state.search,
                mst_customerid: state.customer,
                voucher_search: state.voucher_search,
                status: state.status,
                sort_by: state.sort_by,
                sort_dir: state.sort_dir
                */
                const params = []

                if (state.search !== '') {
                    params.push(`search=${encodeURIComponent(state.search)}`)
                }

                if (state.mst_customerid !== '' && state.mst_customerid !== null && state.mst_customerid !== undefined) {
                    params.push(`mst_customerid=${encodeURIComponent(state.mst_customerid)}`)
                }

                if (state.voucher_search !== '' && state.voucher_search !== null && state.voucher_search !== undefined) {
                    params.push(`voucher_search=${encodeURIComponent(state.voucher_search)}`)
                }

                if (state.status !== '' && state.status !== null && state.status !== undefined) {
                    params.push(`status=${encodeURIComponent(state.status)}`)
                }

                if (state.sort_by !== '') {
                    params.push(`sort_by=${encodeURIComponent(state.sort_by)}`)
                }

                if (state.sort_dir !== '') {
                    params.push(`sort_dir=${encodeURIComponent(state.sort_dir)}`)
                }

                if (state.date_enabled && state.date_from !== '') {
                    params.push(`date_from=${encodeURIComponent(state.date_from)}`)
                }

                if (state.date_enabled && state.date_to !== '') {
                    params.push(`date_to=${encodeURIComponent(state.date_to)}`)
                }

                if (state.itemtype !== '' && state.itemtype !== null && state.itemtype !== undefined) {
                    params.push(`itemtype=${encodeURIComponent(state.itemtype)}`)
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
                        $(this).html('<i class="fas fa-sort text-secondary"></i>')
                        return
                    }

                    $(this).html(state.sort_dir === 'ASC' ?
                        ' <i class="fas fa-sort-up"></i>' :
                        ' <i class="fas fa-sort-down"></i>')
                })
            }

            const escapeHtml = (value) => $('<div>').text(value == null ? '' : String(value)).html()
            const dmyToYmd = (str) => {
                var m = str.match(/^(\d{2})-(\d{2})-(\d{4})$/);
                return m ? m[3] + '-' + m[2] + '-' + m[1] : str
            }

            const getRedeemIdFromButton = ($button) => {
                const dataId = $button.data('id')
                if (dataId !== undefined && dataId !== null && String(dataId).trim() !== '') {
                    return String(dataId)
                }

                const rowId = $button.closest('tr').find('td.d-none').first().text().trim()
                return rowId
            }

            const setOptions = ($select, placeholder, rows, key, labelKey) => {
                let html = `<option value="">${placeholder}</option>`;
                (rows || []).forEach(function(row) {
                    html += `<option value="${escapeHtml(String(row[key] || ''))}">${escapeHtml(row.display_name || row[labelKey] || '')}</option>`
                })
                $select.html(html).selectpicker('refresh')
            }

            const loadCustomers = () => $.getJSON(endpoints.customerOptions).then(function(res) {
                if (!res.success) return
                setOptions(filterCustomer, '-- ALL --', res.data || [], 'mst_customerid', 'custname')
            })

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
                        mst_customerid: state.customer,
                        voucher_search: state.voucher_search,
                        status: state.status,
                        sort_by: state.sort_by,
                        sort_dir: state.sort_dir,
                        date_from: state.date_enabled ? state.date_from : '',
                        date_to: state.date_enabled ? state.date_to : '',
                        itemtype: state.itemtype
                    },
                    beforeSend: function() {
                        var dateDisabled = filterDateFrom.prop('disabled');
                        $('input, select, textarea, button').prop('disabled', true);
                        filterDateEnable.prop('disabled', false);
                        filterDateFrom.prop('disabled', dateDisabled);
                        filterDateTo.prop('disabled', dateDisabled);
                        $.LoadingOverlay('show', {
                            background: 'rgba(0, 0, 0, 0.25)'
                        });
                    },
                    success: function(res) {
                        selectedRedeemId = null;
                        selectedIsCompleted = false;
                        $('#btnComplete').prop('disabled', false);
                        $('#btnReject').prop('disabled', true);
                        $('#tableBodyRedeem tr').css({
                            background: '',
                            boxShadow: ''
                        });
                        $('#tableBodyRedeem tr td').css({
                            background: '',
                            borderLeft: ''
                        });
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to load redeem data', 'error')
                            return
                        }

                        const rows = res.data || []
                        tableBody.html(rows.length ? rows.map((row) => `
                            <tr class="${Number(row.status) === 4 ? 'table-success' : Number(row.status) === 5 ? 'table-danger' : ''}" data-status="${escapeHtml(row.status || '')}">
                                <td class="d-none">${escapeHtml(row.act_redeemid)}</td>
                                <td class="text-nowrap d-none">${escapeHtml(row.custname || '-')}</td>
                                <td class="text-nowrap">${escapeHtml(row.voucher_code || '-')}</td>
                                <td class="text-nowrap">${escapeHtml(row.itemname || '-')}</td>
                                <td class="d-none text-nowrap">${escapeHtml(row.description || '-')}</td>
                                <td class="d-none text-nowrap d-none">${escapeHtml(row.confirmed_by || '-')}</td>
                                <td class="d-none text-nowrap d-none">${escapeHtml(formatDate(row.confirmed_date) || '-')}</td>
                                <td class="d-none text-nowrap">${escapeHtml(row.completed_by || '-')}</td>
                                <td class="d-none text-nowrap">${escapeHtml(formatDate(row.completed_date) || '-')}</td>
                                <td class="text-nowrap">${escapeHtml(formatDate(row.redeemed_date) || '-')}</td>
                            </tr>`).join('') : '<tr><td colspan="10" class="text-center text-muted py-4">No data found</td></tr>')

                        const p = res.pagination || {}
                        const total = Number(p.total || 0),
                            page = Number(p.page || 1),
                            perPage = Number(p.per_page || state.perPage)
                        const start = total === 0 ? 0 : ((page - 1) * perPage) + 1
                        const end = Math.min(total, page * perPage)
                        tableInfo.text(total === 0 ? 'Showing 0 to 0 of 0 entries' : `Showing ${start} to ${end} of ${total.toLocaleString('en-US')} entries`)
                        renderPagination(res.pagination || {})
                        updateSortIndicators()
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Server error (' + xhr.status + ')', 'error')
                    },
                    complete: function() {
                        $('input, select, textarea, button').prop('disabled', false);
                        filterDateFrom.prop('disabled', !filterDateEnable.is(':checked'));
                        filterDateTo.prop('disabled', !filterDateEnable.is(':checked'));
                        $.LoadingOverlay('hide');
                    }
                })
            }

            const reverseGeocode = (lat, lon) => {
                return fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`)
                    .then(r => r.ok ? r.json() : null)
                    .then(data => data && data.display_name ? data.display_name : null)
                    .catch(() => null);
            }

            const fillInformation = (item) => {
                const rawPhone = item.phone_number || '';
                const cleanPhone = rawPhone.replace(/\D/g, '');
                let waNumber = cleanPhone;
                if (cleanPhone.startsWith('0')) {
                    waNumber = '62' + cleanPhone.substring(1);
                } else if (cleanPhone.startsWith('8')) {
                    waNumber = '62' + cleanPhone;
                }
                let idNumber = cleanPhone;
                if (waNumber.startsWith('62')) {
                    idNumber = '0' + waNumber.substring(2);
                }

                const waMessage = encodeURIComponent(
                    `Halo ${item.custname || 'Kak'},\n\n` +
                    `Selamat! Hadiah Anda telah berhasil diproses sebagai bagian dari program Hoki Beli Illusions by Internal Grup.\n\n` +
                    `Hadiah: ${item.itemname || '-'}${item.description ? ' (' + item.description + ')' : ''}\n` +
                    `No. E-Wallet: ${idNumber || waNumber}\n` +
                    `Tanggal Proses: ${new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })} WIB\n\n` +
                    `Terima kasih telah berbelanja produk Illusions by Internal Grup.`
                );

                const phoneDisplay = cleanPhone ? `
                    <div class="d-flex align-items-center flex-wrap gap-1 justify-content-end" style="gap:4px">
                        <a href="javascript:void(0)" onclick="copyToClipboard('${idNumber}')" class="text-primary font-weight-semibold" title="Copy for e-wallet (08xx)">
                            ${idNumber} <i class="fas fa-copy"></i>
                        </a>
                        <span class="text-muted d-none">|</span>
                        <a href="https://wa.me/${waNumber}?text=${waMessage}" target="_blank" class="d-none text-primary font-weight-semibold">
                            WhatsApp
                        </a>
                    </div>
                ` : '-';

                info.phone.html(phoneDisplay);

                info.id.val(item.act_redeemid || '')
                info.customer.text([item.custname].filter(Boolean).join(' ') || '-')
                info.email.html(item.email ? `<a href="mailto:${escapeHtml(item.email)}" class="text-primary font-weight-semibold">${escapeHtml(item.email)}</a> <a href="javascript:void(0)" onclick="copyToClipboard('${escapeHtml(item.email)}')" class="text-primary font-weight-semibold ml-2"><i class="fas fa-copy"></i></a>` : '-');
                info.redeemed_date.text(formatDate(item.redeemed_date) || '-')
                info.description.text(item.description || '-')
                info.confirmed_by.text(item.confirmed_by || '-')
                info.confirmed_date.text(item.confirmed_date || '-')
                info.confirmed_date.text(item.confirmed_date || '-')
                info.completed_by.text(item.completed_by || '-')
                info.completed_date.text(formatDate(item.completed_date) || '-')

                var voucherStatus = String(item.voucher_status || '');
                $('#infoCompletedByWrap, #infoCompletedDate').closest('.detail-row').toggle(voucherStatus === '4');
                $('#infoRejectedByRow, #infoRejectedDateRow, #infoRejectedNotesRow').toggle(voucherStatus === '5');
                info.rejected_by.text(item.rejected_by || '-');
                info.rejected_date.text(formatDate(item.rejected_date) || '-');
                info.rejected_notes.text(formatDate(item.rejected_notes) || '-');
                info.ip_address.text(item.ip_address || '-')
                info.mac_address.text(item.mac_address || '-')
                const hasGeo = item.geo_lat && item.geo_long;
                info.geo.text(hasGeo ? `${item.geo_lat}, ${item.geo_long}` : '-');
                if (hasGeo) {
                    reverseGeocode(item.geo_lat, item.geo_long).then(address => {
                        if (address) info.geo.html(`${escapeHtml(address)}`);
                    });
                }
                info.voucher.text(item.voucher_code || '-')
                info.voucher_status.text(voucherStatusMap[String(item.voucher_status)] || '-')
                modal.data('voucher-status', String(item.voucher_status || ''));
                $('#btnRedeemFooter').toggle(String(item.voucher_status) === '3');
                $('#btnRejectFooter').toggle(String(item.voucher_status) === '3');
                info.itemgift.text(item.itemname ? item.itemname + (item.description ? ' - ' + item.description : '') : '-')
                info.item_description.text(item.item_description || item.itemname || '-')
                confirmInfo.voucher.text(item.voucher_code || '-')
                confirmInfo.itemgift.text(item.itemname ? item.itemname + (item.description ? ' - ' + item.description : '') : '-')
                confirmInfo.voucher_status.text(voucherStatusMap[String(item.voucher_status)] || '-')
                confirmInfo.item_description.text(item.item_description || item.itemname || '-')
                confirmInfo.customer.text(item.custname || '-')
                confirmInfo.notes.text(item.description || '-')
                confirmInfo.phone.html(phoneDisplay);
                confirmInfo.email.html(item.email ? `<a href="mailto:${escapeHtml(item.email)}" class="text-primary font-weight-semibold">${escapeHtml(item.email)}</a> <a href="javascript:void(0)" onclick="copyToClipboard('${escapeHtml(item.email)}')" class="text-primary font-weight-semibold ml-2"><i class="fas fa-copy"></i></a>` : '-');

                $('#rejectInfoVoucher').text(item.voucher_code || '-')
                $('#rejectInfoItemGift').text(item.itemname ? item.itemname + (item.description ? ' - ' + item.description : '') : '-')
                $('#rejectInfoVoucherStatus').text(voucherStatusMap[String(item.voucher_status)] || '-')
                $('#rejectInfoCustomer').text(item.custname || '-')
                $('#rejectInfoPhone').html(phoneDisplay)
                $('#rejectInfoEmail').html(item.email ? `<a href="mailto:${escapeHtml(item.email)}" class="text-primary font-weight-semibold">${escapeHtml(item.email)}</a>` : '-')

                const proof = item.proof || null
                if (proof && proof.filepath) {
                    info.proof_preview.attr('href', '<?= base_url() ?>' + proof.filepath)
                    info.completed_by.html(`${escapeHtml(item.completed_by || '-')} `)
                    $('#proofCompletedImg').attr('src', '<?= base_url() ?>' + proof.filepath).removeClass('d-none')
                    $('#proofCompletedEmpty').addClass('d-none')
                    $('#proofCompletedHint').removeClass('d-none')
                    $('#proofCompletedNotes').text(proof.notes ? escapeHtml(proof.notes) : '-').removeClass('d-none')
                } else {
                    info.proof_preview.addClass('d-none')
                    info.completed_by.text(item.completed_by || '-')
                    $('#proofCompletedImg').attr('src', '').addClass('d-none')
                    $('#proofCompletedEmpty').removeClass('d-none')
                    $('#proofCompletedHint').addClass('d-none')
                    $('#proofCompletedNotes').addClass('d-none')
                }

                const purchaseProof = item.purchase_proof || null
                if (purchaseProof && purchaseProof.filepath) {
                    var src = '<?= base_url() ?>' + purchaseProof.filepath;
                    $('#proofPurchaseImg').attr('src', src).removeClass('d-none')
                    $('#proofPurchaseEmpty').addClass('d-none')
                    $('#proofPurchaseHint').removeClass('d-none')
                    $('#proofPurchaseDownloadLink').attr('href', src)
                    $('#proofPurchaseDownload').removeClass('d-none')
                } else {
                    $('#proofPurchaseImg').attr('src', '').addClass('d-none')
                    $('#proofPurchaseEmpty').removeClass('d-none')
                    $('#proofPurchaseHint').addClass('d-none')
                    $('#proofPurchaseDownload').addClass('d-none')
                }

                if (window._proofViewer) {
                    window._proofViewer.destroy();
                    window._proofViewer = null;
                }

            }

            const openInformationModal = (id) => $.ajax({
                url: endpoints.information,
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id
                },
                beforeSend: function() {
                    var dateDisabled = filterDateFrom.prop('disabled');
                    $('input, select, textarea, button').prop('disabled', true);
                    filterDateEnable.prop('disabled', false);
                    filterDateFrom.prop('disabled', dateDisabled);
                    filterDateTo.prop('disabled', dateDisabled);
                    $.LoadingOverlay('show', {
                        background: 'rgba(0, 0, 0, 0.25)'
                    });
                },
                success: function(res) {
                    if (!res.success) {
                        Swal.fire('Error', res.message || 'Failed to load redeem data', 'error')
                        return
                    }
                    fillInformation(res.data || {})
                    modal.data('redeem-id', id)
                    modal.modal('show')
                },
                complete: function() {
                    $('input, select, textarea, button').prop('disabled', false);
                    filterDateFrom.prop('disabled', !filterDateEnable.is(':checked'));
                    filterDateTo.prop('disabled', !filterDateEnable.is(':checked'));
                    $.LoadingOverlay('hide');
                }
            })

            const openConfirmModal = (id) => $.ajax({
                url: endpoints.information,
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id
                },
                beforeSend: function() {
                    var dateDisabled = filterDateFrom.prop('disabled');
                    $('input, select, textarea, button').prop('disabled', true);
                    filterDateEnable.prop('disabled', false);
                    filterDateFrom.prop('disabled', dateDisabled);
                    filterDateTo.prop('disabled', dateDisabled);
                    $.LoadingOverlay('show', {
                        background: 'rgba(0, 0, 0, 0.25)'
                    });
                },
                success: function(res) {
                    if (!res.success) {
                        Swal.fire('Error', res.message || 'Failed to load redeem data', 'error')
                        return
                    }
                    fillInformation(res.data || {})
                    confirmModal.data('redeem-id', id)
                    $('#confirmRedeemId').val(id)
                    confirmModal.modal('show')
                },
                complete: function() {
                    $('input, select, textarea, button').prop('disabled', false);
                    filterDateFrom.prop('disabled', !filterDateEnable.is(':checked'));
                    filterDateTo.prop('disabled', !filterDateEnable.is(':checked'));
                    $.LoadingOverlay('hide');
                }
            })

            const openRejectModal = (id) => $.ajax({
                url: endpoints.information,
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id
                },
                beforeSend: function() {
                    var dateDisabled = filterDateFrom.prop('disabled');
                    $('input, select, textarea, button').prop('disabled', true);
                    filterDateEnable.prop('disabled', false);
                    filterDateFrom.prop('disabled', dateDisabled);
                    filterDateTo.prop('disabled', dateDisabled);
                    $.LoadingOverlay('show', {
                        background: 'rgba(0, 0, 0, 0.25)'
                    });
                },
                success: function(res) {
                    if (!res.success) {
                        Swal.fire('Error', res.message || 'Failed to load redeem data', 'error')
                        return
                    }
                    fillInformation(res.data || {})
                    $('#rejectRedeemId').val(id)
                    $('#rejectNote').val('')
                    $('#modalReject').modal('show')
                },
                complete: function() {
                    $('input, select, textarea, button').prop('disabled', false);
                    filterDateFrom.prop('disabled', !filterDateEnable.is(':checked'));
                    filterDateTo.prop('disabled', !filterDateEnable.is(':checked'));
                    $.LoadingOverlay('hide');
                }
            })

            $('#btnApply').on('click', function() {
                state.page = 1
                state.search = $('#search').val().trim()
                state.customer = filterCustomer.val()
                state.voucher_search = filterVoucherSearch.val().trim()
                state.status = filterStatus.val()
                state.perPage = parseInt($('#perPage').val(), 10) || 10
                state.date_enabled = filterDateEnable.is(':checked')
                state.date_from = dmyToYmd(filterDateFrom.val().trim())
                state.date_to = dmyToYmd(filterDateTo.val().trim())
                state.itemtype = filterItemtype.val()
                loadData()
            })

            $('#btnReset').on('click', function() {
                $('#search').val('')
                $('#perPage').val('10')
                filterCustomer.selectpicker('val', '')
                filterVoucherSearch.val('')
                filterStatus.val('')
                filterDateEnable.prop('checked', false)
                filterDateFrom.val('').prop('disabled', true)
                filterDateTo.val('').prop('disabled', true)
                state.page = 1
                state.perPage = 10
                state.search = ''
                state.customer = ''
                state.voucher_search = ''
                state.status = ''
                state.date_enabled = false
                state.date_from = ''
                state.date_to = ''
                state.itemtype = ''
                filterItemtype.val('')
                loadData()
            })

            $('#pagination').on('click', '.page-link', function(e) {
                e.preventDefault()
                const page = parseInt($(this).data('page'), 10)
                if (!page || $(this).closest('.page-item').hasClass('disabled') || $(this).closest('.page-item').hasClass('active')) return
                state.page = page
                loadData()
            })

            $(document).on('click', '.sort-header', function() {
                const s = $(this).data('sort')
                if (!s) return
                if (state.sort_by === s) {
                    state.sort_dir = state.sort_dir === 'ASC' ? 'DESC' : 'ASC'
                } else {
                    state.sort_by = s
                    state.sort_dir = 'ASC'
                }
                state.page = 1
                loadData()
            })

            $(document).on('click', '#tableBodyRedeem tr', function(e) {
                if ($(e.target).closest('button, .btn').length) return;
                $('#tableBodyRedeem tr').css({
                    background: '',
                    boxShadow: ''
                });
                $('#tableBodyRedeem tr td').css({
                    background: '',
                    borderLeft: ''
                });
                $(this).css({
                    background: '#cce5ff'
                });
                $(this).find('td').css({
                    background: '#cce5ff'
                });
                $(this).find('td:first').css({
                    borderLeft: '3px solid #3399ff'
                });
                const idEl = $(this).find('td.d-none').first();
                selectedRedeemId = idEl.length ? idEl.text().trim() : null;
                selectedIsCompleted = $(this).data('status') == 4;
                $('#btnComplete').prop('disabled', selectedIsCompleted || $(this).data('status') == 5);
                $('#btnReject').prop('disabled', Number($(this).data('status')) !== 3);
            })

            $('#btnDetail').on('click', function() {
                if (!selectedRedeemId) {
                    Swal.fire('Info', 'Please choose row!', 'info');
                    return;
                }
                openInformationModal(selectedRedeemId);
            })

            $('#btnComplete').on('click', function() {
                if (!selectedRedeemId) {
                    Swal.fire('Info', 'Please choose row!', 'info');
                    return;
                }
                openConfirmModal(selectedRedeemId);
            })

            $('#btnRedeemFooter').on('click', function() {
                const id = info.id.val();
                if (!id) return;
                modal.modal('hide');
                openConfirmModal(id);
            })

            $('#btnRejectFooter').on('click', function() {
                const id = info.id.val();
                if (!id) return;
                modal.modal('hide');
                openRejectModal(id);
            })

            $('#btnReject').on('click', function() {
                if (!selectedRedeemId) {
                    Swal.fire('Info', 'Please choose row!', 'info');
                    return;
                }
                openRejectModal(selectedRedeemId);
            })

            $('#btnConfirm').on('click', function() {
                const id = confirmModal.data('redeem-id') || $('#confirmRedeemId').val()
                if (!id) return

                const proofFile = $('#paymentProof')[0]?.files[0]
                if (!proofFile) {
                    Swal.fire('Error', 'Proof file is required', 'error')
                    return
                }

                const formData = new FormData()
                formData.append('id', id)
                formData.append('notes', $('#paymentNote').val() || '')
                formData.append('proof_file', proofFile)

                var csrfName = $('meta[name="csrf-token-name"]').attr('content') || 'csrf_test_name'
                var csrfValue = $('meta[name="csrf-token-value"]').attr('content')
                if (csrfValue) formData.append(csrfName, csrfValue)

                $('input, select, textarea, button').prop('disabled', true)
                $.LoadingOverlay('show', {
                    background: 'rgba(0,0,0,0.25)'
                })

                fetch(endpoints.confirm, {
                        method: 'POST',
                        body: formData
                    })
                    .then(function(r) {
                        if (!r.ok) throw new Error('HTTP ' + r.status)
                        return r.json()
                    })
                    .then(function(res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to confirm redeem', 'error')
                            return
                        }
                        Swal.fire('Success', res.message || 'Redeem confirmed', 'success')
                        confirmModal.modal('hide')
                        loadData()
                    })
                    .catch(function(err) {
                        console.error('[confirm] error:', err)
                        Swal.fire('Error', 'Failed: ' + err.message, 'error')
                    })
                    .finally(function() {
                        $('input, select, textarea, button').prop('disabled', false)
                        $.LoadingOverlay('hide')
                    })
            })

            $('#btnRejectConfirm').on('click', function() {
                const id = $('#rejectRedeemId').val()
                if (!id) return

                const notes = $('#rejectNote').val() || ''

                var csrfName = $('meta[name="csrf-token-name"]').attr('content') || 'csrf_test_name';
                var csrfValue = $('meta[name="csrf-token-value"]').attr('content');

                $.ajax({
                    url: endpoints.reject,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id,
                        notes: notes
                    },
                    beforeSend: function(xhr, settings) {
                        if (csrfValue && settings.data) {
                            settings.data[csrfName] = csrfValue;
                        }
                        $('input, select, textarea, button').prop('disabled', true);
                        $.LoadingOverlay('show', {
                            background: 'rgba(0, 0, 0, 0.25)'
                        });
                    },
                    success: function(res) {
                        if (!res.success) {
                            Swal.fire('Error', res.message || 'Failed to reject redeem', 'error')
                            return
                        }
                        Swal.fire('Success', res.message || 'Redeem rejected successfully', 'success')
                        $('#modalReject').modal('hide')
                        loadData()
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('[btnReject] ERROR - status:', jqXHR.status, 'textStatus:', textStatus, 'error:', errorThrown);
                        console.error('[btnReject] responseText:', jqXHR.responseText?.substring(0, 500));
                        Swal.fire('Error', 'Failed (' + (jqXHR.status || 0) + '): ' + (textStatus || 'unknown'), 'error')
                    },
                    complete: function(jqXHR, textStatus) {
                        console.log('[btnReject] complete - status:', textStatus);
                        $('input, select, textarea, button').prop('disabled', false);
                        $.LoadingOverlay('hide');
                    }
                })
            })

            $('#paymentProof').on('change', function() {
                const fileName = this.files && this.files.length ? this.files[0].name : 'Choose file...'
                $(this).next('.custom-file-label').text(fileName)
            })

            confirmModal.on('hidden.bs.modal', function() {
                confirmModal.removeData('redeem-id')
                $('#confirmRedeemId').val('')
                $('#paymentProof').val('')
                $('#paymentProof').next('.custom-file-label').text('Choose file...')
                $('#paymentNote').val('')
                document.activeElement.blur()
            })

            $('#modalReject').on('hidden.bs.modal', function() {
                $('#rejectRedeemId').val('')
                $('#rejectNote').val('')
                if (document.activeElement) {
                    document.activeElement.blur();
                }
            })

            $('#modalForm').on('hide.bs.modal', function() {
                if (document.activeElement) {
                    document.activeElement.blur();
                }
                $('#proofPurchaseImg').attr('src', '').addClass('d-none')
                $('#proofPurchaseEmpty').removeClass('d-none')
                $('#proofCompletedImg').attr('src', '').addClass('d-none')
                $('#proofCompletedEmpty').removeClass('d-none')
            });

            $('#btnPrint').on('click', function() {
                const query = buildPrintQuery()
                const url = '<?= site_url("activities/redeem/data_print") ?>' + (query ? `?${query}` : '')
                openReportUrl(url)
            })

            $('#btnExport').on('click', function() {
                const query = buildPrintQuery()
                const timestamp = getTimestamp()
                const filename = `redeem_${timestamp}`

                const url = '<?= site_url("activities/redeem/data_printhtml") ?>/' + filename + '/1' + (query ? `?${query}` : '')
                openReportUrl(url)
            })

            filterCustomer.on('changed.bs.select change', function() {
                state.customer = $(this).val()
            })

            filterStatus.on('change', function() {
                state.status = $(this).val()
            })

            filterDateEnable.on('change', function() {
                var checked = $(this).is(':checked');
                filterDateFrom.prop('disabled', !checked);
                filterDateTo.prop('disabled', !checked);
                if (!checked) {
                    filterDateFrom.val('');
                    filterDateTo.val('');
                } else {
                    var today = new Date().toISOString().split('T')[0];
                    filterDateFrom.attr('max', today);
                    filterDateTo.attr('max', today);
                }
            })

            filterDateFrom.on('change', function() {
                var val = $(this).val();
                filterDateTo.attr('min', val);
                if (filterDateTo.val() && filterDateTo.val() < val) {
                    filterDateTo.val(val);
                }
            })

            state.status = filterStatus.val()
            loadCustomers().always(loadData)
        })

        function openImageViewer(src) {
            if (!src) return;
            if (window._proofViewer) {
                window._proofViewer.destroy();
                window._proofViewer = null;
            }
            var img = document.createElement('img');
            img.src = src;
            img.alt = 'Proof';
            var viewer = new Viewer(img, {
                inline: false,
                button: true,
                navbar: false,
                toolbar: {
                    zoomIn: 4,
                    zoomOut: 4,
                    oneToOne: 4,
                    reset: 4,
                    rotateLeft: 4,
                    rotateRight: 4,
                },
                title: false,
                transition: true,
                movable: true,
                rotatable: true,
                scalable: true,
                zoomable: true,
                zoomRatio: 0.1,
                minZoomRatio: 0.1,
                maxZoomRatio: 16,
                hidden: function() {
                    viewer.destroy();
                    window._proofViewer = null;
                }
            });
            window._proofViewer = viewer;
            viewer.show();
        }

        $(document).on('click', '#proofPurchaseImg, #proofCompletedImg', function() {
            openImageViewer($(this).attr('src'));
        });
    </script>
</body>

</html>