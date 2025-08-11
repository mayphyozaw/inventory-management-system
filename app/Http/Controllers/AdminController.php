<?php

namespace App\Http\Controllers;

use App\Mail\VerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function admin_logout(Request $request) 
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function admin_login(Request $request)
    {
        $credentials = $request->only('email','password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $verificationCode = random_int(100000,999999);
            
            session(['verification_code' => $verificationCode, 'user_id' => $user->id]);

            Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));

            Auth::logout();

            return redirect()->route('custom.verification.form')->with('status','Verification code send to your mail');
            
        }
        return redirect()->back()->withErrors(['email'=>'Invaild Credential Provided']);

    }

    public function showVerification()
    {
        return view('auth.verify');
    }

    public function verificationVerify(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);

        if($request->code == session('verification_code'))
        {
            Auth::loginUsingId(session('user_id'));

            session()->forget('verification_code','user_id');

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['code' => 'Invalid Verification Code']);

    }
}
