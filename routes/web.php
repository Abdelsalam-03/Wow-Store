<?php

use App\Http\Controllers\User\CategoryController as UserCategoryController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LiveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RedirectController;
use App\Http\Middleware\admin;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/redirect', RedirectController::class)->name('redirect');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/cart/all', [CartController::class, 'all']);
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/destroy', [CartController::class, 'destroy']);
    Route::delete('/cart/{id}', [CartController::class, 'remove']);
});

require __DIR__.'/auth.php';

Route::middleware(['auth', admin::class])->group(function (){
    Route::prefix('admin/')->name('admin.')->group(function(){
        Route::get('/', AdminHomeController::class)->name('home');
        Route::resource('/categories', AdminCategoryController::class);
        Route::resource('/products', AdminProductController::class);
    });
});

Route::get('/categories', UserCategoryController::class . '@index')->name('user.categories');
Route::get('/categories/{category}', UserCategoryController::class . '@show')->name('user.category');

Route::get('/products', UserProductController::class . '@index')->name('user.products');
Route::get('/products/{product}', UserProductController::class . '@show')->name('user.product');

Route::get('/livesearch', [LiveController::class, 'liveSearch']);