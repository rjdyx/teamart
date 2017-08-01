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

class OrderPayController extends Controller
{
	const APPID = 'wxdaa4107ed552fdcb';//微信公众号id
	const APPSECRET = '449a412c0ac4bc8c8fc275f816c6c794';//微信公众号key
	const MCHID = "1387257002";//商户号
	const KEY = "GuoSenLinMiSiShenQing13632214480";//商户密匙key
	const URL = "https://api.mch.weixin.qq.com/pay/unifiedorder";//统一下单地址
	protected $Datas = array();

	public function payOrder() 
	{	
		/***** 1.初始化 *****/
		$this->setSpce();

		/***** 2.签名 *****/
	    $this->Datas["sign"] = $this->getSign();

	    /***** 3.转换格式 (数组->XML) *****/
		$xml = $this->arrayToXml($this->Datas);

		/***** 4.统一下单请求 *****/
		$returnXml = $this->postXmlCurl($xml, $this::URL);

		/***** 5.返回结果处理 *****/
		$res = json_decode(json_encode(simplexml_load_string($returnXml,'SimpleXMLElement', LIBXML_NOCDATA)),true);
		if ($res['return_code'] != 'SUCCESS') return 'false';

		/***** 6.再次签名 *****/
		return $this->zycgetSign($res);
	}

	//初始化参数设置
	public function setSpce()
	{
		$notify = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"].$_SERVER["QUERY_STRING"];
		$this->Datas["appid"] = $this::APPID;//微信公众号id
		$this->Datas["mch_id"] = $this::MCHID;//商户号
		$this->Datas["body"] = "s"; //商品描述
		$this->Datas["nonce_str"] = $this->createNoncestr();//随机字符串
		$this->Datas["out_trade_no"] ="FX20170".rand(100,1000);//商品订单号 
		$this->Datas["total_fee"] = 1;//总金额(分)
		$this->Datas["notify_url"] = $notify;//通知地址 
		$this->Datas["spbill_create_ip"] = $_SERVER["REMOTE_ADDR"];//设备ip
		$this->Datas["trade_type"] = "JSAPI";//交易类型(H5:'MWEB')
		// $this->Datas["openid"] = $this->GetOpenid();//微信openid
		$this->Datas["openid"] = 'o7t83wmZOMLxMQuG-eSMOZnePSIE';//微信openid
	}

	//二次签名
	public function zycgetSign($res)
	{
		// $this->Datas['appId'] = $this::APPID;//微信公众号id
		// $this->Datas['nonceStr'] = $this->createNoncestr();//随机字符串
		// $this->Datas['timeStamp'] = time();//当前时间戳
		// $this->Datas['signType'] = "MD5";
		// $this->Datas['package'] = 'prepay_id='.$res['prepay_id'];//订单详情扩展字符串
		// $this->Datas['paySign'] = $this->getSign();//生成签名	
		// return json_encode($this->Datas);

		$arr = array();	
		$arr['appid'] = $this::APPID;//商户号
		$arr['partnerid'] = $this::MCHID;//商户号
		$arr['prepayid'] = $res['prepay_id'];//预支付id
		$arr['package'] = 'Sign=WXPay';//扩展字段
		$arr['noncestr'] = $this->createNoncestr();//随机字符串
		$arr['timestamp'] = time();//当前时间戳
		$arr['sign'] = $this->getSign($arr);//生成签名	
		return json_encode($arr);
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
		$String = $this->ToUrlParams($Obj);//签名步骤一：按字典序排序参数
		$String = $String."&key=".$this::KEY;//签名步骤二：在string后加入KEY
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
