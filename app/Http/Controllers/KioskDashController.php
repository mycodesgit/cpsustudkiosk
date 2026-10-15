<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\EnrollmentDB\Student;
use App\Models\EnrollmentDB\Grade;

use App\Models\AssessmentDB\StudentAppraisal;

class KioskDashController extends Controller
{
    public function kioskhome()
    {
        [$guard, $studentowner, $studauth] = $this->kioskContext();

        $studsub = Grade::leftJoin('coasv2_db_schedule.sub_offered', 'studgrades.subjID', '=', 'coasv2_db_schedule.sub_offered.id')
                    ->leftJoin('coasv2_db_schedule.subjects', 'coasv2_db_schedule.sub_offered.subCode', '=', 'coasv2_db_schedule.subjects.sub_code')
                    ->select( 'studgrades.*', 'coasv2_db_schedule.sub_offered.*', 'coasv2_db_schedule.subjects.*')
                    ->where('studgrades.studID', $studentowner)
                    ->orderBy('coasv2_db_schedule.sub_offered.id', 'ASC')
                    ->get();

        return view('pages.dashboard', compact('guard', 'studauth', 'studsub'));
    }

    public function kioskaccount()
    {
        [$guard, $studentowner, $studauth] = $this->kioskContext();

        $studfees = StudentAppraisal::select('student_appraisal.*')
                    ->where('student_appraisal.studID', $studentowner)
                    ->orderBy('student_appraisal.id', 'ASC')
                    ->get();



        return view('pages.kiosk.viewaccount', compact('guard', 'studauth', 'studfees'));
    }

    public function logout()
    {
        // if (\Auth::guard('web')->check() || \Auth::guard('faculty')->check()) {
        //     auth()->guard('web')->logout();
        //     auth()->guard('faculty')->logout();
        //     return redirect()->route('login')->with('success', 'You have been Successfully Logged Out');
        // } else {
        //     return redirect()->route('home')->with('error', 'No authenticated user to log out');
        // }

        if (\Auth::guard('kioskstudent')->check()) {
            auth()->guard('kioskstudent')->logout();
            return redirect()->route('loginkioskstud')->with('success', 'You have been Successfully Logged Out');
        }  else {
            return redirect()->route('kioskhome')->with('error', 'No authenticated user to log out');
        }

    }
}
