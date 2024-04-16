<?php

use App\Http\Controllers\User\CategoryController as UserCategoryController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::delete('/cart/destroy', [CartController::class, 'destroy']);
    Route::put('/cart/update', [CartController::class, 'update']);
});

require __DIR__.'/auth.php';

Route::prefix('admin/')->group(function(){
    Route::resource('/categories', AdminCategoryController::class);
    Route::resource('products', AdminProductController::class);
});

Route::get('/categories', UserCategoryController::class . '@index')->name('user.categories');
Route::get('/categories/{category}', UserCategoryController::class . '@show')->name('user.category');

Route::get('/products', UserProductController::class . '@index')->name('user.products');
Route::get('/products/{product}', UserProductController::class . '@show')->name('user.product');