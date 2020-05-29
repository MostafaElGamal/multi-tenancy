<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'tenant.checker'], function () {
    $namespace = 'App\\Http\\Controllers\\Tenant\\';
    Route::prefix('api')->namespace($namespace)->group(function () {

        Route::post('login', 'AuthController@login');
        Route::get('/tenant/permissions', 'PermissionsController@tenantPermissions');

        Route::group(['middleware' => ['auth.guard.checker:tenant', 'jwt.auth']], function () {
            Route::post('logout', 'AuthController@logout');
            Route::post('refresh', 'AuthController@refresh');
            Route::post('user', 'AuthController@user');
            Route::apiResource('users', 'UserController');
            Route::get('permissions', 'PermissionsController@index');
        });
    });
});
