<!-- Performers Section -->
<section class="relative py-20 sm:py-28 px-5 sm:px-8 overflow-hidden bg-red-950 -mt-px">
    <!-- Dot texture -->
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #f5edd6 1px, transparent 1px); background-size: 24px 24px;"></div>
    <!-- Radial gold glow -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_rgba(212,175,55,0.08)_0%,_transparent_60%)]"></div>

    <!-- Top fade from speaker -->
    <div class="absolute top-0 left-0 right-0 h-24 bg-gradient-to-b from-red-950 via-red-950/80 to-transparent pointer-events-none z-10"></div>
    <!-- Bottom fade to gallery -->
    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-red-950 via-red-950/80 to-transparent pointer-events-none z-10"></div>

    <!-- Bokeh dots -->
    <div class="absolute top-[15%] left-[12%] w-2 h-2 rounded-full bg-gold-400/15 blur-[1px] animate-pulse"></div>
    <div class="absolute top-[35%] right-[18%] w-1.5 h-1.5 rounded-full bg-gold-300/10 blur-[1px] animate-pulse" style="animation-delay: 1s;"></div>
    <div class="absolute bottom-[30%] left-[25%] w-1 h-1 rounded-full bg-gold-400/20 blur-[1px] animate-pulse" style="animation-delay: 2s;"></div>

    <div class="relative z-10 max-w-md lg:max-w-lg mx-auto space-y-8 pt-10 pb-10">

        <!-- Header -->
        <div class="text-center space-y-4">
            <p class="text-[11px] font-semibold tracking-[0.25em] uppercase text-gold-400">
                Dimeriahkan Oleh
            </p>
            <div class="flex items-center justify-center gap-3">
                <span class="block w-10 h-px bg-gradient-to-r from-transparent via-gold-400/60 to-transparent"></span>
                <span class="block w-1.5 h-1.5 rounded-full bg-gold-400/60"></span>
                <span class="block w-10 h-px bg-gradient-to-r from-transparent via-gold-400/60 to-transparent"></span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold text-white leading-snug">
                Performers
            </h2>
        </div>

        <!-- Performer cards grid -->
        <div class="grid grid-cols-2 gap-3">

            <!-- Worship Leader -->
            <div class="card-hover bg-white/10 backdrop-blur-sm rounded-2xl border border-white/10 shadow-sm p-5 text-center space-y-3">
                <div class="w-14 h-14 mx-auto rounded-full bg-gold-400/10 flex items-center justify-center">
                    <i class="fas fa-music text-gold-400 text-lg"></i>
                </div>
                <div class="space-y-0.5">
                    <p class="text-sm font-bold text-white">Worship Leader</p>
                    <p class="text-[11px] text-stone-300">Memimpin pujian</p>
                </div>
            </div>

            <!-- Christmas Choir -->
            <div class="card-hover bg-white/10 backdrop-blur-sm rounded-2xl border border-white/10 shadow-sm p-5 text-center space-y-3">
                <div class="w-14 h-14 mx-auto rounded-full bg-gold-400/10 flex items-center justify-center">
                    <i class="fas fa-users text-gold-400 text-lg"></i>
                </div>
                <div class="space-y-0.5">
                    <p class="text-sm font-bold text-white">Christmas Choir</p>
                    <p class="text-[11px] text-stone-300">Paduan suara</p>
                </div>
            </div>

            <!-- Music Team -->
            <div class="card-hover bg-white/10 backdrop-blur-sm rounded-2xl border border-white/10 shadow-sm p-5 text-center space-y-3">
                <div class="w-14 h-14 mx-auto rounded-full bg-gold-400/10 flex items-center justify-center">
                    <i class="fas fa-guitar text-gold-400 text-lg"></i>
                </div>
                <div class="space-y-0.5">
                    <p class="text-sm font-bold text-white">Music Team</p>
                    <p class="text-[11px] text-stone-300">Tim musik</p>
                </div>
            </div>

            <!-- Special Performance -->
            <div class="card-hover bg-white/10 backdrop-blur-sm rounded-2xl border border-white/10 shadow-sm p-5 text-center space-y-3">
                <div class="w-14 h-14 mx-auto rounded-full bg-gold-400/10 flex items-center justify-center">
                    <i class="fas fa-star text-gold-400 text-lg"></i>
                </div>
                <div class="space-y-0.5">
                    <p class="text-sm font-bold text-white">Special</p>
                    <p class="text-[11px] text-stone-300">Penampilan spesial</p>
                </div>
            </div>

        </div>

    </div>
</section>
