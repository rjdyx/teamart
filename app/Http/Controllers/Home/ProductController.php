<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductImg;
use App\ProductCategory;
use App\Brand;
use App\Comment;
use App\Reply;
use App\Order;
use Illuminate\Support\Facades\Auth;
use IQuery;

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
				->whereNull('product.deleted_at')
				->whereNull('brand.deleted_at')
				->whereNull('product_category.deleted_at')
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
					'product.img',
					'product.thumb',
					'product.state',
					'product.stock'
					)
				->orderBy($orField, $order)
				->distinct('product.id')
				->paginate(10);

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
		$content = $this->productContent($id);
		$specs = $this->productSpecs($content->group_id);
		$imgs = ProductImg::where('group_id',$content->group_id)->get();
		$title = '商品详情';

		$commentA = Comment::where('product_id',$id)->where('grade','>','60')->count();
		$commentB = Comment::where('product_id',$id)->where('grade','=','60')->count();
		$commentC = Comment::where('product_id',$id)->where('grade','<','60')->count();
		$commentImg = Comment::where('product_id',$id)->whereNotNull('img')->count();
		$commentAmount = Comment::where('product_id',$id)->count();

		//查询商品是否被收藏
		$collect = Order::join('order_product','order.id','=','order_product.order_id')
					->where('type','=','collect')
					->where('order_product.product_id','=',$id)
					->whereNull('order_product.deleted_at')
					->select('order.id')
					->first();

		return view(config('app.theme').'.home.productDetail')->with(['imgs'=>$imgs,'specs'=>$specs,'content'=>$content, 'title'=>$title,'footer'=>'product','commentA'=>$commentA,'commentB'=>$commentB,'commentC'=>$commentC,'commentImg'=>$commentImg,'commentAmount'=>$commentAmount,'collect'=>$collect]);
	}

	//查询商品参数(详情页加入购物车)
	public function productAddCartData($id)
	{
		$content = $this->productContent($id);
		$specs = $this->productSpecs($content->group_id);
		return ['specs'=>$specs, 'content'=>$content];
	}

	//查询规格
	public function productSpecs($id)
	{
		$specs = Product::join('spec','product.spec_id','=','spec.id')
					->where('product.group_id','=',$id)
					->distinct('spec.id')
					->select('product.id','spec.name')
					->get();
		return $specs;
	}

	//查询商品详情
	public function productContent($id)
	{
		$data = Product::join('product_group','product.group_id','=','product_group.id')
					->where('product.id','=',$id)
					->select('product.*','product_group.desc as gdesc')
					->first();
		return $data;
	}

	//查询商品评论
	public function productComment(Request $request, $product_id)
	{
		$datas = array();
		$comments = Comment::join('user','comment.user_id','=','user.id')
			->where('comment.product_id',$product_id);

		if ($request->grade) {
			if ($request->grade == 'A') $fh = '>';
			if ($request->grade == 'B') $fh = '=';
			if ($request->grade == 'C') $fh = '<';
			if ($request->grade == 'Img') {
				$comments = $comments->whereNotNull('comment.img');
			} else {
				$comments = $comments->where('comment.grade',$fh,'60');
			}
		}

		$comments = $comments->select('comment.*','user.thumb as user_img','user.name as user_name')->paginate(5);

		foreach ($comments as $k => $comment) {
			$replys = Reply::join('user as auser','reply.auser_id','=','auser.id')
					->join('user as buser','reply.auser_id','=','buser.id')
					->where('reply.comment_id',$comment->id)
					->select('reply.*','auser.name as aname','buser.name as bname')
					->orderBy('reply.created_at','asc')
					->get();
			$imgs = empty($comment->img)?null:$comment->img;
			$thumbs = empty($comment->thumb)?null:$comment->thumb;
			$datas[$k] = $comment;
			$datas[$k]['img'] = $imgs;
			$datas[$k]['thumb'] = $thumbs;
			$datas[$k]['replys'] = $replys;
		}
		return $datas;
	}
}
