<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            'Admin' => 'dashboard.admin',
            'KPS_Kajur' => 'dashboard.kps_kajur',
            'KJM' => 'dashboard.kjm',
            'Direktur' => 'dashboard.direktur',
            default => 'dashboard.default'
        };

        return view($view);
    }
}