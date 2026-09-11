<!-- Registration Form Section -->
<section id="sec-register" class="py-20 sm:py-28 px-5 sm:px-8 bg-stone-100/50">
    <div class="max-w-md mx-auto space-y-8">

        <!-- Header -->
        <div class="text-center space-y-4">
            <p class="text-[11px] font-semibold tracking-[0.25em] uppercase text-amber-500">
                Register Now
            </p>
            <div class="flex items-center justify-center gap-3">
                <span class="block w-8 h-px bg-amber-400/50"></span>
                <span class="block w-1.5 h-1.5 rounded-full bg-amber-400/60"></span>
                <span class="block w-8 h-px bg-amber-400/50"></span>
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
                    <i class="fas fa-spinner fa-spin text-amber-500 text-2xl"></i>
                    <p class="text-sm font-semibold text-stone-600">Mendaftarkan...</p>
                </div>

                <!-- Nama Lengkap -->
                <div class="space-y-1.5">
                    <label for="reg-name" class="block text-xs font-semibold text-stone-700 tracking-wide">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="reg-name" name="name" placeholder="Masukkan nama lengkap"
                           class="reg-input reg-field w-full px-4 py-3 rounded-xl border border-stone-200 text-sm text-stone-800 placeholder-stone-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                    <p class="reg-err-msg hidden text-[11px] text-red-500 mt-1"></p>
                </div>

                <!-- WhatsApp / Email -->
                <div class="space-y-1.5">
                    <label for="reg-contact" class="block text-xs font-semibold text-stone-700 tracking-wide">
                        WhatsApp / Email <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="reg-contact" name="contact" placeholder="08xxxxxxxxxx / email@example.com"
                           class="reg-input reg-field w-full px-4 py-3 rounded-xl border border-stone-200 text-sm text-stone-800 placeholder-stone-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                    <p class="reg-err-msg hidden text-[11px] text-red-500 mt-1"></p>
                </div>

                <!-- Kategori -->
                <div class="space-y-1.5">
                    <label for="reg-category" class="block text-xs font-semibold text-stone-700 tracking-wide">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select id="reg-category" name="category"
                            class="reg-input reg-field w-full px-4 py-3 rounded-xl border border-stone-200 text-sm text-stone-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400 appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%239ca3af%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.23%207.21a.75.75%200%20011.06.02L10%2011.168l3.71-3.938a.75.75%200%20111.08%201.04l-4.25%204.5a.75.75%200%2001-1.08%200l-4.25-4.5a.75.75%200%2001.02-1.06z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem] bg-[right_0.75rem_center] bg-no-repeat">
                        <option value="" disabled selected>Pilih kategori</option>
                        <option value="jemaat">Jemaat</option>
                        <option value="pemuda">Pemuda</option>
                        <option value="anak">Anak-anak</option>
                        <option value="tamu">Tamu</option>
                    </select>
                    <p class="reg-err-msg hidden text-[11px] text-red-500 mt-1"></p>
                </div>

                <!-- Jumlah Kehadiran -->
                <div class="space-y-1.5">
                    <label for="reg-qty" class="block text-xs font-semibold text-stone-700 tracking-wide">
                        Jumlah Kehadiran <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="reg-qty" name="qty" value="1" min="1" max="10"
                           class="reg-input reg-field w-full px-4 py-3 rounded-xl border border-stone-200 text-sm text-stone-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                </div>

                <!-- Sesi -->
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-stone-700 tracking-wide">
                        Sesi <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-3">
                        <label class="sesi-option flex-1">
                            <input type="radio" name="session" value="1" class="sr-only peer" checked>
                            <div class="cursor-pointer text-center px-3 py-3 rounded-xl border border-stone-200 text-sm text-stone-600 transition-all duration-200 peer-checked:border-amber-400 peer-checked:bg-amber-50 peer-checked:text-amber-700 hover:border-stone-300">
                                <p class="font-semibold">Sesi 1</p>
                                <p class="text-xs text-stone-400 peer-checked:text-amber-500">16:00</p>
                            </div>
                        </label>
                        <label class="sesi-option flex-1">
                            <input type="radio" name="session" value="2" class="sr-only peer">
                            <div class="cursor-pointer text-center px-3 py-3 rounded-xl border border-stone-200 text-sm text-stone-600 transition-all duration-200 peer-checked:border-amber-400 peer-checked:bg-amber-50 peer-checked:text-amber-700 hover:border-stone-300">
                                <p class="font-semibold">Sesi 2</p>
                                <p class="text-xs text-stone-400 peer-checked:text-amber-500">19:00</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Global error (hidden) -->
                <div id="reg-error" class="hidden p-3 rounded-xl bg-red-50 border border-red-200 text-xs text-red-600">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    <span id="reg-error-msg"></span>
                </div>

                <!-- Submit button -->
                <button type="button" id="reg-submit"
                        class="w-full py-3.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-red-950 font-semibold text-sm tracking-wide transition-all duration-300 hover:shadow-lg hover:shadow-amber-500/25 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2">
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
                <div class="flex items-center justify-center gap-2 text-amber-400">
                    <i class="fas fa-star text-[10px]"></i>
                    <i class="fas fa-star text-xs"></i>
                    <i class="fas fa-star text-[10px]"></i>
                </div>

                <!-- Back button -->
                <button type="button" id="reg-back-btn"
                        class="inline-flex items-center gap-2 text-xs font-semibold text-amber-500 hover:text-amber-600 tracking-wide transition-colors">
                    <i class="fas fa-arrow-left"></i> Kembali ke form
                </button>

            </div>
        </div>

    </div>
</section>

<style>
    /* Error input state */
    .reg-field.reg-error {
        @apply border-red-400 bg-red-50/50;
        box-shadow: 0 0 0 2px rgba(248, 113, 113, 0.15);
    }
    .reg-field.reg-error:focus {
        @apply ring-red-400/50 border-red-400;
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
        @apply opacity-50 cursor-not-allowed;
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
    var fields = document.querySelectorAll('.reg-field');

    function clearErrors() {
        errBox.classList.add('hidden');
        fields.forEach(function (f) {
            f.classList.remove('reg-error');
        });
        document.querySelectorAll('.reg-err-msg').forEach(function (e) {
            e.classList.add('hidden');
            e.textContent = '';
        });
    }

    function showFieldError(fieldId, msg) {
        var field = document.getElementById(fieldId);
        var errEl = field.parentElement.querySelector('.reg-err-msg');
        if (field) field.classList.add('reg-error');
        if (errEl) {
            errEl.textContent = msg;
            errEl.classList.remove('hidden');
        }
    }

    function setInputsDisabled(state) {
        fields.forEach(function (f) { f.disabled = state; });
    }

    btn.addEventListener('click', function () {
        var name = document.getElementById('reg-name').value.trim();
        var contact = document.getElementById('reg-contact').value.trim();
        var category = document.getElementById('reg-category').value;

        clearErrors();

        var hasError = false;

        if (!name) {
            showFieldError('reg-name', 'Nama lengkap wajib diisi.');
            hasError = true;
        }
        if (!contact) {
            showFieldError('reg-contact', 'Nomor WhatsApp / Email wajib diisi.');
            hasError = true;
        }
        if (!category) {
            showFieldError('reg-category', 'Silakan pilih kategori.');
            hasError = true;
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
        document.getElementById('reg-contact').value = '';
        document.getElementById('reg-category').selectedIndex = 0;
        document.getElementById('reg-qty').value = '1';
        document.querySelector('input[name="session"][value="1"]').checked = true;
        btnText.classList.remove('hidden');
        btnLoad.classList.add('hidden');
        btn.disabled = false;
        overlay.classList.add('hidden');
        setInputsDisabled(false);
        clearErrors();
    });
})();
</script>
