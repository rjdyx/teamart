<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;
use Redirect;

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
        $this->middleware('guest', ['except' => ['layout','adminLayout']]);
    }


    //登录方法
    public function login(Request $request)
    {
        $this->validateLogin($request);//验证
        $newRequest = $this->credentials($request);//返回字段

        if ($this->guard()->attempt($newRequest)) {
            return $this->sendLoginResponse($request);//成功
        }
        $this->incrementLoginAttempts($request); //失败
        return $this->sendFailedLoginResponse($request);
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
        $newRequest = $this->credentials($request);//返回字段

        if ($this->guard()->attempt($newRequest)) {
            return $this->sendLoginResponse($request, true);//成功
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
