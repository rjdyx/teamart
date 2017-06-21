<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\CheapUser;
use IQuery;
use Cache;

class CheapUserObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('优惠券用户表',$operate);
    }

    //新建
    public function created(CheapUser $CheapUser)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(CheapUser $CheapUser)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(CheapUser $CheapUser)
    {
        $this->logStore('删除');
    }
}

