<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Address;
use IQuery;
use Cache;

class AddressObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('地址表',$operate);
    }

    //新建
    public function created(Address $Address)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(Address $Address)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(Address $Address)
    {
        $this->logStore('删除');
    }
}

