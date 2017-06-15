<?php

namespace App\Http\Controllers\Admin;

/*
* user: 郭森林
* title: 代理商
* date: 2017/06/15
 */
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\User;
use Redirect;

class AgentController extends Controller
{
    //列表页
    public function index(Request $request)
    {
        $lists = $this->indexData();

        if ($request->name) {
            $lists = $lists->where('name','like','%'.$request->name.'%')
                    ->Orwhere('realname','like','%'.$request->name.'%');
        }
        $lists = $lists->select('user.*','parter.name as parter_name')
                ->orderBy('user.id','asc')
                ->paginate(10);

        //查询所有关联的分销角色
        $selects = $this->indexData()->distinct('parter.id')->select('parter.name','parter.id')->get();

        return view(config('app.theme').'.admin.user.agent')->with(['lists'=>$lists,'selects'=>$selects]);
    }

    //数据查询
    public function indexData () {
        $lists = User::join('parter','user.parter_id','=','parter.id')
                ->where('user.type',1)
                ->whereNull('user.deleted_at')
                ->whereNull('parter.deleted_at');
        return $lists;
    }

    //创建
    public function create()
    {
        return view(config('app.theme').'.admin.user.agent_create');
    }

    //修改
    public function edit($id)
    {
        $data = Parter::find($id);
        return view(config('app.theme').'.admin.user.agent_edit')->with('date',$data);
    }

    //查看
    public function show($id)
    {
        return Parter::find($id);
    }

    //单条删除
    public function destroy($id)
    {
        $data = Parter::find($id);
        if ($data->destroy()) {
            return Redirect::back()->with('status','删除成功');
        }
        return Redirect::back()->withErrors('删除失败');
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
            'scale'=>'required|numeric',
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
            return Redirect::to('admin/agent')->with('status', '保存成功');
        } else {
            return Redirect::back()->withErrors('保存失败');
        }
    }

}
