<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Article;
use IQuery;
use Cache;

class ArticleObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('文章表',$operate);
    }

    //新建
    public function created(Article $Article)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(Article $Article)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(Article $Article)
    {
        $this->logStore('删除');
    }
}

