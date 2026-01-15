<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Menampilkan halaman forgot password
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }
    
    /**
     * Mengirim email reset password dengan OTP (untuk form biasa)
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validasi input
        $validator = $this->validator($request->all());
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Validasi tambahan untuk domain - hanya gmail.com yang diperbolehkan
        $email = $request->email;
        $allowedDomains = ['gmail.com'];
        $domain = explode('@', $email)[1] ?? '';
        
        if (!in_array(strtolower($domain), $allowedDomains)) {
            return redirect()->back()
                ->withErrors(['email' => 'Email Anda Salah'])
                ->withInput();
        }
        
        // Cari user berdasarkan email
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => 'Email tidak terdaftar dalam sistem.'])
                ->withInput();
        }
        
        try {
            // Generate OTP 6 digit
            $otp = rand(100000, 999999);
            
            // Simpan OTP ke cache dengan expiry 10 menit (lebih aman dari database)
            Cache::put('otp_' . $email, $otp, now()->addMinutes(10));
            
            // Simpan juga counter untuk mencegah spam
            $attempts = Cache::get('otp_attempts_' . $email, 0);
            Cache::put('otp_attempts_' . $email, $attempts + 1, now()->addMinutes(10));
            
            // Kirim email menggunakan SMTP
            Mail::send('emails.otp', [
                'user' => $user,
                'otp' => $otp,
                'userName' => $user->name,
            ], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Kode OTP Reset Password - Sleepy Panda');
            });
            
            return redirect()->back()
                ->with('success', 'Kode OTP telah dikirim ke email Anda! Silakan cek email Anda.');
            
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email: ' . $e->getMessage());
            
            return redirect()->back()
                ->withErrors(['error' => 'Gagal mengirim email. Silakan coba lagi.'])
                ->withInput();
        }
    }
    
    /**
     * Mengirim OTP via API (untuk AJAX request dari modal)
     */
    public function sendOtp(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    // Validasi domain - hanya gmail.com yang diperbolehkan
                    $allowedDomains = ['gmail.com'];
                    $domain = explode('@', $value)[1] ?? '';
                    if (!in_array(strtolower($domain), $allowedDomains)) {
                        $fail('Email Anda Salah');
                    }
                },
            ]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak valid'
            ], 422);
        }

        $email = $request->email;

        // Cek apakah email terdaftar
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak terdaftar'
            ], 404);
        }

        // Cek rate limiting - maksimal 5 percobaan per 10 menit
        $attempts = Cache::get('otp_attempts_' . $email, 0);
        if ($attempts >= 5) {
            return response()->json([
                'success' => false,
                'message' => 'Terlalu banyak percobaan. Silakan coba lagi dalam 10 menit.'
            ], 429);
        }

        try {
            // Generate OTP 6 digit
            $otp = rand(100000, 999999);

            // Simpan OTP ke cache dengan expiry 10 menit
            Cache::put('otp_' . $email, $otp, now()->addMinutes(10));
            
            // Update counter attempts
            Cache::put('otp_attempts_' . $email, $attempts + 1, now()->addMinutes(10));

            // Kirim email OTP
            Mail::send('emails.otp', [
                'user' => $user,
                'otp' => $otp,
                'userName' => $user->name,
            ], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Kode OTP Reset Password - Sleepy Panda');
            });

            return response()->json([
                'success' => true,
                'message' => 'Kode OTP telah dikirim ke email Anda',
                'email' => $email
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send OTP email: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|digits:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid'
            ], 422);
        }

        $email = $request->email;
        $otp = $request->otp;

        // Ambil OTP dari cache
        $storedOtp = Cache::get('otp_' . $email);

        if (!$storedOtp) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP sudah kadaluarsa'
            ], 400);
        }

        if ($storedOtp != $otp) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP salah'
            ], 400);
        }

        // OTP valid, hapus dari cache dan buat token reset password
        Cache::forget('otp_' . $email);
        Cache::forget('otp_attempts_' . $email);

        // Generate token untuk reset password
        $resetToken = Str::random(60);
        Cache::put('reset_token_' . $email, $resetToken, now()->addMinutes(30));

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP valid',
            'reset_token' => $resetToken
        ]);
    }

    /**
     * Reset password with token
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'reset_token' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        $email = $request->email;
        $resetToken = $request->reset_token;

        // Verifikasi token
        $storedToken = Cache::get('reset_token_' . $email);

        if (!$storedToken || $storedToken !== $resetToken) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid atau sudah kadaluarsa'
            ], 400);
        }

        // Update password
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        // Hapus token
        Cache::forget('reset_token_' . $email);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil direset'
        ]);
    }
    
    /**
     * Validator untuk data forgot password
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    // Validasi format email
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $fail('Email Anda Salah');
                    }
                    
                    // Validasi domain - hanya gmail.com yang diperbolehkan
                    $allowedDomains = ['gmail.com'];
                    $domain = explode('@', $value)[1] ?? '';
                    if (!in_array(strtolower($domain), $allowedDomains)) {
                        $fail('Email Anda Salah');
                    }
                },
            ],
        ], [
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email Anda Salah',
        ]);
    }
}