<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use app\http\Controllers\Controller;
use App\models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('admin.categories.index', ['categories' => Category::filter($request)->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:categories',],
        ]);
        Category::create(['name' => $request->name]);
        if (isset($request->return)) {
            return redirect(route('admin.categories.create'))->with('success', 'Category Created');
        }
        return redirect(route('admin.categories.index'))->with('success', 'Category Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return(view('admin.categories.show', [
            'category' => Category::findOrFail($id), 
            'products' => Product::select()->where('category_id', '=', $id)->paginate(10)
        ]));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return(view('admin.categories.edit', ['category' => Category::findOrFail($id)]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'unique:categories'],
        ]);
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();
        return redirect(route('admin.categories.show', ['category' => $id]))->with('success', 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::destroy($id);
        return redirect(route('admin.categories.index'))->with('success', 'Category Deleted');
    }
}
