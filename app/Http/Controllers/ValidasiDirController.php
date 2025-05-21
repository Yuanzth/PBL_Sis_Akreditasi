<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ValidasiModel;
use App\Models\KriteriaModel;
use Illuminate\Support\Facades\Auth;

class ValidasiDirController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil semua data validasi beserta kriteria dan user yang melakukan validasi
        $dataValidasi = ValidasiModel::with(['kriteria', 'user'])
            ->join('m_kriteria', 't_validasi.id_kriteria', '=', 'm_kriteria.id_kriteria')
            ->select(
                't_validasi.*',
                'm_kriteria.nama_kriteria',
                //'m_kriteria.updated_at as tanggal_submit',
                //'m_kriteria.status_selesai as status_submit',
            )
            ->orderBy('m_kriteria.id_kriteria')
            ->get();

        return view('direktur.validasi-data_dir', [
            'breadcrumb' => (object)[
                'title' => 'Validasi Data',
                'list' => ['Home', 'Validasi Data']
            ],
            'activeMenu' => 'validasi-data',
            'dataValidasi' => $dataValidasi,
        ]);
    }

    public function show($id)
    {
        // Tampilkan detail PDF atau komentar per kriteria
        // Bisa ditambahkan logic di sini nanti
    }

    public function updateStatus(Request $request, $id)
    {
        $validasi = ValidasiModel::findOrFail($id);
        $validasi->status = $request->status; // "Valid" / "Belum Valid"
        $validasi->id_user = Auth::id(); // ID user Dir yang validasi
        $validasi->save();

        return redirect()->back()->with('success', 'Status validasi berhasil diperbarui.');
    }
}
