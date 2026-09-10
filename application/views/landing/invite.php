<!DOCTYPE html>
<html lang="id">

<head>
    <?php $this->load->view('partial/landing/head.php') ?>
    <style>
        * { box-sizing: border-box; }

        /* ===== Root Layout ===== */
        .invite-wrap {
            display: flex;
            height: 100dvh;
            overflow: hidden;
        }

        /* ===== Left: Sticky Hero ===== */
        .invite-hero {
            position: relative;
            width: 45%;
            flex-shrink: 0;
            height: 100dvh;
            overflow: hidden;
        }
        .invite-hero img.hero-bg {
            position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;
        }
        .invite-hero .hero-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(180deg, rgba(22,34,68,0.50) 0%, rgba(22,34,68,0.82) 100%);
        }
        .invite-hero .hero-content {
            position: relative; z-index: 2;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            height: 100%; text-align: center; padding: 2rem;
        }

        /* ===== Right: Scrollable Frame ===== */
        .invite-frame {
            flex: 1;
            height: 100dvh;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
            scroll-padding-bottom: 64px;
        }
        .invite-frame::-webkit-scrollbar { width: 3px; }
        .invite-frame::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.08); border-radius: 4px; }

        /* ===== Bottom Bar ===== */
        .bottom-bar {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 50;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-top: 1px solid rgba(0,0,0,0.06);
            padding-bottom: env(safe-area-inset-bottom, 0);
        }
        .bottom-bar-inner {
            display: flex; justify-content: space-around; align-items: center;
            max-width: 480px; margin: 0 auto;
            height: 56px;
        }
        .bottom-bar-item {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: 2px; flex: 1; cursor: pointer;
            color: #9ca3af; font-size: 10px; font-weight: 500; letter-spacing: 0.3px;
            transition: color .2s;
            text-decoration: none; -webkit-tap-highlight-color: transparent;
        }
        .bottom-bar-item.active,
        .bottom-bar-item:active { color: #b91c1c; }
        .bottom-bar-item i { font-size: 18px; transition: transform .2s; }
        .bottom-bar-item.active i { transform: scale(1.15); }

        /* ===== Section Blocks ===== */
        .invite-section {
            min-height: 100dvh;
            display: flex; align-items: center; justify-content: center;
            padding: 3rem 1.5rem calc(3rem + 64px);
        }

        /* ===== Event Detail Card ===== */
        .detail-card {
            background: #fff; border-radius: 1.25rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            padding: 2rem 1.5rem; width: 100%; max-width: 400px;
        }
        .detail-card .dt-icon {
            width: 48px; height: 48px; border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 20px; color: #fff; margin-bottom: 1rem;
        }
        .detail-card .dt-label {
            font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em;
            color: #9ca3af; margin-bottom: 4px;
        }
        .detail-card .dt-value {
            font-size: 1rem; font-weight: 600; color: #1f2937; line-height: 1.5;
        }
        .detail-card .dt-divider {
            height: 1px; background: #f3f4f6; margin: 1rem 0;
        }

        /* ===== CTA Button ===== */
        .btn-cta {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 14px 32px; border-radius: 9999px; font-weight: 700; font-size: 1rem;
            color: #fff; text-decoration: none; border: none; cursor: pointer;
            box-shadow: 0 6px 20px rgba(185,28,28,0.35);
            transition: transform .15s, box-shadow .15s;
        }
        .btn-cta:active { transform: scale(0.97); }

        /* ===== Location Card ===== */
        .map-wrap {
            width: 100%; max-width: 400px; border-radius: 1rem; overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
        }
        .map-wrap iframe { width: 100%; height: 220px; border: 0; display: block; }
        .map-wrap .map-info { background: #fff; padding: 1rem 1.25rem; }

        /* ===== Contact ===== */
        .contact-card {
            background: #fff; border-radius: 1.25rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            padding: 2rem 1.5rem; text-align: center; width: 100%; max-width: 400px;
        }
        .contact-card .avatar {
            width: 64px; height: 64px; border-radius: 50%;
            background: #fef2f2; display: inline-flex; align-items: center; justify-content: center;
            font-size: 28px; color: #b91c1c; margin-bottom: 0.75rem;
        }
        .wa-btn {
            display: inline-flex; align-items: center; gap: 8px;
            background: #25d366; color: #fff; padding: 12px 28px;
            border-radius: 9999px; font-weight: 600; text-decoration: none;
            transition: transform .15s;
        }
        .wa-btn:active { transform: scale(0.97); }

        /* ===== Snowflake ===== */
        .snowflake {
            position: absolute; color: rgba(255,255,255,0.7); font-size: 14px;
            pointer-events: none; animation: snowfall linear infinite;
        }
        @keyframes snowfall {
            0%   { transform: translateY(-10vh) rotate(0deg); opacity: 1; }
            100% { transform: translateY(105vh) rotate(360deg); opacity: 0.3; }
        }

        /* ===== Mobile: hide left hero, full-width frame ===== */
        @media (max-width: 767px) {
            .invite-hero { display: none; }
            .invite-frame { width: 100%; }
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900">

    <div class="invite-wrap">

        <!-- ===== LEFT: Sticky Hero (desktop only) ===== -->
        <div class="invite-hero">
            <img class="hero-bg" src="https://picsum.photos/800/1200?random=1" alt="Cover" />
            <div class="hero-overlay"></div>
        </div>

        <!-- ===== RIGHT: Scrollable Content ===== -->
        <div class="invite-frame" id="inviteFrame">

            <!-- EVENT INFO -->
            <div class="invite-section" id="sec-event" data-bar="1">
                <div class="detail-card text-center">
                    <div class="dt-icon" style="background:linear-gradient(135deg,#b91c1c,#dc2626);"><i class="fas fa-calendar-check"></i></div>
                    <h2 class="text-lg font-bold mb-4" style="color:#1f2937;">Ibadah &amp; Perayaan Natal 2025</h2>
                    <div class="dt-divider"></div>
                    <div class="mb-3">
                        <div class="dt-label">Tanggal</div>
                        <div class="dt-value">Minggu, 21 Desember 2025</div>
                    </div>
                    <div class="mb-3">
                        <div class="dt-label">Waktu</div>
                        <div class="dt-value">17.00 &ndash; 20.00 WIB</div>
                    </div>
                    <div class="mb-3">
                        <div class="dt-label">Open Gate</div>
                        <div class="dt-value">16.00 WIB</div>
                    </div>
                    <div class="dt-divider"></div>
                    <div>
                        <div class="dt-label">Lokasi</div>
                        <div class="dt-value">GPdI Kopo Permai<br><span class="text-sm font-normal text-gray-500">Komp. Kopo Permai 2 Blok 19B No. 2-4, Bandung</span></div>
                    </div>
                    <div class="dt-divider"></div>
                    <div>
                        <div class="dt-label">Pembicara</div>
                        <div class="dt-value">Pdt. Timotius Michael Litha</div>
                    </div>
                    <div class="mt-4">
                        <button class="btn-cta w-full" style="background:linear-gradient(135deg,#b91c1c,#dc2626);font-size:0.9rem;padding:12px 0;" onclick="scrollToSection('sec-rsvp')">
                            <i class="fas fa-pen"></i> Daftar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- RSVP / PENDAFTARAN -->
            <div class="invite-section" id="sec-rsvp" data-bar="2">
                <div class="detail-card">
                    <div class="text-center mb-5">
                        <div class="dt-icon mx-auto" style="background:linear-gradient(135deg,#b91c1c,#dc2626);"><i class="fas fa-pen-to-square"></i></div>
                        <h2 class="text-lg font-bold mt-2" style="color:#1f2937;">Form Pendaftaran</h2>
                        <p class="text-xs text-gray-400 mt-1">Mohon mengisi pendaftaran untuk mendapatkan nomor kursi</p>
                    </div>

                    <form id="formRsvp" onsubmit="return false;">
                        <div class="mb-3">
                            <label class="dt-label">Nama Lengkap</label>
                            <input type="text" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition" placeholder="Masukkan nama" />
                        </div>
                        <div class="mb-3">
                            <label class="dt-label">No. WhatsApp</label>
                            <input type="tel" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition" placeholder="08xxx" />
                        </div>
                        <div class="mb-3">
                            <label class="dt-label">Kehadiran</label>
                            <div class="flex gap-2">
                                <label class="flex-1 flex items-center justify-center gap-2 border border-gray-200 rounded-xl py-3 text-sm cursor-pointer hover:border-red-400 transition has-[:checked]:bg-red-50 has-[:checked]:border-red-400 has-[:checked]:text-red-700">
                                    <input type="radio" name="hadir" value="1" class="sr-only" /> <i class="fas fa-check-circle"></i> Hadir
                                </label>
                                <label class="flex-1 flex items-center justify-center gap-2 border border-gray-200 rounded-xl py-3 text-sm cursor-pointer hover:border-red-400 transition has-[:checked]:bg-red-50 has-[:checked]:border-red-400 has-[:checked]:text-red-700">
                                    <input type="radio" name="hadir" value="0" class="sr-only" /> <i class="fas fa-times-circle"></i> Tidak Hadir
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="dt-label">Jumlah Tamu</label>
                            <select class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition appearance-none bg-white">
                                <option>1 Orang</option>
                                <option>2 Orang</option>
                                <option>3 Orang</option>
                                <option>4 Orang</option>
                                <option>5 Orang</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="dt-label">Ucapan / Doa</label>
                            <textarea rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-400 transition resize-none" placeholder="Tulis ucapan atau doa..."></textarea>
                        </div>
                        <button type="button" class="btn-cta w-full" style="background:linear-gradient(135deg,#16a34a,#22c55e);font-size:0.9rem;padding:12px 0;">
                            <i class="fas fa-paper-plane"></i> Kirim Pendaftaran
                        </button>
                    </form>
                </div>
            </div>

            <!-- LOKASI / MAPS -->
            <div class="invite-section" id="sec-loc" data-bar="3">
                <div class="text-center w-full max-w-md">
                    <h2 class="text-lg font-bold mb-4" style="color:#1f2937;">Lokasi Acara</h2>
                    <div class="map-wrap mx-auto">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.946!2d107.5877!3d-6.9686!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTgnMDcuMCJTIDEwN8KwMzUnMTUuOCJF!5e0!3m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <div class="map-info">
                            <p class="font-semibold text-sm" style="color:#1f2937;">GPdI Kopo Permai</p>
                            <p class="text-xs text-gray-400 mt-1">Komp. Kopo Permai 2 Blok 19B No. 2-4, Bandung</p>
                            <p class="text-xs text-gray-400 mt-1"><i class="fas fa-parking mr-1"></i> Parkir mobil: lapangan barat gereja | Parkir motor: GH</p>
                        </div>
                    </div>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=-6.9686,107.5877" target="_blank" class="btn-cta mt-4" style="background:linear-gradient(135deg,#b91c1c,#dc2626);font-size:0.85rem;">
                        <i class="fas fa-diamond-turn-right"></i> Petunjuk Arah
                    </a>
                    <div class="contact-card mx-auto mt-6">
                        <div class="avatar"><i class="fas fa-phone"></i></div>
                        <p class="font-semibold text-sm" style="color:#1f2937;">CP Panitia Natal</p>
                        <p class="text-xs text-gray-400 mb-3">Richard</p>
                        <a href="https://wa.me/6282183328384" target="_blank" class="wa-btn text-sm">
                            <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                        </a>
                    </div>
                </div>
            </div>

        </div><!-- /invite-frame -->

    </div><!-- /invite-wrap -->

    <!-- ===== FIXED BOTTOM BAR ===== -->
    <nav class="bottom-bar">
        <div class="bottom-bar-inner">
            <a class="bottom-bar-item active" data-target="sec-event" href="#sec-event">
                <i class="fas fa-calendar-days"></i>
                <span>Acara</span>
            </a>
            <a class="bottom-bar-item" data-target="sec-rsvp" href="#sec-rsvp">
                <i class="fas fa-pen-to-square"></i>
                <span>Daftar</span>
            </a>
            <a class="bottom-bar-item" data-target="sec-loc" href="#sec-loc">
                <i class="fas fa-location-dot"></i>
                <span>Lokasi</span>
            </a>
            <a class="bottom-bar-item" data-target="sec-cover" href="#">
                <i class="fas fa-images"></i>
                <span>Galeri</span>
            </a>
        </div>
    </nav>

    <script>
    (function(){
        var frame = document.getElementById('inviteFrame');
        var items = document.querySelectorAll('.bottom-bar-item');
        var secs  = ['sec-event','sec-rsvp','sec-loc','sec-cover'];

        /* active state on scroll */
        frame.addEventListener('scroll', function(){
            var y = frame.scrollTop + frame.clientHeight * 0.4;
            var idx = 0;
            secs.forEach(function(id, i){
                var el = document.getElementById(id);
                if(el && el.offsetTop <= y) idx = i;
            });
            items.forEach(function(a,i){
                a.classList.toggle('active', i === idx);
            });
        });

        /* smooth scroll from bottom bar */
        items.forEach(function(a){
            a.addEventListener('click', function(e){
                e.preventDefault();
                var t = document.getElementById(this.dataset.target);
                if(t) t.scrollIntoView({behavior:'smooth', block:'start'});
            });
        });
    })();

    window.scrollToSection = function(id){
        var el = document.getElementById(id);
        if(el) el.scrollIntoView({behavior:'smooth', block:'start'});
    };
    </script>

        <?php $this->load->view('partial/landing/foot.php') ?>
</body>

</html>
