<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use App\Models\ValidasiModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ValidasiTahapSatuController extends Controller
{
    public function index()
    {
        $activeMenu = 'validasitahapsatu';
        $breadcrumb = (object) [
            'title' => 'Validasi Tahap Satu',
            'list' => ['Home', 'Validasi Tahap Satu']
        ];

        return view('validasitahapsatu.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function list(Request $request)
    {
        try {
            $validasi = ValidasiModel::with(['kriteria', 'user'])
                ->select('t_validasi.*');

            return DataTables::eloquent($validasi)
                ->addIndexColumn()
                ->addColumn('id_validasi', fn($v) => $v->id_validasi)
                ->addColumn('nama_kriteria', fn($v) => $v->kriteria->nama_kriteria ?? 'N/A')
                ->addColumn('nama_data', fn($v) => $v->user->name ?? 'System') // Assuming m_user has a 'name' field
                ->addColumn('tanggal_upload', function($v) {
                    return $v->tanggal->format('d-m-Y');
                })
                ->addColumn('url_data_pendukung', fn($v) => $v->user->name ?? 'N/A') // Placeholder for URL
                ->addColumn('status_validasi', fn($v) => $v->status)
                ->addColumn('aksi', function ($v) {
                    $status = $v->status;
                    $buttons = '<div class="text-center">' .
                        '<button onclick="showDetail(\'' . url('/validasi-tahap-satu/'. $v->id_validasi . '/show_ajax').'\')" class="btn btn-sm btn-info mr-1">Detail</button>';

                    if ($status != 'Sudah Tugas Tim') {
                        $buttons .= '<button onclick="approveAction(\'' . url('/validasi-tahap-satu/'. $v->id_validasi . '/approve_ajax').'\')" class="btn btn-sm btn-success mr-1">Setuju</button>' .
                                    '<button onclick="rejectAction(\'' . url('/validasi-tahap-satu/'. $v->id_validasi . '/reject_ajax').'\')" class="btn btn-sm btn-danger mr-1">Tolak</button>';
                    }

                    $buttons .= '<button onclick="notesAction(\'' . url('/validasi-tahap-satu/'. $v->id_validasi . '/notes_ajax').'\')" class="btn btn-sm btn-warning">Catatan</button>' .
                                '</div>';

                    return $buttons;
                })
                ->rawColumns(['aksi'])
                ->toJson();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show_ajax($id)
    {
        $validasi = ValidasiModel::with(['kriteria', 'user'])->findOrFail($id);
        return view('validasi_tahap_satu.show_ajax', compact('validasi'));
    }

    public function approve_ajax(Request $request, $id)
    {
        try {
            $validasi = ValidasiModel::findOrFail($id);
            $validasi->update([
                'status' => 'Sudah Tugas Tim',
                'updated_at' => now()->setTimezone('Asia/Jakarta'),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Validasi berhasil disetujui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyetujui validasi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reject_ajax(Request $request, $id)
    {
        try {
            $validasi = ValidasiModel::findOrFail($id);
            $validasi->update([
                'status' => 'Belum Validasi',
                'updated_at' => now()->setTimezone('Asia/Jakarta'),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Validasi berhasil ditolak'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menolak validasi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function notes_ajax(Request $request, $id)
    {
        $validasi = ValidasiModel::findOrFail($id);
        return view('validasitahapsatu.notes_ajax', compact('validasi'));
    }
}