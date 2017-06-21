<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Brand;
use IQuery;
use Cache;

class BrandObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('商品品牌表',$operate);
    }

    //新建
    public function created(Brand $Brand)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(Brand $Brand)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(Brand $Brand)
    {
        $this->logStore('删除');
    }
}

