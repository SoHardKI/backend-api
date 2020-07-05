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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Work with users
Route::post('register', 'UserController@registration');
Route::get('auth', 'UserController@authorization')->middleware('check-user');

//Work with products
Route::group(['middleware' => ['check-bearer']], function () {
    Route::get('products', 'ProductController@index');
});
