<!-- Jquery -->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

<!-- Popper -->
<script type="text/javascript" src="<?php echo base_url('assets/plugins/popper/umd/popper.min.js'); ?>"></script>

<!-- Admin LTE JS -->
<script type="text/javascript" src="<?php echo base_url('assets/js/adminlte.min.js'); ?>"></script>

<!-- Bootstrap Bundle -->
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>

<!-- Bootstrap Select -->
<script type="text/javascript" src="<?php echo base_url('assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js'); ?>"></script>

<!-- SweetAlert2 -->
<script type="text/javascript" src="<?php echo base_url('assets/plugins/sweetalert2/sweetalert2.min.js'); ?>"></script>

<!-- Loading Overlay -->
<script type="text/javascript" src="<?php echo base_url('assets/js/loadingoverlay.min.js'); ?>"></script>

<!-- ChartJS -->
<script type="text/javascript" src="<?php echo base_url('assets/plugins/chart.js/Chart.min.js'); ?>"></script>

<!-- Shared Utilities -->
<script type="text/javascript" src="<?php echo base_url('assets/js/helpers/dateFormat.js'); ?>"></script>

<!-- Firebase SDK -->
<script src="https://www.gstatic.com/firebasejs/10.13.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.13.0/firebase-messaging-compat.js"></script>
<script src="<?php echo base_url('firebase-config.js'); ?>"></script>

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


<!-- Android back button → close modal -->
<script type="text/javascript">
    (function() {
        var modalHistoryPushed = false;

        $(document).on('shown.bs.modal', function() {
            if (!modalHistoryPushed) {
                history.pushState({
                    modal: true
                }, '');
                modalHistoryPushed = true;
            }
        });

        $(window).on('popstate', function() {
            if (modalHistoryPushed) {
                modalHistoryPushed = false;
                $('.modal.show').modal('hide');
            }
        });
    })();
</script>

<!-- Get Current DB -->
<script type="text/javascript">
    (function() {
        var dbListEndpoint = '<?= site_url("activities/authentication/get_databases") ?>'
        var currentDB = '<?= $this->session->userdata("selected_database") ?: "" ?>'

        function loadDBNav() {
            if (typeof $ === 'undefined') return
            $.getJSON(dbListEndpoint)
                .done(function(res) {
                    if (!res.success || !res.data || !res.data.length) return

                    var $dbSelector = $('#dbSelectorNavbar')
                    if (!$dbSelector.length) return

                    var $currentDBName = $('#currentDBName')

                    $dbSelector.show()

                    var displayName = currentDB
                    res.data.forEach(function(db) {
                        if (db.name === currentDB) {
                            displayName = db.name
                        }
                    })
                    $currentDBName.text(displayName || res.data[0].display)
                })
        }

        $(document).ready(function() {
            loadDBNav()
        })
    })()
</script>