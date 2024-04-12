<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use app\http\Controllers\Controller;
use App\models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.categories.index', ['categories' => Category::all()]);
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
        return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return(view('admin.categories.show', ['category' => Category::findOrFail($id)]));
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
            'name' => ['required',],
        ]);
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();
        return redirect(route('categories.show', ['category' => $id]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
