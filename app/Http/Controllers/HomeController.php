<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Ad;
use App\System;
use App\Product;
use App\OrderProduct;
use DB;
use IQuery;

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
        $rands = Product::where('product.state','=',1)
            ->join('spec','product.id','=','spec.product_id')
            ->where('spec.state','=',1)
            ->inRandomOrder()
            ->select('product.*','spec.price')
            ->paginate($num);
        return $rands;
    }

    //最新商品
    public function newProduct()
    {
        if (!Product::first()) return null;
        $news = Product::orderBy('product.id','desc')
            ->join('spec','product.id','=','spec.product_id')
            ->where('spec.state','=',1)
            ->select('product.*','spec.price')
            ->paginate(4);
        return $news;
    }

    //活动商品
    public function activityProduct() 
    {
        $activitys = Product::join('activity_product','product.id','=','activity_product.id')
            ->join('spec','product.id','=','spec.product_id')
            ->where('spec.state','=',1)
            ->whereNull('product.deleted_at')
            ->select('product.*','spec.price')
            ->distinct('product.id')
            ->orderBy('product.id','desc')
            ->paginate(3);
        return $activitys;
    }

    //热卖商品方法
    public function sellProduct() 
    {
        $sells = DB::table('order')
            ->join('order_product','order.id','=','order_product.order_id')
            ->join('product','order_product.product_id','=','product.id')
            ->where('order.type','=','order')
            ->where('order.state','=','close')
            ->select(DB::raw('sum(fx_order_product.amount) as nums'),'order_product.product_id as id')
            ->groupBy('product_id')
            ->orderBy('nums','desc')
            ->paginate(3);
        $ids = array(); 
        foreach ($sells as $sell) {
            $ids[] = $sell->id;
        }
        $data = Product::join('spec','product.id','=','spec.product_id')
            ->where('spec.state','=',1)
            ->whereIn('product.id',$ids)
            ->whereNull('product.deleted_at')
            ->select('product.*','spec.price')
            ->paginate(3);
        return $data;
    }

    public function shopping()
    {
        $products = Product::paginate(16);
        return view(config('app.theme').'.home.shopping')->with('products',$products);
    }

    //访问设备错误
    public function isPc(Request $request)
    {
        $err = $request->all();
        if (!empty($err)) {
            foreach ($err as $k => $v) {
               $err = base64_decode($v);
            }
        }
        return view('/layouts/is_pc')->with('err', $err);
    }
}
