<!-- Gallery Section -->
<section class="relative py-14 sm:py-20 px-5 sm:px-8 overflow-hidden bg-red-950 -mt-px">
    <!-- Dot texture -->
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #f5edd6 1px, transparent 1px); background-size: 24px 24px;"></div>
    <!-- Radial gold glow -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(212,175,55,0.08)_0%,_transparent_60%)]"></div>

    <!-- Top fade from performers -->
    <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-b from-red-950 via-red-950/80 to-transparent pointer-events-none z-10"></div>
    <!-- Bottom fade to FAQ -->
    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-red-950 via-red-950/80 to-transparent pointer-events-none z-10"></div>

    <div class="relative z-10 max-w-md lg:max-w-lg mx-auto space-y-6">

        <!-- Header -->
        <div class="text-center space-y-4" data-aos="fade-up">
            <p class="text-[11px] font-semibold tracking-[0.25em] uppercase text-gold-400">
                Throwback
            </p>
            <div class="flex items-center justify-center gap-3">
                <span class="block w-10 h-px bg-gradient-to-r from-transparent via-gold-400/60 to-transparent"></span>
                <span class="block w-1.5 h-1.5 rounded-full bg-gold-400/60"></span>
                <span class="block w-10 h-px bg-gradient-to-r from-transparent via-gold-400/60 to-transparent"></span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold text-white leading-snug">
                Dokumentasi Natal 2025
            </h2>
        </div>

        <!-- Slider Wrapper -->
        <div class="relative group" data-aos="fade-right" data-aos-delay="120">

            <!-- Track -->
            <div id="gallery-track" class="flex gap-3 sm:gap-4 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-4 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                
                <?php 
                $total_photos = 12;
                for ($i = 1; $i <= $total_photos; $i++): 
                    $img_url = site_url('assets/images/christmas/gallery-' . $i . '.webp');
                ?>
                <div class="gallery-slide snap-center shrink-0 w-[82%] sm:w-[85%] relative rounded-2xl overflow-hidden border border-white/10 shadow-lg aspect-[4/3] bg-red-900/40" data-gallery-index="<?php echo $i - 1; ?>">
                    <img src="<?php echo $img_url; ?>" alt="Dokumentasi Natal 2025 - <?php echo $i; ?>" loading="lazy"
                         class="w-full h-full object-cover">
                    <!-- Overlay gradient tipis untuk keterbacaan indikator angka -->
                    <div class="absolute inset-0 bg-gradient-to-t from-red-950/60 via-transparent to-transparent opacity-80 pointer-events-none"></div>
                    <!-- Hanya indikator angka (tanpa teks caption) -->
                    <div class="absolute bottom-3 right-4 flex items-center justify-end text-xs text-white/90">
                        <span class="text-[10px] text-gold-400 font-semibold bg-red-950/40 px-2 py-0.5 rounded-full backdrop-blur-sm border border-gold-400/20">
                            <?php echo $i . '/' . $total_photos; ?>
                        </span>
                    </div>
                </div>
                <?php endfor; ?>

            </div>

            <!-- Prev / Next Navigation Buttons -->
            <button type="button" id="gallery-prev" 
                    class="absolute left-2 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-red-950/80 border border-gold-400/40 text-gold-400 flex items-center justify-center shadow-lg backdrop-blur-sm opacity-90 sm:opacity-0 group-hover:opacity-100 transition-opacity duration-200 focus:outline-none hover:bg-gold-500 hover:text-red-950">
                <i class="fas fa-chevron-left text-xs"></i>
            </button>
            <button type="button" id="gallery-next" 
                    class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-red-950/80 border border-gold-400/40 text-gold-400 flex items-center justify-center shadow-lg backdrop-blur-sm opacity-90 sm:opacity-0 group-hover:opacity-100 transition-opacity duration-200 focus:outline-none hover:bg-gold-500 hover:text-red-950">
                <i class="fas fa-chevron-right text-xs"></i>
            </button>

        </div>

    </div>
</section>

<!-- Lightbox Overlay (DISABLED — aktifkan lagi dengan meremove atribut hidden & flag LB_ENABLED) -->
<div id="gallery-lightbox" class="fixed inset-0 z-[9999] bg-black/90 backdrop-blur-sm hidden items-center justify-center p-4">
    <!-- Close -->
    <button type="button" id="lb-close"
            class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 text-white flex items-center justify-center transition-colors duration-200 focus:outline-none">
        <i class="fas fa-times"></i>
    </button>

    <!-- Prev -->
    <button type="button" id="lb-prev"
            class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/10 hover:bg-gold-500 hover:text-red-950 border border-white/20 text-white flex items-center justify-center transition-colors duration-200 focus:outline-none">
        <i class="fas fa-chevron-left"></i>
    </button>

    <!-- Image -->
    <figure class="max-w-4xl w-full text-center">
        <img id="lb-img" src="" alt="Dokumentasi Natal 2025"
             class="max-h-[80vh] w-auto mx-auto rounded-xl shadow-2xl select-none">
        <figcaption id="lb-counter" class="mt-3 text-xs text-gold-400 font-semibold tracking-widest"></figcaption>
    </figure>

    <!-- Next -->
    <button type="button" id="lb-next"
            class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/10 hover:bg-gold-500 hover:text-red-950 border border-white/20 text-white flex items-center justify-center transition-colors duration-200 focus:outline-none">
        <i class="fas fa-chevron-right"></i>
    </button>
</div>

<style>
    #gallery-lightbox { transition: opacity 0.25s ease; }
    #gallery-lightbox.lb-open { opacity: 1; }
    #gallery-lightbox.lb-closing { opacity: 0; }
    #lb-img { animation: lbZoom 0.25s ease-out; }
    @keyframes lbZoom {
        from { transform: scale(0.94); opacity: 0; }
        to   { transform: scale(1); opacity: 1; }
    }
    @media (prefers-reduced-motion: reduce) {
        #gallery-lightbox, #lb-img { transition: none; animation: none; }
    }
</style>

<script>
(function () {
    var track = document.getElementById('gallery-track');
    var prev = document.getElementById('gallery-prev');
    var next = document.getElementById('gallery-next');
    var TOTAL = 12;

    /* ---- Slider arrows ---- */
    if (track && prev && next) {
        prev.addEventListener('click', function () {
            var slideWidth = track.querySelector('.gallery-slide').offsetWidth + 16;
            track.scrollBy({ left: -slideWidth, behavior: 'smooth' });
        });
        next.addEventListener('click', function () {
            var slideWidth = track.querySelector('.gallery-slide').offsetWidth + 16;
            track.scrollBy({ left: slideWidth, behavior: 'smooth' });
        });
    }

    /* ---- Lightbox (SUDAH DIHIDE — set true untuk mengaktifkan kembali) ---- */
    var LB_ENABLED = false;
    var lb = document.getElementById('gallery-lightbox');
    var lbImg = document.getElementById('lb-img');
    var lbCounter = document.getElementById('lb-counter');
    var lbClose = document.getElementById('lb-close');
    var lbPrev = document.getElementById('lb-prev');
    var lbNext = document.getElementById('lb-next');
    if (!lb || !lbImg) return;

    var current = 0;
    var base = <?php echo json_encode(site_url('assets/images/christmas/gallery-')); ?>;

    function srcFor(i) { return base + (i + 1) + '.webp'; }

    function render() {
        lbImg.src = srcFor(current);
        lbImg.style.animation = 'none';
        void lbImg.offsetWidth; /* restart animation */
        lbImg.style.animation = '';
        lbCounter.textContent = (current + 1) + ' / ' + TOTAL;
    }

    function open(i) {
        current = i;
        render();
        lb.classList.remove('hidden', 'lb-closing');
        lb.classList.add('flex');
        requestAnimationFrame(function () { lb.classList.add('lb-open'); });
        document.body.style.overflow = 'hidden';
    }

    function close() {
        lb.classList.add('lb-closing');
        lb.classList.remove('lb-open');
        document.body.style.overflow = '';
        setTimeout(function () {
            lb.classList.add('hidden');
            lb.classList.remove('flex', 'lb-closing');
        }, 250);
    }

    function go(step) {
        current = (current + step + TOTAL) % TOTAL;
        render();
    }

    /* Open on slide click */
    if (LB_ENABLED) {
        document.querySelectorAll('.gallery-slide').forEach(function (slide) {
            slide.addEventListener('click', function () {
                open(parseInt(slide.getAttribute('data-gallery-index'), 10) || 0);
            });
        });
    }

    lbClose.addEventListener('click', close);
    lbPrev.addEventListener('click', function () { go(-1); });
    lbNext.addEventListener('click', function () { go(1); });

    /* Backdrop click (close only when clicking overlay itself) */
    lb.addEventListener('click', function (e) {
        if (e.target === lb) close();
    });

    /* Keyboard */
    document.addEventListener('keydown', function (e) {
        if (lb.classList.contains('hidden')) return;
        if (e.key === 'Escape') close();
        else if (e.key === 'ArrowLeft') go(-1);
        else if (e.key === 'ArrowRight') go(1);
    });

    /* Swipe (touch) */
    var startX = null;
    lb.addEventListener('touchstart', function (e) {
        startX = e.changedTouches[0].clientX;
    }, { passive: true });
    lb.addEventListener('touchend', function (e) {
        if (startX === null) return;
        var dx = e.changedTouches[0].clientX - startX;
        if (Math.abs(dx) > 50) go(dx < 0 ? 1 : -1);
        startX = null;
    }, { passive: true });
})();
</script>