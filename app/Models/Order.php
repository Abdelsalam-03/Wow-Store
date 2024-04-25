<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'shipping_cost',
        'total',
        'status',
        'address',
    ];

    public static function filter(Request $request){
        $orders = self::select();
        if ($request->status) {
            $query = $request->status;
            $orders = $orders->where('status', '=', $query);
        }
        
        $orders->orderBy('date', 'asc');

        return $orders;
    }
    
    public function products(): HasMany
    {
        return $this->hasMany(Order_product::class);
    }

    static function totalSales()
    {
        return self::select(DB::raw('SUM(total) as total'))
            ->where('status', 'delivered')
            ->first()->total;

    }


}
