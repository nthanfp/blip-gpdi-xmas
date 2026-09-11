<!-- Countdown Section -->
<section class="py-20 sm:py-28 px-5 sm:px-8 bg-red-950">
    <div class="max-w-md mx-auto text-center space-y-8">

        <!-- Eyebrow -->
        <div class="space-y-4">
            <p class="text-[11px] font-semibold tracking-[0.25em] uppercase text-amber-400">
                Countdown
            </p>
            <h2 class="text-2xl sm:text-3xl font-bold text-white leading-snug">
            Menuju Perayaan Natal
            </h2>
        </div>

        <!-- Countdown boxes -->
        <div class="flex justify-center gap-3 sm:gap-4" id="xmas-countdown">

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
            24 Desember 2026 · 18:00 WIB
        </p>

    </div>
</section>

<style>
    .countdown-box {
        @apply flex flex-col items-center justify-center w-16 h-20 sm:w-20 sm:h-24 rounded-xl bg-red-900/50 border border-amber-400/20;
    }
    .countdown-num {
        @apply text-2xl sm:text-3xl font-bold text-amber-400 font-heading;
    }
    .countdown-label {
        @apply text-[10px] sm:text-xs font-medium text-stone-400 uppercase tracking-wider mt-1;
    }
</style>

<script>
(function () {
    var target = new Date('2026-12-24T18:00:00+07:00').getTime();
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
