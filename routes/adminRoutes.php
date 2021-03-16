<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::group(["middleware" => ["checkRole:ADMIN"], "prefix" => "admin"], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
