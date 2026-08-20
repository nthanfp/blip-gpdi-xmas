            <div class="guide-section">
                <div class="guide-section-header"><i class="fas fa-info-circle mr-2"></i>Ringkasan</div>
                <div class="guide-section-body">
                    <p class="mb-0">Module Customer digunakan untuk mengelola data pelanggan yang melakukan klaim. Data customer bisa masuk otomatis saat user melakukan klaim pertama.</p>
                </div>
            </div>
            <div class="guide-section">
                <div class="guide-section-header"><i class="fas fa-list-ol mr-2"></i>Cara Penggunaan</div>
                <div class="guide-section-body">
                    <div class="guide-step">
                        <div class="step-num">1</div>
                        <div class="step-body"><strong>Lihat daftar Customer</strong>
                            <p>Semua customer yang pernah melakukan klaim ditampilkan dalam tabel.</p>
                            <img src="<?= base_url('assets/images/guides/customer-list.png') ?>" alt="Daftar customer" class="img-fluid rounded shadow-sm border" onerror="this.style.display='none';this.nextElementSibling.style.display='block'" />
                            <div class="guide-img-placeholder" style="display:none"><i class="fas fa-image"></i> <code>assets/images/guides/customer-list.png</code><br><small>Tabel daftar customer — tampilkan nama, no hp, email, dan domisili.</small></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="guide-section">
                <div class="guide-section-header"><i class="fas fa-table mr-2"></i>Field Reference</div>
                <div class="guide-section-body">
                    <table class="table table-sm table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Phone Number</td>
                                <td>Nomor handphone yang telah diformat.</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>Alamat email customer.</td>
                            </tr>
                            <tr>
                                <td>Domisili</td>
                                <td>Data region: mulai dari provinsi, kota, kecamatan.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>