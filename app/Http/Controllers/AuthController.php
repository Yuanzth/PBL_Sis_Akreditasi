<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
                'username' => 'required|min:4|max:20',
                'password' => 'required|min:5|max:20',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ], 422);
            }

            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $user = Auth::user();
                Log::info('Login successful', ['user_id' => $user->id_user, 'level_kode' => $user->level->level_kode]);

                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }

            Log::warning('Login failed', ['username' => $request->username]);
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