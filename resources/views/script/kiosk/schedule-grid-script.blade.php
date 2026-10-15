<script>
    $(document).ready(function () {
        const days = @json($days ?? []);
        const times = @json($times ?? []);

        const urlParams = new URLSearchParams(window.location.search);
        const schlyear = urlParams.get('schlyear') || '';
        const semester = urlParams.get('semester') || '';
        const progCod = urlParams.get('progCod') || '';

        $('#refreshSchedule').on('click', function () {
            location.reload();
        });

        function loadSchedule() {
            $.ajax({
                url: '{{ route('fetchSchedule') }}',
                method: 'GET',
                data: { schlyear, semester, progCod },
                success: function (response) {
                    if (!response || response.length === 0) {
                        Swal.fire({
                            icon: 'info',
                            title: 'No Schedule',
                            text: 'No Schedule being plotted'
                        });
                        return;
                    }

                    response.forEach(function (item) {
                        const day = item.schedday;
                        const startTime = item.start_time;
                        const endTime = item.end_time;
                        const subjectInfo = `${item.sub_name ?? ''} ${item.subSec ?? ''} ${item.lname ?? ''}, ${item.room_name ?? ''} ${item.remarks ?? ''}`;

                        const timeIndexStart = times.indexOf(startTime);
                        const timeIndexEnd = times.indexOf(endTime);

                        for (let i = timeIndexStart; i <= timeIndexEnd && i >= 0; i++) {
                            $(`.time-slot[data-day="${day}"][data-time="${times[i]}"]`)
                                .addClass('highlighted occupied')
                                .text(subjectInfo);
                        }
                    });

                    mergeCellsForView();
                },
                error: function (response) {
                    const msg = response.responseJSON && response.responseJSON.message
                        ? response.responseJSON.message
                        : 'Unable to load schedule.';
                    toastr.error('Error loading schedule: ' + msg);
                }
            });
        }

        function createScheduleGrid() {
            let grid = '<table class="table table-bordered schedule-table"><thead><tr><th class="kiosk-sched-head">Time</th>';
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

            grid += '</tbody></table>';
            $('#schedule-grid').html(grid);
        }

        function mergeCellsForView() {
            days.forEach((day) => {
                let prevCell = null;
                let rowspanCount = 1;

                times.forEach((time) => {
                    const currentCell = $(`.time-slot[data-day="${day}"][data-time="${time}"]`);
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

            $('#schedule-grid table td').css({
                'text-align': 'center',
                'padding': '10px',
                'vertical-align': 'middle'
            });
        }

        createScheduleGrid();
        loadSchedule();

        if ($('#ss').length) {
            $('#ss').DataTable({
                responsive: true,
                autoWidth: false
            });
        }
    });
</script>
