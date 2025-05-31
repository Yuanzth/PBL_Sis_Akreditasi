<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use App\Models\ValidasiModel;
use App\Models\GeneratedDocumentModel;
use App\Models\KomentarModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class ValidasiTahapDuaController extends Controller
{
    public function index()
    {
        $activeMenu = 'validasi-tahap-dua';
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
                        $query->whereIn('id_user', [10, 11, 12, 13])
                            ->orderBy('updated_at', 'desc');
                    },
                    'validasi.user'
                ])
                ->whereIn('id_kriteria', range(1, 9));

            $statusFilter = $request->input('status_validasi');

            if ($statusFilter) {
                $query->whereHas('validasi', function ($query) use ($statusFilter) {
                    $query->whereIn('id_user', [12, 13])
                          ->where('status', $statusFilter);
                });
            }

            return DataTables::eloquent($query)
                ->addColumn('nama_kriteria', fn($row) => 'Kriteria ' . $row->id_kriteria)
                ->addColumn('tanggal_submit', fn($row) => $row->status_selesai === 'Submitted' ? ($row->updated_at ?? $row->created_at)->format('d-m-Y H:i:s') : '-')
                ->addColumn('tanggal_validasi', function ($row) {
                    $validasiTahapSatu = $row->validasi->whereIn('id_user', [10, 11])
                        ->where('updated_at', '>=', $row->updated_at)
                        ->first();
                    return $validasiTahapSatu ? $validasiTahapSatu->updated_at->format('d-m-Y H:i:s') : '-';
                })
                ->addColumn('status_validasi', function ($row) {
                    $validasiTahapSatu = $row->validasi->whereIn('id_user', [10, 11])
                        ->where('updated_at', '>=', $row->updated_at)
                        ->first();
                    $validasiTahapDua = $row->validasi->whereIn('id_user', [12, 13])
                        ->where('updated_at', '>=', $row->updated_at)
                        ->first();

                    if (!$validasiTahapSatu) {
                        return '<span class="status-onprogress">On Progress</span>';
                    }

                    if ($validasiTahapSatu->status === 'Valid' && !$validasiTahapDua) {
                        return '<span class="status-onkjm">Menunggu Validasi KJM/Direktur</span>';
                    }

                    if ($validasiTahapDua) {
                        if ($validasiTahapDua->status === 'Valid') {
                            return '<span class="status-valid">Valid</span>';
                        } elseif ($validasiTahapDua->status === 'Belum Validasi') {
                            return '<span class="status-rejected">Ditolak</span>';
                        }
                    }

                    return '<span class="status-onprogress">On Progress</span>';
                })
                ->addColumn('divalidasi_oleh', function ($row) {
                    $validasiTahapSatu = $row->validasi->whereIn('id_user', [10, 11])
                        ->where('updated_at', '>=', $row->updated_at)
                        ->first();
                    $validasiTahapDua = $row->validasi->whereIn('id_user', [12, 13])
                        ->where('updated_at', '>=', $row->updated_at)
                        ->first();

                    $tahapSatuValidator = $validasiTahapSatu && $validasiTahapSatu->user ? $validasiTahapSatu->user->name : '-';
                    $tahapDuaValidator = $validasiTahapDua && $validasiTahapDua->user ? $validasiTahapDua->user->name : '-';

                    return $tahapSatuValidator . ($tahapDuaValidator !== '-' ? ' / ' . $tahapDuaValidator : '');
                })
                ->addColumn('status_selesai', function ($row) {
                    return $row->status_selesai === 'Submitted'
                        ? '<span class="status-valid">Submitted</span>'
                        : '<span class="status-onprogress">On Progress</span>';
                })
                ->addColumn('aksi', function ($row) {
                    $button = '<div class="text-center">';
                    $validasiTahapSatu = $row->validasi->whereIn('id_user', [10, 11])
                        ->where('updated_at', '>=', $row->updated_at)
                        ->first();
                    $validasiTahapDua = $row->validasi->whereIn('id_user', [12, 13])
                        ->where('updated_at', '>=', $row->updated_at)
                        ->first();

                    if ($validasiTahapSatu && $validasiTahapSatu->status === 'Valid' && !$validasiTahapDua && $row->status_selesai === 'Submitted') {
                        $button .= '<a href="' . route('validasi.tahap.dua.show', $row->id_kriteria) . '" class="btn btn-sm btn-info btn-active mr-1 position-relative">Lihat<span class="badge-exclamation">!</span></a>';
                    } elseif ($validasiTahapSatu && $validasiTahapSatu->status === 'Valid' && $row->status_selesai === 'Submitted') {
                        $button .= '<a href="' . route('validasi.tahap.dua.show', $row->id_kriteria) . '" class="btn btn-sm btn-info btn-validated mr-1">Lihat</a>';
                    } else {
                        $button .= '<button onclick="showNotSubmittedAlert()" class="btn btn-sm btn-info btn-disabled mr-1">Lihat</button>';
                    }
                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['status_submit', 'status_validasi', 'status_selesai', 'aksi'])
                ->toJson();
        } catch (\Exception $e) {
            Log::error('Error in ValidasiTahapDuaController@list: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Terjadi kesalahan pada server'], 500);
        }
    }

    public function show($id)
    {
        try {
            $kriteria = KriteriaModel::with([
                'validasi' => function ($query) {
                    $query->whereIn('id_user', [10, 11, 12, 13])
                        ->orderBy('updated_at', 'desc');
                },
                'user'
            ])->findOrFail($id);

            $validasiTahapSatu = $kriteria->validasi->whereIn('id_user', [10, 11])
                ->where('updated_at', '>=', $kriteria->updated_at)
                ->first();
            if (!$validasiTahapSatu || $validasiTahapSatu->status !== 'Valid') {
                return redirect()->route('validasi.tahap.dua')->with('error', 'Kriteria ini belum divalidasi pada tahap satu.');
            }

            $generatedDocument = GeneratedDocumentModel::where('id_kriteria', $id)->first();
            $pdfPath = $generatedDocument ? asset('storage/' . $generatedDocument->generated_document) : null;

            $activeMenu = 'validasi-tahap-dua';
            $breadcrumb = (object) [
                'title' => 'Detail Validasi Tahap Dua',
                'list' => ['Home', 'Validasi Tahap Dua', 'Detail Validasi']
            ];

            return view('validasitahapdua.show', compact('kriteria', 'pdfPath', 'activeMenu', 'breadcrumb'));
        } catch (\Exception $e) {
            Log::error('Error in ValidasiTahapDuaController@show: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('validasi.tahap.dua')->with('error', 'Terjadi kesalahan internal');
        }
    }

    public function approve(Request $request, $id)
    {
        try {
            $kriteria = KriteriaModel::findOrFail($id);
            $comment = $request->input('comment', '');

            $validasi = ValidasiModel::where('id_kriteria', $id)
                ->whereIn('id_user', [12, 13])
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
                return response()->json(['success' => 'Validasi tahap dua berhasil diterima']);
            }
            return redirect()->back()->with('success', 'Validasi tahap dua berhasil diterima');
        } catch (\Exception $e) {
            Log::error('Error in ValidasiTahapDuaController@approve: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            if ($request->ajax()) {
                return response()->json(['error' => 'Gagal menerima validasi tahap dua: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Gagal menerima validasi tahap dua: ' . $e->getMessage());
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

            // Ambil atau buat entri validasi untuk tahap dua
            $validasiTahapDua = ValidasiModel::where('id_kriteria', $id)
                ->whereIn('id_user', [12, 13])
                ->where('updated_at', '>=', $kriteria->updated_at)
                ->orderBy('updated_at', 'desc')
                ->first();

            if ($validasiTahapDua) {
                $validasiTahapDua->update([
                    'status' => 'Belum Validasi',
                    'updated_at' => now()->setTimezone('Asia/Jakarta'),
                ]);
            } else {
                $validasiTahapDua = ValidasiModel::create([
                    'id_kriteria' => $id,
                    'id_user' => auth()->id(),
                    'status' => 'Belum Validasi',
                    'created_at' => now()->setTimezone('Asia/Jakarta'),
                    'updated_at' => now()->setTimezone('Asia/Jakarta'),
                ]);
            }

            // Ubah status validasi tahap satu (KPS/Kajur) menjadi "Belum Validasi"
            $validasiTahapSatu = ValidasiModel::where('id_kriteria', $id)
                ->whereIn('id_user', [10, 11])
                ->where('updated_at', '>=', $kriteria->updated_at)
                ->orderBy('updated_at', 'desc')
                ->first();

            if ($validasiTahapSatu) {
                $validasiTahapSatu->update([
                    'status' => 'Belum Validasi',
                    'updated_at' => now()->setTimezone('Asia/Jakarta'),
                ]);
            }

            // Update status_selesai di m_kriteria menjadi 'Save'
            $kriteria->update(['status_selesai' => 'Save']);

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

            if ($request->ajax()) {
                return response()->json(['success' => 'Validasi tahap dua berhasil ditolak']);
            }
            return redirect()->back()->with('success', 'Validasi tahap dua berhasil ditolak');
        } catch (\Exception $e) {
            Log::error('Error in ValidasiTahapDuaController@reject: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            if ($request->ajax()) {
                return response()->json(['error' => 'Gagal menolak validasi tahap dua: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Gagal menolak validasi tahap dua: ' . $e->getMessage());
        }
    }
}