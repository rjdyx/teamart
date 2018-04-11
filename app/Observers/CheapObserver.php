<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Cheap;
use IQuery;
use Cache;

class CheapObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('优惠券表',$operate);
    }

    //新建
    public function created(Cheap $Cheap)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(Cheap $Cheap)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(Cheap $Cheap)
    {
        $this->logStore('删除');
    }
}

