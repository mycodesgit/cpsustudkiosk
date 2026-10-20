@extends('layouts.app')

@section('title')
    Campus WiFi
@endsection

@section('body')
    <div class="container">
        <div class="mb-3 d-flex align-items-center justify-content-between">
            <div>
                <h2 class="h5 fw-bold mb-1">
                    <i class="ti ti-wifi text-success me-1"></i> Campus WiFi
                </h2>
                <small class="text-muted">Generate Campus WiFi Voucher Code per semester in every academic year.</small>
            </div>
            <a href="{{ route('kioskhome') }}" class="rounded-pill bg-body-secondary border text-secondary px-3 py-2">
                <i class="ti ti-arrow-back text-success me-1"></i> Go back to Main
            </a>
        </div>

        <div class="row g-3">
            <div class="col-md-12">
                <div class="card shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="row g-4 align-items-start">
                            <div class="col-lg-7">
                                <h3 class="h6 fw-bold mb-3">
                                    <i class="ti ti-list-checks text-success me-1"></i> How to get your voucher
                                </h3>
                                <ol class="mb-0 ps-3 d-flex flex-column gap-2 text-body" style="font-size: 0.92rem;">
                                    <li>Tap the <strong>Generate Voucher</strong> button below.</li>
                                    <li>Your voucher code pops up in a window — keep it or write it down.</li>
                                    <li>On your device, connect to the <strong>CampusWiFi</strong> network and enter the code when asked.</li>
                                    <li>One voucher per student every semester. Each code works only once.</li>
                                </ol>
                            </div>
                            <div class="col-lg-5">
                                <div class="p-3 border rounded-3 bg-body-tertiary text-center">
                                    <small class="text-muted d-block mb-1">Current semester</small>
                                    <div class="fw-bold mb-1">
                                        {{ $term['schlyear'] ?? '—' }}
                                        @if (isset($term['semester']))
                                            • @if ($term['semester'] == 1) 1st Sem @elseif ($term['semester'] == 2) 2nd Sem @elseif ($term['semester'] == 3) Summer @endif
                                        @endif
                                    </div>
                                    <small class="text-muted d-block mb-3">{{ $studauth->lname ?? '' }}, {{ $studauth->fname ?? '' }} • {{ $studauth->stud_id ?? '' }}</small>

                                    @if ($existing && $existing->voucher)
                                        <div class="alert alert-success py-2 px-3 small mb-3">
                                            You already claimed a voucher this semester.
                                        </div>
                                        <button type="button" class="btn btn-kiosk-primary w-100 justify-content-center" id="viewVoucherBtn">
                                            <i class="ti ti-ticket fs-5"></i><span>View My Voucher</span>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-kiosk-primary w-100 justify-content-center" id="generateVoucherBtn">
                                            <i class="ti ti-ticket fs-5"></i><span>Generate Voucher</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: WIFI VOUCHER CODE -->
    <div class="modal fade" id="voucherModal" tabindex="-1" aria-labelledby="voucherModalHeading" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <div class="w-100">
                        <h2 class="modal-title h5 mb-0 fw-bold" id="voucherModalHeading">
                            <i class="ti ti-wifi text-success me-1"></i> Your WiFi Voucher
                        </h2>
                        <small class="text-muted" id="voucherModalSubtitle"></small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="voucherLoading" class="py-4" style="display: none;">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted small mt-2 mb-0" id="voucherLoadingText">Generating your code...</p>
                    </div>
                    <div id="voucherEmpty" class="py-4" style="display: none;">
                        <div class="mb-2">
                            <i class="ti ti-alert-circle text-warning" style="font-size: 2rem;"></i>
                        </div>
                        <p class="mb-0" id="voucherEmptyText">No voucher code at this A.Y. and Semester.</p>
                    </div>
                    <div id="voucherCodeWrap" style="display: none;">
                        <small class="text-muted d-block mb-2">Enter this code on the CampusWiFi login page</small>
                        <div class="p-3 border rounded-3 bg-body-tertiary mb-3">
                            <span id="voucherCode" class="fw-bold font-monospace user-select-all" style="font-size: 1.6rem; letter-spacing: 0.08em;"></span>
                        </div>
                        <div class="alert alert-warning py-2 px-3 small mb-0" id="voucherFreshNote" style="display: none;">
                            Keep this code — it is single-use and tied to your student ID.
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-body-tertiary border-top justify-content-center">
                    <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            const semLabel = { 1: '1st Sem', 2: '2nd Sem', 3: 'Summer' };
            const termSchlyear = @json($term['schlyear'] ?? '');
            const termSemester = @json($term['semester'] ?? '');

            const voucherModalEl = document.getElementById('voucherModal');
            const voucherModal = new bootstrap.Modal(voucherModalEl);

            function showVoucher(code, fresh) {
                $('#voucherLoading').hide();
                $('#voucherEmpty').hide();
                $('#voucherCode').text(code);
                $('#voucherFreshNote').toggle(!!fresh);
                $('#voucherModalSubtitle').text(
                    termSchlyear + (termSemester !== '' ? ' • ' + (semLabel[termSemester] || '') : '')
                );
                $('#voucherCodeWrap').show();
                voucherModal.show();
            }

            function showVoucherEmpty(message) {
                $('#voucherLoading').hide();
                $('#voucherCodeWrap').hide();
                $('#voucherEmptyText').text(message || 'No voucher code at this A.Y. and Semester.');
                $('#voucherModalSubtitle').text(
                    termSchlyear + (termSemester !== '' ? ' • ' + (semLabel[termSemester] || '') : '')
                );
                $('#voucherEmpty').show();
                voucherModal.show();
            }

            $('#generateVoucherBtn').on('click', function () {
                const btn = $(this);
                btn.prop('disabled', true);
                $('#voucherCodeWrap').hide();
                $('#voucherEmpty').hide();
                $('#voucherLoadingText').text('Generating your code...');
                $('#voucherLoading').show();
                voucherModal.show();

                $.ajax({
                    url: '{{ route('wifi.voucher.generate') }}',
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        btn.prop('disabled', false);
                        showVoucher(response.voucher_code, response.fresh);
                    },
                    error: function (xhr) {
                        btn.prop('disabled', false);
                        const msg = xhr.responseJSON && xhr.responseJSON.message
                            ? xhr.responseJSON.message
                            : 'Unable to generate a voucher right now.';
                        showVoucherEmpty(msg);
                        toastr.error(msg);
                    }
                });
            });

            $('#viewVoucherBtn').on('click', function () {
                const btn = $(this);
                btn.prop('disabled', true);
                $('#voucherCodeWrap').hide();
                $('#voucherEmpty').hide();
                $('#voucherLoadingText').text('Loading your voucher...');
                $('#voucherLoading').show();
                voucherModal.show();

                $.ajax({
                    url: '{{ route('wifi.voucher.mine') }}',
                    method: 'GET',
                    success: function (response) {
                        btn.prop('disabled', false);
                        showVoucher(response.voucher_code, false);
                    },
                    error: function (xhr) {
                        btn.prop('disabled', false);
                        const msg = xhr.responseJSON && xhr.responseJSON.message
                            ? xhr.responseJSON.message
                            : 'Unable to load your voucher right now.';
                        showVoucherEmpty(msg);
                        toastr.error(msg);
                    }
                });
            });
        });
    </script>
@endpush
