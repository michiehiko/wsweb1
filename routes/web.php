<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('/kategori', [App\Http\Controllers\kategoriController::class, 'index'])->name('kategori_buku')->middleware('auth');
Route::get('/kategori/create', [App\Http\Controllers\kategoriController::class, 'create'])->name('kategori_create')->middleware('auth');
Route::post('/kategori', [App\Http\Controllers\kategoriController::class, 'store'])->name('kategori_store')->middleware('auth');

Route::get('/buku', [App\Http\Controllers\bukuController::class, 'index'])->name('buku')->middleware('auth');
Route::get('/buku/create', [App\Http\Controllers\bukuController::class, 'create'])->name('buku_create')->middleware('auth');
Route::post('/buku', [App\Http\Controllers\bukuController::class, 'store'])->name('buku_store')->middleware('auth');