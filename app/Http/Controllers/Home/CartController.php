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
		return view(config('app.theme').'.home.orderList')->with(['lists'=>$lists,'title'=>$title,'footer'=>$footer]);
	}
}
