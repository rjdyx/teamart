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

    //微信绑定页面加载
    public function bindWeiXin()
    {
        if (Auth::user()) return redirect::back();
        return view(config('app.theme').'.home.bind_wx');
    }

    //微信号注册
    public function autoRegister($user)
    {
        $data['name'] = $this->Noncestr();
        $data['password'] = $this->Noncestr();
        $data['email'] = $this->Noncestr();
        $data['phone'] = $this->Noncestr();
        $this->createUser($data);
    }

    protected function createUser(array $data)
    {
        return User::create([
            'email'       => $data['email'],
            'name'    => $data['name'],
            'password'    => bcrypt($data['password']),
            'phone'        => $data['phone'],
            'gender'        => $data['gender'],
            'parter_id'        => $data['agent_id']
        ]);
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

    //会员扫码绑定分销商
    public function bindAgent($id)
    {
        $id = base64_decode($id);// id解码
        //判断登录情况
        if (Auth::user()) {
            if (Auth::user()->type != 2) return redirect('/admin/login');
            $bind = $this->bind($id);
            return redirect('/');
        } else {
            return redirect('/register?'.base64_encode('agentid').'='.base64_encode($id));
        }
    }

    //绑定分销商方法
    public function bind($id)
    {
        $user = User::find(Auth::user()->id);
        $user->parter_id = $id;
        return $user->save();
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
        $user = User::where('name',$request->name)->first();
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
        if ($this->role($request)) return $this->failedLoginCome($request);

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
        $this->guard()->logout();
        return redirect('/login');
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
