<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KriteriaModel;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ManageKriteriaController extends Controller
{
    public function index()
    {
        // Pengecekan akses SuperAdmin
        $user = Auth::user();
        if ($user->level->level_kode !== 'SuperAdmin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses untuk mengelola kriteria.');
        }

        $kriteria = KriteriaModel::with('level')->get();
        Log::info('SuperAdmin accessed kriteria management', ['kriteria_count' => $kriteria->count()]);
        return view('manage-kriteria.index', [
            'kriteria' => $kriteria,
            'activeMenu' => 'manage-kriteria',
            'breadcrumb' => (object) [
                'title' => 'Kelola Kriteria',
                'list' => ['Home', 'Kelola Kriteria']
            ],
        ]);
    }

    public function create(Request $request)
    {
        // Pengecekan akses SuperAdmin
        $user = Auth::user();
        if ($user->level->level_kode !== 'SuperAdmin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses untuk mengelola kriteria.');
        }

        $request->validate([
            'nama_kriteria' => 'required|unique:m_kriteria,nama_kriteria',
            'id_level' => 'required|exists:m_level,id_level',
        ]);

        KriteriaModel::create([
            'nama_kriteria' => $request->nama_kriteria,
            'id_level' => $request->id_level,
            'status_selesai' => 'Save',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info('New kriteria created by SuperAdmin', ['nama_kriteria' => $request->nama_kriteria]);
        return redirect()->back()->with('success', 'Kriteria berhasil ditambahkan.');
    }
}