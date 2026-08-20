            <div class="guide-section">
                <div class="guide-section-header"><i class="fas fa-info-circle mr-2"></i>Ringkasan</div>
                <div class="guide-section-body">
                    <p class="mb-0">Module Item Gift digunakan untuk mengelola daftar hadiah yang tersedia. Setiap Item Gift memiliki nama, deskripsi, nominal, tipe (E-Wallet atau Voucher Shopee), status aktif. Voucher yang dibuat nanti akan merujuk ke salah satu Item Gift.</p>
                </div>
            </div>
            <div class="guide-section">
                <div class="guide-section-header"><i class="fas fa-list-ol mr-2"></i>Cara Penggunaan</div>
                <div class="guide-section-body">
                    <div class="guide-step">
                        <div class="step-num">1</div>
                        <div class="step-body"><strong>Tambah Item Gift baru</strong>
                            <p>Klik tombol <span class="badge badge-secondary">+ NEW</span> lalu mengisi form: Item Name, Description, Nominal, Item Type (E-Wallet, Voucher Shopee), Status Suspend</p>
                            <img src="<?= base_url('assets/images/guides/itemgift-create.png') ?>" alt="Form create Item Gift" class="img-fluid rounded shadow-sm border" onerror="this.style.display='none';this.nextElementSibling.style.display='block'" />
                            <div class="guide-img-placeholder" style="display:none"><i class="fas fa-image"></i> <code>assets/images/guides/itemgift-create.png</code><br><small>Form create Item Gift yang sudah terisi — tampilkan field Item Name, Description, Nominal, Item Type, Status, dan upload icon.</small></div>
                        </div>
                    </div>
                    <div class="guide-step">
                        <div class="step-num">2</div>
                        <div class="step-body"><strong>Edit Item Gift</strong>
                            <p>Klik tombol <i class="fas fa-pencil-alt text-primary"></i> pada baris yang ingin diubah.</p>
                            <img src="<?= base_url('assets/images/guides/itemgift-edit.png') ?>" alt="Form edit Item Gift" class="img-fluid rounded shadow-sm border" onerror="this.style.display='none';this.nextElementSibling.style.display='block'" />
                            <div class="guide-img-placeholder" style="display:none"><i class="fas fa-image"></i> <code>assets/images/guides/itemgift-edit.png</code><br><small>Form edit Item Gift — tampilkan tombol edit di tabel dan form yang terisi data existing.</small></div>
                        </div>
                    </div>
                    <div class="guide-step">
                        <div class="step-num">3</div>
                        <div class="step-body"><strong>Suspend / Aktifkan</strong>
                            <p>Item Gift yang di-suspend tidak bisa digunakan untuk voucher baru, tapi voucher lama tetap berlaku.</p>
                            <!-- <img src="<?= base_url('assets/images/guides/itemgift-suspend.png') ?>" alt="Status suspend" class="img-fluid rounded shadow-sm border" onerror="this.style.display='none';this.nextElementSibling.style.display='block'" /> -->
                            <!-- <div class="guide-img-placeholder" style="display:none"><i class="fas fa-image"></i> <code>assets/images/guides/itemgift-suspend.png</code><br><small>Tabel Item Gift dengan status Suspend (merah) — tampilkan kolom Status perbedaan Active vs Suspend.</small></div> -->
                        </div>
                    </div>
                    <div class="guide-step">
                        <div class="step-num">4</div>
                        <div class="step-body"><strong>Hapus Item Gift</strong>
                            <p>Item Gift hanya bisa dihapus jika belum ada voucher yang menggunakannya.</p>
                            <!-- <img src="<?= base_url('assets/images/guides/itemgift-delete.png') ?>" alt="Konfirmasi hapus" class="img-fluid rounded shadow-sm border" onerror="this.style.display='none';this.nextElementSibling.style.display='block'" /> -->
                            <!-- <div class="guide-img-placeholder" style="display:none"><i class="fas fa-image"></i> <code>assets/images/guides/itemgift-delete.png</code><br><small>SweetAlert konfirmasi hapus Item Gift — tampilkan dialog konfirmasi delete.</small></div> -->
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
                                <td>Item Name</td>
                                <td>Nama hadiah yang akan ditampilkan ke user.</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>Deskripsi singkat tentang hadiah.</td>
                            </tr>
                            <tr>
                                <td>Nominal</td>
                                <td>Jumlah nominal atau nilai hadiah.</td>
                            </tr>
                            <tr>
                                <td>Item Type</td>
                                <td>Pilihan type item: <strong>E-Wallet</strong>, <strong>Voucher Shopee</strong>.</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td><strong>Active</strong>: bisa dipakai, <strong>Suspend</strong> = tidak bisa dipakai.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="guide-tip"><i class="fas fa-lightbulb mr-2"></i><strong>Tips:</strong> Buat Item Gift dengan nama yang deskriptif dan nominal yang jelas.</div>