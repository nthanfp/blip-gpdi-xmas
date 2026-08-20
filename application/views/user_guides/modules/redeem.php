            <div class="guide-section">
                <div class="guide-section-header"><i class="fas fa-info-circle mr-2"></i>Ringkasan</div>
                <div class="guide-section-body">
                    <p class="mb-0">Module Redeem digunakan untuk memproses klaim hadiah yang masuk. Setiap kali user melakukan klaim melalui landing page, sebuah record redeem akan dibuat. Admin bisa melihat detail klaim, mengkonfirmasi (dengan upload bukti pembayaran), atau menolak klaim.</p>
                </div>
            </div>
            <div class="guide-section">
                <div class="guide-section-header"><i class="fas fa-list-ol mr-2"></i>Cara Penggunaan</div>
                <div class="guide-section-body">
                    <div class="guide-step">
                        <div class="step-num">1</div>
                        <div class="step-body"><strong>Lihat daftar Redeem</strong>
                            <p>Data redeem ditampilkan dalam tabel. Kolom yang terlihat: <i>Customer</i>, <i>Voucher</i>, <i>Item Gift</i>, <i>Completed By</i>, <i>Completed Date</i>, dan <i>Redeemed Date</i>.</p>
                            <p>Pilih baris dengan cara <strong>klik</strong> pada baris yang diinginkan. Baris yang dipilih akan ditandai dengan highlight biru dan border kiri. Setelah memilih, tombol <span class="badge badge-primary mx-1 px-1">DETAIL</span> <span class="badge badge-success mx-1 px-1">CONFIRM</span> dan <span class="badge badge-danger mx-1 px-1">REJECT</span> menjadi aktif.</p>
                            <img src="<?= base_url('assets/images/guides/redeem-list.png') ?>" alt="Tabel redeem" class="mt-1 img-fluid rounded shadow-sm border" onerror="this.style.display='none';this.nextElementSibling.style.display='block'" />
                            <div class="guide-img-placeholder" style="display:none"><i class="fas fa-image"></i> <code>assets/images/guides/redeem-list.png</code><br><small>Tabel daftar redeem — tampilkan kolom Customer, Voucher, Item, Completed By, Completed Date, Redeemed Date. Baris dipilih ditandai highlight biru.</small></div>
                        </div>
                    </div>
                    <div class="guide-step">
                        <div class="step-num">2</div>
                        <div class="step-body"><strong>Filter data</strong>
                            <p>Gunakan filter di bagian atas tabel untuk menyaring data:</p>
                            <ul class="mb-2">
                                <li><strong>Date range</strong> — centang "<i>Filter by Date</i>" lalu pilih tanggal awal dan akhir.</li>
                                <li><strong>Voucher</strong> — masukkan kode voucher untuk pencarian spesifik.</li>
                                <li><strong>Search</strong> — cari berdasarkan nama customer, voucher, atau item.</li>
                                <li><strong>Status</strong> — pilih REDEEMED, COMPLETED, atau REJECTED. Default: REDEEMED.</li>
                                <li><strong>Show</strong> — tentukan jumlah baris per halaman (10, 25, atau 50).</li>
                            </ul>
                            <p>Klik <span class="badge badge-primary mx-1 px-1">FILTER</span> untuk menerapkan, atau <span class="badge badge-danger mx-1 px-1">RESET</span> untuk mengembalikan ke default.</p>
                            <img src="<?= base_url('assets/images/guides/redeem-filter.png') ?>" alt="Filter redeem" class="mt-1 img-fluid rounded shadow-sm border" onerror="this.style.display='none';this.nextElementSibling.style.display='block'" />
                            <div class="guide-img-placeholder" style="display:none"><i class="fas fa-image"></i> <code>assets/images/guides/redeem-filter.png</code><br><small>Filter controls — tampilkan checkbox date range, input voucher, search, dropdown status, dropdown show per page, tombol Reset dan Filter.</small></div>
                        </div>
                    </div>
                    <div class="guide-step">
                        <div class="step-num">3</div>
                        <div class="step-body"><strong>Lihat Detail Klaim</strong>
                            <p>Pilih baris redeem, lalu klik tombol <span class="badge badge-primary"><i class="fas fa-info-circle mr-1"></i> Detail</span> untuk membuka modal detail.</p>
                            <p>Modal detail terdiri dari:</p>
                            <ul>
                                <li><strong>Ringkasan Voucher</strong> — kode voucher, nama item gift, dan status voucher saat ini (CREATED / REDEEMED / COMPLETED / REJECTED).</li>
                                <li><strong>Customer & Redeem</strong> — nama customer, nomor telepon (dengan tombol <i class="fas fa-copy"></i> untuk copy), email, dan tanggal klaim (Redeemed Date).</li>
                                <li><strong>Informasi Proses</strong> — Completed By, Completed Date, IP Address, Lokasi GPS customer. Jika klaim ditolak, ditampilkan Rejected By dan Rejected Date.</li>
                                <li><strong>Tab Bukti</strong>:
                                    <ul>
                                        <li><em>Purchase Proof</em> — foto bukti pembelian yang di-upload customer saat klaim. Klik gambar untuk memperbesar. Tombol <i class="fas fa-download"></i> Download tersedia jika ada file.</li>
                                        <li><em>Completed Proof</em> — foto bukti pemrosesan yang di-upload admin saat konfirmasi.</li>
                                    </ul>
                                </li>
                            </ul>
                            <p>Tombol di footer modal:</p>
                            <ul>
                                <li><span class="badge badge-secondary">CLOSE</span> — tutup informasi.</li>
                                <li><span class="badge badge-danger">REJECT</span> — langsung tolak klaim.</li>
                                <li><span class="badge badge-success">CONTINUE REDEEM</span> — buka pop-up konfirmasi.</li>
                            </ul>
                            <img src="<?= base_url('assets/images/guides/redeem-detail.png') ?>" alt="Modal detail redeem" class="img-fluid rounded shadow-sm border" onerror="this.style.display='none';this.nextElementSibling.style.display='block'" />
                            <div class="guide-img-placeholder" style="display:none"><i class="fas fa-image"></i> <code>assets/images/guides/redeem-detail.png</code><br><small>Modal detail redeem — tampilkan ringkasan voucher di atas, panel kiri (Customer & Redeem + Info Proses), panel kanan (tab Purchase Proof / Completed Proof), footer dengan tombol Close, Reject, dan Continue Redeem.</small></div>
                        </div>
                    </div>
                    <div class="guide-step">
                        <div class="step-num">4</div>
                        <div class="step-body"><strong>Konfirmasi (Complete) Klaim</strong>
                            <p>Ada dua cara membuka modal konfirmasi:</p>
                            <ul>
                                <li>Klik baris → klik tombol <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> CONFIRM</span>.</li>
                                <li>Buka modal Detail → klik tombol <span class="badge badge-success">CONTINUE REDEEM</span> di footer.</li>
                            </ul>
                            <p>Modal konfirmasi menampilkan ringkasan voucher, data customer, dan form berikut:</p>
                            <ul>
                                <li><strong>Proof of Payment <span class="text-danger">*</span></strong> — upload bukti pembayaran. Format: .JPG, .PNG, .PDF. Maksimal 2MB. <em>Wajib diisi.</em></li>
                                <li><strong>Notes</strong> — catatan opsional terkait pemrosesan.</li>
                            </ul>
                            <p>Setelah form terisi, klik <span class="badge badge-success">CONFIRM REDEEM</span> untuk menyelesaikan. Status voucher akan berubah menjadi <strong>COMPLETED</strong>.</p>
                            <img src="<?= base_url('assets/images/guides/redeem-confirm-2.png') ?>" alt="Modal konfirmasi redeem" class="mt-1 img-fluid rounded shadow-sm border" onerror="this.style.display='none';this.nextElementSibling.style.display='block'" />
                            <div class="guide-img-placeholder" style="display:none"><i class="fas fa-image"></i> <code>assets/images/guides/redeem-confirm.png</code><br><small>Modal konfirmasi — tampilkan ringkasan voucher + customer, form upload Proof of Payment (file input) dan Notes (textarea), tombol Close dan Confirm Redeem.</small></div>
                        </div>
                    </div>
                    <div class="guide-step">
                        <div class="step-num">5</div>
                        <div class="step-body"><strong>Tolak (Reject) Klaim</strong>
                            <p>Ada dua cara menolak klaim:</p>
                            <ul>
                                <li><strong>Dari tabel</strong> — klik baris (status harus REDEEMED), lalu klik tombol <span class="badge badge-danger"><i class="fas fa-times-circle mr-1"></i> Reject</span>. Muncul modal reject dengan ringkasan voucher dan customer. Klik <span class="badge badge-danger">Reject Voucher</span> untuk menolak.</li>
                                <li><strong>Dari modal Detail</strong> — klik tombol <span class="badge badge-danger">Reject</span> di footer. Muncul konfirmasi. Klik <span>Yes, reject!</span> untuk menolak tanpa kolom alasan.</li>
                            </ul>
                            <p>Setelah ditolak, status voucher berubah menjadi <strong>REJECTED</strong>. Aksi ini tidak dapat dibatalkan.</p>
                            <img src="<?= base_url('assets/images/guides/redeem-reject.png') ?>" alt="Modal reject redeem" class="img-fluid rounded shadow-sm border" onerror="this.style.display='none';this.nextElementSibling.style.display='block'" />
                            <div class="guide-img-placeholder" style="display:none"><i class="fas fa-image"></i> <code>assets/images/guides/redeem-reject.png</code><br><small>Modal reject — tampilkan ringkasan voucher + customer, kolom Rejection Reason, tombol Close dan Reject Voucher.</small></div>
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
                                <td>Status</td>
                                <td>
                                    <ul>
                                        <li><code>3</code> = REDEEMED (klaim masuk, menunggu diproses)</li>
                                        <li><code>4</code> = COMPLETED (sudah dikonfirmasi/diproses)</li>
                                        <li><code>5</code> = REJECTED (ditolak).</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Customer</td>
                                <td>Nama customer pengklaim.</td>
                            </tr>
                            <tr>
                                <td>Voucher</td>
                                <td>Kode voucher yang diklaim.</td>
                            </tr>
                            <tr>
                                <td>Item Gift</td>
                                <td>Nama hadiah (item gift) terkait voucher.</td>
                            </tr>
                            <tr>
                                <td>Redeemed Date</td>
                                <td>Tanggal & waktu customer melakukan klaim.</td>
                            </tr>
                            <tr>
                                <td>Completed By</td>
                                <td>Admin yang mengkonfirmasi/memproses klaim.</td>
                            </tr>
                            <tr>
                                <td>Completed Date</td>
                                <td>Tanggal & waktu konfirmasi diproses.</td>
                            </tr>
                            <tr>
                                <td>Rejected By</td>
                                <td>Admin yang menolak klaim (hanya ditampilkan jika status = REJECTED).</td>
                            </tr>
                            <tr>
                                <td>Rejected Date</td>
                                <td>Tanggal & waktu penolakan.</td>
                            </tr>
                            <tr>
                                <td>IP Address</td>
                                <td>IP address customer saat melakukan klaim.</td>
                            </tr>
                            <tr>
                                <td>Location</td>
                                <td>Koordinat GPS customer saat klaim, beserta alamat.</td>
                            </tr>
                            <tr>
                                <td>Purchase Proof</td>
                                <td>Bukti pembelian yang di-upload customer saat klaim (opsional).</td>
                            </tr>
                            <tr>
                                <td>Completed Proof</td>
                                <td>Bukti pemrosesan yang di-upload admin saat konfirmasi.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="guide-tip"><i class="fas fa-lightbulb mr-2"></i><strong>Tips:</strong> Klik baris pada tabel untuk memilih, lalu <strong>Detail</strong> untuk melihat informasi lengkap beserta foto bukti pembelian dan lokasi customer. Tombol <strong>Confirm</strong> dan <strong>Reject</strong> hanya aktif untuk baris dengan status REDEEMED.</div>