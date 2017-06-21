<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\OrderProduct;
use DB;
class HomeController extends Controller
{
    //首页
    public function index()
    {

        //新品推荐
        $news = Product::join('product_group','product.group_id','=','product_group.id')
                ->join('product_img','product_group.id','=','product_img.group_id')
                ->select('product.*','product_img.img as image','product_img.thumb')
                ->orderBy('product.id','desc')
                ->paginate(3);

        //活动商品
        $activitys = Product::join('activity_product','product.id','=','activity_product.id')
                    ->join('product_group','product.group_id','=','product_group.id')
                    ->join('product_img','product_group.id','=','product_img.group_id')
                    ->select('product.*','product_img.img as image','product_img.thumb')
                    ->orderBy('product.id','desc')
                    ->paginate(3);
        if (!count($activitys))  $activitys = $news; 

        //热卖商品
        $sells = DB::table('order_product')
                ->join('order','order_product.order_id','=','order.id')
                ->join('product','order_product.product_id','=','product.id')
                // ->join('product_group','product.group_id','=','product_group.id')
                // ->join('product_img','product_group.id','=','product_img.group_id')
                ->where('order.type','=','order')
                ->where('order.state','=','paid')
                ->Orwhere('order.state','=','close')
                ->select(
                    'product.*',
                    // 'product_img.thumb',
                    // 'product_img.img as image',
                    'order_product.product_id',
                    DB::raw('SUM(amount) as nums')
                )
                ->groupBy('order_product.product_id')
                ->orderBy('nums','desc')
                ->paginate(3);

        return view('index')->with(['footer'=>'home','activitys'=>$activitys,'news'=>$news,'sells'=>$sells]); 
    }

    public function shopping()
    {
        $products = Product::paginate(16);
        return view(config('app.theme').'.home.shopping')->with('products',$products);
    }
}
