<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login dengan validasi sesuai ketentuan
     */
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // KETENTUAN 1: Username dan password tidak boleh kosong
        if (empty($email) || empty($password)) {
            return redirect()->back()
                ->with('error', 'username/password incorrect.')
                ->withInput($request->only('email'));
        }

        // KETENTUAN 2: Validasi format email dan domain
        // Cek format email dasar
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()
                ->with('error', 'username/password incorrect.')
                ->withInput($request->only('email'));
        }

        // Validasi domain - BLACKLIST domain terlarang
        $blockedDomains = ['ganteng.com']; // Domain yang dilarang
        $allowedDomains = ['gmail.com'];   // Domain yang diperbolehkan
        
        $emailParts = explode('@', $email);
        if (count($emailParts) === 2) {
            $domain = strtolower($emailParts[1]);
            
            // Cek jika domain termasuk dalam blacklist
            if (in_array($domain, $blockedDomains)) {
                return redirect()->back()
                    ->with('error', 'username/password incorrect.')
                    ->withInput($request->only('email'));
            }
            
            // Cek jika domain TIDAK termasuk dalam whitelist
            if (!in_array($domain, $allowedDomains)) {
                return redirect()->back()
                    ->with('error', 'username/password incorrect.')
                    ->withInput($request->only('email'));
            }
        } else {
            return redirect()->back()
                ->with('error', 'username/password incorrect.')
                ->withInput($request->only('email'));
        }

        // KETENTUAN 3: Password harus lebih dari 8 karakter (minimal 9)
        if (strlen($password) <= 8) {
            return redirect()->back()
                ->with('error', 'username/password incorrect.')
                ->withInput($request->only('email'));
        }

        // KETENTUAN 4: Jika username dan password sudah sesuai kaidah 1-3
        // Coba login dengan credentials
        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // Login berhasil - redirect ke dashboard
            return redirect()->intended('/dashboard');
        }

        // Jika login gagal (user tidak ditemukan atau password salah)
        // User bisa menuju forgot password jika lupa password
        return redirect()->back()
            ->with('error', 'username/password incorrect.')
            ->withInput($request->only('email'));
    }

    /**
     * Menampilkan halaman register
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Proses register (HANYA EMAIL & PASSWORD)
     */
    public function register(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // Validasi tidak boleh kosong
        if (empty($email) || empty($password)) {
            return redirect()->back()
                ->withErrors(['email' => 'Email dan password tidak boleh kosong.'])
                ->withInput($request->only('email'));
        }

        // Validasi format email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()
                ->withErrors(['email' => 'username/password incorrect.'])
                ->withInput($request->only('email'));
        }

        // Validasi domain - BLACKLIST dan WHITELIST
        $allowedDomains = ['gmail.com', 'yahoo.com'];
        
        $emailParts = explode('@', $email);
        if (count($emailParts) === 2) {
            $domain = strtolower($emailParts[1]);
            
            // Cek whitelist
            if (!in_array($domain, $allowedDomains)) {
                return redirect()->back()
                    ->withErrors(['email' => 'username/password incorrect.'])
                    ->withInput($request->only('email'));
            }
        } else {
            return redirect()->back()
                ->withErrors(['email' => 'Format email tidak valid'])
                ->withInput($request->only('email'));
        }

        // Validasi password harus lebih dari 8 karakter (minimal 9)
        if (strlen($password) <= 8) {
            return redirect()->back()
                ->withErrors(['password' => 'Password harus lebih dari 8 karakter'])
                ->withInput($request->only('email'));
        }

        // Cek apakah email sudah terdaftar
        if (User::where('email', $email)->exists()) {
            return redirect()->back()
                ->withErrors(['email' => 'Email sudah terdaftar.'])
                ->withInput($request->only('email'));
        }

        try {
            // Buat user baru - name auto generate dari email
            $name = explode('@', $email)[0]; // Ambil bagian sebelum @
            
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            // Login otomatis setelah register
            Auth::login($user);

            return redirect('/dashboard')->with('success', 'Registrasi berhasil!');
            
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'])
                ->withInput($request->only('email'));
        }
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'Berhasil logout');
    }
}