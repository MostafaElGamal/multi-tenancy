<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hostname  = app(\Hyn\Tenancy\Environment::class)->hostname();
        // Get Current Customer 
        // dd($hostname->customer->name);


        // Switch if there is customer 
        if ($fqdn = optional($hostname)->fqdn) {
            config(['database.default' => 'tenant']);
            dd($fqdn);
        }

        // Get Users Customer 
        // return User::all();
    }
}
