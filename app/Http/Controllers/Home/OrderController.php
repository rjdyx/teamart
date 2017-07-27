<?php

namespace App\Http\Controllers\Home;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\Address;
use App\Site;
use App\Reply;
use App\Cheap;
use App\System;
use App\Delivery;
use App\Comment;
use App\OrderProduct;
use Illuminate\Support\Facades\Auth;
use Redirect;
use IQuery;

class OrderController extends Controller
{
	//订单列表页
	public function index (Request $request) {
		$lists = Order::where('type','order')
		->where('user_id',Auth::user()->id)
		->paginate(config('app.paginate10'));
		$title = '订单管理';
		return view(config('app.theme').'.home.orderList')->with(['footer'=>'order','lists'=>$lists,'title'=>$title]);
	}

	//订单预处理 (未支付)
	public function confirmData (Request $request) 
	{
		$datas = $request->data;
		if (!count($datas)) return 0;
		$order = new Order;
		$order->user_id = Auth::user()->id;
		$order->serial = IQuery::orderSerial();
		$order->type = 'order';
		$order->state = 'pading';
		$order->date = date('Y-m-d');
		$address = Address::where('state',1)->select('id')->first();
		$address_id = 0;
		if (isset($address->id)) $address_id = $address->id;
		$order->address_id = $address_id;

		$order->pid = Auth::user()->pater_id;
		if (!$order->save()) return 500;

		foreach($datas as $id => $amount) {
			$orderProduct = new OrderProduct;
			$orderProduct->product_id = $id;
			$orderProduct->amount = $amount;
			$orderProduct->price = Product::find($id)->price;
			$orderProduct->order_id = $order->id;
			if (!$orderProduct->save()) return 0;
			$this->delCartProduct($id);
		}
		return $order->id;
	}

	//删除购物车商品方法
	public function delCartProduct($product_id)
	{
		$cart = $this->issetCart($product_id);
		if (empty($cart->id)) return 0;
		if (OrderProduct::destroy($cart->id)) return 1;
		return 0;
	}

    //判断购物车商品是否存在
    public function issetCart($product_id)
    {
        $data = OrderProduct::join('order','order_product.order_id','=','order.id')
            ->where('order_product.product_id','=',$product_id)
            ->where('order.type','=','cart')
            ->whereNull('order.deleted_at')
			->whereNull('order_product.deleted_at')
            ->select('order_product.id')
            ->first();
        return $data;
    }

	//待支付 选择参数
	public function confirm (Request $request) 
	{
		$id = $request->id;
		$lists = OrderProduct::join('product','order_product.product_id','=','product.id')
				->leftjoin('activity_product',function($join){
					$join->on('product.id','=','activity_product.product_id')
					->whereNull('activity_product.deleted_at');	
				})
				->leftjoin('activity',function($join){
					$join->on('activity_product.activity_id','=','activity.id')
						->where('activity.date_start','<=',date('Y-m-d H:i:s'))
						->where('activity.date_end','>=',date('Y-m-d H:i:s'))
						->whereNull('activity.deleted_at');
				})
				->where('order_product.order_id','=',$id)
				->whereNull('product.deleted_at')
				->whereNull('order_product.deleted_at')
				->select(
					'product.id','product.name',
					'product.desc','product.thumb','product.price',
					'product.delivery_price','order_product.amount',
					'product.grade','product.state','activity.price as activity_price'
				)
				->distinct('product.id')
				->get();

		
		$delivery_price = System::find(1)->free; //查询包邮金额

		$count = 0; $grade = 1; $d_price = 0;

		foreach ($lists as $list) {
			$price = $list->price;
			if ($list->activity_price) $price = $list->activity_price;//活动商品价格
			$count += $price * $list->amount;//商品总价格
			if (!$list->grade) $grade = 0;//不能使用积分
		}

		$count2 = $count;
		//包邮时 优惠券总价 加入配送价格
		if ($count >= $delivery_price && $delivery_price) {
			$d_price = 1;//包邮
			$count2 = $count + $lists->max('delivery_price'); 
		}

		//查询优惠券
		$cheaps = Cheap::join('cheap_user','cheap.id','=','cheap_user.cheap_id')
		        ->where('cheap.indate','>=',date('Y-m-d H:i:s'))
		        ->where('cheap_user.user_id','=',Auth::user()->id)
		        ->whereNull('cheap.deleted_at')
		        ->whereNull('cheap_user.deleted_at')
		        ->where('cheap.full','<=',$count2)
		        ->select('cheap.*')
		        ->get();

		$title = '确认订单';
		return view(config('app.theme').'.home.confirm')->with(['title'=>$title,'lists'=>$lists,'count'=>$count,'grade'=>$grade,'cheaps'=>$cheaps,'id'=>$id]);
	}

	//检测订单状态
	public function getOrderState($id)
	{
		if (empty($id)) return 0;
		$order = Order::find($id);
		if ($order->state == 'pading') return 1;
		return 0;
	}

	//支付接口
	public function pay (Request $request) 
	{
		$model = Order::find($request->id);
		$model->date = date('Y-m-d H:i:s');
		$model->price = $request->price;
		$model->state = 'paid';
		$model->method = $request->method;
		$model->address_id = $request->address_id;
		$model->memo = $request->memo;
		if ($model->save()) return 1;
		return 0;
	}

	//订单列表数据
	public function orderListData(Request $request)
	{
		$datas = Order::where('type','order');

		$state = $request->state;//订单状态
		$serial = $request->serial;//订单号
		if ($state) {
			if ($state == 'self'){
				$datas = $datas->where('order.method','=','self')
						->where('order.state','=','paid');
			}else if ($state == 'paid'){
				$datas = $datas->where('order.method','!=','self')
						->where('order.state','=','paid');
			}else{
				$datas = $datas->where('order.state','=',$state);
			}
		}
		if ($serial) $datas = $datas->where('order.serial','like','%'.$serial.'%');

		$datas = $datas->select('id')->paginate(10);

		$arrs = array();
		foreach ($datas as $data) {
			$res = $this->orderListProducts($data->id);
			if (count($res)) {
				$arrs[$data->id] = $res;
			}
		}
		return $arrs;
	}

	public function orderListProducts($id) 
	{
		$datas = Order::where('order.user_id','=',Auth::user()->id)
				->join('order_product','order.id','=','order_product.order_id')
				->join('product','order_product.product_id','=','product.id')
				->where('order.id','=',$id)
				->where('order.type','=','order')
				->whereNull('product.deleted_at')
				->whereNull('order_product.deleted_at')
				->whereNull('order.deleted_at')
				->select(
					'order_product.amount as order_amount',
					'order_product.price as order_product_price',
					'order.serial','order.id as order_id','order.updated_at as order_date','order.price as order_price',
					'order.state as order_state','order.method as order_method','order.type as order_type',
					'product.*'
					)
				->distinct('order_product.id')
				->get();
		return $datas;
	}

	//查看订单物流
	public function showDelivery($order_id)
	{
		$title = "物流信息";
		$lists = OrderProduct::where('order_product.order_id','=',$order_id)
				->join('product','order_product.product_id','=','product.id')
				->join('order','order_product.order_id','=','order.id')
				->where('order.user_id','=',Auth::user()->id)
				->select('product.thumb','product.price as raw_price',
					'product.name','product.desc','order.delivery_serial',
					'order_product.amount','order_product.price'
				)->get();

		$data = Order::where('order.user_id','=',Auth::user()->id)->find($order_id);

		return view(config('app.theme').'.home.orderDelivery')
				->with(['title' => $title,'lists'=>$lists,'data'=>$data]);
	}

	//查看物流信息
	public function deliveryData(Request $request)
	{
		$id = $request->id;
		$code = $request->code;
		$coding = $request->coding;
		//判断是否从数据库取出数据
		$data = Order::find($id);
		$result = Delivery::where('order_id',$id)->get();
		if (count($result)) return $result;
		$result =  json_decode(IQuery::getOrderTracesByJson($code, $coding),true)['Traces'];
		return $result;
	}

	//订单评论
	public function orderComment($order_id){
		$order = Order::find($order_id);
		$state = isset($order->state)?$order->state:'';
		if ($state != 'take') return Redirect::to('/home/order/list');
		return view(config('app.theme').'.home.orderComment')->with(['id'=>$order_id]);
	}

	//获取订单商品
	public function getOrderProduct($id)
	{
		$data = OrderProduct::join('product','order_product.product_id','=','product.id')
				->where('order_product.order_id',$id)
				->select('product.price','product.thumb',
					'product.name','product.desc','product.id',
					'order_product.amount','order_product.price as order_price'
				)->get();
		return $data;
	}

	//评论处理
	public function commentStore(Request $request, $id)
	{
        //获取订单商品
        $goods = $this->getOrderProduct($id);
		foreach ($goods as $good) {
			$imgs = $this->imgComment ($request, $good->id);
			$model = new Comment;
			$model->product_id = $good->id;
			$model->order_id = $id;
			$model->user_id = Auth::user()->id;
			$model->grade = $request->input('grade'.$good->id) * 20;
			$model->content = $request->input('content'.$good->id);
			$model->img = $imgs['img'];
			$model->thumb = $imgs['thumb'];
			if (!$model->save()) return 0;
		}

		$order = Order::find($id);
		$order->state = 'close';
		if ($order->save())	return 1;
		return 0;
	}

	public function imgComment ($request, $id) {
		$datas = array('img'=>'','thumb'=>'');
		$imgs = $thumbs = array();
		//资源、上传图片名称、是否生成缩略图
        $pics = IQuery::uploads($request, 'imgs'.$id, true);
		if ($pics != 'false') {
            foreach ($pics as $pic) {
                $imgs[] = $pic['pic'];
                $thumbs[] = $pic['thumb'];
            }
            $datas['img'] = implode(',', $imgs);
            $datas['thumb'] = implode(',', $thumbs);
        }
        return $datas;
	}

	//订单state改变
	public function orderOperate(Request $request, $state)
	{
		$order = Order::find($request->id);
		$order->state = $state;
		if ($state == 'backn') {
			$order->reason = $request->reason.'&'.$request->desc;
		}
		if ($order->save()) return 200;
		return 500;
	}

	//退货理由
	public function backnReason($id)
	{
		$title = "订单退货";
		return view(config('app.theme').'.home.order.backn_reason')
				->with(['title' => $title,'id'=>$id]);
	}

	// 订单详情
	public function orderDetail ($id) {
		$title = "订单详情";
		$order = Order::leftjoin('address','order.address_id','=','address.id')
				->where('order.id','=',$id)
				->select('order.*','address.name as aname',
					'address.province as p1','address.city as p2',
					'address.area as p3','address.detail as p4',
					'address.phone','address.code'
				)->first();

		if (!count($order)) return Redirect::back();//订单无效
		if ($order->user_id != Auth::user()->id) return Redirect::back();//订单无效

		$goods = Product::join('order_product','product.id','=','order_product.product_id')
				->where('order_product.order_id','=',$id)
				->whereNull('product.deleted_at')
				->whereNull('order_product.deleted_at')
				->distinct('product.id')
				->select('product.name','product.desc',
					'product.thumb','product.id',
					'product.price as raw_price',
					'order_product.amount','order_product.price'
				)->get();

		$datas = array();
		foreach ($goods as $k=>$good) {
			$datas[$k] = $good;
			$datas[$k]['comment'] = $this->detailComment($good->id, $id);
			$cid = isset($datas[$k]['comment']->id)?$datas[$k]['comment']->id:'';
			$datas[$k]['replys'] = $this->commentReply($cid);
		}

		return view(config('app.theme').'.home.order.detail')
				->with(['title' => $title,'order'=>$order,'datas'=>$datas]);
	}

	public function detailComment($id, $order_id)
	{
		if (empty($id)) return null;
		return  Comment::where('order_id',$order_id)->find($id);
	}

	public function commentReply($id)
	{
		if (empty($id)) return null;
		$datas = Reply::join('user as ua','reply.auser_id','=','ua.id')
				->join('user as ub','reply.buser_id','=','ub.id')
				->whereNull('reply.deleted_at')
				->where('reply.comment_id',$id)
				->select('reply.*','ua.name as aname','ub.name as bname')
				->orderBy('reply.created_at','asc')
				->get();
		return $datas;
	}

	public function payOrder() 
	{		
		$unifiedOrder = Array();
		$key = '449a412c0ac4bc8c8fc275f816c6c794';
		$url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
		$unifiedOrder["appid"] = 'wxdaa4107ed552fdcb';//微信公众号id
		$unifiedOrder["mch_id"] = 1387257002;//商户号
		$unifiedOrder["body"] = '微信购买'; //商品描述
		$unifiedOrder["nonce_str"] = $this->createNoncestr();//随机字符串
	    $unifiedOrder["sign"] = $this->getSign($unifiedOrder, $key);//签名
		$unifiedOrder["out_trade_no"] ='FX201702012336';//商品订单号 
		$unifiedOrder["total_fee"] = 0.01;//总金额
		$unifiedOrder["notify_url"] = 'www.fx.com';//通知地址 
		$unifiedOrder["trade_type"] = "MWEB";//交易类型
		$xml = $this->arrayToXml($unifiedOrder);
		$returnXml = $this->postXmlCurl($xml,$url);
		$arr = json_decode(json_encode(simplexml_load_string($returnXml,'SimpleXMLElement', LIBXML_NOCDATA)),true);
		echo "<pre>";
		print_r($arr);die;	
	}

	//产生随机字符串，不长于32位
	public function createNoncestr( $length = 32 ) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
		$str ="";
		for ( $i = 0; $i < $length; $i++ )  {  
			$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
		}  
		return $str;
	}

	//array转xml
	public function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val) {
        	if (is_numeric($val)) {
        	 	$xml.="<".$key.">".$val."</".$key.">"; 
        	}else{
				$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
			}  
        }
        $xml.="</xml>";
        return $xml;
    }

	//生成签名
	public function getSign($Obj, $key)
	{
		foreach ($Obj as $k => $v) {
			$Parameters[$k] = $v;
		}
		//签名步骤一：按字典序排序参数
		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		//签名步骤二：在string后加入KEY
		$String = $String."&key=".$key;
		//签名步骤三：MD5加密
		$String = md5($String);
		//签名步骤四：所有字符转为大写
		$result_ = strtoupper($String);
		return $result_;
	}

	//格式化参数，签名过程需要使用
	public function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = "";
		ksort($paraMap);
		foreach ($paraMap as $k => $v)
		{
		    if($urlencode)
		    {
			   $v = urlencode($v);
			}
			//$buff .= strtolower($k) . "=" . $v . "&";
			$buff .= $k . "=" . $v . "&";
		}
		$reqPar;
		if (strlen($buff) > 0) 
		{
			$reqPar = substr($buff, 0, strlen($buff)-1);
		}
		return $reqPar;
	}

	//以post方式提交xml到对应的接口url
	public function postXmlCurl($xml, $url, $second=30)
	{	
        //初始化curl        
       	$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		//post提交方式
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		
        $data = curl_exec($ch); //运行curl

		//返回结果
		if($data) {
			// curl_close($ch);
			return $data;
		} else { 
			$error = curl_errno($ch);
			echo "curl出错，错误码:$error"."<br>"; 
			echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
			curl_close($ch);
			return false;
		}
	}
}
