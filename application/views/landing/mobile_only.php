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

        .phone-outline {
            width: 56px;
            height: 56px;
            border: 3px solid rgba(255, 255, 255, 0.25);
            border-radius: 12px;
            position: relative;
            margin: 0 auto;
        }

        .phone-outline::before {
            content: '';
            position: absolute;
            top: 6px;
            left: 50%;
            transform: translateX(-50%);
            width: 18px;
            height: 3px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }

        .phone-outline::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            width: 8px;
            height: 8px;
            border: 2px solid rgba(255, 255, 255, 0.15);
            border-radius: 50%;
        }

        .phone-screen {
            position: absolute;
            top: 13px;
            left: 5px;
            right: 5px;
            bottom: 17px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .phone-screen i {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.3);
        }

        .scan-lines {
            position: absolute;
            inset: 0;
            overflow: hidden;
            border-radius: inherit;
            pointer-events: none;
        }

        .scan-lines::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -25%;
            width: 150%;
            height: 200%;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(255, 255, 255, 0.015) 2px,
                rgba(255, 255, 255, 0.015) 4px
            );
            transform: rotate(-15deg);
        }
    </style>
</head>

<body class="bg-light flex justify-center">
    <div class="w-full relative overflow-hidden shadow-2xl" style="height:100dvh">

        <!-- Main Content -->
        <div class="shadow-2xl relative flex flex-col justify-center items-center px-5" style="height:100dvh" id="main-content">
            <!-- Glass Card --> 
            <div class="w-full max-w-sm bg-white/10 backdrop-blur-xl border border-white/10 ring-1 ring-white/10 rounded-2xl pt-6 pb-5 px-6 shadow-xl text-center">
                <!-- Icon: Phone outline -->
                <div class="mb-3 flex items-center justify-center">
                    <div class="phone-outline">
                        <div class="phone-screen">
                            <i class="fas fa-times"></i>
                        </div>
                        <div class="scan-lines"></div>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="font-serif text-3xl font-bold text-white mb-2 drop-shadow-[0_2px_12px_rgba(0,0,0,0.28)]">
                    <span class="font-serif-italic text-redlux-light">Mobile</span> Only
                </h1>

                <!-- Subtitle -->
                <p class="text-sm text-red-100/80 leading-relaxed mb-4 max-w-xs mx-auto">
                    Halaman ini hanya dapat diakses melalui perangkat mobile. Silakan buka link ini dari smartphone Anda.
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
