             <div class="guide-section">
                 <div class="guide-section-header"><i class="fas fa-info-circle mr-2"></i>Ringkasan</div>
                 <div class="guide-section-body">
                     <p>Menu Push Notification digunakan untuk mengirim notifikasi ke perangkat pengguna yang telah mendaftarkan token FCM (misal: PWA di HP jemaat). Notifikasi terkirim ke SEMUA token yang terdaftar.</p>
                 </div>
             </div>
             <div class="guide-section">
                 <div class="guide-section-header"><i class="fas fa-list-ol mr-2"></i>Cara Penggunaan</div>
                 <div class="guide-section-body">
                     <div class="guide-step">
                         <div class="step-num">1</div>
                         <div class="step-body"><strong>Isi Title</strong>
                             <p>Judul notifikasi, wajib diisi (contoh: "Pengumuman Natal").</p>
                         </div>
                     </div>
                     <div class="guide-step">
                         <div class="step-num">2</div>
                         <div class="step-body"><strong>Isi Body</strong>
                             <p>Teks pesan yang tampil di layar notifikasi, wajib diisi.</p>
                         </div>
                     </div>
                     <div class="guide-step">
                         <div class="step-num">3</div>
                         <div class="step-body"><strong>Click URL (opsional)</strong>
                             <p>Halaman yang dibuka saat notifikasi diklik (contoh: <code>index.php/p/H9QC8</code>).</p>
                         </div>
                     </div>
                     <div class="guide-step">
                         <div class="step-num">4</div>
                         <div class="step-body"><strong>Kirim</strong>
                             <p>Klik <em>Send</em> untuk broadcast ke semua perangkat, atau <em>Test</em> untuk mengirim hanya ke perangkat admin (disarankan test dulu sebelum broadcast).</p>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="guide-tip"><i class="fas fa-lightbulb mr-2"></i><strong>Tips:</strong> Daftar token yang menerima broadcast bisa dicek di menu <strong>FCM Token</strong>. Token perangkat yang sudah lama tidak aktif sebaiknya dihapus agar tidak membebani pengiriman.</div>
