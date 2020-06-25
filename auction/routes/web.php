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
        'products' => 'ItemsController',
    ]);
});
Route::middleware('guest:web')->group(function () {
    Route::get('/login', 'Auth\AdminAuthController@getLogin')->name('getLogin');
    Route::post('/login', 'Auth\AdminAuthController@login')->name('login');
});