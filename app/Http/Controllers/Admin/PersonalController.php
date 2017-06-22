<?php
/*
 * @version: 0.1 个人中心控制器
 * @author: gsl
 * @date: 2017/06/13
 * @description:数据增删查改
 *
 */
namespace App\Http\Controllers\Admin;

use App\System;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use IQuery;
use Auth;

class PersonalController extends Controller
{
    //首页 (列表页)
    public function index(Request $request)
    {
        $user = Auth::User();
        return view(config('app.theme').'.admin.system.personal')->with('user',$user);
    }

    //查看单条信息
    public function show($id)
    {
        return System::find($id);
    }

    //数据创建
    public function create()
    {
        return view(config('app.theme').'.admin.system.send_create');
    }

    //保存新建数据
    public function store(Request $request)
    {
        return $this->StoreOrUpdate($request);
    }

    //编辑数据
    public function edit($id)
    {

    }

    //编辑保存
    public function update(Request $request, $id)
    {
        return $this->StoreOrUpdate($request, $id);
    }

    //单条删除
    public function destroy($id)
    {
        return Redirect::back()->withErrors('删除失败');
    }

    //保存方法
    public function StoreOrUpdate(Request $request, $id = -1)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'numeric',
            'gender' => 'in:0,1',
            'password' => 'nullable|string|min:6|max:30',
            'password2' => 'same:password',
        ]);
        $user = User::find($id);
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $gender = $request->gender;
        $password = $request->password;

        $user->name = $name;
        $user->email = $email;
        $user->phone = $phone;
        $user->gender = $gender;
        if($password != null && $password != '') $user->password = bcrypt($password);

        $imgs = IQuery::upload($request,'img',true);
        if ($imgs !== 'false') {
            IQuery::destroyPic(new User,$id,'img');
            $user->img = $imgs['pic'];
            $user->thumb = $imgs['thumb'];
        }
        if($user->save()){
            return Redirect::to('admin/index')->with('status', '保存成功');
        }else{
            return Redirect::back()->withErrors('保存失败');
        }
    }
}
