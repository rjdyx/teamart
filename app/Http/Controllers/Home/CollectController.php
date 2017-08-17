<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\OrderProduct;
use App\Product;

class CollectController extends Controller
{
    //收藏列表
    public function index(Request $request) {
        $lists= $this->searchList();
        $title = '收藏管理';
        return view(config('app.theme').'.home.collect')->with(['footer'=>'collect','lists'=>$lists,'title'=>$title]);
    }

    //搜索分页
    public function searchList(){
        $data = Order::join('order_product','order.id','=','order_product.order_id')
                ->join('product','order_product.product_id','=','product.id')
                ->join('spec','product.id','=','spec.product_id')
                ->where('spec.state','=',1)
                ->where('type','collect')
                ->where('order.user_id',Auth::user()->id)
                ->whereNull('order.deleted_at')
                ->whereNull('order_product.deleted_at')
                ->whereNull('product.deleted_at')
                ->select('product.*', 
                    'order_product.id as op_id',
                    'product.desc as p_desc',
                    'product.img as p_img',
                    'product.sell_amount as p_sell_amount',
                    'product.name as p_name',
                    'spec.price'
                )->paginate(5);
        return $data;
    }

    //取消收藏
    public function destroy($product_id)
    {
        $collect_id = Order::join('order_product','order.id','=','order_product.order_id')
                ->join('product','order_product.product_id','=','product.id')
                ->where('type','collect')
                ->where('order.user_id',Auth::user()->id)
                ->where('order_product.deleted_at','=',null)
                ->where('product.id',$product_id)
                ->select('order_product.id as op_id')
                ->value('op_id');

        if($this->del($collect_id)) return 1;
        return 0;
    }

    public function del($id)
    {
        if (OrderProduct::destroy($id)) return true;
        return false;
    }

    //批量取消收藏
    public function dels(Request $request)
    {
        $ids = $request->all();
        foreach ($ids as $id) {
            if (!$this->del($id)) return 0;
        }
        return 1;
    }

    public function listData(Request $request) 
    {
        $lists= $this->searchList();
        return $lists;
    }

    //加入收藏
    public function store(Request $request)
    {
		$product_id = $request->id;//商品id
        $order = Order::where('type','collect')->where('user_id',Auth::user()->id)->first();

        if (empty($order->id)){
            $order = $this->createCollect('collect');
        }
        return $this->addOrderProduct($product_id, $order->id);
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

    //收藏加入购物车
    public function storeCart(Request $request)
    {
        $ids = $request->ids;
        $neworder = true;
        //查询是否有购物车订单
        $issetOrder = Order::where('type','cart')
            ->where('user_id',Auth::user()->id)
            ->first();

        foreach ($ids as $id) {   
            $product = OrderProduct::find($id);
            $cart = $this->issetCart($product->product_id);
            if (empty($cart->id)) {
                if ($neworder && empty($issetOrder->id)) {
                    $order = $this->createCollect('cart'); //新建购物车订单
                    if ($order) {
                        $neworder = false;
                    }else{
                        return 0;
                    }
                } else {
                    $order = $issetOrder;
                }
                if (!$this->addOrderProduct($product->product_id, $order->id)) return 0;
            } else {
                if (!$this->editOrderProduct($cart->id)) return 0;
            }    
        }
        return  1;
    }

    //添加 商品订单关联方法
    public function addOrderProduct($id, $order_id)
    {   
        $order_product = new OrderProduct;
        $order_product->order_id = $order_id;
        $order_product->product_id = $id;
        $data = $this->productPrice($id);
        $order_product->price = $data->price;
        $order_product->spec_id = $data->id;
        $order_product->amount = 1;

        if ($order_product->save()) return 1;
        return 0;
    }

    //编辑数量 商品订单关联方法
    public function editOrderProduct($id)
    {   
        $order_product = OrderProduct::find($id);
        $amount = $order_product->amount + 1;
        $order_product->amount = $amount;
        $data = $this->productPrice($order_product->product_id);
        $order_product->price = $data->price * $amount;
        if ($order_product->save()) return 1;
        return 0;
    }

    public function issetCart($product_id)
    {
        $data = OrderProduct::join('order','order_product.order_id','=','order.id')
            ->where('order_product.product_id','=',$product_id)
            ->where('user_id',Auth::user()->id)
            ->where('order.type','=','cart')
            ->whereNull('order.deleted_at')
            ->whereNull('order_product.deleted_at')
            ->select('order_product.id')
            ->first();
        return $data;
    }

    //查询商品价格
    public function productPrice($id,$sid=-1)
    {
        $data = Product::join('spec','product.id','=','spec.product_id')
            ->where('product.id',$id);
        if ($sid != -1) {
            $data = $data->where('spec.id',$sid);
        }else {
            $data = $data->where('spec.state',1);
        }
        $data = $data->select('spec.price','spec.id')->first(); 
        return $data;
    }

}
