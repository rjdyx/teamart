<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Redirect;
use App\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    use ResetsPasswords; //使用这个实现密码重置

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login'; //密码重置后自动跳转的页面位置

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function passwordReset(Request $request)
    {
        $pas1 = $request->password;
        $pas2 = $request->repassword;
        $email = $request->email;
        if ($pas1!=$pas2) return Redirect::back()->withError('两次密码不一致');
        $user = User::where('email',$email)->first();
        if (empty($user->email)) return Redirect::back()->withError('邮箱输入有误');
        $user->password = bcrypt($pas1);
        if ($user->save()) return Redirect::back()->withError('ok');
        return Redirect::back()->withError('重置密码失败');
    }

}
