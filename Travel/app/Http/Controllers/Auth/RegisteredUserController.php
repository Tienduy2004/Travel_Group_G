<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPMail; // Thêm dòng này


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:20','regex:/^[\p{L}\s]+$/u'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:50', 'unique:'.User::class],
            'password' => [
            'required',
            'confirmed',
            'min:8',
            'max:15',
            'regex:/[A-Z]/',      // Ít nhất 1 chữ cái viết hoa
            'regex:/[a-z]/',      // Ít nhất 1 chữ cái viết thường
            'regex:/[0-9]/',      // Ít nhất 1 chữ số
            'regex:/[@$!%*#?&]/', // Ít nhất 1 ký tự đặc biệt
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        

        // event(new Registered($user));
        $otp = random_int(100000, 999999);
        session(['otp' => $otp]);
    
        // Send OTP via email
        Mail::to($user->email)->send(new OTPMail($otp));
    
        Auth::login($user);
    
        return redirect()->route('otp.verify');
        

        return redirect(route('dashboard', absolute: false));
    }
}
