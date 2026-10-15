<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function loginkioskstud()
    {
        // Login now lives in the welcome page modal; keep this route name
        // (used by the login_auth middleware and logout) working.
        return redirect()->to('/?login=1');
    }

    public function studkiosk_login(Request $request)
    {
        $request->validate([
            'email' => 'required_without:studid|email',
            'studid' => 'required_without:email',
        ]);

        $validatedStudent = auth()->guard('kioskstudent')->attempt([
            'studid' => $request->studid,
            'password' => $request->password,
        ]);
        
        if($validatedStudent) {
            return redirect()->route('kioskhome')->with('success', 'You have successfully logged in.');
        } 
        else {
            return redirect()->back()->with('error', 'Invalid Credentials');
        }
    }
}
