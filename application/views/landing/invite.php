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
