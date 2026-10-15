<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\EnrollmentDB\Student;
use App\Models\EnrollmentDB\StudEnrolmentHistory;

use App\Models\ScheduleDB\EnPrograms;
use App\Models\ScheduleDB\ClassEnroll;
use App\Models\ScheduleDB\Stime;
use App\Models\ScheduleDB\Sday;
use App\Models\ScheduleDB\SetClassSchedule;

class KioskClassSchedController extends Controller
{
    public function index()
    {
        [$guard, $studentowner, $studauth, $studentcampus] = $this->kioskContext();

        $enrollmentHistory = StudEnrolmentHistory::join('coasv2_db_schedule.programs', 'program_en_history.progCod', '=', 'coasv2_db_schedule.programs.progCod')
            ->where('program_en_history.studentID', $studauth->stud_id)
            ->where('program_en_history.campus', $studentcampus)
            ->select('program_en_history.*', 'coasv2_db_schedule.programs.progAcronym')
            ->orderBy('schlyear', 'ASC')
            ->get();

        $days = Sday::all()->pluck('dayDesc')->toArray();
        $times = Stime::all()->pluck('timeDesc')->toArray();

        return view('pages.viewschedule', compact('studauth', 'enrollmentHistory', 'days', 'times'));
    }

    public function schedclassShow(Request $request)
    {
        [$guard, $studentowner, $studauth] = $this->kioskContext();

        $schlyear = $request->query('schlyear');
        $semester = $request->query('semester');
        $progCod = $request->query('progCod');
        $campus = $studauth->campus;

        $parts = preg_split('/[\+\s]/', $progCod);
        $progCodPart = $parts[0];
        $progCodSuffix = isset($parts[1]) ? $parts[1] : null;
        $program = EnPrograms::whereRaw('LOWER(progCod) = ?', [strtolower($progCodPart)])->first();

        $progAcronym = $program ? $program->progAcronym : 'N/A';

        $studclass = ClassEnroll::join('programs', 'class_enroll.progCode', '=', 'programs.progCod')
                        ->where('class_enroll.schlyear', '=', $schlyear)
                        ->where('class_enroll.semester', '=', $semester)
                        ->where('class_enroll.progCode', $progCod)
                        ->select('programs.progAcronym', 'class_enroll.*')
                        ->get();

        $days = Sday::all()->pluck('dayDesc')->toArray();
        $times = Stime::all()->pluck('timeDesc')->toArray();

        return view('pages.viewscheduleresult', compact('studauth', 'progAcronym', 'progCodPart', 'progCodSuffix', 'days', 'times'));
    }

    public function fetchSchedule(Request $request)
    {
        [$guard, $studentowner, $studauth, $studentcampus] = $this->kioskContext();

        $schlyear = $request->query('schlyear');
        $semester = $request->query('semester');
        $progCod = $request->query('progCod');
        $campus = $studentcampus;

        $parts = preg_split('/[\+\s]/', $progCod);
        $progCodPart = $parts[0];
        $progCodSuffix = isset($parts[1]) ? $parts[1] : null;
        $program = EnPrograms::whereRaw('LOWER(progCod) = ?', [strtolower($progCodPart)])->first();

        $progAcronym = $program ? $program->progAcronym : 'N/A';

        $schedule = SetClassSchedule::join('sub_offered', 'scheduleclass.subject_id', '=', 'sub_offered.id')
                        ->join('subjects', 'sub_offered.subCode', '=', 'subjects.sub_code')
                        ->leftJoin('faculty', 'scheduleclass.faculty_id', '=', 'faculty.id')
                        ->leftJoin('rooms', 'scheduleclass.room_id', '=', 'rooms.id')
                        ->where('scheduleclass.schlyear', '=', $schlyear)
                        ->where('scheduleclass.semester', '=', $semester)
                        ->where('scheduleclass.progcodename', $progCodPart)
                        ->where('scheduleclass.progcodesection', $progCodSuffix)
                        ->where('scheduleclass.campus', $campus)
                        ->select('sub_offered.subSec', 'scheduleclass.*', 'subjects.sub_name', 'faculty.lname', 'faculty.fname', 'rooms.room_name')
                        ->get();

        return response()->json($schedule);
    }
}
