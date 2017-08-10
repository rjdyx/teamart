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

    //分享
    public function sns(Request $request)
    {   
        // 获取access_token
        // if (empty(session('access_token')) || (time() - session('token_time') >= 7200)) {
            // IQuery::getWeixin($request);
            // $res = IQuery::getWXdata("snsapi_base");       
            return $res = IQuery::getWXdata("snsapi_userinfo");       
            //缓存token
            $request->session()->put('access_token', $res['access_token']);
            $request->session()->put('token_time', time());
        // }

        // 获取jsapi_ticket
        if (empty(session('jsapi_ticket')) || (time() - session('ticket_time') >= 7200)) {
            return $res = $this->getTicket($request);
            if ($res == 'false') return '获取jsapi_ticket失败';
            $request->session()->put('jsapi_ticket', $res['ticket']);
            $request->session()->put('ticket_time', time());
        }

        return $data = $this->wxJsapiSign();
        return view('fx/home/sns')->with(['data'=>$data]);
    }

    // 获取jsapi_ticket (有效期7200秒) 
    public function getTicket($request)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket";
        // $url .= "?access_token=".session('access_token')."&type=jsapi";
        // $res = IQuery::getJson($url);
        $data['access_token'] = session('access_token');
        $data['type'] = 'jsapi';
        return $res = IQuery::sendPost($url, $data);
        if ($res['errmsg'] != 'ok') return 'false'; //返回失败
        return $res;
    }

    //签名
    public function wxJsapiSign()
    {
        $data['noncestr'] = IQuery::Noncestr(); //随机字符串   
        $data['jsapi_ticket'] = session('jsapi_ticket'); //有效的jsapi_ticket
        $data['timestamp'] = time(); //当前时间戳
        $data['url'] = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"].$_SERVER["QUERY_STRING"]; //当前url
        ksort($data);
        $str = IQuery::ToUrlParams($data);
        $data['sign'] = sha1($str);
        return $data;
    }

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
			$user->parter_id = $request->parter_id;
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