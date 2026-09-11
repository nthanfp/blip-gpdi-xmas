<!DOCTYPE html>
<html lang="id">

<head>
    <?php $this->load->view('partial/landing/head.php') ?>
</head>

<body class="bg-stone-50 text-stone-800 antialiased">

    <!-- ═══ DESKTOP: Split-screen ═══ -->
    <div class="lg:flex">

        <!-- LEFT HERO: sticky panel (desktop only) -->
        <div class="hidden lg:block lg:w-5/12 shrink-0 sticky top-0 h-screen bg-red-950 overflow-hidden">
            <?php $this->load->view('landing/christmas/hero') ?>
        </div>

        <!-- RIGHT CONTENT: normal document scroll -->
        <div class="w-full lg:w-7/12">

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
        /* IntersectionObserver — fade-in on scroll */
        var items = document.querySelectorAll('.fi');
        if ('IntersectionObserver' in window) {
            var obs = new IntersectionObserver(function (entries) {
                entries.forEach(function (e) {
                    if (e.isIntersecting) {
                        e.target.classList.add('fi-visible');
                        obs.unobserve(e.target);
                    }
                });
            }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
            items.forEach(function (el) { obs.observe(el); });
        } else {
            /* Fallback: show all */
            items.forEach(function (el) { el.classList.add('fi-visible'); });
        }
    })();
    </script>
</body>

</html>
