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

Route::post('auth/login', 'API\AuthController@login');
Route::post('auth/logout', 'API\AuthController@logout');
Route::get('auth/refresh', 'API\AuthController@refresh');
Route::get('auth/user', 'API\AuthController@refresh');

Route::post('feeds/descobrir', 'API\FeedsController@descobrir');

Route::resource('feeds', 'API\FeedsController')->only([
    'store'
]);
