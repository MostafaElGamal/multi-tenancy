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


Route::get('/users', 'System\UserController@index');

Route::post('login', 'System\AuthController@login');

Route::group(['middleware' => ['assign.guard:system', 'jwt.auth']], function () {
    Route::post('logout', 'System\AuthController@logout');
    Route::post('refresh', 'System\AuthController@refresh');
    Route::post('me', 'System\AuthController@me');
});
