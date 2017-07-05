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
	public function index (Request $request) 
	{
		$lists= $this->searchList();

		$totals= Order::where('type','cart')
			->where('order.user_id',Auth::user()->id)
			->value('price');
		$title = '购物车';
		$footer = 'cart';
		return view(config('app.theme').'.home.cart')
		->with(['lists'=>$lists,'title'=>$title,'footer'=>$footer,'totals'=>$totals]);
	}

	//添加商品到购物车
	public function store(Request $request)
	{
		$amount= $request->amount;
	    $product_id=$request->id;

		$product_price=Product::where('id',$product_id)->value('price');

		$hasOrder = Order::where('user_id',Auth::user()->id)->where('type','cart')->count('id');
		
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
			$order_id=$order->id;
			$this->changeOrderProduct($order_product,$amount,$product_price,$order_id,$product_id);
			return 1;
		}
		else{
					$order=Order::where('user_id',Auth::user()->id)->
					where('type','cart')->
					where('order.deleted_at',null)->
					first();
					$order_id=$order->id;
					$hasOrderProduct=OrderProduct::where('product_id',$product_id)->where('order_id',$order_id)->count();
					if(!$hasOrderProduct){
						$order_product=new OrderProduct;

					}else{
						$order_product=OrderProduct::where('product_id',$product_id)->where('order_id',$order_id)->first();

			}

			$order_product_newprice=$product_price*$amount;
			$order=Order::find($order_id);
			$order_old_price=$order->price;
			$order->price=$order_old_price-$order_product->price+$order_product_newprice;
			$this->changeOrderProduct($order_product,$amount,$product_price,$order_id,$product_id);
            $order->save();
			return 1;

		}
	}

	//删除购物车
	public function destroy($id){
		$product_id=$id;// 商品id
		$order_product=Order::join('order_product','order.id','=','order_product.order_id')->
			where('user_id',Auth::user()->id)->
		    where('product_id',$product_id)->
		    where('order_product.deleted_at',null)->
			where('order.deleted_at',null)->
		    first();
		$order_product_id=	$order_product->id;
		$order_product_price=	$order_product->price;
		$order_product_orderId=	$order_product->order_id;
        $order=Order::find($order_product_orderId);
		$order_oldprice=$order->price;
		$order->price=$order_oldprice-$order_product_price;
		$order->save();
		if($this->del($order_product_id)){
			return 1;
		}else{
			return 0;
		}

	}
	//删除单条购物车商品
	public function del($id){
		if (OrderProduct::destroy($id)) return true;
		return false;
	}
	//批量删除购物车商品
	public function dels(Request $request)
	{
		$ids=$request->all();

		foreach ($ids as $id) {
			if (!$this->del($id)) return 0;
		}
		return 1;

	}
	//更新购物车
	public  function update(Request $request){
		$product_id=$request->id; // 商品id
		$amount= $request->amount;        //商品数量

		$product_price=Product::where('id',$product_id)->value('price');

		$order=Order::join('order_product','order.id','=','order_product.order_id')->
		where('user_id',Auth::user()->id)->
		where('type','cart')->
		where('order.deleted_at',null)->
		where('order_product.deleted_at',null)->
		first();
		$order_id=$order->order_id;
		$order_product_newprice=$product_price*$amount;
		$order=Order::find($order_id);
		$order_old_price=$order->price;
		$order_product=OrderProduct::where('product_id',$product_id)->where('order_id',$order_id)->first();
		$order->price=$order_old_price-$order_product->price+$order_product_newprice;
		$this->changeOrderProduct($order_product,$amount,$product_price);

		$order->save();

	}

	//分页展示
	public function  listData(Request $request)
	{
		return $this->searchList();
	}

	public function searchList()
	{
		return Order::join('order_product','order.id','=','order_product.order_id')
			->join('product','order_product.product_id','=','product.id')
			->where('type','cart')
			->where('order.user_id',Auth::user()->id)
			->whereNull('order_product.deleted_at')
			->whereNull('product.deleted_at')
			->whereNull('order.deleted_at')
			->distinct('product.id')
			->select('product.*','order_product.id as opid','order_product.amount','order.id as order_id')
			->paginate(5);
	}

	public function changeOrderProduct($order_product,$amount,$product_price,$order_id=0,$product_id=0){
        if($order_id){
		$order_product->order_id=$order_id;
		}
		if($product_id){
			$order_product->product_id=$product_id;
		}
		$order_product->amount=$amount;
		$order_product->price=$amount*$product_price;
		$order_product->save();
	}

	//修改购物车商品数量
	public function updateAmount(Request $request)
	{
		$id = $request->id;
		$amount = $request->amount;
		$data = OrderProduct::find($id);
		$data->amount = $amount;
		if ($data->save()) return 1;
		return 0;
	}
}
