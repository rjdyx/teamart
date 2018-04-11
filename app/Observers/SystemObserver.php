<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\System;
use IQuery;
use Cache;

class SystemObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('系统设置表',$operate);
    }

    //新建
    public function created(System $System)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(System $System)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(System $System)
    {
        $this->logStore('删除');
    }
}

