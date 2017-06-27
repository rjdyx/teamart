<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductCategory;
use App\Brand;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
	//商品列表页
	public function index (Request $request) 
	{
		$title = '商品搜索';
		return view(config('app.theme').'.home.productList')->with(['title'=>$title,'footer'=>'product']);
	}

	//商品列表页数据
	public function listData (Request $request) 
	{
		$order = 'desc';//排序方向
		$orField = 'product.sell_amount';//排序field
		$whValue = '';//模糊查询value

		$type = $request->type;//获取排序类型
		$up = $request->up;//获取排序方向
		$name = $request->name;//获取模糊查询value值
		$brands = empty($request->brands)?array():$request->brands;//获取多个品牌
		$category = $request->category;//获取分类
		$min = $request->min;//低价格
		$max = $request->max;//高价格

		if (!empty($type)) {
			if ($type == 'sell') $orField = 'product.sell_amount';
			if ($type == 'price') $orField = 'product.price';
		}
		if (!empty($up)) $order = $up;
		if (!empty($name)) $whValue = $name;

		$lists = Product::join('product_category','product.category_id','=','product_category.id')
				->join('brand','product.brand_id','=','brand.id')
				->join('product_group','product.group_id','=','product_group.id')
				->leftjoin('product_img','product_group.id','=','product_img.group_id')
				->whereNull('product.deleted_at')
				->whereNull('brand.deleted_at')
				->whereNull('product_category.deleted_at')
				->whereNull('product_group.deleted_at')
				->where('product.name', 'like', '%'.$whValue.'%');

		if (!empty($brands) && count($brands)) $lists = $lists->whereIn('brand.id',$brands);	
		if (!empty($category)) $lists = $lists->where('product.category_id','=',$category);	
		if (!empty($min)) $lists = $lists->where('product.price','>=',$min);	
		if (!empty($max)) $lists = $lists->where('product.price','<=',$max);	

		$lists = $lists->select(
					'product.id',
					'product.name',
					'product.desc',
					'product.sell_amount',
					'product.price',
					'product_img.img',
					'product_img.thumb'
					)
				->orderBy($orField, $order)
				->distinct('product.id')
				->paginate(4);
		return $lists;
	}

	//商品品牌
	public function productBrand () {
		return Brand::get();
	}

	//商品分类
	public function productCategory () {
		return ProductCategory::get();
	}

	//商品详情页
	public function detail (Request $request, $id) {
		$content = Product::find($id);
		$title = '商品详情';
		return view(config('app.theme').'.home.productDetail')->with(['content'=>$content, 'title'=>$title,'footer'=>'product']);
	}
}
