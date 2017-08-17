<?php

/*
 * @version: 0.1 查询工具类范例
 * @author: gsl
 * @date: 2017/06/08
 * @description:公共调用方法
 *
 */
namespace app\Utils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Log;
use App\System;
use ReflectionClass;
use Session;
use DB;

class IQuery{

    protected $Inits = array();//存放公众号相关数据

    //图片异步上传
    public function upload($request, $file_pic='img', $minState=true, $obj, $delId=-1)
    {
        if (!$request->hasFile($file_pic)) return ['pic'=>null,'thumb'=>null];
        if ($delId != -1) $this::destroyPic($obj, $delId, $file_pic);
        return $this->uploadOrs($request->file($file_pic), $minState);
    }

    //多图片异步上传
    public function uploads($request, $pics='imgs', $minState=true)
    {         
        $imgs = array();
        $files = $request->file($pics);
        if (!empty($files) && count($files) && is_array($files)) {
            foreach ($files as $k => $file) {
                $imgs[$k] = $this->uploadOrs($file, $minState);
            }
            return $imgs;
        }
        return 'false';
    }

    //图片上传方法
    public function uploadOrs($file, $minState)
    {
        $res = ['pic'=>null,'thumb'=>null];
        $path = config('app.image_path');
        $Extension = $file->getClientOriginalExtension();
        $filename = 'FX_'.time().rand(1,9999).'.'. $Extension;
        $check = $file->move($path, $filename);
        $filePath = $path.$filename; //原图路径加名称
        $res['pic']= $filePath;//原图
        if($minState) {
            $newfilePath = $path.'FX_S_'.time().rand(1,9999).'.'. $Extension;//缩略图路径名称
            $this->img_create_small($filePath,config('app.thumb_width'),config('app.thumb_height'),$newfilePath);  //生成缩略图
            $res['thumb'] = $newfilePath;//缩略图
        }
        return $res;//返回原图 缩略图 的路径 数组
    }

    //生成缩略图
    public function img_create_small($big_img, $width, $height, $small_img) 
    {  
        //原始大图地址，缩略图宽度，高度，缩略图地址
        $imgage = getimagesize($big_img); //得到原始大图片
        switch ($imgage[2]) { // 图像类型判断
        case 1:
        $im = imagecreatefromgif($big_img);
        break;
        case 2:
        $im = imagecreatefromjpeg($big_img);
        break;
        case 3:
        $im = imagecreatefrompng($big_img);
        break;
        }
        $src_W = $imgage[0]; //获取大图片宽度
        $src_H = $imgage[1]; //获取大图片高度
        $tn = imagecreatetruecolor($width, $height); //创建缩略图
        imagecopyresampled($tn, $im, 0, 0, 0, 0, $width, $height, $src_W, $src_H); //复制图像并改变大小
        imagejpeg($tn, $small_img); //输出图像
    }
    
    //删除图片方法
    public function destroyPic($class,$id,$image='img') {
        $p = $class::where('id','=',$id)->first();
        if($image=='img') {
            if (empty($p->img) || empty($p->thumb)) return 'false';
            $img = str_replace("\\","/",public_path().'/'.$p->img);
            $thumb = str_replace("\\","/",public_path().'/'.$p->thumb);
            if (is_file($img)) unlink($img);
            if (is_file($thumb))  unlink($thumb); 
        }
        else {
            if (empty($p->$image)) return 'false';
            $img = str_replace("\\","/",public_path().'/'.$p->$image);
            if (is_file($img)) unlink($img); 
        }
        return 'true';
    }
    
    //加入日志
    public function ofLog($module, $operate)
    {
        $log = new Log;
        $log->table = $module;
        $log->operate = $operate;
        $log->ip = $_SERVER["REMOTE_ADDR"];
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)){
            $log->user_id = Auth::user()->id;
        }
        $log->save();
    }

    //生成订单号
    public function orderSerial()
    {
        $date = date('Ymd');
        $rand = rand(99999,999999);
        $per = 'Fx';
        return $per.$date.$rand;
    }


    /**
     * Json方式 查询订单物流轨迹
     * $code 订单号 (可缺省)
     * $order 物流单号
     */
    function getOrderTracesByJson($code, $coding = "STO", $order=0)
    {
        $system = System::find(1);
        if (empty($system->delivery_id)) return false;
        $ID = $system->delivery_id;//商户id
        $key = $system->delivery_key;//API key
        $url = 'http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx';//请求地址
        $requestData="{'OrderCode':'".$order."','ShipperCode':'".$coding."','LogisticCode':'".$code."'}";
        $datas = array(
            'EBusinessID' => $ID,
            'RequestType' => '1002',
            'RequestData' => urlencode($requestData) ,
            'DataType' => '2',
        );
        $datas['DataSign'] = $this->encrypt($requestData, $key);
        $result = $this->sendPost($url, $datas);   
        //根据公司业务处理返回的信息......
        return $result;
    }

    /**
     * 电商Sign签名生成
     * @param data 内容   
     * @param appkey Appkey
     * @return DataSign签名
     */
    function encrypt($data, $appkey) {
        return urlencode(base64_encode(md5($data.$appkey)));
    }
    /**
     *  post提交数据 
     * @param  string $url 请求Url
     * @param  array $datas 提交的数据 
     * @return url响应返回的html
     */
    function sendPost($url, $datas) {
        $temps = array();   
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);      
        }   
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
        if(empty($url_info['port']))
        {
            $url_info['port']=80;   
        }
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader.= "Host:" . $url_info['host'] . "\r\n";
        $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader.= "Connection:close\r\n\r\n";
        $httpheader.= $post_data;
        $fd = fsockopen($url_info['host'], $url_info['port']);
        fwrite($fd, $httpheader);
        $gets = "";
        $headerFlag = true;
        while (!feof($fd)) {
            if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
                break;
            }
        }
        while (!feof($fd)) {
            $gets.= fread($fd, 128);
        }
        fclose($fd);  
        return $gets;
    }

    //获取微信 openid
    public function GetOpenid()
    {
        $res = $this->getWXdata("snsapi_base");
        return $res['openid'];
    }

    //获取微信 data
    public function GetwxInfo()
    {
        return $this->getWXdata("snsapi_userinfo");
    }

    public function getWXdata($scope)
    {
        $this->setInit();
        //通过code获得openid
        if (!isset($_GET['code'])){
            //触发微信返回code码
            $baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING']);
            $url = $this->__CreateOauthUrlForCode($baseUrl, $scope);
            Header("Location:".$url);
            exit();
        } else {
            //获取code码，以获取openid
            $code = $_GET['code'];
            return $this->getOpenidFromMp($code);
        }    
    }

    //设置参数
    public function setInit()
    {
        //查询参数
        $system = System::find(1);
        $this->Inits['appid'] = empty($system->wx_appid)? config('app.wx_appid'): $system->wx_appid;
        $this->Inits['appsecret'] = empty($system->wx_appsecret)? config('app.wx_appsecret'):$system->wx_appsecret;
    }

    /**
     * 构造获取code的url连接
     * @param string $redirectUrl 微信服务器回跳的url，需要url编码
     * @return 返回构造好的url
     */
    private function __CreateOauthUrlForCode($redirectUrl, $scope)
    {
        $urlObj["appid"] = $this->Inits['appid'];
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
        // $urlObj["scope"] = "snsapi_base";
        $urlObj["scope"] = $scope;
        $urlObj["state"] = "STATE"."#wechat_redirect";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
    }

    /**
     * 拼接签名字符串
     * @param array $urlObj
     * @return 返回已经拼接好的字符串
     */
    public function ToUrlParams($urlObj)
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
     * 通过code从工作平台获取openid机器access_token
     * @param string $code 微信跳转回来带上的code
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
        $data = json_decode($res, true);
        return $data;
        // return $data['openid'];
    }

    /**
     * 构造获取open和access_toke的url地址
     * @param string $code，微信跳转带回的code
     * @return 请求的url
     */
    private function __CreateOauthUrlForOpenid($code)
    {
        $urlObj["appid"] = $this->Inits['appid'];
        $urlObj["secret"] = $this->Inits['appsecret'];
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
    }


    //获取微信用户信息
    public function getWeixin() 
    { 
        $res = $this->GetwxInfo();
        $token = $res['access_token'];
        $openid = $res['openid'];
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$token.'&openid='.$openid.'&lang=zh_CN';
        return $this->getJson($url);
    }

    //获取信息 发送请求
    public function getJson($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
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

    /*移动端判断*/
    public function isMobile()
    { 
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        {
            return 1;
        } 
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']))
        { 
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? 1 : 0;
        } 
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
                ); 
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return 1;
            } 
        } 
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT']))
        { 
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return 1;
            } 
        } 
        return 0;
    } 
}