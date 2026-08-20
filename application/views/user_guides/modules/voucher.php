            <div class="guide-section">
                <div class="guide-section-header"><i class="fas fa-info-circle mr-2"></i>Ringkasan</div>
                <div class="guide-section-body">
                    <p class="mb-0">Module Voucher digunakan untuk membuat dan mengelola voucher. Voucher bisa dibuat dalam jumlah banyak (<i>bulk</i>). Setiap voucher memiliki kode unik (<i>voucher code</i>).</p>
                </div>
            </div>
            <div class="guide-section">
                <div class="guide-section-header"><i class="fas fa-list-ol mr-2"></i>Cara Penggunaan</div>
                <div class="guide-section-body">
                    <div class="guide-step">
                        <div class="step-num">1</div>
                        <div class="step-body"><strong>Buat Voucher (Bulk)</strong>
                            <p>Klik <span class="badge badge-secondary">BULK CREATE</span> Isi prefix kode, total qty, qty per item gift, dan expired date.</p>
                            <img src="<?= base_url('assets/images/guides/voucher-create-bulk.png') ?>" alt="Form bulk create voucher" class="img-fluid rounded shadow-sm border" onerror="this.style.display='none';this.nextElementSibling.style.display='block'" />
                            <div class="guide-img-placeholder" style="display:none"><i class="fas fa-image"></i> <code>assets/images/guides/voucher-create-bulk.png</code><br><small>Form bulk create voucher — tampilkan prefix, qty, tabel item gifts, expired date, tombol Generate.</small></div>
                        </div>
                    </div>
                    <div class="guide-step">
                        <div class="step-num">2</div>
                        <div class="step-body"><strong>Edit &amp; Update Voucher</strong>
                            <p>Klik <i class="fas fa-pencil-alt text-primary"></i> pada baris yang ingin diubah.</p>
                            <img src="<?= base_url('assets/images/guides/voucher-edit.png') ?>" alt="Form edit voucher" class="img-fluid rounded shadow-sm border" onerror="this.style.display='none';this.nextElementSibling.style.display='block'" />
                            <div class="guide-img-placeholder" style="display:none"><i class="fas fa-image"></i> <code>assets/images/guides/voucher-edit.png</code><br><small>Form edit voucher — tampilkan tabel dengan icon edit dan form/modal yang sudah terisi.</small></div>
                        </div>
                    </div>
                    <div class="guide-step d-none">
                        <div class="step-num">3</div>
                        <div class="step-body"><strong>Print &amp; Export</strong>
                            <p>Gunakan tombol PRINT, EXCEL, dan QR untuk cetak/export data.</p>
                            <img src="<?= base_url('assets/images/guides/voucher-export.png') ?>" alt="Toolbar export voucher" class="img-fluid rounded shadow-sm border" onerror="this.style.display='none';this.nextElementSibling.style.display='block'" />
                            <div class="guide-img-placeholder" style="display:none"><i class="fas fa-image"></i> <code>assets/images/guides/voucher-export.png</code><br><small>Toolbar tabel voucher — tampilkan tombol PRINT, EXCEL, QR, dan icon BULK NEW.</small></div>
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
                                <td>Voucher Prefix</td>
                                <td>Awalan kode unik voucher.</td>
                            </tr>
                            <tr>
                                <td>Expired Date</td>
                                <td>Tanggal kadaluarsa voucher.</td>
                            </tr>
                            <tr>
                                <td>Item Gift</td>
                                <td>Hadiah yang terikat ke voucher ini.</td>
                            </tr>
                            <tr>
                                <td>Qty</td>
                                <td>Jumlah voucher yang tersedia.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="guide-tip d-none"><i class="fas fa-lightbulb mr-2"></i><strong>Tips:</strong> - </div>