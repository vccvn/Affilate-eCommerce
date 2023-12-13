<?php

use App\Http\Controllers\Admin\General\ErrorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Clients\AlertController;
use App\Http\Controllers\Clients\HomeController;
use App\Http\Controllers\Clients\LocationController;
use App\Http\Controllers\Clients\UserController;
use App\Http\Controllers\Google2FA\Google2FAController;
use Gomee\Core\System;
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

Route::controller(AuthController::class)->group(base_path('routes/auth.php'));
// Route::controller(AuthController::class)->group(base_path('routes/auth.php'));

Route::get('/errors/{code?}',[ErrorController::class,'showError'])->name('errors');

Route::controller(HomeController::class)->group(base_path('routes/client/home.php'));


Route::post('/2fa', [Google2FAController::class, 'check2fa'])->name('2fa')->middleware('2fa');

Route::get('/setup-2fa', [Google2FAController::class, 'showQr'])->middleware('auth')->name('setup-2fa');


Route::as('client.')->group(function(){

    Route::get('/thong-bao.html', [AlertController::class,'message'])->name('alert');
    Route::prefix('location')->as('location.')->controller(LocationController::class)->group(base_path('routes/client/location.php'));
    $routes = [
        'account'
    ];

    $modules = get_web_module_list(get_web_type());
    if(count($modules)){
        foreach ($modules as $module) {
            if($module == 'posts' || $module == 'products') continue;
            if($module){
                $routes[] = $module;
            }
        }
    }


    foreach ($routes as $route => $prefix) {
        $mw = null; // middleware
        $pf = null; // prefix


        if (is_numeric($route)) {
            if (file_exists($path = base_path('routes/client/' . $prefix . '.php'))) {
                Route::middleware('next')->group($path);
            }
        } else if (file_exists($path = base_path('routes/client/' . $route . '.php'))) {
            Route::prefix($prefix)->group($path);
        }
    }

    if($packageRoutes = System::getAllRoutes()){
        foreach ($packageRoutes as $slug => $scopeRoutes) {
            // chỉ lấy các route admin
            if(array_key_exists('client', $scopeRoutes) && $scopeRoutes['client']){
                $routes = $scopeRoutes['client'];
                foreach ($routes as $key => $routeParam) {
                    if($routeParam['prefix']){
                        $router = Route::prefix($routeParam['prefix']);
                        if($routeParam['name']){
                            $router->name($routeParam['name']);
                        }
                        if($routeParam['middleware']){
                            $router->middleware($routeParam['middleware']);
                        }
                    }elseif($routeParam['name']){
                        $router = Route::name($routeParam['name']);
                        if($routeParam['middleware']){
                            $router->middleware($routeParam['middleware']);
                        }
                    }elseif($routeParam['middleware']){
                        $router = Route::middleware($routeParam['name']);
                    }
                    else{
                        $router = Route::middleware('next');
                    }
                    $router->group($routeParam['group']);
                }
            }
        }
    }


});




Route::name('client.')->group(base_path('routes/client/clients.php'));
Route::name('sitemap')->group(base_path('routes/client/sitemap.php'));

// Route::namespace($namespace)->group(base_path('routes/client/assets.php'));


if(get_web_type() == 'ecommerce'){
    Route::name('client.')->group(base_path('routes/client/products.php'));
}

Route::name('client.')->group(base_path('routes/client/posts.php'));
// 'message' => Response::$statusTexts[$statusCode]