<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\pdfController;
use App\Http\Controllers\barangController;
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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
Route::get('otp-verification', [GoogleAuthController::class, 'showOtpForm'])->name('otp.view');
Route::post('otp-verification', [GoogleAuthController::class, 'verifyOtp'])->name('otp.verify');
Route::get('otp-resend', [GoogleAuthController::class, 'resendOtp'])->name('otp.resend');
Route::get('/dashboard', function () {
    return view('home'); 
})->middleware('auth')->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('/kategori', [App\Http\Controllers\kategoriController::class, 'index'])->name('kategori_buku')->middleware('auth');
Route::get('/kategori/create', [App\Http\Controllers\kategoriController::class, 'create'])->name('kategori_create')->middleware('auth');
Route::post('/kategori', [App\Http\Controllers\kategoriController::class, 'store'])->name('kategori_store')->middleware('auth');
Route::get('/kategori/{id}/edit', [App\Http\Controllers\kategoriController::class, 'edit'])->name('edit_kategori')->middleware('auth');
Route::put('/kategori/{id}', [App\Http\Controllers\kategoriController::class, 'update'])->name('kategori_update')->middleware('auth');
Route::delete('/kategori/{id}', [App\Http\Controllers\kategoriController::class, 'destroy'])->name('hapus_kategori')->middleware('auth');

Route::get('/buku', [App\Http\Controllers\bukuController::class, 'index'])->name('buku')->middleware('auth');
Route::get('/buku/create', [App\Http\Controllers\bukuController::class, 'create'])->name('buku_create')->middleware('auth');
Route::post('/buku', [App\Http\Controllers\bukuController::class, 'store'])->name('buku_store')->middleware('auth');
Route::get('/buku/{id}/edit', [App\Http\Controllers\bukuController::class, 'edit'])->name('buku_edit')->middleware('auth'); 
Route::put('/buku/{id}', [App\Http\Controllers\bukuController::class, 'update'])->name('buku_update')->middleware('auth');
Route::delete('/buku/{id}', [App\Http\Controllers\bukuController::class, 'destroy'])->name('hapus_buku')->middleware('auth');

Route::get('/cetak-sertifikat', [pdfController::class, 'cetakSertifikat'])->name('cetak.sertifikat')->middleware('auth');
Route::get('/cetak-undangan', [PdfController::class, 'cetakUndangan'])->name('cetak.undangan');

Route::get('/barang', [barangController::class, 'index'])->name('barang')->middleware('auth');
Route::post('/barang/cetak', [barangController::class, 'cetak'])->name('barang_cetak')->middleware('auth');

// --- ROUTE KHUSUS TUGAS KANTIN & AJAX ---
Route::prefix('admin-kantin')->middleware('auth')->group(function () {
    // Tampilan Halaman Dropdown Wilayah
    Route::get('/wilayah', [App\Http\Controllers\Kantin\WilayahController::class, 'index'])->name('kantin_wilayah');
    
    // API Endpoint untuk Axios (Cascading Dropdown)
    Route::get('/api/kota/{id_provinsi}', [App\Http\Controllers\Kantin\WilayahController::class, 'getKota']);
    Route::get('/api/kecamatan/{id_kota}', [App\Http\Controllers\Kantin\WilayahController::class, 'getKecamatan']);
    Route::get('/api/kelurahan/{id_kecamatan}', [App\Http\Controllers\Kantin\WilayahController::class, 'getKelurahan']);
    Route::get('/wilayah-ajax', [App\Http\Controllers\Kantin\WilayahController::class, 'indexAjax'])->name('kantin_wilayah_ajax');

    // --- ROUTE KHUSUS KASIR ---
    Route::get('/kasir', [App\Http\Controllers\Kantin\KasirController::class, 'index'])->name('kantin.kasir');
    Route::get('/api/barang/{kode}', [App\Http\Controllers\Kantin\KasirController::class, 'searchBarang']);
    Route::post('/api/checkout', [App\Http\Controllers\Kantin\KasirController::class, 'checkout']);

    Route::post('/api/midtrans-webhook', [App\Http\Controllers\Kantin\KasirController::class, 'webhook']);
});