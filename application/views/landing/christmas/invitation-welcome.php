<!-- Invitation Welcome / Personal Greeting -->
<?php if (!empty($booking)) : ?>
<section class="relative pt-16 pb-3 px-5 sm:px-8 overflow-hidden bg-red-950">
    <div class="relative z-10 max-w-md lg:max-w-lg mx-auto">
        <div class="text-center space-y-3" data-aos="fade-up">
            <p class="text-sm text-gold-400/90 font-medium tracking-wide">
                Selamat datang, 👋
            </p>
            <h1 class="text-lg sm:text-xl font-bold tracking-tight leading-snug bg-gradient-to-r from-gold-300 via-gold-400 to-gold-500 bg-clip-text text-transparent uppercase">
                <?php echo html_escape($booking->name); ?>
            </h1>
            <div class="flex items-center justify-center gap-3 pt-1">
                <span class="block w-10 h-px bg-gradient-to-r from-transparent via-gold-400/60 to-transparent"></span>
                <span class="block w-1.5 h-1.5 rounded-full bg-gold-400/60"></span>
                <span class="block w-10 h-px bg-gradient-to-r from-transparent via-gold-400/60 to-transparent"></span>
            </div>
            <p class="text-xs sm:text-sm text-stone-400 leading-relaxed max-w-xs mx-auto">
                Anda diundang secara khusus untuk menghadiri<br class="hidden sm:block">
                Perayaan Natal GPdI Kopo Permai.
            </p>
        </div>
    </div>
</section>
<?php endif; ?>
