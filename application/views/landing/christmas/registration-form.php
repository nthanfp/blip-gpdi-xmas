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

        <!-- Form card -->
        <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6 sm:p-8 space-y-5">

            <!-- Nama Lengkap -->
            <div class="space-y-1.5">
                <label for="reg-name" class="block text-xs font-semibold text-stone-700 tracking-wide">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" id="reg-name" name="name" placeholder="Masukkan nama lengkap"
                       class="reg-input w-full px-4 py-3 rounded-xl border border-stone-200 text-sm text-stone-800 placeholder-stone-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
            </div>

            <!-- WhatsApp / Email -->
            <div class="space-y-1.5">
                <label for="reg-contact" class="block text-xs font-semibold text-stone-700 tracking-wide">
                    WhatsApp / Email <span class="text-red-500">*</span>
                </label>
                <input type="text" id="reg-contact" name="contact" placeholder="08xxxxxxxxxx / email@example.com"
                       class="reg-input w-full px-4 py-3 rounded-xl border border-stone-200 text-sm text-stone-800 placeholder-stone-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
            </div>

            <!-- Kategori -->
            <div class="space-y-1.5">
                <label for="reg-category" class="block text-xs font-semibold text-stone-700 tracking-wide">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select id="reg-category" name="category"
                        class="reg-input w-full px-4 py-3 rounded-xl border border-stone-200 text-sm text-stone-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400 appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%239ca3af%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.23%207.21a.75.75%200%20011.06.02L10%2011.168l3.71-3.938a.75.75%200%20111.08%201.04l-4.25%204.5a.75.75%200%2001-1.08%200l-4.25-4.5a.75.75%200%2001.02-1.06z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem] bg-[right_0.75rem_center] bg-no-repeat">
                    <option value="" disabled selected>Pilih kategori</option>
                    <option value="jemaat">Jemaat</option>
                    <option value="pemuda">Pemuda</option>
                    <option value="anak">Anak-anak</option>
                    <option value="tamu">Tamu</option>
                </select>
            </div>

            <!-- Jumlah Kehadiran -->
            <div class="space-y-1.5">
                <label for="reg-qty" class="block text-xs font-semibold text-stone-700 tracking-wide">
                    Jumlah Kehadiran <span class="text-red-500">*</span>
                </label>
                <input type="number" id="reg-qty" name="qty" value="1" min="1" max="10"
                       class="reg-input w-full px-4 py-3 rounded-xl border border-stone-200 text-sm text-stone-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
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

            <!-- Error state (hidden by default) -->
            <div id="reg-error" class="hidden p-3 rounded-xl bg-red-50 border border-red-200 text-xs text-red-600">
                <i class="fas fa-exclamation-circle mr-1"></i>
                <span id="reg-error-msg">Nomor WhatsApp wajib diisi.</span>
            </div>

            <!-- Submit button -->
            <button type="button" id="reg-submit"
                    class="w-full py-3.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-red-950 font-semibold text-sm tracking-wide transition-all duration-300 hover:shadow-lg hover:shadow-amber-500/25 active:scale-[0.98]">
                <span id="reg-btn-text">Daftar Sekarang</span>
                <span id="reg-btn-loading" class="hidden">
                    <i class="fas fa-spinner fa-spin mr-1"></i> Mendaftarkan...
                </span>
            </button>

        </div>

        <!-- Success state (hidden by default) -->
        <div id="reg-success" class="hidden bg-white rounded-2xl border border-stone-100 shadow-sm p-8 text-center space-y-4">
            <div class="w-16 h-16 mx-auto rounded-full bg-green-50 flex items-center justify-center">
                <i class="fas fa-check text-green-500 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-stone-800">Pendaftaran Berhasil!</h3>
            <p class="text-sm text-stone-500 leading-relaxed">
                Terima kasih telah melakukan pendaftaran. Kami akan mengirimkan konfirmasi ke kontak yang Anda berikan.
            </p>
            <button type="button" onclick="document.getElementById('reg-success').classList.add('hidden'); document.querySelector('.space-y-5:last-child').closest('div').classList.remove('hidden');"
                    class="text-xs font-semibold text-amber-500 hover:text-amber-600 tracking-wide">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke form
            </button>
        </div>

    </div>
</section>

<script>
(function () {
    var btn = document.getElementById('reg-submit');
    var btnText = document.getElementById('reg-btn-text');
    var btnLoad = document.getElementById('reg-btn-loading');
    var errBox = document.getElementById('reg-error');
    var errMsg = document.getElementById('reg-error-msg');
    var sucBox = document.getElementById('reg-success');
    var formCard = btn.closest('.space-y-5');

    btn.addEventListener('click', function () {
        var name = document.getElementById('reg-name').value.trim();
        var contact = document.getElementById('reg-contact').value.trim();
        var category = document.getElementById('reg-category').value;

        /* Reset error */
        errBox.classList.add('hidden');

        /* Validate */
        if (!name) {
            errMsg.textContent = 'Nama lengkap wajib diisi.';
            errBox.classList.remove('hidden');
            return;
        }
        if (!contact) {
            errMsg.textContent = 'Nomor WhatsApp / Email wajib diisi.';
            errBox.classList.remove('hidden');
            return;
        }
        if (!category) {
            errMsg.textContent = 'Silakan pilih kategori.';
            errBox.classList.remove('hidden');
            return;
        }

        /* Loading state */
        btnText.classList.add('hidden');
        btnLoad.classList.remove('hidden');
        btn.disabled = true;

        /* Simulate submission */
        setTimeout(function () {
            btnText.classList.remove('hidden');
            btnLoad.classList.add('hidden');
            btn.disabled = false;
            formCard.classList.add('hidden');
            sucBox.classList.remove('hidden');
        }, 1500);
    });
})();
</script>
