<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DIServiceProvider extends ServiceProvider
{

    public function register()
    {
        //Controller
        $this->app->when('App\Http\Controllers\UserController')
            ->needs('App\Abstracts\AEloquentService')
            ->give('App\Services\AuthServiceAdmin');
        $this->app->when('App\Http\Controllers\Auth\AdminAuthController')
            ->needs('App\Interfaces_Service\IAuthService')
            ->give('App\Services\AuthServiceAdmin');
        $this->app->when('App\Http\Controllers\ItemController')
            ->needs('App\Abstracts\AEloquentService')
            ->give('App\Services\ItemService');

        //Service
        $this->app->when('App\Services\AuthServiceAdmin')
            ->needs('App\Abstracts\AEloquentRepository')
            ->give('App\Repositories\UserRepository');
        $this->app->when('App\Services\ItemService')
            ->needs('App\Abstracts\AEloquentRepository')
            ->give('App\Repositories\ItemRepository');
        $this->app->when('App\Services\ItemService')
            ->needs('App\Interfaces_Repository\IBidRepository')
            ->give('App\Repositories\BidRepository');
    }
}
