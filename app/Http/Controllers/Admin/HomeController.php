<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    function __invoke()
    {
        $pendingOrders = Order::select()
                        ->where('status', '=', 'pending')
                        ->get();
        $totalCategories = Category::select()->count();
        $totalProducts = Product::select()->count();
        return view('admin.index', [
            'role' => Auth::user()->role,
            'settings' => Settings::settings(),
            'pendingOrders' => $pendingOrders,
            'totalCategories' => $totalCategories,
            'totalProducts' => $totalProducts,
        ]);
    }
}
