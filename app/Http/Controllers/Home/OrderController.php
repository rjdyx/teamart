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
		return view(config('app.theme').'.home.orderList')->with(['lists'=>$lists,'title'=>$title]);
	}

	//收藏列表页
	public function collect (Request $request) {
		$lists = Order::where('type','collect')
		->where('user_id',Auth::user()->id)
		->paginate(config('app.paginate10'));
		$title = '收藏管理';
		return view(config('app.theme').'.home.collect')->with(['lists'=>$lists,'title'=>$title]);
	}
	//收藏取消
	public function collectDel(Request $request){
		$id=$request->id;
		$order_id = Order::join('order_product','order.id','=','order_product.order_id')->
			join('product','order_product.product_id','=','product.id')->
            where('product.id',$id)->
			where('type','collect')->
			where('order.user_id',Auth::user()->id)->value('order_id');


				if($this->del($order_id)){
//					return Redirect::back()->with('status','删除收藏成功');
					return "Y";
				}else{
//					return Redirect::back()->withErrors('删除收藏失败');
					return "N";
				}

//		return Redirect::back()->withErrors('删除收藏失败');
		return "N";
	}
	public function del($id){
		if (Order::destroy($id)) return true;
		return false;
	}
	//增加收藏
	public function collectCreate(Request $request){
//		$id=$request->id;
      $id=3;
       $lists=Order::join('order_product','order.id','=','order_product.order_id')->

	   where('order_product.product_id',$id)->
	   where('type','collect')->
	   where('order.user_id',Auth::user()->id)->count('order.id');
		if($lists>0){
			return "已经收藏过了";
		}
        else{
		$order=new Order;
		$order->serial=uniqid();
		$order->method="delivery";
		$order->user_id=Auth::user()->id;
		$order->price=0;
		$order->type='collect';
		$order->state='close';
		$order->address_id=0;
		$order->date=date("Ymd");
		$order->save();
		$order_product=new OrderProduct;
		$order_product->order_id=$order->id;
		$order_product->product_id=$id;
		$price=Product::where('id',2)->value('price');
		$order_product->price=$price;
		$order_product->amount=1;
		$order_product->save();
        return "添加收藏成功";
	}}

}
