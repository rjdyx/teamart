<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Activity;
use DB;
class IndexController extends Controller
{
    //首页更多列表页
    public function promotion(Request $request, $type)
    {	
    	$title = "活动商品";
    	if ($type=='new') $title = "最新商品";
    	$id = empty($request->id)?'':$request->id;
        return view(config('app.theme').'.home.promotion')->with(['title' => $title,'type'=>$type,'id'=>$id]);
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
        $news = Product::orderBy('product.id','desc')
            ->join('spec','product.id','=','spec.product_id')
            ->where('spec.state','=',1)
            ->select('product.*','spec.price')
            ->paginate(10);
        return $news;
    }

    //团购商品
    public function markProduct($request)
    {
        $id = $request->id;
        $data = Activity::join('activity_product','activity.id','=','activity_product.activity_id')
                ->join('product','activity_product.product_id','=','product.id')
                ->join('spec','product.id','=','spec.product_id')
                ->where('spec.state','=',1)
                ->where('activity.id','=',$id)
                ->whereNull('activity_product.deleted_at')
                ->whereNull('activity.deleted_at')
                ->distinct('product.id')
                ->select('product.*','spec.price')
                ->paginate(10);
        return $data;
    }

}
