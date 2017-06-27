<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Order;
use App\OrderProduct;
use App\Product;
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
        if ($order->state == 'close' && $order->pid) {
            //代理商销售总额
            $user = User::find($order->pid);
            $pre_sell = $user->sell_count;
            $user->sell_count = intval($pre_sell) + intval($order->price);
            $user->save();
            //商品销量更新
            $datas = OrderProduct::where('order_id',$order->id)->select('product_id as pid','amount')->get();
            foreach ($datas as $data) {
                $product = Product::find($data->pid);
                $product->sell_amount = intval($product->sell_amount) + intval($data->amount);
                $product->save();
            }
        }
    }

    //删除
    public function deleted(Order $Order)
    {
        $this->logStore('删除');
    }
}

