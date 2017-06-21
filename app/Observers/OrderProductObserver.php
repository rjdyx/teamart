<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\OrderProdcut;
use IQuery;
use Cache;

class OrderProdcutObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('订单商品表',$operate);
    }

    //新建
    public function created(OrderProdcut $OrderProdcut)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(OrderProdcut $OrderProdcut)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(OrderProdcut $OrderProdcut)
    {
        $this->logStore('删除');
    }
}

