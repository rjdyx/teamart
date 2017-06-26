<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderProduct;
use App\User;
use Illuminate\Support\Facades\Auth;

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
		$show = User::find(Auth::user()->id);
		$title = '个人资产';
		return view(config('app.theme').'.home.userAssets')->with(['show'=>$show,'title'=>$title]);
	}

	//编辑 用户信息
	public function edit () {
		$show = User::find(Auth::user()->id);
		$title = '个人信息';
		return view(config('app.theme').'.home.userEdit')->with(['show'=>$show,'title'=>$title]);
	}
}
