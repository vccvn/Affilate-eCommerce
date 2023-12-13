<?php

use App\Http\Controllers\Apis\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

$aa   = 'auth:api';
$auth = [$aa];

$routes = [
    // prefix => middleware
    // 'admin',
    // 'users',// => $auth,
    // 'test',
    // 'tasks',
    'auth',
];

Route::prefix("/v1/auth")->group(function () {
    // TODO AUTH
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => ['auth:api'], 'prefix' => '/v1'], function () {
    // TODO
});

Route::prefix("/v1")->group(function () {
    // TODO
});


foreach ($routes as $prefix => $middleware) {
    $mw = null; // middleware
    $pf = null; // prefix
    if (!is_numeric($prefix)) {
        $pf = $prefix;
        if ($middleware) {
            $mw = $middleware;
        }
    } else {
        $pf = $middleware;
    }
    if ($pf) {
        $router = Route::prefix($pf);
        if ($mw) {
            $router->middleware($mw);
        }
        $router->group(base_path('routes/api/' . $pf . '.php'));
    }
}
