<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Feedback;
use IQuery;
use Cache;

class FeedbackObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('反馈表',$operate);
    }

    //新建
    public function created(Feedback $Feedback)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(Feedback $Feedback)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(Feedback $Feedback)
    {
        $this->logStore('删除');
    }
}

