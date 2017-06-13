<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
	//商品列表页
	public function index (Request $request) {
		$lists = Product::where('user_id',Auth::user()->id)
		->paginate(config('app.paginate10'));
		$title = '商品搜索';
		return view(config('app.theme').'.home.productList')->with(['lists'=>$lists, 'title'=>$title,'footer'=>'product']);
	}

	//商品详情页
	public function detail (Request $request, $id) {
		$content = Product::find($id);
		$title = '商品详情';
		return view(config('app.theme').'.home.productDetail')->with(['content'=>$content, 'title'=>$title,'footer'=>'product']);
	}
}
