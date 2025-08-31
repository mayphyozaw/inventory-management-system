<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
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

Route::middleware('auth')->group(function () {
    Route::get('/profile',[AdminController::class,'admin_profile'])->name('admin.profile');
    Route::post('/profile/store',[AdminController::class,'profile_store'])->name('profile.store');
    Route::post('/admin/password/update',[AdminController::class,'password_update'])->name('admin.password.update');

});

Route::middleware('auth')->group(function () {
    Route::controller(ReviewController::class)->group(function(){
        Route::get('/all/review','AllReview')->name('all.review');
        Route::get('/add/review','AddReview')->name('add.review');
        Route::post('/store/review','StoreReview')->name('store.review');
        Route::get('/eidt/review/{id}','EditReview')->name('edit.review');
        Route::post('/update/review','UpdateReview')->name('update.review');
        Route::get('/delete/review/{id}','DeleteReview')->name('delete.review');

    });


    Route::controller(SliderController::class)->group(function(){
        Route::get('/get/slider','GetSlider')->name('get.slider');
        Route::post('/update/slider','UpdateSlider')->name('update.slider');
        Route::post('/edit-slider/{id}','EditSlider');
        Route::post('/edit-features/{id}','EditFeatures');
        Route::post('/edit-reviews/{id}','EditReview');
        Route::post('/edit-answers/{id}','EditAnswer');
        

    });


    Route::controller(HomeController::class)->group(function(){
         Route::get('/all/features','AllFeature')->name('all.feature');
        Route::get('/add/feature','AddFeature')->name('add.feature');
        Route::post('/store/feature','StoreFeature')->name('store.feature');
        Route::get('/eidt/feature/{id}','EditFeature')->name('edit.feature');
        Route::post('/update/feature','UpdateFeature')->name('update.feature');
        Route::get('/delete/feature/{id}','DeleteFeature')->name('delete.feature');
        

    });


    Route::controller(HomeController::class)->group(function(){
         Route::get('/get/clarifies','GetClarifies')->name('get.clarifies');
         Route::post('/update/clarify','UpdateClarifies')->name('update.clarify');
        
    });

     Route::controller(HomeController::class)->group(function(){
         Route::get('/get/usability','GetUsability')->name('get.usability');
         Route::post('/update/usability','UpdateUsability')->name('update.usability');
        
    });
});