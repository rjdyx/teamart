<?php
/*
 * @version: 0.1 站点控制器
 * @author: gsl
 * @date: 2017/06/13
 * @description:数据增删查改
 *
 */
namespace App\Http\Controllers\Admin;

use App\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use IQuery;

class SiteController extends Controller
{
    //首页 (列表页)
    public function index(Request $request)
    {
        $lists = Site::whereRaw('1=1');
        $detail = $request->detail;
        if($request->detail!=''||$request->detail!=null){
            $lists = $lists->where('detail','like','%'.$detail.'%');
        }
        $lists = $lists->paginate(config('app.paginate10'));
        return view(config('app.theme').'.admin.system.site')->with('lists',$lists);
    }

    //查看单条信息
    public function show($id)
    {
        return Site::find($id);
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
        $site = Site::find($id);
        return view(config('app.theme').'.admin.system.site_edit')->with("site",$site);
    }

    //编辑保存
    public function update(Request $request, $id)
    {
        return $this->StoreOrUpdate($request, $id);
    }

    //单条删除
    public function destroy($id)
    {
        $site = Site::find($id);
        if($site->delete()){
            return Redirect::back()->with('status','删除成功');
        }else{
            return Redirect::back()->withErrors('删除失败');
        }
    }

    //批量删除
    public function dels(Request $request)
    {
        $ids = explode(',', $request->ids);
        if (Site::destroy($ids)) {
            return Redirect::to('admin/system/site')->with('status','批量删除成功');
        }else{
            return Redirect::back()->withErrors('批量删除失败');
        }
    }

    //保存方法
    public function StoreOrUpdate(Request $request, $id = -1)
    {
        $this->validate($request, [
            'province' => 'string|string',
            'city' => 'string',
            'area' => 'string',
            'detail' => 'string',
            'user' => 'string',
            'phone' => 'numeric',
        ]);
        if($id == -1) {
            $site = new Site;
        }else{
            $site = Site::find($id);
        }
        $site->setRawAttributes($request->only(['province','city','area','detail','user','phone']));
        if ($site->save()) {
            return Redirect::to('admin/system/site')->with('status', '保存成功');
        }else{
            return Redirect::back()->withErrors('保存失败');
        }
    }
}
