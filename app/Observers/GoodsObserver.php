<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Prodcut;
use IQuery;
use Cache;

class GoodsObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('商品表',$operate);
    }

    //新建
    public function created(Prodcut $Prodcut)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(Prodcut $Prodcut)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(Prodcut $Prodcut)
    {
        $this->logStore('删除');
    }
}

