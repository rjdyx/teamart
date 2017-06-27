<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderProduct;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


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
				//待定 后面补上...
			}
		}
		$title = '个人中心';
		$footer = 'user';
		return view(config('app.theme').'.home.userCenter')->with(['sells'=>$sells,'prices'=>$prices,'title'=>$title,'footer'=>$footer]);
	}

	//个人资产
	public function userAsset () {
		$data = User::find(Auth::user()->id);
		$title = '个人资产';
		return view(config('app.theme').'.home.userAssets')->with(['data'=>$data,'title'=>$title]);
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

        $model = User::find($id);

        //接收数据 加入model
        $model->setRawAttributes($request->only(['realname','email','phone','gender','birth_date']));

        $password = $request->password;
        if ($password) $model->password = bcrypt($password);

        if ($model->save()) return 'true';
        return 'false';
	}
}
