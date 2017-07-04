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
use App\Order;
use App\Parter;
use App\Brokerage;
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
        $datas = User::join('order','user.id','=','order.pid')
            ->select(DB::raw('distinct date_format(fx_order.created_at, "%Y") as year'))
            ->groupBy('year')->orderBy('year','asc')->get();
        $arrs = array();
        foreach ($datas as $data) {
            $arrs[] = $data->year;
        }
        return view(config('app.theme').'.admin.user.agent_show')->with(['years'=>$arrs,'id'=>$id]);
    }

    //统计单个代理商某年每月的销售数据
    public function sellCount(Request $request) 
    {
        $id = $request->id;
        $year = date('Y');
        if ($request->year) $year = $request->year;
        $orders = $prices = array();
        for($i=1; $i<13; $i++){
            $orders[$i-1] = Order::whereYear('created_at',$year)
            ->whereMonth('created_at',$i)
            ->where('state','close') 
            ->where('pid',$id)
            ->count();
            $prices[$i-1] = Order::whereYear('created_at',$year)
            ->whereMonth('created_at',$i)
            ->where('state','close') 
            ->where('pid',$id)
            ->sum('price');
        } 
        return ['orders'=>$orders,'prices'=>$prices];
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

    //分销商佣金记录
    public function record(Request $request, $id)
    {
        $order = 'desc';
        $lists = Brokerage::where('user_id', $id);
        if (!empty($request->date)) 
        {
            $lists = $lists->where('date','<=',$request->date); 
            $order = 'asc';
        }
        $lists = $lists->orderBy('date',$order)->paginate(10);
        return view(config('app.theme').'.admin.user.agent_record')->with(['lists'=>$lists,'id'=>$id]);
    }

    //创建结账
    public function solve($id)
    {
        $bro = Brokerage::orderBy('created_at','desc')->first();//获取最后一次结账日期
        $remain = 0;
        $parter = Parter::find($id);//分销商角色信息
        $orders = Order::where('pid',$id)->where('state','close');
        $prices = Order::where('pid',$id)->where('state','close');
        if (!empty($bro)) {
            $date = $bro->created_at;
            $remain = $bro->remain;
            $orders = $orders ->where('updated_at','>=',$date);
            $prices = $prices ->where('updated_at','>=',$date);
        } 
        $orders = $orders->count();//获取订单数量
        $counts = $prices->sum('price');//获取订单总金额
        $prices = $counts * $parter->scale;//佣金总额
        return view(config('app.theme').'.admin.user.agent_record_create')->with(['parter'=>$parter,'id'=>$id,'orders'=>$orders,'prices'=>$prices,'remain'=>$remain]);
    }

    //结账处理
    public function recordStore(Request $request)
    {
        $this->validate($request, [
            'price'=>'required'
        ]);

        $model = new Brokerage;

        //接收数据 加入model
        $model->setRawAttributes($request->only(['scale','count','amount','price']));
        $model->date = date('Y-m-d');
        $model->user_id = $request->id;
        $model->remain = ($request->count) + ($request->remain) - ($request->price);

        if ($model->save()) return Redirect::to('admin/user/agent/record/'.$request->id)->with('status', '保存成功');
        return Redirect::back()->withErrors('保存失败');
    }

    //佣金记录单条删除
    public function recordDel(Request $request)
    {
        $id = $request->id;
        if (Brokerage::destroy($id)) return Redirect::back()->with('删除成功');
        return Redirect::back()->withErrors('删除失败');
    }

    //佣金记录批量删除
    public function recordDels(Request $request)
    {
        $ids = explode(',',$request->ids);
        if (Brokerage::destroy($ids)) return Redirect::back()->with('删除成功');
        return Redirect::back()->withErrors('删除失败');
    }
}
