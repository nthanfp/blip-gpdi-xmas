<!DOCTYPE html>
<html lang="id">

<head>
    <?php $this->load->view('partial/landing/head.php') ?>
</head>

<body class="bg-stone-50 text-stone-800 antialiased">

    <!-- ═══ DESKTOP: Split-screen — left fixed, right scrolls ═══ -->
    <div class="lg:flex lg:h-screen">

        <!-- LEFT HERO: fixed panel (desktop only) — 60% -->
        <div class="hidden lg:block lg:w-3/5 shrink-0 lg:h-screen bg-red-950 overflow-hidden">
            <?php $this->load->view('landing/christmas/hero') ?>
        </div>

        <!-- RIGHT CONTENT: independent scroll on desktop, page scroll on mobile — 40% -->
        <div class="w-full lg:w-2/5 lg:h-screen lg:overflow-y-auto xmas-scroll">

                <!-- Mobile Hero -->
                <?php $this->load->view('landing/christmas/hero-mobile') ?>

                <!-- Welcome -->
                <div class="fi fi-delay-1">
                    <?php $this->load->view('landing/christmas/welcome') ?>
                </div>

                <!-- Countdown -->
                <div class="fi fi-delay-2">
                    <?php $this->load->view('landing/christmas/countdown') ?>
                </div>

                <!-- Event Details -->
                <div class="fi fi-delay-1">
                    <?php $this->load->view('landing/christmas/event-details') ?>
                </div>

                <!-- Registration Form -->
                <div class="fi fi-delay-2">
                    <?php $this->load->view('landing/christmas/registration-form') ?>
                </div>

                <!-- Speaker -->
                <div class="fi fi-delay-1">
                    <?php $this->load->view('landing/christmas/speaker') ?>
                </div>

                <!-- Performers -->
                <div class="fi fi-delay-2">
                    <?php $this->load->view('landing/christmas/performers') ?>
                </div>

                <!-- Gallery -->
                <div class="fi fi-delay-1">
                    <?php $this->load->view('landing/christmas/gallery') ?>
                </div>

                <!-- FAQ -->
                <div class="fi fi-delay-1">
                    <?php $this->load->view('landing/christmas/faq') ?>
                </div>

                <!-- Contact -->
                <div class="fi fi-delay-2">
                    <?php $this->load->view('landing/christmas/contact') ?>
                </div>

                <!-- Footer -->
                <?php $this->load->view('landing/christmas/footer') ?>

            </div>

    </div>

    <?php $this->load->view('partial/landing/foot.php') ?>

    <script>
    (function () {
        var items = document.querySelectorAll('.fi');
        if ('IntersectionObserver' in window) {
            /* Desktop: root = scrollable right panel. Mobile: root = viewport */
            var root = null;
            var scrollEl = document.querySelector('.xmas-scroll');
            if (window.matchMedia('(min-width: 1024px)').matches && scrollEl) {
                root = scrollEl;
            }
            var obs = new IntersectionObserver(function (entries) {
                entries.forEach(function (e) {
                    if (e.isIntersecting) {
                        e.target.classList.add('fi-visible');
                        obs.unobserve(e.target);
                    }
                });
            }, { root: root, threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
            items.forEach(function (el) { obs.observe(el); });
        } else {
            items.forEach(function (el) { el.classList.add('fi-visible'); });
        }
    })();
    </script>
</body>

</html>
