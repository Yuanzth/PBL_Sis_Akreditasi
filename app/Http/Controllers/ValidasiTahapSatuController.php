<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use App\Models\ValidasiModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

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
            $query = KriteriaModel::select('m_kriteria.*')
                ->with(['validasi' => function ($query) {
                    $query->orderBy('updated_at', 'desc')->first();
                }, 'validasi.user'])
                ->whereIn('id_kriteria', range(1, 9));

            return DataTables::eloquent($query)
                ->addColumn('nama_kriteria', fn($row) => 'Kriteria ' . $row->id_kriteria)
                ->addColumn('tanggal_submit', fn($row) => $row->status_selesai === 'Submitted' ? ($row->updated_at ?? $row->created_at)->format('d-m-Y H:i:s') : '-')
                ->addColumn('status_submit', function ($row) {
                    return $row->status_selesai === 'Submitted'
                        ? '<span class="status-valid">Submitted</span>'
                        : '<span class="status-onprogress">On Progress</span>';
                })
                ->addColumn('status_validasi', function ($row) {
                    $status = $row->validasi->first()->status ?? null;
                    if ($status === 'Sudah Tugas Tim') {
                        return '<span class="status-valid">Valid</span>';
                    } elseif ($status === 'Belum Validasi') {
                        return '<span class="status-rejected">Ditolak</span>';
                    } else {
                        return '<span class="status-onprogress">On Progress</span>';
                    }
                })
                ->addColumn('divalidasi_oleh', function ($row) {
                    return $row->validasi->first() && $row->validasi->first()->user ? $row->validasi->first()->user->name : '-';
                })
                ->addColumn('status_selesai', function ($row) {
                    return $row->status_selesai === 'Submitted'
                        ? '<span class="status-valid">Submitted</span>'
                        : '<span class="status-onprogress">On Progress</span>';
                })
                ->addColumn('aksi', function ($row) {
                    $status = $row->validasi->first()->status ?? 'On Progress';
                    $buttons = '<div class="text-center">' .
                        '<button onclick="showDetail(\'' . url('/validasitahapsatu/' . $row->id_kriteria . '/show_ajax') . '\')" class="btn btn-sm btn-info mr-1">Lihat</button>';

                    if ($row->status_selesai === 'Submitted' && $status !== 'Sudah Tugas Tim') {
                        $buttons .= '<button onclick="approveAction(\'' . url('/validasitahapsatu/' . $row->id_kriteria . '/approve_ajax') . '\')" class="btn btn-sm btn-success mr-1">Diterima</button>' .
                                    '<button onclick="rejectAction(\'' . url('/validasitahapsatu/' . $row->id_kriteria . '/reject_ajax') . '\')" class="btn btn-sm btn-danger mr-1">Ditolak</button>';
                    }

                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['status_submit', 'status_validasi', 'status_selesai', 'aksi'])
                ->toJson();
        } catch (\Exception $e) {
            Log::error('Error in ValidasiTahapSatuController@list: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Terjadi kesalahan pada server'], 500);
        }
    }

    public function show_ajax($id)
    {
        $kriteria = KriteriaModel::with(['validasi' => function ($query) {
            $query->orderBy('updated_at', 'desc')->first();
        }, 'user'])->findOrFail($id);
        $latestValidation = $kriteria->validasi->first();
        $googleDriveLink = $latestValidation ? $latestValidation->google_drive_link : null; // Ganti dengan kolom yang sesuai jika ada
        return view('validasitahapsatu.show_ajax', compact('kriteria', 'googleDriveLink'));
    }

    public function approve_ajax(Request $request, $id)
    {
        try {
            $kriteria = KriteriaModel::findOrFail($id);
            $comment = $request->input('comment', ''); // Ambil komentar dari request
            $validasi = ValidasiModel::create([
                'id_kriteria' => $id,
                'id_user' => auth()->id(),
                'status' => 'Sudah Tugas Tim',
                'comment' => $comment,
                'updated_at' => now()->setTimezone('Asia/Jakarta'),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Validasi berhasil diterima'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menerima validasi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reject_ajax(Request $request, $id)
    {
        try {
            $kriteria = KriteriaModel::findOrFail($id);
            $comment = $request->input('comment', ''); // Ambil komentar dari request
            $validasi = ValidasiModel::create([
                'id_kriteria' => $id,
                'id_user' => auth()->id(),
                'status' => 'Belum Validasi',
                'comment' => $comment,
                'updated_at' => now()->setTimezone('Asia/Jakarta'),
            ]);
            $kriteria->update(['status_selesai' => 'Save']);

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
        // Tombol Catatan dinonaktifkan, fungsi ini tidak digunakan lagi
        return response()->json(['status' => false, 'message' => 'Fungsi tidak tersedia']);
    }
}
?>