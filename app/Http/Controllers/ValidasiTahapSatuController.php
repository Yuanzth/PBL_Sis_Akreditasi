<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use App\Models\ValidasiModel;
use App\Models\GeneratedDocumentModel;
use App\Models\UserModel;
use App\Models\KomentarModel;
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
                ->with([
                    'validasi' => function ($query) {
                        $query->orderBy('updated_at', 'desc')->first();
                    },
                    'validasi.user'
                ])
                ->whereIn('id_kriteria', range(1, 9));

            $statusFilter = $request->input('status_validasi');

            if ($statusFilter) {
                $query->whereHas('validasi', function ($query) use ($statusFilter) {
                    $query->where('status', $statusFilter);
                })->orWhereDoesntHave('validasi');
            }

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
                    $button = '<div class="text-center">';
                    if ($row->status_selesai === 'Submitted') {
                        $button .= '<a href="' . route('validasi.tahap.satu.show', $row->id_kriteria) . '" class="btn btn-sm btn-info mr-1">Lihat</a>';
                    } else {
                        $button .= '<button onclick="showNotSubmittedAlert()" class="btn btn-sm btn-info mr-1">Lihat</button>';
                    }
                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['status_submit', 'status_validasi', 'status_selesai', 'aksi'])
                ->toJson();
        } catch (\Exception $e) {
            Log::error('Error in ValidasiTahapSatuController@list: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Terjadi kesalahan pada server'], 500);
        }
    }

    public function show($id)
    {
        try {
            $kriteria = KriteriaModel::with([
                'validasi' => function ($query) {
                    $query->orderBy('updated_at', 'desc')->first();
                },
                'user'
            ])->findOrFail($id);

            $generatedDocument = GeneratedDocumentModel::where('id_kriteria', $id)->first();
            $pdfPath = $generatedDocument ? asset('storage/' . $generatedDocument->generated_document) : null;

            $activeMenu = 'validasitahapsatu';
            $breadcrumb = (object) [
                'title' => 'Detail Validasi',
                'list' => ['Home', 'Validasi Data', 'Detail Validasi']
            ];

            return view('validasitahapsatu.show', compact('kriteria', 'pdfPath', 'activeMenu', 'breadcrumb'));
        } catch (\Exception $e) {
            Log::error('Error in ValidasiTahapSatuController@show: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Terjadi kesalahan internal');
        }
    }

    public function approve(Request $request, $id)
    {
        try {
            $kriteria = KriteriaModel::findOrFail($id);
            $comment = $request->input('comment', '');

            // Simpan validasi ke t_validasi
            $validasi = ValidasiModel::create([
                'id_kriteria' => $id,
                'id_user' => auth()->id(),
                'status' => 'Sudah Tugas Tim',
                'created_at' => now()->setTimezone('Asia/Jakarta'),
                'updated_at' => now()->setTimezone('Asia/Jakarta'),
            ]);

            // Simpan komentar ke t_komentar jika ada
            if (!empty($comment)) {
                KomentarModel::create([
                    'id_kriteria' => $id,
                    'id_user' => auth()->id(),
                    'komentar' => $comment,
                    'created_at' => now()->setTimezone('Asia/Jakarta'),
                    'updated_at' => now()->setTimezone('Asia/Jakarta'),
                ]);
            }

            return redirect()->back()->with('success', 'Validasi berhasil diterima');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menerima validasi: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        try {
            $kriteria = KriteriaModel::findOrFail($id);
            $comment = $request->input('comment', '');

            // Simpan validasi ke t_validasi
            $validasi = ValidasiModel::create([
                'id_kriteria' => $id,
                'id_user' => auth()->id(),
                'status' => 'Belum Validasi',
                'created_at' => now()->setTimezone('Asia/Jakarta'),
                'updated_at' => now()->setTimezone('Asia/Jakarta'),
            ]);

            // Simpan komentar ke t_komentar jika ada
            if (!empty($comment)) {
                KomentarModel::create([
                    'id_kriteria' => $id,
                    'id_user' => auth()->id(),
                    'komentar' => $comment,
                    'created_at' => now()->setTimezone('Asia/Jakarta'),
                    'updated_at' => now()->setTimezone('Asia/Jakarta'),
                ]);
            }

            // Update status_selesai di m_kriteria menjadi 'Save'
            $kriteria->update(['status_selesai' => 'Save']);

            return redirect()->back()->with('success', 'Validasi berhasil ditolak');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menolak validasi: ' . $e->getMessage());
        }
    }

    public function notes_ajax(Request $request, $id)
    {
        return response()->json(['status' => false, 'message' => 'Fungsi tidak tersedia']);
    }
}
?>