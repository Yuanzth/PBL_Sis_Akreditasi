<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use App\Models\DetailKriteriaModel;
use App\Models\DataPendukungModel;
use App\Models\ValidasiModel;
use App\Models\FinalDocumentModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Storage;
use Auth;

class FinalisasiController extends Controller
{
    public function index()
    {
        $activeMenu = 'finalisasi-dokumen';
        $breadcrumb = (object) [
            'title' => 'Finalisasi Dokumen',
            'list' => ['Home', 'Finalisasi Dokumen']
        ];

        // Ambil dokumen final (hanya satu) dengan penanganan error
        $finalDocument = FinalDocumentModel::with('user')->first();

        return view('finalisasi.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'finalDocument' => $finalDocument
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
                $query->where(function ($q) use ($statusFilter) {
                    $q->whereHas('validasi', function ($query) use ($statusFilter) {
                        $query->whereIn('id_user', [12, 13])
                            ->where('status', $statusFilter === 'Valid' ? 'Valid' : 'Belum Validasi');
                    })
                    ->orWhereDoesntHave('validasi', function ($query) use ($statusFilter) {
                        if ($statusFilter === 'Belum Divalidasi') {
                            $query->whereIn('id_user', [12, 13]);
                        }
                    });
                });
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('nama_kriteria', fn($row) => 'Kriteria ' . $row->id_kriteria)
                ->addColumn('tanggal_submit', fn($row) => $row->status_selesai === 'Submitted' ? ($row->updated_at ?? $row->created_at)->format('d-m-Y H:i:s') : '-')
                ->addColumn('tanggal_validasi', function ($row) {
                    $validasiTahapDua = $row->validasi->whereIn('id_user', [12, 13])
                        ->where('updated_at', '>=', $row->updated_at)
                        ->first();
                    return $validasiTahapDua ? $validasiTahapDua->updated_at->format('d-m-Y H:i:s') : '-';
                })
                ->addColumn('status_validasi', function ($row) {
                    $validasiTahapDua = $row->validasi->whereIn('id_user', [12, 13])
                        ->where('updated_at', '>=', $row->updated_at)
                        ->first();

                    if ($validasiTahapDua && $validasiTahapDua->status === 'Valid') {
                        return '<span class="status-valid">Valid</span>';
                    } elseif ($validasiTahapDua && $validasiTahapDua->status === 'Belum Validasi') {
                        return '<span class="status-rejected">Ditolak</span>';
                    }
                    return '<span class="status-onprogress">Belum Divalidasi</span>';
                })
                ->addColumn('divalidasi_oleh', function ($row) {
                    $validasiTahapDua = $row->validasi->whereIn('id_user', [12, 13])
                        ->where('updated_at', '>=', $row->updated_at)
                        ->first();
                    return $validasiTahapDua && $validasiTahapDua->user ? $validasiTahapDua->user->name : '-';
                })
                ->addColumn('status_selesai', function ($row) {
                    return $row->status_selesai === 'Submitted'
                        ? '<span class="status-valid">Submitted</span>'
                        : '<span class="status-onprogress">On Progress</span>';
                })
                ->rawColumns(['status_selesai', 'status_validasi'])
                ->toJson();
        } catch (\Exception $e) {
            Log::error('Error in FinalisasiController@list: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Terjadi kesalahan pada server'], 500);
        }
    }

    public function export(Request $request)
    {
        try {
            // Cek apakah sudah ada dokumen final
            if (FinalDocumentModel::exists()) {
                return response()->json([
                    'error' => 'Dokumen final hanya dapat diekspor satu kali.'
                ], 403);
            }

            // Periksa apakah semua kriteria (1-9) sudah divalidasi tahap dua dengan status "Valid"
            $kriteria = KriteriaModel::select('m_kriteria.*')
                ->with([
                    'validasi' => function ($query) {
                        $query->whereIn('id_user', [12, 13])
                            ->orderBy('updated_at', 'desc');
                    }
                ])
                ->whereIn('id_kriteria', range(1, 9))
                ->get();

            $allValidated = true;
            $invalidKriteria = [];

            foreach ($kriteria as $k) {
                $validasiTahapDua = $k->validasi->whereIn('id_user', [12, 13])
                    ->where('updated_at', '>=', $k->updated_at)
                    ->first();

                if (!$validasiTahapDua || $validasiTahapDua->status !== 'Valid') {
                    $allValidated = false;
                    $invalidKriteria[] = 'Kriteria ' . $k->id_kriteria;
                }
            }

            if (!$allValidated) {
                return response()->json([
                    'error' => 'Tidak dapat mengekspor dokumen. Kriteria berikut belum divalidasi akhir: ' . implode(', ', $invalidKriteria)
                ], 422);
            }

            // Ambil semua data pendukung untuk kriteria 1-9
            $kriteriaList = KriteriaModel::select('m_kriteria.*')
                ->with([
                    'detailKriteria' => function ($query) {
                        $query->with(['kategori', 'dataPendukung' => function ($q) {
                            $q->with('gambar');
                        }]);
                    }
                ])
                ->whereIn('id_kriteria', range(1, 9))
                ->orderBy('id_kriteria')
                ->get();

            // Generate PDF
            $html = view('finalisasi.pdf', compact('kriteriaList'))->render();
            $pdf = PDF::loadHTML($html);
            $timestamp = time();
            $fileName = "finalisasi_dokumen_{$timestamp}.pdf";
            $pdfPath = 'pdf/finalisasi/' . $fileName;

            // Simpan PDF
            $pdfContent = $pdf->output();
            if (!Storage::disk('public')->put($pdfPath, $pdfContent)) {
                Log::error('Gagal menyimpan PDF finalisasi', ['path' => $pdfPath]);
                return response()->json(['error' => 'Gagal menyimpan PDF'], 500);
            }

            // Simpan ke t_final_document
            $finalDocument = new FinalDocumentModel();
            $finalDocument->id_user = Auth::id();
            $finalDocument->final_document = $pdfPath;
            $finalDocument->save();

            Log::info('PDF finalisasi berhasil dibuat dan disimpan', ['path' => $pdfPath, 'user_id' => Auth::id()]);

            // Kembalikan URL untuk download dan ID dokumen
            $downloadUrl = asset('storage/' . $pdfPath);
            return response()->json([
                'success' => 'Dokumen berhasil diekspor dan disimpan.',
                'download_url' => $downloadUrl,
                'document_id' => $finalDocument->id_final_document
            ]);
        } catch (\Exception $e) {
            Log::error('Error in FinalisasiController@export: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Terjadi kesalahan saat mengekspor dokumen'], 500);
        }
    }

    public function showFinal($id)
    {
        $document = FinalDocumentModel::findOrFail($id);
        $pdfUrl = asset('storage/' . $document->final_document);
        $downloadUrl = asset('storage/' . $document->final_document);

        $activeMenu = 'finalisasi-dokumen';
        $breadcrumb = (object) [
            'title' => 'Dokumen Final',
            'list' => ['Home', 'Finalisasi Dokumen', 'Lihat Dokumen']
        ];

        return view('finalisasi.show', compact('pdfUrl', 'downloadUrl', 'activeMenu', 'breadcrumb'));
    }
}