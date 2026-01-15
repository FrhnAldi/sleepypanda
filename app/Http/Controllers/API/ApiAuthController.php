<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    /**
     * POIN C: Register - Simpan password dengan Hash SHA-256 di kolom hashed_password
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // POIN B & C: Hash password menggunakan SHA-256
        $hashedPassword = hash('sha256', $request->password);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Bcrypt untuk fallback
            'hashed_password' => $hashedPassword, // SHA-256 sesuai poin C
            'phone' => $request->phone,
        ]);

        // POIN B: Generate JWT Token dengan expire 30 menit
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->accessToken;

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'created_at' => $user->created_at,
            ],
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => 1800, // 30 menit dalam detik (sesuai poin B)
        ], 201);
    }

    /**
     * POIN D: Login - Decrypt hashed_password dan redirect ke admin dashboard
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        // POIN D: Decrypt/Verify hashed_password dengan SHA-256
        $inputHashedPassword = hash('sha256', $request->password);
        
        if ($user->hashed_password !== $inputHashedPassword) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials - Password does not match'
            ], 401);
        }

        // POIN B: Generate JWT Token dengan Hash 256 dan expire 30 menit
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->accessToken;

        // POIN D: Response dengan redirect ke admin dashboard
        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ],
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => 1800, // 30 menit = 1800 detik (sesuai poin B)
            'redirect_url' => '/admin/dashboard', // Redirect ke dashboard (sesuai poin D)
        ], 200);
    }

    /**
     * Logout user (revoke token)
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get authenticated user info
     */
    public function user(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => $request->user()
        ]);
    }
}