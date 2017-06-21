<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\ArticleCategory;
use IQuery;
use Cache;

class ArticleCategoryObserver
{   
    public function logStore($operate)
    {
        IQuery::ofLog('文章表',$operate);
    }

    //新建
    public function created(ArticleCategory $ArticleCategory)
    {
        $this->logStore('新建');
    }

    //编辑
    public function updated(ArticleCategory $ArticleCategory)
    {
        $this->logStore('编辑');
    }

    //删除
    public function deleted(ArticleCategory $ArticleCategory)
    {
        $this->logStore('删除');
    }
}

