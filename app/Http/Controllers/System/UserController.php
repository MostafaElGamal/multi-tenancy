<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\System\User;
use App\Models\System\Permission;

class UserController extends Controller
{
    private function getUser($id)
    {
        $user = User::find($id);
        $permissions =  $user->getAllPermissions()->pluck('id');
        return ['user' => $user,'permissions' => $permissions];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $permission = Permission::find(1);
        // $user = User::with('permissions')->find(1);
        // dd($user->hasPermissionTo($permission));
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permissions = Permission::whereIn('id', $request->selectedPermissons)->get();
        $user = User::create($request->all());
        $user->givePermissionTo($permissions);
        return $user;
    }

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->getUser($id);
        return $user;
    }

    /**
     * Show the profile for the given user.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $user = User::find($id);
        $user->update($request->all());
        $user->syncPermissions($permissions);
        return $user;
    }


    /**
     * Show the profile for the given user.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->syncPermissions([]);
        $user->delete();
        return 'Deleted';
    }
}
