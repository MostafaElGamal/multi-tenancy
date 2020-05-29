<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Permission;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    public function tenantPermissions()
    {
        $hostname  = app(\Hyn\Tenancy\Environment::class)->hostname();
        return $hostname->customer->getDirectPermissions();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customerPermissions = $this->tenantPermissions();
        $customerUserPermissions = Permission::all();
        $permissions = [];
        foreach ($customerUserPermissions as $permission) {
            if (linearSearch($permission, $customerPermissions)) {
                array_push($permissions, $permission);
            }
        }
        return $permissions;
    }
}
