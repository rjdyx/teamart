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

	const APPID = 'wxdaa4107ed552fdcb';
	const APPSECRET = '449a412c0ac4bc8c8fc275f816c6c794';//微信公众号key
	const MCHID = "1387257002";
	public function payOrder() 
	{	

		$unifiedOrder = Array();
		$url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';//统一下单地址
		$key = 'GuoSenLinMiSiShenQing13632214480';//商户密匙key
		$appid = 'wxdaa4107ed552fdcb';//微信公众号id
		$unifiedOrder["appid"] = $appid;//微信公众号id
		$unifiedOrder["mch_id"] = "1387257002";//商户号
		$unifiedOrder["body"] = "s"; //商品描述
		$unifiedOrder["nonce_str"] = $this->createNoncestr();//随机字符串
		$unifiedOrder["out_trade_no"] ="FX20170".rand(100,1000);//商品订单号 
		$unifiedOrder["total_fee"] = 1;//总金额(单位分)
		$baseUrl = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"].$_SERVER["QUERY_STRING"];
		$unifiedOrder["notify_url"] = $baseUrl;//通知地址 
		$unifiedOrder["spbill_create_ip"] = $_SERVER["REMOTE_ADDR"];//设备ip
		// $unifiedOrder["spbill_create_ip"] = '119.29.34.160';//设备ip
		$unifiedOrder["trade_type"] = "JSAPI";//交易类型(微信内)
		// $unifiedOrder["trade_type"] = "MWEB";//交易类型(H5)
		// $unifiedOrder["trade_type"] = "NATIVE";//交易类型(扫码)
		// $unifiedOrder["openid"] = $this->GetOpenid();//微信openid
		$unifiedOrder["openid"] = 'o7t83wmZOMLxMQuG-eSMOZnePSIE';//微信openid
	    $unifiedOrder["sign"] = $this->getSign($unifiedOrder, $key);//签名

		$xml = $this->arrayToXml($unifiedOrder);
		$returnXml = $this->postXmlCurl($xml,$url);
		$data = json_decode(json_encode(simplexml_load_string($returnXml,'SimpleXMLElement', LIBXML_NOCDATA)),true);
		if ($data['return_code'] != 'SUCCESS') return 'false';
		$data = $this->zycgetSign($data, $key);

		return $data;
		echo "<pre>";
		print_r($data);die;	
	}

	//二次签名
	public function zycgetSign($data, $key)
	{
		$arr = array();
		$rand = $this->createNoncestr();//再次生成随机字符串
		$arr['appid'] = $this::APPID;
		$arr['partnerId'] = $this::MCHID;
		$arr['prepayId'] = $data['prepay_id'];
		$arr['nonceStr'] = $rand;
		$arr['timeStamp'] = time();
		$arr['package'] = "Sign=WXPay";
		$arr['sign'] = $this->getSign($arr, $key);
		return $arr;
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
    	ksort($arr);
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
		ksort($Obj);
		$String = $this->ToUrlParams($Obj);//签名步骤一：按字典序排序参数
		// $String = $this->formatBizQueryParaMap($Parameters, false);//签名步骤一：按字典序排序参数
		$String = $String."&key=".$key;//签名步骤二：在string后加入KEY
		$String = MD5($String);//签名步骤三：MD5加密
		$result = strtoupper($String);//签名步骤四：所有字符转为大写
		// $result = hash_hmac("sha256", $String, $key); //注：HMAC-SHA256签名方式
		return $result;
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
	public function postXmlCurl($xml, $url)
	{	
        //初始化curl        
       	$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
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

	/**
	 * 
	 * 通过跳转获取用户的openid，跳转流程如下：
	 * 1、设置自己需要调回的url及其其他参数，跳转到微信服务器https://open.weixin.qq.com/connect/oauth2/authorize
	 * 2、微信服务处理完成之后会跳转回用户redirect_uri地址，此时会带上一些参数，如：code
	 * 
	 * @return 用户的openid
	 */
	public function GetOpenid()
	{
		//通过code获得openid
		if (!isset($_GET['code'])){
			//触发微信返回code码
			$baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING']);
			$url = $this->__CreateOauthUrlForCode($baseUrl);
			Header("Location:".$url);
			exit();
		} else {
			//获取code码，以获取openid
		    $code = $_GET['code'];
			$openid = $this->getOpenidFromMp($code);
			return $openid;
		}
	}

	/**
	 * 
	 * 构造获取code的url连接
	 * @param string $redirectUrl 微信服务器回跳的url，需要url编码
	 * 
	 * @return 返回构造好的url
	 */
	private function __CreateOauthUrlForCode($redirectUrl)
	{
		$urlObj["appid"] = $this::APPID;
		$urlObj["redirect_uri"] = $redirectUrl;
		$urlObj["response_type"] = "code";
		$urlObj["scope"] = "snsapi_base";
		$urlObj["state"] = "STATE"."#wechat_redirect";
		$bizString = $this->ToUrlParams($urlObj);
		return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
	}

	/**
	 * 
	 * 拼接签名字符串
	 * @param array $urlObj
	 * 
	 * @return 返回已经拼接好的字符串
	 */
	private function ToUrlParams($urlObj)
	{
		$buff = "";
		foreach ($urlObj as $k => $v)
		{
			if($k != "sign"){
				$buff .= $k . "=" . $v . "&";
			}
		}
		
		$buff = trim($buff, "&");
		return $buff;
	}

	/**
	 * 
	 * 通过code从工作平台获取openid机器access_token
	 * @param string $code 微信跳转回来带上的code
	 * 
	 * @return openid
	 */
	public function GetOpenidFromMp($code, $host="0.0.0.0", $port=0)
	{
		$url = $this->__CreateOauthUrlForOpenid($code);
		//初始化curl
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		if($host != "0.0.0.0" && $port!= 0) {
			curl_setopt($ch,CURLOPT_PROXY, $host);
			curl_setopt($ch,CURLOPT_PROXYPORT, $port);
		}
		//运行curl，结果以jason形式返回
		$res = curl_exec($ch);
		curl_close($ch);
		//取出openid
		$data = json_decode($res,true);
		$this->data = $data;
		$openid = $data['openid'];
		return $openid;
	}

	/**
	 * 
	 * 构造获取open和access_toke的url地址
	 * @param string $code，微信跳转带回的code
	 * 
	 * @return 请求的url
	 */
	private function __CreateOauthUrlForOpenid($code)
	{
		$urlObj["appid"] = $this::APPID;
		$urlObj["secret"] = $this::APPSECRET;
		$urlObj["code"] = $code;
		$urlObj["grant_type"] = "authorization_code";
		$bizString = $this->ToUrlParams($urlObj);
		return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
	}

	/**
	 * 错误代码
	 * @param  $code 服务器输出的错误代码
	 * return string
	*/
    public function error_code( $code )
    {
        $errList = array(
            'NOAUTH'                =>  '商户未开通此接口权限',
            'NOTENOUGH'             =>  '用户帐号余额不足',
            'ORDERNOTEXIST'         =>  '订单号不存在',
            'ORDERPAID'             =>  '商户订单已支付，无需重复操作',
            'ORDERCLOSED'           =>  '当前订单已关闭，无法支付',
            'SYSTEMERROR'           =>  '系统错误!系统超时',
            'APPID_NOT_EXIST'       =>  '参数中缺少APPID',
            'MCHID_NOT_EXIST'       =>  '参数中缺少MCHID',
            'APPID_MCHID_NOT_MATCH' =>  'appid和mch_id不匹配',
            'LACK_PARAMS'           =>  '缺少必要的请求参数',
            'OUT_TRADE_NO_USED'     =>  '同一笔交易不能多次提交',
            'SIGNERROR'             =>  '参数签名结果不正确',
            'XML_FORMAT_ERROR'      =>  'XML格式错误',
            'REQUIRE_POST_METHOD'   =>  '未使用post传递参数 ',
            'POST_DATA_EMPTY'       =>  'post数据不能为空',
            'NOT_UTF8'              =>  '未使用指定编码格式'
        ); 
        if( array_key_exists( $code , $errList ) ){
            return $errList[$code];
        }
    }
}
