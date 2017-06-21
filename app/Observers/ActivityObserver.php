<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Activity;
use IQuery;
use Cache;

class ActivityObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('团购活动表',$operate);
    }

    //新建
    public function created(Activity $Activity)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(Activity $Activity)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(Activity $Activity)
    {
        $this->logStore('删除');
    }
}

