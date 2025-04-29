<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SalesController;
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

    // artinya semua route di dalam group ini harus punya role ADM (Administrator) dan MNG (Manager)
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::group(['prefix' => 'kategori'], function () {
            Route::get('/', [KategoriController::class, 'index']); // menampilkan halaman awal kategori
            Route::post("/list", [KategoriController::class, 'list']); // menampilkan data kategori dalam bentuk json untuk datatables
            Route::get('/{id}', [KategoriController::class, 'show']); // menampilkan detail kategori
            // Create menggunakan AJAX
            Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); // menampilkan halaman form tambah kategori ajax
            Route::post('/ajax', [KategoriController::class, 'store_ajax']); // menyimpan data kategori baru ajax
            // Edit menggunakan AJAX
            Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); // menampilkan halaman form edit kategori ajax
            Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // menyimpan perubahan data kategori ajax
            // Delete menggunakan AJAX
            Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); //menampilkan form confirm delete kategori ajax
            Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // menghapus data kategori ajax
            //Import & Export
            Route::get('import', [KategoriController::class, 'import']); // ajax form upload excel
            Route::post('import_ajax', [KategoriController::class, 'import_ajax']); // ajax import excel
            Route::get('export_excel', [KategoriController::class, 'export_excel']); //export excel
            Route::get('export_pdf', [KategoriController::class, 'export_pdf']); //export pdf
        });
    });


    // Staff hanya bisa melihat data barang
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::group(['prefix' => 'barang'], function () {
            Route::get('/', [BarangController::class, 'index']); // Menampilkan daftar barang
            Route::post('/list', [BarangController::class, 'list']); // Menampilkan data barang dalam bentuk JSON untuk datatables
            Route::get('/{id}', [BarangController::class, 'show']); // Menampilkan detail barang
        });
    });

    // Route untuk Admin dan Manager saja (create, update, delete barang)
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        // Akses tambahan untuk barang (create, update, delete)
        Route::group(['prefix' => 'barang'], function () {
            // Create menggunakan AJAX
            Route::get('/create_ajax', [BarangController::class, 'create_ajax']); // Menampilkan halaman form tambah barang Ajax
            Route::post('/ajax', [BarangController::class, 'store_ajax']); // Menyimpan data barang baru Ajax
            // Edit menggunakan AJAX
            Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // Menampilkan halaman form edit barang Ajax
            Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); // Menyimpan perubahan data barang Ajax
            // Delete menggunakan AJAX
            Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete barang Ajax
            Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk hapus data barang Ajax
            //Import & Export
            Route::get('/import', [BarangController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [BarangController::class, 'import_ajax']); // AJAX import excel
            Route::get('export_excel', [BarangController::class, 'export_excel']); //export excel
            Route::get('export_pdf', [BarangController::class, 'export_pdf']); //export pdf
        });
    });

    // artinya semua route di dalam group ini harus punya role ADM (Administrator) dan MNG (Manager)
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::group(['prefix' => 'supplier'], function () {
            Route::get('/', [SupplierController::class, 'index']);
            Route::post('/list', [SupplierController::class, 'list']);
            Route::get('/{id}', [SupplierController::class, 'show']);
            // Create menggunakan AJAX
            Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); // menampilkan halaman form tambah Supplier ajax
            Route::post('/ajax', [SupplierController::class, 'store_ajax']); // menyimpan data Supplier baru ajax
            // Edit menggunakan AJAX
            Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // menampilkan halaman form edit Supplier ajax
            Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // menyimpan perubahan data Supplier ajax
            // Delete menggunakan AJAX
            Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); //menampilkan form confirm delete Supplier ajax
            Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // menghapus data Supplier ajax
            //Import & Export
            Route::get('import', [SupplierController::class, 'import']); // ajax form upload excel
            Route::post('import_ajax', [SupplierController::class, 'import_ajax']); // ajax import excel
            Route::get('export_excel', [SupplierController::class, 'export_excel']); //export excel
            Route::get('export_pdf', [SupplierController::class, 'export_pdf']); //export pdf
        });
    });

    // Route untuk semua role (ADM, MNG, STF) - Hanya View
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::group(['prefix' => 'stok'], function () {
            Route::get('/', [StokController::class, 'index']);
            Route::post('/list', [StokController::class, 'list']); // Gunakan POST untuk DataTables
            Route::get('/{id}', [StokController::class, 'show']); // Jika ada fitur detail
        });
    });

    // Route khusus Admin & Manager (ADM, MNG) - CRUD
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::group(['prefix' => 'stok'], function () {
            // Create
            Route::get('/create_ajax', [StokController::class, 'create_ajax']);
            Route::post('/ajax', [StokController::class, 'store_ajax']);

            // Update
            Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);

            // Delete
            Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']);

            // Import & Export 
            Route::get('/import', [StokController::class, 'import']);
            Route::post('/import_ajax', [StokController::class, 'import_ajax']);
            Route::get('/export_excel', [StokController::class, 'export_excel']);
            Route::get('/export_pdf', [StokController::class, 'export_pdf']);
        });
    });
    // Route untuk semua role (ADM, MNG, STF) - Hanya View
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::group(['prefix' => 'penjualan'], function () {
            Route::get('/', [SalesController::class, 'index'])->name('penjualan.index'); 
            Route::post('/list', [SalesController::class, 'list'])->name('penjualan.list'); 
            Route::get('/{id}', [SalesController::class, 'show'])->name('penjualan.show');
        });
    });

    // Route khusus Admin & Staff/Kasir (ADM, STF) - CRUD
    Route::middleware(['authorize:ADM,STF'])->group(function () {
        Route::group(['prefix' => 'penjualan'], function () {
            // Create
            Route::get('/create_ajax', [SalesController::class, 'create_ajax'])->name('penjualan.create_ajax');
            Route::post('/ajax', [SalesController::class, 'store_ajax'])->name('penjualan.store_ajax');

            // Update
            Route::get('/{id}/edit_ajax', [SalesController::class, 'edit_ajax'])->name('penjualan.edit_ajax');
            Route::put('/{id}/update_ajax', [SalesController::class, 'update_ajax'])->name('penjualan.update_ajax');

            // Delete
            Route::get('/penjualan/{id}/delete_ajax', [SalesController::class, 'confirm_ajax'])
                ->name('penjualan.confirm_ajax');
            Route::delete('/penjualan/{id}/delete_ajax', [SalesController::class, 'delete_ajax'])
                ->name('penjualan.delete_ajax');
        });
    });
});
