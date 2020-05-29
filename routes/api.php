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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('login', 'System\AuthController@login');
Route::get('/checkTenant', 'System\ConfigController@checkTenant');


Route::group(['middleware' => ['auth.guard.checker:system', 'jwt.auth']], function () {
    Route::post('logout', 'System\AuthController@logout');
    Route::post('refresh', 'System\AuthController@refresh');
    Route::post('user', 'System\AuthController@user');
    Route::apiResource('/users', 'System\UserController');
    Route::apiResource('/customers', 'System\CustomersController');
    Route::get('permissions', 'System\PermissionsController@index');
});
