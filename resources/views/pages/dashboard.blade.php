@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('body')
    <div class="container">
        <!-- QUICK KIOSK TOUCH SERVICES TILES -->
        <div class="mb-3 d-flex align-items-center justify-content-between">
            <div>
                <h2 class="h5 fw-bold mb-1">
                    <i class="ti ti-layout-grid text-success me-1"></i> Quick Services
                </h2>
                <small class="text-muted">Touch any service card below for direct self-service</small>
            </div>
            <span class="badge rounded-pill bg-body-tertiary border text-secondary px-3 py-2">
                3 Services Available
            </span>
        </div>

        <div class="row g-3">
            <!-- Tile 1: Grades & GWA -->
            <div class="col-12 col-sm-6 col-lg-4">
                <a href="{{ route('index.grades') }}">
                    <div class="service-tile" data-service="grades">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="tile-icon-box">
                                <i class="ti ti-certificate"></i>
                            </div>
                            <span class="badge bg-success-subtle border text-success">Available</span>
                        </div>
                        <div>
                            <h3 class="tile-title">Grades & Evaluation</h3>
                            <p class="tile-desc">View semester marks, subject remarks, and compute running GWA.</p>
                        </div>
                        <div class="mt-auto d-flex align-items-center text-success fw-semibold" style="font-size: 0.85rem;">
                            <span>Access Grades</span>
                            <i class="ti ti-arrow-right ms-1"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tile 2: Class Schedule -->
            <div class="col-12 col-sm-6 col-lg-4">
                <a href="{{ route('index.schedule') }}">
                    <div class="service-tile" data-service="schedule">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="tile-icon-box">
                                <i class="ti ti-calendar-event"></i>
                            </div>
                            <span class="badge bg-success-subtle border text-success">Available</span>
                        </div>
                        <div>
                            <h3 class="tile-title">Class Schedule & Rooms</h3>
                            <p class="tile-desc">Check your enrolled subjects, weekly schedule, instructors, and room assignments.</p>
                        </div>
                        <div class="mt-auto d-flex align-items-center text-success fw-semibold" style="font-size: 0.85rem;">
                            <span>Check Schedule</span>
                            <i class="ti ti-arrow-right ms-1"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tile 3: Campus Wifi -->
            <div class="col-12 col-sm-6 col-lg-4">
                <a href="{{ route('index.wifi') }}">
                    <div class="service-tile" data-service="cor">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="tile-icon-box">
                                <i class="ti ti-wifi"></i>
                            </div>
                            <span class="badge bg-success-subtle border text-success">Available</span>
                        </div>
                        <div>
                            <h3 class="tile-title">Campus WiFi</h3>
                            <p class="tile-desc">Connect to the campus wireless network and manage your student internet access.</p>
                        </div>
                        <div class="mt-auto d-flex align-items-center text-success fw-semibold" style="font-size: 0.85rem;">
                            <span>Generate Voucher Code</span>
                            <i class="ti ti-arrow-right ms-1"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tile 3: Certificate of Registration (COR) -->
            {{-- <div class="col-12 col-sm-6 col-lg-4">
                <div class="service-tile disabled" data-bs-toggle="modal" data-bs-target="#notavailableModal" data-service="cor">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="tile-icon-box">
                            <i class="ti ti-file-text"></i>
                        </div>
                        <span class="badge text-bg-warning-subtle text-warning-emphasis border">For Development</span>
                    </div>
                    <div>
                        <h3 class="tile-title">Certificate of Registration (COR)</h3>
                        <p class="tile-desc">Print your verified assessment slip and official enrollment form on this kiosk.</p>
                    </div>
                    <div class="mt-auto d-flex align-items-center text-success fw-semibold" style="font-size: 0.85rem;">
                        <span>Print COR</span>
                        <i class="ti ti-arrow-right ms-1"></i>
                    </div>
                </div>
            </div> --}}

            <!-- Tile 4: Admission & Application Tracking -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="service-tile disabled" data-bs-toggle="modal" data-bs-target="#notavailableModal">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="tile-icon-box">
                            <i class="ti ti-id-badge-2"></i>
                        </div>
                        <span class="badge text-bg-light border text-muted">For Development</span>
                    </div>
                    <div>
                        <h3 class="tile-title">Track Admission Status</h3>
                        <p class="tile-desc">Check applicant status, entrance exam results, and enrollment requirements.</p>
                    </div>
                    <div class="mt-auto d-flex align-items-center text-success fw-semibold" style="font-size: 0.85rem;">
                        <span>Track Application</span>
                        <i class="ti ti-arrow-right ms-1"></i>
                    </div>
                </div>
            </div>

            <!-- Tile 5: Campus Queue Token -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="service-tile disabled" data-bs-toggle="modal" data-bs-target="#notavailableModal">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="tile-icon-box">
                            <i class="ti ti-ticket"></i>
                        </div>
                        <span class="badge text-bg-light border text-muted">For Development</span>
                    </div>
                    <div>
                        <h3 class="tile-title">Queueing & Office Ticket</h3>
                        <p class="tile-desc">Generate priority queue number for Registrar, Cashier, Accounting, or Guidance.</p>
                    </div>
                    <div class="mt-auto d-flex align-items-center text-success fw-semibold" style="font-size: 0.85rem;">
                        <span>Get Ticket</span>
                        <i class="ti ti-arrow-right ms-1"></i>
                    </div>
                </div>
            </div>

            <!-- Tile 6: Student Clearance -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="service-tile disabled" data-bs-toggle="modal" data-bs-target="#notavailableModal" data-service="clearance">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="tile-icon-box">
                            <i class="ti ti-shield-check"></i>
                        </div>
                        <span class="badge text-bg-light border text-muted">FOr Development</span>
                    </div>
                    <div>
                        <h3 class="tile-title">Online Clearance</h3>
                        <p class="tile-desc">Check departmental clearance sign-offs, library returns, and account liabilities.</p>
                    </div>
                    <div class="mt-auto d-flex align-items-center text-success fw-semibold" style="font-size: 0.85rem;">
                        <span>Verify Clearance</span>
                        <i class="ti ti-arrow-right ms-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <!-- MODAL: WELCOME POP (auto-closes after 3 seconds) -->
        <div class="modal fade" id="welcomePopModal" tabindex="-1" aria-labelledby="welcomePopHeading" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
                <div class="modal-content text-center">
                    <div class="modal-body p-4">
                        <div class="tile-icon-box mx-auto mb-3" style="width: 64px; height: 64px; font-size: 2rem;">
                            <i class="ti ti-user-check"></i>
                        </div>
                        <h2 class="h5 fw-bold mb-1" id="welcomePopHeading">
                            Welcome, {{ $studauth->fname ?? 'Cenphilian' }}!
                        </h2>
                        <p class="text-muted small mb-0">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const el = document.getElementById('welcomePopModal');
                    if (el && typeof bootstrap !== 'undefined') {
                        const pop = new bootstrap.Modal(el);
                        pop.show();
                        setTimeout(function () { pop.hide(); }, 3000);
                    }
                });
            </script>
        @endpush
    @endif
@endsection
