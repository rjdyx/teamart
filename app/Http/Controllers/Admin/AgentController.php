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
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Parter;
use Redirect;
use DB;
class AgentController extends Controller
{
    //列表页
    public function index(Request $request)
    {
        $lists = $this->indexData();
        if ($request->name) {
            $lists = $lists->where('user.name','like','%'.$request->name.'%')
                    ->Orwhere('user.realname','like','%'.$request->name.'%');
        }
        if ($request->role) {
            $lists = $lists->where('parter.id','=',$request->role);
        }

        $lists = $lists->select('user.*','parter.name as parter_name')
                ->distinct('user.id')
                ->orderBy('sell_count','desc')
                ->paginate(10);

        //查询所有关联的分销角色
        $selects = $this->indexData()->distinct('parter.id')->select('parter.name','parter.id')->get();

        return view(config('app.theme').'.admin.user.agent')->with(['lists'=>$lists,'selects'=>$selects]);
    }

    //数据查询
    public function indexData () {
        $lists = DB::table('user')->join('parter','user.parter_id','=','parter.id')
                ->where('user.type',1)
                ->whereNull('user.deleted_at')
                ->whereNull('parter.deleted_at');
        return $lists;
    }

    //创建
    public function create()
    {
        $selects = Parter::select('id','name','scale')->get();
        return view(config('app.theme').'.admin.user.agent_create')->with('selects',$selects);
    }

    //修改
    public function edit($id)
    {
        $data = User::find($id);
        $selects = Parter::select('id','name','scale')->get();
        return view(config('app.theme').'.admin.user.agent_edit')
        ->with(['data'=>$data,'selects'=>$selects]);
    }

    //查看
    public function show($id)
    {
        return User::find($id);
    }

    //单条删除
    public function destroy($id)
    {
        if (User::destroy($id)) {
            return Redirect::back()->with('status','删除成功');
        }
        return Redirect::back()->withErrors('删除失败');
    }

    //批量删除
    public function dels(Request $request)
    {
        $ids = explode(',', $request->ids);
        if (User::destroy($ids)) {
            return Redirect::back()->with('status','批量删除成功');
        }
        return Redirect::back()->withErrors('批量删除失败');
    }

    //新建保存
    public function store(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|max:18',
        ]);
        return $this->StoreOrUpdate($request);
    }

    //编辑保存
    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'password' => 'nullable|max:18',
        ]);
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
                Rule::unique('user')->ignore($id)->where(function($query) use ($id) {
                    $query->whereNull('deleted_at');
                })
            ], 
            'email'=>'required|email|max:50',
            'phone'=>'nullable|max:50',
            'realname'=>'nullable|max:50',
            'gender' => 'required|max:2'
        ]);

        if ($id == -1) {
            $model = new User;
        } else {
            $model = User::find($id);
        }

        //接收数据 加入model
        $model->setRawAttributes($request->only(['name','realname','email','phone','gender','birth_date','parter_id']));

        if ($id == -1 ){
            $model->type = 1;
            $model->grade = 0;
            $model->password = bcrypt($request->password);
        } else {
            if (!empty($request->password)) {
                $model->password = bcrypt($request->password);
            }
        }

        if ($model->save()) {
            return Redirect::to('admin/user/agent')->with('status', '保存成功');
        } else {
            return Redirect::back()->withErrors('保存失败');
        }
    }

}
