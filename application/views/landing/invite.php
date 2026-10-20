<!DOCTYPE html>
<html lang="id">

<head>
    <?php $this->load->view('partial/landing/head.php') ?>
</head>

<body class="bg-red-950 text-stone-200 antialiased">

    <!-- ═══ Snowfall (pure CSS, halus & subtle) ═══ -->
    <div class="xmas-snow" aria-hidden="true">
        <span style="left:4%;  width:4px; height:4px; background:rgba(245,237,214,.8);  animation-duration:12s; animation-delay:-2s;  --drift:25px;"></span>
        <span style="left:11%; width:3px; height:3px; background:rgba(212,175,55,.75); animation-duration:16s; animation-delay:-8s;  --drift:-30px;"></span>
        <span style="left:18%; width:5px; height:5px; background:rgba(245,237,214,.6);  animation-duration:14s; animation-delay:-14s; --drift:20px;"></span>
        <span style="left:26%; width:3px; height:3px; background:rgba(245,237,214,.75); animation-duration:18s; animation-delay:-5s;  --drift:-18px;"></span>
        <span style="left:33%; width:4px; height:4px; background:rgba(212,175,55,.7);  animation-duration:11s; animation-delay:-11s; --drift:28px;"></span>
        <span style="left:41%; width:3px; height:3px; background:rgba(245,237,214,.7);  animation-duration:15s; animation-delay:-1s;  --drift:-24px;"></span>
        <span style="left:48%; width:5px; height:5px; background:rgba(245,237,214,.55); animation-duration:13s; animation-delay:-16s; --drift:15px;"></span>
        <span style="left:55%; width:3px; height:3px; background:rgba(212,175,55,.8);  animation-duration:17s; animation-delay:-7s;  --drift:-22px;"></span>
        <span style="left:62%; width:4px; height:4px; background:rgba(245,237,214,.75); animation-duration:12s; animation-delay:-13s; --drift:30px;"></span>
        <span style="left:69%; width:3px; height:3px; background:rgba(245,237,214,.65); animation-duration:19s; animation-delay:-3s;  --drift:-16px;"></span>
        <span style="left:76%; width:5px; height:5px; background:rgba(212,175,55,.6);  animation-duration:14s; animation-delay:-18s; --drift:22px;"></span>
        <span style="left:83%; width:3px; height:3px; background:rgba(245,237,214,.85); animation-duration:10s; animation-delay:-9s;  --drift:-27px;"></span>
        <span style="left:90%; width:4px; height:4px; background:rgba(245,237,214,.7);  animation-duration:20s; animation-delay:-4s;  --drift:18px;"></span>
        <span style="left:96%; width:3px; height:3px; background:rgba(212,175,55,.75); animation-duration:13s; animation-delay:-12s; --drift:-20px;"></span>
        <span style="left:8%;  width:3px; height:3px; background:rgba(245,237,214,.6);  animation-duration:21s; animation-delay:-20s; --drift:12px;"></span>
        <span style="left:52%; width:4px; height:4px; background:rgba(245,237,214,.7);  animation-duration:12s; animation-delay:-6s;  --drift:-25px;"></span>
        <span style="left:72%; width:3px; height:3px; background:rgba(245,237,214,.75); animation-duration:16s; animation-delay:-15s; --drift:26px;"></span>
        <span style="left:37%; width:3px; height:3px; background:rgba(212,175,55,.65); animation-duration:15s; animation-delay:-10s; --drift:-14px;"></span>
        <span style="left:15%; width:4px; height:4px; background:rgba(245,237,214,.7);  animation-duration:14s; animation-delay:-17s; --drift:23px;"></span>
        <span style="left:59%; width:3px; height:3px; background:rgba(212,175,55,.7);  animation-duration:18s; animation-delay:-9s;  --drift:-19px;"></span>
        <span style="left:87%; width:4px; height:4px; background:rgba(245,237,214,.65); animation-duration:12s; animation-delay:-3s;  --drift:21px;"></span>
        <span style="left:44%; width:3px; height:3px; background:rgba(245,237,214,.8);  animation-duration:17s; animation-delay:-19s; --drift:-26px;"></span>
    </div>
    <style>
        .xmas-snow {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 30;
            overflow: hidden;
        }
        .xmas-snow span {
            position: absolute;
            top: -8px;
            border-radius: 50%;
            animation-name: xmasSnowfall;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
        }
        @keyframes xmasSnowfall {
            0%   { transform: translateY(-2vh) translateX(0); opacity: 0; }
            8%   { opacity: 1; }
            92%  { opacity: 1; }
            100% { transform: translateY(105vh) translateX(var(--drift, 20px)); opacity: 0; }
        }
        @media (prefers-reduced-motion: reduce) {
            .xmas-snow { display: none; }
        }
    </style>

    <!-- ═══ Decorative floating frames (top & bottom) — hanya mobile, layar besar tidak dipasang ═══ -->
    <img src="<?php echo site_url('assets/images/christmas/frame-top.png'); ?>" alt=""
         aria-hidden="true"
         class="fixed top-0 left-0 w-full lg:hidden pointer-events-none select-none z-40">
    <img src="<?php echo site_url('assets/images/christmas/frame_bottom.png'); ?>" alt=""
         aria-hidden="true"
         class="fixed bottom-0 left-0 w-full lg:hidden pointer-events-none select-none z-40">

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

                <!-- Speaker -->
                <?php $this->load->view('landing/christmas/speaker') ?>

                <!-- Performers -->
                <?php $this->load->view('landing/christmas/performers') ?>

                <!-- Gallery -->
                <?php $this->load->view('landing/christmas/gallery') ?>

                <!-- FAQ -->
                <?php $this->load->view('landing/christmas/faq') ?>

                <!-- Registration Form -->
                <?php $this->load->view('landing/christmas/registration-form') ?>

                <!-- Contact -->
                <?php $this->load->view('landing/christmas/contact') ?>

                <!-- Footer -->
                <?php $this->load->view('landing/christmas/footer') ?>

            </div>

    </div>

    <?php $this->load->view('partial/landing/foot.php') ?>

    <!-- ═══ Music player (autoplay on first interaction + toggle) ═══ -->
    <audio id="xmas-audio" loop preload="auto">
        <source src="<?php echo site_url('assets/audio/christmas.mp3'); ?>" type="audio/mpeg">
    </audio>
    <button type="button" id="xmas-music-btn" aria-label="Putar atau jeda musik"
            class="fixed bottom-20 right-5 z-50 w-12 h-12 rounded-full bg-gold-500/90 hover:bg-gold-400 text-red-950 shadow-lg shadow-gold-500/30 flex items-center justify-center transition-all duration-300 active:scale-95 focus:outline-none focus:ring-2 focus:ring-gold-400 focus:ring-offset-2 focus:ring-offset-red-950">
        <i class="fas fa-music text-sm" id="xmas-music-icon"></i>
    </button>
    <script>
        (function () {
            var audio = document.getElementById('xmas-audio');
            var icon = document.getElementById('xmas-music-icon');
            var started = false;
            var FADE_MS = 1500;
            var fadeTimer = null;

            function renderIcon(playing) {
                if (playing) {
                    icon.classList.remove('fa-play');
                    icon.classList.add('fa-music', 'animate-pulse');
                } else {
                    icon.classList.remove('fa-music', 'animate-pulse');
                    icon.classList.add('fa-play');
                }
            }

            function fadeIn() {
                clearInterval(fadeTimer);
                var target = 0.7;
                audio.volume = 0;
                fadeTimer = setInterval(function () {
                    audio.volume = Math.min(target, audio.volume + target / (FADE_MS / 50));
                    if (audio.volume >= target) clearInterval(fadeTimer);
                }, 50);
            }

            function play() {
                fadeIn();
                audio.play().then(function () {
                    started = true;
                    renderIcon(true);
                }).catch(function () {
                    clearInterval(fadeTimer);
                    started = false;
                    renderIcon(false);
                });
            }

            function pause() {
                clearInterval(fadeTimer);
                audio.pause();
                renderIcon(false);
            }

            /* Interaksi pertama (klik/scroll/tap/key) → musik mulai */
            var events = ['pointerdown', 'touchstart', 'wheel', 'keydown', 'scroll'];
            function firstInteraction() {
                events.forEach(function (ev) { document.removeEventListener(ev, firstInteraction); });
                if (!started && audio.paused) play();
            }
            events.forEach(function (ev) {
                document.addEventListener(ev, firstInteraction, { passive: true });
            });

            /* Toggle manual */
            document.getElementById('xmas-music-btn').addEventListener('click', function (e) {
                e.stopPropagation();
                if (audio.paused) play(); else pause();
            });

            renderIcon(false);
        })();
    </script>
</body>

</html>
