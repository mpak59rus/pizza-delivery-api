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

Route::resource('/categories', 'CategoryController')->only([
    'index', 'show'
]);

Route::resource('/params', 'ParamController')->only([
    'index'
]);

Route::resource('/products', 'ProductController')->only([
    'index'
]);

Route::resource('/orders', 'OrderController')->only([
    'create'
]);

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->group(function () {
    Route::resource('/orders', 'OrderController')->only([
        'index'
    ]);
    Route::get('/logout', 'AuthController@logout')->name('logout');
});
