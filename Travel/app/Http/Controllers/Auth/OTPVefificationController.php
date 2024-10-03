<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPMail;
use Illuminate\Support\Str;

class OTPVefificationController extends Controller
{
    public function resend(Request $request)
    {
        $user = Auth::user();

        // Tạo mã OTP ngẫu nhiên
        $otp = random_int(100000, 999999);
        session(['otp' => $otp]);

        // Gửi OTP qua email
        Mail::to($user->email)->send(new OTPMail($otp));

        return back()->with('status', 'OTP has been resent to your email address.');
    }
}
