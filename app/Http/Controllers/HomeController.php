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
        if (Auth::check()) {
            return view('index', ['products' => Product::filter($request)->paginate(3), 'categories' => Category::all()]);
        } else {
            return view('guest');
        }
    }
}
