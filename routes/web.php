<?php

use App\Http\Controllers\LandingPageConntroller;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// 1. get = mengambil data/menampilkan hasil
// 2. post = menambahkan data ke db
// 3. put/patch = mengupdate data ke db
// 4. delete = menghapus data dari db   

Route::middleware(['isGuest'])->group(function () {
    Route::get('/', [UserController::class, 'ShowLogin'])->name('login.auth');
    Route::post('/login_proses', action: [UserController::class, 'loginAuth'])->name('login.proses');

});

//memberikan hak akses 
Route::middleware(['isLogin'])->group(function () {

    Route::get('/logout', [UserController::class, 'logout'])->name('logout.auth');
    Route::get('/landing', [LandingPageConntroller::class, 'index'])->name('landing_page');


    Route::middleware(['isAdmin'])->group(function () {
        Route::get('/order', [OrderController::class,'indexAdmin'])->name('pembelian.admin');
        Route::get('/order/export/excel', [OrderController::class,'exportExcel'])->name('pembelian.admin.export');
        Route::get('/user/export/excel', [UserController::class,'exportExcel'])->name('user.admin.export');
        Route::get('/obat/export/excel', [MedicineController::class,'exportExcel'])->name('obat.admin.export');

        //fitur/bagian/fitur mengelola obat / data obat
        Route::prefix('/obat')->name('obat.')->group(function () {
            Route::get('/data', [MedicineController::class, 'index'])->name('data');
            Route::get('/tambah-obat', [MedicineController::class, 'create'])->name('tambah_obat');
            Route::post('/tambah-obat', [MedicineController::class, 'store'])->name('tambah_obat.formulir');
            Route::delete('/medicines/delete/{id}', [MedicineController::class, 'destroy'])->name('delete');
            Route::get('/edit/{id}', [MedicineController::class, 'edit'])->name('edit');
            Route::patch('/edit/{id}', [MedicineController::class, 'update'])->name('edit_formulir');
            Route::patch('/edit/stock/{id}', [MedicineController::class, 'updateStock'])->name('edit_stock');
        });

        //fitur untuk mengelola user / data akun
        Route::prefix('/user')->name('user.')->group(function () {
            Route::get('/data_user', [UserController::class, 'index'])->name('login');  // Untuk login
            Route::get('/tambah', [UserController::class, 'create'])->name('tambah_pengguna');  // Formulir pembuatan user
            Route::post('/tambah', [UserController::class, 'store'])->name('tambah_pengguna.formulir');   // Menyimpan user ke database
            Route::get('/edit/0{id}', [UserController::class, 'edit'])->name('edit');
            Route::patch('/edit/update/{id}', [UserController::class, 'update'])->name('edit_formulir');
            Route::delete('/data_user/delete/{id}', [UserController::class, 'destroy'])->name('hapus');
        });
    });
    
    Route::middleware(['isCashier'])->prefix('')->group(function () {
        Route::prefix('/pembelian')->name('pembelian.')->group(function () {
            Route::get('/order', [OrderController::class,'index'])->name('order');
            Route::get('/formulir', [OrderController::class, 'create'])->name('formulir');
            Route::post('/store-order', [OrderController::class, 'store'])->name('store_order');
            Route::get('/print/{id}', [OrderController::class, 'show'])->name('print');
            Route::get('/export.pdf/{id}', [OrderController::class, 'downloadPDF'])->name('export.pdf');
        });
    });
});

