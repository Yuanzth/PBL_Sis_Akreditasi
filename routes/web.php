<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;

Route::pattern('id', '[0-9]+'); // Pastikan parameter {id} hanya berupa angka

// Rute otentikasi

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'postRegister']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


// Semua rute di bawah ini hanya bisa diakses jika sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/', [WelcomeController::class, 'index']);
    Route::get('/profile', [UserController::class, 'profilePage']);
    Route::post('/user/editPhoto', [UserController::class, 'editPhoto']);

    Route::middleware(['authorize:ADM'])->group(function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index']); // menampilkan halaman awal user
            Route::post('/list', [UserController::class, 'list']); // menampilkan data user dalam bentuk json untuk datatables
            Route::get('/{id}', [UserController::class, 'show']); // menampilkan detail user
            //Create Menggunakan AJAX
            Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
            Route::post('/store_ajax', [UserController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            //Edit Menggunakan AJAX
            Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // Menampilkan halaman form edit user Ajax
            Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // Menyimpan perubahan data user Ajax
            //Delete Menggunakan AJAX
            Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
            Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax
            //Import & Export
            Route::get('import', [UserController::class, 'import']); // ajax form upload excel
            Route::post('import_ajax', [UserController::class, 'import_ajax']); // ajax import excel
            Route::get('export_excel', [UserController::class, 'export_excel']); //export excel
            Route::get('export_pdf', [UserController::class, 'export_pdf']); //export pdf

        });
    });

    // artinya semua route di dalam group ini harus punya role ADM (Administrator)
    Route::middleware(['authorize:ADM'])->group(function () {
        Route::group(['prefix' => 'level'], function () {
            Route::get('/', [LevelController::class, 'index']); // menampilkan halaman awal level
            Route::post("/list", [LevelController::class, 'list']); // menampilkan data level dalam bentuk json untuk datatables
            Route::get('/{id}', [LevelController::class, 'show']); // menampilkan detail level
            //Create Menggunakan AJAX
            Route::get('/create_ajax', [LevelController::class, 'create_ajax']); // Menampilkan halaman form tambah level Ajax
            Route::post('/ajax', [LevelController::class, 'store_ajax']); // Menyimpan data level baru Ajax
            //Edit Menggunakan AJAX
            Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); // Menampilkan halaman form edit level Ajax
            Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); // Menyimpan perubahan data level Ajax
            //Delete Menggunakan AJAX
            Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete level Ajax
            Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // Untuk hapus data level Ajax
            //Import & Export
            Route::get('import', [LevelController::class, 'import']); // ajax form upload excel
            Route::post('import_ajax', [LevelController::class, 'import_ajax']); // ajax import excel
            Route::get('export_excel', [LevelController::class, 'export_excel']); //export excel
            Route::get('export_pdf', [LevelController::class, 'export_pdf']); //export pdf
        });
    });
});
