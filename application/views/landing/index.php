<!DOCTYPE html>
<html lang="id">

<head>
    <?php $this->load->view('partial/landing/head.php') ?>

</head>

<body class="bg-light flex justify-center">
    <div class="w-full max-w-[430px] flex flex-col relative shadow-2xl" style="min-height: 100vh; min-height: 100dvh;">
        <!-- Navbar -->
        <div class="flex-shrink-0">
            <?php $this->load->view('partial/landing/navbar.php') ?>
        </div>

        <!-- Screen 1 (max-w-md mx-auto) -->
        <div class="flex-1 flex flex-col justify-between overflow-y-auto min-h-0" id="Screen-1">
            <!-- Section: Top  -->
            <div id="Section-Top">
                <div class="page active" id="p1">
                    <div class="px-5 pt-8 pb-5">
                        <p class="text-[12px] tracking-[3px] font-semibold text-white/90 mb-2.5">
                            SELAMAT DATANG
                        </p>
                        <h1
                            class="font-serif text-4xl font-bold leading-tight text-white mb-3 drop-shadow-[0_2px_12px_rgba(0,0,0,0.28)]">
                            Ada <span class="font-serif-italic text-redlux-light">hadiah spesial</span>
                            <br> untukmu hari ini
                        </h1>
                        <p class="text-sm text-red-100 leading-relaxed">
                            Kami sedang memverifikasi voucher eksklusifmu dari produk ILLUSIONS.
                        </p>
                    </div>
                </div>
            </div>
            <!-- Section: Bottom-->
            <div id="Section-Bottom" class="relative -mt-8">
                <!-- Card Status Voucher -->
                <div class="mx-5 mb-5
                bg-gradient-to-b from-primary to-redlux-dark
                border border-brand-border
                ring-1 ring-white/10
                backdrop-blur-sm
                rounded-2xl
                p-4
                shadow-xl shadow-red-900/20">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 rounded-lg bg-white/10 backdrop-blur-s flex 
                        items-center justify-center flex-shrink-0">
                            <i class="fas fa-gift text-white text-base"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">
                                Status Voucher
                            </p>
                            <div id="verif-status-ok" class="hidden items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium
                            bg-emerald-300/10
                            text-emerald-100
                            border border-emerald-300/10
                            backdrop-blur-sm">
                                <i class="fas fa-check-circle text-emerald-500"></i>
                                Voucher Valid & Aktif
                            </div>
                            <div id="verif-status-loading"
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-white/10 text-white/90 border border-white/10 backdrop-blur-md shadow-inner shadow-white/5">
                                <i class="fas fa-spinner fa-spin"></i>
                                Memverifikasi Voucher...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Screen 2 -->
        <div class="flex-1 flex-col justify-center overflow-y-auto min-h-0 hidden" id="Screen-2">
            <!-- Section: Invalid -->
            <div id="Section-Invalid" class="px-5">
                <div
                    class="bg-white/10 backdrop-blur-xl border border-white/10 ring-1 ring-white/10 rounded-2xl p-5 shadow-xl">
                    <div
                        class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-red-800/30 border border-rose-300/10 flex items-center justify-center">
                        <i class="fas fa-times-circle text-2xl text-red-200"></i>
                    </div>
                    <h3 class="text-center text-xl font-bold text-white mb-2">
                        Voucher Tidak Tersedia
                    </h3>
                    <p class="text-sm text-center text-red-100/80 leading-relaxed mb-5">
                        Voucher yang Anda gunakan sudah pernah diklaim,
                        kedaluwarsa, atau tidak valid.
                    </p>
                    <div class="bg-white/5 border border-white/10 rounded-xl p-4 mb-4 hidden">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5">
                                <i class="fas fa-info-circle text-amber-300"></i>
                            </div>
                            <p class="text-xs text-white/70 leading-relaxed">
                                Pastikan Anda menggunakan link voucher resmi
                                dari PRODUK ILLUSIONS dan belum pernah melakukan klaim sebelumnya.
                            </p>
                        </div>
                    </div>
                    <button onclick="window.location.reload()" class="w-full py-3.5
                   rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 text-white
                   text-xs font-semibold tracking-[1px] transition-all hidden">
                        COBA VERIFIKASI ULANG
                    </button>

                </div>

            </div>
        </div>

        <!-- Screen 5 - Redeemed -->
        <div class="flex-1 justify-center flex-col overflow-y-auto min-h-0 hidden" id="Screen-5">
            <div class="px-5">
                <div class="bg-white/10 safari-blur-fix backdrop-blur-md border border-white/20 rounded-2xl p-6 shadow-xl">
                    <div class="w-20 h-20 mx-auto mb-5 rounded-3xl bg-amber-500/10 border border-amber-300/10 flex items-center justify-center">
                        <i class="fas fa-clock text-4xl text-amber-300"></i>
                    </div>
                    <h2 class="text-center text-2xl font-bold text-white mb-3">
                        Hadiah Sudah Ditukarkan
                    </h2>
                    <p class="text-sm text-center text-white/70 leading-relaxed mb-6">
                        Voucher ini sudah pernah diklaim sebelumnya. Silakan cek email Anda untuk informasi lebih lanjut mengenai pengiriman hadiah.
                    </p>
                    <div class="hidden bg-white/5 border border-white/10 rounded-xl p-4 mb-5">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5">
                                <i class="fas fa-envelope text-amber-200"></i>
                            </div>
                            <p class="text-xs text-white/70 leading-relaxed">
                                Jika belum menerima email, hubungi customer service
                                untuk bantuan lebih lanjut.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php $this->load->view('partial/landing/footer.php') ?>
    </div>

    <!-- Foot Js -->
    <?php $this->load->view('partial/landing/foot.php') ?>

    <!-- GSAP -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/gsap.min.js"></script>

    <!-- Custom Js -->
    <script type="text/javascript">
        function showError(message) {
            $('#verif-status-loading')
                .removeClass('bg-white/10')
                .addClass('bg-red-500/20 border-red-400/20 text-red-100')
                .html(` <i class="fas fa-times-circle"></i> ${message}
                `);

            $('#lihatHadiahBtn').prop('disabled', true);
        }

        function showScreen1() {
            $('#Screen-1').removeClass('hidden').addClass('flex');
            $('#Screen-2').addClass('hidden').removeClass('flex');
            $('#Screen-5').addClass('hidden').removeClass('flex');
            gsap.fromTo('#Screen-1', {
                opacity: 0,
                y: 30
            }, {
                opacity: 1,
                y: 0,
                duration: 0.4,
                ease: 'power2.out'
            });
            gsap.fromTo('#Section-Top', {
                opacity: 0,
                y: -20
            }, {
                opacity: 1,
                y: 0,
                duration: 0.5,
                ease: 'power2.out',
                delay: 0.1
            });
            gsap.fromTo('#Section-Bottom', {
                opacity: 0,
                y: 20
            }, {
                opacity: 1,
                y: 0,
                duration: 0.5,
                ease: 'power2.out',
                delay: 0.2
            });
        }

        function showScreen2() {
            $('#Screen-1').addClass('hidden').removeClass('flex');
            $('#Screen-5').addClass('hidden').removeClass('flex');
            $('#Screen-2').removeClass('hidden').addClass('flex');
            gsap.fromTo('#Screen-2', {
                opacity: 0,
                y: 30
            }, {
                opacity: 1,
                y: 0,
                duration: 0.4,
                ease: 'power2.out'
            });
            gsap.fromTo('#Section-Invalid', {
                opacity: 0,
                scale: 0.95
            }, {
                opacity: 1,
                scale: 1,
                duration: 0.5,
                ease: 'power2.out',
                delay: 0.1
            });
            gsap.fromTo('#Section-Invalid .fa-times-circle', {
                scale: 0,
                rotation: -90
            }, {
                scale: 1,
                rotation: 0,
                duration: 0.5,
                ease: 'back.out(1.7)',
                delay: 0.2
            });
        }

        function showScreen5() {
            $('#Screen-1').addClass('hidden').removeClass('flex');
            $('#Screen-2').addClass('hidden').removeClass('flex');
            $('#Screen-5').removeClass('hidden').addClass('flex');
            gsap.fromTo('#Screen-5', {
                opacity: 0,
                y: 30
            }, {
                opacity: 1,
                y: 0,
                duration: 0.4,
                ease: 'power2.out'
            });
        }

        (function init() {

            var csrfName = $('meta[name="csrf-token-name"]').attr('content') || 'csrf_test_name';
            var csrfToken = $('meta[name="csrf-token-value"]').attr('content');

            const segments = window.location.pathname.split('/').filter(Boolean);
            const voucherKey = segments[segments.length - 1];
            const apiUrl = '<?php echo site_url('api/voucher/verification') ?>';

            const startTime = Date.now();

            var postData = {
                voucher_key: voucherKey
            };
            if (csrfToken) postData[csrfName] = csrfToken;

            $.ajax({
                url: apiUrl,
                type: 'POST',
                dataType: 'json',
                data: postData,
                success: function(result) {
                    const delay = Math.max(0, 5000 - (Date.now() - startTime));

                    setTimeout(function() {
                        $('#verif-status-loading').addClass('hidden');

                        if (result.success === true && result.verified === true && result.can_claim === true && result.data.status === '1') {

                            const redirectUrl = '<?php echo site_url(); ?>landing/complete/' + voucherKey;

                            $('#verif-status-ok')
                                .removeClass('hidden')
                                .addClass('inline-flex')
                                .html(`<i class="fas fa-check-circle text-emerald-500"></i> Voucher Terkonfirmasi`);

                            $.LoadingOverlay('show', {
                                imageColor: 'rgba(122, 16, 40, 0)',
                                background: 'rgba(0, 0, 0, 0.25)'
                            });

                            setTimeout(() => {
                                window.location.href = redirectUrl;
                            }, 1200);
                        } else if (result?.success === true && result?.data && (String(result.data.status) === '3' || String(result.data.status) === '4')) {
                            showScreen5();
                        } else {
                            showScreen2();
                        }
                    }, delay);

                },
                error: function(xhr, status, error) {
                    const delay = Math.max(0, 5000 - (Date.now() - startTime));
                    setTimeout(function() {
                        console.error(error);
                        showScreen2();
                    }, delay);
                }
            });
        })();
    </script>

</body>

</html>