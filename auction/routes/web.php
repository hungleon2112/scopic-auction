<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth:web')->group(function () {
    Route::get('/', function () {
        return view('admin.DashboardPage');
    })->name('index');

    Route::resources([
        'items' => 'ItemController',
    ]);

    Route::post('/items/bid-update', 'ItemController@bidUpdate')->name('items.bid-update');
    Route::post('/items/bid', 'ItemController@bid')->name('items.bid');
    Route::post('/logout', 'Auth\AdminAuthController@logout')->name('logout');
});
Route::middleware('guest:web')->group(function () {
    Route::get('/login', 'Auth\AdminAuthController@getLogin')->name('getLogin');
    Route::post('/login', 'Auth\AdminAuthController@login')->name('login');
    // Route::get('/admin-register', 'UserController@create')->name('create');
});