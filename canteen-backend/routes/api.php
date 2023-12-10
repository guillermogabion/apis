<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoreController;
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
Route::get('test', [UserController::class, 'test'])->name('test');


Route::group(['prefix' => '/v1'], function () {
    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::post('token-refresh', [UserController::class, 'tokenRefresher'])->name('token-refresh');
    
    Route::post('register', [UserController::class, 'createUser'])->name('register'); 
    // user 


    // add store 
    // Route::get('export', 'UserController@export');

});
Route::middleware('auth:api')->prefix('v1')->group(function () {
    // user 

    Route::get('self', [UserController::class, 'self'])->name('self');
    Route::post('update-self', [UserController::class, 'updateUser']);
    Route::post('create-store', [StoreController::class, 'createStore'])->name('create-store');
});