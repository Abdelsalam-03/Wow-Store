<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function index(){
        return view('user.categories.index', ['categories' => Category::all()]);
    }

    function show(Request $request){
        $category = Category::findOrFail($request->category);
        return view('user.categories.show', ['category' => $category, 'products' => $category->products]);
    }

}