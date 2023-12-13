<?php

namespace App\Exceptions;

use App\Http\Controllers\Admin\General\ErrorController;
use App\Http\Controllers\Clients\ErrorController as ClientsErrorController;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        
        if ($this->isHttpException($exception)) {
            
            if (!$request->expectsJson()) {

                $code = $exception->getStatusCode();
                // dd($request->is('admin/*'));
                if($request->is('admin/*') && in_array($code, [403, 404])){
                    /**
                     * @var ErrorController
                     */
                    $errorController = app(ErrorController::class);
                    
                    return response($errorController->showError($request, $code), $code);
                }

                if ($code == 404) {
                    
                    if($path = hasEmptyPathInUri()) return redirect($path);
                    /**
                     * @var ClientsErrorController
                     */
                    $errorController = app(ClientsErrorController::class);
                    if($errorController->checkModuleExists($code)) return response($errorController->reportError($request, $code), $code);
                }

                if($code == 419){
                    return \Illuminate\Support\Facades\Redirect::back()->withErrors(['_token.mismatch' => 'Token Mismatch'])->withInput()->with('error', 'Token mismatch');
                }
                
            }
        }
        return parent::render($request, $exception);
    }
}
