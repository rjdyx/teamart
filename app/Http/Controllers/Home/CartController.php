<?php

namespace App\Http\Controllers\Home;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderProduct;
use Illuminate\Support\Facades\Auth;
use App\Address;


class CartController extends Controller
{
	//购物车列表页
	public function index (Request $request) {
		$lists= Order::join('order_product','order.id','=','order_product.order_id')
			->join('product','order_product.product_id','=','product.id')
			->join('product_group','product.group_id','=','product_group.id')
			->join('product_img','product_img.group_id','=','product_group.id')
			->where('type','cart')
			->where('order.user_id',Auth::user()->id)
			->where('order_product.deleted_at',null)
			->get();
		$totals= Order::where('type','cart')
			->where('order.user_id',Auth::user()->id)
			->value('price');
		$title = '购物车';
		$footer = 'cart';
		return view(config('app.theme').'.home.cart')->with(['lists'=>$lists,'title'=>$title,'footer'=>$footer,'totals'=>$totals]);
	}
	//添加商品到购物车
	public function create(Request $request){

	     // $product_id=$request->product_id;
		$product_id = 1;
		$product_price=Product::where('id',$product_id)->value('price');
		if(!$product_price){
			return "该商品已下架";
		}
		// $amount= $request->amount;
$amount = 1;
		$hasOrder = Order::where('user_id',Auth::user()->id)->count('id');
		if(!$hasOrder){
		$order = new Order;
		$order->address_id=Address::where('user_id',Auth::user()->id)->value('id');
		$order->user_id=Auth::user()->id;
		$order->serial=uniqid();
		$order->price=$amount*$product_price;
		$order->type="cart";
		$order->date=date("Ymd");
		$order->save();
			$order_product=new OrderProduct;
		$order_product->order_id=$order->id;
		$order_product->product_id=$product_id;
		$order_product->amount=$amount;
		$order_product->price=$product_price*$amount;
		$order_product->save();
		}
		else{
			$order=Order::join('order_product','order.id','=','order_product.order_id')->
			where('user_id',Auth::user()->id)->first();
			$order_id=$order->order_id;
			$hasOrderProduct=OrderProduct::where('product_id',$product_id)->where('order_id',$order_id)->count();
			if(!$hasOrderProduct){
			     $order_product=new OrderProduct;
				 $order_product->amount=$amount;
			}else{
				$order_product=OrderProduct::where('product_id',$product_id)->where('order_id',$order_id)->first();
				$amount=($order_product->amount)+1;
				$order_product->amount=$amount;
			}
			$order_product->order_id=$order_id;
			$order_product->product_id=$product_id;
			$order_product_newprice=$product_price*$amount;



			$order=Order::find($order_id);
			$order_old_price=$order->price;
			$order->price=$order_old_price-$order_product->price+$order_product_newprice;
			$order_product->price=$product_price*$amount;
			$order_product->save();

            $order->save();

		}
	}
	//删除购物车
	public function destory(Request $request){
		$product_id=$request->product_id;// 商品id

		$order_product=Order::join('order_product','order.id','=','order_product.order_id')->
			where('user_id',Auth::user()->id)->where('product_id',$product_id)->first();
		$order_product_id=	$order_product->id;
		$order_product_price=	$order_product->price;
		$order_product_orderId=	$order_product->order_id;

        $order=Order::find($order_product_orderId);
		$order->price=$order->price-$order_product_price;
		$order->save();
		OrderProduct::find($order_product_id)->delete();

	}
	//更新购物车
	public  function update(Request $request,$id){
		$product_id=$request->product_id; // 商品id
		$amount= $request->amount;        //商品数量

		$product_price=Product::where('id',$product_id)->value('price');
		if(!$product_price){
			return "该商品已下架";
		}


		$order=Order::join('order_product','order.id','=','order_product.order_id')->
		where('user_id',Auth::user()->id)->first();
		$order_id=$order->order_id;
		$order_product_newprice=$product_price*$amount;
		$order=Order::find($order_id);
		$order_old_price=$order->price;
		$order_product=OrderProduct::where('product_id',$product_id)->where('order_id',$order_id)->first();

		$order_product->amount=$amount;
		$order->price=$order_old_price-$order_product->price+$order_product_newprice;
		$order_product->price=$product_price*$amount;
		$order_product->save();

		$order->save();

	}


}
