<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

use App\Models\EnrollmentDB\Student;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getGuard()
    {
        if (\Auth::guard('kioskstudent')->check()) {
            return 'kioskstudent';
        }

        return null;
    }

    /**
     * One-line replacement for the repeated guard + student lookup
     * pasted in every kiosk controller.
     *
     * Usage: [$guard, $studentowner, $studauth, $studentcampus] = $this->kioskContext();
     */
    protected function kioskContext(): array
    {
        $guard = $this->getGuard();
        $studentowner = $guard ? Auth::guard($guard)->user()->studid : null;
        $studauth = $studentowner
            ? Student::where('stud_id', '=', $studentowner)->first()
            : null;
        $studentcampus = $studauth->campus ?? null;

        return [$guard, $studentowner, $studauth, $studentcampus];
    }
}
