<!-- Countdown Section -->
<section class="py-20 sm:py-28 px-5 sm:px-8 bg-red-950">
    <div class="max-w-md lg:max-w-lg mx-auto text-center space-y-8">

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
        border: 1px solid rgba(212, 175, 55, 0.2);
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
