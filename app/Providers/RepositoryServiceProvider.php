<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this -> app -> bind('App\Repositories\User\UserDataAccessRepositoryInterface','App\Repositories\User\UserDataAccessQBRepository');
        var_dump("test");
        // \App\Repositories\User\UserDataAccessRepositoryInterface::class,
        // \App\Repositories\User\UserDataAccessQBRepository::class
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
