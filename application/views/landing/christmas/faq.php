<!-- FAQ Section -->
<?php $faqs = isset($faqs) && is_array($faqs) ? $faqs : []; ?>
<?php if (!empty($faqs)) : ?>
<section class="relative py-14 sm:py-20 px-5 sm:px-8 overflow-hidden -mt-px bg-red-950">
    <!-- Gradient bg -->
    <div class="absolute inset-0 bg-gradient-to-b from-red-900/70 via-red-950 to-red-950"></div>
    <!-- Dot texture -->
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #f5edd6 1px, transparent 1px); background-size: 24px 24px;"></div>
    <!-- Radial gold glow -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(212,175,55,0.06)_0%,_transparent_60%)]"></div>

    <!-- Top fade from gallery (red-900/70) -->
    <div class="absolute top-0 left-0 right-0 h-24 bg-gradient-to-b from-red-900/70 via-red-900/50 to-transparent pointer-events-none z-10"></div>
    <!-- Bottom fade to registration -->
    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-red-950 via-red-950/80 to-transparent pointer-events-none z-10"></div>

    <div class="relative z-10 max-w-md lg:max-w-lg mx-auto space-y-8">

        <!-- Header -->
        <div class="text-center space-y-4" data-aos="fade-up">
            <p class="text-[11px] font-semibold tracking-[0.25em] uppercase text-gold-400">
                FAQ
            </p>
            <div class="flex items-center justify-center gap-3">
                <span class="block w-8 h-px bg-gold-400/50"></span>
                <span class="block w-1.5 h-1.5 rounded-full bg-gold-400/60"></span>
                <span class="block w-8 h-px bg-gold-400/50"></span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold text-white leading-snug">
                Pertanyaan Umum
            </h2>
        </div>

        <!-- Accordion (dari database: set_faq) -->
        <div class="space-y-2" id="faq-list">

            <?php foreach ($faqs as $i => $faq): ?>
            <div class="faq-item card-hover bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="<?php echo (int) $i * 70; ?>">
                <button type="button"
                        class="faq-toggle w-full flex items-center justify-between gap-3 px-5 py-4 text-left">
                    <span class="text-sm font-semibold text-white"><?php echo html_escape($faq->question); ?></span>
                    <i class="fas fa-chevron-down text-stone-400 text-xs shrink-0 transition-transform duration-200"></i>
                </button>
                <div class="faq-answer hidden px-5 pb-4">
                    <p class="text-xs text-stone-300 leading-relaxed">
                        <?php echo html_escape($faq->answer); ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>

        </div>

    </div>
</section>
<?php endif; ?>

<script>
(function () {
    var toggles = document.querySelectorAll('.faq-toggle');

    toggles.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var item = this.closest('.faq-item');
            var answer = item.querySelector('.faq-answer');
            var icon = this.querySelector('i');
            var isOpen = !answer.classList.contains('hidden');

            /* Close all others */
            document.querySelectorAll('.faq-answer').forEach(function (a) {
                a.classList.add('hidden');
            });
            document.querySelectorAll('.faq-toggle i').forEach(function (i) {
                i.classList.remove('rotate-180');
            });

            /* Toggle current */
            if (!isOpen) {
                answer.classList.remove('hidden');
                icon.classList.add('rotate-180');
            }
        });
    });
})();
</script>
