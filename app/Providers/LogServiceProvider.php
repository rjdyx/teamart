<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Log\Connection;

use App\User;
use App\Observers\UserObserver;

use App\Activity;
use App\Observers\ActivityObserver;

use App\ActivityProduct;
use App\Observers\ActivityProductObserver;

use App\Address;
use App\Observers\AddressObserver;

use App\Article;
use App\Observers\ArticleObserver;

use App\ArticleCategory;
use App\Observers\ArticleCategoryObserver;

use App\Brand;
use App\Observers\BrandObserver;

use App\Cheap;
use App\Observers\CheapObserver;

use App\CheapUser;
use App\Observers\CheapUserObserver;

use App\Comment;
use App\Observers\CommentObserver;

use App\Feedback;
use App\Observers\FeedbackObserver;

use App\Order;
use App\Observers\OrderObserver;

use App\OrderProduct;
use App\Observers\OrderDetailObserver;

use App\Parter;
use App\Observers\ParterObserver;

use App\Product;
use App\Observers\GoodsObserver;

use App\ProductCategory;
use App\Observers\ProductCategoryObserver;

use App\ProductGroup;
use App\Observers\ProductGroupObserver;

use App\ProductImg;
use App\Observers\ProductImgObserver;

use App\Reply;
use App\Observers\ReplyObserver;

use App\Site;
use App\Observers\SiteObserver;

use App\Spec;
use App\Observers\SpecObserver;

use App\System;
use App\Observers\SystemObserver;

class LogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_DEBUG')){
            User::observe(UserObserver::class);
            Article::observe(ArticleObserver::class);
            ArticleCategory::observe(ArticleCategoryObserver::class);
            Activity::observe(ActivityObserver::class);
            ActivityProduct::observe(ActivityProductObserver::class);
            Address::observe(AddressObserver::class);
            Brand::observe(BrandObserver::class);
            Cheap::observe(CheapObserver::class);
            CheapUser::observe(CheapUserObserver::class);
            Comment::observe(CommentObserver::class);
            Feedback::observe(FeedbackObserver::class);
            Order::observe(OrderObserver::class);
            OrderProduct::observe(OrderDetailObserver::class);
            Parter::observe(ParterObserver::class);
            Product::observe(GoodslObserver::class);
            ProductCategory::observe(ProductCategoryObserver::class);
            ProductGroup::observe(ProductGroupObserver::class);
            ProductImg::observe(ProductImgObserver::class);
            Reply::observe(ReplyObserver::class);
            Site::observe(SiteObserver::class);
            Spec::observe(SpecObserver::class);
            System::observe(SystemObserver::class);
        }
    }

    /**
     * 在容器中注册绑定.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Log\Contracts\Connection', function ($app) {
            return new Connection(config('log'));
        });
    }
}
