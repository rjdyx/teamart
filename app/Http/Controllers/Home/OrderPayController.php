<?php 

namespace App\Http\Controllers\Home;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\System;
use App\OrderProduct;
use Illuminate\Support\Facades\Auth;
use Redirect;
use IQuery;

class OrderPayController extends Controller
{
	const URL = "https://api.mch.weixin.qq.com/pay/unifiedorder"; //统一下单地址
	protected $Datas = array();
	protected $Inits = array();

	//预支付
	public function payOrder(Request $request) 
	{	
		/***** 0.判断订单正确 *****/
		$ck = $this->checkOrder ($request);
		if (!$ck['state']) return $ck;

		/***** 1.初始化 *****/
		$this->setInit($request);

		/***** 2.签名 *****/
	    $this->Datas["sign"] = $this->getSign();

	    /***** 3.转换格式 (数组->XML) *****/
		$xml = $this->arrayToXml($this->Datas);

		/***** 4.统一下单请求 *****/
		$returnXml = $this->postXmlCurl($xml, $this::URL);

		/***** 5.返回结果处理 *****/
		$res = json_decode(json_encode(simplexml_load_string($returnXml,'SimpleXMLElement', LIBXML_NOCDATA)),true);
		if ($res['return_code'] != 'SUCCESS') {
			return ['state'=>1,'data'=> $res['return_msg']];
		}

		/***** 6.再次签名 *****/
		$res = $this->zycgetSign($res);
		// return ['state'=>1,'data'=>$res];
		return $res;
	}

	//判断订单状态
	public function checkOrder ($request) {
		$order = Order::find($request->id);
		if (!isset($order->state)) return ['state'=>0,'data'=>'订单不存在!'];
		if ($order->state == 'paid') return ['state'=>0,'data'=>'该订单已支付!'];
		if ($order->state != 'pading') return ['state'=>0,'data'=>'该订单不能支付!'];
		return ['state'=>1];
	}

	//查询数据 设置数组 Inits
	public function setInit($request)
	{
		//查询系统参数
		$system = System::find(1);
		//查询订单
		$order = Order::select('serial')->find($request->id);
		//设置常量
		$this->Inits['appid'] = empty($system->wx_appid)? config('app.wx_appid'): $system->wx_appid;
		$this->Inits['mch_id'] = empty($system->wx_mchid)? config('app.wx_mchid'): $system->wx_mchid;
		$this->Inits['app_secret'] = empty($system->wx_appsecret)? config('app.wx_appsecret'): $system->wx_appsecret;
		$this->Inits['key'] = empty($system->wx_key)? config('app.wx_key'): $system->wx_key;
		$this->Inits['notify_url'] = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"].$_SERVER["QUERY_STRING"];
		$this->Inits['openid'] = $request->openid;
		$this->Inits['total_fee'] = $request->price * 100;
		$this->Inits['spbill_create_ip'] = $_SERVER["REMOTE_ADDR"];
		$this->Inits['body'] = "广州茶沁轩出售";
		$this->Inits['out_trade_no'] = $order->serial;
		$this->Inits['trade_type'] = "JSAPI";
		$this->setSpce();
	}

	//初始化参数设置
	public function setSpce()
	{
		$this->Datas["openid"] = $this->Inits['openid']; //微信openid
		$this->Datas["appid"] = $this->Inits['appid']; //微信公众号id
		$this->Datas["mch_id"] = $this->Inits['mch_id']; //商户号
		$this->Datas["body"] = $this->Inits['body']; //商品描述
		$this->Datas["out_trade_no"] = $this->Inits['out_trade_no']; //商品订单号 
		$this->Datas["total_fee"] = $this->Inits['total_fee'];//总金额(分)
		$this->Datas["notify_url"] = $this->Inits['notify_url'];//通知地址 
		$this->Datas["spbill_create_ip"] = $this->Inits['spbill_create_ip'];//设备ip
		$this->Datas["trade_type"] = $this->Inits['trade_type'];//交易类型(H5:'MWEB')
		$this->Datas["nonce_str"] = $this->Noncestr(); //随机字符串
	}

	//二次签名
	public function zycgetSign($res)
	{
		$time = time();//当前时间戳
		$arr["appId"] = $this->Inits['appid'];//微信公众号id
		$arr["nonceStr"] = $this->Noncestr();//随机字符串
		$arr["timeStamp"] = "$time";
		$arr["signType"] = "MD5";
		$arr["package"] = "prepay_id=".$res["prepay_id"];//订单详情扩展字符串	
		$arr["paySign"] = $this->getSign($arr);//生成签名
		return json_encode($arr);
	}

	//产生随机字符串，不长于32位
	public function Noncestr( $length = 32 ) 
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
        foreach ($arr as $k => $v) {
        	if (is_numeric($v)) {
        	 	$xml.="<".$k.">".$v."</".$k.">"; 
        	}else{
				$xml.="<".$k."><![CDATA[".$v."]]></".$k.">";
			}  
        }
        $xml.="</xml>";
        return $xml;
    }

	//生成签名
	public function getSign($Obj = null)
	{	
		if ($Obj == null) $Obj = $this->Datas;
		ksort($Obj);
		$String = IQuery::ToUrlParams($Obj);//签名步骤一：按字典序排序参数
		$String = $String."&key=".$this->Inits['key'];//签名步骤二：在string后加入KEY
		$String = MD5($String);//签名步骤三：MD5加密
		$result = strtoupper($String);//签名步骤四：所有字符转为大写
		return $result;
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

}
