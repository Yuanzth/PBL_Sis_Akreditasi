<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
        // Profil user
    public function profile() 
    {
        $user = auth()->user();
    
        if (!$user) {
            return redirect('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $breadcrumb = (object) [
            'title' => 'Profile User',
            'list' => ['Home', 'Profile']
        ];
    
        $page = (object) [
            'title' => 'Profil Pengguna'
        ];
    
        
        $activeMenu = 'profile'; // Set menu aktif
    
        return view('profile.profile', compact('user', 'breadcrumb', 'page', 'activeMenu'));
    }
    
    //Update foto profile user 
    public function updatePhoto(Request $request)
    {
        // Validasi file
        $request->validate([
            'photo_profile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        try {
            // auth user yang login
            $user = auth()->user();
    
            if (!$user) {
                return redirect('/login')->with('error', 'Silahkan login terlebih dahulu');
            }
    
            // user id
                $userId = $user->id_user;
    
            // $user = UserModel::find($userId);
    
            if (!$user) {
                return redirect('/login')->with('error', 'User tidak ditemukan');
            }
    
            // hapus jika sudah ada foto profile
            if ($user->photo_profile && file_exists(storage_path('app/public/' . $user->photo_profile))) {
                Storage::disk('public')->delete($user->photo_profile);
            }
    
            // update foto profile baru 
            $fileName = 'profile_' . $userId . '_' . time() . '.' . $request->photo_profile->extension();
            $path = $request->photo_profile->storeAs('profiles', $fileName, 'public');
    
            // Update
            UserModel::where('id_user', $userId)->update([
                'photo_profile' => $path
            ]);
    
            return redirect()->back()->with('success', 'Foto profile berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
        }
    }
}
