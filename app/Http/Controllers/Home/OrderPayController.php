<?php 

namespace App\Http\Controllers\Home;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
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

	public static function payOrder() 
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
		// $this->Datas["openid"] = $this->GetOpenid();//微信openid
		$this->Datas["openid"] = 'o7t83wmZOMLxMQuG-eSMOZnePSIE';//微信openid
		$this->Datas["appid"] = $this::APPID;//微信公众号id
		$this->Datas["mch_id"] = $this::MCHID;//商户号
		$this->Datas["body"] = "s"; //商品描述
		$this->Datas["nonce_str"] = $this->createNoncestr();//随机字符串
		$this->Datas["out_trade_no"] ="FX20170".rand(100,1000);//商品订单号 
		$this->Datas["total_fee"] = 1;//总金额(分)
		$this->Datas["notify_url"] = $notify;//通知地址 
		$this->Datas["spbill_create_ip"] = $_SERVER["REMOTE_ADDR"];//设备ip
		$this->Datas["trade_type"] = "JSAPI";//交易类型(H5:'MWEB')
	}

	//二次签名
	public function zycgetSign($res)
	{
		$time = time();//当前时间戳
		$arr["appId"] = $this::APPID;//微信公众号id
		$arr["nonceStr"] = $this->createNoncestr();//随机字符串
		$arr["timeStamp"] = "$time";
		$arr["signType"] = "MD5";
		$arr["package"] = "prepay_id=".$res["prepay_id"];//订单详情扩展字符串	
		$arr["paySign"] = $this->getSign($arr);//生成签名
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

}
