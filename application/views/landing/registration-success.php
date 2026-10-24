<!DOCTYPE html>
<html lang="id">

<head>
    <?php $this->load->view('partial/landing/head.php') ?>
    <!-- QR generator (client-side) -->
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
</head>

<body class="bg-red-950 text-stone-200 antialiased min-h-screen">

    <!-- Halaman standalone: buka lagi kunci scroll desktop dari head.php
         (kunci itu hanya untuk layout split invite/invitation) -->
    <style>
        @media (min-width: 1024px) {
            html, body {
                overflow: auto !important;
                height: auto !important;
            }
        }
    </style>

    <!-- ═══ Background: hero image + overlay (vibes invite.php) ═══ -->
    <div class="fixed inset-0 z-0 bg-cover bg-center bg-no-repeat"
         style="background-image: url('<?php echo site_url('assets/images/christmas/hero.webp'); ?>');"
         aria-hidden="true"></div>
    <div class="fixed inset-0 z-0 bg-red-950/80" aria-hidden="true"></div>
    <!-- Radial gold glow -->
    <div class="fixed inset-0 z-0 bg-[radial-gradient(ellipse_at_center,_rgba(212,175,55,0.12)_0%,_transparent_60%)]" aria-hidden="true"></div>
    <!-- Dot texture -->
    <div class="fixed inset-0 z-0 opacity-[0.04]"
         style="background-image: radial-gradient(circle, #f5edd6 1px, transparent 1px); background-size: 24px 24px;" aria-hidden="true"></div>

    <!-- Frames dekoratif (mobile) -->
    <img src="<?php echo site_url('assets/images/christmas/frame-top.webp'); ?>" alt=""
         aria-hidden="true"
         class="fixed top-0 left-0 w-full lg:hidden pointer-events-none select-none z-40">

    <div class="relative z-10 py-14 sm:py-20 px-5">

        <div class="w-full max-w-sm mx-auto space-y-6">

            <!-- Logo From Glory to Glory (seperti hero) -->
            <div class="text-center">
                <img src="<?php echo site_url('assets/images/christmas/from-glory.png'); ?>" alt="From Glory to Glory"
                     class="mx-auto w-56 sm:w-64 h-auto drop-shadow-[0_4px_12px_rgba(0,0,0,0.5)]">
            </div>

            <!-- Card sukses -->
            <div class="bg-white rounded-2xl border border-gold-200/70 ring-1 ring-gold-400/25 shadow-2xl shadow-black/40 p-6 sm:p-8 text-center space-y-5 reg-success-anim">

                <div class="space-y-2">
                    <h1 class="text-lg font-bold text-stone-800">Pendaftaran Berhasil!</h1>
                    <p class="text-sm text-stone-500 leading-relaxed max-w-xs mx-auto">
                        Terima kasih telah mendaftar. Tunjukkan QR code atau kode registrasi ini saat check-in.
                    </p>
                </div>

                <!-- QR Code -->
                <div class="inline-block bg-white p-3 rounded-xl border border-gold-200 ring-1 ring-gold-100 shadow-sm">
                    <div id="qr-box" class="w-44 h-44 mx-auto flex items-center justify-center"></div>
                    <div id="qr-fallback" class="hidden w-44 px-2">
                        <p class="text-[10px] text-stone-400 mb-1">Kode registrasi Anda</p>
                        <p class="text-xl font-black tracking-widest text-stone-800 break-all"><?php echo html_escape($reg->ref_code); ?></p>
                    </div>
                </div>
                <p class="text-[11px] text-stone-400 -mt-2">Scan untuk membuka halaman ini kembali</p>

                <!-- Kode registrasi -->
                <div class="bg-gold-50 border border-gold-200 rounded-xl px-4 py-3 space-y-0.5">
                    <p class="text-[10px] font-semibold tracking-[0.2em] uppercase text-stone-400">Kode Registrasi</p>
                    <p class="text-2xl font-black tracking-[0.15em] text-stone-800"><?php echo html_escape($reg->ref_code); ?></p>
                </div>

                <!-- Ringkasan -->
                <div class="flex items-center justify-center gap-3 text-xs text-stone-500 flex-wrap">
                    <span class="inline-flex items-center gap-1">
                        <i class="fas fa-layer-group text-gold-500 mr-1.5"></i> Lantai <?php echo (int) $reg->floor; ?>
                    </span>
                    <span class="text-stone-300">|</span>
                    <span class="inline-flex items-center gap-1">
                        <i class="fas fa-users text-gold-500 mr-1.5"></i> <?php echo count($attendees); ?> peserta
                    </span>
                </div>

                <!-- Daftar peserta -->
                <?php if ($attendees) : ?>
                <div class="text-left bg-stone-50 rounded-xl px-4 py-3 space-y-1 max-h-32 overflow-auto border border-stone-100">
                    <?php foreach ($attendees as $i => $a) : ?>
                    <p class="text-xs text-stone-600 flex items-center justify-between gap-2">
                        <span><span class="text-stone-400 mr-1"><?php echo $i + 1; ?>.</span><?php echo html_escape($a->name); ?></span>
                        <span class="text-stone-400"><?php echo html_escape($a->age); ?> th</span>
                    </p>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <p class="text-[11px] text-stone-400 leading-relaxed">
                    Simpan screenshot halaman ini.<br>Sampai jumpa — 20 Desember 2026, 17.00 WIB.
                </p>
            </div>

            <!-- Tombol kembali -->
            <div class="text-center">
                <a href="<?php echo site_url('landing/invite'); ?>"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-gold-500 hover:bg-gold-600 text-red-950 font-semibold text-sm tracking-wide transition-all duration-300 hover:shadow-lg hover:shadow-gold-500/25 active:scale-95 focus:outline-none focus:ring-2 focus:ring-gold-400 focus:ring-offset-2 focus:ring-offset-red-950">
                    <i class="fas fa-arrow-left text-xs"></i> Kembali ke Halaman Undangan
                </a>
            </div>

        </div>
    </div>

    <?php $this->load->view('partial/landing/foot.php') ?>

    <script>
        document.title = 'Pendaftaran — <?php echo addslashes($reg->ref_code); ?>';

        (function () {
            var url = <?php echo json_encode(site_url('p/' . $reg->ref_code)); ?>;
            var box = document.getElementById('qr-box');
            var fallback = document.getElementById('qr-fallback');

            function useFallback() {
                box.classList.add('hidden');
                fallback.classList.remove('hidden');
            }

            if (typeof QRCode === 'undefined') {
                /* CDN gagal -> tampilkan kode teks besar */
                setTimeout(function () {
                    if (typeof QRCode === 'undefined') useFallback();
                }, 1500);
                return;
            }

            try {
                new QRCode(box, {
                    text: url,
                    width: 176,
                    height: 176,
                    colorDark: '#1c1917',
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.M
                });
            } catch (e) {
                useFallback();
            }
        })();
    </script>
    <style>
        .reg-success-anim { animation: successPop .45s cubic-bezier(.2,.9,.3,1.2); }
        @keyframes successPop {
            from { opacity: 0; transform: scale(.92) translateY(8px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        @media (prefers-reduced-motion: reduce) { .reg-success-anim { animation: none; } }
    </style>
</body>

</html>
