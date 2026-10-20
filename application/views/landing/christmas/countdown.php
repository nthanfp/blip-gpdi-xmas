<!-- Countdown Section -->
<section class="relative py-14 sm:py-20 px-5 sm:px-8 overflow-hidden -mt-px">
    <!-- Gradient background -->
    <div class="absolute inset-0 bg-gradient-to-b from-red-950 via-red-900 to-red-900"></div>
    <!-- Radial gold glow -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(212,175,55,0.06)_0%,_transparent_70%)]"></div>

    <!-- Top fade -->
    <div class="absolute top-0 left-0 right-0 h-16 bg-gradient-to-b from-red-950/80 to-transparent pointer-events-none"></div>
    <!-- Bottom fade -->
    <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-red-900 to-transparent pointer-events-none"></div>

    <!-- Bokeh dots -->
    <div class="absolute top-[10%] left-[15%] w-2 h-2 rounded-full bg-gold-400/15 blur-[1px] animate-pulse"></div>
    <div class="absolute top-[20%] right-[12%] w-1.5 h-1.5 rounded-full bg-gold-300/10 blur-[1px] animate-pulse" style="animation-delay: 1s;"></div>
    <div class="absolute bottom-[20%] left-[18%] w-1 h-1 rounded-full bg-gold-400/20 blur-[1px] animate-pulse" style="animation-delay: 2s;"></div>
    <div class="absolute bottom-[30%] right-[20%] w-1.5 h-1.5 rounded-full bg-gold-300/10 blur-[1px] animate-pulse" style="animation-delay: 0.5s;"></div>

    <!-- Snowflakes -->
    <div class="snowflakes absolute inset-0 pointer-events-none" aria-hidden="true">
        <div class="snowflake">❄</div>
        <div class="snowflake">❅</div>
        <div class="snowflake">❆</div>
        <div class="snowflake">❄</div>
        <div class="snowflake">❅</div>
    </div>

    <div class="relative z-10 max-w-md lg:max-w-lg mx-auto text-center space-y-8">

        <!-- Eyebrow -->
        <div class="space-y-4" data-aos="fade-down">
            <p class="text-[11px] font-semibold tracking-[0.25em] uppercase text-gold-400">
                Countdown
            </p>
            <h2 class="text-2xl sm:text-3xl font-bold text-white leading-snug">
                Menuju Perayaan Natal
            </h2>
        </div>

        <!-- Countdown boxes -->
        <div class="flex justify-center gap-2 sm:gap-3 md:gap-4" id="xmas-countdown" data-aos="zoom-in-up" data-aos-delay="150">

            <div class="countdown-box">
                <span class="countdown-num" id="cd-days"><span class="cd-inner">00</span></span>
                <span class="countdown-label">Hari</span>
            </div>

            <div class="countdown-box">
                <span class="countdown-num" id="cd-hours"><span class="cd-inner">00</span></span>
                <span class="countdown-label">Jam</span>
            </div>

            <div class="countdown-box">
                <span class="countdown-num" id="cd-mins"><span class="cd-inner">00</span></span>
                <span class="countdown-label">Menit</span>
            </div>

            <div class="countdown-box">
                <span class="countdown-num" id="cd-secs"><span class="cd-inner">00</span></span>
                <span class="countdown-label">Detik</span>
            </div>

        </div>

    </div>
</section>

<style>
    .countdown-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 4rem;
        height: 5rem;
        border-radius: 0.75rem;
        background-color: rgba(127, 29, 29, 0.5);
        border: 1px solid rgba(212, 175, 55, 0.25);
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.08), inset 0 1px 0 rgba(212, 175, 55, 0.1);
        transition: box-shadow 0.3s ease, border-color 0.3s ease;
    }
    .countdown-box:hover {
        border-color: rgba(212, 175, 55, 0.4);
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.15), inset 0 1px 0 rgba(212, 175, 55, 0.15);
    }
    @media (min-width: 640px) {
        .countdown-box {
            width: 5rem;
            height: 6rem;
        }
    }
    .countdown-num {
        display: inline-block;
        position: relative;
        overflow: hidden;
        font-size: 1.5rem;
        line-height: 2rem;
        height: 2rem;
        font-weight: 700;
        color: #D4AF37;
        font-family: 'Playfair Display', serif;
        text-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
    }
    .cd-inner {
        display: block;
    }
    /* Digit lama: naik ke atas & keluar */
    .cd-inner.cd-out {
        position: absolute;
        inset: 0;
        animation: cdOut 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
    /* Digit baru: muncul dari bawah */
    .cd-inner.cd-in {
        animation: cdIn 0.45s cubic-bezier(0.34, 1.3, 0.64, 1) both;
    }
    @keyframes cdOut {
        0%   { transform: translateY(0); opacity: 1; }
        100% { transform: translateY(-100%); opacity: 0; }
    }
    @keyframes cdIn {
        0%   { transform: translateY(100%); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }
    @media (min-width: 640px) {
        .countdown-num {
            font-size: 1.875rem;
            line-height: 2.25rem;
            height: 2.25rem;
        }
    }
    .countdown-label {
        font-size: 0.625rem;
        line-height: 0.75rem;
        font-weight: 500;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 0.25rem;
    }
    @media (min-width: 640px) {
        .countdown-label {
            font-size: 0.75rem;
            line-height: 1rem;
        }
    }

    /* Snowflakes */
    .snowflakes .snowflake {
        position: absolute;
        top: -10px;
        color: rgba(255, 255, 255, 0.15);
        font-size: 0.75rem;
        animation: snowfall linear infinite;
    }
    .snowflakes .snowflake:nth-child(1) { left: 10%; font-size: 0.6rem; animation-duration: 12s; animation-delay: 0s; }
    .snowflakes .snowflake:nth-child(2) { left: 30%; font-size: 0.8rem; animation-duration: 15s; animation-delay: 2s; }
    .snowflakes .snowflake:nth-child(3) { left: 55%; font-size: 0.5rem; animation-duration: 10s; animation-delay: 4s; }
    .snowflakes .snowflake:nth-child(4) { left: 75%; font-size: 0.7rem; animation-duration: 14s; animation-delay: 1s; }
    .snowflakes .snowflake:nth-child(5) { left: 90%; font-size: 0.6rem; animation-duration: 11s; animation-delay: 3s; }

    @keyframes snowfall {
        0% { transform: translateY(-10px) rotate(0deg); opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { transform: translateY(100%) rotate(360deg); opacity: 0; }
    }

    @media (prefers-reduced-motion: reduce) {
        .cd-inner.cd-out, .cd-inner.cd-in { animation: none; }
    }
</style>

<script>
(function () {
    var target = new Date('2026-12-20T17:00:00+07:00').getTime();
    var dEl = document.getElementById('cd-days');
    var hEl = document.getElementById('cd-hours');
    var mEl = document.getElementById('cd-mins');
    var sEl = document.getElementById('cd-secs');

    function pad(n) { return n < 10 ? '0' + n : n; }

    var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* Digit lama naik ke atas, digit baru muncul dari bawah.
       Guard via data-val: hanya box yang nilainya BERUBAH yang animasi. */
    function setNum(el, val) {
        if (el.getAttribute('data-val') === val) return;
        el.setAttribute('data-val', val);

        var cur = el.querySelector('.cd-inner:not(.cd-out)');

        if (reduceMotion) {
            el.innerHTML = '';
            var plain = document.createElement('span');
            plain.className = 'cd-inner';
            plain.textContent = val;
            el.appendChild(plain);
            return;
        }

        /* Digit lama → animasi keluar ke atas, lalu dihapus */
        if (cur) {
            cur.classList.add('cd-out');
            (function (node) {
                setTimeout(function () {
                    if (node.parentNode) node.parentNode.removeChild(node);
                }, 420);
            })(cur);
        }

        /* Digit baru → muncul dari bawah */
        var next = document.createElement('span');
        next.className = 'cd-inner cd-in';
        next.textContent = val;
        el.appendChild(next);
    }

    function tick() {
        var now = Date.now();
        var diff = target - now;

        if (diff <= 0) {
            setNum(dEl, '00');
            setNum(hEl, '00');
            setNum(mEl, '00');
            setNum(sEl, '00');
            return;
        }

        var d = Math.floor(diff / 86400000);
        var h = Math.floor((diff % 86400000) / 3600000);
        var m = Math.floor((diff % 3600000) / 60000);
        var s = Math.floor((diff % 60000) / 1000);

        setNum(dEl, pad(d));
        setNum(hEl, pad(h));
        setNum(mEl, pad(m));
        setNum(sEl, pad(s));

        requestAnimationFrame(function () { setTimeout(tick, 1000); });
    }

    tick();
})();
</script>
