<!-- Registration Form Section -->
<section id="sec-register" class="py-20 sm:py-28 px-5 sm:px-8 bg-stone-100/50">
    <div class="max-w-md lg:max-w-lg mx-auto space-y-8">

        <!-- Header -->
        <div class="text-center space-y-4">
            <p class="text-[11px] font-semibold tracking-[0.25em] uppercase text-gold-500">
                Register Now
            </p>
            <div class="flex items-center justify-center gap-3">
                <span class="block w-8 h-px bg-gold-400/50"></span>
                <span class="block w-1.5 h-1.5 rounded-full bg-gold-400/60"></span>
                <span class="block w-8 h-px bg-gold-400/50"></span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold text-stone-800 leading-snug">
                Reserve Your Seat
            </h2>
            <p class="text-sm text-stone-500 leading-relaxed">
                Daftarkan diri Anda dan keluarga untuk merayakan Natal bersama kami.
            </p>
        </div>

        <!-- Form wrapper (for toggle) -->
        <div id="reg-form-wrap">

            <!-- Form card -->
            <div id="reg-form-card" class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6 sm:p-8 space-y-5 relative">

                <!-- Loading overlay (hidden) -->
                <div id="reg-loading-overlay" class="hidden absolute inset-0 bg-white/70 backdrop-blur-sm rounded-2xl z-10 flex flex-col items-center justify-center gap-3">
                    <i class="fas fa-spinner fa-spin text-gold-500 text-2xl"></i>
                    <p class="text-sm font-semibold text-stone-600">Mendaftarkan...</p>
                </div>

                <!-- Nama Pendaftar -->
                <div class="space-y-1.5">
                    <label for="reg-name" class="block text-xs font-semibold text-stone-700 tracking-wide">
                        Nama Pendaftar <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="reg-name" name="name" placeholder="Masukkan nama lengkap"
                           class="reg-input reg-field w-full px-4 py-3 rounded-xl border border-stone-200 text-sm text-stone-800 placeholder-stone-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gold-400/50 focus:border-gold-400">
                    <p class="reg-err-msg hidden text-[11px] text-red-500 mt-1"></p>
                </div>

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
                        <span class="text-stone-400 font-normal ml-1">(termasuk nama pendaftar)</span>
                    </label>

                    <!-- Attendee list -->
                    <div id="reg-attendees" class="space-y-3">
                        <!-- Row 1 (default - pendaftar) -->
                        <div class="attendee-row flex gap-2 items-end">
                            <div class="flex-1 space-y-1.5">
                                <input type="text" placeholder="Nama"
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
                    <div class="w-20 h-20 rounded-full bg-green-50 border-2 border-green-200 flex items-center justify-center">
                        <i class="fas fa-check text-green-500 text-3xl reg-check-icon"></i>
                    </div>
                </div>

                <!-- Text -->
                <div class="space-y-2">
                    <h3 class="text-lg font-bold text-stone-800">Pendaftaran Berhasil!</h3>
                    <p class="text-sm text-stone-500 leading-relaxed max-w-xs mx-auto">
                        Terima kasih telah melakukan pendaftaran. Kami akan mengirimkan konfirmasi ke kontak yang Anda berikan.
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
    var overlay = document.getElementById('reg-loading-overlay');
    var backBtn = document.getElementById('reg-back-btn');
    var attendeesWrap = document.getElementById('reg-attendees');
    var addAttBtn = document.getElementById('reg-add-att');

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
                '<input type="text" placeholder="Nama" class="reg-att-name reg-field w-full px-3 py-2.5 rounded-xl border border-stone-200 text-sm text-stone-800 placeholder-stone-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gold-400/50 focus:border-gold-400">' +
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

    /* Submit */
    btn.addEventListener('click', function () {
        var name = document.getElementById('reg-name').value.trim();
        var phone = document.getElementById('reg-phone').value.trim();
        var attNames = document.querySelectorAll('.reg-att-name');
        var attAges = document.querySelectorAll('.reg-att-age');

        clearErrors();
        var hasError = false;

        if (!name) {
            showFieldError(document.getElementById('reg-name'), 'Nama pendaftar wajib diisi.');
            hasError = true;
        }
        if (!phone) {
            showFieldError(document.getElementById('reg-phone'), 'No. Handphone wajib diisi.');
            hasError = true;
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

        /* Loading state */
        btnText.classList.add('hidden');
        btnLoad.classList.remove('hidden');
        btn.disabled = true;
        overlay.classList.remove('hidden');
        setInputsDisabled(true);

        /* Simulate submission */
        setTimeout(function () {
            formWrap.classList.add('hidden');
            sucBox.classList.remove('hidden');
        }, 1800);
    });

    /* Back to form */
    backBtn.addEventListener('click', function () {
        sucBox.classList.add('hidden');
        formWrap.classList.remove('hidden');

        /* Reset form */
        document.getElementById('reg-name').value = '';
        document.getElementById('reg-phone').value = '';
        attendeesWrap.innerHTML =
            '<div class="attendee-row flex gap-2 items-end">' +
                '<div class="flex-1 space-y-1.5">' +
                    '<input type="text" placeholder="Nama" class="reg-att-name reg-field w-full px-3 py-2.5 rounded-xl border border-stone-200 text-sm text-stone-800 placeholder-stone-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gold-400/50 focus:border-gold-400">' +
                '</div>' +
                '<div class="w-20 space-y-1.5">' +
                    '<input type="number" placeholder="Umur" min="0" max="120" class="reg-att-age reg-field w-full px-3 py-2.5 rounded-xl border border-stone-200 text-sm text-stone-800 placeholder-stone-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gold-400/50 focus:border-gold-400">' +
                '</div>' +
            '</div>';
        btnText.classList.remove('hidden');
        btnLoad.classList.add('hidden');
        btn.disabled = false;
        overlay.classList.add('hidden');
        setInputsDisabled(false);
        clearErrors();
    });
})();
</script>
