<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TravelGalleryController;
use App\Http\Controllers\TravelPackageController;
use App\Http\Controllers\UserController;
use App\Models\TravelPackage;
use Illuminate\Support\Facades\Route;


Route::group(["middleware" => ["checkRole:ADMIN"], "prefix" => "admin"], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get("/profile", [ProfileController::class, "backProfile"])->name("back-profile");
    Route::get("/profile/change-password", [ProfileController::class, "backChangePassword"])->name("back-change-password");

    Route::group(["middleware" => ["isSuperAdmin:ADMIN,SUPERADMIN"]], function () {
        Route::post("/users/generate-username", [UserController::class, "generateUsername"])->name("users.generate-username");
        Route::get("/users/edit/{user:username}", [UserController::class, "edit"])->name("users.edit");
        Route::resource("users", UserController::class)
            ->parameters(["users" => "user:username"])
            ->except(["edit", "show"]);
    });

    Route::get("/travel-packages/trash", [TravelPackageController::class, "trash"])->name("travel-packages.trash");
    Route::get("/travel-packages/restore/{slug}", [TravelPackageController::class, "restore"])->name("travel-packages.restore");
    Route::delete("/travel-packages/force-delete/{slug}", [TravelPackageController::class, "forceDelete"])->name("travel-packages.force-delete");
    Route::get("/travel-packages/edit/{travel_package:slug}", [TravelPackageController::class, "edit"])->name("travel-packages.edit");
    Route::resource("travel-packages", TravelPackageController::class)
        ->parameters(["travel-packages" => "travel_package:slug"])
        ->except(["edit"]);

    Route::resource("travel-galleries", TravelGalleryController::class)
        ->parameters(["travel-galleries" => "travel_gallery:slug"])
        ->except(["edit", "update"]);
});
