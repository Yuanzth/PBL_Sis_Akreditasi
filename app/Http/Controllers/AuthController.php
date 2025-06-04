<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        Log::info('Accessing login page', ['authenticated' => Auth::check()]);
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'username' => 'required|min:1|max:20',
                'password' => 'required|min:5|max:20',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ], 422);
            }

            // Ambil username dan password dari request
            $username = $request->input('username');
            $password = $request->input('password');

            // Cari user berdasarkan username secara case-sensitive
            $user = UserModel::where('username', $username)->first();

            if ($user && Hash::check($password, $user->password)) {
                // Jika username dan password cocok, login user
                Auth::login($user);
                $request->session()->regenerate();
                Log::info('Login successful', ['user_id' => $user->id_user, 'level_kode' => $user->level->level_kode]);

                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }

            // Jika username atau password salah
            Log::warning('Login failed', ['username' => $username]);
            return response()->json([
                'status' => false,
                'message' => 'Username atau kata sandi salah',
                'msgField' => [
                    'username' => ['Username atau kata sandi salah'],
                    'password' => ['Username atau kata sandi salah']
                ]
            ], 401);
        }

        return redirect('login');
    }

    public function logout(Request $request)
    {
        Log::info('User logout', ['user_id' => Auth::id()]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}