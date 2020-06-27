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
        $this->app->when('App\Http\Controllers\ItemController')
            ->needs('App\Interfaces_Service\IBidService')
            ->give('App\Services\BidService');

        //Api Controller
        $this->app->when('App\Http\Controllers\Auth\ApiAuthController')
        ->needs('App\Interfaces_Service\IAuthService')
        ->give('App\Services\AuthServiceApi');
        $this->app->when('App\Http\Controllers\Api\ApiItemController')
        ->needs('App\Interfaces_Service\IBidService')
        ->give('App\Services\BidService');
        $this->app->when('App\Http\Controllers\Api\ApiItemController')
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
        $this->app->when('App\Services\BidService')
        ->needs('App\Abstracts\AEloquentRepository')
        ->give('App\Repositories\BidRepository');
        $this->app->when('App\Services\BidService')
        ->needs('App\Interfaces_Repository\IItemRepository')
        ->give('App\Repositories\ItemRepository');
        $this->app->when('App\Services\AuthServiceApi')
            ->needs('App\Abstracts\AEloquentRepository')
            ->give('App\Repositories\UserRepository');
    }
}
