<?php

namespace App\Http\Controllers\Home;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\Address;
use App\Site;
use App\OrderProduct;
use Illuminate\Support\Facades\Auth;
use Redirect;
use IQuery;

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

	//订单预处理 (未支付)
	public function confirmData (Request $request) 
	{
		$datas = $request->data;
		if (!count($datas)) return 0;
		$order = new Order;
		$order->user_id = Auth::user()->id;
		$order->serial = IQuery::orderSerial();
		$order->type = 'order';
		$order->state = 'pading';
		$order->date = date('Y-m-d');
		$address = Address::where('state',1)->select('id')->first();
		$address_id = 0;
		if (isset($address->id)) $address_id = $address->id;
		$order->address_id = $address_id;

		$order->pid = Auth::user()->pater_id;
		if (!$order->save()) return 500;

		foreach($datas as $id => $amount) {
			$orderProduct = new OrderProduct;
			$orderProduct->product_id = $id;
			$orderProduct->amount = $amount;
			$orderProduct->price = Product::find($id)->price;
			$orderProduct->order_id = $order->id;
			if (!$orderProduct->save()) return 0;
			$this->delCartProduct($id);
		}
		return $order->id;
	}

	//删除购物车商品方法
	public function delCartProduct($product_id)
	{
		$cart = $this->issetCart($product_id);
		if (empty($cart->id)) return 0;
		if (OrderProduct::destroy($cart->id)) return 1;
		return 0;
	}

    //判断购物车商品是否存在
    public function issetCart($product_id)
    {
        $data = OrderProduct::join('order','order_product.order_id','=','order.id')
            ->where('order_product.product_id','=',$product_id)
            ->where('order.type','=','cart')
            ->whereNull('order.deleted_at')
			->whereNull('order_product.deleted_at')
            ->select('order_product.id')
            ->first();
        return $data;
    }

	//待支付 选择参数
	public function confirm (Request $request) 
	{
		$id = $request->id;
		$lists = OrderProduct::join('product','order_product.product_id','=','product.id')
				->where('order_product.order_id','=',$id)
				->whereNull('product.deleted_at')
				->whereNull('order_product.deleted_at')
				->select('product.id','product.name','product.desc','product.thumb','product.price','product.delivery_price','order_product.amount')
				->distinct('product.id')
				->get();
				
		$count = 0;
		foreach ($lists as $list) {
			$count += $list->price * $list->amount;
		}

		$title = '确认订单';
		return view(config('app.theme').'.home.confirm')->with(['title'=>$title,'lists'=>$lists,'count'=>$count]);
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
					'order_product.price as order_product_price',
					'order.serial','order.id as order_id','order.updated_at as order_date','order.price as order_price',
					'order.state as order_state','order.method as order_method','order.type as order_type',
					'product.*'
					)
					->distinct('order_product.id')
					// ->groupBy('order_product.id')
					->paginate(10);
		$arrs = array();
		foreach ($datas as $data) {
			$arrs[$data->order_id][] = $data;
		}

		return $arrs;
	}

	//查看销售站点页
	public function site(){
		$title = "自提位置";
		return view(config('app.theme').'.home.orderSite')->with(['title' => $title]);
	}

	//所有销售站点数据
	public function siteListData(){
		return Site::get();
	}

	//查看订单物流
	public function showDelivery($order_id){
		$title = "物流信息";
		return view(config('app.theme').'.home.orderDelivery')->with(['title' => $title]);
	}

	//订单评论
	public function orderComment($order_id){
		return view(config('app.theme').'.home.orderComment');
	}

	//订单state改变方法
	public function orderOperate($request, $state)
	{
		$id = $request->id;
		$order = Order::find($id);
		$order->state = $state;
		if ($order->save()) return 200;
		return 500;
	}

	//取消订单
	public function orderCancell(Request $request)
	{
		return $this->orderOperate($request, 'cancell');
	}

	//申请退货
	public function orderBack(Request $request)
	{
		return $this->orderOperate($request, 'backn');
	}
}
