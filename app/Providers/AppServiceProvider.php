<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use App\Models\EnrollmentDB\Student;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share the logged-in student's name with the main layout so no
        // controller has to query/pass $studinfo for the topbar.
        View::composer('layouts.app', function ($view) {
            // A controller-provided $studinfo always wins.
            if (array_key_exists('studinfo', $view->getData())) {
                return;
            }

            $studinfo = null;
            if (Auth::guard('kioskstudent')->check()) {
                $studinfo = Student::where('stud_id', Auth::guard('kioskstudent')->user()->studid)
                    ->select('students.fname', 'students.mname', 'students.lname')
                    ->first();
            }

            $view->with('studinfo', $studinfo);
        });
    }
}
