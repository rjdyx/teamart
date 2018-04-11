<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\ProductImg;
use IQuery;
use Cache;

class ProductImgObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('商品图片表',$operate);
    }

    //新建
    public function created(ProductImg $ProductImg)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(ProductImg $ProductImg)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(ProductImg $ProductImg)
    {
        $this->logStore('删除');
    }
}

