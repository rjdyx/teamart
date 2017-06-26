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
        if (count($this->sellProduct())>2) {
            $sells = $this->sellProduct(true);
        }else{
            $sells = $this->randProduct(3);
        }

        //广告
        $ads = Ad::where('position','index')->get();

        //轮播
        $system = System::find(1); $lbs = array();
        if ($system->slider) $lbs = explode(',', $system->slider);

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
    public function sellProduct($t = false) 
    {
        $sells = DB::table('product')
            ->leftjoin('order_product','product.id','=','order_product.product_id')
            ->leftjoin('order','order_product.order_id','=','order.id')
            ->join('product_group','product.group_id','=','product_group.id')
            ->leftjoin('product_img','product_group.id','=','product_img.group_id')
            ->where('order.type','=','order')
            ->where('order.state','=','close');
        $arr = array('product.id');
        if ($t) {
            $arr = [
                'product.*','product_img.thumb',
                'product_img.img as image',
                'order_product.product_id',
                DB::raw('SUM(order.amount) as nums')
            ];
        }

        $sells = $sells->select($arr)
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
