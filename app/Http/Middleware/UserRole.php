<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Redirect;
use IQuery;

class UserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $type = Auth::user()->type;
        
        //后台路由时
        if ($role == 'admin') {
            // 非pc端访问
            if (IQuery::isMobile()) {
                $url = '/ispc?'.base64_encode('err').'='.base64_encode('pc');
                return Redirect::to($url); 
            }
            // 非管理员访问
            if ($type > 0) {
                $url = '/admin/layout';
                return Redirect::to($url); 
            }
        } 

        //分销商时
        if ($role == 'sell' && $type != 1) return Redirect::to('/layout');

        //平台用户时
        if ($role == 'user' && $type < 1) return Redirect::to('/admin/layout');


        return $next($request);
    }

}
