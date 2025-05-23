<?php

namespace App\Http\Controllers;

use App\Models\FinalDocumentModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class FinalDocumentController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('kategori');
        $search = $request->input('search');

        $query = FinalDocumentModel::with('user');

        if ($filter) {
            $query->where('final_document', 'like', "%$filter%");
        }

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        $documents = $query->get();

        $activeMenu = 'finalisasi-dokumen';

        $breadcrumb = (object)[
            'title' => 'Finalisasi Dokumen',
            'list' => ['Home', 'Finalisasi'],
        ];

        return view('finalisasi.index', compact('documents', 'activeMenu', 'breadcrumb', 'filter', 'search'));
    }

    public function exportPdf(Request $request)
    {
        $filter = $request->input('kategori');

        // Bangun query dengan eager loading validasi dan kriteria
        $query = FinalDocumentModel::with(['validasi.kriteria', 'validasi.user']);

        if ($filter) {
            $query->where('final_document', 'like', "%$filter%");
        }

        // Filter hanya dokumen yang punya validasi dengan id_kriteria antara 1-9
        $query->whereHas('validasi.kriteria', function ($q) {
            $q->whereBetween('id_kriteria', [1, 9]); // kolom sebenarnya di tabel kriteria
        });

        $documents = $query->get();

        $pdf = Pdf::loadView('finalisasi.pdf', compact('documents'))
                ->setPaper('A4', 'portrait');

        return $pdf->download('laporan-kriteria-1-9.pdf');
    }
}
