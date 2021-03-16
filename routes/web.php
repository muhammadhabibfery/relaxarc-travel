<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DetaiController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Http;

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

Route::middleware('preventBack')
    ->group(function () {
        Route::group(['middleware' => ['auth']], function () {

            Route::group(['middleware' => ['verified', 'hasFullProfile']], function () {
                Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
                Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout-success');
                require __DIR__ . '/adminRoutes.php';
            });

            Route::get('/profile', [ProfileController::class, 'frontProfile'])->name('front-profile');
            Route::patch('/profile', [ProfileController::class, 'updateProfile'])->name('update-profile');
            Route::get("/complete-your-profile-first", [ProfileController::class, "completeProfileFirst"])->name("complete-profile");
            Route::post("/profile/delete-avatar", [ProfileController::class, "deleteAvatar"])->name("delete-avatar");
        });

        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/travels', function () {
            return view('pages.frontend.travels');
        })->name('travels');
        Route::get('/terms-conditions', function () {
            return view('pages.frontend.terms-conditions');
        })->name('terms-conditions');
        Route::get('/contact-us', [ContactController::class, 'index'])->name('contact');
        Route::get('/detail', [DetaiController::class, 'index'])->name('detail');

        Auth::routes(['verify' => true]);
    });
