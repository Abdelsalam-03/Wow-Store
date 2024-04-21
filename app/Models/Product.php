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
        $products = null;
        if ($request->query('query')) {
            $query = $request->query('query');
            $products = self::select('*')
                            ->where('name', 'LIKE', '%' . $query . '%')
                            ->orWhere('description', 'LIKE', '%' . $query . '%')
                            ->orWhere('price', '=', $query);
        } else {
            $products = self::select();
        }
        return $products;
    }

}
