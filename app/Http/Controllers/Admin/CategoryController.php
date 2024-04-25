<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use app\http\Controllers\Controller;
use App\models\Category;
use App\Models\Product;
use App\Models\Settings;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('admin.categories.index', [
            'categories' => Category::filter($request)->paginate(10),
            'settings' => Settings::settings(),
        ]);
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
            'photo' => ['required'],
        ]);

        $image_parts = explode(";base64,", $request->photo);
        $image_type_aux = explode("image/", $image_parts[0]);
        $name = 'categories/' . time() . uniqid() . '.' . $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        Storage::put('public/' . $name, $image_base64);

        Category::create([
            'name' => $request->name,
            'photo' => $name,
        ]);

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
            'products' => Product::select()->where('category_id', '=', $id)->paginate(10),
            'settings' => Settings::settings(),
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
        $category = Category::findOrFail($id);
        if ($category->name == $request->name) {
            $request->validate([
                'photo' => ['required'],
            ]);
        } else {
            $request->validate([
                'name' => ['required', 'unique:categories'],
                'photo' => ['required'],
            ]);
            $category->name = $request->name;
        }


        if ($request->photo != 'old') {
            $image_parts = explode(";base64,", $request->photo);
            $image_type_aux = explode("image/", $image_parts[0]);
            $name = 'categories/' . time() . uniqid() . '.' . $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            Storage::put('public/' . $name, $image_base64);
            if ($category->photo) {
                Storage::delete('public/' . $category->photo);
            }
            $category->photo = $name;
        }

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
