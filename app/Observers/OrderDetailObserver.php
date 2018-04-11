<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\OrderProduct;
use IQuery;
use Cache;

class OrderDetailObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('订单商品表',$operate);
    }

    //新建
    public function created(OrderProduct $OrderProduct)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(OrderProduct $OrderProduct)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(OrderProduct $OrderProduct)
    {
        $this->logStore('删除');
    }
}

