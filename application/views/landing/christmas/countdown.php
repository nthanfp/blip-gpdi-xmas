<!-- Countdown Section -->
<section class="relative py-20 sm:py-28 px-5 sm:px-8 overflow-hidden">
    <!-- Gradient background -->
    <div class="absolute inset-0 bg-gradient-to-b from-red-950 via-red-950 to-red-900"></div>
    <!-- Radial gold glow -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(212,175,55,0.06)_0%,_transparent_70%)]"></div>

    <!-- Top fade -->
    <div class="absolute top-0 left-0 right-0 h-16 bg-gradient-to-b from-red-950/80 to-transparent pointer-events-none"></div>
    <!-- Bottom fade -->
    <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-stone-50/10 to-transparent pointer-events-none"></div>

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
        <div class="space-y-4">
            <p class="text-[11px] font-semibold tracking-[0.25em] uppercase text-gold-400">
                Countdown
            </p>
            <h2 class="text-2xl sm:text-3xl font-bold text-white leading-snug">
                Menuju Perayaan Natal
            </h2>
        </div>

        <!-- Countdown boxes -->
        <div class="flex justify-center gap-2 sm:gap-3 md:gap-4" id="xmas-countdown">

            <div class="countdown-box">
                <span class="countdown-num" id="cd-days">00</span>
                <span class="countdown-label">Hari</span>
            </div>

            <div class="countdown-box">
                <span class="countdown-num" id="cd-hours">00</span>
                <span class="countdown-label">Jam</span>
            </div>

            <div class="countdown-box">
                <span class="countdown-num" id="cd-mins">00</span>
                <span class="countdown-label">Menit</span>
            </div>

            <div class="countdown-box">
                <span class="countdown-num" id="cd-secs">00</span>
                <span class="countdown-label">Detik</span>
            </div>

        </div>

        <!-- Event date reminder -->
        <p class="text-xs text-stone-400">
            20 Desember 2026 · 17:00 WIB
        </p>

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
        font-size: 1.5rem;
        line-height: 2rem;
        font-weight: 700;
        color: #D4AF37;
        font-family: 'Playfair Display', serif;
        text-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
    }
    @media (min-width: 640px) {
        .countdown-num {
            font-size: 1.875rem;
            line-height: 2.25rem;
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
</style>

<script>
(function () {
    var target = new Date('2026-12-20T17:00:00+07:00').getTime();
    var dEl = document.getElementById('cd-days');
    var hEl = document.getElementById('cd-hours');
    var mEl = document.getElementById('cd-mins');
    var sEl = document.getElementById('cd-secs');

    function pad(n) { return n < 10 ? '0' + n : n; }

    function tick() {
        var now = Date.now();
        var diff = target - now;

        if (diff <= 0) {
            dEl.textContent = '00';
            hEl.textContent = '00';
            mEl.textContent = '00';
            sEl.textContent = '00';
            return;
        }

        var d = Math.floor(diff / 86400000);
        var h = Math.floor((diff % 86400000) / 3600000);
        var m = Math.floor((diff % 3600000) / 60000);
        var s = Math.floor((diff % 60000) / 1000);

        dEl.textContent = pad(d);
        hEl.textContent = pad(h);
        mEl.textContent = pad(m);
        sEl.textContent = pad(s);

        requestAnimationFrame(function () { setTimeout(tick, 1000); });
    }

    tick();
})();
</script>
