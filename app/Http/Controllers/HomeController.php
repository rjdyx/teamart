<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ad;
use App\System;
use App\Product;
use App\OrderProduct;
use DB;
use IQuery;
class HomeController extends Controller
{
    public function isWeixin() { 
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) { 
            $res = IQuery::GetwxInfo();
            $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$res['access_token'].'&openid='.$res['openid'].'&lang=zh_CN';
            $info = json_decode(file_get_contents($url));
            // $data['name'] = $info->nickname;
            // $data['image'] = $info->headimgurl;
            return $info;
            return '微信端'; 
        } 
        return '不是微信端'; 
    }

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
        $rands = Product::where('state','=',1)
            ->inRandomOrder()
            ->paginate($num);
        return $rands;
    }

    //最新商品
    public function newProduct()
    {
        if (!Product::first()) return null;
        $news = Product::orderBy('product.id','desc')->paginate(4);
        return $news;
    }

    //活动商品
    public function activityProduct() 
    {
        $activitys = Product::join('activity_product','product.id','=','activity_product.id')
            ->select('product.*')
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
        return Product::whereIn('id',$ids)->paginate(3);
    }

    public function shopping()
    {
        $products = Product::paginate(16);
        return view(config('app.theme').'.home.shopping')->with('products',$products);
    }
}
