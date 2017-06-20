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

    }
}
