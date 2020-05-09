<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\User;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Current Customer and his permissions
        // return Permission::all();
        // $hostname  = app(\Hyn\Tenancy\Environment::class)->hostname();
        // dd($hostname->customer->hasPermissionTo('create-users', 'customer'));
        // dd($hostname->customer->getDirectPermissions());

        $permission = Permission::find(2);
        $user = User::with('permissions')->find(1);
        dd($user->hasPermissionTo($permission));


        // Get Users Customer 
        // return User::all();
    }
}
