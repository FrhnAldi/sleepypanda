<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * Menampilkan halaman register
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    
    /**
     * Proses registrasi user baru
     */
    public function register(Request $request)
    {
        // Validasi input
        $validator = $this->validator($request->all());
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
        
        // Validasi tambahan untuk domain - hanya gmail.com yang diperbolehkan
        $email = $request->email;
        $allowedDomains = ['gmail.com'];
        $domain = explode('@', $email)[1] ?? '';
        
        if (!in_array(strtolower($domain), $allowedDomains)) {
            return redirect()->back()
                ->withErrors(['email' => 'username/password incorrect.'])
                ->withInput($request->only('email'));
        }
        
        // Cek apakah email sudah terdaftar
        if (User::where('email', $email)->exists()) {
            return redirect()->back()
                ->withErrors(['email' => 'Email sudah terdaftar.'])
                ->withInput($request->only('email'));
        }
        
        // Buat user baru
        try {
            $user = $this->create($request->all());
            
            // Login otomatis setelah registrasi
            Auth::login($user);
            
            // Redirect ke dashboard atau home
            return redirect()->route('dashboard')->with('success', 'Registrasi berhasil!');
            
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'])
                ->withInput($request->only('email'));
        }
    }
    
    /**
     * Validator untuk data registrasi
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
                        $fail('username/password incorrect.');
                    }

                    // Validasi domain - hanya gmail.com dan yahoo.com yang diperbolehkan
                    $allowedDomains = ['gmail.com', 'yahoo.com'];
                    $domain = explode('@', $value)[1] ?? '';
                    if (!in_array(strtolower($domain), $allowedDomains)) {
                        $fail('username/password incorrect.');
                    }
                },
            ],
            'password' => [
                'required',
                'string',
                'min:8',
            ],
        ], [
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'username/password incorrect.',
            'password.required' => 'Password tidak boleh kosong.',
            'password.min' => 'Password harus lebih dari 8 karakter.',
        ]);
    }
    
    /**
     * Membuat user baru
     */
    protected function create(array $data)
    {
        // Ambil nama dari email (bagian sebelum @)
        $name = explode('@', $data['email'])[0];
        
        return User::create([
            'name' => $name,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}