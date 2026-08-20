<!DOCTYPE html>
<html lang="id">

<head>
    <?php $this->load->view('partial/landing/head.php') ?>

    <style type="text/css">
        html, body {
            height: 100dvh;
            overflow: hidden;
        }

        body {
            font-family: 'Inter', sans-serif;

            background:
                linear-gradient(to bottom,
                    rgba(0, 0, 0, 0.28),
                    rgba(0, 0, 0, 0.12)),

                linear-gradient(180deg,
                    rgba(115, 10, 19, 0.90) 0%,
                    rgba(136, 19, 21, 0.72) 38%,
                    rgba(95, 10, 16, 0.78) 68%,
                    rgba(45, 2, 8, 0.90) 100%),

                url("<?php echo base_url('assets/images/bg-activities.jpeg'); ?>");

            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            background-attachment: scroll;
        }
    </style>
</head>

<body class="bg-light flex justify-center">
    <div class="w-full relative overflow-hidden shadow-2xl" style="height:100dvh">

        <!-- Main Content -->
        <div class="shadow-2xl relative flex flex-col justify-center items-center px-5" style="height:100dvh" id="main-content">
            <!-- Glass Card --> 
            <div class="w-full max-w-sm bg-white/10 backdrop-blur-xl border border-white/10 ring-1 ring-white/10 rounded-2xl pt-6 pb-5 px-6 shadow-xl text-center">
                <!-- Icon -->
                <div class="w-16 h-16 mx-auto mb-3 rounded-3xl bg-gradient-to-br from-primary to-redlux-dark border border-white/10 flex items-center justify-center shadow-lg shadow-red-900/30">
                    <i class="fas fa-gem text-3xl text-white/90"></i>
                </div>

                <!-- Title -->
                <h1 class="font-serif text-3xl font-bold text-white mb-2 drop-shadow-[0_2px_12px_rgba(0,0,0,0.28)]">
                    <span class="font-serif-italic text-redlux-light">Coming</span> Soon
                </h1>

                <!-- Subtitle -->
                <p class="text-sm text-red-100/80 leading-relaxed mb-4 max-w-xs mx-auto">
                    Kami sedang menyiapkan sesuatu yang spesial untukmu. Nantikan kejutan dari produk ILLUSIONS.
                </p>

                <!-- Divider -->
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex-1 h-px bg-white/10"></div>
                    <span class="text-[10px] tracking-[3px] text-white/50 font-semibold">
                        ILLUSIONS
                    </span>
                    <div class="flex-1 h-px bg-white/10"></div>
                </div>

                <!-- Decorative dots -->
                <div class="flex justify-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-white/20"></span>
                    <span class="w-2 h-2 rounded-full bg-white/30"></span>
                    <span class="w-2 h-2 rounded-full bg-white/20"></span>
                </div>
            </div>
        </div>

    </div>

    <!-- Foot Js -->
    <?php $this->load->view('partial/landing/foot.php') ?>

    <!-- GSAP -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/gsap.min.js"></script>

    <script>
        gsap.fromTo('#main-content', {
            opacity: 0,
            y: 30
        }, {
            opacity: 1,
            y: 0,
            duration: 0.6,
            ease: 'power2.out'
        });
    </script>
</body>

</html>