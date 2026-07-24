<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /**
     * Kirim OTP ke email.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'Email tidak terdaftar.',
        ]);

        $otp = (string) random_int(100000, 999999);

        DB::table('password_reset_otps')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(10),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        Mail::to($request->email)->send(new OtpMail($otp));

        return response()->json([
            'message' => 'Kode OTP telah dikirim ke email Anda.',
        ]);
    }

    /**
     * Verifikasi OTP.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'digits:6'],
        ]);

        $record = DB::table('password_reset_otps')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (! $record) {
            throw ValidationException::withMessages([
                'otp' => 'Kode OTP tidak valid.',
            ]);
        }

        if (now()->greaterThan($record->expires_at)) {
            throw ValidationException::withMessages([
                'otp' => 'Kode OTP sudah kedaluwarsa.',
            ]);
        }

        return response()->json([
            'message' => 'OTP valid.',
        ]);
    }

    /**
     * Reset password setelah OTP diverifikasi.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'digits:6'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $record = DB::table('password_reset_otps')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (! $record || now()->greaterThan($record->expires_at)) {
            throw ValidationException::withMessages([
                'otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.',
            ]);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_reset_otps')->where('email', $request->email)->delete();

        return response()->json([
            'message' => 'Password berhasil diubah. Silakan login.',
        ]);
    }
}