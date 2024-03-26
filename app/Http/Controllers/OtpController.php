<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        Otp::where('email', $request->email)->delete();

        $otp = rand(100000, 999999);

        Mail::to($request->email)->send(new VerifyEmail($otp));

        Otp::create([
            'id' => 'otp-'.Str::uuid(),
            'email' => $request->email,
            'otp' => $otp,
        ]);

        return response([
            'message' => 'Otp has been sent to your email',
        ], 200);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'otp' => 'required|numeric',
        ]);

        $otp = Otp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (! $otp) {
            return response([
                'message' => 'Otp is invalid',
            ], 409);
        }

        $otp->delete();

        return response([
            'message' => 'Otp is valid',
        ], 200);
    }
}
