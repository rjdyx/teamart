<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\User;
//use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view(config('app.theme').'.admin.user.list')->with('user',Auth::User());
    }


    public function modifypassword()
    {
        //
        return view(config('app.theme').'.admin.user.modifypassword')->with('user',Auth::User());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        if($this->modifyuserinfo($request, $id)){
            return redirect('admin');
        }else{
          // return redirect()->back()->withInput()->withErrors('信息修改失败！');
            return back()->withInput()->withErrors("用户信息修改失败！");
        }
    }

    public function updatepassword(Request $request, $id){
        $this->validate($request, [
            'newpassword' => 'required|min:6',   //新设置密码必须大于6位
            ]);
        if($request->input('newpassword') != $request->input('newpassword1')){ //新设密码重复确认是否有误检测
            return back()->withInput()->withErrors("新密码确认有误！");
        }    
        $password = $request->password;
        if(Auth::attempt(['id' => $id, 'password' => $password])){ //验证用户身份
           $user = User::find($id);
           $user->password = bcrypt($request->input('newpassword'));
           if($user->save()){
                return redirect('admin');
           }else{
                return back()->withInput()->withErrors("密码修改失败！");
           }
        }else{                                   //用户身份验证失败
            return back()->withInput()->withErrors("用户原密码有误！");
        }
        //echo Hash::make($request->password);
        //echo $request->input('file');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    private function modifyuserinfo(Request $request, $id){
        $file = $request->file('avatar');
        $user = User::find($id);
        $flag = 0;
        if($file){
            $extension = $file->getClientOriginalExtension();//获取图片扩展名
            $distinationpath = 'upload/avatar/';
            $avatar = str_random(10).".".$extension;
            $file->move($distinationpath, $avatar);
            if($user->avatar != null){
                $oldfile = '/public/upload/avatar/'.$user->avatar; //原头像文件路径，用于成功更新后删除旧头像
                $flag = 1;
            }          
        }else{
            $avatar = $user->avatar;
        }
        $user->name = $request->name;
        $user->avatar = $avatar;
        if($user->save()){
            if($flag == 1){
                $re = Storage::delete($oldfile);
            }
            return true;
        }else{
            return false;
        }
    }
}
