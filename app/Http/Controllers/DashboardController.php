<?php

namespace App\Http\Controllers;

use App\Models\DetailKriteriaModel;
use App\Models\KriteriaModel;
use App\Models\ValidasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller {
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

        // Filter kriteria berdasarkan id_level untuk Admin Kriteria, KPS/Kajur, KJM, atau Direktur
        $id_level = $user->id_level;
        $kriteria = [];
        if (in_array($level_kode, ['Admin1', 'Admin2', 'Admin3', 'Admin4', 'Admin5', 'Admin6', 'Admin7', 'Admin8', 'Admin9'])) {
            $kriteria = KriteriaModel::where('id_level', $id_level)->first();
        } elseif ($level_kode === 'SuperAdmin') {
            $kriteria = KriteriaModel::all();
        } elseif ($level_kode === 'KPS_Kajur') {
            $kriteria = KriteriaModel::where('status_selesai', 'Submitted')->get();
        } elseif (in_array($level_kode, ['KJM', 'Direktur'])) {
            // Untuk KJM dan Direktur, ambil semua kriteria yang sudah divalidasi tahap satu oleh KPS/Kajur
            $kriteria = KriteriaModel::whereHas('validasi', function ($query) {
                $query->whereIn('id_user', [10, 11]) // Validasi tahap satu oleh KPS/Kajur
                      ->where('status', 'Valid');
            })->get();
        }

        // Ambil data jumlah data pendukung per kategori
        $categoryCounts = collect();
        if ($kriteria) {
            if ($kriteria instanceof \Illuminate\Database\Eloquent\Collection) {
                $categoryCounts = DetailKriteriaModel::with(['kategori', 'dataPendukung'])
                    ->whereIn('id_kriteria', $kriteria->pluck('id_kriteria'))
                    ->get()
                    ->groupBy('id_kategori_kriteria')
                    ->mapWithKeys(function ($group, $id) {
                        $categoryName = $group->first()->kategori->nama_kategori ?? 'Unknown';
                        return [$categoryName => [
                            'count' => $group->sum(function ($item) {
                                return $item->dataPendukung()->count();
                            }),
                            'name' => $categoryName,
                            'class' => strtolower(str_replace(' ', '', $categoryName)),
                        ]];
                    });
            } else {
                $categoryCounts = DetailKriteriaModel::with(['kategori', 'dataPendukung'])
                    ->where('id_kriteria', $kriteria->id_kriteria)
                    ->get()
                    ->groupBy('id_kategori_kriteria')
                    ->mapWithKeys(function ($group, $id) {
                        $categoryName = $group->first()->kategori->nama_kategori ?? 'Unknown';
                        return [$categoryName => [
                            'count' => $group->sum(function ($item) {
                                return $item->dataPendukung()->count();
                            }),
                            'name' => $categoryName,
                            'class' => strtolower(str_replace(' ', '', $categoryName)),
                        ]];
                    });
            }
        }

        $categories = $categoryCounts->pluck('name')->values()->toArray();
        $counts = $categoryCounts->pluck('count')->values()->toArray();

        // Hitung status kriteria untuk SuperAdmin
        $statusCounts = [
            'submitted' => 0,
            'on_progress' => 0,
            'tahap_satu' => 0,
            'tahap_dua' => 0,
        ];

        if ($level_kode === 'SuperAdmin' && $kriteria) {
            foreach ($kriteria as $k) {
                $validasiTahapSatu = ValidasiModel::where('id_kriteria', $k->id_kriteria)
                    ->whereIn('id_user', [10, 11])
                    ->where('updated_at', '>=', $k->updated_at)
                    ->first();
                $validasiTahapDua = ValidasiModel::where('id_kriteria', $k->id_kriteria)
                    ->whereIn('id_user', [12, 13])
                    ->where('updated_at', '>=', $k->updated_at)
                    ->first();

                if ($validasiTahapDua && $validasiTahapDua->status === 'Valid') {
                    $statusCounts['tahap_dua']++;
                } elseif ($validasiTahapSatu && $validasiTahapSatu->status === 'Valid') {
                    $statusCounts['tahap_satu']++;
                } elseif ($k->status_selesai === 'Submitted') {
                    $statusCounts['submitted']++;
                } else {
                    $statusCounts['on_progress']++;
                }
            }
        }

        // Hitung status kriteria untuk KPS/Kajur, KJM, dan Direktur
        $stats = ['submitted' => 0, 'valid' => 0, 'rejected' => 0, 'on_progress' => 0];
        if ($level_kode === 'KPS_Kajur' && $kriteria) {
            foreach ($kriteria as $k) {
                $validasiTahapSatu = ValidasiModel::where('id_kriteria', $k->id_kriteria)
                    ->whereIn('id_user', [10, 11])
                    ->where('updated_at', '>=', $k->updated_at)
                    ->first();
                $validasiTahapDua = ValidasiModel::where('id_kriteria', $k->id_kriteria)
                    ->whereIn('id_user', [12, 13])
                    ->where('updated_at', '>=', $k->updated_at)
                    ->first();

                if ($validasiTahapDua && $validasiTahapDua->status === 'Valid') {
                    $stats['valid']++;
                    $statusCounts['tahap_dua']++;
                } elseif ($validasiTahapSatu && $validasiTahapSatu->status === 'Valid') {
                    $stats['valid']++;
                    $statusCounts['tahap_satu']++;
                } elseif ($validasiTahapSatu && $validasiTahapSatu->status === 'Belum Validasi') {
                    $stats['rejected']++;
                    $statusCounts['on_progress']++;
                } elseif ($k->status_selesai === 'Submitted') {
                    $stats['submitted']++;
                    $statusCounts['submitted']++;
                } else {
                    $stats['on_progress']++;
                    $statusCounts['on_progress']++;
                }
            }
        } elseif (in_array($level_kode, ['KJM', 'Direktur']) && $kriteria) {
            foreach ($kriteria as $k) {
                // Ambil validasi tahap satu
                $validasiTahapSatu = ValidasiModel::where('id_kriteria', $k->id_kriteria)
                    ->whereIn('id_user', [10, 11])
                    ->where('updated_at', '>=', $k->updated_at)
                    ->first();

                // Ambil validasi tahap dua (KJM atau Direktur)
                $validasiTahapDua = ValidasiModel::where('id_kriteria', $k->id_kriteria)
                    ->whereIn('id_user', [12, 13])
                    ->where('updated_at', '>=', $k->updated_at)
                    ->orderBy('updated_at', 'desc')
                    ->first();

                // Logika penghitungan status
                if ($validasiTahapDua && $validasiTahapDua->status === 'Valid') {
                    $stats['valid']++;
                    $statusCounts['tahap_dua']++;
                } elseif ($validasiTahapDua && $validasiTahapDua->status === 'Belum Validasi') {
                    $stats['rejected']++;
                    $statusCounts['on_progress']++;
                } elseif ($validasiTahapSatu && $validasiTahapSatu->status === 'Valid') {
                    $stats['submitted']++;
                    $statusCounts['tahap_satu']++;
                } else {
                    $stats['on_progress']++;
                    $statusCounts['on_progress']++;
                }
            }
        }

        return view($view, [
            'breadcrumb' => (object) [
                'title' => 'Dashboard ' . $level_kode,
                'list' => ['Home', 'Dashboard']
            ],
            'activeMenu' => 'dashboard',
            'categoryCounts' => $categoryCounts,
            'categories' => $categories,
            'counts' => $counts,
            'stats' => $stats,
            'statusCounts' => $statusCounts,
            'user' => $user,
        ]);
    }
}