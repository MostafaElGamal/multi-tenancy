<?php

namespace App\Http\Controllers\Tenant;

use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
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
            if ($this->linearSearch($permission, $customerPermissions)) {
                array_push($permissions, $permission);
            }
        }
        return $permissions;
    }

    public function linearSearch($value, $array)
    {
        $found = false;
        $index = 0;

        while (!$found && $index < count($array)) {
            if ($array[$index]->name == $value->name) {
                $found = true;
            } else {
                $index += 1;
            }
        }
        return $found;
    }
}
