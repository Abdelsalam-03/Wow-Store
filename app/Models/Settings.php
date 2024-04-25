<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    static function setted()
    {
        $settings = self::select()->first();
        if ($settings) {
            return true;
        } else {
            return false;
        }
    }

    static function settings()
    {
        return self::select()->first();
    }

}
