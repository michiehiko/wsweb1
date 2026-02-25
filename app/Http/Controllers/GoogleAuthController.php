<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'id_google' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(16)) 
                ]
            );

            session(['otp_user_id' => $user->id]);

            $this->sendOtpEmail($user);

            return redirect()->route('otp.view');

        } catch (\Exception $e) {

            return redirect('/')->with('error', 'Login Google Gagal: ' . $e->getMessage());
        }
    }

    
    public function sendOtpEmail($user)
    {
        $otp = strtoupper(Str::random(6));
  
        $user->update(['otp' => $otp]);

        try {
            Mail::raw("Kode OTP Login Anda: " . $otp, function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Kode OTP Masuk Sistem');
            });
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengirim email. Silakan coba kirim ulang.');
        }
    }

    
    public function showOtpForm()
    {
        if (!session('otp_user_id')) {
            return redirect('/'); 
        }
        return view('auth.otp'); 
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);

        $userId = session('otp_user_id');
        $user = User::find($userId);

        if ($user && $user->otp == $request->otp) {
            Auth::login($user);           
            $user->update(['otp' => null]); 
            session()->forget('otp_user_id'); 
            
            return redirect()->route('home'); 
        }

        return back()->with('error', 'Kode OTP Salah!');
    }

    public function resendOtp()
    {
        $userId = session('otp_user_id');
        if (!$userId) {
            return redirect('/');
        }

        $user = User::find($userId);
        
        $this->sendOtpEmail($user);

        return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda!');
    }
}