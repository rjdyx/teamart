<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\ProductCategory;
use IQuery;
use Cache;

class ProductCategoryObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('商品分类表',$operate);
    }

    //新建
    public function created(ProductCategory $ProductCategory)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(ProductCategory $ProductCategory)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(ProductCategory $ProductCategory)
    {
        $this->logStore('删除');
    }
}

