            <div class="guide-section">
                <div class="guide-section-header"><i class="fas fa-info-circle mr-2"></i>Ringkasan</div>
                <div class="guide-section-body">
                    <p class="mb-0">Dashboard menyajikan ringkasan data real-time sistem. Widget menampilkan total Item Gift, Customer, Voucher, dan Redeem. Grafik garis menunjukkan tren klaim 7 hari terakhir. Grafik donat menampilkan distribusi status voucher secara keseluruhan.</p>
                </div>
            </div>
            <div class="guide-section">
                <div class="guide-section-header"><i class="fas fa-list-ol mr-2"></i>Cara Penggunaan</div>
                <div class="guide-section-body">
                    <div class="guide-step">
                        <div class="step-num">1</div>
                        <div class="step-body"><strong>Buka halaman Dashboard</strong>
                            <p>Secara otomatis akan muncul saat login atau klik menu Dashboard di sidebar.</p>
                        </div>
                    </div>
                    <div class="guide-step">
                        <div class="step-num">2</div>
                        <div class="step-body"><strong>Lihat widget ringkasan</strong>
                            <p>Empat widget menampilkan jumlah Item Gift, Customer, Voucher, dan Redeem.</p>
                            <img src="<?= base_url('assets/images/guides/dashboard-widgets.png') ?>" alt="Widget cards" class="img-fluid rounded shadow-sm border" onerror="this.style.display='none';this.nextElementSibling.style.display='block'" />
                            <div class="guide-img-placeholder" style="display:none"><i class="fas fa-image"></i> <code>assets/images/guides/dashboard-widgets.png</code><br><small>Zoom ke area widget cards di atas Dashboard.</small></div>
                        </div>
                    </div>
                    <div class="guide-step">
                        <div class="step-num">3</div>
                        <div class="step-body"><strong>Analisis grafik</strong>
                            <p>Grafik garis <em>Redeemed by Date</em> + grafik donat status voucher.</p>
                            <img src="<?= base_url('assets/images/guides/dashboard-charts.png') ?>" alt="Grafik Dashboard" class="img-fluid rounded shadow-sm border" onerror="this.style.display='none';this.nextElementSibling.style.display='block'" />
                            <div class="guide-img-placeholder" style="display:none"><i class="fas fa-image"></i> <code>assets/images/guides/dashboard-charts.png</code><br><small>Grafik garis dan grafik donat di Dashboard.</small></div>
                        </div>
                    </div>
                    <div class="guide-step">
                        <div class="step-num">4</div>
                        <div class="step-body"><strong>Detail per Item Gift</strong>
                            <p>Tabel rincian jumlah voucher per item gift dengan status warna.</p>
                            <img src="<?= base_url('assets/images/guides/dashboard-itemgift.png') ?>" alt="Tabel Item Gift" class="img-fluid rounded shadow-sm border" onerror="this.style.display='none';this.nextElementSibling.style.display='block'" />
                            <div class="guide-img-placeholder" style="display:none"><i class="fas fa-image"></i> <code>assets/images/guides/dashboard-itemgift-table.png</code><br><small>Tabel summary per Item Gift di bagian bawah Dashboard.</small></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="guide-section d-none">
                <div class="guide-section-header"><i class="fas fa-table mr-2"></i>Field Reference</div>
                <div class="guide-section-body">
                    <table class="table table-sm table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Widget</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Item Gift</td>
                                <td>Total item hadiah terdaftar.</td>
                            </tr>
                            <tr>
                                <td>Customer</td>
                                <td>Total pelanggan yang klaim.</td>
                            </tr>
                            <tr>
                                <td>Voucher</td>
                                <td>Total voucher semua status.</td>
                            </tr>
                            <tr>
                                <td>Redeem</td>
                                <td>Total transaksi redeem.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="guide-tip d-none"><i class="fas fa-lightbulb mr-2"></i><strong>Tips:</strong> -</div>