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
            if ($request->query('query')) {
                $query = $request->query('query');
                $products = Product::where('name', 'like', "%$query%")
                                    ->get();
                return view('index', ['products' => $products, 'categories' => Category::all()]);
            }else {
                return view('index', ['products' => Product::all(), 'categories' => Category::all()]);
            }
        } else {
            return view('guest');
        }
    }
}