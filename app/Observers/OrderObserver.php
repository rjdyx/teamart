<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Order;
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
    public function updated(Order $Order)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(Order $Order)
    {
        $this->logStore('删除');
    }
}

