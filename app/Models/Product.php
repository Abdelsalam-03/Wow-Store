<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public static function filter(Request $request){
        $products = self::select();
        if ($request->query('query')) {
            $query = $request->query('query');
            $products = $products->where('name', 'LIKE', '%' . $query . '%')
                            ->orWhere('description', 'LIKE', '%' . $query . '%');
        }
        if ($request->query('min-price')) {
            $query = $request->query('min-price');
            $products = $products->where('price', '>', +$query);
        }
        if ($request->query('max-price')) {
            $query = $request->query('max-price');
            $products = $products->where('price', '<', +$query);
        }

        if ($request->query('order-by')) {
            $orderBy = $request->query('order-by');
            if ($orderBy != 'name' && $orderBy != 'price') {
                $orderBy = 'price';
            }
            $order = $request->query('order-by');
            if ($order != 'asc' && $order != 'desc') {
                $order = 'asc';
            }
            $products = $products->orderBy($orderBy, $order);
        }
        
        return $products;
    }

}
