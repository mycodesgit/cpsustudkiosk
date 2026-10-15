<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <title>@yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('uilibs/images/cpsulogov4.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('uilibs/images/cpsulogov4.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('uilibs/images/cpsulogov4.png') }}">

    <link rel="stylesheet" href="{{ asset('uilibs/css/main.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('uilibs/css/custom.css') }}?v={{ time() }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('uilibs/plugins/fontawesome-free-V6/css/all.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('uilibs/plugins/toastr/toastr.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('uilibs/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('uilibs/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('uilibs/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('uilibs/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- DataTables  -->
    <link rel="stylesheet" href="{{ asset('uilibs/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('uilibs/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('uilibs/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{ asset('uilibs/plugins/fullcalendar/fullcalendar.css') }}">
    @stack('styles')
</head>
<body>

    <!-- TOP BRAND & TERMINAL BAR -->
    <header class="kiosk-navbar sticky-top py-2 px-3 px-md-4">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <!-- Brand Info -->
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('uilibs/images/cpsulogov4.webp') }}"
                     alt="CPSU Logo"
                     class="brand-logo-img"
                     onerror="this.src='{{ asset('uilibs/images/cpsulogov4.png') }}'">
                <div class="d-none d-sm-block">
                    <h1 class="h6 mb-0 fw-bold text-uppercase tracking-tight">Central Philippines State University</h1>
                    <small class="text-muted d-block" style="font-size: 0.78rem;">Student Self-Service Kiosk Terminal</small>
                </div>
            </div>

            <!-- Terminal Info & Utilities -->
            <div class="d-flex align-items-center gap-3 gap-md-4">
                <!-- Clock -->
                <div class="d-none d-md-flex align-items-center gap-2 text-muted" style="font-size: 0.85rem;">
                    <i class="ti ti-clock text-success fs-5"></i>
                    <div>
                        <span id="kioskClock" class="fw-bold text-body">--:--:-- --</span>
                        <span id="kioskDate" class="d-block text-secondary" style="font-size: 0.72rem;">Loading date...</span>
                    </div>
                </div>

                <!-- Live Status Indicator -->
                <div class="d-flex align-items-center gap-2 bg-body-tertiary px-3 py-1 rounded-pill border" style="font-size: 0.8rem;">
                    <span class="status-pulse"></span>
                    <span class="fw-semibold text-body">
                        @if (Auth::guard('kioskstudent')->check())
                            {{ Auth::guard('kioskstudent')->user()->studid }}
                            @if (!empty($studinfo))
                                | {{ $studinfo->fname }} {{ !empty($studinfo->mname) ? substr($studinfo->mname, 0, 1) . '.' : '' }} {{ $studinfo->lname }}
                            @endif
                        @else
                            Guest
                        @endif
                    </span>
                </div>

                <!-- Light / Dark Theme Switcher -->
                <div class="d-flex align-items-center">
                    <label class="theme-switch" title="Toggle Theme">
                        <input type="checkbox" id="themeToggle" aria-label="Toggle Dark Mode">
                        <span class="slider">
                            <span class="slider-content">
                                <i id="themeIcon" class="ti ti-sun"></i>
                                <span id="themeLabel">Light</span>
                            </span>
                        </span>
                    </label>
                </div>

                <!-- Logout -->
                <div class="d-flex align-items-center">
                    <a href="{{ route('kiosk.logout') }}" class="text-danger">
                        <i class="ti ti-logout"></i><span> Signout</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- MAIN WELCOME HERO SECTION -->
    <main class="kiosk-hero-section-services">
        @yield('body')
    </main>

    <!-- KIOSK FOOTER -->
    <footer class="kiosk-footer">
        <div class="container text-center">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('uilibs/images/cpsulogov4.webp') }}"
                         alt="CPSU"
                         width="26"
                         height="26"
                         onerror="this.src='{{ asset('uilibs/images/cpsulogov4.png') }}'">
                    <span>&copy; {{ date('Y') }} Central Philippines State University. All rights reserved.</span>
                </div>
                <div class="d-flex align-items-center gap-3" style="font-size: 0.8rem;">
                    <span><i class="ti ti-map-pin me-1 text-success"></i> Main Campus, Kabankalan City</span>
                    <span>•</span>
                    <span><i class="ti ti-shield me-1 text-success"></i> MIS Terminal System</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('uilibs/js/main.js') }}"></script>
    <!-- Bootstrap Bundle (modals) -->
    <script src="{{ asset('uilibs/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- jQuery -->
    <script src="{{ asset('uilibs/plugins/jquery/jquery.min.js') }}"></script>

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('uilibs/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('uilibs/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('uilibs/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('uilibs/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('uilibs/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('uilibs/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('uilibs/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('uilibs/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('uilibs/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('uilibs/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('uilibs/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('uilibs/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- fullCalendar 2.2.5 -->
    <script src="{{ asset('uilibs/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('uilibs/plugins/fullcalendar/fullcalendar.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('uilibs/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('uilibs/plugins/toastr/toastr.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('uilibs/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('uilibs/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('uilibs/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Validation JS -->
    <script src="{{ asset('uilibs/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('uilibs/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- Theme -->
    <script src="{{ asset('uilibs/js/theme.js') }}"></script>

    <script>
        // Open the login modal directly (e.g. /?login=1) or re-open it
        // if the last login attempt failed or just logged out.
        @if (session('error') || session('success') || $errors->any() || request()->query('login'))
            document.addEventListener('DOMContentLoaded', function () {
                const loginModalEl = document.getElementById('loginModal');
                if (loginModalEl && typeof bootstrap !== 'undefined') {
                    bootstrap.Modal.getOrCreateInstance(loginModalEl).show();
                }
            });
        @endif
    </script>

    <script>
        // Real-time Digital Clock
        function updateKioskClock() {
            const now = new Date();
            const timeEl = document.getElementById('kioskClock');
            const dateEl = document.getElementById('kioskDate');

            if (timeEl) {
                timeEl.textContent = now.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                });
            }

            if (dateEl) {
                dateEl.textContent = now.toLocaleDateString('en-US', {
                    weekday: 'long',
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                });
            }
        }
        setInterval(updateKioskClock, 1000);
        updateKioskClock();

        // Password Visibility Toggle
        const togglePasswordBtn = document.getElementById('togglePasswordBtn');
        const showKioskPassword = document.getElementById('showKioskPassword');
        const passwordInput = document.getElementById('studentPassInput');
        const togglePasswordIcon = document.getElementById('togglePasswordIcon');

        function setKioskPasswordVisible(visible) {
            if (!passwordInput) return;
            passwordInput.setAttribute('type', visible ? 'text' : 'password');
            if (togglePasswordIcon) {
                togglePasswordIcon.className = visible ? 'ti ti-eye-off' : 'ti ti-eye';
            }
            if (showKioskPassword && showKioskPassword.checked !== visible) {
                showKioskPassword.checked = visible;
            }
        }

        if (togglePasswordBtn && passwordInput) {
            togglePasswordBtn.addEventListener('click', function () {
                setKioskPasswordVisible(passwordInput.getAttribute('type') === 'password');
            });
        }

        if (showKioskPassword && passwordInput) {
            showKioskPassword.addEventListener('change', function () {
                setKioskPasswordVisible(showKioskPassword.checked);
            });
        }

        // Contextual Modal Titles when clicked from service tiles
        const loginModal = document.getElementById('loginModal');
        if (loginModal) {
            loginModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const service = button ? button.getAttribute('data-service') : null;
                const subtitle = document.getElementById('loginModalSubtitle');

                if (service === 'grades') {
                    subtitle.textContent = 'Sign in to evaluate and view your semester grades';
                } else if (service === 'schedule') {
                    subtitle.textContent = 'Sign in to view your class schedule & room assignments';
                } else if (service === 'cor') {
                    subtitle.textContent = 'Sign in to verify and print your official COR';
                } else if (service === 'clearance') {
                    subtitle.textContent = 'Sign in to inspect your student clearance checklist';
                } else {
                    subtitle.textContent = 'Sign in to access your student records';
                }
            });
        }

        // RFID Tap Simulation for Kiosk Demo
        function simulateRfidTap() {
            const feedback = document.getElementById('loginFeedback');
            const feedbackText = document.getElementById('loginFeedbackText');
            const studentIdInput = document.getElementById('studentIdInput');

            // Open login modal if not already open
            if (typeof bootstrap !== 'undefined') {
                const loginModalInstance = bootstrap.Modal.getOrCreateInstance(document.getElementById('loginModal'));
                loginModalInstance.show();
            }

            if (feedback && feedbackText) {
                feedback.style.setProperty('display', 'flex', 'important');
                feedback.className = 'alert alert-warning py-2 px-3 small d-flex align-items-center gap-2 mb-3';
                feedbackText.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Reading RFID Card from kiosk reader...';

                setTimeout(() => {
                    if (studentIdInput) {
                        studentIdInput.value = '2024-CPSU-08492';
                    }
                    feedback.className = 'alert alert-success py-2 px-3 small d-flex align-items-center gap-2 mb-3';
                    feedbackText.innerHTML = '<i class="ti ti-check fs-5"></i> RFID Card Verified: <strong>Student ID 2024-CPSU-08492</strong>. Enter PIN to proceed.';
                }, 1200);
            }
        }

        // Admission Tracking Demo
        function simulateTracking() {
            const ref = document.getElementById('trackingRef').value;
            const res = document.getElementById('trackingResult');
            if (!ref.trim()) {
                alert('Please enter your Application Reference Number.');
                return;
            }
            res.style.display = 'block';
        }

        // Queue Ticket Demo
        function printQueueTicket(department) {
            const res = document.getElementById('queueResult');
            const num = document.getElementById('ticketNumber');
            const prefix = department === 'REGISTRAR' ? 'R' : (department === 'CASHIER' ? 'C' : 'G');
            const randomId = Math.floor(100 + Math.random() * 900);
            num.textContent = `TICKET #${prefix}-${randomId} (${department})`;
            res.style.display = 'block';
        }

        // Auto Inactivity Reset (2 minutes idle protection on public kiosk)
        let idleTimer;
        function resetIdleTimer() {
            clearTimeout(idleTimer);
            idleTimer = setTimeout(() => {
                // If modals are open, close them to protect privacy
                const openModals = document.querySelectorAll('.modal.show');
                openModals.forEach(m => {
                    if (typeof bootstrap !== 'undefined') {
                        const inst = bootstrap.Modal.getInstance(m);
                        if (inst) inst.hide();
                    }
                });
                const form = document.getElementById('kioskLoginForm');
                if (form) form.reset();
            }, 120000); // 2 minutes
        }
        ['touchstart', 'mousemove', 'click', 'keydown', 'scroll'].forEach(evt => {
            window.addEventListener(evt, resetIdleTimer, false);
        });
        resetIdleTimer();
    </script>
    @stack('scripts')
</body>
</html>
