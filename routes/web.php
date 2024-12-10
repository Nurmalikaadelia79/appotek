<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

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
Route::middleware(['IsLogout'])->group(function() {
Route::get('/', function () {
    return view('login');
})->name('login');
Route::post('/login', [UserController::class, 'loginProses'])->name('login.proses');
});
Route::middleware(['IsLogin'])->group(function() {
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Route::httpMethod('/path', [NamaController::class, 'namaFunc'])->name('identitas_route');
// httpMethod   
// get -> mengambil data/menampilkan halaman
// post -> mengirim data ke database (tambah data)
// patch/put -> mengubah data di database
// delete -> menghapus data
Route::get('/landing-page', [LandingPageController::class, 'index'])->name('landing_page');

Route::middleware(['IsAdmin'])->group(function(){
// mengelola data obat
Route::prefix('/data-obat')->name('data_obat.')->group(function() {
    Route::get('/data', [MedicineController::class, 'index'])->name('data');
    Route::get('/tambah', [MedicineController::class, 'create'])->name('tambah');
    Route::post('/tambah/proses', [MedicineController::class, 'store'])->name('tambah.proses');
    Route::get('/ubah/{id}', [MedicineController::class, 'edit'])->name('ubah');
    Route::patch('/ubah/{id}/proses', [MedicineController::class, 'update'])->name('ubah.proses');
    Route::delete('/hapus/{id}', [MedicineController::class, 'destroy'])->name('hapus');
    Route::patch('/ubah/stok/{id}', [MedicineController::class, 'updateStock'])->name('ubah.stok');
    //Route::get('/kelola-akun', function () {})->name('kelola-akun');
});
//kelola akun
Route::prefix('/kelola-akun')->name('kelola_akun.')->group(function() {
    Route::get('/user', [UserController::class, 'kelolaAkun'])->name('user');//karna untuk menambahkan datanya saja 
    Route::get('/tambah', [UserController::class, 'create'])->name('tambah');//tidak diperlukan karna tidak mengambil ID nya 
    Route::post('/tambah/proses', [UserController::class, 'store'])->name('tambah.proses');
    Route::get('/ubah/{id}', [UserController::class, 'edit'])->name('ubah');//untuk mengambil primary key table user //get untuk mengambild ata yang sudah di input
    Route::delete('/hapus/{id}', [UserController::class, 'destroy'])->name('hapus');
    Route::patch('/ubah/{id}/proses', [UserController::class, 'update'])->name('ubah.proses');//id di dapatkan dari primary key //untuk mengubah data yang baru
    //untuk mengambil nama gmail role dan password ,karna banyak jadi di wakilkan oleh primary key
});
});

Route::middleware(['isKasir'])->group( function() {
    Route::prefix('/kasir.')->name('kasir.')->group(function() {
        Route::get('/order', [OrderController::class, 'index'])->name('order');
        Route::get('/tambah', [OrderController::class, 'create'])->name('tambah');
        Route::post('/store', [OrderController::class, 'store'])->name('store');
        Route::get('/print/{id}', [OrderController::class, 'show'])->name('print');
        Route::get('/download-pdf/{id}', [OrderController::class, 'downloadPDF'])->name('download.pdf');

    });
});
});

