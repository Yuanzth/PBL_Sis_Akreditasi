<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use App\Models\ValidasiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class ValidasiTahapDuaController extends Controller
{
    public function index()
    {
        $activeMenu = 'validasitahapdua';
        $breadcrumb = (object) [
            'title' => 'Validasi Tahap Dua',
            'list' => ['Home', 'Validasi Tahap Dua']
        ];

        return view('validasitahapdua.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function list(Request $request)
    {
        try {
            $query = KriteriaModel::select('m_kriteria.*')
                ->with([
                    'validasi' => function ($query) {
                        $query->orderBy('updated_at', 'desc')->first();
                    },
                    'validasi.user'
                ])
                ->whereHas('validasi', function ($query) {
                    $query->where('status', 'Sudah Tugas Tim');
                });

            return DataTables::eloquent($query)
                ->addColumn('nama_kriteria', fn($row) => 'Kriteria ' . $row->id_kriteria)
                ->addColumn('tanggal_submit', fn($row) => $row->status_selesai === 'Submitted' ? ($row->updated_at ?? $row->created_at)->format('d-m-Y H:i:s') : '-')
                ->addColumn('tanggal_validasi', function ($row) {
                    $validasi = $row->validasi->first();
                    return $validasi ? $validasi->updated_at->format('d-m-Y H:i:s') : '-';
                })
                ->addColumn('status_validasi', function ($row) {
                    $validasi = $row->validasi->first();
                    $status = $validasi ? $validasi->status : null;
                    if ($status === 'Sudah Tugas Tim') {
                        return '<span class="status-valid">Valid</span>';
                    } elseif ($status === 'Belum Validasi') {
                        return '<span class="status-rejected">Ditolak</span>';
                    } else {
                        return '<span class="status-onprogress">On Progress</span>';
                    }
                })
                ->addColumn('divalidasi_oleh', function ($row) {
                    $validasi = $row->validasi->first();
                    return $validasi && $validasi->user ? $validasi->user->name : '-';
                })
                ->addColumn('aksi', function ($row) {
                    $buttons = '<div class="text-center">' .
                        '<button onclick="showDetail(\'' . url('/validasi-tahap-dua/' . $row->id_kriteria . '/show_ajax') . '\')" class="btn btn-sm btn-info mr-1">Lihat</button>' .
                        '<button onclick="approveAction(\'' . url('/validasi-tahap-dua/' . $row->id_kriteria . '/approve_ajax') . '\', ' . $row->id_kriteria . ')" class="btn btn-sm btn-success mr-1">Diterima</button>' .
                        '<button onclick="rejectAction(\'' . url('/validasi-tahap-dua/' . $row->id_kriteria . '/reject_ajax') . '\', ' . $row->id_kriteria . ')" class="btn btn-sm btn-danger mr-1">Ditolak</button>' .
                        '</div>';
                    return $buttons;
                })
                ->rawColumns(['status_validasi', 'aksi'])
                ->toJson();
        } catch (\Exception $e) {
            Log::error('Error in ValidasiTahapDuaController@list: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Terjadi kesalahan pada server: ' . $e->getMessage()], 500);
        }
    }

    public function show_ajax($id)
    {
        $kriteria = KriteriaModel::with([
            'validasi' => function ($query) {
                $query->orderBy('updated_at', 'desc')->first();
            },
            'user'
        ])->findOrFail($id);
        $latestValidation = $kriteria->validasi->first();
        $googleDriveLink = $latestValidation ? $latestValidation->google_drive_link : null;

        // Ambil path PDF dari t_generated_document
        $generatedDocument = GeneratedDocumentModel::where('id_kriteria', $id)->first();
        $pdfPath = $generatedDocument ? asset('storage/' . $generatedDocument->generated_document) : null;

        return view('validasitahapdua.show_ajax', compact('kriteria', 'googleDriveLink', 'pdfPath'));
    }

    public function approve_ajax(Request $request, $id)
    {
        try {
            $kriteria = KriteriaModel::findOrFail($id);
            $comment = $request->input('comment', '');
            $validasi = ValidasiModel::create([
                'id_kriteria' => $id,
                'id_user' => auth()->id(),
                'status' => 'Final',
                'comment' => $comment,
                'updated_at' => now()->setTimezone('Asia/Jakarta'),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Validasi tahap dua berhasil diterima'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menerima validasi tahap dua: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reject_ajax(Request $request, $id)
    {
        try {
            $kriteria = KriteriaModel::findOrFail($id);
            $comment = $request->input('comment', '');
            $validasi = ValidasiModel::create([
                'id_kriteria' => $id,
                'id_user' => auth()->id(),
                'status' => 'Ditolak',
                'comment' => $comment,
                'updated_at' => now()->setTimezone('Asia/Jakarta'),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Validasi tahap dua berhasil ditolak'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menolak validasi tahap dua: ' . $e->getMessage()
            ], 500);
        }
    }
}
?>