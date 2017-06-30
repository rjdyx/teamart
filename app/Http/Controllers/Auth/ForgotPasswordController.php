<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails; //使用这个trait显示发送邮和发送邮件

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    // public function getEmail(){
    //     return view('auth.passwords.email');
    // }

    // public function postEmail(){

    // }


    // public function reset(){ 
    //     return view('auth.passwords.email');
    // }

    // public function checkemail(Request $request){
    //     $this->validate($request,[
    //         'name'=>'required',
    //         'email'=>'required'
    //     ]);
    //    $username= $request->name;
    //     $useremail=$request->email;
    //     $user = User::where('name',$username)->
    //             where('email',$useremail)->count();
    //     if($user>0){
    //         return view('auth.passwords.reset');
    //     }
    //     else {
    //         return '用户名与邮箱不匹配';
    //     }
    // }

}
