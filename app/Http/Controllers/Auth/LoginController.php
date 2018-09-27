<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Session;
use Redirect;
use App\User;
use App\System;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $name = 'name';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['layout','adminLayout','loginCheck','bindAgent']]);
    }

    //会员扫码绑定分销商
    public function bindAgent($id)
    {
//        $id = base64_decode($id);// id解码 (原)
        /* 2018 09 25 update  start */
        $id = base64_decode($id);//id解码 值是一个字符串  2018-09-25 修改
        //匹配是否为纯数字
        if (!preg_match_all('/[0-9]/',$id)){
            //不是纯数字就说明不是id号，存在危险
            return view('layouts.userBindMessage')->with(['title'=>'绑定用户错误信息','message'=>'信息出误！']);
        }
        /* 2018 09 25 update   end */
        $id = intval($id);// 类型转换
        //判断登录情况
        if (Auth::user()) {
            if (Auth::user()->type < 1) return redirect('/admin/login');
            if (is_int($id)){
                //$this->bind($id);原版本
                /* 2018 09 25 add start */
                //接收被绑定的经销商id
                $binduserid = $this->bind($id);
                //如果返回的值不为null,则说明已经绑定了经销商
                if(!is_null($binduserid)){
                    $binduser = User::find($binduserid);
                    if($binduserid === $id){
                        $message = "您已经绑定了".$binduser->name."经销商！";//提示信息
                    }else{
                        $message = "您已经绑定了".$binduser->name."经销商，只能绑定一个经销商。";//提示信息
                    }
                    return view('layouts.userBindMessage')->with(['title'=>'绑定用户错误信息','message'=>$message]);
                }

                /* 2018 09 25 add  end  */
            }
            return redirect('/');
        }
        $url = '/register?'.base64_encode('agentid').'='.base64_encode($id);
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false){
            $url = '/bind/weixin?pid='.$id;
        }
        return redirect($url);
    }

    //绑定分销商方法
    public function bind($id)
    {
        $puser = User::find($id);
        if (isset($puser->id)) {
            $user = User::find(Auth::user()->id);
            /** gping add 实现永久绑定 start */
            if(isset($user->pid) || !empty($user->pid)){
                //已经绑定的经销商用户信息
                //$binduser = User::find($user->id);
                //先跳转到指定错误提示页面，过五秒钟再跳回上一个页面
                // return view('layouts.userBindMessage')->with(['title'=>'绑定用户错误信息','bindusername'=>$binduser->name]);//如果先有绑定信息了，就直接返回无需再进行绑定
//                dd($user->pid);
                return $user->pid;//返回绑定用户信息
            }
            /** gping add 实现永久绑定  end  */
            $user->pid = $id;
            $user->save();
        }
    }

    //登录方法
    public function login(Request $request)
    {
        $newRequest = $this->credentials($request);//返回字段
        if ($this->guard()->attempt($newRequest)) {
            return $this->sendLoginResponse($request);//成功
        }
        $this->incrementLoginAttempts($request); //失败
        return $this->sendFailedLoginResponse($request);
    }

    //判断登录
    public function loginCheck(Request $request){
        $this->validateLogin($request);//验证
        $result = $this->role($request);
        if ($result < 0) return 404;
        if (!$this->role($request)) return 403;
        $newRequest = $this->credentials($request);//返回字段
        if ($this->guard()->attempt($newRequest)) return 200;
        return 404;
    }

    public function milkcaptchaLogin($captcha) 
    {
        $system = System::find(1);
        $state =1;
        if($system) $state = $system->verify_state;
        if ($state) {
            if (Session::get('milkcaptcha') != $captcha) return false;
        }
        return true;
    }

    public function role($request)
    {
        $name = $request->name;
        $user = User::where('name',$name)->orwhere('email',$name)->orWhere('phone',$name)->first();
        if ($user) return $user->type;
        return -1;
    }

    //管理登录方法
    public function adminLoginCreate()
    {
        return view(config('app.theme').'.admin.login');
    }

    //后台登录方法
    public function adminLogin(Request $request)
    {
        $this->validateLogin($request);//验证
        // if ($this->role($request)) return $this->failedLoginCome($request);

        //验证码验证
        if ($this->milkcaptchaLogin($request->captcha)) 
        {
            $newRequest = $this->credentials($request);//返回字段
            if ($this->guard()->attempt($newRequest)) {
                return $this->sendLoginResponse($request, true);//成功
            }
        }
        $this->incrementLoginAttempts($request); //失败
        return $this->sendFailedLoginResponse($request);
    }

    //获取登录字段
    public function credentials(Request $request)
    {
        $login = $request->get('name');
        $field1 = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        if($this->isMobile($login)) {
            $field='phone';
        }
        else {
            $field=$field1;
        }
        return [
            $field => $login,
            'password' => $request->get('password'),
        ];
    }

    //登录失败提示
    public function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => '用户名或密码错误！',
            ]);
    }

    //登录入口错误提示
    public function failedLoginCome(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => '登录入口错误！',
            ]);
    }
    //验证
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required'
        ]);
    } 
    
    //登录成功
    protected function sendLoginResponse(Request $request, $t = false)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        $time = date("y-m-d h:i:s",time());
        Session::put('time',$time);
        $url='/home/userinfo';
        if ($t) $url = '/admin/index';
        return redirect($url);
    }

    //获取登录字段
    public function loginUsername()
    {
        return property_exists($this, 'name') ? $this->name : 'email';
    }

    //登出
    public function layout()
    {
        return $this->guard()->logout();
    }

    //后台登出
    public function adminLayout()
    {
        $this->guard()->logout();
        return redirect('/admin/login');
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
}
