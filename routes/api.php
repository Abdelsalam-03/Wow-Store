<?php

use App\Http\Controllers\Api\V1\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Api\V1\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\V1\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\V1\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\LiveController;
use App\Http\Controllers\Api\V1\Manager\AdminController as ManagerAdminController;
use App\Http\Controllers\Api\V1\OrderController as UserOrderController;
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
    Route::get('/livesearch', [LiveController::class, 'liveSearch']);
    Route::get('/orders', [UserOrderController::class, 'all']);
    Route::delete('/orders/{order}', [UserOrderController::class, 'delete']);

    // Auth Middleware
    Route::get('/cart/all', [CartController::class, 'all']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::patch('/cart/update/{product}', [CartController::class, 'update']);
    Route::delete('/cart/destroy', [CartController::class, 'destroy']);
    Route::delete('/cart/{product}', [CartController::class, 'remove']);
    

    // Admin Middleware
    Route::prefix('admin')->group(function(){
        Route::apiResource('/categories', AdminCategoryController::class);
        Route::apiResource('/products', AdminProductController::class);
        Route::get('/orders', [AdminOrderController::class, 'index']);
        Route::get('/orders/{order}', [AdminOrderController::class, 'show']);
        Route::delete('/orders/cancel/{order}', [AdminOrderController::class, 'cancel']);
        Route::patch('/orders/process/{order}', [AdminOrderController::class, 'process']);
        Route::patch('/orders/ship/{order}', [AdminOrderController::class, 'ship']);
        Route::patch('/orders/arrive/{order}', [AdminOrderController::class, 'arrive']);
        Route::post('/settings/set', [AdminSettingsController::class, 'set']);
        Route::put('/settings/update', [AdminSettingsController::class, 'update']);
    });

    // Manager Middleware
    Route::prefix('manager/')->group(function(){
        Route::get('/admins', [ManagerAdminController::class, 'index'])->name('admins.index');
        Route::post('/admins/store', [ManagerAdminController::class, 'store'])->name('admins.store');
        Route::patch('/admins/{admin}', [ManagerAdminController::class, 'suspend'])->name('admins.suspend');
    });

});
