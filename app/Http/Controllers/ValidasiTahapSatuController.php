<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use App\Models\ValidasiModel;
use App\Models\GeneratedDocumentModel;
use App\Models\KomentarModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class ValidasiTahapSatuController extends Controller
{
    public function index()
    {
        $activeMenu = 'validasi-data';
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
                        $query->whereIn('id_user', [10, 11, 12, 13])
                            ->orderBy('updated_at', 'desc')
                            ->with('user'); // Memuat relasi user melalui validasi
                    }
                ])
                ->whereIn('id_kriteria', range(1, 9));

            $statusFilter = $request->input('status_validasi');

            if ($statusFilter) {
                $query->whereHas('validasi', function ($query) use ($statusFilter) {
                    $query->whereIn('id_user', [10, 11])
                        ->where('status', $statusFilter);
                });
            }

            return DataTables::eloquent($query)
                ->addColumn('nama_kriteria', fn($row) => 'Kriteria ' . $row->id_kriteria)
                ->addColumn('tanggal_submit', fn($row) => $row->status_selesai === 'Submitted' ? ($row->updated_at ?? $row->created_at)->format('d-m-Y H:i:s') : '-')
                ->addColumn('tanggal_validasi', function ($row) {
                    $validasi = $row->validasi->whereIn('id_user', [10, 11])
                        ->where('updated_at', '>=', $row->updated_at)
                        ->first();
                    return $validasi ? $validasi->updated_at->format('d-m-Y H:i:s') : '-';
                })
                ->addColumn('status_validasi', function ($row) {
                    $validasiTahapSatu = $row->validasi->whereIn('id_user', [10, 11])
                        ->where('updated_at', '>=', $row->updated_at)
                        ->first();
                    $validasiTahapDua = $row->validasi->whereIn('id_user', [12, 13])
                        ->where('updated_at', '>=', $row->updated_at)
                        ->first();

                    if ($row->status_selesai === 'Submitted' && !$validasiTahapSatu) {
                        return '<span class="status-onprogress">On Progress</span>';
                    }

                    if (!$validasiTahapSatu) {
                        $validasiTahapSatuSebelumnya = $row->validasi->whereIn('id_user', [10, 11])
                            ->where('updated_at', '<', $row->updated_at)
                            ->first();
                        $validasiTahapDuaSebelumnya = $row->validasi->whereIn('id_user', [12, 13])
                            ->where('updated_at', '<', $row->updated_at)
                            ->first();

                        if ($validasiTahapSatuSebelumnya && $validasiTahapSatuSebelumnya->status === 'Belum Validasi' && $validasiTahapDuaSebelumnya && $validasiTahapDuaSebelumnya->status === 'Belum Validasi') {
                            return '<span class="status-rejected">Ditolak KJM/Direktur</span>';
                        }
                        return '<span class="status-onprogress">On Progress</span>';
                    }

                    if ($validasiTahapSatu->status === 'Valid' && !$validasiTahapDua) {
                        return '<span class="status-valid">Valid</span>';
                    }

                    if ($validasiTahapSatu->status === 'Belum Validasi') {
                        if ($validasiTahapDua && $validasiTahapDua->status === 'Belum Validasi') {
                            return '<span class="status-rejected">Ditolak KJM/Direktur</span>';
                        }
                        return '<span class="status-rejected">Ditolak</span>';
                    }

                    if ($validasiTahapDua && $validasiTahapDua->status === 'Valid') {
                        return '<span class="status-valid">Valid</span>';
                    }

                    return '<span class="status-onprogress">On Progress</span>';
                })
                ->addColumn('divalidasi_oleh', function ($row) {
                    $validasi = $row->validasi->whereIn('id_user', [10, 11])
                        ->where('updated_at', '>=', $row->updated_at)
                        ->first();
                    return $validasi && $validasi->user ? $validasi->user->name : '-';
                })
                ->addColumn('status_selesai', function ($row) {
                    return $row->status_selesai === 'Submitted'
                        ? '<span class="status-valid">Submitted</span>'
                        : '<span class="status-onprogress">On Progress</span>';
                })
                ->addColumn('aksi', function ($row) {
                    $button = '<div class="text-center">';
                    $validasiTahapSatuSetelahSubmit = $row->validasi->whereIn('id_user', [10, 11])
                        ->where('updated_at', '>=', $row->updated_at)
                        ->first();
                    $validasiTahapDuaSetelahSubmit = $row->validasi->whereIn('id_user', [12, 13])
                        ->where('updated_at', '>=', $row->updated_at)
                        ->first();

                    // Tombol aktif jika status_selesai = "Submitted" dan belum ada validasi tahap satu setelah submit terakhir
                    if ($row->status_selesai === 'Submitted' && !$validasiTahapSatuSetelahSubmit) {
                        $button .= '<a href="' . route('validasi.tahap.satu.show', $row->id_kriteria) . '" class="btn btn-sm btn-info btn-active mr-1 position-relative">Lihat<span class="badge-exclamation">!</span></a>';
                    } elseif ($validasiTahapSatuSetelahSubmit && $validasiTahapSatuSetelahSubmit->status === 'Valid' && (!$validasiTahapDuaSetelahSubmit || $validasiTahapDuaSetelahSubmit->status !== 'Valid')) {
                        $button .= '<a href="' . route('validasi.tahap.satu.show', $row->id_kriteria) . '" class="btn btn-sm btn-info btn-validated mr-1">Lihat</a>';
                    } elseif ($validasiTahapDuaSetelahSubmit && $validasiTahapDuaSetelahSubmit->status === 'Valid') {
                        $button .= '<a href="' . route('validasi.tahap.satu.show', $row->id_kriteria) . '" class="btn btn-sm btn-info btn-validated mr-1">Lihat</a>';
                    } else {
                        $button .= '<button onclick="showNotSubmittedAlert()" class="btn btn-sm btn-info btn-disabled mr-1">Lihat</button>';
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
                    $query->whereIn('id_user', [10, 11, 12, 13])
                        ->orderBy('updated_at', 'desc')
                        ->with('user'); // Memuat relasi user melalui validasi
                }
            ])->findOrFail($id);

            $generatedDocument = GeneratedDocumentModel::where('id_kriteria', $id)->first();
            $pdfPath = $generatedDocument ? asset('storage/' . $generatedDocument->generated_document) : null;

            $activeMenu = 'validasi-data';
            $breadcrumb = (object) [
                'title' => 'Detail Validasi Data',
                'list' => ['Home', 'Validasi Data', 'Detail Validasi']
            ];

            return view('validasitahapsatu.show', compact('kriteria', 'pdfPath', 'activeMenu', 'breadcrumb'));
        } catch (\Exception $e) {
            Log::error('Error in ValidasiTahapSatuController@show: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('validasi.tahap.satu')->with('error', 'Terjadi kesalahan internal');
        }
    }

    public function approve(Request $request, $id)
    {
        try {
            $kriteria = KriteriaModel::findOrFail($id);
            $comment = $request->input('comment', '');

            $validasi = ValidasiModel::where('id_kriteria', $id)
                ->whereIn('id_user', [10, 11])
                ->where('updated_at', '>=', $kriteria->updated_at)
                ->orderBy('updated_at', 'desc')
                ->first();

            if ($validasi) {
                $validasi->update([
                    'status' => 'Valid',
                    'updated_at' => now()->setTimezone('Asia/Jakarta'),
                ]);
            } else {
                $validasi = ValidasiModel::create([
                    'id_kriteria' => $id,
                    'id_user' => auth()->id(),
                    'status' => 'Valid',
                    'created_at' => now()->setTimezone('Asia/Jakarta'),
                    'updated_at' => now()->setTimezone('Asia/Jakarta'),
                ]);
            }

            if (!empty($comment)) {
                KomentarModel::create([
                    'id_kriteria' => $id,
                    'id_user' => auth()->id(),
                    'komentar' => $comment,
                    'created_at' => now()->setTimezone('Asia/Jakarta'),
                    'updated_at' => now()->setTimezone('Asia/Jakarta'),
                ]);
            }

            if ($request->ajax()) {
                return response()->json(['success' => 'Validasi tahap satu berhasil diterima']);
            }
            return redirect()->back()->with('success', 'Validasi tahap satu berhasil diterima');
        } catch (\Exception $e) {
            Log::error('Error in ValidasiTahapSatuController@approve: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            if ($request->ajax()) {
                return response()->json(['error' => 'Gagal menerima validasi tahap satu: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Gagal menerima validasi tahap satu: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        try {
            $kriteria = KriteriaModel::findOrFail($id);
            $comment = $request->input('comment', '');

            if (empty($comment)) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'Komentar diperlukan untuk menolak validasi'], 422);
                }
                return redirect()->back()->with('error', 'Komentar diperlukan untuk menolak validasi');
            }

            $validasi = ValidasiModel::where('id_kriteria', $id)
                ->whereIn('id_user', [10, 11])
                ->where('updated_at', '>=', $kriteria->updated_at)
                ->orderBy('updated_at', 'desc')
                ->first();

            if ($validasi) {
                $validasi->update([
                    'status' => 'Belum Validasi',
                    'updated_at' => now()->setTimezone('Asia/Jakarta'),
                ]);
            } else {
                $validasi = ValidasiModel::create([
                    'id_kriteria' => $id,
                    'id_user' => auth()->id(),
                    'status' => 'Belum Validasi',
                    'created_at' => now()->setTimezone('Asia/Jakarta'),
                    'updated_at' => now()->setTimezone('Asia/Jakarta'),
                ]);
            }

            $kriteria->update(['status_selesai' => 'Save']);

            if (!empty($comment)) {
                KomentarModel::create([
                    'id_kriteria' => $id,
                    'id_user' => auth()->id(),
                    'komentar' => $comment,
                    'created_at' => now()->setTimezone('Asia/Jakarta'),
                    'updated_at' => now()->setTimezone('Asia/Jakarta'),
                ]);
            }

            if ($request->ajax()) {
                return response()->json(['success' => 'Validasi tahap satu berhasil ditolak']);
            }
            return redirect()->back()->with('success', 'Validasi tahap satu berhasil ditolak');
        } catch (\Exception $e) {
            Log::error('Error in ValidasiTahapSatuController@reject: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            if ($request->ajax()) {
                return response()->json(['error' => 'Gagal menolak validasi tahap satu: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Gagal menolak validasi tahap satu: ' . $e->getMessage());
        }
    }
}