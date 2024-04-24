<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
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

}
