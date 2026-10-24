<!-- Hero (Desktop - Left Panel) -->
<div
    class="hero-desktop-panel relative flex flex-col items-center justify-center h-full px-8 py-16 text-center text-white overflow-hidden">

    <!-- Background image -->
    <div id="hero-parallax-bg" class="absolute inset-0 bg-cover bg-center bg-no-repeat"
        style="background-image: url('<?php echo site_url('assets/images/christmas/hero.webp'); ?>');"></div>
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
        <img src="<?php echo site_url('assets/images/christmas/gpdi.webp'); ?>" alt="GPdI Kopo Permai"
            class="w-12 h-auto mx-auto drop-shadow-[0_4px_12px_rgba(0,0,0,0.5)]"
            data-aos="fade-up" data-aos-delay="0">

        <!-- Eyebrow label -->
        <p class="text-[11px] font-semibold tracking-[0.25em] uppercase text-gold-400"
            data-aos="fade-up" data-aos-delay="100">
            GPdI Kopo Permai<br>Christmas Celebration 2026
        </p>

        <!-- Decorative gold line -->
        <div class="flex items-center justify-center gap-3" data-aos="fade-up" data-aos-delay="180">
            <span class="block w-8 h-px bg-gold-400/50"></span>
            <span class="block w-1.5 h-1.5 rounded-full bg-gold-400/60"></span>
            <span class="block w-8 h-px bg-gold-400/50"></span>
        </div>

        <!-- Main title (dengan sparkle sweep) -->
        <div class="glory-wrap relative overflow-hidden -mx-6 md:-mx-10" data-aos="fade-up" data-aos-delay="260">
            <img src="<?php echo site_url('assets/images/christmas/from-glory.png'); ?>" alt="From Glory to Glory"
                class="w-full drop-shadow-[0_4px_16px_rgba(0,0,0,0.6)]">
            <span class="glory-shine" aria-hidden="true"
                style="-webkit-mask-image:url('<?php echo site_url('assets/images/christmas/from-glory.png'); ?>');mask-image:url('<?php echo site_url('assets/images/christmas/from-glory.png'); ?>');-webkit-mask-size:100% 100%;mask-size:100% 100%;-webkit-mask-repeat:no-repeat;mask-repeat:no-repeat;"></span>
        </div>

        <!-- Decorative gold line -->
        <div class="flex items-center justify-center gap-3" data-aos="fade-up" data-aos-delay="340">
            <span class="block w-12 h-px bg-gold-400/30"></span>
            <span class="block w-1 h-1 rounded-full bg-gold-400/40"></span>
            <span class="block w-12 h-px bg-gold-400/30"></span>
        </div>

        <!-- Bible verse -->
        <blockquote class="space-y-2 -mx-6 md:-mx-10" data-aos="fade-up" data-aos-delay="420">
            <p class="text-sm italic text-stone-300/80 leading-relaxed">
                "Dan kita semua mencerminkan kemuliaan Tuhan dengan muka yang tidak berselubung. Dan karena kemuliaan
                itu datangnya dari Tuhan yang adalah Roh, maka kita diubah menjadi serupa dengan gambar-Nya, dalam
                kemuliaan yang semakin besar."
            </p>
            <cite class="block text-xs font-semibold text-gold-400/70 not-italic tracking-wide">
                — 2 Korintus 3:18 (TB)
            </cite>
        </blockquote>

        <!-- CTA Button -->
        <div class="pt-4" data-aos="fade-up" data-aos-delay="520">
            <a href="#sec-register"
                class="inline-block px-8 py-3 rounded-full bg-gold-500 hover:bg-gold-600 text-red-950 font-semibold text-sm tracking-wide transition-all duration-300 hover:shadow-lg hover:shadow-gold-500/25">
                Daftar Sekarang
            </a>
        </div>

    </div>

    <!-- Bottom decorative gradient fade -->
    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-red-950 to-transparent pointer-events-none">
    </div>

    <!-- Bottom decoration -->
    <div class="absolute bottom-0 left-0 right-0 pointer-events-none select-none" aria-hidden="true">
        <img src="<?php echo site_url('assets/images/christmas/desktop_bottom.webp'); ?>" alt=""
            class="block w-full h-auto">
    </div>

</div>

<style>
    .hero-stars {
        background-image:
            radial-gradient(1px 1px at 20% 30%, rgba(245, 158, 11, 0.4) 0%, transparent 100%),
            radial-gradient(1px 1px at 80% 20%, rgba(245, 158, 11, 0.3) 0%, transparent 100%),
            radial-gradient(1px 1px at 40% 70%, rgba(245, 158, 11, 0.25) 0%, transparent 100%),
            radial-gradient(1px 1px at 60% 50%, rgba(255, 255, 255, 0.15) 0%, transparent 100%),
            radial-gradient(1px 1px at 10% 80%, rgba(245, 158, 11, 0.2) 0%, transparent 100%),
            radial-gradient(1.5px 1.5px at 90% 60%, rgba(245, 158, 11, 0.3) 0%, transparent 100%),
            radial-gradient(1px 1px at 50% 10%, rgba(255, 255, 255, 0.2) 0%, transparent 100%),
            radial-gradient(1px 1px at 30% 90%, rgba(245, 158, 11, 0.15) 0%, transparent 100%),
            radial-gradient(1.5px 1.5px at 70% 85%, rgba(245, 158, 11, 0.25) 0%, transparent 100%),
            radial-gradient(1px 1px at 15% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
    }

    /* Sparkle sweep "From Glory to Glory" — kilau melintasi huruf emas tiap ~6 detik */
    .glory-shine {
        position: absolute;
        inset: -10% -30%;
        background: linear-gradient(115deg,
            transparent 42%,
            rgba(255, 255, 255, 0.55) 50%,
            rgba(255, 244, 214, 0.85) 52%,
            transparent 60%);
        transform: translateX(-120%);
        animation: gloryShine 6s ease-in-out infinite;
        pointer-events: none;
    }
    @keyframes gloryShine {
        0%   { transform: translateX(-120%); }
        55%  { transform: translateX(120%); }
        100% { transform: translateX(120%); }
    }

    /* Parallax: background & bintang bergerak subtle mengikuti kursor (desktop) */
    #hero-parallax-bg {
        transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        transform: scale(1.06);
        will-change: transform;
    }
    .hero-stars {
        transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        will-change: transform;
    }

    @media (prefers-reduced-motion: reduce) {
        .glory-shine { animation: none; display: none; }
        #hero-parallax-bg, .hero-stars { transition: none; }
    }
</style>

<script>
    (function () {
        /* Parallax mouse — hanya desktop dengan pointer presisi & motion diizinkan */
        if (!window.matchMedia) return;
        var mqDesktop = window.matchMedia('(min-width: 1024px) and (pointer: fine)');
        var mqReduce = window.matchMedia('(prefers-reduced-motion: reduce)');
        if (!mqDesktop.matches || mqReduce.matches) return;

        var panel = document.querySelector('.hero-desktop-panel');
        var bg = document.getElementById('hero-parallax-bg');
        var stars = document.querySelector('.hero-desktop-panel .hero-stars');
        if (!panel || !bg) return;

        var MAX = 5; /* px */
        var raf = null;

        panel.addEventListener('mousemove', function (e) {
            if (raf) return;
            raf = requestAnimationFrame(function () {
                raf = null;
                var r = panel.getBoundingClientRect();
                var x = (e.clientX - r.left) / r.width - 0.5;   /* -0.5 .. 0.5 */
                var y = (e.clientY - r.top) / r.height - 0.5;
                bg.style.transform = 'scale(1.06) translate(' + (-x * MAX).toFixed(2) + 'px,' + (-y * MAX).toFixed(2) + 'px)';
                if (stars) stars.style.transform = 'translate(' + (x * MAX * 1.6).toFixed(2) + 'px,' + (y * MAX * 1.6).toFixed(2) + 'px)';
            });
        });

        panel.addEventListener('mouseleave', function () {
            bg.style.transform = 'scale(1.06)';
            if (stars) stars.style.transform = '';
        });
    })();
</script>