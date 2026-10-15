<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CPSU Student Self-Service Kiosk | Central Philippines State University</title>

    <!-- Favicon -->
    <link rel="icon" type="image/webp" href="{{ asset('uilibs/images/cpsulogov4.webp') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('uilibs/plugins/fontawesome-free-V6/css/all.min.css') }}">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('uilibs/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('uilibs/css/custom.css') }}">
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
                    <span class="fw-semibold text-body">Kiosk Active</span>
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
            </div>
        </div>
    </header>

    <!-- MAIN WELCOME HERO SECTION -->
    <main class="kiosk-hero-section">
        <div class="container py-2 py-md-4">
            <!-- Main Hero Card -->
            <div class="hero-banner-card mb-4 mb-lg-5">
                <div class="p-4 p-md-5">
                    <div class="row align-items-center g-4 g-lg-5">

                        <!-- Left Hero Content -->
                        <div class="col-lg-7">
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                <span class="kiosk-badge">
                                    <i class="ti ti-sparkles me-1 fs-6"></i> Welcome Cenphilians
                                </span>
                                <span class="kiosk-badge">
                                    <i class="ti ti-device-desktop me-1"></i> Self-Service Kiosk
                                </span>
                            </div>

                            <h1 class="hero-title mb-3">
                                Instant Access to <span class="text-cpsu">Student Records</span>.
                            </h1>

                            <p class="hero-subtitle mb-4">
                                Enter your details or sign in to instantly view your grades, access your class schedule, check application updates, and manage your student profile.
                            </p>

                            <!-- Primary Action Buttons: Get Started & Login Here -->
                            <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                                <!-- Get Started Button -->
                                <button type="button"
                                        class="btn btn-kiosk-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#getStartedModal">
                                    <i class="ti ti-rocket fs-4"></i>
                                    <span>Get Started</span>
                                </button>

                                <!-- Login Here Button -->
                                <button type="button"
                                        class="btn btn-kiosk-outline"
                                        data-bs-toggle="modal"
                                        data-bs-target="#loginModal">
                                    <i class="ti ti-login fs-4"></i>
                                    <span>Login Here</span>
                                </button>
                            </div>

                            <!-- RFID / ID Tap Quick Notice -->
                            <div class="rfid-strip">
                                <i class="ti ti-id-badge-2 fs-5"></i>
                                {{-- <span><strong>RFID / Student ID Ready:</strong> Tap your card or touch a service below to begin.</span> --}}
                            </div>
                        </div>

                        <!-- Right Hero Visual (2 and 2 side by side) -->
                        <div class="col-lg-5 text-center">
                            <div class="hero-graphic-wrap">
                                <div class="hero-graphic-circle"></div>

                                <!-- Left Badge 1: Track Admission Status -->
                                <div class="floating-pill pill-top-left">
                                    <i class="ti ti-certificate text-warning fs-5"></i>
                                    <span>View Grades</span>
                                </div>

                                <!-- Left Badge 2: View Grades -->
                                <div class="floating-pill pill-bottom-left">
                                    <i class="ti ti-id-badge-2 text-info fs-5"></i>
                                    <span>Track Admission Status</span>
                                </div>

                                <!-- Center: Student Mascot / Avatar -->
                                <img src="{{ asset('uilibs/images/student.png') }}"
                                     alt="CPSU Student"
                                     class="hero-student-img img-fluid"
                                     onerror="this.src='{{ asset('uilibs/images/usergreen.png') }}'">

                                <!-- Right Badge 1: View Class Schedule -->
                                <div class="floating-pill pill-top-right">
                                    <i class="ti ti-calendar-event text-success fs-5"></i>
                                    <span>View Class Schedule</span>
                                </div>

                                <!-- Right Badge 2: Campus Wifi -->
                                <div class="floating-pill pill-bottom-right">
                                    <i class="ti ti-wifi text-primary fs-5"></i>
                                    <span>Campus Wifi</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- MODAL: LOGIN HERE -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h2 class="modal-title h5 mb-0 fw-bold" id="loginModalLabel">
                            <i class="ti ti-login text-success me-1"></i> Student Kiosk Login
                        </h2>
                        <small class="text-muted" id="loginModalSubtitle">Sign in to access your student records</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <!-- Notification Banner inside modal -->
                    @php
                        $kioskLoginError = session('error') ?: ($errors->any() ? $errors->first() : null);
                        $kioskLoginSuccess = !$kioskLoginError ? session('success') : null;
                        $kioskLoginNotice = $kioskLoginError ?: $kioskLoginSuccess;
                    @endphp
                    <div id="loginFeedback"
                         class="alert py-2 px-3 small align-items-center gap-2 mb-3 {{ $kioskLoginNotice ? ($kioskLoginError ? 'alert-danger d-flex' : 'alert-success d-flex') : 'alert-info' }}"
                         @if (!$kioskLoginNotice) style="display: none !important;" @endif>
                        <i class="ti ti-info-circle fs-5"></i>
                        <span id="loginFeedbackText">{{ $kioskLoginNotice }}</span>
                    </div>

                    <!-- Login Form -->
                    <form id="kioskLoginForm" method="POST" action="{{ route('studkiosk_login') }}">
                        @csrf

                        <!-- Student ID -->
                        <div class="mb-3">
                            <label for="studentIdInput" class="form-label fw-bold small text-body mb-1">Student ID Number</label>
                            <div class="kiosk-input-wrap">
                                <i class="ti ti-id input-inner-icon"></i>
                                <input type="text"
                                       name="studid"
                                       id="studentIdInput"
                                       class="form-control @error('studid') is-invalid @enderror"
                                       placeholder="e.g. xxxx-xxxx-x"
                                       value="{{ old('studid') }}"
                                       required
                                       autocomplete="off"
                                       oninput="this.value = this.value.toUpperCase()">
                            </div>
                            @error('studid')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-muted" style="font-size: 0.73rem;">Tap the field to use the on-screen keypad</small>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="studentPassInput" class="form-label fw-bold small text-body mb-0">Password</label>
                            </div>
                            <div class="kiosk-input-wrap">
                                <i class="ti ti-lock input-inner-icon"></i>
                                <input type="password"
                                       name="password"
                                       id="studentPassInput"
                                       class="form-control has-toggle"
                                       placeholder="••••••••"
                                       required
                                       autocomplete="current-password"
                                       oninput="this.value = this.value.toUpperCase()">
                                <button type="button" class="input-inner-toggle" id="togglePasswordBtn" title="Show / Hide Password" aria-label="Toggle password visibility">
                                    <i class="ti ti-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Touch Options -->
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <span class="badge bg-body-tertiary border text-muted small">
                                <i class="ti ti-clock me-1"></i> Auto-logout: 2m
                            </span>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-kiosk-primary w-100 justify-content-center mb-3">
                            <i class="ti ti-login fs-5"></i>
                            <span>Sign In</span>
                        </button>
                    </form>
                </div>

                <div class="modal-footer bg-body-tertiary border-top justify-content-between p-3">
                    <small class="text-muted" style="font-size: 0.74rem;">
                        <i class="ti ti-info-circle me-1"></i> First time? Inquire at the MIS Desk.
                        <span class="d-block mt-1"><i class="ti ti-clock me-1"></i> This window closes after 1 min idle.</span>
                    </small>
                    <button type="button" class="btn btn-secondary rounded-2" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

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

    {{-- macOS dock-style touch keyboard for the Student ID field --}}
    @include('script.kiosk.kiosk-keyboard')

    <!-- Scripts -->
    <script src="{{ asset('uilibs/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('uilibs/js/main.js') }}"></script>
    <script src="{{ asset('uilibs/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
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

    <script>
    // Dedicated idle guard for the login modal: close it after
    // 2 minutes without any interaction inside it.
    (function () {
        const modalEl = document.getElementById('loginModal');
        const form = document.getElementById('kioskLoginForm');
        if (!modalEl) return;

        const IDLE_MS = 120000; // 2 minutes
        let idleTimer = null;

        const isOpen = () => modalEl.classList.contains('show');

        function closeIdleModal() {
            if (!isOpen() || typeof bootstrap === 'undefined') return;

            // 1. Properly hide via Bootstrap Modal Instance
            const inst = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            if (inst) inst.hide();

            // 2. Force-remove any remaining backdrops and unlock screen scrolling/touch
            setTimeout(() => {
                document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
                document.body.classList.remove('modal-open');
                document.body.style.removeProperty('overflow');
                document.body.style.removeProperty('padding-right');
            }, 350); // Wait for Bootstrap fade transition to finish

            // 3. Reset form and feedback fields
            if (form) form.reset();
            const feedback = document.getElementById('loginFeedback');
            const feedbackText = document.getElementById('loginFeedbackText');
            if (feedback) feedback.style.setProperty('display', 'none', 'important');
            if (feedbackText) feedbackText.textContent = '';
        }

        function armIdleTimer() {
            clearTimeout(idleTimer);
            idleTimer = setTimeout(closeIdleModal, IDLE_MS);
        }

        modalEl.addEventListener('shown.bs.modal', armIdleTimer);
        modalEl.addEventListener('hidden.bs.modal', () => clearTimeout(idleTimer));
        ['click', 'keydown', 'touchstart', 'input'].forEach((evt) => {
            modalEl.addEventListener(evt, () => { if (isOpen()) armIdleTimer(); }, { passive: true });
        });
    })();
</script>
</body>
</html>
