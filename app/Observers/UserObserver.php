<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\User;
use IQuery;
use Cache;

class UserObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('用户表',$operate);
    }

    //新建
    public function created(User $user)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(User $user)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(User $user)
    {
        $this->logStore('删除');
    }
}

