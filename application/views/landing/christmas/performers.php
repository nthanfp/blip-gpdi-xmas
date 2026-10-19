<!-- Performers Section -->
<section class="relative py-14 sm:py-20 px-5 sm:px-8 overflow-hidden bg-red-950 -mt-px">
    <!-- Gradient bg (sedikit hangat di tengah) -->
    <div class="absolute inset-0 bg-gradient-to-b from-red-950 via-red-900/45 to-red-950"></div>
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

    <div class="relative z-10 max-w-md lg:max-w-lg mx-auto space-y-8">

        <!-- Header -->
        <div class="text-center space-y-4" data-aos="fade-up">
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

        <!-- Performer list (1 row per card) -->
        <div class="space-y-3">

            <?php
            $performers = [
                ['img' => 'gallery-1.webp', 'no' => '01', 'title' => 'Paduan Suara Narwastu'],
                ['img' => 'gallery-2.webp', 'no' => '02', 'title' => 'Teens Choir'],
                ['img' => 'gallery-3.webp', 'no' => '03', 'title' => 'Drama'],
                ['img' => 'gallery-4.webp', 'no' => '04', 'title' => 'Tamborin'],
            ];
            foreach ($performers as $i => $p):
                $isRev   = ($i % 2 === 1);
                $reverse = $isRev ? 'flex-row-reverse' : '';
                $textCls = $isRev ? 'text-right pl-12' : 'text-left pr-12';
                $numPos  = $isRev ? 'left-3' : 'right-3';
                $aos     = $isRev ? 'fade-left' : 'fade-right';
                ?>

            <!-- <?php echo $p['title']; ?> -->
            <div class="group relative flex items-center gap-4 <?php echo $reverse; ?> rounded-2xl bg-white/10 hover:bg-white/[0.14] border border-white/10 hover:border-gold-400/40 backdrop-blur-sm p-3.5 transition-all duration-300"
                 data-aos="<?php echo $aos; ?>" data-aos-delay="<?php echo $i * 80; ?>">

                <!-- Foto (landscape 4:3) -->
                <div class="w-36 h-28 rounded-xl overflow-hidden ring-1 ring-white/20 shrink-0">
                    <img src="<?php echo site_url('assets/images/christmas/' . $p['img']); ?>" alt="<?php echo $p['title']; ?>"
                         loading="lazy"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                </div>

                <!-- Nama performer -->
                <div class="flex-1 min-w-0 flex items-center <?php echo $textCls; ?>">
                    <p class="text-xl font-extrabold tracking-tight leading-tight min-w-0 bg-gradient-to-r from-gold-300 to-gold-500 bg-clip-text text-transparent"><?php echo $p['title']; ?></p>
                </div>

                <!-- Nomor urut -->
                <span class="absolute top-1/2 -translate-y-1/2 <?php echo $numPos; ?> text-3xl font-black text-white/[0.18] leading-none pointer-events-none"><?php echo $p['no']; ?></span>

            </div>

            <?php endforeach; ?>

        </div>

    </div>
</section>
