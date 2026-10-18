<!-- Speaker Section -->
<section class="relative py-14 sm:py-20 px-5 sm:px-8 overflow-hidden bg-red-950 -mt-px">
    <!-- Gradient bg -->
    <div class="absolute inset-0 bg-gradient-to-b from-red-900 via-red-950 to-red-950"></div>
    <!-- Dot texture -->
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #f5edd6 1px, transparent 1px); background-size: 24px 24px;"></div>
    <!-- Radial gold glow -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(212,175,55,0.08)_0%,_transparent_60%)]"></div>

    <!-- Top fade from event-details (red-950) -->
    <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-b from-red-950 via-red-950/80 to-transparent pointer-events-none z-10"></div>
    <!-- Bottom fade to performers -->
    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-red-950 via-red-950/80 to-transparent pointer-events-none z-10"></div>

    <!-- Bokeh dots -->
    <div class="absolute top-[20%] left-[10%] w-2 h-2 rounded-full bg-gold-400/15 blur-[1px] animate-pulse"></div>
    <div class="absolute top-[40%] right-[15%] w-1.5 h-1.5 rounded-full bg-gold-300/10 blur-[1px] animate-pulse" style="animation-delay: 1s;"></div>
    <div class="absolute bottom-[25%] left-[20%] w-1 h-1 rounded-full bg-gold-400/20 blur-[1px] animate-pulse" style="animation-delay: 2s;"></div>

    <div class="relative z-10 max-w-md lg:max-w-lg mx-auto space-y-8">

        <!-- Header -->
        <div class="text-center space-y-4" data-aos="fade-up">
            <p class="text-[11px] font-semibold tracking-[0.25em] uppercase text-gold-400">
                Featured Speaker
            </p>
            <div class="flex items-center justify-center gap-3">
                <span class="block w-10 h-px bg-gradient-to-r from-transparent via-gold-400/60 to-transparent"></span>
                <span class="block w-1.5 h-1.5 rounded-full bg-gold-400/60"></span>
                <span class="block w-10 h-px bg-gradient-to-r from-transparent via-gold-400/60 to-transparent"></span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold text-white leading-snug">
                Pembicara
            </h2>
        </div>

        <!-- Speaker card -->
        <div class="card-hover bg-white/10 backdrop-blur-sm rounded-2xl border border-white/10 shadow-sm p-8 text-center space-y-5" data-aos="zoom-in-up" data-aos-delay="120">

            <!-- Photo -->
            <div class="relative w-40 h-40 sm:w-44 sm:h-44 mx-auto">
                <div class="w-full h-full rounded-full bg-gradient-to-br from-gold-400 to-gold-500 p-[2px]">
                    <div class="w-full h-full rounded-full bg-red-950 flex items-center justify-center overflow-hidden">
                        <img src="<?php echo site_url('assets/images/christmas/pdt-harapan.webp'); ?>" alt="Pdt. Harapan Nainggolan, M.Th"
                             class="w-full h-full object-cover rounded-full">
                    </div>
                </div>
            </div>

            <!-- Name & title -->
            <div class="space-y-1">
                <h3 class="text-lg font-bold text-white">Pdt. Harapan Nainggolan, M.Th</h3>
                <p class="text-xs font-semibold uppercase tracking-wider text-gold-400">Pembimas Kristen DKI Jakarta</p>
            </div>

        </div>

    </div>
</section>
