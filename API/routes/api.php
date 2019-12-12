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


header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:X-PINGOTHER, Content-Type, Authorization, Content-Length, X-Requested-With');
header('Access-Control-Allow-Methods:GET, POST, PUT, PATCH, DELETE, OPTIONS');

// Auth
Route::post('login', 'AuthControllerJWT@login');
Route::post('register', 'AuthControllerJWT@register');

Route::get('resFixErrorLaravelBug', 'AuthControllerJWT@fixBug')->name('login');

Route::group(['middleware' => ['auth:api']], function () {

    Route::post('me', 'AuthControllerJWT@me');
    Route::post('logout', 'AuthControllerJWT@logout');
    Route::post('refresh', 'AuthControllerJWT@refresh');

    // Task CRUD
    Route::get('task', 'TaskController@get')->middleware('permission:3');                   //GET
    Route::get('task/{id}', 'TaskController@find')->middleware('permission:3');             //FIND
    Route::post('task', 'TaskController@post')->middleware('permission:1');                 //POST
    Route::put('task/{id}', 'TaskController@put')->middleware('permission:4');              //PUT
    Route::delete('task/{id}', 'TaskController@delete')->middleware('permission:2');        //DELETE

    // TaskFor CRUD
    Route::post('duty', 'TaskForController@post')->middleware('permission:13'); //for admin
    Route::delete('duty/delete/{id}', 'TaskForController@delete')->middleware('permission:14'); //for admin
    Route::post('duty/finish/{id}', 'TaskForController@finish'); //for users        

    // Role CRUD
    Route::get('role', 'RoleController@get')->middleware('permission:7');
    Route::get('role/{id}', 'RoleController@find')->middleware('permission:7');
    Route::post('role', 'RoleController@post')->middleware('permission:5');
    Route::put('role/{id}', 'RoleController@put')->middleware('permission:8');
    Route::delete('role/{id}', 'RoleController@delete')->middleware('permission:6');

    // Permission CRUD
    Route::post('permission', 'PermissionController@post')->middleware('permission:9');
    Route::post('permission/toggle/{id}', 'PermissionController@toggle')->middleware('permission:12');

    // User CRUD  
    Route::get('users', 'UserController@get');
    Route::get('user/{id}', 'UserController@find');
    Route::put('user/change_role/{id}', 'UserController@changeRole');
    
});