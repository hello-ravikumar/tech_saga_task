<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserOtp;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon;

class AuthOtpController extends Controller
{
    // Return View of OTP Login Page
    public function login()
    {
        return view('auth.otp-login');
    }

    // Generate OTP
    public function generate(Request $request)
    {
        // Validate Data
        $request->validate([
            'mobile_number' => ['required', 'max:10','regex:/^([0-9\s\-\+\(\)]*)$/','min:10','exists:users,contact_number']
        ]);

        //Generate An OTP
        $verificationCode = $this->generateOtp($request->mobile_number);

        $message = "Your OTP To Login is - ".$verificationCode->otp;
        // Return With OTP 
        
        $verifyFormData = view('auth.verify-otp', ['user_id' => $verificationCode->user_id, 'message' => $message])->render();

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $verifyFormData
        ], 200);
    }

    public function generateOtp($mobile_no)
    {
        $user = User::where('contact_number', $mobile_no)->first();

        # User Does not Have Any Existing OTP
        $verificationCode = UserOtp::where('user_id', $user->id)->latest()->first();

        $now = Carbon::now();

        if($verificationCode && $now->isBefore($verificationCode->expire_at)){
            return $verificationCode;
        }

        // Create a New OTP
        return UserOtp::create([
            'user_id' => $user->id,
            'otp' => rand(123456, 999999),
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);
    }

    public function verification($user_id)
    {
        return view('auth.otp-verification')->with([
            'user_id' => $user_id
        ]);
    }

    public function loginWithOtp(Request $request)
    {
        //Validation
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required'
        ]);

        //Validation Logic
        $verificationCode   = UserOtp::where('user_id', $request->user_id)->where('otp', $request->otp)->first();

        $now = Carbon::now();
        if (!$verificationCode) {
            return response()->json([
                'status' => false,
                'message' => 'Your OTP is not correct',
            ], 422);

        }elseif($verificationCode && $now->isAfter($verificationCode->expire_at)){
            return response()->json([
                'status' => false,
                'message' => 'Your OTP has been expired',
            ], 422);
        }

        $user = User::whereId($request->user_id)->first();

        if($user){
            // Expire The OTP
            $verificationCode->update([
                'expire_at' => Carbon::now()
            ]);

            Auth::login($user);

            return response()->json([
                'status' => true,
                'message' => 'Login successfuly wait for redirect',
                'redirect_uri' =>  RouteServiceProvider::HOME
            ], 200);

        }
        return response()->json([
            'status' => false,
            'message' => 'Your Otp is not correct',
        ], 422);


    }
}