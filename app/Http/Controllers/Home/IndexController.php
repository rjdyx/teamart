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
		return $this->sellProduct();
    }

    //最新商品
    public function newProduct()
    {
        $news = Product::join('product_group','product.group_id','=','product_group.id')
            ->leftjoin('product_img','product_group.id','=','product_img.group_id')
            ->select('product.*','product_img.img as image','product_img.thumb')
            ->distinct('product.id')
            ->orderBy('product.id','desc')
            ->paginate(10);
        return $news;
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
            ->paginate(10); 
        return $sells;
    }
}
