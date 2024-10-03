<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerifyOTPController extends Controller
{
    public function showVerifyForm()
    {
        return view('auth.verify-otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        if ($request->input('otp') == session('otp')) {
            $user = $request->user();
            $user->markEmailAsVerified();
            session()->forget('otp');

            return redirect()->route('dashboard')->with('status', 'Email verified successfully!');
        }

        return back()->withErrors(['otp' => 'The OTP code is incorrect.']);
    }
}
