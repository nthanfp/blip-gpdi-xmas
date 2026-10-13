<!-- FAQ Section -->
<section class="relative py-14 sm:py-20 px-5 sm:px-8 overflow-hidden -mt-px bg-red-950">
    <!-- Gradient bg -->
    <div class="absolute inset-0 bg-gradient-to-b from-red-900/70 via-red-950 to-red-950"></div>
    <!-- Dot texture -->
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #f5edd6 1px, transparent 1px); background-size: 24px 24px;"></div>
    <!-- Radial gold glow -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(212,175,55,0.06)_0%,_transparent_60%)]"></div>

    <!-- Top fade from gallery (red-900/70) -->
    <div class="absolute top-0 left-0 right-0 h-24 bg-gradient-to-b from-red-900/70 via-red-900/50 to-transparent pointer-events-none z-10"></div>
    <!-- Bottom fade to contact -->
    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-red-950 via-red-950/80 to-transparent pointer-events-none z-10"></div>

    <div class="relative z-10 max-w-md lg:max-w-lg mx-auto space-y-8">

        <!-- Header -->
        <div class="text-center space-y-4" data-aos="fade-up">
            <p class="text-[11px] font-semibold tracking-[0.25em] uppercase text-gold-400">
                FAQ
            </p>
            <div class="flex items-center justify-center gap-3">
                <span class="block w-8 h-px bg-gold-400/50"></span>
                <span class="block w-1.5 h-1.5 rounded-full bg-gold-400/60"></span>
                <span class="block w-8 h-px bg-gold-400/50"></span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold text-white leading-snug">
                Pertanyaan Umum
            </h2>
        </div>

        <!-- Accordion -->
        <div class="space-y-2" id="faq-list">

            <!-- Q1 -->
            <div class="faq-item card-hover bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="0">
                <button type="button"
                        class="faq-toggle w-full flex items-center justify-between gap-3 px-5 py-4 text-left">
                    <span class="text-sm font-semibold text-white">Bagaimana cara melakukan pendaftaran?</span>
                    <i class="fas fa-chevron-down text-stone-400 text-xs shrink-0 transition-transform duration-200"></i>
                </button>
                <div class="faq-answer hidden px-5 pb-4">
                    <p class="text-xs text-stone-300 leading-relaxed">
                        Klik tombol "Daftar Sekarang", isi formulir pendaftaran dengan lengkap, lalu tekan tombol kirim. Anda akan menerima konfirmasi melalui kontak yang didaftarkan.
                    </p>
                </div>
            </div>

            <!-- Q2 -->
            <div class="faq-item card-hover bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="70">
                <button type="button"
                        class="faq-toggle w-full flex items-center justify-between gap-3 px-5 py-4 text-left">
                    <span class="text-sm font-semibold text-white">Apakah acara ini gratis?</span>
                    <i class="fas fa-chevron-down text-stone-400 text-xs shrink-0 transition-transform duration-200"></i>
                </button>
                <div class="faq-answer hidden px-5 pb-4">
                    <p class="text-xs text-stone-300 leading-relaxed">
                        Ya, acara ini terbuka untuk umum dan tidak dipungut biaya. Anda hanya perlu mendaftarkan diri untuk menjaga kuota tempat.
                    </p>
                </div>
            </div>

            <!-- Q3 -->
            <div class="faq-item card-hover bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="140">
                <button type="button"
                        class="faq-toggle w-full flex items-center justify-between gap-3 px-5 py-4 text-left">
                    <span class="text-sm font-semibold text-white">Apakah anak-anak boleh hadir?</span>
                    <i class="fas fa-chevron-down text-stone-400 text-xs shrink-0 transition-transform duration-200"></i>
                </button>
                <div class="faq-answer hidden px-5 pb-4">
                    <p class="text-xs text-stone-300 leading-relaxed">
                        Tentu! Anak-anak sangat welcome. Pilih kategori "Anak-anak" saat pendaftaran untuk kelompok usia anak.
                    </p>
                </div>
            </div>

            <!-- Q4 -->
            <div class="faq-item card-hover bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="210">
                <button type="button"
                        class="faq-toggle w-full flex items-center justify-between gap-3 px-5 py-4 text-left">
                    <span class="text-sm font-semibold text-white">Bagaimana proses check-in?</span>
                    <i class="fas fa-chevron-down text-stone-400 text-xs shrink-0 transition-transform duration-200"></i>
                </button>
                <div class="faq-answer hidden px-5 pb-4">
                    <p class="text-xs text-stone-300 leading-relaxed">
                        Datang sesuai sesi yang dipilih, tunjukkan konfirmasi pendaftaran kepada petugas di pintu masuk, lalu Anda akan mendapatkan kartu hadir.
                    </p>
                </div>
            </div>

            <!-- Q5 -->
            <div class="faq-item card-hover bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="280">
                <button type="button"
                        class="faq-toggle w-full flex items-center justify-between gap-3 px-5 py-4 text-left">
                    <span class="text-sm font-semibold text-white">Apakah perlu membawa tiket?</span>
                    <i class="fas fa-chevron-down text-stone-400 text-xs shrink-0 transition-transform duration-200"></i>
                </button>
                <div class="faq-answer hidden px-5 pb-4">
                    <p class="text-xs text-stone-300 leading-relaxed">
                        Tidak perlu tiket fisik. Cukup tunjukkan bukti pendaftaran digital (screenshot atau email konfirmasi) saat check-in.
                    </p>
                </div>
            </div>

            <!-- Q6 -->
            <div class="faq-item card-hover bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="350">
                <button type="button"
                        class="faq-toggle w-full flex items-center justify-between gap-3 px-5 py-4 text-left">
                    <span class="text-sm font-semibold text-white">Di mana lokasi parkir?</span>
                    <i class="fas fa-chevron-down text-stone-400 text-xs shrink-0 transition-transform duration-200"></i>
                </button>
                <div class="faq-answer hidden px-5 pb-4">
                    <p class="text-xs text-stone-300 leading-relaxed">
                        Parkir mobil tersedia di lapangan barat gereja. Parkir motor di halaman gereja. Datang lebih awal untuk mendapatkan tempat parkir yang nyaman.
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>

<script>
(function () {
    var toggles = document.querySelectorAll('.faq-toggle');

    toggles.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var item = this.closest('.faq-item');
            var answer = item.querySelector('.faq-answer');
            var icon = this.querySelector('i');
            var isOpen = !answer.classList.contains('hidden');

            /* Close all others */
            document.querySelectorAll('.faq-answer').forEach(function (a) {
                a.classList.add('hidden');
            });
            document.querySelectorAll('.faq-toggle i').forEach(function (i) {
                i.classList.remove('rotate-180');
            });

            /* Toggle current */
            if (!isOpen) {
                answer.classList.remove('hidden');
                icon.classList.add('rotate-180');
            }
        });
    });
})();
</script>
