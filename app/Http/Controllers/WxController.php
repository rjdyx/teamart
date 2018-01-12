<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\System;
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
        $pid = $request->pid;
        if (!is_int($pid) && !empty($pid)){
            $pid = explode('pid', $pid)[0];
        }
        return view(config('app.theme').'.home.bind_wx')->with(['parter_id'=>$pid]);
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

    //用户名验证
    public function nameCheck($name)
    {
        $res = User::where('name',$name)->first();
        if (isset($res->id)) return 1;
        return 0;
    }

    //邮箱验证
    public function emailCheck($email)
    {
        $res = User::where('email',$email)->first();
        if (isset($res->id)) return 1;
        return 0;
    }

    //手机号验证
    public function phoneCheck($phone)
    {
        $res = User::where('phone',$phone)->first();
        if (isset($res->id)) return 1;
        return 0;
    }

    //绑定微信账户
    public function bindWeiXinPassCheck(Request $request)
    {
        if (Auth::user()) return 0;
        $id = $this->bindWeiXinCheck($request);
        //是否有账号绑定
        if ($request->type && !empty($request->user)) {
            $data = $this->credentials($request);
            if ($id<1) return $id; //账号不存在
            return $this->login($request, $data, $id);
        } else {
            if ($this->nameCheck($request->name)) return -2;//账号已存在
            if ($this->emailCheck($request->email)) return -3;//邮箱已存在
            if ($this->phoneCheck($request->phone)) return -4;//手机已存在
            return $this->bindWeiXinUserRegister($request);
        }
    }

    //微信号注册
    public function bindWeiXinUserRegister(Request $request)
    {
		$wx = session('wx'); // 获取微信用户信息
		$data['openid'] = $wx['openid'];
		$data['realname'] = $wx['nickname'];
		$data['img'] = $wx['headimgurl'];
		$data['thumb'] = $wx['headimgurl'];
		$data['gender'] = $wx['sex']>1? 1: 0;
		$data['name'] = $request->name;
        $data['phone'] = $request->phone;
		$data['email'] = $request->email;
        $data['password'] = bcrypt($request->password);
        $data['parter_id'] = $request->parter_id;
        $result = User::create($data);
        //注册成功 自动登录
        if ($result){
        	auth()->login($result);//自动登录;
        	return 1;
        }
        return 3;
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
			$user->pid = $request->parter_id;
			$wx = session('wx'); // 获取微信用户信息
			$user->openid = $wx['openid'];
			if ($user->save()) {
		  	    auth()->login($user);
		        return 1;
			}
		}
		return 2;
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
        if(preg_match("/^1[34578]\d{9}$/", $mobile) && strlen($mobile)== 11){
            return true;
        } else {
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