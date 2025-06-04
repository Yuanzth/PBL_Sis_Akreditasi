<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\DetailKriteriaModel;
use App\Models\KriteriaModel;

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

        // Tentukan view berdasarkan level_kode
        $view = match ($level_kode) {
            'SuperAdmin' => 'dashboard.superadmin',
            'Admin1', 'Admin2', 'Admin3', 'Admin4', 'Admin5', 'Admin6', 'Admin7', 'Admin8', 'Admin9' => 'dashboard.admin',
            'KPS_Kajur' => 'dashboard.kps_kajur',
            'KJM' => 'dashboard.kjm',
            'Direktur' => 'dashboard.direktur',
            default => 'dashboard.default'
        };

        // Filter kriteria berdasarkan id_level untuk Admin Kriteria atau SuperAdmin
        $id_level = $user->id_level;
        $kriteria = null;
        if (in_array($level_kode, ['Admin1', 'Admin2', 'Admin3', 'Admin4', 'Admin5', 'Admin6', 'Admin7', 'Admin8', 'Admin9'])) {
            // Untuk Admin Kriteria, filter kriteria berdasarkan id_level
            $kriteria = KriteriaModel::where('id_level', $id_level)->first();
        } elseif ($level_kode === 'SuperAdmin') {
            // Untuk SuperAdmin, ambil semua kriteria (atau bisa disesuaikan logikanya)
            $kriteria = KriteriaModel::all();
        }

        // Ambil data jumlah data pendukung per kategori
        $categoryCounts = collect();
        if ($kriteria) {
            if ($kriteria instanceof \Illuminate\Database\Eloquent\Collection) {
                // Jika SuperAdmin, ambil semua detail kriteria dari semua kriteria
                $categoryCounts = DetailKriteriaModel::with(['kategori', 'dataPendukung'])
                    ->whereIn('id_kriteria', $kriteria->pluck('id_kriteria'))
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
            } else {
                // Untuk Admin Kriteria, ambil detail kriteria berdasarkan id_kriteria
                $categoryCounts = DetailKriteriaModel::with(['kategori', 'dataPendukung'])
                    ->where('id_kriteria', $kriteria->id_kriteria)
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
            }
        }

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
            'user' => $user, // Tambahkan user untuk akses di view
        ]);
    }
}