<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Site;
use IQuery;
use Cache;

class SiteObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('销售站点表',$operate);
    }

    //新建
    public function created(Site $Site)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(Site $Site)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(Site $Site)
    {
        $this->logStore('删除');
    }
}

