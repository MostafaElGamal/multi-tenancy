<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function checkTenant()
    {
        $hostname = app(\Hyn\Tenancy\Environment::class)->hostname();
        return $hostname ?  response()->json(true) :  response()->json(false);
    }
}
