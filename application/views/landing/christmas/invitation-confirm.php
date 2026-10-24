<!-- Invitation Confirmation Section -->
<?php $bk = isset($booking) ? $booking : null; ?>
<section id="sec-invitation" class="relative py-14 sm:py-20 px-5 sm:px-8 overflow-hidden -mt-px bg-red-950">
    <!-- Gradient bg -->
    <div class="absolute inset-0 bg-gradient-to-b from-red-950 via-red-900 to-red-900"></div>
    <!-- Subtle warm tint -->
    <div class="absolute inset-0 bg-gradient-to-br from-red-950/[0.02] via-transparent to-gold-400/[0.05]"></div>
    <!-- Dot texture -->
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #f5edd6 1px, transparent 1px); background-size: 24px 24px;"></div>
    <!-- Radial gold glow -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(212,175,55,0.06)_0%,_transparent_60%)]"></div>

    <!-- Top fade from FAQ (red-950) -->
    <div class="absolute top-0 left-0 right-0 h-24 bg-gradient-to-b from-red-950 via-red-950/80 to-transparent pointer-events-none z-10"></div>
    <!-- Bottom fade to contact (red-950) -->
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-red-950 via-red-950/80 to-transparent pointer-events-none z-10"></div>

    <div class="relative z-10 max-w-md lg:max-w-lg mx-auto space-y-8 pb-4">

        <!-- Header -->
        <div class="text-center space-y-4" data-aos="fade-up">
            <p class="text-[11px] font-semibold tracking-[0.25em] uppercase text-gold-400">
                You Are Invited
            </p>
            <div class="flex items-center justify-center gap-3">
                <span class="block w-8 h-px bg-gold-400/50"></span>
                <span class="block w-1.5 h-1.5 rounded-full bg-gold-400/60"></span>
                <span class="block w-8 h-px bg-gold-400/50"></span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold text-white leading-snug">
                Konfirmasi Kehadiran
            </h2>
            <p class="text-sm text-stone-300 leading-relaxed">
                Kami menantikan kehadiran Anda di Perayaan Natal GPdI Kopo Permai.
            </p>
        </div>

        <?php if ($bk) : ?>
        <div id="inv-card" class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6 sm:p-8 space-y-5 relative" data-aos="fade-up" data-aos-delay="120">

            <!-- Form state -->
            <div id="inv-form-wrap" class="<?php echo ((int) $bk->status !== 0) ? 'hidden' : ''; ?> space-y-5">
                <!-- Nama undangan -->
                <div class="text-center space-y-1.5 pb-4 border-b border-stone-100">
                    <p class="text-[11px] font-semibold tracking-[0.2em] uppercase text-stone-400">Kepada Yth.</p>
                    <p class="text-base font-bold text-stone-800 tracking-tight"><?php echo html_escape($bk->name); ?></p>
                </div>

                <?php $already = $bk->confirmed_count !== null ? (int) $bk->confirmed_count : null; ?>
                <?php if ($already !== null) : ?>
                <div class="bg-green-50 border border-green-200 rounded-xl px-4 py-3 text-center">
                    <p class="text-xs text-green-700 font-semibold">
                        <i class="fas fa-check-circle mr-1"></i> Sudah terkonfirmasi: <b><?php echo $already; ?> orang</b>
                        <?php if (!empty($bk->confirmed_date)) : ?>
                            <span class="font-normal text-green-600">&middot; <?php echo date('d M Y H:i', strtotime($bk->confirmed_date)); ?></span>
                        <?php endif; ?>
                    </p>
                </div>
                <?php endif; ?>

                <!-- No. Handphone (wajib) -->
                <div class="space-y-1.5">
                    <label for="inv-phone" class="block text-xs font-semibold text-stone-700 tracking-wide">
                        No. Handphone <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="inv-phone" name="phone" maxlength="20" required
                           value="<?php echo html_escape($bk->phone ?: ''); ?>"
                           placeholder="<?php echo $bk->phone ? 'Nomor tersimpan — ubah bila perlu' : '08xxxxxxxxxx'; ?>"
                           class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm text-stone-800 bg-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gold-400/50 focus:border-gold-400">
                    <p class="text-[11px] text-stone-400">Untuk keperluan konfirmasi dari panitia — <?php echo $bk->phone ? 'saat ini sudah terdaftar.' : 'wajib diisi sebelum konfirmasi.'; ?></p>
                </div>

                <!-- Jumlah orang (dropdown) -->
                <div class="space-y-1.5">
                    <label for="inv-count" class="block text-xs font-semibold text-stone-700 tracking-wide">
                        Jumlah orang yang hadir <span class="text-red-500">*</span>
                    </label>
                    <select id="inv-count" name="count"
                            class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm text-stone-800 bg-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gold-400/50 focus:border-gold-400">
                        <?php for ($i = 1; $i <= (int) $bk->seats; $i++) : ?>
                        <option value="<?php echo $i; ?>"<?php echo ($already === $i) ? ' selected' : ''; ?>>
                            <?php echo $i; ?> orang
                        </option>
                        <?php endfor; ?>
                    </select>
                    <p class="text-[11px] text-stone-400">Maksimal <?php echo (int) $bk->seats; ?> orang sesuai kuota undangan.</p>
                </div>

                <!-- Error -->
                <div id="inv-err" class="hidden bg-red-50 border border-red-200 rounded-xl px-4 py-3">
                    <p class="text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i> <span id="inv-err-msg"></span></p>
                </div>

                <!-- Submit -->
                <button type="button" id="inv-submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-gold-500 hover:bg-gold-600 text-red-950 font-bold text-sm tracking-wide transition-all duration-300 hover:shadow-lg hover:shadow-gold-500/25 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-gold-400 focus:ring-offset-2">
                    <span id="inv-submit-text"><?php echo ($already !== null) ? 'Perbarui Konfirmasi' : 'Konfirmasi Kehadiran'; ?></span>
                    <span id="inv-submit-load" class="hidden"><i class="fas fa-spinner fa-spin"></i> Menyimpan...</span>
                </button>
            </div>

            <!-- Inactive state -->
            <?php if ((int) $bk->status !== 0) : ?>
            <div class="text-center py-6 space-y-3">
                <div class="w-14 h-14 mx-auto rounded-full bg-stone-100 flex items-center justify-center">
                    <i class="fas fa-envelope-open-text text-stone-400 text-xl"></i>
                </div>
                <p class="text-sm font-semibold text-stone-700">Undangan ini sudah tidak aktif</p>
                <p class="text-xs text-stone-500 leading-relaxed">Silakan hubungi panitia bila Anda merasa menerima pesan ini keliru.</p>
            </div>
            <?php endif; ?>

            <!-- Success state -->
            <div id="inv-success" class="hidden text-center py-6 space-y-4">
                <div class="w-16 h-16 mx-auto rounded-full bg-green-100 flex items-center justify-center">
                    <i class="fas fa-check text-green-600 text-2xl"></i>
                </div>
                <div class="space-y-1">
                    <p class="text-lg font-extrabold text-stone-800">Terima kasih!</p>
                    <p class="text-sm text-stone-600 leading-relaxed">Konfirmasi kehadiran Anda sudah kami catat.</p>
                </div>
                <div class="inline-flex items-center gap-2 bg-gold-50 border border-gold-200 rounded-full px-4 py-2">
                    <i class="fas fa-users text-gold-600 text-xs"></i>
                    <span class="text-sm font-bold text-stone-800"><span id="inv-success-count">-</span> orang hadir</span>
                    <span class="text-xs text-stone-400">&middot; dari <?php echo (int) $bk->seats; ?> kursi</span>
                </div>
                <p class="text-xs text-stone-400">Sampai jumpa di hari pelaksanaan — 20 Desember 2026, 17.00 WIB.</p>
            </div>

        </div>
        <?php endif; ?>

    </div>
</section>

<script>
    (function () {
        <?php if (!$bk || (int) $bk->status !== 0) : ?>
        return;
        <?php else: ?>
        var bookingid = <?php echo (int) $bk->bookingid; ?>;
        var maxSeats = <?php echo (int) $bk->seats; ?>;
        var endpoint = '<?php echo site_url("landing/invitation_confirm"); ?>';

        var btn = document.getElementById('inv-submit');
        var btnText = document.getElementById('inv-submit-text');
        var btnLoad = document.getElementById('inv-submit-load');
        var sel = document.getElementById('inv-count');
        var errBox = document.getElementById('inv-err');
        var errMsg = document.getElementById('inv-err-msg');
        var formWrap = document.getElementById('inv-form-wrap');
        var successBox = document.getElementById('inv-success');
        var card = document.getElementById('inv-card');
        if (!btn || !sel) return;

        function showError(msg) {
            errMsg.textContent = msg;
            errBox.classList.remove('hidden');
            card.classList.remove('inv-shake');
            void card.offsetWidth;
            card.classList.add('inv-shake');
        }

        btn.addEventListener('click', function () {
            var count = parseInt(sel.value, 10) || 0;
            var phone = (document.getElementById('inv-phone').value || '').trim();
            errBox.classList.add('hidden');

            if (phone === '') {
                showError('No. Handphone wajib diisi.');
                return;
            }
            if (!/^0[0-9]{9,13}$/.test(phone)) {
                showError('Format No. Handphone tidak valid (contoh: 081234567890).');
                return;
            }
            if (count < 1 || count > maxSeats) {
                showError('Jumlah orang harus antara 1 sampai ' + maxSeats + '.');
                return;
            }

            btn.disabled = true;
            btnText.classList.add('hidden');
            btnLoad.classList.remove('hidden');

            var payload = new FormData();
            payload.append('bookingid', bookingid);
            payload.append('count', count);
            if (phone !== '') payload.append('phone', phone);
            var tn = document.querySelector('meta[name="csrf-token-name"]');
            var tv = document.querySelector('meta[name="csrf-token-value"]');
            if (tn && tv) payload.append(tn.getAttribute('content'), tv.getAttribute('content'));

            fetch(endpoint, { method: 'POST', body: payload, credentials: 'same-origin' })
                .then(function (r) { return r.json(); })
                .then(function (res) {
                    btn.disabled = false;
                    btnText.classList.remove('hidden');
                    btnLoad.classList.add('hidden');

                    if (!res.success) {
                        showError(res.message || 'Gagal menyimpan konfirmasi. Coba lagi.');
                        return;
                    }
                    document.getElementById('inv-success-count').textContent = (res.data && res.data.confirmed_count) || count;
                    formWrap.classList.add('hidden');
                    successBox.classList.remove('hidden');
                    successBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                })
                .catch(function () {
                    btn.disabled = false;
                    btnText.classList.remove('hidden');
                    btnLoad.classList.add('hidden');
                    showError('Koneksi bermasalah. Coba lagi.');
                });
        });
        <?php endif; ?>
    })();
</script>
<style>
    .inv-shake { animation: invShake .4s; }
    @keyframes invShake {
        0%, 100% { transform: translateX(0); }
        20% { transform: translateX(-6px); }
        40% { transform: translateX(6px); }
        60% { transform: translateX(-4px); }
        80% { transform: translateX(4px); }
    }
    @media (prefers-reduced-motion: reduce) { .inv-shake { animation: none; } }
</style>
