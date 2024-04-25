<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    function __invoke(Request $request)
    {
        $request->merge(['onStock' => true]);
        return view('index', [
            'products' => Product::filter($request)->paginate(10),
            'categories' => Category::all(),
        ]);
    }
}
