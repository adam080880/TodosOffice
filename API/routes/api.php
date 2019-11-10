<?php

use Illuminate\Http\Request;

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

// Auth
Route::post('login', 'AuthControllerJWT@login');
Route::post('register', 'AuthControllerJWT@register');

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('me', 'AuthControllerJWT@me');
    Route::post('logout', 'AuthControllerJWT@me');
    Route::post('refresh', 'AuthControllerJWT@me');
});