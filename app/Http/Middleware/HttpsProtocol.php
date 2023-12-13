<?php

namespace App\Http\Middleware;

use App\Web\Option;
use App\Web\Options;
use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class HttpsProtocol
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $options = app(Options::class);
        if($path = hasEmptyPathInUri()) return redirect($path);

        if($urls = $options->urlsettings){
            
            if (($general = $urls->general) && $general->https_redirect && !$request->secure()) {
                return redirect()->secure($request->getRequestUri());
            }
        }

        

        return $next($request);
    }
}

