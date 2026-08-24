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

<!-- PWA: Service Worker Registration + Install Prompt -->
<script type="text/javascript">
    (function() {
        if (!('serviceWorker' in navigator)) return

        var deferredPrompt = null

        // 1. Capture beforeinstallprompt — defer + show banner
        window.addEventListener('beforeinstallprompt', function(e) {
            e.preventDefault()
            deferredPrompt = e
            showInstallBanner()
        })

        // 2. Register Service Worker
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('<?php echo base_url() . 'firebase-messaging-sw.js'; ?>')
                .then(function(reg) {
                    if (typeof firebase !== 'undefined' && firebase.initializeApp && firebase.messaging) {
                        var isSecure = location.protocol === 'https:' || location.hostname === 'localhost' || location.hostname === '127.0.0.1' || location.hostname === '[::1]'
                        if (!isSecure) {
                            console.info('[FCM] Skipped — HTTPS required for push notifications. Current:', location.protocol + '//' + location.hostname)
                            return
                        }

                        firebase.initializeApp(firebaseConfig)
                        var messaging = firebase.messaging()
                        var vapidKey = '<?php echo $this->config->item('fcm_vapid_key'); ?>'

                        messaging.getToken({
                            vapidKey: vapidKey,
                            serviceWorkerRegistration: reg
                        }).then(function(token) {
                            if (token) {
                                $.post('<?php echo site_url('activities/notification/save_token'); ?>', {
                                    token: token
                                })
                                console.log('[FCM] Token saved')
                            }
                        }).catch(function(err) {
                            console.warn('[FCM] getToken error:', err)
                        })

                        messaging.onMessage(function(payload) {
                            var title = (payload.notification && payload.notification.title) || payload.data.title || 'IG Admin'
                            var body = (payload.notification && payload.notification.body) || payload.data.body || ''
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: title,
                                text: body,
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true
                            })
                            if (typeof window.checkNotifications === 'function') window.checkNotifications()
                        })
                    }
                })
                .catch(function(err) {
                    console.warn('[FCM] SW register error:', err)
                })
        })

        // 3. Install banner
        function showInstallBanner() {
            if (localStorage.getItem('pwa-install-dismissed')) return

            Swal.fire({
                icon: 'info',
                html: '<div style="text-align:center;padding:8px 0">' +
                    '<i class="fas fa-rocket fa-3x text-primary mb-3"></i>' +
                    '<h5 style="font-weight:700;margin-bottom:6px">Install App</h5>' +
                    '<p style="font-size:14px;color:#6c757d;margin:0">Add Internal Gift to your home screen for faster access</p>' +
                    '</div>',
                showConfirmButton: true,
                showDenyButton: true,
                confirmButtonText: '<i class="fas fa-download mr-1"></i> Install',
                confirmButtonColor: '#007bff',
                denyButtonText: 'Not now',
                denyButtonColor: '#6c757d',
                footer: '<a href="#" id="pwa-skip-link" style="color:#adb5bd;font-size:13px">Don\'t show again</a>',
                customClass: {
                    popup: 'pwa-install-popup',
                    confirmButton: 'btn btn-primary px-4',
                    denyButton: 'btn btn-outline-secondary px-3 ml-2'
                },
                buttonsStyling: false,
                allowOutsideClick: false
            }).then(function(result) {
                if (result.isConfirmed) {
                    if (deferredPrompt) {
                        deferredPrompt.prompt()
                        deferredPrompt.userChoice.then(function(choice) {
                            if (choice.outcome === 'accepted') {
                                console.log('[PWA] User installed the app')
                            }
                            deferredPrompt = null
                        })
                    }
                }
            })

            document.addEventListener('click', function(e) {
                if (e.target && e.target.id === 'pwa-skip-link') {
                    e.preventDefault()
                    localStorage.setItem('pwa-install-dismissed', '1')
                    Swal.close()
                }
            })
        }

        // 4. Detect already installed — hide banner
        if (window.matchMedia('(display-mode: standalone)').matches) {
            console.log('[PWA] Running in standalone mode')
        }
    })()
</script>

<!-- Push Notification Polling -->
<script type="text/javascript">
    (function() {
        var csrfName = $('meta[name="csrf-token-name"]').attr('content') || 'csrf_test_name'
        var csrfToken = $('meta[name="csrf-token-value"]').attr('content')

        function csrfData(extra) {
            var d = extra || {};
            if (csrfToken) d[csrfName] = csrfToken;
            return d
        }

        var notifEndpoint = '<?php echo site_url('activities/notification/check'); ?>'
        var markAllEndpoint = '<?php echo site_url('activities/notification/mark_all_read'); ?>'
        var prevCount = 0
        var pollTimer = null
        var isChecking = false

        function escapeHtml(val) {
            return $('<div>').text(val == null ? '' : String(val)).html()
        }


        function updateBadge(count) {
            var $badge = $('#notifBadge')
            if (count > 0) {
                $badge.text(count > 99 ? '99+' : count).removeClass('d-none')
            } else {
                $badge.addClass('d-none')
            }
        }

        function updateDropdown(items) {
            var $list = $('#notifList')
            var $subtitle = $('#notifSubtitle')

            if (!items || !items.length) {
                $list.html('<div class="dropdown-item text-muted text-center py-3 small">No notifications</div>')
                $subtitle.text('0 unread')
                return
            }

            $subtitle.text($('#notifBadge').text() + ' unread')
            var html = ''
            items.forEach(function(n) {
                var dotClass = n.is_read == 1 ? 'text-muted' : 'text-success'
                html +=
                    '<div class="dropdown-item border-bottom px-3 py-2">' +
                    '<div class="d-flex align-items-start">' +
                    '<i class="fas fa-circle ' + dotClass + ' mt-1 mr-2" style="font-size:8px"></i>' +
                    '<div class="flex-grow-1" style="min-width:0">' +
                    '<strong class="d-block text-truncate" style="font-size:13px">' + escapeHtml(n.title || '') + '</strong>' +
                    '<span class="d-block text-muted text-truncate" style="font-size:12px">' + escapeHtml(n.message || '') + '</span>' +
                    '<small class="text-muted" style="font-size:11px">' + escapeHtml(formatDate(n.created_date)) + '</small>' +
                    '</div></div></div>'
            })
            $list.html(html)
        }

        function showToastNotification(items) {
            var latest = items[0]
            if (!latest) return
            var icon = latest.type === 'redeem' ? 'success' : 'info'
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: latest.title,
                text: latest.message,
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            })
            if ('Notification' in window && Notification.permission === 'granted') {
                try {
                    var n = new Notification(latest.title, {
                        body: latest.message,
                        icon: '<?php echo base_url('assets/icons/android-chrome-192x192.png'); ?>',
                        tag: 'itg-notif',
                        renotify: false
                    })
                    setTimeout(function() {
                        n.close()
                    }, 6000)
                } catch (_) {}
            }
        }

        function checkNotifications() {
            if (isChecking) return
            isChecking = true
            $.getJSON(notifEndpoint)
                .done(function(res) {
                    if (!res.success || !res.data) return
                    if (!res.data.enabled) {
                        updateBadge(0);
                        return
                    }
                    var count = Number(res.data.count) || 0
                    var items = res.data.items || []
                    updateBadge(count)
                    updateDropdown(items)
                    if (count > prevCount && count > 0 && prevCount > 0) {
                        showToastNotification(items)
                    }
                    prevCount = count
                })
                .fail(function() {
                    updateBadge(0)
                    if (pollTimer) {
                        clearInterval(pollTimer);
                        pollTimer = null
                    }
                })
                .always(function() {
                    isChecking = false
                })
        }
        window.checkNotifications = checkNotifications

        function requestNotificationPermission() {
            if ('Notification' in window && Notification.permission === 'default') {
                Notification.requestPermission()
            }
        }

        $('#notifMarkAllRead').on('click', function(e) {
            e.preventDefault()
            e.stopPropagation()
            $.post(markAllEndpoint, csrfData()).done(function() {
                prevCount = 0
                isChecking = false
                checkNotifications()
                $('#notifDropdown > a').dropdown('show')
            })
        })

        $('#notifTestPush').on('click', function(e) {
            e.preventDefault()
            var $btn = $(this)
            $btn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Sending...')
            $.post('<?php echo site_url('activities/notification/test_push'); ?>', csrfData())
                .done(function(res) {
                    if (res.success) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Sent!',
                            text: res.message,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        })
                    } else {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Failed',
                            text: res.message,
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true
                        })
                    }
                })
                .fail(function() {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Error',
                        text: 'Could not reach server',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true
                    })
                })
                .always(function() {
                    $btn.html('<i class="fas fa-paper-plane mr-1"></i> Test Push')
                })
        })

        $('#notifDropdown').on('show.bs.dropdown', function() {
            checkNotifications()
        })
        $(document).on('visibilitychange', function() {
            if (!document.hidden) checkNotifications()
        })

        requestNotificationPermission()
        checkNotifications()
        pollTimer = setInterval(checkNotifications, 15000)
    })()
</script>

<script src="https://cdn.jsdelivr.net/npm/eruda"></script>
<script type="text/javascript">
    eruda.init();
</script>