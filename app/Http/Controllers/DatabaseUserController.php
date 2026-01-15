<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DatabaseUserController extends Controller
{
    /**
     * Display a listing of users with statistics
     */
    public function index()
    {
        try {
            // Get all users ordered by creation date
            $users = User::orderBy('created_at', 'desc')->get();
            
            // Calculate statistics
            $totalUsers = User::count();
            $activeUsers = User::where('updated_at', '>=', Carbon::now()->subDays(7))->count();
            $newUsers = User::where('created_at', '>=', Carbon::now()->subMonth())->count();
            $inactiveUsers = $totalUsers - $activeUsers;
            
            return view('pages.database-user', compact('users', 'totalUsers', 'activeUsers', 'newUsers', 'inactiveUsers'));
        } catch (\Exception $e) {
            Log::error('Error loading database user page: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Gagal memuat halaman database user');
        }
    }

    /**
     * Display the specified user
     */
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching user: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Validation rules
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id . ',id',
                'phone' => 'nullable|string|max:20',
            ], [
                'name.required' => 'Nama wajib diisi',
                'name.max' => 'Nama maksimal 255 karakter',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah digunakan oleh user lain',
                'phone.max' => 'Nomor telepon maksimal 20 karakter',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Begin transaction
            DB::beginTransaction();

            try {
                // Update user data
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);

                DB::commit();

                Log::info('User updated successfully: ' . $user->id . ' by ' . Auth::user()->name);

                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil diupdate!',
                    'user' => $user->fresh()
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate data. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Reset the specified user's password
     */
    public function resetPassword(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Validation rules
            $validator = Validator::make($request->all(), [
                'new_password' => 'required|string|min:8|confirmed',
            ], [
                'new_password.required' => 'Password baru wajib diisi',
                'new_password.min' => 'Password minimal 8 karakter',
                'new_password.confirmed' => 'Konfirmasi password tidak cocok',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Begin transaction
            DB::beginTransaction();

            try {
                // Update password
                $user->update([
                    'password' => Hash::make($request->new_password)
                ]);

                DB::commit();

                Log::info('Password reset successfully for user: ' . $user->id . ' by ' . Auth::user()->name);

                return response()->json([
                    'success' => true,
                    'message' => 'Password berhasil direset!'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error resetting password: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mereset password. Silakan coba lagi.'
            ], 500);
        }
    }
}