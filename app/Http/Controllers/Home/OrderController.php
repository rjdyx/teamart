<?php

namespace App\Http\Controllers\Home;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderProduct;
use Illuminate\Support\Facades\Auth;
use Redirect;
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



	public function confirm () {
		$title = '确认订单';
		return view(config('app.theme').'.home.confirm')->with(['title'=>$title]);
	}

	//订单列表数据
	public function orderListData(Request $request)
	{
		$datas = Order::where('order.user_id','=',Auth::user()->id)
				->join('order_product','order.id','=','order_product.order_id')
				->join('product','order_product.product_id','=','product.id')
				->where('order.type','=','order')
				->whereNull('product.deleted_at')
				->whereNull('order_product.deleted_at')
				->whereNull('order.deleted_at');

		$state = $request->state;//订单状态
		$serial = $request->serial;//订单号
		if ($state) {
			if ($state == 'self'){
				$datas = $datas->where('order.method','=','self')
						->where('order.state','=','paid');
			}else if ($state == 'paid'){
				$datas = $datas->where('order.method','!=','self')
						->where('order.state','=','paid');
			}else{
				$datas = $datas->where('order.state','=',$state);
			}
		}
		if ($serial) $datas = $datas->where('order.serial','like','%'.$serial.'%');

		$datas = $datas->select(
					'order_product.amount as order_amount',
					'order_product.price as order_price',
					'order.serial','order.id as order_id','order.updated_at as order_date',
					'product.*'
					)
					->groupBy('order_product.id')
					->paginate(10);
		return $datas;
	}
}
