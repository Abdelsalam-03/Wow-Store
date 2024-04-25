<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    function __invoke()
    {
        $settings = Settings::settings();
        $totalAdmins = User::select('id')->where('role', '=', 'admin')->count();
        $pendingOrders = Order::select()
                        ->where('status', '=', 'pending')
                        ->count();
        $processingOrders = Order::select()
                        ->where('status', '=', 'processing')
                        ->count();
        $shippedOrders = Order::select()
                        ->where('status', '=', 'shipped')
                        ->count();
        $deliveredOrders = Order::select()
                        ->where('status', '=', 'delivered')
                        ->count();
        $totalCategories = Category::select('id')->count();
        $totalProducts = Product::select('id')->count();
        $lowStockProducts = Product::select()
                            ->where('stock', '<', $settings?->stock_warning)
                            ->count();
        
        return view('admin.index', [
            'role' => Auth::user()->role,
            'settings' => $settings,
            'totalAdmins' => $totalAdmins,
            'pendingOrders' => $pendingOrders,
            'processingOrders' => $processingOrders,
            'shippedOrders' => $shippedOrders,
            'deliveredOrders' => $deliveredOrders,
            'totalCategories' => $totalCategories,
            'totalProducts' => $totalProducts,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }
}
