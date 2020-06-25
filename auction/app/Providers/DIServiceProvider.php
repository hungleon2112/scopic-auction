<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DIServiceProvider extends ServiceProvider
{

    public function register()
    {

        
        $this->app->when('App\Http\Controllers\FibreTraceUserGroupController')
            ->needs('App\Abstracts\AEloquentService')
            ->give('App\Services\FibreTraceUserGroupService');

    }
}
