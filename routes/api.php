<?php

use App\Http\Controllers\Api\V1\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\V1\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\SettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function(){
    Route::get('/settings', SettingsController::class);
    Route::get('/products', [ProductController::class, 'all']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'all']);

    Route::apiResource('/categories', AdminCategoryController::class);
    Route::apiResource('/products', AdminProductController::class);

});


// Route::prefix('admin/')->name('admin.')->group(function(){
//     Route::get('/', AdminHomeController::class)->name('home');
//     Route::resource('/categories', AdminCategoryController::class);
//     Route::resource('/products', AdminProductController::class);
//     Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
//     Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
//     Route::delete('/orders/cancel/{order}', [AdminOrderController::class, 'cancel'])->name('orders.delete');
//     Route::patch('/orders/process/{order}', [AdminOrderController::class, 'process'])->name('orders.process');
//     Route::patch('/orders/ship/{order}', [AdminOrderController::class, 'ship'])->name('orders.ship');
//     Route::patch('/orders/arrive/{order}', [AdminOrderController::class, 'arrive'])->name('orders.arrive');
//     Route::post('/orders/search', [AdminOrderController::class, 'search'])->name('orders.search');
//     Route::get('/settings', [AdminSettingsController::class, 'view'])->name('settings');
//     Route::get('/settings/create', [AdminSettingsController::class, 'create'])->name('settings.create');
//     Route::post('/settings/set', [AdminSettingsController::class, 'set'])->name('settings.set');
//     Route::put('/settings/update', [AdminSettingsController::class, 'update'])->name('settings.update');
// });

