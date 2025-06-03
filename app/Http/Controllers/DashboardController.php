<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\DetailKriteriaModel;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            Log::error('No authenticated user found in DashboardController');
            return redirect('/login');
        }

        $level_kode = $user->level->level_kode;
        Log::info('Accessing dashboard', ['user_id' => $user->id_user, 'level_kode' => $level_kode]);

        $view = match ($level_kode) {
            'Admin' => 'dashboard.admin',
            'KPS_Kajur' => 'dashboard.kps_kajur',
            'KJM' => 'dashboard.kjm',
            'Direktur' => 'dashboard.direktur',
            default => 'dashboard.default'
        };

        // Filter hanya kriteria yang sesuai dengan id_user admin
        $id_kriteria = $user->id_user; // Admin1 -> Kriteria 1, Admin2 -> Kriteria 2, dst.

        // Ambil data jumlah data pendukung per kategori
        $categoryCounts = DetailKriteriaModel::with(['kategori', 'dataPendukung'])
            ->where('id_kriteria', $id_kriteria)
            ->get()
            ->groupBy('id_kategori_kriteria')
            ->mapWithKeys(function ($group, $id) {
                $categoryName = $group->first()->kategori->nama_kategori ?? 'Unknown';
                return [$id => [
                    'count' => $group->sum(function ($item) {
                        return $item->dataPendukung->count();
                    }),
                    'name' => $categoryName,
                    'class' => strtolower(str_replace(' ', '', $categoryName))
                ]];
            });

        $categories = $categoryCounts->pluck('name')->values()->toArray();
        $counts = $categoryCounts->pluck('count')->values()->toArray();

        return view($view, [
            'breadcrumb' => (object) [
                'title' => 'Dashboard ' . $level_kode,
                'list' => ['Home', 'Dashboard']
            ],
            'activeMenu' => 'dashboard',
            'categoryCounts' => $categoryCounts,
            'categories' => $categories,
            'counts' => $counts,
        ]);
    }
}