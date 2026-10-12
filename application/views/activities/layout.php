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
            gap: .75rem;
            font-size: .68rem;
            color: #495057;
            align-items: center;
        }

        .seating-map .legend .seat {
            cursor: default;
            flex: 0 0 var(--seat-size);
            width: var(--seat-size);
        }
    </style>
</head>

<body class="<?php $this->load->view('partial/activities/body-class'); ?>">
    <div class="wrapper">
        <?php $this->load->view('partial/activities/sidebar.php') ?>

        <div class="content-wrapper py-4 px-4 text-sm">

            <?php
            /* ---------- Floor data (source: context/SYSTEM/0002-Seating-Layout.md) ---------- */

            $floor1Rows = [
                ['groups' => [5, 2, 2, 2, 2, 4], 'table_after' => [1, 3]], /* meja hitam: lorong 7|8 dan 11|12 */
                ['groups' => [5, 5, 5, 4]],
                ['groups' => [5, 5, 5, 4]],
                ['groups' => [5, 4, 4, 4], 'empty_after' => [1], 'empty_before' => [2]], /* seat empty: kanan blok 61–64, kiri blok 65–68 */
                ['groups' => [5, 5, 5, 4]],
                ['groups' => [4, 5, 5, 3], 'empty_before' => [0], 'empty_after' => [3]], /* seat empty: kiri blok 92–95, kanan blok 106–108 */
                ['groups' => [5, 5, 5, 4]],
                ['groups' => [5, 5, 5, 4]],
                ['groups' => [5, 5, 5, 4]],
                ['groups' => [5, 5, 5, 4]],
                ['groups' => [4, 5, 5, 3], 'empty_before' => [0], 'empty_after' => [3]], /* seat empty: kiri 185, kanan 201 */
                ['groups' => [4, 5, 5, 4], 'empty_before' => [0]], /* seat empty: kiri 202 */
                ['groups' => [4, 5, 5, 4], 'empty_before' => [0]], /* seat empty: kiri 220 */
                ['groups' => [4, 5, 5, 4], 'empty_before' => [0]], /* seat empty: kiri 238 */
                ['groups' => [3, 4, 4, 4], 'empty_before' => [0, 0], 'pillar_split' => [1 => 3, 2 => 1]], /* seat empty 2x kiri 256; pilar lebar-seat sesudah 261 & 263 */
                ['groups' => [5, 5, 3], 'empty_after' => [2], 'hidden_before' => [271 => [5]]], /* seat empty: kanan 283; hidden: kiri 271 = blok 5 */
                ['groups' => [5, 5, 4], 'hidden_before' => [284 => [5]]], /* hidden: kiri 284 = blok 5 */
                ['groups' => [4], 'hidden_before' => [298 => [5, 5, 5]]], /* hidden: kiri 298 = blok 5 x3 */
                ['label' => '302', 'groups' => [7], 'hidden_before' => [302 => [2, 5, 5]], 'no_aisle' => true], /* row 302 = di dalam ruangan; tempel kanan, tanpa gap/gang sama sekali */
            ];

            $floor1Back = [
                ['label' => '309', 'groups' => [2]],
                ['label' => '311', 'groups' => [2]],
            ];

            $floor2Rows = array_fill(0, 9, ['groups' => [5, 9, 5]]);

            function seating_render_rows($rows, $start_number = 1, $norm_units = 19, $norm_aisles = 3)
            {
                $n = (int) $start_number;
                $html = '';

                foreach ($rows as $i => $row) {
                    $row_no = $i + 1;
                    $table_after = $row['table_after'] ?? [];
                    $row_no_aisle = !empty($row['no_aisle']); /* baris ini tanpa gang sama sekali */

                    $children = [];
                    $units = 0;
                    $aisles = 0;

                    $flush_run = function (&$run) use (&$children, &$units) {
                        if (!empty($run)) {
                            $children[] = ['t' => 'seats', 'from' => $run[0], 'count' => count($run)];
                            $units += count($run);
                            $run = [];
                        }
                    };

                    foreach ($row['groups'] as $gi => $count) {
                        if ($gi > 0) {
                            if (in_array($gi - 1, $table_after)) {
                                $children[] = ['t' => 'table'];
                                $units += 1;
                            } else {
                                $children[] = ['t' => 'aisle'];
                                $aisles += 1;
                            }
                        }

                        foreach (array_keys($row['empty_before'] ?? [], $gi) as $_blank) {
                            $children[] = ['t' => 'blank'];
                            $units += 1;
                        }

                        $split = $row['pillar_split'][$gi] ?? null;
                        $run = [];
                        $pillar_placed = false;

                        for ($s = 0; $s < $count; $s++) {
                            $seatno = $n;

                            if (isset($row['hidden_before'][$seatno])) {
                                $flush_run($run);
                                foreach ($row['hidden_before'][$seatno] as $size) {
                                    $children[] = ['t' => 'hidden', 'size' => (int) $size];
                                    $units += (int) $size;
                                    if (!$row_no_aisle && (int) $size === 5) { /* tetap ada gang/akses setelah blok hidden 5 */
                                        $children[] = ['t' => 'aisle'];
                                        $aisles += 1;
                                    }
                                }
                            }

                            if ($split !== null && !$pillar_placed && count($run) >= (int) $split) {
                                $flush_run($run);
                                $children[] = ['t' => 'pillar'];
                                $units += 1;
                                $pillar_placed = true;
                            }

                            $run[] = $seatno;
                            $n++;

                            if (isset($row['hidden_after'][$seatno])) {
                                $flush_run($run);
                                foreach ($row['hidden_after'][$seatno] as $size) {
                                    $children[] = ['t' => 'hidden', 'size' => (int) $size];
                                    $units += (int) $size;
                                    if (!$row_no_aisle && (int) $size === 5) { /* tetap ada gang/akses setelah blok hidden 5 */
                                        $children[] = ['t' => 'aisle'];
                                        $aisles += 1;
                                    }
                                }
                            }
                        }
                        $flush_run($run);

                        foreach (array_keys($row['empty_after'] ?? [], $gi) as $_blank) {
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
                                $no = $ch['from'] + $s;
                                $cells .= '<div class="seat" title="Seat ' . $no . '">' . $no . '</div>';
                            }
                            $cells .= '</div>';
                        }
                    }

                    $row_norm_aisles = $row_no_aisle ? 0 : (int) $norm_aisles;
                    for ($a = $aisles; $a < $row_norm_aisles; $a++) {
                        $cells .= '<div class="seat-aisle"></div>';
                    }

                    $label = isset($row['label']) ? $row['label'] : (string) $row_no;
                    $html .= '<div class="seat-row"><div class="row-label">' . htmlspecialchars($label) . '</div>' . $cells . '</div>';
                }

                return ['html' => $html, 'next' => $n];
            }

            $f1 = seating_render_rows($floor1Rows, 1);
            $f1_count = $f1['next'] - 1; /* expect 301 */
            $f1_back = seating_render_rows($floor1Back, $f1['next']);
            $f1_total = $f1_back['next'] - 1; /* expect 312 */
            $f2 = seating_render_rows($floor2Rows, 1);
            $f2_total = $f2['next'] - 1; /* expect 171 */
            ?>

            <!-- Summary -->
            <div class="row">
                <div class="col-12 col-md-4 mb-2">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-layer-group"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Floor 1 (Main)</span>
                            <span class="info-box-number"><?php echo (int) $f1_total; ?> seats</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-2">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-chair"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Floor 2 (Balcony)</span>
                            <span class="info-box-number"><?php echo (int) $f2_total; ?> seats</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-2">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-couch"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Grand Total</span>
                            <span class="info-box-number"><?php echo (int) ($f1_total + $f2_total); ?> seats</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Legend -->
            <div class="card card-outline card-secondary">
                <div class="card-header py-1 px-2">
                    <h3 class="card-title text-sm py-1 mb-0"><i class="fas fa-map mr-1"></i> Seating Layout</h3>
                </div>
                <div class="card-body py-2 seating-map">
                    <div class="legend mb-2">
                        <span class="d-inline-flex align-items-center"><span class="seat me-1">1</span> Seat</span>
                        <span class="d-inline-flex align-items-center"><span class="seat seat-table me-1"></span> Table</span>
                        <span class="d-inline-flex align-items-center"><span class="seat seat-pillar-box me-1"></span> Pillar</span>
                        <span class="d-inline-flex align-items-center"><span class="stage-bar px-2 py-1 me-1" style="font-size:.6rem;">STAGE</span> Stage</span>
                        <span class="text-muted">Viewed from above &mdash; stage at the front (top)</span>
                    </div>
                </div>
            </div>

            <div class="row align-items-start">
                <!-- ===== Floor 1 ===== -->
                <div class="col-12 mb-3">
                    <div class="card card-outline card-secondary mb-0 h-100">
                        <div class="card-header py-1 px-2">
                            <h3 class="card-title text-sm py-1 mb-0"><i class="fas fa-building mr-1"></i> Floor 1 — Main Hall (Seats 1–<?php echo (int) $f1_total; ?>)</h3>
                        </div>
                        <div class="card-body py-2 seating-map">
                            <div class="map-scroll">
                                <div style="min-width: 460px; width: 100%;">
                                    <div class="stage-bar">PANGGUNG / STAGE</div>
                                    <div class="stage-arrow"><i class="fas fa-arrow-down"></i> audience</div>

                                    <?php echo $f1['html']; ?>

                                    <div class="seat-divider"></div>
                                    <div class="seat-caption"><i class="fas fa-arrow-alt-circle-down mr-1"></i> Back area / FoH (Seats 309–312)</div>
                                    <?php echo $f1_back['html']; ?>
                                </div>
                            </div>
                            <div class="legend mt-2">
                                <span>Pilar penyangga: baris 15 (sesudah kursi 261 &amp; 263)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===== Floor 2 ===== -->
                <div class="col-12 mb-3">
                    <div class="card card-outline card-secondary mb-0 h-100">
                        <div class="card-header py-1 px-2">
                            <h3 class="card-title text-sm py-1 mb-0"><i class="fas fa-layer-group mr-1"></i> Floor 2 — Balcony / Mezzanine (Seats 1–<?php echo (int) $f2_total; ?>)</h3>
                        </div>
                        <div class="card-body py-2 seating-map">
                            <div class="map-scroll">
                                <div style="min-width: 460px; width: 100%;">
                                    <div class="stage-bar">PANGGUNG / STAGE</div>
                                    <div class="stage-arrow"><i class="fas fa-arrow-down"></i> audience</div>

                                    <?php echo $f2['html']; ?>

                                    <div class="seat-divider"></div>
                                    <div class="seat-caption">3 sections: Left (5) &middot; Center (9) &middot; Right (5) per row &mdash; 9 rows</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php $this->load->view('partial/activities/footer.php') ?>
    </div>

    <?php $this->load->view('partial/activities/foot.php') ?>
</body>

</html>
