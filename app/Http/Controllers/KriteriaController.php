<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use App\Models\DetailKriteriaModel;
use App\Models\DataPendukungModel;
use App\Models\GambarModel;
use App\Models\KomentarModel;
use App\Models\GeneratedDocumentModel;
use App\Models\ValidasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\PDF;

class KriteriaController extends Controller
{
    /**
     * Menampilkan halaman pengerjaan kriteria.
     */
    public function edit($id)
    {
        // Cek apakah Admin memiliki akses ke id_kriteria berdasarkan id_level
        $user = Auth::user();
        $kriteria = KriteriaModel::where('id_kriteria', $id)->first();

        if (!$kriteria || $kriteria->id_level !== $user->id_level) {
            Log::error('Akses ditolak untuk id_kriteria: ' . $id, ['user_id' => $user->id_user, 'id_level' => $user->id_level]);
            abort(403, 'Akses ditolak');
        }

        // Ambil detail kriteria (5 kategori)
        $detailKriteria = DetailKriteriaModel::with(['kategori', 'dataPendukung.gambar'])
            ->where('id_kriteria', $id)
            ->get();

        // Ambil komentar revisi
        $komentar = KomentarModel::with('user')
            ->where('id_kriteria', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kriteria.edit', [
            'kriteria' => $kriteria,
            'detailKriteria' => $detailKriteria,
            'komentar' => $komentar,
            'breadcrumb' => (object) [
                'title' => 'Kriteria ' . $id,
                'list' => ['Home', 'Dashboard', 'Kriteria ' . $id]
            ],
            'activeMenu' => 'kriteria' . $id
        ]);
    }

    /**
     * Menyimpan perubahan data pendukung dan gambar.
     */
    public function save(Request $request, $id)
    {
        $user = Auth::user();
        $kriteria = KriteriaModel::where('id_kriteria', $id)
            ->where('id_level', $user->id_level)
            ->firstOrFail();

        $request->validate([
            'data_pendukung.*.*.id_detail_kriteria' => 'required|exists:m_detail_kriteria,id_detail_kriteria',
            'data_pendukung.*.*.nama_data' => 'required|string|max:255',
            'data_pendukung.*.*.deskripsi_data' => 'nullable|string',
            'data_pendukung.*.*.hyperlink_data' => 'nullable|string|max:1000',
            'data_pendukung.*.*.gambar.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $draftData = $request->input('data_pendukung', []);

        // Simpan sebagai draft atau final tergantung status
        foreach ($draftData as $categoryIndex => $dataList) {
            foreach ($dataList as $dataIndex => $data) {
                $isNew = $dataIndex === 'new';
                $dataPendukung = DataPendukungModel::updateOrCreate(
                    [
                        'id_detail_kriteria' => $data['id_detail_kriteria'],
                        'nama_data' => $data['nama_data']
                    ] + ($isNew ? [] : ['id_data_pendukung' => $data['id_data_pendukung'] ?? null]),
                    [
                        'deskripsi_data' => $data['deskripsi_data'] ?? '',
                        'hyperlink_data' => $data['hyperlink_data'] ?? '',
                        'draft' => true
                    ]
                );

                // Proses upload gambar
                if ($request->hasFile("data_pendukung.{$categoryIndex}.{$dataIndex}.gambar")) {
                    foreach ($request->file("data_pendukung.{$categoryIndex}.{$dataIndex}.gambar") as $file) {
                        $path = $file->store('gambar/draft', 'public');
                        GambarModel::create([
                            'id_data_pendukung' => $dataPendukung->id_data_pendukung,
                            'gambar' => $path,
                            'draft' => true
                        ]);
                    }
                }
            }
        }

        // Jika tombol Save utama ditekan, tandai sebagai final
        if ($request->has('final_save')) {
            $detailKriteriaIds = DetailKriteriaModel::where('id_kriteria', $id)->pluck('id_detail_kriteria');
            DataPendukungModel::whereIn('id_detail_kriteria', $detailKriteriaIds)->where('draft', true)->update(['draft' => false]);
            GambarModel::whereIn('id_data_pendukung', function ($query) use ($detailKriteriaIds) {
                $query->select('id_data_pendukung')
                    ->from('t_data_pendukung')
                    ->whereIn('id_detail_kriteria', $detailKriteriaIds)
                    ->where('draft', true);
            })->update(['draft' => false]);
            Log::info('Data pendukung disimpan final untuk id_kriteria: ' . $id, ['user_id' => $user->id_user]);
        } else {
            Log::info('Data pendukung disimpan sebagai draft untuk id_kriteria: ' . $id, ['user_id' => $user->id_user]);
        }

        // Jika request adalah AJAX, kembalikan response JSON
        if ($request->ajax()) {
            return response()->json(['message' => 'Data berhasil disimpan sebagai draft']);
        }

        return redirect()->route('kriteria.edit', $id)->with('success', 'Data berhasil disimpan ' . ($request->has('final_save') ? 'secara final' : 'sebagai draft'));
    }

    /**
     * Submit kriteria (ubah status ke Submitted).
     */
    public function submit(Request $request, $id)
    {
        $user = Auth::user();
        $kriteria = KriteriaModel::where('id_kriteria', $id)
            ->where('id_level', $user->id_level)
            ->first();

        if (!$kriteria) {
            Log::error('Akses ditolak untuk id_kriteria: ' . $id, ['user_id' => $user->id_user, 'id_level' => $user->id_level]);
            abort(403, 'Akses ditolak');
        }

        // Validasi input
        $request->validate([
            'data_pendukung' => 'nullable|array',
            'data_pendukung.*.*.id_detail_kriteria' => 'required|exists:m_detail_kriteria,id_detail_kriteria',
            'data_pendukung.*.*.nama_data' => 'required|string|max:255',
            'data_pendukung.*.*.deskripsi_data' => 'nullable|string',
            'data_pendukung.*.*.hyperlink_data' => 'nullable|string|max:1000',
            'data_pendukung.*.*.gambar.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Proses data pendukung hanya jika ada
        if ($request->has('data_pendukung')) {
            foreach ($request->data_pendukung as $categoryIndex => $dataList) {
                foreach ($dataList as $dataIndex => $data) {
                    $dataPendukung = DataPendukungModel::updateOrCreate(
                        [
                            'id_detail_kriteria' => $data['id_detail_kriteria'],
                            'nama_data' => $data['nama_data']
                        ],
                        [
                            'deskripsi_data' => $data['deskripsi_data'] ?? '',
                            'hyperlink_data' => $data['hyperlink_data'] ?? ''
                        ]
                    );

                    // Proses upload gambar
                    if ($request->hasFile("data_pendukung.{$categoryIndex}.{$dataIndex}.gambar")) {
                        Log::info('Files received for processing', ['files' => $request->file("data_pendukung.{$categoryIndex}.{$dataIndex}.gambar")]);
                        foreach ($request->file("data_pendukung.{$categoryIndex}.{$dataIndex}.gambar") as $file) {
                            $path = $file->store('gambar/draft', 'public');
                            GambarModel::create([
                                'id_data_pendukung' => $dataPendukung->id_data_pendukung,
                                'gambar' => $path,
                                'draft' => true
                            ]);
                            Log::info('Gambar disimpan', ['path' => $path, 'id_data_pendukung' => $dataPendukung->id_data_pendukung]);
                        }
                    } else {
                        Log::warning('No files received for processing', ['categoryIndex' => $categoryIndex, 'dataIndex' => $dataIndex]);
                    }
                }
            }
        }

        // Hapus semua entri validasi terkait di t_validasi sebelum submit
        try {
            ValidasiModel::where('id_kriteria', $id)->delete();
            Log::info('Entri validasi dihapus untuk id_kriteria: ' . $id, ['user_id' => $user->id_user]);
        } catch (\Exception $e) {
            Log::error('Gagal menghapus entri validasi untuk id_kriteria: ' . $id, [
                'error' => $e->getMessage(),
                'user_id' => $user->id_user
            ]);
            return redirect()->route('dashboard')->with('error', 'Gagal menghapus entri validasi lama: ' . $e->getMessage());
        }

        // Update status kriteria
        $kriteria->update([
            'status_selesai' => 'Submitted',
            'tanggal_submit' => now()->setTimezone('Asia/Jakarta')
        ]);

        // Ambil data dari database untuk generate PDF
        $detailKriteria = DetailKriteriaModel::with(['kategori', 'dataPendukung.gambar'])
            ->where('id_kriteria', $id)
            ->get();

        // Generate PDF
        $html = view('pdf.kriteria', compact('kriteria', 'detailKriteria'))->render();
        $pdf = PDF::loadHTML($html);
        $timestamp = time();
        $fileName = "kriteria_{$id}_{$timestamp}.pdf";
        $pdfPath = 'pdf/' . $fileName;

        // Cek dan hapus semua dokumen lama untuk id_kriteria ini
        $existingDocuments = GeneratedDocumentModel::where('id_kriteria', $id)->get();
        foreach ($existingDocuments as $existingDocument) {
            $oldFilePath = $existingDocument->generated_document;
            if (Storage::disk('public')->exists($oldFilePath)) {
                if (!Storage::disk('public')->delete($oldFilePath)) {
                    Log::error('Gagal menghapus file lama untuk id_kriteria: ' . $id, ['path' => $oldFilePath]);
                } else {
                    Log::info('File lama berhasil dihapus untuk id_kriteria: ' . $id, ['path' => $oldFilePath]);
                }
            }
            $existingDocument->delete();
        }

        // Simpan file PDF baru ke penyimpanan
        $pdfContent = $pdf->output();
        if (!Storage::disk('public')->put($pdfPath, $pdfContent)) {
            Log::error('Gagal menyimpan PDF untuk id_kriteria: ' . $id, ['path' => $pdfPath]);
            return redirect()->route('dashboard')->with('error', 'Gagal menghasilkan PDF');
        }

        // Simpan path ke t_generated_document
        GeneratedDocumentModel::create([
            'id_kriteria' => $id,
            'generated_document' => $pdfPath,
        ]);

        Log::info('PDF generated and saved for id_kriteria: ' . $id, ['user_id' => $user->id_user, 'path' => $pdfPath]);

        Log::info('Kriteria disubmit untuk id_kriteria: ' . $id, ['user_id' => $user->id_user]);

        return redirect()->route('dashboard')->with('success', 'Kriteria berhasil disubmit dan PDF telah dihasilkan');
    }

    /**
     * Menghapus data pendukung.
     */
    public function deleteData(Request $request, $id, $dataId)
    {
        $request->validate([
            'id_data_pendukung' => 'required|exists:t_data_pendukung,id_data_pendukung'
        ]);

        $dataPendukung = DataPendukungModel::findOrFail($request->id_data_pendukung);
        $kriteria = KriteriaModel::where('id_kriteria', $id)
            ->where('id_level', Auth::user()->id_level)
            ->firstOrFail();

        // Hapus gambar terkait
        $gambar = GambarModel::where('id_data_pendukung', $dataPendukung->id_data_pendukung)->get();
        foreach ($gambar as $img) {
            Storage::disk('public')->delete($img->gambar);
            $img->delete();
        }

        // Hapus data pendukung
        $dataPendukung->delete();

        Log::info('Data pendukung dihapus untuk id_kriteria: ' . $id, ['user_id' => Auth::user()->id_user, 'id_data_pendukung' => $request->id_data_pendukung]);

        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    /**
     * Menghapus draft gambar yang diupload 
     */
    public function deleteGambar(Request $request, $id, $gambarId)
    {
        $kriteria = KriteriaModel::where('id_kriteria', $id)
            ->where('id_level', Auth::user()->id_level)
            ->firstOrFail();

        $gambar = GambarModel::findOrFail($gambarId);
        Storage::disk('public')->delete($gambar->gambar);
        $gambar->delete();

        Log::info('Gambar dihapus untuk id_kriteria: ' . $id, ['user_id' => Auth::user()->id_user, 'id_gambar' => $gambarId]);

        return response()->json(['message' => 'Gambar berhasil dihapus']);
    }
}