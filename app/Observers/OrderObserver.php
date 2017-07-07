<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Order;
use App\OrderProduct;
use App\Product;
use App\Delivery;
use App\User;
use IQuery;
use Cache;

class OrderObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('订单表',$operate);
    }

    //新建
    public function created(Order $Order)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(Order $order)
    {
        $this->logStore('编辑');

        if ($order->state == 'close' &&) {

            //代理商销售总额
            if ($order->pid) {
                $user = User::find($order->pid);
                $pre_sell = $user->sell_count;
                $user->sell_count = intval($pre_sell) + intval($order->price);
                $user->save();
            }

            //商品销量更新
            $datas = OrderProduct::where('order_id',$order->id)
                    ->select('product_id as pid','amount')->get();
            foreach ($datas as $data) {
                $product = Product::find($data->pid);
                $product->sell_amount = intval($product->sell_amount) + intval($data->amount);
                $product->save();
            }
        }

        //发货更新库存
        if ($order->state == 'paid') {
            $this->stockUpdate('-');
        }

        //退货更新库存
        if ($order->state == 'backy') {
            $this->stockUpdate('+');
        }

        //收货后存储物流信息
        if ($order->state == 'take') {
            $datas = json_decode(IQuery::getOrderTracesByJson($order->delivery_serial, $order->coding),true)['Traces'];
            foreach ($datas as $data) {
                $delivery = new Delivery;
                $delivery->order_id = $order->id;
                $delivery->content = $data['AcceptStation'];
                $delivery->date = $data['AcceptTime'];
                $delivery->save();
            }
        }

    }

    //商品库存更新
    public function stockUpdate($type)
    {
        $lists = Order::join('order_product','order.id','=','order_product.order_id')
                ->select('order_product.amount','order_product.product_id as id')
                ->get();
        foreach ($lists as $list) {
            $product = Product::find($list->id);
            $product->stock = intval($product->stock) .$type. intval($list->amount);
            $product->save();
        }
    }

    //删除
    public function deleted(Order $Order)
    {
        $this->logStore('删除');
    }
}

