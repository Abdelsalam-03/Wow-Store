<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function __invoke()
    {
        $pendingOrders = Order::select()
                        ->where('status', '=', 'pending')
                        ->get();
        return view('admin.index', ['pendingOrders' => $pendingOrders]);
    }
}
