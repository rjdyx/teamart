<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Closure;
use IQuery;
use App\User;
use Redirect;

class IsWeixin
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
        $request->session()->forget('webType');//清除
        $request->session()->put('webType',0);//加入

        // 判断登录状态
        if (!Auth::user()) {
            //判断是否微信端
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) { 
                $wx = IQuery::getWeixin(); // 获取微信用户信息
                $request->session()->put('wx', $wx);
                $user = $this->userState($wx['openid']); //判断该微信用户是否绑定账号
                if (isset($user->id)) {
                    auth()->login($user);//自动登录
                } else {
                    return Redirect::to('/bind/winxin');
                }
                $request->session()->put('webType',1);//加入微信端标识
            }
        }
        return $next($request);
    }


    //判断是否绑定账号
    public function userState($openid) 
    {
        return User::where('openid',$openid)->first();
    }


}
