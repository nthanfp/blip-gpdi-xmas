<!-- Jquery -->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

<!-- Popper -->
<script type="text/javascript" src="<?php echo base_url('assets/plugins/popper/umd/popper.min.js'); ?>"></script>

<!-- Scroll to top button -->
<button type="button" id="scroll-top" aria-label="Kembali ke atas"
        class="fixed bottom-5 right-5 z-[999] w-11 h-11 rounded-full bg-gold-500 hover:bg-gold-600 text-red-950 shadow-lg shadow-black/30 flex items-center justify-center opacity-0 translate-y-3 pointer-events-none transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gold-400 focus:ring-offset-2 active:scale-95">
    <i class="fas fa-chevron-up text-sm"></i>
</button>

<script type="text/javascript">
    (function () {
        var btn = document.getElementById('scroll-top');
        if (!btn) return;

        function scrollContainer() {
            if (window.matchMedia('(min-width: 1024px)').matches) {
                var el = document.querySelector('.xmas-scroll');
                if (el) return el;
            }
            return null; /* mobile: window */
        }

        function scrollTop() {
            var c = scrollContainer();
            return c ? c.scrollTop : (window.pageYOffset || document.documentElement.scrollTop || 0);
        }

        function onScroll() {
            if (scrollTop() > 300) {
                btn.classList.remove('opacity-0', 'translate-y-3', 'pointer-events-none');
            } else {
                btn.classList.add('opacity-0', 'translate-y-3', 'pointer-events-none');
            }
        }

        window.addEventListener('scroll', onScroll, { passive: true });
        var panel = document.querySelector('.xmas-scroll');
        if (panel) panel.addEventListener('scroll', onScroll, { passive: true });
        onScroll();

        btn.addEventListener('click', function () {
            var c = scrollContainer();
            if (c) {
                c.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    })();
</script>

<!-- AOS trigger (IntersectionObserver) -->
<!-- aos.css dipertahankan untuk definisi animasi, tapi aos.js TIDAK dipakai:
     AOS mengecek posisi elemen via window.pageYOffset + window.innerHeight,
     sedangkan di desktop body di-overflow:hidden (yang di-scroll panel kanan),
     sehingga pageYOffset selalu 0 dan elemen di bawah lipatan panel
     tidak pernah dianggap "terlihat" → opacity 0 selamanya.
     IntersectionObserver bekerja untuk window scroll & panel scroll apa adanya. -->
<script type="text/javascript">
    (function () {
        var els = document.querySelectorAll('[data-aos]');
        if (!els.length) return;

        /* Fallback: tanpa IntersectionObserver → tampilkan semua */
        if (typeof IntersectionObserver === 'undefined') {
            Array.prototype.forEach.call(els, function (el) {
                el.classList.add('aos-animate');
            });
            return;
        }

        /* Attribut body dibutuhkan css aos untuk duration + easing */
        document.body.setAttribute('data-aos-duration', '650');
        document.body.setAttribute('data-aos-easing', 'ease-out-cubic');

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('aos-animate');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0, rootMargin: '0px 0px -60px 0px' });

        Array.prototype.forEach.call(els, function (el) {
            var delay = el.getAttribute('data-aos-delay');
            if (delay && !isNaN(delay)) {
                /* inline delay — css bawaan aos hanya punya kelipatan 50ms */
                el.style.transitionDelay = delay + 'ms';
            }
            io.observe(el);
        });
    })();
</script>

<!-- Loading Overlay -->
<script type="text/javascript" src="<?php echo base_url('assets/js/loadingoverlay.min.js'); ?>"></script>

<!-- CSRF: auto-include token in all AJAX POST -->
<script type="text/javascript">
    (function() {
        function getCookie(name) {
            var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? decodeURIComponent(match[2]) : null;
        }

        $(document).ajaxSend(function(e, xhr, settings) {
            if (settings.type.toUpperCase() !== 'POST') return;

            var tokenName = $('meta[name="csrf-token-name"]').attr('content') || 'csrf_test_name';
            var tokenValue = $('meta[name="csrf-token-value"]').attr('content') || getCookie('csrf_cookie_name');
            if (!tokenValue) {
                console.warn('[CSRF] Token not found, skipping');
                return;
            }

            if (settings.data instanceof FormData) {
                if (!settings.data.has(tokenName)) {
                    settings.data.append(tokenName, tokenValue);
                }
                return;
            }

            if (typeof settings.data === 'string') {
                if (settings.data.indexOf(tokenName + '=') !== -1) return;
                settings.data += '&' + tokenName + '=' + encodeURIComponent(tokenValue);
            } else if (settings.data) {
                settings.data[tokenName] = tokenValue;
            } else {
                settings.data = tokenName + '=' + encodeURIComponent(tokenValue);
            }
        });
    })();
</script>