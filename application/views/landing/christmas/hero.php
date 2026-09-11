<!-- Hero (Desktop - Left Panel) -->
<div class="relative flex flex-col items-center justify-center h-full px-8 py-12 text-center text-white overflow-hidden">

    <!-- Background: gradient + soft glow -->
    <div class="absolute inset-0 bg-gradient-to-b from-red-950 via-red-950 to-red-900"></div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(245,158,11,0.08)_0%,_transparent_70%)]"></div>

    <!-- Decorative stars (CSS) -->
    <div class="hero-stars absolute inset-0 pointer-events-none"></div>

    <!-- Soft bokeh dots -->
    <div class="absolute top-[10%] left-[15%] w-2 h-2 rounded-full bg-amber-400/20 blur-[1px] animate-pulse"></div>
    <div class="absolute top-[25%] right-[20%] w-1.5 h-1.5 rounded-full bg-amber-300/15 blur-[1px] animate-pulse" style="animation-delay: 1s;"></div>
    <div class="absolute bottom-[30%] left-[10%] w-1 h-1 rounded-full bg-amber-400/25 blur-[1px] animate-pulse" style="animation-delay: 2s;"></div>
    <div class="absolute bottom-[20%] right-[25%] w-2 h-2 rounded-full bg-amber-300/15 blur-[1px] animate-pulse" style="animation-delay: 0.5s;"></div>
    <div class="absolute top-[60%] left-[30%] w-1 h-1 rounded-full bg-amber-400/20 blur-[1px] animate-pulse" style="animation-delay: 1.5s;"></div>

    <!-- Content -->
    <div class="relative z-10 space-y-8 max-w-sm">

        <!-- Logo placeholder -->
        <div class="w-20 h-20 mx-auto rounded-full border-2 border-amber-400/40 flex items-center justify-center">
            <span class="text-xs font-semibold text-amber-400/80 tracking-wider uppercase">Logo</span>
        </div>

        <!-- Eyebrow label -->
        <p class="text-[11px] font-semibold tracking-[0.25em] uppercase text-amber-400">
            Christmas Celebration 2026
        </p>

        <!-- Decorative gold line -->
        <div class="flex items-center justify-center gap-3">
            <span class="block w-8 h-px bg-amber-400/50"></span>
            <span class="block w-1.5 h-1.5 rounded-full bg-amber-400/60"></span>
            <span class="block w-8 h-px bg-amber-400/50"></span>
        </div>

        <!-- Main title -->
        <h1 class="text-4xl xl:text-5xl font-bold leading-tight text-white">
            Joy to the World
        </h1>

        <!-- Subtitle -->
        <p class="text-base font-medium text-amber-200/80">
            Light in the Darkness
        </p>

        <!-- Decorative gold line -->
        <div class="flex items-center justify-center gap-3">
            <span class="block w-12 h-px bg-amber-400/30"></span>
            <span class="block w-1 h-1 rounded-full bg-amber-400/40"></span>
            <span class="block w-12 h-px bg-amber-400/30"></span>
        </div>

        <!-- Bible verse -->
        <blockquote class="space-y-2">
            <p class="text-sm italic text-stone-300/80 leading-relaxed">
                "The light shines in the<br>darkness, and the darkness<br>has not overcome it."
            </p>
            <cite class="block text-xs font-semibold text-amber-400/70 not-italic tracking-wide">
                — John 1:5
            </cite>
        </blockquote>

        <!-- CTA Button -->
        <div class="pt-4">
            <a href="#sec-register"
               class="inline-block px-8 py-3 rounded-full bg-amber-500 hover:bg-amber-600 text-red-950 font-semibold text-sm tracking-wide transition-all duration-300 hover:shadow-lg hover:shadow-amber-500/25">
                Daftar Sekarang
            </a>
        </div>

    </div>

    <!-- Bottom decorative gradient fade -->
    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-red-950 to-transparent pointer-events-none"></div>

</div>

<style>
    .hero-stars {
        background-image:
            radial-gradient(1px 1px at 20% 30%, rgba(245,158,11,0.4) 0%, transparent 100%),
            radial-gradient(1px 1px at 80% 20%, rgba(245,158,11,0.3) 0%, transparent 100%),
            radial-gradient(1px 1px at 40% 70%, rgba(245,158,11,0.25) 0%, transparent 100%),
            radial-gradient(1px 1px at 60% 50%, rgba(255,255,255,0.15) 0%, transparent 100%),
            radial-gradient(1px 1px at 10% 80%, rgba(245,158,11,0.2) 0%, transparent 100%),
            radial-gradient(1.5px 1.5px at 90% 60%, rgba(245,158,11,0.3) 0%, transparent 100%),
            radial-gradient(1px 1px at 50% 10%, rgba(255,255,255,0.2) 0%, transparent 100%),
            radial-gradient(1px 1px at 30% 90%, rgba(245,158,11,0.15) 0%, transparent 100%),
            radial-gradient(1.5px 1.5px at 70% 85%, rgba(245,158,11,0.25) 0%, transparent 100%),
            radial-gradient(1px 1px at 15% 50%, rgba(255,255,255,0.1) 0%, transparent 100%);
    }
</style>
