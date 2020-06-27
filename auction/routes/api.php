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

Route::group(['middleware' => ['cors']], function() {
    Route::post('v1/register', 'Auth\ApiAuthController@register');
    Route::post('v1/login', 'Auth\ApiAuthController@login');
});

Route::group(['middleware' => ['jwt.verify', 'cors']], function() {
    Route::get('v1/items', 'Api\ApiItemController@items');
    Route::get('v1/item', 'Api\ApiItemController@item');
    Route::get('v1/items-bid', 'Api\ApiItemController@itemsBid');
    Route::get('v1/items-awarded', 'Api\ApiItemController@itemsAwarded');
    Route::post('v1/bid', 'Api\ApiItemController@bid');
});