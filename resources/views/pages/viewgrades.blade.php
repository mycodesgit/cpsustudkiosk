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
                    <i class="ti ti-layout-grid text-success me-1"></i> View Grades
                </h2>
                <small class="text-muted">Subjects Enrolled per semester in every academic year.</small>
            </div>
            <a href="{{ route('kioskhome') }}" class="rounded-pill bg-body-secondary border text-secondary px-3 py-2">
                <i class="ti ti-arrow-back text-success me-1"></i> Go back to Main
            </a>
        </div>

        <div class="row g-3">
            <div class="col-md-12">
                <div class="card shadow-sm rounded-4 mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-head-fixed text-nowrap mt-2">
                                <thead>
                                    <tr>
                                        <th>Stud. ID</th>
                                        <th>School Year</th>
                                        <th>Semester</th>
                                        <th>Course</th>
                                        <th>Subject</th>
                                        <th>Descriptive Title</th>
                                        <th>Final Grade</th>
                                        <th>N Grade</th>
                                        <th>SubjComp</th>
                                        <th>Credit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        if (!function_exists('getEquivalentGPA')) {
                                            function getEquivalentGPA($grade, $isOldSystem) {
                                                if ($grade === 'INC') return ['gpa' => 'INC', 'status' => 'Incomplete'];
                                                if ($grade === 'NN') return ['gpa' => 'NN', 'status' => 'No Name'];
                                                if ($grade === 'NG') return ['gpa' => 'NG', 'status' => 'No Grade'];
                                                if ($grade === 'Drp.') return ['gpa' => 'Drp.', 'status' => 'Drop'];

                                                if ($isOldSystem) {
                                                    // 4-point scale logic
                                                    if ($grade >= 95 || $grade == 1) return ['gpa' => '1.0', 'status' => 'Passed'];
                                                    if ($grade >= 94) return ['gpa' => '1.1', 'status' => 'Passed'];
                                                    if ($grade >= 93) return ['gpa' => '1.2', 'status' => 'Passed'];
                                                    if ($grade >= 92) return ['gpa' => '1.3', 'status' => 'Passed'];
                                                    if ($grade >= 91) return ['gpa' => '1.4', 'status' => 'Passed'];
                                                    if ($grade >= 90) return ['gpa' => '1.5', 'status' => 'Passed'];
                                                    if ($grade >= 89) return ['gpa' => '1.6', 'status' => 'Passed'];
                                                    if ($grade >= 88) return ['gpa' => '1.7', 'status' => 'Passed'];
                                                    if ($grade >= 87) return ['gpa' => '1.8', 'status' => 'Passed'];
                                                    if ($grade >= 86) return ['gpa' => '1.9', 'status' => 'Passed'];
                                                    if ($grade >= 85 || $grade == 2) return ['gpa' => '2.0', 'status' => 'Passed'];
                                                    if ($grade >= 84) return ['gpa' => '2.1', 'status' => 'Passed'];
                                                    if ($grade >= 83) return ['gpa' => '2.2', 'status' => 'Passed'];
                                                    if ($grade >= 82) return ['gpa' => '2.3', 'status' => 'Passed'];
                                                    if ($grade >= 81) return ['gpa' => '2.4', 'status' => 'Passed'];
                                                    if ($grade >= 80) return ['gpa' => '2.5', 'status' => 'Passed'];
                                                    if ($grade >= 79) return ['gpa' => '2.6', 'status' => 'Passed'];
                                                    if ($grade >= 78) return ['gpa' => '2.7', 'status' => 'Passed'];
                                                    if ($grade >= 77) return ['gpa' => '2.8', 'status' => 'Passed'];
                                                    if ($grade >= 76) return ['gpa' => '2.9', 'status' => 'Passed'];
                                                    if ($grade >= 75 || $grade == 3) return ['gpa' => '3.0', 'status' => 'Passed'];
                                                    if ($grade >= 74) return ['gpa' => '4.0', 'status' => 'Conditional'];
                                                    if ($grade >= 73) return ['gpa' => '4.0', 'status' => 'Conditional'];
                                                    if ($grade >= 72) return ['gpa' => '4.0', 'status' => 'Conditional'];
                                                    if ($grade >= 71) return ['gpa' => '4.0', 'status' => 'Conditional'];
                                                    if ($grade >= 70) return ['gpa' => '4.0', 'status' => 'Conditional'];
                                                    return ['gpa' => '5.0', 'status' => 'Failure'];
                                                } else {
                                                    if ($grade >= 97 || $grade == 1) return ['gpa' => '1.00', 'status' => 'Passed'];
                                                    if ($grade >= 94) return ['gpa' => '1.25', 'status' => 'Passed'];
                                                    if ($grade >= 91) return ['gpa' => '1.50', 'status' => 'Passed'];
                                                    if ($grade >= 88) return ['gpa' => '1.75', 'status' => 'Passed'];
                                                    if ($grade >= 85 || $grade == 2) return ['gpa' => '2.00', 'status' => 'Passed'];
                                                    if ($grade >= 82) return ['gpa' => '2.25', 'status' => 'Passed'];
                                                    if ($grade >= 79) return ['gpa' => '2.50', 'status' => 'Passed'];
                                                    if ($grade >= 76) return ['gpa' => '2.75', 'status' => 'Passed'];
                                                    if ($grade >= 75 || $grade == 3) return ['gpa' => '3.00', 'status' => 'Passed'];
                                                    if ($grade >= 70) return ['gpa' => '4.00', 'status' => 'Conditional'];
                                                    return ['gpa' => '5.00', 'status' => 'Failure'];
                                                }
                                            }

                                            //$isOldSystem = Str::contains($studsub->first()->subSec ?? '', '4-');

                                            function displayGrade($grade, $isOldSystem = false) {
                                                if (is_numeric($grade) && strpos($grade, '.') === false) {
                                                    $equivalent = getEquivalentGPA($grade, $isOldSystem);
                                                    return $equivalent['gpa'];
                                                }
                                                return $grade;
                                            }
                                        }
                                    @endphp

                                    @php
                                        $currentYear = '';
                                        $currentSemester = '';
                                        $currentColor = '';
                                        $colorClasses = ['table-light', 'table-secondary'];
                                        $colorIndex = 0;
                                        $sumProduct = 0;
                                        $totalCredits = 0;
                                    @endphp

                                    @foreach($studsub as $index => $datastudsubowner)
                                        @php
                                            $entryYear = (int)substr($datastudsubowner->studID, 0, 4);
                                            if ($entryYear == 0) {
                                                $entryYear = (int)substr(request('stud_id'), 0, 4);
                                            }
                                            $isOldSystem = $entryYear <= 2021;

                                            $gradenumerical = $datastudsubowner->subjFgrade;
                                            $credit = $datastudsubowner->creditEarned;

                                            $product = 0;
                                            if(is_numeric($gradenumerical) && is_numeric($credit)){
                                                $product = $gradenumerical * $credit;
                                            }
                                        @endphp

                                        @if($currentYear != $datastudsubowner->schlyear || $currentSemester != $datastudsubowner->semester)
                                            @php
                                                $currentYear = $datastudsubowner->schlyear;
                                                $currentSemester = $datastudsubowner->semester;
                                                $currentColor = $colorClasses[$colorIndex % count($colorClasses)];
                                                $colorIndex++;
                                            @endphp
                                        @endif
                                        @php
                                            if(is_numeric($gradenumerical) && is_numeric($credit)){
                                                $sumProduct += $product;
                                                $totalCredits += $credit;
                                            }
                                        @endphp
                                        <tr class="{{ $currentColor }}">
                                            <td>{{ $datastudsubowner->studID }}</td>
                                            <td>{{ $datastudsubowner->schlyear }}</td>
                                            <td>
                                                @if($datastudsubowner->semester == 1)
                                                    <span class="badge bg-primary">1st Sem</span>
                                                @elseif($datastudsubowner->semester == 2)
                                                    <span class="badge bg-success">2nd Sem</span>
                                                @elseif($datastudsubowner->semester == 3)
                                                    <span class="badge bg-secondary">Summer</span>
                                                @endif
                                            </td>
                                            <td>{{ $datastudsubowner->subSec }}</td>
                                            <td>{{ $datastudsubowner->sub_name }}</td>
                                            <td>{{ $datastudsubowner->sub_title }}</td>
                                            <td><b style="{{ $datastudsubowner->subjFgrade == 'INC' ? 'color: red;' : '' }}">{{ displayGrade($datastudsubowner->subjFgrade, $isOldSystem) }}</b></td>
                                            <td>{{ $datastudsubowner->subjFgrade }}</td>
                                            <td><b>{{ displayGrade($datastudsubowner->subjComp, $isOldSystem) }}</b></td>
                                            <td>{{ $datastudsubowner->creditEarned }}</td>
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
@endsection
