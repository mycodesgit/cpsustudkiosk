@extends('layouts.app')

@section('title')
    View Grades
@endsection

@section('body')
    <div class="container">
        <!-- QUICK KIOSK TOUCH SERVICES TILES -->
        <div class="mb-3 d-flex align-items-center justify-content-between">
            <div>
                <h2 class="h5 fw-bold mb-1">
                    <i class="ti ti-layout-grid text-success me-1"></i> View Class Schedule
                </h2>
                <small class="text-muted">Class Schedule per semester in every academic year.</small>
            </div>
            <a href="{{ route('kioskhome') }}" class="rounded-pill bg-body-secondary border text-secondary px-3 py-2">
                <i class="ti ti-arrow-back text-success me-1"></i> Go back to Main
            </a>
        </div>

        <div class="row g-3">
            <div class="col-md-12">
                <div class="card shadow-sm rounded-4 mb-4">
                    <div class="card-body">
                        <div class="table-responsive p-2">
                            <table id="ss" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>A.Y. Semester</th>
                                        <th>Course Yr&Section</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($enrollmentHistory as $history)
                                        <tr>
                                            <td>{{ $history->schlyear }}
                                                @if($history->semester == 1)
                                                    <span class="badge bg-primary">1st Sem</span>
                                                @elseif($history->semester == 2)
                                                    <span class="badge bg-success">2nd Sem</span>
                                                @elseif($history->semester == 3)
                                                    <span class="badge bg-secondary">Summer</span>
                                                @endif
                                            </td>
                                            <td>{{ $history->progAcronym }} {{ $history->studYear }}-{{ $history->studSec }}</td>
                                            <td>
                                                <button type="button"
                                                        class="btn btn-outline-success btn-sm view-sched-btn"
                                                        data-schlyear="{{ $history->schlyear }}"
                                                        data-semester="{{ $history->semester }}"
                                                        data-progcod="{{ $history->progCod . '+' . $history->studYear . '-' . $history->studSec }}"
                                                        data-prog="{{ $history->progAcronym }} {{ $history->studYear }}-{{ $history->studSec }}">
                                                    View Sched
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: CLASS SCHEDULE -->
    <div class="modal fade" id="schedModal" tabindex="-1" aria-labelledby="schedModalHeading" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h2 class="modal-title h5 mb-0 fw-bold" id="schedModalHeading">Student Class Schedule</h2>
                        <small class="text-muted">Weekly class grid for the selected semester</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="breadcrumb" style="font-size: 13pt">
                                        <span>Course: <span id="schedCourse">Not Available</span>,</span>
                                        <span class="ml-2">School Year: <span id="schedYear"></span>,</span>
                                        <span class="ml-2">Semester: <span id="schedSem"></span></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="breadcrumb">
                                        <button type="button" id="refreshSchedule" class="btn btn-success btn-sm" style="font-size: 9pt">
                                            <i class="fas fa-sync"></i> Refresh Schedule
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="schedModalLoading" class="text-center py-5" style="display: none;">
                                <div class="spinner-border text-success" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="text-muted small mt-2 mb-0">Loading schedule...</p>
                            </div>
                            <div id="schedModalEmpty" class="alert alert-info mb-0" style="display: none;">
                                No schedule plotted for this semester yet.
                            </div>
                            <div class="table-responsive" id="schedule-grid"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-body-tertiary border-top">
                    <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            const days = @json($days ?? []);
            const times = @json($times ?? []);
            const semLabel = { 1: '1st Sem', 2: '2nd Sem', 3: 'Summer' };

            const schedModalEl = document.getElementById('schedModal');
            const schedModal = new bootstrap.Modal(schedModalEl);

            let current = { schlyear: '', semester: '', progCod: '' };

            if ($('#ss').length && $.fn.DataTable) {
                $('#ss').DataTable({ responsive: true, autoWidth: false });
            }

            function buildGrid() {
                let grid = '<table class="table table-bordered schedule-table mb-0"><thead><tr><th class="kiosk-sched-head">Time</th>';
                days.forEach((day) => {
                    grid += `<th class="day-label text-center kiosk-sched-head">${day}</th>`;
                });
                grid += '</tr></thead><tbody>';
                times.forEach((time) => {
                    grid += `<tr><td class="time-label text-left kiosk-sched-time" width="10%">${time}</td>`;
                    days.forEach((day) => {
                        grid += `<td class="time-slot kiosk-sched-cell" data-day="${day}" data-time="${time}"></td>`;
                    });
                    grid += '</tr>';
                });
                return grid + '</tbody></table>';
            }

            function mergeCells($container) {
                days.forEach((day) => {
                    let prevCell = null;
                    let rowspanCount = 1;
                    times.forEach((time) => {
                        const currentCell = $container.find(`.time-slot[data-day="${day}"][data-time="${time}"]`);
                        if (!currentCell.length) return;
                        const currentText = currentCell.html();
                        if (prevCell && currentText && prevCell.html().trim() === currentText.trim() && currentText.trim() !== '') {
                            rowspanCount++;
                            prevCell.attr('rowspan', rowspanCount);
                            currentCell.remove();
                            prevCell.css('background-color', '#d9edf7');
                        } else {
                            prevCell = currentCell;
                            rowspanCount = 1;
                        }
                    });
                });
                $container.find('table td').css({ 'text-align': 'center', 'padding': '10px', 'vertical-align': 'middle' });
            }

            function loadSchedule() {
                const $grid = $('#schedule-grid');
                $grid.empty();
                $('#schedModalEmpty').hide();
                $('#schedModalLoading').show();

                $.ajax({
                    url: '{{ route('fetchSchedule') }}',
                    method: 'GET',
                    data: { schlyear: current.schlyear, semester: current.semester, progCod: current.progCod },
                    success: function (response) {
                        $('#schedModalLoading').hide();
                        if (!response || response.length === 0) {
                            $('#schedModalEmpty').show();
                            return;
                        }
                        $grid.html(buildGrid());
                        response.forEach(function (item) {
                            const subjectInfo = `${item.sub_name ?? ''} ${item.subSec ?? ''} ${item.lname ?? ''}, ${item.room_name ?? ''} ${item.remarks ?? ''}`;
                            const start = times.indexOf(item.start_time);
                            const end = times.indexOf(item.end_time);
                            for (let i = start; i <= end && i >= 0; i++) {
                                $grid.find(`.time-slot[data-day="${item.schedday}"][data-time="${times[i]}"]`)
                                    .addClass('highlighted occupied')
                                    .text(subjectInfo);
                            }
                        });
                        mergeCells($grid);
                    },
                    error: function (xhr) {
                        $('#schedModalLoading').hide();
                        const msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Unable to load schedule.';
                        toastr.error('Error loading schedule: ' + msg);
                    }
                });
            }

            $('.view-sched-btn').on('click', function () {
                const btn = $(this);
                current = {
                    schlyear: btn.data('schlyear'),
                    semester: btn.data('semester'),
                    progCod: btn.data('progcod')
                };

                $('#schedCourse').text(btn.data('prog') || 'Not Available');
                $('#schedYear').text(current.schlyear);
                $('#schedSem').text(semLabel[current.semester] || 'Unknown Semester');

                schedModal.show();
                loadSchedule();
            });

            $('#refreshSchedule').on('click', function () {
                loadSchedule();
            });
        });
    </script>
@endpush
