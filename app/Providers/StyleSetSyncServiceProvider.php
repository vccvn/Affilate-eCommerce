<?php

namespace App\Providers;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Clients\AuthController as ClientsAuthController;
use App\Models\User;
use App\Repositories\StyleSets\Personal\StyleSetRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;

class StyleSetSyncServiceProvider extends ServiceProvider
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
        AuthController::on('login:success', function($request, $response, $user){
            $this->sync($request, $response, $user);
        });
        ClientsAuthController::on('login:success', function($request, $response, $user){
            $this->sync($request, $response, $user);
        });
    }

    /**
     * đồng bộ style cá nhân
     *
     * @param Request $request
     * @param Response $response
     * @param User $user
     * @return void
     */
    public function sync(Request $request, $response, $user)
    {
        if($user && $local_style_list = $request->cookie('style_set_list')){
            $ids = explode('|', trim($local_style_list));
            if(count($ids) && app(StyleSetRepository::class)->grandUser($user->id, $ids)){
                $response->withCookie(cookie('style_set_list', '', -1));
            }
        }
    }
}
