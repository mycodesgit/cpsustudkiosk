@extends('layouts.app')

@section('body')
<div class="text-xs">
    <div class="row" style="padding-top: 0px;">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <div class="h3"><b>Student</b> Class Schedule</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-body">
                                <div class="table-responsive" id="schedule-grid"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    CISS V.1.0: Maintained and Managed by Management Information System Office (MISO) under the Leadership of Dr. Aladino C. Moraca Copyright © 2023 CPSU, All Rights Reserved
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    var days = @json($days);
    var times = @json($times);
</script>
@include('script.kiosk.viewscheduleresult')
@endpush

@endsection
