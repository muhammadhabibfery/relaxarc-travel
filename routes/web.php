<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetaiController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/travels', function () {
    return view('pages.frontend.travels');
})->name('travels');
Route::get('/terms-conditions', function () {
    return view('pages.frontend.terms-conditions');
})->name('terms-conditions');
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact');
Route::get('/detail', [DetaiController::class, 'index'])->name('detail');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout-success');

Auth::routes();

Route::prefix('admin')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

// require __DIR__ . '/dashboard.php';
// Route::prefix('admin')
//     ->group(function () {
//         Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
//     });

// Route::get('/home', [HomeController::class, 'index'])->name('home');

// NOTE: Tonton materi video, ketika sampai materi auth (login & register) gunakan logic yang berbeda dari yg ada di video. Karena Step nya setelah login redirect ke fitur profil untuk melengkapi data yg belum lengkap seperti username, phone, alamat, dan lainnya (kalo masih ada data lainnya hehe).
