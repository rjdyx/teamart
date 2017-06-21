<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Comment;
use IQuery;
use Cache;

class CommentObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('评论表',$operate);
    }

    //新建
    public function created(Comment $Comment)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(Comment $Comment)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(Comment $Comment)
    {
        $this->logStore('删除');
    }
}

