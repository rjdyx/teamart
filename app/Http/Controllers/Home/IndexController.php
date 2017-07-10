<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Product;
use DB;
class IndexController extends Controller
{
    //首页更多列表页
    public function promotion($type)
    {	
    	$title = "活动商品";
    	if ($type=='new') $title = "最新商品";
    	
        return view(config('app.theme').'.home.promotion')->with(['title' => $title,'type'=>$type]);
    }

    //首页更多列表页数据接口
    public function promotionData(Request $request)
    {	
    	if ($request->type != 'activity') return $this->newProduct();
		return $this->markProduct($request);
    }

    //最新商品
    public function newProduct()
    {
        $news = Product::orderBy('product.id','desc')->paginate(10);
        return $news;
    }

    //团购商品
    public function markProduct($request)
    {
        $id = $request->id;
        $data = Activity::join('activity_product','activity.id','=','activity_product.activity_id')
                ->join('product','activity_product.product_id','=','product.id')
                ->where('activity.id','=',$id)
                ->select('product.*')
                ->paginate(10);
        return $data;
    }

    //热卖商品方法
    // public function sellProduct() 
    // {
    //     $sells = DB::table('product')
    //         ->join('order_product','product.id','=','order_product.product_id')
    //         ->join('order','order_product.order_id','=','order.id')
    //         ->where('order.type','=','order')
    //         ->where('order.state','=','close')
    //         ->select(DB::raw('sum(amount) as nums','product.*'))
    //         ->groupBy('order_product.product_id')
    //         ->orderBy('nums','desc')
    //         ->paginate(10); 
    //     return $sells;
    // }
}
