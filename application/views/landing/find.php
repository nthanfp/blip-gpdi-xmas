<!DOCTYPE html>
<html lang="id">

<head>
    <?php $this->load->view('partial/landing/head.php') ?>
    <title>Cari Pendaftaran — From Glory to Glory</title>
</head>

<body class="bg-red-950 text-stone-200 antialiased min-h-screen">

    <style>
        @media (min-width: 1024px) {
            html, body {
                overflow: auto !important;
                height: auto !important;
            }
        }
        .find-anim { animation: findPop .4s cubic-bezier(.2,.9,.3,1.15); }
        @keyframes findPop {
            from { opacity: 0; transform: scale(.95) translateY(8px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        @media (prefers-reduced-motion: reduce) { .find-anim { animation: none; } }
    </style>

    <!-- Background (sama dengan registration-success) -->
    <div class="fixed inset-0 z-0 bg-cover bg-center bg-no-repeat"
         style="background-image: url('<?php echo site_url('assets/images/christmas/hero.webp'); ?>');"
         aria-hidden="true"></div>
    <div class="fixed inset-0 z-0 bg-red-950/80" aria-hidden="true"></div>
    <div class="fixed inset-0 z-0 bg-[radial-gradient(ellipse_at_center,_rgba(212,175,55,0.12)_0%,_transparent_60%)]" aria-hidden="true"></div>
    <div class="fixed inset-0 z-0 opacity-[0.04]"
         style="background-image: radial-gradient(circle, #f5edd6 1px, transparent 1px); background-size: 24px 24px;" aria-hidden="true"></div>

    <img src="<?php echo site_url('assets/images/christmas/frame-top.webp'); ?>" alt=""
         aria-hidden="true"
         class="fixed top-0 left-0 w-full lg:hidden pointer-events-none select-none z-40">

    <div class="relative z-10 py-14 sm:py-20 px-5">

        <div class="w-full max-w-sm mx-auto space-y-6">

            <div class="text-center">
                <img src="<?php echo site_url('assets/images/christmas/from-glory.png'); ?>" alt="From Glory to Glory"
                     class="mx-auto w-56 sm:w-64 h-auto drop-shadow-[0_4px_12px_rgba(0,0,0,0.5)]">
            </div>

            <div class="bg-white rounded-2xl border border-gold-200/70 ring-1 ring-gold-400/25 shadow-2xl shadow-black/40 p-6 sm:p-8 space-y-5 find-anim">

                <div class="space-y-2 text-center">
                    <h1 class="text-lg font-bold text-stone-800">Cari Pendaftaran</h1>
                    <p class="text-sm text-stone-500 leading-relaxed">
                        Masukkan nomor HP yang digunakan saat mendaftar untuk membuka halaman pendaftaran Anda.
                    </p>
                </div>

                <form id="findForm" class="space-y-4" autocomplete="off" novalidate>
                    <div class="space-y-1.5 text-left">
                        <label for="findPhone" class="block text-xs font-semibold text-stone-700 tracking-wide">
                            No. HP <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="findPhone" name="phone" inputmode="numeric"
                               placeholder="08xx / 62xx" required
                               class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm text-stone-800 placeholder-stone-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gold-400/50 focus:border-gold-400">
                    </div>

                    <button type="submit" id="findBtn"
                            class="w-full py-3 rounded-xl bg-gold-500 hover:bg-gold-600 text-red-950 font-semibold text-sm tracking-wide transition-all duration-300 hover:shadow-lg hover:shadow-gold-500/25 active:scale-95 focus:outline-none focus:ring-2 focus:ring-gold-400 focus:ring-offset-2 focus:ring-offset-white">
                        <i class="fas fa-search mr-2"></i> Cari Pendaftaran
                    </button>
                </form>

                <!-- Hasil multi: pilih salah satu -->
                <div id="findMulti" class="hidden space-y-2">
                    <p class="text-xs font-semibold text-stone-600 text-center">Ditemukan beberapa pendaftaran — pilih salah satu:</p>
                    <div id="findMultiList" class="space-y-2"></div>
                </div>

                <!-- Pesan error -->
                <div id="findMsg" class="hidden rounded-xl px-4 py-3 text-sm text-center"></div>
            </div>

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
        (function () {
            var endpoint = <?php echo json_encode(site_url('find_ajax')); ?>;
            var form = document.getElementById('findForm');
            var btn = document.getElementById('findBtn');
            var msg = document.getElementById('findMsg');
            var multiBox = document.getElementById('findMulti');
            var multiList = document.getElementById('findMultiList');
            var btnHtml = btn.innerHTML;

            function showMessage(html, ok) {
                msg.className = 'rounded-xl px-4 py-3 text-sm text-center ' +
                    (ok ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                        : 'bg-red-50 text-red-700 border border-red-200');
                msg.innerHTML = html;
                msg.classList.remove('hidden');
            }

            function hideMessage() {
                msg.classList.add('hidden');
                multiBox.classList.add('hidden');
                multiList.innerHTML = '';
            }

            function csrfPayload(data) {
                var name = (document.querySelector('meta[name="csrf-token-name"]') || {}).content || 'csrf_test_name';
                var value = (document.querySelector('meta[name="csrf-token-value"]') || {}).content || '';
                data.append(name, value);
                return data;
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                hideMessage();

                var phone = document.getElementById('findPhone').value.replace(/\D+/g, '');
                if (!phone) {
                    showMessage('Masukkan nomor HP terlebih dahulu.', false);
                    return;
                }

                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mencari...';

                var payload = new FormData();
                payload.append('phone', phone);

                fetch(endpoint, {
                    method: 'POST',
                    body: csrfPayload(payload),
                    credentials: 'same-origin'
                })
                    .then(function (r) { return r.json(); })
                    .then(function (res) {
                        if (!res.success) {
                            showMessage(res.message || 'Terjadi kesalahan. Coba lagi.', false);
                            return;
                        }
                        if (res.multi && res.list && res.list.length) {
                            multiList.innerHTML = '';
                            res.list.forEach(function (item) {
                                var a = document.createElement('a');
                                a.href = item.redirect;
                                a.className = 'flex items-center justify-between gap-2 w-full px-4 py-3 rounded-xl bg-gold-50 hover:bg-gold-100 border border-gold-200 text-stone-800 text-sm font-semibold transition-all duration-200 active:scale-95';
                                a.innerHTML = '<span><i class="fas fa-ticket-alt text-gold-500 mr-2"></i>' +
                                    item.ref_code + '</span>' +
                                    '<span class="text-xs text-stone-500 font-normal">' + item.floor_name + '</span>';
                                multiList.appendChild(a);
                            });
                            multiBox.classList.remove('hidden');
                            showMessage('Nomor terdaftar di beberapa pendaftaran. Pilih salah satu di bawah.', true);
                            return;
                        }
                        if (res.redirect) {
                            showMessage('Ditemukan! Mengalihkan ke <b>' + res.ref_code + '</b>&hellip;', true);
                            setTimeout(function () { window.location.href = res.redirect; }, 600);
                        }
                    })
                    .catch(function () {
                        showMessage('Tidak dapat terhubung ke server. Coba lagi.', false);
                    })
                    .finally(function () {
                        btn.disabled = false;
                        btn.innerHTML = btnHtml;
                    });
            });
        })();
    </script>
</body>

</html>
