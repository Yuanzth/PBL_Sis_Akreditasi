<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KriteriaModel;
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

    public function show($id)
    {
        // Pengecekan akses SuperAdmin
        $user = Auth::user();
        if ($user->level->level_kode !== 'SuperAdmin') {
            return response()->json(['error' => 'Anda tidak memiliki akses.'], 403);
        }

        $kriteria = KriteriaModel::with('level')->find($id);
        if (!$kriteria) {
            return response()->json(['error' => 'Kriteria tidak ditemukan.'], 404);
        }

        return response()->json([
            'id_kriteria' => $kriteria->id_kriteria,
            'nama_kriteria' => $kriteria->nama_kriteria,
            'level_nama' => $kriteria->level->level_nama,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Pengecekan akses SuperAdmin
        $user = Auth::user();
        if ($user->level->level_kode !== 'SuperAdmin') {
            return response()->json(['error' => 'Anda tidak memiliki akses.'], 403);
        }

        $request->validate([
            'nama_kriteria' => 'required|unique:m_kriteria,nama_kriteria,' . $id . ',id_kriteria',
        ]);

        $kriteria = KriteriaModel::find($id);
        if (!$kriteria) {
            return response()->json(['error' => 'Kriteria tidak ditemukan.'], 404);
        }

        $kriteria->update([
            'nama_kriteria' => $request->nama_kriteria,
            'updated_at' => now(),
        ]);

        Log::info('Kriteria updated by SuperAdmin', ['id_kriteria' => $id, 'nama_kriteria' => $request->nama_kriteria]);
        return response()->json(['message' => 'Kriteria berhasil diperbarui.']);
    }
}