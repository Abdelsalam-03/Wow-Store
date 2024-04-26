<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LiveController;
use App\Http\Controllers\Manager\AdminController;
use App\Http\Controllers\OrderController as UserOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\SettingsController;
use App\Http\Middleware\admin;
use App\Http\Middleware\guestToHome;
use App\Http\Middleware\manager;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/redirect', RedirectController::class)->middleware(guestToHome::class, 'verified')->name('redirect');

// Route::get('/dashboard', function () {
    //     return redirect(route('redirect'));
    // })->middleware(['auth', 'verified'])->name('dashboard');
    
Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/all', [CartController::class, 'all']);
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/destroy', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [CheckoutController::class, 'check'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/address/create', [AddressController::class, 'create']);
    Route::get('/orders', [UserOrderController::class, 'index'])->name('user.orders');
    Route::delete('/orders/{order}', [UserOrderController::class, 'delete'])->name('user.orders.delete');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified', admin::class])->group(function (){
    Route::prefix('admin/')->name('admin.')->group(function(){
        Route::get('/', AdminHomeController::class)->name('home');
        Route::resource('/categories', AdminCategoryController::class);
        Route::resource('/products', AdminProductController::class);
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::delete('/orders/cancel/{order}', [AdminOrderController::class, 'cancel'])->name('orders.delete');
        Route::patch('/orders/process/{order}', [AdminOrderController::class, 'process'])->name('orders.process');
        Route::patch('/orders/ship/{order}', [AdminOrderController::class, 'ship'])->name('orders.ship');
        Route::patch('/orders/arrive/{order}', [AdminOrderController::class, 'arrive'])->name('orders.arrive');
        Route::post('/orders/search', [AdminOrderController::class, 'search'])->name('orders.search');
        Route::get('/settings', [AdminSettingsController::class, 'view'])->name('settings');
        Route::get('/settings/create', [AdminSettingsController::class, 'create'])->name('settings.create');
        Route::post('/settings/set', [AdminSettingsController::class, 'set'])->name('settings.set');
        Route::put('/settings/update', [AdminSettingsController::class, 'update'])->name('settings.update');
    });
});
Route::middleware(['auth', 'verified', manager::class])->group(function (){
    Route::prefix('manager/')->name('manager.')->group(function(){
        Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
        Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
        Route::post('/admins/store', [AdminController::class, 'store'])->name('admins.store');
        Route::patch('/admins/{admin}', [AdminController::class, 'suspend'])->name('admins.suspend');
    });
});

Route::get('/products/{product}', UserProductController::class . '@show')->name('user.product');  

Route::get('/livesearch', [LiveController::class, 'liveSearch']);