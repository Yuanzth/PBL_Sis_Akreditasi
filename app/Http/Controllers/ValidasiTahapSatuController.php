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
            'title' => 'Validasi Data',
            'list' => ['Home', 'Validasi Data']
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
                ->select('t_validasi')
                ->select('m_kriteria');

            return DataTables::eloquent($validasi)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex', fn($row) => $row->getIndex())
                ->addColumn('nama_kriteria', fn($v) => $v->kriteria->nama_kriteria ?? 'N/A')
                ->addColumn('tanggal_submit', fn($v) => $v->tanggal ? $v->tanggal->format('d-m-Y') : '-')
                ->addColumn('status_submit', function ($v) {
                    return $v->url_data_pendukung ? $v->url_data_pendukung : '-';
                })
                ->addColumn('status_validasi', function ($v) {
                    if ($v->status === 'Sudah Tugas Tim') {
                        return 'Valid';
                    } elseif ($v->status === 'Belum Validasi') {
                        return 'Ditolak';
                    } else {
                        return 'On Progress';
                    }
                })
                ->addColumn('divalidasi_oleh', fn($v) => $v->user->name ?? 'System')
                ->addColumn('aksi', function ($v) {
                    $status = $v->status;
                    $buttons = '<div class="text-center">' .
                        '<button onclick="showDetail(\'' . url('/validasitahapsatu/' . $v->id_validasi . '/show_ajax') . '\')" class="btn btn-sm btn-info mr-1">Detail</button>';

                    if ($status != 'Sudah Tugas Tim') {
                        $buttons .= '<button onclick="approveAction(\'' . url('/validasitahapsatu/' . $v->id_validasi . '/approve_ajax') . '\')" class="btn btn-sm btn-success mr-1">Setuju</button>' .
                                    '<button onclick="rejectAction(\'' . url('/validasitahapsatu/' . $v->id_validasi . '/reject_ajax') . '\')" class="btn btn-sm btn-danger mr-1">Tolak</button>';
                    }

                    $buttons .= '<button onclick="notesAction(\'' . url('/validasitahapsatu/' . $v->id_validasi . '/notes_ajax') . '\')" class="btn btn-sm btn-warning">Catatan</button>' .
                                '</div>';

                    return $buttons;
                })
                ->rawColumns(['status_submit', 'status_validasi', 'aksi'])
                ->toJson();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show_ajax($id)
    {
        $validasi = ValidasiModel::with(['kriteria', 'user'])->findOrFail($id);
        return view('validasitahapsatu.show_ajax', compact('validasi'));
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