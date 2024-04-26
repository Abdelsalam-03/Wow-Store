<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'price',
        'category_id',
        'stock',
        'photo',
        'description',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function onCart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public static function filter(Request $request){
        $products = self::select();
        if ($request->query('query')) {
            $query = $request->query('query');
            $products = $products->where('name', 'LIKE', '%' . $query . '%')
                            ->orWhere('description', 'LIKE', '%' . $query . '%');
        }
        if ($request->query('min-price')) {
            $query = $request->query('min-price');
            $products = $products->where('price', '>', $query);
        }
        if ($request->query('max-price')) {
            $query = $request->query('max-price');
            $products = $products->where('price', '<', $query);
        }
        if ($request->query('category')) {
            $query = $request->query('category');
            $products = $products->where('category_id', '=', $query);
        }

        if ($request->onStock) {
            $products = $products->where('stock', '>', '0');
        }

        if ($request->query('order-by')) {
            $orderBy = $request->query('order-by');
            if ($orderBy != 'name' && $orderBy != 'price' && $orderBy != 'stock') {
                $orderBy = 'price';
            }
            $order = $request->query('order-by');
            if ($order != 'asc' && $order != 'desc') {
                $order = 'asc';
            }
            $products = $products->orderBy($orderBy, $order);
        } else {
            $products = $products->orderBy('category_id', 'desc');
        }

        $products = $products->orderBy('id', 'desc');
        
        return $products;
    }

}
