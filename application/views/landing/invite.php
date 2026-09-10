<!DOCTYPE html>
<html lang="id">

<head>
    <?php $this->load->view('partial/landing/head.php') ?>
    <style>
        /* scrollbar halus */
        .frame-scroll::-webkit-scrollbar {
            width: 3px;
        }

        .frame-scroll::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, .08);
            border-radius: 99px;
        }

        .frame-scroll {
            scroll-behavior: smooth;
            scroll-padding-bottom: 56px;
        }

        /* bottom bar active */
        .bar-item {
            transition: color .2s;
            text-decoration: none;
            -webkit-tap-highlight-color: transparent;
        }

        .bar-item.active,
        .bar-item:active {
            color: #b91c1c;
        }

        .bar-item.active i {
            transform: scale(1.15);
        }

        .bar-item i {
            transition: transform .2s;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 antialiased">

    <!-- ═══ ROOT ═══ -->
    <div class="flex h-screen overflow-hidden">

        <!-- ═══ LEFT: Hero BG (desktop only) ═══ -->
        <div class="relative hidden md:block w-[60%] shrink-0 h-screen overflow-hidden">
            <img class="absolute inset-0 w-full h-full object-cover" src="https://picsum.photos/800/1200?random=1"
                alt="Cover" />
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/40 to-slate-900/70"></div>
        </div>

        <!-- ═══ RIGHT: Scrollable ═══ -->
        <div class="frame-scroll flex-1 h-screen overflow-y-auto">

            <!-- Section 1: Acara -->
            <section id="sec-1" class="min-h-screen flex items-center justify-center p-6 pb-20">
                <div class="max-w-sm w-full text-center space-y-4">
                    <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-alt text-red-600 text-xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold">Ibadah &amp; Perayaan Natal 2025</h1>
                    <p class="text-gray-500 leading-relaxed">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                    </p>
                </div>
            </section>

            <!-- Section 2: Daftar -->
            <section id="sec-2" class="min-h-screen flex items-center justify-center p-6 pb-20">
                <div class="max-w-sm w-full text-center space-y-4">
                    <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-edit text-red-600 text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold">Form Pendaftaran</h2>
                    <p class="text-gray-500 leading-relaxed">
                        Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
                        cupidatat non proident, sunt in culpa qui officia deserunt.
                    </p>
                </div>
            </section>

            <!-- Section 3: Lokasi -->
            <section id="sec-3" class="min-h-screen flex items-center justify-center p-6 pb-20">
                <div class="max-w-sm w-full text-center space-y-4">
                    <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-red-600 text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold">Lokasi Acara</h2>
                    <p class="text-gray-500 leading-relaxed">
                        Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit
                        aut fugit, sed quia consequuntur magni dolores eos qui ratione
                        voluptatem sequi nesciunt.
                    </p>
                </div>
            </section>

            <!-- Section 4: Galeri -->
            <section id="sec-4" class="min-h-screen flex items-center justify-center p-6 pb-20">
                <div class="max-w-sm w-full text-center space-y-4">
                    <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-images text-red-600 text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold">Galeri Foto</h2>
                    <p class="text-gray-500 leading-relaxed">
                        Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet,
                        consectetur, adipisci velit, sed quia non numquam eius modi tempora
                        incidunt ut labore et dolore magnam aliquam quaerat voluptatem.
                    </p>
                </div>
            </section>

        </div>
    </div>

    <!-- ═══ BOTTOM BAR ═══ -->
    <nav class="fixed inset-x-0 bottom-0 z-50 bg-white/90 backdrop-blur-md border-t border-gray-100">
        <div class="flex justify-around items-center h-14 max-w-lg mx-auto">

            <a href="#sec-1"
                class="bar-item active flex flex-col items-center gap-0.5 flex-1 text-[10px] font-medium text-gray-400 transition-colors">
                <i class="fas fa-calendar-alt text-lg"></i>
                <span>Acara</span>
            </a>

            <a href="#sec-2"
                class="bar-item flex flex-col items-center gap-0.5 flex-1 text-[10px] font-medium text-gray-400 transition-colors">
                <i class="fas fa-edit text-lg"></i>
                <span>Daftar</span>
            </a>

            <a href="#sec-3"
                class="bar-item flex flex-col items-center gap-0.5 flex-1 text-[10px] font-medium text-gray-400 transition-colors">
                <i class="fas fa-map-marker-alt text-lg"></i>
                <span>Lokasi</span>
            </a>

            <a href="#sec-4"
                class="bar-item flex flex-col items-center gap-0.5 flex-1 text-[10px] font-medium text-gray-400 transition-colors">
                <i class="fas fa-images text-lg"></i>
                <span>Galeri</span>
            </a>

        </div>
    </nav>

    <script>
        (function () {
            var frame = document.querySelector('.frame-scroll');
            var items = document.querySelectorAll('.bar-item');
            var secs = ['sec-1', 'sec-2', 'sec-3', 'sec-4'];

            /* active state on scroll */
            frame.addEventListener('scroll', function () {
                var y = frame.scrollTop + frame.clientHeight * 0.4;
                var idx = 0;
                secs.forEach(function (id, i) {
                    var el = document.getElementById(id);
                    if (el && el.offsetTop <= y) idx = i;
                });
                items.forEach(function (a, i) {
                    a.classList.toggle('active', i === idx);
                });
            });

            /* smooth scroll from bottom bar */
            items.forEach(function (a) {
                a.addEventListener('click', function (e) {
                    e.preventDefault();
                    var t = document.getElementById(this.getAttribute('href').slice(1));
                    if (t) t.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });
        })();
    </script>

    <?php $this->load->view('partial/landing/foot.php') ?>
</body>

</html>