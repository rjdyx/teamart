<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Reply;
use IQuery;
use Cache;

class ReplyObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('评论回复表',$operate);
    }

    //新建
    public function created(Reply $Reply)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(Reply $Reply)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(Reply $Reply)
    {
        $this->logStore('删除');
    }
}

