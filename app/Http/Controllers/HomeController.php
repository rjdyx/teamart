<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ad;
use App\System;
use App\Product;
use App\OrderProduct;
use DB;
class HomeController extends Controller
{
    //首页
    public function index()
    {

        //新品推荐
        $news = $this->newProduct();

        //活动商品
        $activitys = $this->activityProduct();
        if (count($activitys)<3) $activitys = $this->randProduct(3); 

        //热卖商品
        $sells = $this->sellProduct();
        if (count($sells)<3) $sells = $this->randProduct(3);

        //广告
        $ads = Ad::where('position','index')->get();

        //轮播
        $system = System::find(1); $lbs = array();
        if (isset($system->slider) && !empty($system->slider)) $lbs = explode(',', $system->slider);

        return view('index')->with(['footer'=>'home','lbs'=>$lbs,'activitys'=>$activitys,'news'=>$news,'sells'=>$sells,'ads'=>$ads]); 
    }

    //随机查询商品
    public function randProduct($num = 3)
    {
        if (!Product::first()) return null;
        $rands = Product::join('product_group','product.group_id','=','product_group.id')
            ->join('product_img','product_group.id','=','product_img.group_id')
            ->where('state','=',1)
            ->select('product.*','product_img.img as image','product_img.thumb')
            ->distinct('product.id')
            ->inRandomOrder()
            ->paginate($num);
        return $rands;
    }

    //最新商品
    public function newProduct()
    {
        if (!Product::first()) return null;
        $news = Product::join('product_group','product.group_id','=','product_group.id')
            ->leftjoin('product_img','product_group.id','=','product_img.group_id')
            ->select('product.*','product_img.img as image','product_img.thumb')
            ->distinct('product.id')
            ->orderBy('product.id','desc')
            ->paginate(4);
        return $news;
    }

    //活动商品
    public function activityProduct() 
    {
        $activitys = Product::join('activity_product','product.id','=','activity_product.id')
            ->join('product_group','product.group_id','=','product_group.id')
            ->join('product_img','product_group.id','=','product_img.group_id')
            ->select('product.*','product_img.img as image','product_img.thumb')
            ->distinct('product.id')
            ->orderBy('product.id','desc')
            ->paginate(3);
        return $activitys;
    }

    //热卖商品方法
    public function sellProduct() 
    {
        $sells = DB::table('product')
            ->join('order_product','product.id','=','order_product.product_id')
            ->join('order','order_product.order_id','=','order.id')
            ->where('order.type','=','order')
            ->where('order.state','=','close')
            ->select(DB::raw('sum(amount) as nums','product.*'))
            ->groupBy('order_product.product_id')
            ->orderBy('nums','desc')
            ->paginate(3); 
        return $sells;
    }

    public function shopping()
    {
        $products = Product::paginate(16);
        return view(config('app.theme').'.home.shopping')->with('products',$products);
    }
}
