<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('partial/activities/head.php') ?>

    <style type="text/css">
        /* ===== Seating layout (activities/layout) ===== */
        .seating-map {
            --seat-size: 24px;
            --seat-gap: 2px;
            --aisle-width: 20px;
        }

        .seating-map .map-scroll {
            overflow-x: auto;
            padding-bottom: .25rem;
        }

        .seating-map .stage-bar {
            background: linear-gradient(135deg, #6c757d 0%, #343a40 100%);
            color: #fff;
            text-align: center;
            font-weight: 600;
            font-size: .72rem;
            letter-spacing: .2em;
            padding: .55rem 1rem;
            border-radius: .4rem;
            border: 1px solid rgba(255, 255, 255, .15);
        }

        .seating-map .stage-arrow {
            text-align: center;
            font-size: .65rem;
            color: #adb5bd;
            padding: .2rem 0;
        }

        .seating-map .seat-row {
            display: flex;
            align-items: center;
            gap: 0;
            margin-bottom: 4px;
        }

        .seating-map .row-label {
            width: 30px;
            flex: 0 0 30px;
            margin-right: 8px;
            text-align: right;
            font-size: .62rem;
            color: #6c757d;
            user-select: none;
        }

        .seating-map .row-label-label {
            width: 120px;
            flex: 0 0 120px;
            text-align: left;
            font-size: .62rem;
            color: #6c757d;
            user-select: none;
        }

        .seating-map .seat-block {
            display: flex;
            gap: 0;
            flex: 1 1 0;
            min-width: 0;
        }

        .seating-map .seat-aisle {
            width: var(--aisle-width);
            flex: 0 0 var(--aisle-width);
            position: relative;
        }

        .seating-map .seat {
            flex: 1 1 0;
            min-width: 18px;
            height: var(--seat-size);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .65rem;
            font-weight: 600;
            line-height: 1;
            color: #111827;
            background: #fff;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            cursor: default;
            transition: background .15s, border-color .15s;
        }

        .seating-map .seat:hover {
            background: #fff3cd;
            border-color: #ffc107;
        }

        .seating-map .seat[data-seat] {
            cursor: pointer;
        }

        /* State warna seat (UI saja — logic DB menyusul) */
        .seating-map .seat.seat-confirmed {
            background: #198754;
            border-color: #146c43;
            color: #fff;
        }

        .seating-map .seat.seat-confirmed:hover {
            background: #157347;
            border-color: #0f5132;
        }

        .seating-map .seat.seat-selected {
            background: #f59f00;
            border-color: #e8590c;
            color: #212529;
            box-shadow: 0 0 0 2px rgba(245, 159, 0, .4);
        }

        .seating-map .seat.seat-selected:hover {
            background: #e8590c;
            color: #fff;
        }

        .seating-map .seat.seat-table {
            background: #212529;
            border-color: #212529;
            color: transparent;
        }

        .seating-map .seat.seat-table:hover {
            background: #000;
            border-color: #000;
        }

        .seating-map .seat.seat-empty {
            visibility: hidden;
        }

        /* Hidden-border object: tetap jadi object (ambil tempat, selebar seat)
           tapi tidak terlihat di UI — bukan disabled */
        .seating-map .hseat {
            flex: 1 1 0;
            min-width: 18px;
            height: var(--seat-size);
            border: 1px solid transparent;
            visibility: hidden;
        }

        .seating-map .seat.seat-blank {
            background: #f8f9fa;
            color: transparent;
            border-style: dashed;
        }

        .seating-map .seat.seat-blank:hover {
            background: #f8f9fa;
            border-color: #ced4da;
        }

        .seating-map .seat-pillar-box {
            background: #212529;
            border-color: #212529;
            color: transparent;
        }

        .seating-map .seat-divider {
            border-top: 1px dashed #ced4da;
            margin: .5rem 0;
        }

        .seating-map .seat-caption {
            font-size: .65rem;
            color: #6c757d;
            margin-bottom: .35rem;
        }

        .seating-map .legend {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem 1.25rem; /* jarak antar item legend: rapat & seragam */
            font-size: .68rem;
            color: #495057;
            align-items: center;
        }

        .seating-map .legend > span {
            margin: 0;
            white-space: nowrap;
        }

        .seating-map .legend .seat {
            cursor: default;
            flex: 0 0 var(--seat-size);
            width: var(--seat-size);
            margin: 0 .5rem 0 0; /* jarak swatch -> teks seragam */
        }

        .seating-map .legend .stage-bar {
            margin: 0 .5rem 0 0;
        }

        /* ===== Seat assign toolbar ===== */
        #seatToolbar .form-control-sm {
            font-size: .85rem;
        }

        #seatToolbar .view-toggle {
            display: inline-flex;
            gap: 4px;
        }

        #seatToolbar .view-btn {
            height: 26px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            background: #fff;
            color: #6c757d;
            padding: 0 8px;
            font-size: 12px;
            line-height: 1;
        }

        #seatToolbar .view-btn:hover {
            border-color: #6c757d;
            color: #6c757d;
        }

        #seatToolbar .view-btn.active {
            background: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }

        /* Tanpa !important — supaya jQuery .hide() (inline display:none) tetap menang */
        #seatRegEmpty {
            display: flex;
            align-items: center;
            min-height: 38px;
        }

        #seatSearchResults {
            display: none;
        }

        #seatSearchResults.show {
            display: block;
        }

        #seatSearchResults .list-group-item {
            cursor: pointer;
            padding: .4rem .6rem;
            font-size: .8rem;
        }

        #seatSearchResults .list-group-item:hover,
        #seatSearchResults .list-group-item.active {
            background-color: #e9ecef;
        }

        .seat-attendee-item {
            display: flex;
            align-items: center;
            gap: .5rem;
            padding: .25rem .5rem;
            border: 1px solid #dee2e6;
            border-radius: .25rem;
            margin-bottom: .3rem;
            font-size: .8rem;
            cursor: pointer;
        }

        .seat-attendee-item:hover {
            background-color: #f8f9fa;
        }

        .seat-attendee-item input {
            margin: 0;
        }

        .seating-map .seat.seat-releasable {
            box-shadow: 0 0 0 2px rgba(220, 53, 69, .45);
        }

        /* Reserved for a booking (act_seating_seat.bookingid) */
        .seating-map .seat.seat-reserved {
            background: #0d6efd;
            border-color: #0a58ca;
            color: #fff;
        }

        .seating-map .seat.seat-reserved:hover {
            background: #0a58ca;
            border-color: #084298;
        }

        .seating-map .seat[data-reg]:not([data-reg="0"]) {
            cursor: pointer;
        }
    </style>
</head>

<body class="<?php $this->load->view('partial/activities/body-class'); ?>">
    <div class="wrapper">
        <?php $this->load->view('partial/activities/sidebar.php') ?>

        <div class="content-wrapper py-4 px-4 text-sm">

            <?php
            /* ---------- Seating data dari database (act_seating_floor / _row / _slot)
               Seed: sql/2026-10-13-00001.sql — source awal context/SYSTEM/0002-Seating-Layout.md ---------- */

            $floors = $this->db->order_by('sort_order')->get('act_seating_floor')->result_array();
            $all_rows = $this->db->order_by('floor_id, sort_order')->get('act_seating_row')->result_array();
            $all_slots = $this->db->order_by('row_id, sort_order')->get('act_seating_slot')->result_array();

            $rows_by_floor = [];
            foreach ($all_rows as $r) {
                $rows_by_floor[$r['floor_id']][] = $r;
            }
            $slots_by_row = [];
            foreach ($all_slots as $s) {
                $slots_by_row[$s['row_id']][] = $s;
            }

            /* Per-seat state (derived from act_seating_seat + attendee.status):
               hanya attendee confirmed (status=1) yang dianggap terisi */
            $seat_state = [];
            $seat_q = $this->db->query(
                'SELECT s.floor_id, s.seat_number, s.registrationid AS seat_regid, s.bookingid AS seat_bookingid, a.status AS attendee_status, a.name AS attendee_name, r.ref_code
                 FROM act_seating_seat s
                 LEFT JOIN act_xmas_attendee a ON a.attendeeid = s.attendeeid
                 LEFT JOIN act_xmas_registration r ON r.registrationid = s.registrationid
                 ORDER BY s.floor_id, s.seat_number'
            );
            foreach ($seat_q->result_array() as $sr) {
                $seat_state[(int) $sr['floor_id']][(int) $sr['seat_number']] = [
                    'confirmed' => ((int) ($sr['attendee_status'] ?? 0) === 1),
                    'name' => (string) ($sr['attendee_name'] ?? ''),
                    'ref' => (string) ($sr['ref_code'] ?? ''),
                    'regid' => (int) ($sr['seat_regid'] ?? 0),
                    'bookingid' => (int) ($sr['seat_bookingid'] ?? 0),
                ];
            }

            function seating_render_rows($rows, $start_number, $norm_units, $norm_aisles, $seat_state = [])
            {
                $n = (int) $start_number;
                $html = '';

                foreach ($rows as $i => $row) {
                    /* snake: baris ganjil-index (1,3,5...) dibaca kanan->kiri */
                    $reverse = ($i % 2 === 1);
                    $row_no_aisle = !empty($row['no_aisle']);

                    $children = [];
                    $units = 0;
                    $aisles = 0;
                    $row_first = $n; /* nomor seat pertama baris ini */
                    $seat_slot = 0; /* slot seat visual kiri->kanan (untuk penomoran snake) */

                    /* Slot DB = urutan visual kiri->kanan (mirror struktur children lama) */
                    foreach ($row['slots'] as $sl) {
                        $type = $sl['type'];
                        $uc = (int) $sl['units'];
                        $cnt = (int) $sl['seat_count'];

                        if ($type === 'seat') {
                            $children[] = ['t' => 'seats', 'from' => $n, 'count' => $cnt];
                            $units += $cnt;
                            $n += $cnt;
                        } elseif ($type === 'aisle') {
                            $children[] = ['t' => 'aisle'];
                            $aisles += 1;
                        } elseif ($type === 'hidden') {
                            $children[] = ['t' => 'hidden', 'size' => $uc];
                            $units += $uc;
                        } elseif ($type === 'table') {
                            $children[] = ['t' => 'table'];
                            $units += 1;
                        } elseif ($type === 'pillar') {
                            $children[] = ['t' => 'pillar'];
                            $units += 1;
                        } elseif ($type === 'empty') {
                            $children[] = ['t' => 'blank'];
                            $units += 1;
                        }
                    }

                    /* Normalisasi: semua baris = $norm_units unit + $norm_aisles lorong
                       supaya lebar tiap seat selalu sama di seluruh denah */
                    $pad = (int) $norm_units - $units;
                    if ($pad > 0) {
                        $children[] = ['t' => 'pad', 'size' => $pad];
                        $units += $pad;
                    }

                    /* Snake flow: urutan child (posisi hidden/table/pillar/empty) TIDAK diubah —
                       hanya nomor seat yang diisi sesuai arah baca baris ini */
                    $row_last = $n - 1;

                    $cells = '';
                    foreach ($children as $ch) {
                        if ($ch['t'] === 'aisle') {
                            $cells .= '<div class="seat-aisle"></div>';
                        } elseif ($ch['t'] === 'table') {
                            $cells .= '<div class="seat-block" style="flex-grow: 1"><div class="seat seat-table" title="Meja (table)"></div></div>';
                        } elseif ($ch['t'] === 'blank') {
                            $cells .= '<div class="seat-block" style="flex-grow: 1"><div class="seat seat-blank" title="Empty seat"></div></div>';
                        } elseif ($ch['t'] === 'pillar') {
                            $cells .= '<div class="seat-block" style="flex-grow: 1"><div class="seat seat-pillar-box" title="Pillar"></div></div>';
                        } elseif ($ch['t'] === 'hidden') {
                            $cells .= '<div class="seat-block" style="flex-grow: ' . $ch['size'] . '">';
                            for ($x = 0; $x < $ch['size']; $x++) {
                                $cells .= '<div class="hseat"></div>';
                            }
                            $cells .= '</div>';
                        } elseif ($ch['t'] === 'pad') {
                            $cells .= '<div class="seat-block" style="flex-grow: ' . $ch['size'] . '">';
                            for ($x = 0; $x < $ch['size']; $x++) {
                                $cells .= '<div class="seat seat-empty"></div>';
                            }
                            $cells .= '</div>';
                        } elseif ($ch['t'] === 'seats') {
                            $cells .= '<div class="seat-block" style="flex-grow: ' . $ch['count'] . '">';
                            for ($s = 0; $s < $ch['count']; $s++) {
                                /* snake: slot visual kiri->kanan diisi nomor naik (baris normal)
                                   atau turun (baris balik) supaya urutan baca sambung-menyambung */
                                $no = $reverse
                                    ? ($row_last - $seat_slot)
                                    : ($row_first + $seat_slot);
                                $seat_slot++;
                                $st = $seat_state[$no] ?? null;
                                $cls = 'seat';
                                $title = 'Seat ' . $no;
                                $regid = 0;
                                $bid = (int) ($st['bookingid'] ?? 0);
                                if (!empty($st['confirmed'])) {
                                    $cls .= ' seat-confirmed';
                                    $regid = (int) ($st['regid'] ?? 0);
                                    if ($st['name'] !== '') {
                                        $title .= ' — ' . $st['name']
                                            . ($st['ref'] !== '' ? ' (' . $st['ref'] . ')' : '')
                                            . ' — Confirmed';
                                    }
                                } elseif ($bid > 0) {
                                    $cls .= ' seat-reserved';
                                    $title .= ' — Reserved (booking #' . $bid . ')';
                                }
                                $cells .= '<div class="' . $cls . '" data-seat="' . $no . '" data-reg="' . $regid . '" data-booking="' . $bid . '" title="' . htmlspecialchars($title) . '">' . $no . '</div>';
                            }
                            $cells .= '</div>';
                        }
                    }

                    $row_norm_aisles = $row_no_aisle ? 0 : (int) $norm_aisles;
                    for ($a = $aisles; $a < $row_norm_aisles; $a++) {
                        $cells .= '<div class="seat-aisle"></div>';
                    }

                    if (!empty($row['divider_caption'])) { /* pemisah area (mis. FoH) sebelum baris ini */
                        $html .= '<div class="seat-divider"></div>';
                        $html .= '<div class="seat-caption"><i class="fas fa-arrow-alt-circle-down mr-1"></i> ' . htmlspecialchars($row['divider_caption']) . '</div>';
                    }

                    $label = ($row['label'] !== null && $row['label'] !== '') ? $row['label'] : (string) ($i + 1);
                    $html .= '<div class="seat-row"><div class="row-label">' . htmlspecialchars($label) . '</div>' . $cells . '</div>';
                }

                return ['html' => $html, 'next' => $n];
            }

            /* Render semua floor dari data DB — snake paritas dihitung dari urutan baris,
               jadi baris back (FoH) sambung otomatis tanpa parameter terpisah */
            $floor_render = [];
            $grand_total = 0;
            foreach ($floors as $f) {
                $rows = $rows_by_floor[$f['id']] ?? [];
                foreach ($rows as &$r) {
                    $r['slots'] = $slots_by_row[$r['id']] ?? [];
                }
                unset($r);

                $res = seating_render_rows($rows, (int) $f['start_number'], (int) $f['norm_units'], (int) $f['norm_aisles'], $seat_state[(int) $f['id']] ?? []);
                $count = $res['next'] - (int) $f['start_number'];
                $grand_total += $count;
                $floor_render[] = [
                    'floor' => $f,
                    'html' => $res['html'],
                    'count' => $count,
                    'first' => (int) $f['start_number'],
                    'last' => $res['next'] - 1,
                ];
            }
            ?>

            <!-- Summary -->
            <div class="row">
                <?php foreach ($floor_render as $fr) : ?>
                <div class="col-12 col-md-4 mb-2">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-secondary"><i class="fas <?php echo htmlspecialchars($fr['floor']['icon_class']); ?>"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><?php echo htmlspecialchars($fr['floor']['name']); ?></span>
                            <span class="info-box-number"><?php echo (int) $fr['count']; ?> seats</span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <div class="col-12 col-md-4 mb-2">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-building"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Grand Total</span>
                            <span class="info-box-number"><?php echo (int) $grand_total; ?> seats</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assign Seats Toolbar (admin) -->
            <div class="card card-outline card-secondary mb-3" id="seatToolbar">
                <div class="card-header py-1 px-2 d-flex align-items-center">
                    <h3 class="card-title text-sm py-1 mb-0"><i class="fas fa-user-check mr-1"></i> Assign Seats</h3>
                    <div class="view-toggle ml-auto" role="group" aria-label="Assign mode">
                        <button type="button" class="view-btn active" id="btnModeReg"><i class="fas fa-users"></i> Registration</button>
                        <button type="button" class="view-btn" id="btnModeBook"><i class="fas fa-bookmark"></i> Booking</button>
                    </div>
                </div>
                <div class="card-body py-2">

                    <!-- ===== Mode: Registration ===== -->
                    <div class="row" id="modeRegWrap">
                        <div class="col-12 col-md-5 mb-2 mb-md-0">
                            <label class="mb-1 d-block"><i class="fas fa-search mr-1 text-muted"></i> Search Registration <small class="text-muted">(code / phone / name)</small></label>
                            <input type="text" class="form-control form-control-sm" id="seatSearch" placeholder="5-char code / 08xx / name" autocomplete="off">
                            <div id="seatSearchResults" class="list-group mt-1"></div>
                            <small class="text-muted d-block mt-1">Registrations with <b>pending</b> attendees still appear (yellow badge) — attendees must be <b>Confirmed</b> in the Registration menu before seats can be assigned.</small>
                        </div>
                        <div class="col-12 col-md-7">
                            <div id="seatRegEmpty" class="text-muted">
                                <i class="fas fa-info-circle mr-1"></i> Search for a registration to start assigning / releasing seats.
                            </div>
                            <div id="seatRegPanel" style="display:none">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong id="seatRegTitle" class="text-sm"></strong><br>
                                        <small class="text-muted" id="seatRegMeta"></small>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="seatRegClear" title="Clear selection">&times;</button>
                                </div>
                                <div id="seatRegAttendees" class="mb-2" style="max-height:150px;overflow:auto"></div>
                                <div class="d-flex align-items-center flex-wrap">
                                    <span class="badge badge-info mr-2" id="seatSelCount">0 seat(s) selected</span>
                                    <span class="badge badge-warning mr-2 d-none" id="seatAttCount">0 attendee(s)</span>
                                    <button type="button" class="btn btn-sm btn-primary mr-1" id="seatAssignBtn" disabled><i class="fas fa-chair mr-1"></i> Assign</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="seatReleaseBtn" disabled><i class="fas fa-undo mr-1"></i> Release</button>
                                    <small class="text-muted d-block w-100 mt-1">Click seats on the map: empty seat = assign, seat owned by this registration (red outline) = release.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== Mode: Booking ===== -->
                    <div class="row" id="modeBookWrap" style="display:none">
                        <div class="col-12 col-md-5 mb-2 mb-md-0">
                            <label class="mb-1 d-block"><i class="fas fa-search mr-1 text-muted"></i> Search Booking <small class="text-muted">(notes / floor / #id)</small></label>
                            <input type="text" class="form-control form-control-sm" id="seatBookSearch" placeholder="e.g. name / 08xx / Floor 1" autocomplete="off">
                            <div id="seatBookResults" class="list-group mt-1"></div>
                            <small class="text-muted d-block mt-1">Booking seats are reserved <b>exclusively</b> for the booking (final) — registrants cannot occupy them. Leave empty to list active bookings.</small>
                        </div>
                        <div class="col-12 col-md-7">
                            <div id="seatBookEmpty" class="text-muted">
                                <i class="fas fa-info-circle mr-1"></i> Search for a booking to start reserving / releasing seats.
                            </div>
                            <div id="seatBookPanel" style="display:none">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong id="seatBookTitle" class="text-sm"></strong><br>
                                        <small class="text-muted" id="seatBookMeta"></small>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="seatBookClear" title="Clear selection">&times;</button>
                                </div>
                                <div class="d-flex align-items-center flex-wrap">
                                    <span class="badge badge-info mr-2" id="bookSelCount">0 seat(s) selected</span>
                                    <button type="button" class="btn btn-sm btn-primary mr-1" id="seatBookAssignBtn" disabled><i class="fas fa-bookmark mr-1"></i> Reserve</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="seatBookReleaseBtn" disabled><i class="fas fa-undo mr-1"></i> Release</button>
                                    <small class="text-muted d-block w-100 mt-1">Click empty seats on the map to reserve them for this booking, or click the blue seats of this booking (red outline) to release them.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Floors -->
            <div class="row align-items-start">
                <?php foreach ($floor_render as $fr) :
                    $f = $fr['floor']; ?>
                <!-- ===== <?php echo htmlspecialchars($f['name']); ?> ===== -->
                <div class="col-12 mb-3">
                    <div class="card card-outline card-secondary mb-0 h-100">
                        <div class="card-header py-1 px-2">
                            <h3 class="card-title text-sm py-1 mb-0"><i class="fas <?php echo htmlspecialchars($f['icon_class']); ?> mr-1"></i> <?php echo htmlspecialchars($f['name']); ?> (Seats <?php echo (int) $fr['first']; ?>–<?php echo (int) $fr['last']; ?>)</h3>
                        </div>
                        <div class="card-body py-2 seating-map" data-floor="<?php echo (int) $f['id']; ?>">
                            <div class="map-scroll">
                                <div style="min-width: 460px; width: 100%;">
                                    <div class="stage-bar">STAGE</div>
                                    <div class="stage-arrow"><i class="fas fa-arrow-down"></i> audience</div>

                                    <?php echo $fr['html']; ?>
                                </div>
                            </div>
                            <?php if (!empty($f['caption'])) : ?>
                            <div class="seat-caption mt-2"><?php echo htmlspecialchars($f['caption']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Legend (paling bawah, tanpa card) -->
            <div class="seating-map">
                <div class="seat-divider mb-2"></div>
                <div class="legend mb-0">
                    <span class="d-inline-flex align-items-center"><span class="seat me-2">1</span> Available</span>
                    <span class="d-inline-flex align-items-center"><span class="seat seat-confirmed me-2"></span> Confirmed</span>
                    <span class="d-inline-flex align-items-center"><span class="seat seat-reserved me-2"></span> Reserved (booking)</span>
                    <span class="d-inline-flex align-items-center"><span class="seat seat-selected me-2"></span> Selected</span>
                    <span class="d-inline-flex align-items-center"><span class="seat seat-blank me-2"></span> Empty</span>
                    <span class="d-inline-flex align-items-center"><span class="seat seat-table me-2"></span> Table</span>
                    <span class="d-inline-flex align-items-center"><span class="seat seat-pillar-box me-2"></span> Pillar</span>
                    <span class="d-inline-flex align-items-center"><span class="stage-bar px-2 py-1 me-2" style="font-size:.6rem;">STAGE</span> Stage</span>
                    <span class="text-muted">Viewed from above &mdash; stage at the front (top)</span>
                </div>
            </div>

        </div>

        <?php $this->load->view('partial/activities/footer.php') ?>
    </div>

    <?php $this->load->view('partial/activities/foot.php') ?>

    <script>
        (function () {
            var seatSearchEndpoint = '<?php echo site_url("activities/layout/seat_search") ?>';
            var seatAttendeesEndpoint = '<?php echo site_url("activities/layout/seat_attendees") ?>';
            var seatAssignEndpoint = '<?php echo site_url("activities/layout/seat_assign") ?>';
            var seatReleaseEndpoint = '<?php echo site_url("activities/layout/seat_release") ?>';
            var seatBookSearchEndpoint = '<?php echo site_url("activities/layout/seat_booking_search") ?>';
            var seatBookAssignEndpoint = '<?php echo site_url("activities/layout/seat_booking_assign") ?>';
            var seatBookReleaseEndpoint = '<?php echo site_url("activities/layout/seat_booking_release") ?>';

            /* Active registration state + multi-select seats (client-side).
               Available = green ready to assign; confirmed reg active (red outline) = ready to release.
               Booking mode: empty seat = reserve for booking; blue seat of this booking = release. */
            var mode = 'reg';
            var currentReg = null;
            var currentBooking = null;
            var searchTimer = null;
            var bookTimer = null;
            var lastSearchRows = {};
            var lastBookRows = {};

            function escapeHtml(val) {
                return $('<div>').text(val == null ? '' : String(val)).html();
            }

            function toast(icon, title, text) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: icon,
                    title: title,
                    text: text || '',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });
            }

            function selectedSeats() {
                var seats = [];
                $('.seating-map .seat.seat-selected').each(function () {
                    seats.push({
                        number: parseInt($(this).data('seat'), 10),
                        reg: parseInt($(this).data('reg'), 10) || 0,
                        booking: parseInt($(this).data('booking'), 10) || 0
                    });
                });
                return seats;
            }

            function checkedAttendees() {
                var ids = [];
                $('#seatRegAttendees input[type="checkbox"]:checked').each(function () {
                    ids.push(parseInt($(this).val(), 10));
                });
                return ids;
            }

            function updateButtons() {
                var seats = selectedSeats();

                if (mode === 'booking') {
                    var free = 0, own = 0, other = 0;
                    seats.forEach(function (s) {
                        if (s.booking && currentBooking && s.booking === currentBooking.bookingid) own++;
                        else if (s.booking) other++;
                        else free++;
                    });
                    $('#bookSelCount').text(seats.length + ' seat(s) selected');
                    var canReserve = !!(currentBooking && free > 0 && own === 0 && other === 0 &&
                        (Number(currentBooking.assigned_count) + free) <= Number(currentBooking.seats));
                    var canRelease = !!(currentBooking && own > 0 && own === seats.length && free === 0 && other === 0);
                    $('#seatBookAssignBtn').prop('disabled', !canReserve);
                    $('#seatBookReleaseBtn').prop('disabled', !canRelease);
                    return;
                }

                var atts = checkedAttendees();
                var freeCount = 0;
                var regCount = 0;
                seats.forEach(function (s) {
                    if (s.reg) regCount++; else freeCount++;
                });

                $('#seatSelCount').text(seats.length + ' seat(s) selected');
                if (currentReg) {
                    $('#seatAttCount').removeClass('d-none').text(atts.length + ' attendee(s) checked');
                }

                var canAssign = !!(currentReg && freeCount > 0 && freeCount === atts.length && regCount === 0);
                var canRelease = !!(currentReg && regCount > 0 && regCount === seats.length && freeCount === 0);
                $('#seatAssignBtn').prop('disabled', !canAssign);
                $('#seatReleaseBtn').prop('disabled', !canRelease);
            }

            function clearSeatSelection() {
                $('.seating-map .seat.seat-selected').removeClass('seat-selected');
            }

            function markReleasableSeats(regId) {
                $('.seating-map .seat').removeClass('seat-releasable');
                if (regId) {
                    $('.seating-map .seat[data-reg="' + regId + '"]').addClass('seat-releasable');
                }
            }

            function markBookingSeats(bookingid) {
                $('.seating-map .seat').removeClass('seat-releasable');
                if (bookingid) {
                    $('.seating-map .seat[data-booking="' + bookingid + '"]').addClass('seat-releasable');
                }
            }

            function setMode(m) {
                if (mode === m) return;
                mode = m;
                $('#btnModeReg').toggleClass('active', m === 'reg');
                $('#btnModeBook').toggleClass('active', m === 'booking');
                $('#modeRegWrap').toggle(m === 'reg');
                $('#modeBookWrap').toggle(m === 'booking');
                clearSeatSelection();
                clearReg();
                clearBooking();
            }

            function selectBooking(b) {
                currentBooking = {
                    bookingid: parseInt(b.bookingid, 10) || 0,
                    floor: parseInt(b.floor, 10) || 0,
                    seats: parseInt(b.seats, 10) || 0,
                    name: b.name || '',
                    keterangan: b.keterangan || '',
                    assigned_count: parseInt(b.assigned_count, 10) || 0
                };
                clearSeatSelection();
                markBookingSeats(currentBooking.bookingid);
                $('#seatBookEmpty').hide();
                $('#seatBookPanel').show();
                $('#seatBookTitle').text('#' + currentBooking.bookingid + ' · ' + (currentBooking.name || currentBooking.keterangan) + ' — ' + (b.floor_name || ('Floor ' + currentBooking.floor)));
                $('#seatBookMeta').html((currentBooking.keterangan ? escapeHtml(currentBooking.keterangan) + ' &middot; ' : '') + '<b>' + currentBooking.assigned_count + ' of ' + currentBooking.seats + '</b> seat(s) reserved');
                $('#seatBookResults').empty().removeClass('show');
                if (currentBooking.assigned_count >= currentBooking.seats) {
                    toast('info', 'Booking is full', 'All ' + currentBooking.seats + ' seat(s) are already reserved.');
                }
                updateButtons();
            }

            function clearBooking() {
                currentBooking = null;
                clearSeatSelection();
                markBookingSeats(0);
                $('#seatBookTitle').text('');
                $('#seatBookMeta').empty();
                $('#seatBookPanel').hide();
                $('#seatBookEmpty').show();
                $('#seatBookResults').empty().removeClass('show');
                $('#seatBookAssignBtn, #seatBookReleaseBtn').prop('disabled', true);
                $('#bookSelCount').text('0 seat(s) selected');
            }

            $('#btnModeReg').on('click', function () { setMode('reg'); });
            $('#btnModeBook').on('click', function () { setMode('booking'); });
            $('#seatBookClear').on('click', clearBooking);

            function renderAttendees(attendees) {
                var html = '';
                var hasPending = false;
                (attendees || []).forEach(function (a) {
                    var seated = a.seat_number ? 'Seat ' + a.seat_number : 'No seat';
                    var badgeCls = a.seat_number ? 'badge-success' : 'badge-secondary';
                    var checked = '';
                    var disabled = '';
                    var statusTag = '';
                    if (a.status == 1) {
                        checked = a.seat_number ? '' : 'checked';
                    } else {
                        hasPending = true;
                        disabled = 'disabled';
                        statusTag = '<span class="badge badge-warning mr-1">Pending</span>';
                    }
                    html +=
                        '<label class="seat-attendee-item mb-1" title="' + (disabled ? 'Attendee not confirmed yet — confirm first in the Registration menu' : '') + '">' +
                        '<input type="checkbox" value="' + a.attendeeid + '" ' + checked + ' ' + disabled + '>' +
                        statusTag +
                        '<span class="flex-grow-1">' + escapeHtml(a.name) + '</span>' +
                        '<span class="badge ' + badgeCls + '">' + escapeHtml(seated) + '</span>' +
                        '</label>';
                });
                $('#seatRegAttendees').html(html || '<div class="text-muted">No attendees</div>');
                if (hasPending) {
                    $('#seatRegAttendees').prepend(
                        '<div class="alert alert-warning py-1 px-2 mb-1 text-xs" style="font-size:.75rem">' +
                        '<i class="fas fa-exclamation-triangle mr-1"></i> Attendees with <b>pending</b> status cannot select seats. ' +
                        'Confirm them first in the <a href="<?= site_url("activities/registration") ?>" target="_blank">Registration</a> menu.' +
                        '</div>'
                    );
                }
            }

            function selectReg(reg) {
                reg.registrationid = parseInt(reg.registrationid, 10) || 0;
                reg.floor = parseInt(reg.floor, 10) || 0;
                currentReg = reg;
                clearSeatSelection();
                markReleasableSeats(reg.registrationid);
                $('#seatRegEmpty').hide();
                $('#seatRegPanel').show();
                $('#seatRegTitle').text(reg.ref_code + ' — Floor ' + reg.floor);
                var pendingN = parseInt(reg.pending_count, 10) || 0;
                var confN = parseInt(reg.confirmed_count, 10) || 0;
                $('#seatRegMeta').html(
                    escapeHtml(reg.phone || '') + ' · <b>' + confN + ' confirmed</b> (' + (parseInt(reg.seated_count, 10) || 0) + ' seated)' +
                    (pendingN ? ' · <span class="text-warning">' + pendingN + ' pending</span>' : '')
                );
                if (confN === 0) {
                    toast('info', 'No confirmed attendees yet', 'Confirm attendees in the Registration menu before assigning seats');
                }
                $('#seatSearchResults').empty().removeClass('show');

                $.getJSON(seatAttendeesEndpoint, { registrationid: reg.registrationid })
                    .done(function (res) {
                        if (!res.success) {
                            toast('error', 'Failed', res.message);
                            return;
                        }
                        renderAttendees(res.data.attendees);
                        updateButtons();
                    })
                    .fail(function () {
                        toast('error', 'Error', 'Could not reach server');
                    });
            }

            function clearReg() {
                currentReg = null;
                clearSeatSelection();
                markReleasableSeats(0);
                $('#seatRegAttendees').empty();
                $('#seatRegTitle').text('');
                $('#seatRegMeta').empty();
                $('#seatRegPanel').hide();
                $('#seatRegEmpty').show();
                $('#seatAssignBtn, #seatReleaseBtn').prop('disabled', true);
                $('#seatAttCount').addClass('d-none');
                $('#seatSelCount').text('0 seat(s) selected');
            }

            /* Search */
            $('#seatSearch').on('input', function () {
                var q = $.trim($(this).val());
                clearTimeout(searchTimer);
                if (!q) {
                    $('#seatSearchResults').empty().removeClass('show');
                    return;
                }
                searchTimer = setTimeout(function () {
                    $.getJSON(seatSearchEndpoint, { q: q })
                        .done(function (res) {
                            var $box = $('#seatSearchResults');
                            $box.empty();
                            lastSearchRows = {};
                            if (!res.success || !res.data || !res.data.length) {
                                $box.html('<div class="list-group-item text-muted">No matching registration. Try 5-char code / phone / name.</div>').addClass('show');
                                return;
                            }
                            res.data.forEach(function (r) {
                                lastSearchRows[r.registrationid] = r;
                                var conf = parseInt(r.confirmed_count, 10) || 0;
                                var pend = parseInt(r.pending_count, 10) || 0;
                                var statusBadge = conf > 0
                                    ? '<span class="badge badge-success">Ready</span>'
                                    : '<span class="badge badge-warning">Pending</span>';
                                $box.append(
                                    '<button type="button" class="list-group-item list-group-item-action" data-regid="' + r.registrationid + '">' +
                                    '<div class="d-flex justify-content-between align-items-start">' +
                                    '<strong>' + escapeHtml(r.ref_code) + '</strong> ' + statusBadge +
                                    '</div>' +
                                    '<small class="text-muted d-block">Floor ' + escapeHtml(r.floor) + ' · ' + escapeHtml(r.phone || '') +
                                    ' · ' + conf + ' confirmed' + (pend ? ' · ' + pend + ' pending' : '') + ' · ' + (parseInt(r.seated_count, 10) || 0) + ' seated</small>' +
                                    '</button>'
                                );
                            });
                            $box.addClass('show');
                        })
                        .fail(function () {
                            toast('error', 'Error', 'Could not reach server');
                        });
                }, 350);
            });

            $('#seatSearchResults').on('click', '[data-regid]', function () {
                var regid = $(this).data('regid');
                var r = lastSearchRows[regid];
                if (!r) return;
                selectReg(r);
            });

            $('#seatRegClear').on('click', clearReg);

            /* Booking search */
            $('#seatBookSearch').on('input', function () {
                var q = $.trim($(this).val());
                clearTimeout(bookTimer);
                bookTimer = setTimeout(function () {
                    $.getJSON(seatBookSearchEndpoint, { q: q })
                        .done(function (res) {
                            var $box = $('#seatBookResults');
                            $box.empty();
                            lastBookRows = {};
                            if (!res.success || !res.data || !res.data.length) {
                                $box.html('<div class="list-group-item text-muted">No active booking found. Try notes / floor / #id.</div>').addClass('show');
                                return;
                            }
                            res.data.forEach(function (b) {
                                lastBookRows[b.bookingid] = b;
                                var assigned = parseInt(b.assigned_count, 10) || 0;
                                var total = parseInt(b.seats, 10) || 0;
                                var badge = (total > 0 && assigned >= total)
                                    ? '<span class="badge badge-secondary">Full</span>'
                                    : '<span class="badge badge-success">' + assigned + '/' + total + '</span>';
                                $box.append(
                                    '<button type="button" class="list-group-item list-group-item-action" data-bookingid="' + b.bookingid + '">' +
                                    '<div class="d-flex justify-content-between align-items-start">' +
                                    '<strong>#' + b.bookingid + ' &middot; ' + escapeHtml(b.name || b.keterangan) + '</strong> ' + badge +
                                    '</div>' +
                                    '<small class="text-muted d-block">' + escapeHtml(b.floor_name || ('Floor ' + b.floor)) +
                                    (b.phone ? ' &middot; ' + escapeHtml(b.phone) : '') +
                                    ' &middot; ' + assigned + ' of ' + total + ' seat(s) reserved</small>' +
                                    '</button>'
                                );
                            });
                            $box.addClass('show');
                        })
                        .fail(function () {
                            toast('error', 'Error', 'Could not reach server');
                        });
                }, 350);
            });

            $('#seatBookResults').on('click', '[data-bookingid]', function () {
                var b = lastBookRows[$(this).data('bookingid')];
                if (b) selectBooking(b);
            });

            $('#seatRegAttendees').on('change', 'input[type="checkbox"]', updateButtons);

            /* Seat click */
            $(document).on('click', '.seating-map .seat[data-seat]', function () {
                var $s = $(this);

                if (mode === 'booking') {
                    if ($s.hasClass('seat-confirmed')) return;
                    var bid = parseInt($s.data('booking'), 10) || 0;
                    if (bid > 0) {
                        if (currentBooking && bid === currentBooking.bookingid) {
                            $s.toggleClass('seat-selected');
                            updateButtons();
                        } else {
                            toast('info', 'Reserved for another booking', 'Seat ' + $s.data('seat') + ' belongs to booking #' + bid);
                        }
                        return;
                    }
                    if (!currentBooking) return;
                    $s.toggleClass('seat-selected');
                    updateButtons();
                    return;
                }

                if ($s.hasClass('seat-confirmed')) {
                    if (currentReg && parseInt($s.data('reg'), 10) === currentReg.registrationid) {
                        $s.toggleClass('seat-selected');
                        updateButtons();
                    }
                    return;
                }
                if (parseInt($s.data('booking'), 10) > 0) {
                    toast('info', 'Reserved for a booking', 'Seat ' + $s.data('seat') + ' is held by a booking — switch to Booking mode to release it.');
                    return;
                }
                $s.toggleClass('seat-selected');
                updateButtons();
            });

            /* Assign */
            $('#seatAssignBtn').on('click', function () {
                var $btn = $(this);
                var atts = checkedAttendees();
                var seats = selectedSeats().map(function (s) { return s.number; }).sort(function (a, b) { return a - b; });
                if (!currentReg || !atts.length || !seats.length) return;

                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
                $.post(seatAssignEndpoint, {
                    registrationid: currentReg.registrationid,
                    floor_id: currentReg.floor,
                    attendees: atts,
                    seats: seats
                })
                    .done(function (res) {
                        if (res.success) {
                            toast('success', 'Assigned!', res.message);
                            setTimeout(function () { location.reload(); }, 900);
                        } else {
                            toast('error', 'Failed', res.message);
                            $btn.prop('disabled', false).html('<i class="fas fa-chair mr-1"></i> Assign');
                        }
                    })
                    .fail(function () {
                        toast('error', 'Error', 'Could not reach server');
                        $btn.prop('disabled', false).html('<i class="fas fa-chair mr-1"></i> Assign');
                    });
            });

            /* Release */
            $('#seatReleaseBtn').on('click', function () {
                var $btn = $(this);
                var seats = selectedSeats().map(function (s) { return s.number; });
                if (!currentReg || !seats.length) return;

                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
                $.post(seatReleaseEndpoint, {
                    floor_id: currentReg.floor,
                    seats: seats,
                    registrationid: currentReg.registrationid
                })
                    .done(function (res) {
                        if (res.success) {
                            toast('success', 'Released!', res.message);
                            setTimeout(function () { location.reload(); }, 900);
                        } else {
                            toast('error', 'Failed', res.message);
                            $btn.prop('disabled', false).html('<i class="fas fa-undo mr-1"></i> Release');
                        }
                    })
                    .fail(function () {
                        toast('error', 'Error', 'Could not reach server');
                        $btn.prop('disabled', false).html('<i class="fas fa-undo mr-1"></i> Release');
                    });
            });

            /* Reserve (booking mode) */
            $('#seatBookAssignBtn').on('click', function () {
                var $btn = $(this);
                var seats = selectedSeats().map(function (s) { return s.number; }).sort(function (a, b) { return a - b; });
                if (!currentBooking || !seats.length) return;

                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
                $.post(seatBookAssignEndpoint, {
                    bookingid: currentBooking.bookingid,
                    floor_id: currentBooking.floor,
                    seats: seats
                })
                    .done(function (res) {
                        if (res.success) {
                            toast('success', 'Reserved!', res.message);
                            setTimeout(function () { location.reload(); }, 900);
                        } else {
                            toast('error', 'Failed', res.message);
                            $btn.prop('disabled', false).html('<i class="fas fa-bookmark mr-1"></i> Reserve');
                        }
                    })
                    .fail(function () {
                        toast('error', 'Error', 'Could not reach server');
                        $btn.prop('disabled', false).html('<i class="fas fa-bookmark mr-1"></i> Reserve');
                    });
            });

            /* Release booking seats */
            $('#seatBookReleaseBtn').on('click', function () {
                var $btn = $(this);
                var seats = selectedSeats().map(function (s) { return s.number; });
                if (!currentBooking || !seats.length) return;

                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
                $.post(seatBookReleaseEndpoint, {
                    bookingid: currentBooking.bookingid,
                    floor_id: currentBooking.floor,
                    seats: seats
                })
                    .done(function (res) {
                        if (res.success) {
                            toast('success', 'Released!', res.message);
                            setTimeout(function () { location.reload(); }, 900);
                        } else {
                            toast('error', 'Failed', res.message);
                            $btn.prop('disabled', false).html('<i class="fas fa-undo mr-1"></i> Release');
                        }
                    })
                    .fail(function () {
                        toast('error', 'Error', 'Could not reach server');
                        $btn.prop('disabled', false).html('<i class="fas fa-undo mr-1"></i> Release');
                    });
            });
        })();
    </script>
</body>

</html>
