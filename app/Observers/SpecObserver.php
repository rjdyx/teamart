<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Spec;
use IQuery;
use Cache;

class SpecObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('商品参数表',$operate);
    }

    //新建
    public function created(Spec $Spec)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(Spec $Spec)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(Spec $Spec)
    {
        $this->logStore('删除');
    }
}

