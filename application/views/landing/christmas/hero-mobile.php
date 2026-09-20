<!-- Hero (Mobile - Full Width) -->
<section
    class="lg:hidden relative flex flex-col items-center justify-center min-h-screen px-5 sm:px-8 py-16 text-center text-white overflow-hidden">

    <!-- Background image -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
        style="background-image: url('<?php echo site_url('assets/images/christmas/hero.jpg'); ?>');"></div>
    <!-- Maroon overlay -->
    <div class="absolute inset-0 bg-red-950/65"></div>
    <!-- Depth gradient -->
    <div class="absolute inset-0 bg-gradient-to-b from-red-950/70 via-red-950/45 to-red-950/80"></div>
    <!-- Soft glow -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(245,158,11,0.08)_0%,_transparent_70%)]">
    </div>

    <!-- Decorative stars (CSS) -->
    <div class="hero-stars absolute inset-0 pointer-events-none"></div>

    <!-- Soft bokeh dots -->
    <div class="absolute top-[10%] left-[15%] w-2 h-2 rounded-full bg-gold-400/20 blur-[1px] animate-pulse"></div>
    <div class="absolute top-[25%] right-[20%] w-1.5 h-1.5 rounded-full bg-gold-300/15 blur-[1px] animate-pulse"
        style="animation-delay: 1s;"></div>
    <div class="absolute bottom-[30%] left-[10%] w-1 h-1 rounded-full bg-gold-400/25 blur-[1px] animate-pulse"
        style="animation-delay: 2s;"></div>
    <div class="absolute bottom-[20%] right-[25%] w-2 h-2 rounded-full bg-gold-300/15 blur-[1px] animate-pulse"
        style="animation-delay: 0.5s;"></div>
    <div class="absolute top-[60%] left-[30%] w-1 h-1 rounded-full bg-gold-400/20 blur-[1px] animate-pulse"
        style="animation-delay: 1.5s;"></div>

    <!-- Content -->
    <div class="relative z-10 space-y-6 max-w-md">

        <!-- Logo -->
        <img src="<?php echo site_url('assets/images/christmas/gpdi.png'); ?>" alt="GPdI Kopo Permai"
            class="w-12 h-auto mx-auto drop-shadow-[0_4px_12px_rgba(0,0,0,0.5)]">

        <!-- Eyebrow label -->
        <p class="text-[10px] sm:text-[11px] font-semibold tracking-[0.25em] uppercase text-gold-400">
            GPdI Kopo Permai<br>Christmas Celebration 2026
        </p>

        <!-- Decorative gold line -->
        <div class="flex items-center justify-center gap-3">
            <span class="block w-8 h-px bg-gold-400/50"></span>
            <span class="block w-1.5 h-1.5 rounded-full bg-gold-400/60"></span>
            <span class="block w-8 h-px bg-gold-400/50"></span>
        </div>

        <!-- Main title -->
        <img src="<?php echo site_url('assets/images/christmas/from-glory.png'); ?>" alt="From Glory to Glory"
            class="w-full max-w-sm mx-auto drop-shadow-[0_4px_16px_rgba(0,0,0,0.6)]">

        <!-- Decorative gold line -->
        <div class="flex items-center justify-center gap-3">
            <span class="block w-12 h-px bg-gold-400/30"></span>
            <span class="block w-1 h-1 rounded-full bg-gold-400/40"></span>
            <span class="block w-12 h-px bg-gold-400/30"></span>
        </div>

        <!-- Bible verse -->
        <blockquote class="space-y-2">
            <p class="text-xs sm:text-sm italic text-stone-300/80 leading-relaxed">
                "Dan kita semua mencerminkan kemuliaan Tuhan dengan muka yang tidak berselubung. Dan karena kemuliaan
                itu datangnya dari Tuhan yang adalah Roh, maka kita diubah menjadi serupa dengan gambar-Nya, dalam
                kemuliaan yang semakin besar."
            </p>
            <cite class="block text-[11px] sm:text-xs font-semibold text-gold-400/70 not-italic tracking-wide">
                — 2 Korintus 3:18 (TB)
            </cite>
        </blockquote>

        <!-- CTA Button -->
        <div class="pt-4">
            <a href="#sec-register"
                class="inline-block px-8 py-3 rounded-full bg-gold-500 hover:bg-gold-600 text-red-950 font-semibold text-sm tracking-wide transition-all duration-300 hover:shadow-lg hover:shadow-gold-500/25 active:scale-95">
                Daftar Sekarang
            </a>
        </div>

    </div>

    <!-- Bottom fade — blend into dark welcome section -->
    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-red-950 to-transparent pointer-events-none">
    </div>

</section>