<?php
/*
 * @version: 0.1 商店设置控制器
 * @author: gsl
 * @date: 2017/06/13
 * @description:数据增删查改
 *
 */
namespace App\Http\Controllers\Admin;

use App\System;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use IQuery;

class ShopController extends Controller
{
    //首页 (列表页)
    public function index(Request $request)
    {
        $shop = System::first();
        if($shop==null){
            $shop = new System;
            $shop->save();
        }
        return view(config('app.theme').'.admin.system.shop')->with('shop',$shop);
    }

    //查看单条信息
    public function show($id)
    {
        return System::find($id);
    }

    //数据创建
    public function create()
    {
        return view(config('app.theme').'.admin.');
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
  
        ]);

        if($id === -1){
            $shop = new System;
        }else{
            $shop = System::find($id);
        }

        $shop->name = $request->name;//网站名称
        $shop->email = $request->email;//联系邮箱
        $shop->phone = $request->phone;//联系电话
        $shop->verify_state = $request->verify_state;//验证码状态
        $shop->free = $request->free;//免邮金额
        $shop->record = $request->record;//备案号
        $shop->keywords = $request->keywords;//关键字

        //logo
        $img = IQuery::upload($request,'img',false);
        if ($img !== 'false') {
            IQuery::destroyPic(new System,$id);
            $shop->logo = $img['pic'];
        }

        //轮播图待扩展

        if($shop->save()){
            return Redirect::to('admin/index')->with('status', '保存成功');
        }else{
            return Redirect::back()->withErrors('保存失败');
        }

    }
}
