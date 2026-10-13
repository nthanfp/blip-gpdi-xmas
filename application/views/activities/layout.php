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

            function seating_render_rows($rows, $start_number, $norm_units, $norm_aisles)
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
                            $cells .= '<div class="seat-block" style="flex-grow: 1"><div class="seat seat-pillar-box" title="Pilar penyangga"></div></div>';
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
                                $cells .= '<div class="seat" data-seat="' . $no . '" title="Seat ' . $no . '">' . $no . '</div>';
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

                $res = seating_render_rows($rows, (int) $f['start_number'], (int) $f['norm_units'], (int) $f['norm_aisles']);
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
                        <span class="info-box-icon bg-secondary"><i class="<?php echo htmlspecialchars($fr['floor']['icon_class']); ?>"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><?php echo htmlspecialchars($fr['floor']['name']); ?></span>
                            <span class="info-box-number"><?php echo (int) $fr['count']; ?> seats</span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <div class="col-12 col-md-4 mb-2">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-couch"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Grand Total</span>
                            <span class="info-box-number"><?php echo (int) $grand_total; ?> seats</span>
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
                            <h3 class="card-title text-sm py-1 mb-0"><i class="<?php echo htmlspecialchars($f['icon_class']); ?> mr-1"></i> <?php echo htmlspecialchars($f['name']); ?> (Seats <?php echo (int) $fr['first']; ?>–<?php echo (int) $fr['last']; ?>)</h3>
                        </div>
                        <div class="card-body py-2 seating-map" data-floor="<?php echo (int) $f['id']; ?>">
                            <div class="map-scroll">
                                <div style="min-width: 460px; width: 100%;">
                                    <div class="stage-bar">PANGGUNG / STAGE</div>
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
            /* Preview warna state — SEMUA CONTOH, logic DB belum ada */
            var demoConfirmed = { 1: [3, 4, 5], 2: [2, 3] };
            var demoSelected = { 1: [8], 2: [] };

            $(function () {
                $('.seating-map[data-floor] .seat[data-seat]').each(function () {
                    var floor = parseInt($(this).closest('[data-floor]').data('floor'), 10);
                    var no = parseInt($(this).data('seat'), 10);
                    if ((demoConfirmed[floor] || []).indexOf(no) !== -1) {
                        $(this).addClass('seat-confirmed');
                    }
                    if ((demoSelected[floor] || []).indexOf(no) !== -1) {
                        $(this).addClass('seat-selected');
                    }
                });
            });

            /* Multi-select: klik seat available <-> selected; seat confirmed tidak bisa dipilih */
            $(document).on('click', '.seating-map .seat[data-seat]', function () {
                if ($(this).hasClass('seat-confirmed')) return;
                $(this).toggleClass('seat-selected');
            });
        })();
    </script>
</body>

</html>
