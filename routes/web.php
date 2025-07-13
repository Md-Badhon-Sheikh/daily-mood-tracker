<?php

use App\Http\Controllers\backend\admin\DashboardController;
use App\Http\Controllers\backend\admin\MoodTypeController;
use App\Http\Controllers\backend\admin\ProfileController;
use App\Http\Controllers\backend\AuthenticationController;
use App\Http\Controllers\backend\operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\backend\operator\ProfileController as OperatorProfileController;
use App\Http\Controllers\FrontEndController;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\OperatorAuthenticationMiddleware;
use Illuminate\Support\Facades\Route;

// frontend 

Route::get('/', [FrontEndController::class, 'home'])->name('home');


// backend 
Route::match(['get', 'post'], 'login', [AuthenticationController::class, 'login'])->name('login');
// route prefix 
Route::prefix('admin')->group(function () {
    // route name prefix 
    Route::name('admin.')->group(function () {
        //middleware 
        Route::middleware(AdminAuthenticationMiddleware::class)->group(function () {
            Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
            //profile 
            Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
            Route::post('profile-info/update', [ProfileController::class, 'profile_info_update'])->name('profile.info.update');
            Route::post('profile-password/update', [ProfileController::class, 'profile_password_update'])->name('profile.password.update');
            //dashboard
            Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

            Route::match(['get', 'post'], 'mood_type', [MoodTypeController::class, 'MoodType'])->name('mood_type');

        });
    });
});
// Advocate 
// route prefix
Route::prefix('operator')->group(function () {
    // route name prefix
    Route::name('operator.')->group(function () {
        //middleware 
            Route::middleware(OperatorAuthenticationMiddleware::class)->group(function () {
            Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
            //profile 
            Route::get('profile', [OperatorProfileController::class, 'profile'])->name('profile');
            Route::post('profile-info/update', [OperatorProfileController::class, 'profile_info_update'])->name('profile.info.update');
            Route::post('profile-password/update', [OperatorProfileController::class, 'profile_password_update'])->name('profile.password.update');
            //dashboard 
            Route::get('dashboard', [OperatorDashboardController::class, 'dashboard'])->name('dashboard');
        });
    });
});
