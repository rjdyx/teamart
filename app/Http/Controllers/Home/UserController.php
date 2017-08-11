<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Order;
use App\OrderProduct;
use App\User;
use App\System;
use App\Brokerage;
use IQuery;
use Session;

class UserController extends Controller
{
	//个人中心 用户相关信息
	public function userInfo () {
		$prices = 0;
		$sells = 0;
		if (Auth::user()){
			//消费总额
			$prices = Order::where('user_id','=',Auth::user()->id)
				->where('order.type','=','order') 
				->where('order.state','!=','pading') 
				->select('price')->count();
			//佣金计算
			if (Auth::user()->type == 1){
				$sells = $this->brokerage();//累计金额
			}
		}
		$title = '个人中心';
		$footer = 'user';
		return view(config('app.theme').'.home.userCenter')->with(['sells'=>$sells,'prices'=>$prices,'title'=>$title,'footer'=>$footer]);
	}

	//个人资产
	public function userAsset (Request $request) 
	{
		$data = Brokerage::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->first();
		$check = 'false'; 
		$await = 0;
		if (!empty($data)) {
			$check = $data->created_at;
			$await = $data->remain;
		}
		$allprices = $this->brokerage();//累计金额
		$prices = $this->brokerage($check) + $await;//可提现余额
		$title = '个人资产';
		$datas = ['data'=>$data,'title'=>$title,'allprices'=>$allprices,'prices'=>$prices];
		if (session('webType') == 1){ //客户端是否为微信浏览器
			$res = $this->snsWx($request);
			$datas['appid'] = $res['appid'];
			$datas['noncestr'] = $res['noncestr'];
			$datas['timestamp'] = $res['timestamp'];
			$datas['sign'] = $res['sign'];
		}
		return view(config('app.theme').'.home.userAssets')->with($datas);
	}

    //分享
    public function snsWx($request)
    {   
        // 获取access_token
        if (empty(session('access_token')) || (time() - session('token_time') >= 7200)) {
            $access_token = $this->getToken();       
            //缓存token
            $request->session()->put('access_token', $access_token);
            $request->session()->put('token_time', time());
        }

        // 获取jsapi_ticket
        if (empty(session('jsapi_ticket')) || (time() - session('ticket_time') >= 7200)) {
            $ticket = $this->getTicket($request);
            if ($ticket == 'false') return '获取jsapi_ticket失败';
            $request->session()->put('jsapi_ticket', $ticket);
            $request->session()->put('ticket_time', time());
        }
        return $this->wxJsapiSign();
    }

    //获取token
    public function getToken()
    {
        //查询参数
        $system = System::find(1);
        $appid = empty($system->wx_appid)? config('app.wx_appid'): $system->wx_appid;
        $appsecret = empty($system->wx_appsecret)? config('app.wx_appsecret'):$system->wx_appsecret;
        $url = "https://api.weixin.qq.com/cgi-bin/token";
        $url .= "?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
        $res = IQuery::getJson($url);
        return $res['access_token'];
    }

    // 获取jsapi_ticket (有效期7200秒) 
    public function getTicket($request)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket";
        $url .= "?access_token=".session('access_token')."&type=jsapi";
        $res = IQuery::getJson($url);
        if ($res['errmsg'] != 'ok') return 'false'; //返回失败
        return $res['ticket'];
    }

    //签名
    public function wxJsapiSign()
    {
        $data['noncestr'] = IQuery::Noncestr(); //随机字符串   
        $data['jsapi_ticket'] = session('jsapi_ticket'); //有效的jsapi_ticket
        $data['timestamp'] = time(); //当前时间戳
        $data['url'] = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"].$_SERVER["QUERY_STRING"]; //当前url
        ksort($data);
        $str = IQuery::ToUrlParams($data);
        $data['sign'] = sha1($str);
        //查询参数
        $system = System::find(1);
        $data['appid'] = empty($system->wx_appid)? config('app.wx_appid'): $system->wx_appid;
        return $data;
    }

	//订单金额统计方法
	public function brokerage($check ='false')
	{
		$prices = Order::where('type','order')
				->where('state','close')
				->where('pid',Auth::user()->id);
		if ($check != 'false') $prices = $prices->where('updated_at','>=',$check);
		return $prices->sum('price');		
	}	

	//资产记录
	public function brokerageList()
	{
		$data = Brokerage::where('user_id',Auth::user()->id)->paginate(10);
		return $data;
	}

	//编辑 用户信息
	public function edit () {
		$data = User::leftjoin('user as auser','user.pid','=','auser.id')
			->where('user.id','=',Auth::user()->id)
			->select('user.*','auser.name as pname')
			->first();
		$title = '个人信息';
		return view(config('app.theme').'.home.userEdit')->with(['data'=>$data,'title'=>$title]);
	}

	//编辑 用户信息
	public function update (Request $request, $id) {
		$this->validate($request, [
            'email' => [
                'required',
                'max:50', 
                //name+软删除 唯一验证               
                Rule::unique('user')->ignore($id)->where(function($query) use ($id) {
                    $query->whereNull('deleted_at');
                })
            ], 
            'phone' => [
                'required',
                'max:50', 
                //name+软删除 唯一验证               
                Rule::unique('user')->ignore($id)->where(function($query) use ($id) {
                    $query->whereNull('deleted_at');
                })
            ], 
            'realname'=>'nullable|max:50',
            'gender' => 'required|max:4'
        ]);

        $model = User::find(Auth::user()->id);

        //接收数据 加入model
        $model->setRawAttributes($request->only(['realname','email','phone','gender','birth_date']));
        
        if ($request->del) {
            $model->img = null;
            $model->thumb = null;
            IQuery::destroyPic(new Brand, $id, 'img');
        }

        //资源、上传图片名称、是否生成缩略图
        $imgs = IQuery::upload($request,'img',true);
        if ($imgs != 'false') {
            $model->img = $imgs['pic'];
            $model->thumb = $imgs['thumb'];
        }

        $password = $request->password;
        if ($password) $model->password = bcrypt($password);

        if ($model->save()) return 'true';
        return 'false';
	}
}
