<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderProduct;
use App\User;
use App\Brokerage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use IQuery;

class UserController extends Controller
{
	//个人中心 用户相关信息
	public function userInfo () {
		$prices = 0;
		$sells = 0;
		if (Auth::user()){
			//消费总额
			$prices = Order::where('user_id','=',Auth::user()->id)
				->where('order.type','=','order') 
				->where('order.state','!=','pading') 
				->select('price')->count();

			//佣金计算
			if (Auth::user()->type == 1){
				$sells = $this->brokerage();//累计金额
			}
		}
		$title = '个人中心';
		$footer = 'user';
		return view(config('app.theme').'.home.userCenter')->with(['sells'=>$sells,'prices'=>$prices,'title'=>$title,'footer'=>$footer]);
	}

	//个人资产
	public function userAsset () {
		$data = Brokerage::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->first();
		$check = 'false'; 
		$await = 0;
		if (!empty($data)) {
			$check = $data->created_at;
			$await = $data->remain;
		}
		$allprices = $this->brokerage();//累计金额
		$prices = $this->brokerage($check) + $await;//可提现余额
		$title = '个人资产';
		return view(config('app.theme').'.home.userAssets')->with(['data'=>$data,'title'=>$title,'allprices'=>$allprices,'prices'=>$prices]);
	}

	//订单金额统计方法
	public function brokerage($check ='false')
	{
		$prices = Order::where('type','order')
				->where('state','close')
				->where('pid',Auth::user()->id);
		if ($check != 'false') $prices = $prices->where('updated_at','>=',$check);
		return $prices->sum('price');		
	}	

	//资产记录
	public function brokerageList()
	{
		$data = Brokerage::where('user_id',Auth::user()->id)->paginate(10);
		return $data;
	}

	//编辑 用户信息
	public function edit () {
		$data = User::leftjoin('user as auser','user.parter_id','=','auser.id')
			->where('user.id','=',Auth::user()->id)
			->select('user.*','auser.name as pname')
			->first();
		$title = '个人信息';
		return view(config('app.theme').'.home.userEdit')->with(['data'=>$data,'title'=>$title]);
	}

	//编辑 用户信息
	public function update (Request $request, $id) {
		$this->validate($request, [
            'email' => [
                'required',
                'max:50', 
                //name+软删除 唯一验证               
                Rule::unique('user')->ignore($id)->where(function($query) use ($id) {
                    $query->whereNull('deleted_at');
                })
            ], 
            'phone' => [
                'required',
                'max:50', 
                //name+软删除 唯一验证               
                Rule::unique('user')->ignore($id)->where(function($query) use ($id) {
                    $query->whereNull('deleted_at');
                })
            ], 
            'realname'=>'nullable|max:50',
            'gender' => 'required|max:4'
        ]);

        $model = User::find(Auth::user()->id);

        //接收数据 加入model
        $model->setRawAttributes($request->only(['realname','email','phone','gender','birth_date']));
        
        if ($request->del) {
            $model->img = null;
            $model->thumb = null;
            IQuery::destroyPic(new Brand, $id, 'img');
        }

        //资源、上传图片名称、是否生成缩略图
        $imgs = IQuery::upload($request,'img',true);
        if ($imgs != 'false') {
            $model->img = $imgs['pic'];
            $model->thumb = $imgs['thumb'];
        }

        $password = $request->password;
        if ($password) $model->password = bcrypt($password);

        if ($model->save()) return 'true';
        return 'false';
	}
}
