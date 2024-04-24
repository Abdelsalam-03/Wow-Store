<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public static function filter(Request $request){
        $categories = self::select();
        if ($request->query('name')) {
            $query = $request->query('name');
            $categories = $categories->where('name', 'LIKE', '%' . $query . '%');
        }
        return $categories;
    }

}
