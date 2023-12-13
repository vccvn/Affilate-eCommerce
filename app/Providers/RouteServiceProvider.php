<?php

namespace App\Providers;

use App\Engines\ModuleManager;
use App\Services\Permissions\PermissionService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        
        if ($this->app->runningInConsole()) {
            return;
        }
        if(isset($_GET) && isset($_GET['active_matrix_route'])){
            ModuleManager::active();
        }
        app(PermissionService::class)->setupModuleRoleMatrix();
        $this->routes(function () {
            Route::prefix('api')
                ->middleware(['api', 'checkinstalled'])
                ->group(base_path('routes/api.php'));
            Route::prefix('webapi')
                ->middleware(['api', 'checkinstalled'])
                ->group(base_path('routes/client/api.php'));
            Route::prefix('setup')
                ->middleware(['web', 'checknotinstall'])
                ->group(base_path('routes/setup.php'));
            Route::prefix('admin')
                ->middleware(['web', 'checkinstalled', 'auth', 'https.redirect', 'permission', 'admin.share'])
                ->group(base_path('routes/admin.php'));


            Route::middleware(['web', 'checkinstalled', 'https.redirect'])
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
