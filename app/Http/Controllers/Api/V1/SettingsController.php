<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    function __invoke()
    {
        return response()->json(['settings' => Settings::settings()]);
    }
}
