<!-- Event Details Section -->
<section class="relative py-14 sm:py-20 px-5 sm:px-8 overflow-hidden -mt-px bg-red-950">
    <!-- Gradient bg -->
    <div class="absolute inset-0 bg-gradient-to-b from-red-900 via-red-950 to-red-950"></div>
    <!-- Subtle dot pattern -->
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #f5edd6 1px, transparent 1px); background-size: 24px 24px;"></div>
    <!-- Radial gold glow -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_rgba(212,175,55,0.06)_0%,_transparent_60%)]"></div>

    <!-- Top fade from countdown (red-900) -->
    <div class="absolute top-0 left-0 right-0 h-24 bg-gradient-to-b from-red-900 via-red-900/80 to-transparent pointer-events-none z-10"></div>
    <!-- Bottom fade to registration (red-950) -->
    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-red-950 via-red-950/80 to-transparent pointer-events-none z-10"></div>

    <div class="relative z-10 max-w-md lg:max-w-lg mx-auto space-y-8">

        <!-- Header -->
        <div class="text-center space-y-4" data-aos="fade-up">
            <p class="text-[11px] font-semibold tracking-[0.25em] uppercase text-gold-400">
                Event Details
            </p>
            <!-- Gradient accent line -->
            <div class="flex items-center justify-center gap-3">
                <span class="block w-10 h-px bg-gradient-to-r from-transparent via-gold-400/60 to-transparent"></span>
                <span class="block w-1.5 h-1.5 rounded-full bg-gold-400/60"></span>
                <span class="block w-10 h-px bg-gradient-to-r from-transparent via-gold-400/60 to-transparent"></span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold text-white leading-snug">
                Informasi Acara
            </h2>
        </div>

        <!-- Cards grid -->
        <div class="space-y-3">

            <!-- Date -->
            <div class="card-hover flex items-start gap-4 p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10 shadow-sm" data-aos="fade-right" data-aos-delay="0">
                <div class="w-10 h-10 rounded-lg bg-gold-400/10 flex items-center justify-center shrink-0">
                    <i class="fas fa-calendar-alt text-gold-400 text-base"></i>
                </div>
                <div class="space-y-0.5">
                    <p class="text-xs font-semibold uppercase tracking-wider text-stone-300">Tanggal</p>
                    <p class="text-sm font-semibold text-white">Minggu, 20 Desember 2026</p>
                </div>
            </div>

            <!-- Time -->
            <div class="card-hover flex items-start gap-4 p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10 shadow-sm" data-aos="fade-right" data-aos-delay="80">
                <div class="w-10 h-10 rounded-lg bg-gold-400/10 flex items-center justify-center shrink-0">
                    <i class="fas fa-clock text-gold-400 text-base"></i>
                </div>
                <div class="space-y-0.5">
                    <p class="text-xs font-semibold uppercase tracking-wider text-stone-300">Waktu</p>
                    <p class="text-sm font-semibold text-white">17:00 – 20:00 WIB</p>
                    <p class="text-xs text-stone-400">Open Gate: 16:00 WIB</p>
                </div>
            </div>

            <!-- Location -->
            <div class="card-hover flex items-start gap-4 p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10 shadow-sm" data-aos="fade-right" data-aos-delay="160">
                <div class="w-10 h-10 rounded-lg bg-gold-400/10 flex items-center justify-center shrink-0">
                    <i class="fas fa-map-marker-alt text-gold-400 text-base"></i>
                </div>
                <div class="space-y-0.5">
                    <p class="text-xs font-semibold uppercase tracking-wider text-stone-300">Lokasi</p>
                    <p class="text-sm font-semibold text-white">GPdI Kopo Permai</p>
                    <p class="text-xs text-stone-400 leading-relaxed">Komp. Kopo Permai 2 Blok 19B No. 2-4, Bandung</p>
                </div>
            </div>

            <!-- Dresscode -->
            <div class="card-hover flex items-start gap-4 p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10 shadow-sm" data-aos="fade-right" data-aos-delay="240">
                <div class="w-10 h-10 rounded-lg bg-gold-400/10 flex items-center justify-center shrink-0">
                    <i class="fas fa-tshirt text-gold-400 text-base"></i>
                </div>
                <div class="space-y-0.5">
                    <p class="text-xs font-semibold uppercase tracking-wider text-stone-300">Dresscode</p>
                    <p class="text-sm font-semibold text-white">
                        <span class="text-red-400">Merah</span>
                        <span class="text-stone-500 mx-1">/</span>
                        <span class="text-gold-400">Gold</span>
                    </p>
                </div>
            </div>

        </div>

        <!-- Embedded Map -->
        <div class="rounded-2xl overflow-hidden border border-white/10 shadow-sm" data-aos="zoom-in" data-aos-delay="100">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d843.1203017108479!2d107.58710270616756!3d-6.9685757724170045!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e8d73290a91f%3A0x290398ae10b51bd8!2sGPdI%20Kopo%20Permai!5e0!3m2!1sid!2sid!4v1789645919094!5m2!1sid!2sid""
                    width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin"
                    class="w-full"></iframe>
        </div>

        <!-- Maps button -->
        <div class="text-center">
            <a href="https://www.google.com/maps/place/GPdI+Kopo+Permai/@-6.9685758,107.5871027,17z" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-gold-500 hover:bg-gold-600 text-red-950 font-semibold text-sm tracking-wide transition-all duration-300 hover:shadow-lg hover:shadow-gold-500/25 active:scale-95">
                <i class="fas fa-directions text-xs"></i>
                Buka Petunjuk Arah
            </a>
        </div>

    </div>
</section>
