<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderProduct;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
	//购物车列表页
	public function index (Request $request) {
		$lists = Order::join('order_product','order.id','=','order_product.order_id')
		->join('product','order_product.product_id','=','product.id')
		->where('order.type','cart')
		->where('order.user_id',Auth::user()->id)
		->select('product.*')
		->paginate(config('app.paginate10'));
		$title = '购物车';
		$footer = 'cart';
		return view(config('app.theme').'.home.cart')->with(['lists'=>$lists,'title'=>$title,'footer'=>$footer]);
	}
	//购物车未支付页面
	public function pending(Request $request){
		$lists = Order::join('order_product','order.id','=','order_product.order_id')
			->join('product','order_product.product_id','=','product.id')
			->where('order.type','cart')
			->where('state','pending')
			->where('order.user_id',Auth::user()->id)
			->select('product.*')
			->paginate(config('app.paginate10'));
		$title = '待支付';
		$footer = 'pending';
		return view(config('app.theme').'.home.orderList')->with(['lists'=>$lists,'title'=>$title,'footer'=>$footer]);
	}
	//添加一下购物车

}
