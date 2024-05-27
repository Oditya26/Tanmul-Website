<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\buatKirimanController;
use App\Http\Controllers\detailController;
use App\Http\Controllers\pelangganController;
use App\Http\Controllers\stockController;
use Laravel\Socialite\Facades\Socialite;

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
Route::redirect('/', 'dashboard');
Route::redirect('home', 'dashboard');

Route::get('/auth',[authController::class, "index"])->name('login')->middleware('guest');
Route::get('/auth/redirect',[authController::class, "redirect"])->middleware('guest');
Route::get('/auth/callback',[authController::class, "callback"])->middleware('guest');
Route::get('/auth/logout', [authController::class, "logout"]);

Route::prefix('dashboard')->middleware('auth')->group(
    function() {
        Route::get('/', [stockController::class, "index"]);
        Route::resource('pelanggan', pelangganController::class);
        Route::resource('stock', stockController::class);
        Route::resource('buat-kiriman', buatKirimanController::class);
        
        Route::prefix('buat-kiriman/{id_kirim}/details')->group(function() {
            Route::get('/', [DetailController::class, 'index'])->name('buat-kiriman.details.index');
            Route::get('create', [DetailController::class, 'create'])->name('buat-kiriman.details.create');
            Route::post('/', [DetailController::class, 'store'])->name('buat-kiriman.details.store');
            Route::get('{id_detail}', [DetailController::class, 'show'])->name('buat-kiriman.details.show');
            Route::get('{id_detail}/edit', [DetailController::class, 'edit'])->name('buat-kiriman.details.edit');
            Route::put('{id_detail}', [DetailController::class, 'update'])->name('buat-kiriman.details.update');
            Route::delete('{id_detail}', [DetailController::class, 'destroy'])->name('buat-kiriman.details.destroy');
        });
    }
);