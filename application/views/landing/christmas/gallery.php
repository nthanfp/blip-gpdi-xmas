<!-- Gallery Section -->
<section class="relative py-20 sm:py-28 px-5 sm:px-8 overflow-hidden bg-red-950 -mt-px">
    <!-- Dot texture -->
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #f5edd6 1px, transparent 1px); background-size: 24px 24px;"></div>
    <!-- Radial gold glow -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(212,175,55,0.08)_0%,_transparent_60%)]"></div>

    <!-- Top fade from performers -->
    <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-b from-red-950 via-red-950/80 to-transparent pointer-events-none z-10"></div>
    <!-- Bottom fade to FAQ -->
    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-stone-50 via-stone-50/80 to-transparent pointer-events-none z-10"></div>

    <div class="relative z-10 max-w-md lg:max-w-lg mx-auto space-y-6 pt-10 pb-10">

        <!-- Header -->
        <div class="text-center space-y-4">
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
        <div class="relative group">

            <!-- Track -->
            <div id="gallery-track" class="flex gap-3 sm:gap-4 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-4 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                
                <?php 
                $photos = [
                    ['url' => 'https://picsum.photos/600/400?random=101', 'caption' => 'Ibadah Natal 2025'],
                    ['url' => 'https://picsum.photos/600/400?random=102', 'caption' => 'Perayaan Sukacita'],
                    ['url' => 'https://picsum.photos/600/400?random=103', 'caption' => 'Paduan Suara Natal'],
                    ['url' => 'https://picsum.photos/600/400?random=104', 'caption' => 'Penyalaan Lilin'],
                    ['url' => 'https://picsum.photos/600/400?random=105', 'caption' => 'Penampilan Spesial Anak'],
                    ['url' => 'https://picsum.photos/600/400?random=106', 'caption' => 'Tim Musik & Praise'],
                    ['url' => 'https://picsum.photos/600/400?random=107', 'caption' => 'Kebersamaan Jemaat'],
                    ['url' => 'https://picsum.photos/600/400?random=108', 'caption' => 'Drama Natal'],
                    ['url' => 'https://picsum.photos/600/400?random=109', 'caption' => 'Pemberitaan Firman'],
                    ['url' => 'https://picsum.photos/600/400?random=110', 'caption' => 'Ramah Tamah'],
                    ['url' => 'https://picsum.photos/600/400?random=111', 'caption' => 'Foto Bersama Pelayan'],
                    ['url' => 'https://picsum.photos/600/400?random=112', 'caption' => 'Sesi Foto Jemaat'],
                ];
                foreach ($photos as $i => $photo): 
                ?>
                <div class="gallery-slide snap-center shrink-0 w-[82%] sm:w-[85%] relative rounded-2xl overflow-hidden border border-white/10 shadow-lg aspect-[4/3] bg-red-900/40">
                    <img src="<?php echo $photo['url']; ?>" alt="<?php echo $photo['caption']; ?>" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-red-950/90 via-transparent to-transparent opacity-80"></div>
                    <div class="absolute bottom-3 left-4 right-4 flex items-center justify-between text-xs text-white/90">
                        <span class="font-medium tracking-wide"><?php echo $photo['caption']; ?></span>
                        <span class="text-[10px] text-gold-400 font-semibold"><?php echo ($i + 1) . '/' . count($photos); ?></span>
                    </div>
                </div>
                <?php endforeach; ?>

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

<script>
(function () {
    var track = document.getElementById('gallery-track');
    var prev = document.getElementById('gallery-prev');
    var next = document.getElementById('gallery-next');

    if (!track || !prev || !next) return;

    prev.addEventListener('click', function () {
        var slideWidth = track.querySelector('.gallery-slide').offsetWidth + 16;
        track.scrollBy({ left: -slideWidth, behavior: 'smooth' });
    });

    next.addEventListener('click', function () {
        var slideWidth = track.querySelector('.gallery-slide').offsetWidth + 16;
        track.scrollBy({ left: slideWidth, behavior: 'smooth' });
    });
})();
</script>