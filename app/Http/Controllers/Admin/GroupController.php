<?php

namespace App\Http\Controllers\Admin;

/*
* editor:严能发
* user: 郭森林
* title: 团购活动
* date: 2017/06/16
 */
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Group;
use App\ActivityProduct;
use Redirect;
use IQuery;
use DB;

class GroupController extends Controller
{
    //列表页
    public function index(Request $request)
    {
        $lists = Group::whereRaw('1=1');
        if ($request->name) {
            $lists = $lists->where('name','like','%'.$request->name.'%');
        }
        $lists = $lists->paginate(3);
        return view(config('app.theme').'.admin.activity.group.group')->with(['lists'=>$lists]);
    }

    // //数据查询(团购活动查询)
    // public function indexData () {
    //     // $lists = ActivityProduct::join('activity','activity_product.activity_id','=','activity.id')
    //     //         ->join('product','activity_product.product_id','=','product.id');
    //     //         // ->whereNull('product.deleted_at')
    //     //         // ->whereNull('activity.deleted_at');
    //     // // $lists = Group::orderBy('id','asc');
    //     // $lists = Group::orderBy('id','asc');
    //     // return $lists;
    // }

    //创建
    public function create()
    {
        return view(config('app.theme').'.admin.activity.group.group_create');
    }

    //修改
    public function edit($id)
    {
        $data = Group::find($id);
        return view(config('app.theme').'.admin.activity.group.group_edit')
        ->with(['data'=>$data]);
    }

    //查看
    public function show($id)
    {
        return Group::find($id);
    }

    //单条删除
    public function destroy($id)
    {
        if ($this->del($id)) {
            return Redirect::back()->with('status','删除成功');
        }
        return Redirect::back()->withErrors('删除失败');
    }

    public function del($id) 
    {
        // if (Group::destroy($id)){
        //     ActivityProduct
        //     return true;
        // }
        $activity = Group::find($id);
        $activity_id = $activity->id;
        if(DB::delete('delete from fx_activity_product where activity_id = '.$activity_id)){
            if(Group::destroy($id)){
                return true;
            }
        }
        return false;
    }

    //批量删除
    public function dels(Request $request)
    {
        $ids = explode(',', $request->ids);
        if (Group::destroy($ids)) {
            return Redirect::back()->with('status','批量删除成功');
        }
        return Redirect::back()->withErrors('批量删除失败');
    }

    //新建保存
    public function store(Request $request)
    {
        return $this->StoreOrUpdate($request);
    }

    //编辑保存
    public function update(Request $request, $id)
    {   
        return $this->StoreOrUpdate($request, $id);
    }

    //保存方法
    public function StoreOrUpdate(Request $request, $id = -1)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'max:50', 
                //name+软删除 唯一验证               
                Rule::unique('activity')->ignore($id)->where(function($query) use ($id) {
                    $query->whereNull('deleted_at');
                })
            ], 
            'date_start' => [
            'required', ],   
            'date_end' => [
            'required', ],   
            'desc'=>'nullable|max:255'
        ]);

        if ($id == -1) {
            $model = new Group;
        } else {
            $model = Group::find($id);
        }

        //接收数据 加入model
        $model->setRawAttributes($request->only(['name','date_start','date_end','desc','price']));

        if ($model->save()) {
            return Redirect::to('admin/activity/group')->with('status', '保存成功');
        }
        return Redirect::back()->withErrors('保存失败');
    }

}
