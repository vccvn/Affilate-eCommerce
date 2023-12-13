<?php
/**
 * middleware phân quyền
 * @author Doan Le
 * @copyright 2019
 * 
 * tác dụng Phân quyền cho các route
 */

namespace App\Http\Middleware;

use Closure;

use Gomee\Laravel\Router;
use App\Repositories\Permissions\ModuleRepository;
use App\Services\Permissions\PermissionService;
use ReflectionClass;

class Permission
{
    protected static $checkedModules = [];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // lấy thông tin route hiện tại
        $routeinfo = Router::getRouteInfo($request->route());
        $moduleRep = app(ModuleRepository::class);
        
        if(!($user = $request->user())) return $this->redirect($request);
        if(!$user->google2fa_secret) return redirect()->route('setup-2fa');
        if(in_array($user->type, ['admin', 'manager'])) return $next($request);
        
        $userRoles = $user->getUserRoles();
        if(array_key_exists('name',$routeinfo) && $routeinfo['name']){
            if(PermissionService::checkModulePermiss($routeinfo['name'], $userRoles)) return $next($request);
        }
        return $this->redirect($request);
    }

    // chuyển hướng trang
    /**
     * Undocumented function
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function redirect($request)
    {
        if (0 === strpos($request->headers->get('Accept'), 'application/json'))
        {
            return response()->json(['status' => false, 'message'=>'Bạn không thể thực hiện hành động này!'], 403);
        }
        abort(403, "Truy cập bị từ chối");
    }
}
