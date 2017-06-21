<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Parter;
use IQuery;
use Cache;

class ParterObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('分销角色表',$operate);
    }

    //新建
    public function created(Parter $Parter)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(Parter $Parter)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(Parter $Parter)
    {
        $this->logStore('删除');
    }
}

