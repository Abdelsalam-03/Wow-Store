<?php

use App\Http\Controllers\Api\V1\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Api\V1\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\V1\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\V1\Admin\SettingsController as AdminSettingsController;
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

    Route::prefix('admin')->group(function(){
        Route::apiResource('/categories', AdminCategoryController::class);
        Route::apiResource('/products', AdminProductController::class);
        Route::get('/orders', [AdminOrderController::class, 'index']);
        Route::get('/orders/{order}', [AdminOrderController::class, 'show']);
        Route::delete('/orders/cancel/{order}', [AdminOrderController::class, 'cancel']);
        Route::patch('/orders/process/{order}', [AdminOrderController::class, 'process']);
        Route::patch('/orders/ship/{order}', [AdminOrderController::class, 'ship']);
        Route::patch('/orders/arrive/{order}', [AdminOrderController::class, 'arrive']);
        Route::post('/settings/set', [AdminSettingsController::class, 'set'])->name('settings.set');

    });

});


// Route::prefix('admin/')->name('admin.')->group(function(){
//     Route::put('/settings/update', [AdminSettingsController::class, 'update'])->name('settings.update');
// });

