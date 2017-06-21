<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\ActivityProduct;
use IQuery;
use Cache;

class ActivityProductObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('活动商品表',$operate);
    }

    //新建
    public function created(ActivityProduct $ActivityProduct)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(ActivityProduct $ActivityProduct)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(ActivityProduct $ActivityProduct)
    {
        $this->logStore('删除');
    }
}

