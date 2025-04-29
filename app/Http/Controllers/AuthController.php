<?php

namespace App\Http\Controllers;


use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        if(Auth::check()){ // jika sudah login, maka redirect ke halaman home
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }

        return redirect('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    
    }

    public function register()
    {
        $staffLevel = LevelModel::where('level_nama', 'Staff')->first();
    
        if (!$staffLevel) {
            abort(404, 'Level Staff tidak ditemukan');
        }
    
        return view('auth.register');
    }
    
    public function postRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:m_user,username',
            'nama' => 'required|string|max:255',
            'password' => 'required|string|min:5|confirmed', // Hapus validasi level_id
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ]);
        }
    
        // Cari level Staff
        $staffLevel = LevelModel::where('level_nama', 'Staff')->firstOrFail();
    
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $staffLevel->level_id // Set otomatis ke level Staff
        ]);
    
        return response()->json([
            'status' => true,
            'message' => 'Registrasi Berhasil',
            'redirect' => url('/login')
        ]);
    }
}