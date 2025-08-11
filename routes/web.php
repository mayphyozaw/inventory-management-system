<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/admin/logout',[AdminController::class,'admin_logout'])->name('admin.logout');
Route::post('/admin/login',[AdminController::class,'admin_login'])->name('admin.login');

Route::get('/verify',[AdminController::class,'showVerification'])->name('custom.verification.form');
Route::post('/verify',[AdminController::class,'verificationVerify'])->name('custom.verification.verify');
