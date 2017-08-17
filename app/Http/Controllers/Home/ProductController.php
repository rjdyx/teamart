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
use App\OrderProduct;
use App\Spec;
use App\Address;
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
				->join('spec','product.id','=','spec.product_id')
            	->where('spec.state','=',1)
				->whereNull('spec.deleted_at')
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
					'product.img',
					'product.thumb',
					'product.state',
					'product.stock',
					'spec.price'
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
		$specs = $this->productSpecs($id);
		$imgs = ProductImg::where('product_id',$id)->get();
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
		$specs = $this->productSpecs($id);
		return ['specs'=>$specs, 'content'=>$content];
	}

	//查询规格
	public function productSpecs($id)
	{
		return Spec::where('product_id',$id)->get();
	}

	//查询商品详情
	public function productContent($id)
	{
		$data = Product::join('spec','product.id','=','spec.product_id')
            	->where('spec.state','=',1)
				->where('product.id','=',$id)
				->whereNull('product.deleted_at')
				->whereNull('spec.deleted_at')
				->select('product.*','spec.price')
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

	//加入购物车
	public function addCart(Request $request)
	{
		$id = $request->id;
		$spec_id = $request->spec_id;
		$amount = $request->amount;
		$data = $this->isCartProduct($id,$spec_id);//是否存在购物车中
		if(isset($data->id)) {
			$md = OrderProduct::find($data->id);
			$md->amount = $md->amount + $amount;
			$md->price = $this->specPrice($spec_id) * $md->amount;
			if(!$md->save()) return 0;
		} else {
			$model = new OrderProduct;
			$model->spec_id = $spec_id;
			$model->price = $this->specPrice($spec_id) * $amount;
			$model->product_id = $id;
			$model->amount = $amount;
			$isCart = $this->isCartOrder(); //是否有购物车订单
			if (!isset($isCart->id)){
				$res = $this->newCartOrder();
				$model->order_id = $res->id;
			} else {
				$model->order_id = $isCart->id;
			}
			if(!$model->save()) return 0;
		}
		return 1;
	}

	//查询是否存在购物车订单
	public function isCartOrder()
	{
		return Order::where('user_id',Auth::user()->id)->where('type','cart')->first();
	}

	//查询规格价格
	public function specPrice($id)
	{
		return Spec::find($id)->price;
	}

	//查询购物车是否存在此商品
	public function isCartProduct($id,$sid)
	{
		$data = OrderProduct::join('order','order_product.order_id','=','order.id')
			->where('order_product.product_id',$id)
			->where('order.type','cart')
			->where('order_product.spec_id',$sid)
			->where('order_product.id')
			->first();
		return $data;
	}

	//新建购物车订单
	public function newCartOrder($type='cart')
	{
		$order = new Order;
		$order->user_id = Auth::user()->id;
		$order->serial = IQuery::orderSerial();
		$order->type = $type;
		$order->date = date('Y-m-d');
		$address = Address::where('state',1)->select('id')->first();
		$address_id = 0;
		if (isset($address->id)) $address_id = $address->id;
		$order->address_id = $address_id;
		$order->pid = Auth::user()->pater_id;
		if ($type=='order') $order->state = 'pading';
		if (!$order->save()) return 500;
		return $order->id;
	}

	//立即购买 预支付
	public function addOrder(Request $request)
	{
		$id = $request->id;
		$spec_id = $request->spec_id;
		$amount = $request->amount;
		$order_id = $this->newCartOrder('order');
		$md = new OrderProduct;
		$md->product_id = $id;
		$md->spec_id = $spec_id;
		$md->order_id = $order_id;
		$md->price = $this->specPrice($spec_id) * $amount;
		$md->amount = $amount;
		if (!$md->save()) return 0;
		$order = Order::find($order_id);
		$order->price = $md->price;
		if (!$order->save()) return 0;
		return $order_id;
	}
}
