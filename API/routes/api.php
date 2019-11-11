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
Route::group(['middleware' => ['cors']], function () {

    Route::post('login', 'AuthControllerJWT@login');
    Route::post('register', 'AuthControllerJWT@register');

    Route::get('resFixErrorLaravelBug', function() {
        return response()->json([
            'errors' => [
                'main' => 'Unauthorized'
            ],
            'status' => false,
            'data' => []
        ], 401);
    })->name('login');

    Route::group(['middleware' => ['auth:api']], function () {

        Route::post('me', 'AuthControllerJWT@me');
        Route::post('logout', 'AuthControllerJWT@logout');
        Route::post('refresh', 'AuthControllerJWT@refresh');

        // Task CRUD
        Route::get('task', 'TaskController@get')->middleware('permission:3');                   //GET
        Route::get('task/{id}', 'TaskController@find')->middleware('permission:3');             //FIND
        Route::post('task', 'TaskController@post')->middleware('permission:1'); //POST
        Route::put('task/{id}', 'TaskController@put')->middleware('permission:4');              //PUT
        Route::delete('task/{id}', 'TaskController@delete')->middleware('permission:2');        //DELETE

        // TaskFor CRUD
        Route::post('duty', 'TaskForController@post')->middleware('permission:13'); //for admin
        Route::post('duty/toggle/{id}', 'TaskForController@toggleActive')->middleware('permission:16'); //for admin
        Route::post('duty/finish/{id}', 'TaskController@finish'); //for users        

        
        
    });
    
});