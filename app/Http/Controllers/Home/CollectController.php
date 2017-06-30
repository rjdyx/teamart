<?php

namespace App\Http\Controllers\Home;

use App\OrderProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Support\Facades\Auth;
use App\Product;
class CollectController extends Controller
{

    //收藏列表
    public function index(Request $request) {
        $lists= Order::join('order_product','order.id','=','order_product.order_id')
            ->join('product','order_product.product_id','=','product.id')
            ->where('type','collect')
            ->where('order.user_id',Auth::user()->id)
            ->where('order.deleted_at',null)
            ->where('order_product.deleted_at',null)
            ->where('product.deleted_at',null)
            ->select('product.*', 'order_product.id as op_id','product.desc as p_desc','product.img as p_img','product.price as p_price',
                     'product.sell_amount as p_sell_amount','product.name as p_name')

            ->paginate(10);


//            ->paginate(config('app.paginate10'));
        $title = '收藏管理';
        return view(config('app.theme').'.home.collect')->with(['footer'=>'collect','lists'=>$lists,'title'=>$title]);
    }
    //取消收藏
    public function destroy($product_id){


        $collect_id = Order::join('order_product','order.id','=','order_product.order_id')->
        join('product','order_product.product_id','=','product.id')->
        where('type','collect')->
        where('order.user_id',Auth::user()->id)->
        where('order_product.deleted_at','=',null)->
        where('product.id',$product_id)->
        select('order_product.id as op_id')->value('op_id');

        if($this->del($collect_id)){

            return 1;
        }else{

            return 0;
        }



    }
    public function del($id){
        if (OrderProduct::destroy($id)) return true;
        return false;
    }
    //批量取消收藏
    public function dels(Request $request)
    {
        $ids=$request->all();


        foreach ($ids as $id) {
            if (!$this->destroy($id)) {
                echo $id;
                return 0;
            }
        }
        return 1;

    }
    public function show(Request $request){
        return $this->dels($request);
    }
    //加入收藏
    public function create(Request $request){
		$product_id=$request->id;

        $hasCollectOrder=Order::where('type','collect')->
            where('user_id',Auth::user()->id);
        if($hasCollectOrder->count()){
            $order=$hasCollectOrder->first();
        }else{
            $order=new Order;
        }
        $lists=Order::join('order_product','order.id','=','order_product.order_id')->

        where('order_product.product_id',$product_id)->
        where('type','collect')->
        where('order.user_id',Auth::user()->id)->
        where('order_product.deleted_at',null)->count('order.id');
        if($lists>0){
            return 0;
        }
        else{

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
            $order_product->product_id=$product_id;
            $price=Product::where('id',2)->value('price');
            $order_product->price=$price;
            $order_product->amount=1;
            $order_product->save();
            return 1;
        }}
}
