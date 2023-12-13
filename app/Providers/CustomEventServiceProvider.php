<?php

namespace App\Providers;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Clients\CheckAuthController;
use App\Repositories\StyleSets\Personal\StyleSetRepository;
use Illuminate\Support\ServiceProvider;

class CustomEventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // StyleSetRepository::on("beforeGetData", function($instance, $args){
        //     dd($args);
        // });
        
    }
}
