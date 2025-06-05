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
        return response()->json([
            'message' => 'Pengguna berhasil ditambahkan.',
            'user' => [
                'username' => $request->username,
                'name' => $request->name,
                'level_nama' => \App\Models\LevelModel::find($request->id_level)->level_nama
            ]
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        if ($user->level->level_kode !== 'SuperAdmin') {
            return response()->json(['error' => 'Anda tidak memiliki akses.'], 403);
        }

        $user = UserModel::with('level')->findOrFail($id);
        return response()->json([
            'username' => $user->username,
            'name' => $user->name,
            'level_nama' => $user->level->level_nama,
            'id_level' => $user->id_level
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->level->level_kode !== 'SuperAdmin') {
            return response()->json(['error' => 'Anda tidak memiliki akses.'], 403);
        }

        $request->validate([
            'username' => 'required|unique:m_user,username,' . $id . ',id_user',
            'name' => 'required',
            'password' => 'nullable|min:5',
            'id_level' => 'required|exists:m_level,id_level',
        ]);

        $user = UserModel::findOrFail($id);
        $user->update([
            'username' => $request->username,
            'name' => $request->name,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'id_level' => $request->id_level,
        ]);

        Log::info('User updated by SuperAdmin', ['username' => $request->username]);
        return response()->json([
            'message' => 'Pengguna berhasil diperbarui.',
            'user' => [
                'username' => $user->username,
                'name' => $user->name,
                'level_nama' => $user->level->level_nama
            ]
        ]);
    }
}