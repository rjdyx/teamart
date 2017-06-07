<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderProduct;

class OrderController extends Controller
{
	//订单列表页
	public function list (Request $request) {
		$lists = Order::paginate(config('app.paginate10'));
		$title = '订单管理';
		return view(config('app.theme').'.home.orderList')->with(['lists'=>$lists,'title'=>$title]);
	}

}
