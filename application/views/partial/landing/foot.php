<!-- Jquery -->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

<!-- Popper -->
<script type="text/javascript" src="<?php echo base_url('assets/plugins/popper/umd/popper.min.js'); ?>"></script>

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

<!-- Google tag (gtag.js) -->
<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZPVBY8YWG0"></script>
<script type="text/javascript">
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-ZPVBY8YWG0');
</script> -->