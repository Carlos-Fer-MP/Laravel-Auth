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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * 
 *  Esto hay que revisarlo.
 * 
 */
Route::prefix('auth')->group(function () {
    
    Route::post('login', 'AuthController@login', function ($id) {
        
    });
    Route::post('signup', 'AuthController@signUp', function ($id) {
        
    });

    Route::middleware(['auth:api'])->group(function () {
       
        Route::get('logout','AuthController@logout', function ($id) {
            
        });
        Route::get('user','AuthController@user', function ($id) {
            
        });
    });
});