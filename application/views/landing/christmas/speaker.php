<!-- Speaker Section -->
<section class="relative py-20 sm:py-28 px-5 sm:px-8 overflow-hidden">
    <!-- Dot texture -->
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #1c1917 1px, transparent 1px); background-size: 24px 24px;"></div>
    <!-- Radial gold glow -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(212,175,55,0.04)_0%,_transparent_60%)]"></div>

    <!-- Top fade from registration -->
    <div class="absolute top-0 left-0 right-0 h-16 bg-gradient-to-b from-stone-100/50 to-transparent pointer-events-none"></div>
    <!-- Bottom fade to performers -->
    <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-stone-100/50 to-transparent pointer-events-none"></div>

    <div class="relative z-10 max-w-md lg:max-w-lg mx-auto space-y-8">

        <!-- Header -->
        <div class="text-center space-y-4">
            <p class="text-[11px] font-semibold tracking-[0.25em] uppercase text-gold-500">
                Featured Speaker
            </p>
            <div class="flex items-center justify-center gap-3">
                <span class="block w-10 h-px bg-gradient-to-r from-transparent via-gold-400/60 to-transparent"></span>
                <span class="block w-1.5 h-1.5 rounded-full bg-gold-400/60"></span>
                <span class="block w-10 h-px bg-gradient-to-r from-transparent via-gold-400/60 to-transparent"></span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold text-stone-800 leading-snug">
                Pembicara
            </h2>
        </div>

        <!-- Speaker card -->
        <div class="card-hover bg-white rounded-2xl border border-stone-100 shadow-sm p-8 text-center space-y-5">

            <!-- Photo -->
            <div class="relative w-28 h-28 mx-auto">
                <div class="w-full h-full rounded-full bg-gradient-to-br from-gold-400 to-gold-500 p-[2px]">
                    <div class="w-full h-full rounded-full bg-stone-100 flex items-center justify-center overflow-hidden">
                        <img src="https://picsum.photos/200/200?random=10" alt="Speaker"
                             class="w-full h-full object-cover rounded-full">
                    </div>
                </div>
                <!-- Decorative star -->
                <div class="absolute -top-1 -right-1 w-6 h-6 rounded-full bg-gold-50 flex items-center justify-center border border-gold-200">
                    <i class="fas fa-star text-gold-400 text-[8px]"></i>
                </div>
            </div>

            <!-- Name & title -->
            <div class="space-y-1">
                <h3 class="text-lg font-bold text-stone-800">Ps. John Doe</h3>
                <p class="text-xs font-semibold uppercase tracking-wider text-gold-500">Guest Speaker</p>
            </div>

            <!-- Brief bio -->
            <p class="text-xs text-stone-500 leading-relaxed max-w-xs mx-auto">
                Menginspirasi komunitas untuk merayakan sukacita Natal dengan penuh makna dan kebersamaan.
            </p>

        </div>

    </div>
</section>
