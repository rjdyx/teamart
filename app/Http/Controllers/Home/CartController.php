<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Order;
use App\OrderProduct;
use App\Address;
use App\Product;

class CartController extends Controller
{
	//购物车列表页
	public function index (Request $request) 
	{
		$title = '购物车'; $footer = 'cart';
		return view(config('app.theme').'.home.cart')->with(['title'=>$title,'footer'=>$footer]);
	}

	//分页展示
	public function  listData(Request $request)
	{
		$data = Order::join('order_product','order.id','=','order_product.order_id')
			->join('product','order_product.product_id','=','product.id')
			->where('type','cart')
			->where('order.user_id',Auth::user()->id)
			->whereNull('order_product.deleted_at')
			->whereNull('product.deleted_at')
			->whereNull('order.deleted_at')
			->distinct('product.id')
			->select('product.*','order_product.id as opid','order_product.amount','order.id as order_id')
			->paginate(5);
		return $data;
	}

	//添加商品到购物车
	public function store(Request $request)
	{
		$product_id = $request->id; // 商品id
		$amount = $request->amount;//商品数量
		$result = $this->issetCart($product_id);//判断商品是否在购物车存在

		if (empty($result->id)){
			$order = Order::where('type','cart')->where('user_id',Auth::user()->id)->first();//查询是否有购物车订单
			if (empty($order->id)) {
				$newOrder = $this->createCollect('cart');//创建购物车订单
				if (!$newOrder) return 0;
				$newId = $newOrder->id;
			} else {
				$newId = $order->id;
			}
			return $this->addOrderProduct($product_id, $newId);
		} else {
			return $this->editOrderProduct($result->id);
		}
	}

    //创建新的Order信息
    public function createCollect($type = false)
    {
    	$order = new Order;
        $order->serial = uniqid();
        $order->method = "delivery";
        $order->user_id = Auth::user()->id;
        $order->price = 0;
        $order->type = 'collect';
        $order->state = 'pading';
        $order->address_id = 0;
        $order->date = date("Y-m-d");
        if ($type) $order->type = $type;
        if ($order->save()) return $order;
        return 0;
    }

    //添加 商品订单关联方法
    public function addOrderProduct($id, $order_id)
    {   
        $order_product = new OrderProduct;
        $order_product->order_id = $order_id;
        $order_product->product_id = $id;
        $order_product->price = Product::find($id)->price;
        $order_product->amount = 1;

        if ($order_product->save()) return 1;
        return 0;
    }

    //编辑数量 商品订单关联方法
    public function editOrderProduct($id)
    {   
        $model = OrderProduct::find($id);
        $amount = $model->amount + 1;
        $model->amount = $amount;
        $model->price = (Product::find($model->product_id)->price) * $amount;
        if ($model->save()) return 1;
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
