<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use App\Models\DetailKriteriaModel;
use App\Models\DataPendukungModel;
use App\Models\GeneratedDocumentModel;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index($id = null)
    {
        // Jika tidak ada ID, tampilkan halaman utama (welcome)
        if (is_null($id)) {
            return view('welcome');
        }

        // Validasi ID kriteria (1-9)
        if (!in_array($id, range(1, 9))) {
            abort(404, 'Kriteria tidak valid');
        }

        // Ambil data Kriteria berdasarkan ID
        $kriteria = KriteriaModel::where('id_kriteria', $id)->first();

        if (!$kriteria) {
            abort(404, 'Kriteria tidak ditemukan');
        }

        // Cek apakah kriteria sudah difinalisasi (status Submitted)
        if ($kriteria->status_selesai !== 'Submitted') {
            abort(403, 'Kriteria ini belum difinalisasi dan tidak dapat dilihat oleh publik');
        }

        // Ambil detail kriteria berdasarkan kategori (Penetapan, Pelaksanaan, dll.)
        $detailKriteria = DetailKriteriaModel::with(['kategori', 'dataPendukung'])
            ->where('id_kriteria', $id)
            ->get()
            ->groupBy('kategori.nama_kategori'); // Group berdasarkan nama kategori

        // Ambil dokumen PDF yang sudah digenerate (jika ada)
        $generatedDocument = GeneratedDocumentModel::where('id_kriteria', $id)->first();

        return view('components.kriteria', [
            'kriteria' => $kriteria,
            'detailKriteria' => $detailKriteria,
            'generatedDocument' => $generatedDocument,
            'breadcrumb' => (object) [
                'title' => 'Kriteria ' . $id,
                'list' => ['Home', 'Kriteria ' . $id]
            ],
        ]);
    }
}