<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\KioskDashController;
use App\Http\Controllers\KioskGradeController;
use App\Http\Controllers\KioskClassSchedController;
use App\Http\Controllers\KioskCampusWiFiController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>['guest']],function(){
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/studkiosk/onsite', [LoginController::class, 'loginkioskstud'])->name('loginkioskstud');
    Route::post('/stud/user_login', [LoginController::class, 'studkiosk_login'])->name('studkiosk_login');
});

Route::group(['middleware'=>['login_auth']],function(){
    Route::prefix('student')->group(function () {
        Route::get('/dashboard/view', [KioskDashController::class, 'kioskhome'])->name('kioskhome');
        Route::get('/grades/view', [KioskGradeController::class, 'index'])->name('index.grades');
        Route::get('/schedule/view', [KioskClassSchedController::class, 'index'])->name('index.schedule');
        Route::get('/camp-wifi/view', [KioskCampusWiFiController::class, 'index'])->name('index.wifi');
        Route::get('/camp-wifi/voucher/mine', [KioskCampusWiFiController::class, 'myVoucher'])->name('wifi.voucher.mine');
        Route::post('/camp-wifi/voucher/generate', [KioskCampusWiFiController::class, 'generate'])->name('wifi.voucher.generate');

        Route::get('/localstud/info/kiosk/account/view', [KioskDashController::class, 'kioskaccount'])->name('kioskaccount');

        Route::get('/localstud/info/kiosk/schedule/view/result', [KioskClassSchedController::class, 'schedclassShow'])->name('schedclassShow');
        Route::get('/localstud/info/kiosk/schedule/view/result/ajax', [KioskClassSchedController::class, 'fetchSchedule'])->name('fetchSchedule');

        Route::get('/localstud/info/kiosk/logout', [KioskDashController::class, 'logout'])->name('kiosk.logout');
    });
});
