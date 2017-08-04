<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use IQuery;
use Redirect;
use Session;

class WxController extends Controller
{
	use AuthenticatesUsers;

    //微信绑定页面加载
    public function bindWeiXin(Request $request)
    {
        if (Auth::user()) return redirect::back();
        $wx = IQuery::getWeixin(); // 获取微信用户信息
        $request->session()->put('wx', $wx);
        $parter_id = isset($request->pid)?$request->pid:'';
        $parter_id = base64_decode($parter_id);
        return view(config('app.theme').'.home.bind_wx')->with(['parter_id'=>$parter_id]);
    }

    //微信解除绑定
    public function bindWeiXinRelieve()
    {
    	if (!Auth::user()) return redirect::back(); 
    	$user = User::find(Auth::user()->id);
    	$user->openid = null;
    	if ($user->save()) {
    		$this->guard()->logout();
    		return 1;
    	}
        return 0;
    }

    //账号验证
    public function bindWeiXinCheck(Request $request)
    {
        $user = $request->user;
        $res = User::where('name',$user)->orWhere('email',$user)->orWhere('phone',$user)->first();
        if (isset($res->id)) {
            if (empty($res->openid)) return $res->id;
            return -1;
        }
        return 0;
    }

    //密码验证 及绑定微信账户
    public function bindWeiXinPassCheck(Request $request)
    {
        if (Auth::user()) return 0;
        $data = $this->credentials($request);
        $isUser = $this->bindWeiXinCheck($request);
        //未注册 绑定
        if ($isUser == 0) {
        	return $this->bindWeiXinUserRegister($request, $data);
        }
        //已注册 绑定
        if ($isUser > 0) {
        	return $this->login($request, $data, $isUser);
        }
		return -1;//被占用
    }

    //微信号注册
    public function bindWeiXinUserRegister($request, $list)
    {
        foreach ($list as $k => $v) {
        	if ($k!='password') $file = $k;
        }
		$wx = session('wx'); // 获取微信用户信息
		$data['openid'] = $wx['openid'];
		$data['realname'] = $wx['nickname'];
		$data['img'] = $wx['headimgurl'];
		$data['thumb'] = $wx['headimgurl'];
		$data['gender'] = $wx['sex']>1? 0: 1;

		if ($file == 'name') {
			$data['name'] = $list['name'];
			$data['email'] = $list['name'].'@qq.com';
		} 
		if ($file == 'phone') {
			$data['name'] = $this->randOnly();
			$data['email'] = $data['name'].'@qq.com';
			$data['phone'] = $list['phone'];
		}
		if ($file == 'email') {
			$data['name'] = $this->randOnly();
			$data['name'] = $list['name'];
		}
        $data['password'] = bcrypt($list['password']);
        $data['parter_id'] = $request->parter_id;
        $result = User::create($data);
        //注册成功 自动登录
        if ($result){
        	auth()->login($result);//自动登录;
        	return 1;
        }
        return 0;
    }	

    // 唯一随机字符串
    public function randOnly()
    {
    	$rand = $this->Noncestr();//随机字符串
    	$email = $rand.'@qq.com';
		$user = User::where('email',$email)->first();
		while (isset($user->id)) {
			$rand = $this->Noncestr();//随机字符串
    		$email = $rand.'@qq.com';
			$user = User::where('email',$email)->first();
		}
		return $rand;
    }

    //	登录 绑定
    public function login($request, $data, $id)
    {
		if ($this->guard()->attempt($data)) {
			$user = User::find($id);
			$user->parter_id = $request->parter_id;
			$wx = session('wx'); // 获取微信用户信息
			$user->openid = $wx['openid'];
			if ($user->save()) {
		  	    auth()->login($user);
		        return 1;
			}
		}
		return -2;
    }

    //获取登录字段
    public function credentials(Request $request)
    {
        $login = $request->user;
        $field1 = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        if($this->isMobile($login)) {
            $field='phone';
        } else {
            $field=$field1;
        }
        return [
            $field => $login,
            'password' => $request->pass,
        ];
    }


    //验证手机
    public function isMobile($mobile) 
    {
        if(preg_match("/^1[34578]\d{9}$/", $mobile)){
            return true;
        }
        else {
            return false;
        }
    }


    //产生随机字符串，不长于10位
    public function Noncestr( $length = 10 ) 
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {  
            $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
        }  
        return $str;
    }

}