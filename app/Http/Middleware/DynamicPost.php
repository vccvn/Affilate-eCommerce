<?php

namespace App\Http\Middleware;

use Closure;


use App\Repositories\Dynamics\DynamicRepository;
use App\Repositories\Posts\CategoryRepository;
class DynamicPost
{
    protected static $checked = false;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(static::$checked || static::check($request)) return $next($request);
        // chay qua cai nay de share data thoi
        return redirect()->route('errors', ['code' => 404]);
    }

    public static function check($request)
    {
        if(static::$checked) return true;
        if($request->dynamic && $dynamic = (new DynamicRepository)->notTrashed()->first(['slug' => $request->dynamic])){
            CategoryRepository::setDynamicID($dynamic->id);
            $dynamic->applyMeta();
            if($dynamic->post_config){
                $dynamic->post_config = is_array($dynamic->post_config)?$dynamic->post_config:json_decode($dynamic->post_config, true);
            }
            else{
                $dynamic->post_config = [];
            }
            
            set_web_data('dynamic', $dynamic);
            view()->share('dynamic', $dynamic);
            static::$checked = true;
            return true;
        }
        return false;
    }
}