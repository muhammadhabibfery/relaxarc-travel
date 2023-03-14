<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TravelGalleryController;
use App\Http\Controllers\TravelPackageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware(["authRoles:ADMIN,1"])
    ->prefix('admin-panel')
    ->group(function () {

        // User who have ADMIN role can be access these routes
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get("/profile", [ProfileController::class, "backProfile"])->name("back-profile");
        Route::get("/profile/change-password", [ProfileController::class, "backChangePassword"])->name("back-change-password");

        Route::get("/travel-packages/trash", [TravelPackageController::class, "indexTrash"])->name("travel-packages.trash");
        Route::get("/travel-packages/trash/{slug}", [TravelPackageController::class, "showTrash"])->name("travel-packages.trash.show");
        Route::get("/travel-packages/restore/{slug}", [TravelPackageController::class, "restore"])->name("travel-packages.restore");
        Route::delete("/travel-packages/force-delete/{slug}", [TravelPackageController::class, "forceDelete"])->name("travel-packages.force-delete");
        Route::get("/travel-packages/edit/{travel_package:slug}", [TravelPackageController::class, "edit"])->name("travel-packages.edit");
        Route::resource("travel-packages", TravelPackageController::class)
            ->parameters(["travel-packages" => "travel_package:slug"])
            ->except(["edit", "show"]);
        Route::get("/travel-packages/{travel_package:slug}/{invoice_number?}", [TravelPackageController::class, "show"])
            ->name("travel-packages.show");

        Route::resource("travel-galleries", TravelGalleryController::class)
            ->parameters(["travel-galleries" => "travel_gallery:slug"])
            ->except(["edit", "update", "show"]);
        Route::get("travel-galleries/{travel_package:slug}", [TravelGalleryController::class, "show"])->name("travel-galleries.show");

        Route::get("/transactions/trash", [TransactionController::class, "indexTrash"])->name("transactions.trash");
        Route::get("/transactions/trash/{invoice_number}", [TransactionController::class, "showTrash"])->name("transactions.trash.show");
        Route::get("/transactions/restore/{invoice_number}", [TransactionController::class, "restore"])->name("transactions.restore");
        Route::delete("/transactions/force-delete/{invoice_number}", [TransactionController::class, "forceDelete"])->name("transactions.force-delete");
        Route::resource("transactions", TransactionController::class)
            ->parameters(["transactions" => "transaction:invoice_number"])
            ->except(["edit", "update"]);

        // User who have ADMIIN & SUPERADMIN roles can be access these routes
        Route::middleware(["authRoles:ADMIN,SUPERADMIN,2"])
            ->group(function () {
                Route::post("/users/generate-username", [UserController::class, "generateUsername"])->name("users.generate-username")
                    ->withoutMiddleware(['auth', 'verified', 'hasFullProfile']);
                Route::get("/users/edit/{user:username}", [UserController::class, "edit"])->name("users.edit");
                Route::resource("users", UserController::class)
                    ->parameters(["users" => "user:username"])
                    ->except(["edit", "show"]);
            });
    });
