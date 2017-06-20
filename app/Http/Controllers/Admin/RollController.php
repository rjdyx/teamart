<?php
/*
 * @version: 0.1 优惠券控制器
 * @author: gsl
 * @date: 2017/06/13
 * @description:数据增删查改
 *
 */
namespace App\Http\Controllers\Admin;

use App\Cheap;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use IQuery;

class RollController extends Controller
{
    //首页 (列表页)
    public function index(Request $request)
    {
        $lists = Cheap::whereRaw('1=1');
        $state = $request->state;
        if($request->state!=''||$request->state!=null){
            $lists = $lists->where('state','=',$state);
        }
        $name = $request->name;
        if($name!=''||$name!=null){
            $lists = $lists->where('name','like','%'.$name.'%');
        }
        $lists = $lists ->paginate(config('app.paginate10'));
        return view(config('app.theme').'.admin.activity.roll.index')->with('lists',$lists);
    }

    //查看单条信息
    public function show($id)
    {
        
    }

    //数据创建
    public function create()
    {
        return view(config('app.theme').'.admin.activity.roll.create');
    }

    //保存新建数据
    public function store(Request $request)
    {
        return $this->StoreOrUpdate($request);
    }

    //编辑数据
    public function edit($id)
    {
        $cheap = Cheap::find($id);
        return view(config('app.theme').'.admin.activity.roll.edit')->with('cheap',$cheap);
    }

    //编辑保存
    public function update(Request $request, $id)
    {
        return $this->StoreOrUpdate($request, $id);
    }

    //单条删除
    public function destroy($id)
    {
        $cheap = Cheap::find($id);
        if($cheap->delete()){
            return Redirect::back()->with('status','删除成功');
        }else{
            return Redirect::back()->withErrors('删除失败');
        }
    }

    //保存方法
    public function StoreOrUpdate(Request $request, $id = -1)
    {
        $this->validate($request, [
            'name' =>'required|string',
            'full' => 'numeric',
            'cut' =>'numeric',
            'amount' => 'numeric',
            'state' => 'in:0,1',
            //'indate' => ,//待补充
            'desc' => 'string|nullable',
        ]);

        if($id == -1){
            $cheap = new Cheap;
        }else{
            $cheap = Cheap::find($id);
        }

        $cheap->setRawAttributes($request->only(['name','full','cut','amount','indate','state','desc']));

        if($cheap->save()){
            return Redirect::to('admin/activity/roll')->with('status', '保存成功');
        }else{
            return Redirect::back()->withErrors('保存失败');
        }
    }

    public function dels(Request $request)
    {
        $ids = explode(',', $request->ids);
        if (Cheap::destroy($ids)) {
            return Redirect::to('admin/activity/roll')->with('status','批量删除成功');
        }else{
            return Redirect::back()->withErrors('批量删除失败');
        }
    }
}
