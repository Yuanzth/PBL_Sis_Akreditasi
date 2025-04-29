<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list'  => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';
        $user = Auth::user();
        
        // Handle jika user tidak memiliki level
        $role = optional($user->level)->level_kode ?? 'STF';

        return view('welcome', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'userRole' => $role
        ]);
    }
}