<!DOCTYPE html>
<html lang="id">

<head>
    <?php $this->load->view('partial/landing/head.php') ?>
</head>

<body class="bg-red-950 text-stone-200 antialiased">

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
                <?php $this->load->view('landing/christmas/welcome') ?>

                <!-- Countdown -->
                <?php $this->load->view('landing/christmas/countdown') ?>

                <!-- Event Details -->
                <?php $this->load->view('landing/christmas/event-details') ?>

                <!-- Registration Form -->
                <?php $this->load->view('landing/christmas/registration-form') ?>

                <!-- Speaker -->
                <?php $this->load->view('landing/christmas/speaker') ?>

                <!-- Performers -->
                <?php $this->load->view('landing/christmas/performers') ?>

                <!-- Gallery -->
                <?php $this->load->view('landing/christmas/gallery') ?>

                <!-- FAQ -->
                <?php $this->load->view('landing/christmas/faq') ?>

                <!-- Contact -->
                <?php $this->load->view('landing/christmas/contact') ?>

                <!-- Footer -->
                <?php $this->load->view('landing/christmas/footer') ?>

            </div>

    </div>

    <?php $this->load->view('partial/landing/foot.php') ?>
</body>

</html>
