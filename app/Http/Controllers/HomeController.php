<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    function __invoke(Request $request)
    {
        $request->merge(['onStock' => true]);
        return view('index', [
            'products' => Product::filter($request)->paginate(12),
            'categories' => Category::select()->orderBy('id', 'desc')->get(),
            'settings' => Settings::settings(),
        ]);
    }
}
