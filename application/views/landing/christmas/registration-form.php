<!-- Registration Form Section -->
<section id="sec-register" class="relative py-14 sm:py-20 px-5 sm:px-8 overflow-hidden -mt-px bg-red-950">
    <!-- Gradient bg (highlight section: lebih hangat) -->
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
                Register Now
            </p>
            <div class="flex items-center justify-center gap-3">
                <span class="block w-8 h-px bg-gold-400/50"></span>
                <span class="block w-1.5 h-1.5 rounded-full bg-gold-400/60"></span>
                <span class="block w-8 h-px bg-gold-400/50"></span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold text-white leading-snug">
                Reserve Your Seat
            </h2>
            <p class="text-sm text-stone-300 leading-relaxed">
                Daftarkan diri Anda dan keluarga untuk merayakan Natal bersama kami.
            </p>
        </div>

        <!-- Form wrapper (for toggle) -->
        <div id="reg-form-wrap">

            <!-- Form card -->
            <div id="reg-form-card" class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6 sm:p-8 space-y-5 relative" data-aos="fade-up" data-aos-delay="120">

                <!-- No. Handphone -->
                <div class="space-y-1.5">
                    <label for="reg-phone" class="block text-xs font-semibold text-stone-700 tracking-wide">
                        No. Handphone <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="reg-phone" name="phone" placeholder="08xxxxxxxxxx"
                           class="reg-input reg-field w-full px-4 py-3 rounded-xl border border-stone-200 text-sm text-stone-800 placeholder-stone-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gold-400/50 focus:border-gold-400">
                    <p class="reg-err-msg hidden text-[11px] text-red-500 mt-1"></p>
                </div>

                <!-- Data Jemaat (dynamic) -->
                <div class="space-y-3">
                    <label class="block text-xs font-semibold text-stone-700 tracking-wide">
                        Data Jemaat <span class="text-red-500">*</span>
                    </label>

                    <!-- Attendee list -->
                    <div id="reg-attendees" class="space-y-3">
                        <!-- Row 1 (default - pendaftar) -->
                        <div class="attendee-row flex gap-2 items-end">
                            <div class="flex-1 space-y-1.5">
                                <input type="text" placeholder="Nama Lengkap"
                                       class="reg-att-name reg-field w-full px-3 py-2.5 rounded-xl border border-stone-200 text-sm text-stone-800 placeholder-stone-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gold-400/50 focus:border-gold-400">
                            </div>
                            <div class="w-20 space-y-1.5">
                                <input type="number" placeholder="Umur" min="0" max="120"
                                       class="reg-att-age reg-field w-full px-3 py-2.5 rounded-xl border border-stone-200 text-sm text-stone-800 placeholder-stone-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gold-400/50 focus:border-gold-400">
                            </div>
                        </div>
                    </div>

                    <!-- Add attendee button -->
                    <button type="button" id="reg-add-att"
                            class="flex items-center gap-1.5 text-xs font-semibold text-gold-500 hover:text-gold-600 transition-colors">
                        <i class="fas fa-plus-circle text-sm"></i> Tambah Peserta
                    </button>
                </div>

                <!-- Pilihan Lantai (hanya 1) -->
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-stone-700 tracking-wide">
                        Lantai <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="relative">
                            <input type="radio" name="reg-floor" id="reg-floor-1" value="1" class="peer sr-only">
                            <label for="reg-floor-1"
                                   class="block rounded-xl border border-stone-200 p-4 cursor-pointer transition-all duration-200 hover:border-gold-400 peer-checked:border-gold-400 peer-checked:bg-gold-400/10 peer-checked:ring-2 peer-checked:ring-gold-400/40">
                                <span class="block text-sm font-bold text-stone-800">Lantai 1</span>
                                <span class="block text-[11px] text-stone-500 mt-1">Sisa <span class="font-semibold text-gold-600" id="seat-l1">-</span> kursi</span>
                            </label>
                        </div>
                        <div class="relative">
                            <input type="radio" name="reg-floor" id="reg-floor-2" value="2" class="peer sr-only">
                            <label for="reg-floor-2"
                                   class="block rounded-xl border border-stone-200 p-4 cursor-pointer transition-all duration-200 hover:border-gold-400 peer-checked:border-gold-400 peer-checked:bg-gold-400/10 peer-checked:ring-2 peer-checked:ring-gold-400/40">
                                <span class="block text-sm font-bold text-stone-800">Lantai 2</span>
                                <span class="block text-[11px] text-stone-500 mt-1">Sisa <span class="font-semibold text-gold-600" id="seat-l2">-</span> kursi</span>
                            </label>
                        </div>
                    </div>
                    <p id="reg-floor-err" class="reg-err-msg hidden text-[11px] text-red-500">Silakan pilih lantai terlebih dahulu.</p>
                </div>

                <!-- Global error (hidden) -->
                <div id="reg-error" class="hidden p-3 rounded-xl bg-red-50 border border-red-200 text-xs text-red-600">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    <span id="reg-error-msg"></span>
                </div>

                <!-- Submit button -->
                <button type="button" id="reg-submit"
                        class="w-full py-3.5 rounded-xl bg-gold-500 hover:bg-gold-600 text-red-950 font-semibold text-sm tracking-wide transition-all duration-300 hover:shadow-lg hover:shadow-gold-500/25 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-gold-400 focus:ring-offset-2">
                    <span id="reg-btn-text">Daftar Sekarang</span>
                    <span id="reg-btn-loading" class="hidden">
                        <i class="fas fa-spinner fa-spin mr-1"></i> Mendaftarkan...
                    </span>
                </button>

            </div>

        </div>

        <!-- Success state (hidden) -->
        <div id="reg-success" class="hidden">
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-8 text-center space-y-5 reg-success-anim">

                <!-- Animated checkmark -->
                <div class="reg-check-ring mx-auto">
                    <div class="w-20 h-20 mx-auto rounded-full bg-green-50 border-2 border-green-200 flex items-center justify-center">
                        <i class="fas fa-check text-green-500 text-3xl leading-none reg-check-icon"></i>
                    </div>
                </div>

                <!-- Text -->
                <div class="space-y-2">
                    <h3 class="text-lg font-bold text-stone-800">Pendaftaran Berhasil!</h3>
                    <p class="text-sm text-stone-500 leading-relaxed max-w-xs mx-auto">
                        Terima kasih telah melakukan pendaftaran. Kami akan mengirimkan konfirmasi ke kontak yang Anda berikan.
                    </p>
                    <p id="reg-ref-code" class="hidden text-xs text-stone-600">
                        Kode registrasi: <span class="font-bold text-gold-600" id="reg-ref-value"></span>
                    </p>
                </div>

                <!-- Decorative -->
                <div class="flex items-center justify-center gap-2 text-gold-400">
                    <i class="fas fa-star text-[10px]"></i>
                    <i class="fas fa-star text-xs"></i>
                    <i class="fas fa-star text-[10px]"></i>
                </div>

                <!-- Back button -->
                <button type="button" id="reg-back-btn"
                        class="inline-flex items-center gap-2 text-xs font-semibold text-gold-500 hover:text-gold-600 tracking-wide transition-colors">
                    <i class="fas fa-arrow-left"></i> Kembali ke form
                </button>

            </div>
        </div>

    </div>

    <!-- Konfirmasi daftar ulang (nomor sama) -->
    <div id="reg-reconfirm" class="fixed inset-0 z-[9998] hidden items-center justify-center p-5 bg-red-950/85 backdrop-blur-sm">
        <div class="w-full max-w-sm bg-white rounded-2xl border border-gold-400/40 shadow-xl p-6 space-y-5 text-center reg-success-anim">
            <div class="w-14 h-14 mx-auto rounded-full bg-gold-400/10 border-2 border-gold-400/40 flex items-center justify-center">
                <i class="fas fa-user-clock text-gold-500 text-xl leading-none"></i>
            </div>
            <div class="space-y-2">
                <h3 class="text-base font-bold text-stone-800">Daftar Ulang?</h3>
                <p class="text-sm text-stone-500 leading-relaxed">
                    Apakah Anda yakin mendaftar ulang?<br>
                    Anda telah terdaftar <span class="font-bold text-gold-600" id="reg-reconfirm-count">0</span> orang
                    pada waktu <span class="font-semibold text-stone-700" id="reg-reconfirm-time"></span>.
                </p>
            </div>
            <div class="flex gap-3">
                <button type="button" id="reg-reconfirm-cancel"
                        class="flex-1 py-2.5 rounded-xl border border-stone-200 text-sm font-semibold text-stone-500 hover:bg-stone-50 hover:border-stone-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-stone-300">
                    Batal
                </button>
                <button type="button" id="reg-reconfirm-yes"
                        class="flex-1 py-2.5 rounded-xl bg-gold-500 hover:bg-gold-600 text-red-950 text-sm font-semibold transition-all duration-200 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-gold-400 focus:ring-offset-2">
                    Ya, Daftar Ulang
                </button>
            </div>
        </div>
    </div>
</section>

<style>
    /* Error input state */
    .reg-field.reg-error {
        border-color: #f87171;
        background-color: rgba(254, 226, 226, 0.5);
        box-shadow: 0 0 0 2px rgba(248, 113, 113, 0.15);
    }
    .reg-field.reg-error:focus {
        --tw-ring-color: rgba(248, 113, 113, 0.5);
        border-color: #f87171;
    }

    /* Success animation */
    .reg-success-anim {
        animation: regPop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) both;
    }
    @keyframes regPop {
        from { opacity: 0; transform: scale(0.9) translateY(12px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }

    /* Checkmark ring animation */
    .reg-check-ring {
        animation: regRing 0.5s ease-out 0.2s both;
    }
    @keyframes regRing {
        from { transform: scale(0.5); opacity: 0; }
        to   { transform: scale(1); opacity: 1; }
    }

    /* Check icon bounce */
    .reg-check-icon {
        animation: regCheck 0.4s ease-out 0.45s both;
    }
    @keyframes regCheck {
        from { transform: scale(0) rotate(-45deg); opacity: 0; }
        to   { transform: scale(1) rotate(0deg); opacity: 1; }
    }

    /* Shake animation for error */
    .reg-shake {
        animation: regShake 0.4s ease-in-out;
    }
    @keyframes regShake {
        0%, 100% { transform: translateX(0); }
        20% { transform: translateX(-6px); }
        40% { transform: translateX(6px); }
        60% { transform: translateX(-4px); }
        80% { transform: translateX(4px); }
    }

    /* Disabled input during loading */
    .reg-field:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Attendee row remove button */
    .attendee-remove {
        color: #9ca3af;
        transition: color 0.2s;
    }
    .attendee-remove:hover {
        color: #ef4444;
    }
</style>

<script>
(function () {
    var btn = document.getElementById('reg-submit');
    var btnText = document.getElementById('reg-btn-text');
    var btnLoad = document.getElementById('reg-btn-loading');
    var errBox = document.getElementById('reg-error');
    var errMsg = document.getElementById('reg-error-msg');
    var sucBox = document.getElementById('reg-success');
    var formWrap = document.getElementById('reg-form-wrap');
    var formCard = document.getElementById('reg-form-card');
    var backBtn = document.getElementById('reg-back-btn');
    var attendeesWrap = document.getElementById('reg-attendees');
    var addAttBtn = document.getElementById('reg-add-att');
    var endpointSeats = '<?php echo site_url('landing/registration_seats'); ?>';
    var endpointSubmit = '<?php echo site_url('landing/registration_submit'); ?>';
    var endpointSuccess = '<?php echo site_url('p/'); ?>';

    /* Loading overlay global (jquery-loading-overlay) — background gelap senada tema merah */
    function showLoading() {
        if (window.jQuery && jQuery.LoadingOverlay) {
            jQuery('body').LoadingOverlay('show', {
                background: 'rgba(69, 10, 10, 0.85)',
                color: '#d4af37'
            });
        }
    }
    function hideLoading() {
        if (window.jQuery && jQuery.LoadingOverlay) {
            jQuery('body').LoadingOverlay('hide');
        }
    }

    /* Muat sisa kursi real-time */
    function loadSeats() {
        fetch(endpointSeats, { credentials: 'same-origin' })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (!res.success || !res.data || !res.data.floors) return;
                res.data.floors.forEach(function (f) {
                    var el = document.getElementById('seat-l' + f.floor);
                    if (el) el.textContent = f.remaining;
                });
            })
            .catch(function () { /* diamkan: angka tetap '-' */ });
    }
    loadSeats();

    function getFields() {
        return document.querySelectorAll('.reg-field');
    }

    function clearErrors() {
        errBox.classList.add('hidden');
        getFields().forEach(function (f) {
            f.classList.remove('reg-error');
        });
        document.querySelectorAll('.reg-err-msg').forEach(function (e) {
            e.classList.add('hidden');
            e.textContent = '';
        });
    }

    function showFieldError(field, msg) {
        if (field) field.classList.add('reg-error');
        var errEl = field ? field.parentElement.querySelector('.reg-err-msg') : null;
        if (errEl) {
            errEl.textContent = msg;
            errEl.classList.remove('hidden');
        }
    }

    function setInputsDisabled(state) {
        getFields().forEach(function (f) { f.disabled = state; });
    }

    /* Add attendee row */
    addAttBtn.addEventListener('click', function () {
        var row = document.createElement('div');
        row.className = 'attendee-row flex gap-2 items-end';
        row.innerHTML =
            '<div class="flex-1 space-y-1.5">' +
                '<input type="text" placeholder="Nama Lengkap" class="reg-att-name reg-field w-full px-3 py-2.5 rounded-xl border border-stone-200 text-sm text-stone-800 placeholder-stone-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gold-400/50 focus:border-gold-400">' +
            '</div>' +
            '<div class="w-20 space-y-1.5">' +
                '<input type="number" placeholder="Umur" min="0" max="120" class="reg-att-age reg-field w-full px-3 py-2.5 rounded-xl border border-stone-200 text-sm text-stone-800 placeholder-stone-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gold-400/50 focus:border-gold-400">' +
            '</div>' +
            '<button type="button" class="reg-remove-att pb-2.5 pl-1 attendee-remove">' +
                '<i class="fas fa-times-circle text-base"></i>' +
            '</button>';
        attendeesWrap.appendChild(row);

        /* Remove handler */
        row.querySelector('.reg-remove-att').addEventListener('click', function () {
            row.remove();
        });
    });

    /* Nama jemaat: otomatis UPPERCASE saat mengetik (delegated — berlaku untuk baris baru & reset) */
    document.addEventListener('input', function (e) {
        var t = e.target;
        if (!t || !t.classList || !t.classList.contains('reg-att-name')) return;
        var pos = t.selectionStart;
        t.value = t.value.toUpperCase();
        try { t.setSelectionRange(pos, pos); } catch (err) { /* abaikan */ }
    });

    /* Sembunyikan error lantai saat memilih */
    document.querySelectorAll('input[name="reg-floor"]').forEach(function (r) {
        r.addEventListener('change', function () {
            document.getElementById('reg-floor-err').classList.add('hidden');
        });
    });

    var reconfirmBox = document.getElementById('reg-reconfirm');
    var reconfirmCount = document.getElementById('reg-reconfirm-count');
    var reconfirmTime = document.getElementById('reg-reconfirm-time');

    function showReconfirm(data) {
        reconfirmCount.textContent = data.count || 0;
        reconfirmTime.textContent = data.registered_at || '-';
        reconfirmBox.classList.remove('hidden');
        reconfirmBox.classList.add('flex');
    }
    function hideReconfirm() {
        reconfirmBox.classList.add('hidden');
        reconfirmBox.classList.remove('flex');
    }

    /* Reset form ke keadaan awal (dipakai tombol Batal & Kembali) */
    function resetForm() {
        document.getElementById('reg-phone').value = '';
        attendeesWrap.innerHTML =
            '<div class="attendee-row flex gap-2 items-end">' +
                '<div class="flex-1 space-y-1.5">' +
                    '<input type="text" placeholder="Nama Lengkap" class="reg-att-name reg-field w-full px-3 py-2.5 rounded-xl border border-stone-200 text-sm text-stone-800 placeholder-stone-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gold-400/50 focus:border-gold-400">' +
                '</div>' +
                '<div class="w-20 space-y-1.5">' +
                    '<input type="number" placeholder="Umur" min="0" max="120" class="reg-att-age reg-field w-full px-3 py-2.5 rounded-xl border border-stone-200 text-sm text-stone-800 placeholder-stone-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gold-400/50 focus:border-gold-400">' +
                '</div>' +
            '</div>';
        btnText.classList.remove('hidden');
        btnLoad.classList.add('hidden');
        btn.disabled = false;
        hideLoading();
        setInputsDisabled(false);
        clearErrors();

        /* Reset pilihan lantai */
        var checkedFloor = document.querySelector('input[name="reg-floor"]:checked');
        if (checkedFloor) checkedFloor.checked = false;
        document.getElementById('reg-floor-err').classList.add('hidden');
    }

    /* Submit */
    btn.addEventListener('click', function () {
        var phone = document.getElementById('reg-phone').value.trim();
        var attNames = document.querySelectorAll('.reg-att-name');
        var attAges = document.querySelectorAll('.reg-att-age');

        clearErrors();
        var hasError = false;

        if (!phone) {
            showFieldError(document.getElementById('reg-phone'), 'No. Handphone wajib diisi.');
            hasError = true;
        } else if (!/^0[0-9]{9,13}$/.test(phone)) {
            showFieldError(document.getElementById('reg-phone'), 'Format No. Handphone tidak valid (contoh: 081234567890).');
            hasError = true;
        }

        /* Validasi lantai */
        var floorErr = document.getElementById('reg-floor-err');
        var floor = document.querySelector('input[name="reg-floor"]:checked');
        if (!floor) {
            floorErr.classList.remove('hidden');
            hasError = true;
        } else {
            floorErr.classList.add('hidden');
        }

        /* Validate attendees */
        if (attNames.length === 0) {
            errMsg.textContent = 'Minimal harus ada 1 jemaat.';
            errBox.classList.remove('hidden');
            hasError = true;
        }

        for (var i = 0; i < attNames.length; i++) {
            if (!attNames[i].value.trim()) {
                showFieldError(attNames[i], 'Nama wajib diisi.');
                hasError = true;
            }
            if (!attAges[i].value.trim()) {
                showFieldError(attAges[i], 'Umur wajib diisi.');
                hasError = true;
            }
        }

        if (hasError) {
            formCard.classList.add('reg-shake');
            setTimeout(function () { formCard.classList.remove('reg-shake'); }, 500);
            return;
        }

        doSubmit(false);
    });

    /* Eksekusi submit (force = sudah konfirmasi daftar ulang) */
    function doSubmit(force) {
        var phone = document.getElementById('reg-phone').value.trim();
        var floor = document.querySelector('input[name="reg-floor"]:checked');
        var attNames = document.querySelectorAll('.reg-att-name');
        var attAges = document.querySelectorAll('.reg-att-age');

        /* Loading state */
        btnText.classList.add('hidden');
        btnLoad.classList.remove('hidden');
        btn.disabled = true;
        showLoading();
        setInputsDisabled(true);

        /* Kumpulkan payload */
        var attendees = [];
        for (var j = 0; j < attNames.length; j++) {
            attendees.push({
                name: attNames[j].value.trim(),
                age: attAges[j].value.trim()
            });
        }

        /* Submit nyata */
        var payload = new FormData();
        payload.append('phone', phone);
        payload.append('floor', floor.value);
        if (force) payload.append('confirm', '1');
        attendees.forEach(function (a, idx) {
            payload.append('attendees[' + idx + '][name]', a.name);
            payload.append('attendees[' + idx + '][age]', a.age);
        });

        function restoreUI() {
            btnText.classList.remove('hidden');
            btnLoad.classList.add('hidden');
            btn.disabled = false;
            hideLoading();
            setInputsDisabled(false);
        }

        fetch(endpointSubmit, {
            method: 'POST',
            body: payload,
            credentials: 'same-origin'
        })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                restoreUI();

                /* Nomor sama → tampilkan konfirmasi daftar ulang */
                if (res.requires_confirm) {
                    showReconfirm(res.data || {});
                    return;
                }

                if (!res.success) {
                    errMsg.textContent = res.message || 'Pendaftaran gagal. Coba lagi.';
                    errBox.classList.remove('hidden');
                    formCard.classList.add('reg-shake');
                    setTimeout(function () { formCard.classList.remove('reg-shake'); }, 500);
                    loadSeats();
                    return;
                }

                /* Sukses -> redirect ke halaman sukses /p/{ref_code} (dengan QR) */
                if (res.data && res.data.ref_code) {
                    window.location.href = endpointSuccess + encodeURIComponent(res.data.ref_code);
                    return;
                }

                /* Fallback bila ref_code tidak dikembalikan: tampilkan inline seperti dulu */
                var refEl = document.getElementById('reg-ref-code');
                if (res.data && res.data.ref_code) {
                    document.getElementById('reg-ref-value').textContent = res.data.ref_code;
                    refEl.classList.remove('hidden');
                } else {
                    refEl.classList.add('hidden');
                }
                formWrap.classList.add('hidden');
                sucBox.classList.remove('hidden');
                loadSeats();
            })
            .catch(function () {
                restoreUI();
                errMsg.textContent = 'Terjadi gangguan jaringan. Coba lagi.';
                errBox.classList.remove('hidden');
                formCard.classList.add('reg-shake');
                setTimeout(function () { formCard.classList.remove('reg-shake'); }, 500);
            });
    }

    /* Tombol konfirmasi daftar ulang */
    document.getElementById('reg-reconfirm-yes').addEventListener('click', function () {
        hideReconfirm();
        doSubmit(true);
    });

    /* Batal daftar ulang → kosongkan form */
    document.getElementById('reg-reconfirm-cancel').addEventListener('click', function () {
        hideReconfirm();
        resetForm();
    });

    /* Back to form */
    backBtn.addEventListener('click', function () {
        sucBox.classList.add('hidden');
        formWrap.classList.remove('hidden');
        resetForm();
    });
})();
</script>
