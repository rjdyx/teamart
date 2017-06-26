<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderProduct;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
	//订单列表页
	public function index (Request $request) {
		$lists = Order::where('type','order')
		->where('user_id',Auth::user()->id)
		->paginate(config('app.paginate10'));
		$title = '订单管理';
		return view(config('app.theme').'.home.orderList')->with(['footer'=>'order','lists'=>$lists,'title'=>$title]);
	}

	//收藏列表页
	public function collect (Request $request) {
		$lists = Order::where('type','collect')
		->where('user_id',Auth::user()->id)
		->paginate(config('app.paginate10'));
		$title = '收藏管理';
		return view(config('app.theme').'.home.collect')->with(['footer'=>'collect','lists'=>$lists,'title'=>$title]);
	}
}
