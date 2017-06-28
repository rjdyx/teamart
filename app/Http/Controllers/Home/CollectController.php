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

    //收藏列表页
    public function index(Request $request) {
        $lists= Order::join('order_product','order.id','=','order_product.order_id')
            ->join('product','order_product.product_id','=','product.id')
            ->join('product_group','product.group_id','=','product_group.id')
            ->join('product_img','product_img.group_id','=','product_group.id')
            ->where('type','collect')
            ->where('order.user_id',Auth::user()->id)
            ->where('order_product.deleted_at',null)
            ->get();
//            ->paginate(config('app.paginate10'));
        $title = '收藏管理';
        return view(config('app.theme').'.home.collect')->with(['footer'=>'collect','lists'=>$lists,'title'=>$title]);
    }
    //收藏取消
    public function destory($id){
       $product_id=$id;

        $collect_id = Order::join('order_product','order.id','=','order_product.order_id')->
        join('product','order_product.product_id','=','product.id')->
        where('product.id',$product_id)->
        where('type','collect')->
        where('order.user_id',Auth::user()->id)->select('*','order_product.id as collect_id')->value('collect_id');

        if($this->del($collect_id)){
//					return Redirect::back()->with('status','删除收藏成功');
            return 1;
        }else{
//					return Redirect::back()->withErrors('删除收藏失败');
            return 0;
        }

//		return Redirect::back()->withErrors('删除收藏失败');
        return 0;
    }
    public function del($id){
        if (OrderProduct::destroy($id)) return true;
        return false;
    }
    //批量删除收藏
    public function dels(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            if (!$this->destory($id)) {
                return 0;
            }
        }
        return 0;
    }
    //增加收藏
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
