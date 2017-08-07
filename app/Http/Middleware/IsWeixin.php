<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Closure;
use IQuery;
use App\User;
use Redirect;
use Session;

class IsWeixin
{
    // 前端中间件
    public function handle($request, Closure $next)
    {
        // 访问设备判断
        $url = '/ispc?'.base64_encode('err').'=';
        if (strpos($request->url(),'admin')) {
            if (IQuery::isMobile()) {
                return Redirect::to($url.base64_encode('pc'));
            }
        } else {
            if (!IQuery::isMobile()) {
                return Redirect::to($url.base64_encode('phone'));
            }
        }

        $request->session()->forget('webType');//清除
        $request->session()->put('webType',0);//加入
        $micro = strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger');
        //判断是否微信端
        if ($micro !== false) {
            // 判断登录状态
            if (!Auth::user()) {
                $user = $this->userState($request); //判断该微信用户是否绑定账号
                if (isset($user->id)) {
                    auth()->login($user);//自动登录
                } else {
                    return Redirect::to('/bind/weixin');
                }
            }
            $request->session()->put('webType',1);//加入微信端标识
        }
        return $next($request);
    }

    //判断是否绑定账号
    public function userState($request) 
    {
        $wx = IQuery::getWeixin(); // 获取微信用户信息
        $request->session()->put('wx', $wx);
        return User::where('openid',$wx['openid'])->first();
    }

}
