<?php

namespace App\Http\Middleware;

use Closure;
use IQuery;
use App\User;

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
                $res = $this->getWeixin(); // 获取微信用户信息
                $user = $this->userState($res['openid']); //判断该微信用户是否绑定账号
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

    //获取微信用户信息
    public function getWeixin() 
    { 
        $res = IQuery::GetwxInfo();
        $token = $res['access_token'];
        $openid = $res['openid'];
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$token.'&openid='.$openid.'&lang=zh_CN';
        return $this->getJson($url);
    }

    //获取信息 发送请求
    public function getJson($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }

    //判断是否绑定账号
    public function userState($openid) 
    {
        return User::where('openid',$openid)->first();
    }


}
