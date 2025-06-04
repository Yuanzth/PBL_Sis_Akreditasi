<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ManageUserController extends Controller
{
    public function index()
    {
        // Pengecekan akses SuperAdmin
        $user = Auth::user();
        if ($user->level->level_kode !== 'SuperAdmin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses untuk mengelola pengguna.');
        }

        $users = UserModel::with('level')->get();
        Log::info('SuperAdmin accessed user management', ['user_count' => $users->count()]);
        return view('manage-users.index', [
            'users' => $users,
            'activeMenu' => 'manage-users',
            'breadcrumb' => (object) [
                'title' => 'Kelola Pengguna',
                'list' => ['Home', 'Kelola Pengguna']
            ],
        ]);
    }

    public function create(Request $request)
    {
        // Pengecekan akses SuperAdmin
        $user = Auth::user();
        if ($user->level->level_kode !== 'SuperAdmin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses untuk mengelola pengguna.');
        }

        $request->validate([
            'username' => 'required|unique:m_user,username',
            'name' => 'required',
            'password' => 'required|min:5',
            'id_level' => 'required|exists:m_level,id_level',
        ]);

        UserModel::create([
            'username' => $request->username,
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'id_level' => $request->id_level,
            'photo_profile' => null,
        ]);

        Log::info('New user created by SuperAdmin', ['username' => $request->username]);
        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan.');
    }
}