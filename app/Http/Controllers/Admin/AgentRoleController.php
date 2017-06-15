<?php

namespace App\Http\Controllers\Admin;

/*
* user: 郭森林
* title: 分销角色
* date: 2017/06/15
 */
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Parter;
use Redirect;

class AgentRoleController extends Controller
{
    //列表页
    public function index(Request $request)
    {
        $lists = Parter::orderBy('scale','asc');
        if ($request->name) {
            $lists = $lists->where('name','like','%'.$request->name.'%');
        }
        $lists = $lists->paginate(10);
        return view(config('app.theme').'.admin.user.agentRole')->with(['lists'=>$lists]);
    }

    //创建
    public function create()
    {
        return view(config('app.theme').'.admin.user.agentRole_create');
    }

    //修改
    public function edit($id)
    {
        $data = Parter::find($id);
        return view(config('app.theme').'.admin.user.agentRole_edit')->with('data',$data);
    }

    //查看
    public function show($id)
    {
        return Parter::find($id);
    }

    //单条删除
    public function destroy($id)
    {
        if (Parter::destroy($id)) {
            return Redirect::back()->with('status','删除成功');
        }
        return Redirect::back()->withErrors('删除失败');
    }

    //批量删除
    public function dels(Request $request)
    {
        $ids = explode(',', $request->ids);
        if (Parter::destroy($ids)) {
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
                Rule::unique('parter')->ignore($id)->where(function($query) use ($id) {
                    $query->whereNull('deleted_at');
                })
            ], 
            'scale'=> 'required|numeric',
            'desc' => 'nullable|max:50'
        ]);

        if ($id == -1) {
            $model = new Parter;
        } else {
            $model = Parter::find($id);
        }

        //接收数据 加入model
        $model->setRawAttributes($request->only(['name','scale','desc']));

        if ($model->save()) {
            return Redirect::to('admin/user/agentrole')->with('status', '保存成功');
        } else {
            return Redirect::back()->withErrors('保存失败');
        }
    }

}
