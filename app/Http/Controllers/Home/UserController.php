<?php

namespace App\Http\Controllers\Home;

use App\ApplicationRecord;
use App\Parter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
                /* gping add 20180912 start */
                //如果是一级代理商，则查询下属二级代理商为其提供的提成
                $sells += $this->upperparterscale(Auth::user()->id);
                // 计算其绑定用户所有消费为其提供的提成
                $sells += $this->ordinaryCommission(Auth::user()->id);
                /* gping add 20180912  end  */
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

        /* gping add 20180912 start */
        //
        $prices += $this->upperparterscale(Auth::user()->id);

        $prices += $this->ordinaryCommission(Auth::user()->id);
        /* gping add 20180912  end  */

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
        $imgs = IQuery::upload($request,'img',true, new User);
        
        if (isset($imgs['pic'])) {
            $model->img = $imgs['pic'];
            $model->thumb = $imgs['thumb'];
        }

        $password = $request->password;
        if ($password) $model->password = bcrypt($password);

        if ($model->save()) return 'true';
        return 'false';
	}

	/* *********   20180907 add start    ********** */
    //绑定的用户列表
    public function binduserasset(){
        //当前分销商id
        $nowuserid = Auth::id();
        //获取所有由我共享的用户列表
//        $sql = <<<SQL
//                select sum(fx_order.price) as price,fx_user.id,fx_user.name,fx_user.phone,fx_user.name,fx_user.email
//                from fx_user
//                join fx_order on fx_order.user_id = fx_user.id
//                where fx_user.pid = '$nowuserid'
//                group by fx_user.id,fx_user.name,fx_user.phone,fx_user.email
//SQL;
//
//        $shareuserlist = DB::select($sql);
        //先查询出绑定的用户信息
        $shareuserlist = User::where('pid',$nowuserid)->get();
        //再进行查询用户消费额度
        foreach ($shareuserlist as $key => $useritem){
            //查询每个用户的所有
            $shareuserlist[$key]->price = Order::where('type','order')
                ->where('state','close')
                ->where('user_id',$useritem->id)
                ->sum('price');
        }
//        dd($shareuserlist);
        //加上每一个用户的消费总额
        return view(config('app.theme').'.home.bindUserasset')->with(['shareuserlist'=>$shareuserlist,'title'=>'绑定用户信息']);
    }

    //计算一级分销商所得的提成
    public function upperparterscale($id){
        //查询所有upperparter_id为当前用户的提成
        $upperparter = User::where('upperparter_id',$id)->get();
        $upperpartersum = 0;//总提成
        foreach ($upperparter as $upperitem){
            //遍历所有其二级代理商
            $bro = Brokerage::orderBy('created_at','desc')->first();//获取最后一次结账日期
            $parter = Parter::find($upperitem->parter_id);//分销商角色信息
            $prices = Order::where('user_id',$upperitem->id)->where('state','close');
            if (!empty($bro)) {
                //如果结算过，就按上次结算时间开始计算
                $date = $bro->created_at;
                $prices = $prices ->where('updated_at','>=',$date);
            }
            $counts = $prices->sum('price');//获取订单总金额
            //如果不属于代理商
            if (!isset($parter)) {
                continue;
            }
            //二级用户所有消费总额乘以提成比例
//            $upperpartersum += ($counts * $upperitem->scale);
            $upperpartersum += $counts;
        }
        return $upperpartersum * Auth::user()->scale;//返回所有其二级代理商给其的提成
    }

    //关联普通用户消费为关联代理商提供的提成
    public function ordinaryCommission($id){/*初步成功*/
        //当前用户信息
        $nowuser = User::findOrFail($id);
        //查询关联所胡普通用户
        $users = User::where('pid',$id)->get();
        $usercommissionsum = 0;
        //遍历所有用户
        foreach ($users as $useritem){
            $bro = Brokerage::orderBy('created_at','desc')->first();//获取最后一次结账日期
            $parter = Parter::find($useritem->parter_id);//分销商角色信息
            $prices = Order::where('user_id',$useritem->id)->where('state','close');//查询订单关闭后的总额度
            if (!empty($bro)) {
                //如果结算过，就按上次结算时间开始计算
                $date = $bro->created_at;
                $prices = $prices ->where('updated_at','>=',$date);
            }
            $counts = $prices->sum('price');//获取订单总金额
            //非普通用户则跳过
            if(isset($parter)){
                continue;
            }
            $scale = ($counts * floatval($nowuser->scale));
            $usercommissionsum += $scale;
        }
        return $usercommissionsum;
    }

    //获取指定用户订单
    public function userorder($id){
        $thisuser = User::find($id);
        //获取指定用户的所有消费信息(订单关闭后)                                              订单编号 订单总价格 时间
        $userorderlist = Order::where('user_id',$id)->where('state','close')->select('serial','price','date')->get();

        return view(config('app.theme').'.home.userConsumptionRecord')->with(['userorderlist'=>$userorderlist,'title'=>$thisuser->name.'订单信息']);
//        return $userorderlist;
    }

    /**
     * 我的代理商管理
     * (发展二级用户时，用户需要同意才能建立上下级关系，申请成为某用户的二级代理商时，一级代理商需要同意才能建立上下级关系)
     * [需要指定用户同意才能建立关联]
     */
    //管理我的代理商(只是显示视图,数据采用异步请求)
    public function managementDealer(){
        if (Auth::user()->type === 1 && (Auth::user()->uppertarteg_id === 0 || empty(Auth::user()->uppertarger_id))) {
            //返回视图
            //一级代理商
            return view(config('app.theme') . '.home.managementDealer')->with(['title' => '我的二级代理商']);
        }else{
            //普通用户
            return view(config('app.theme') . '.home.userDealerInformationManagement')->with(['title' => '代理商信息管理']);
        }
    }

    // 添加我的二级代理商信息视图
    public function secondaryDealerAdd(){
        $userlist = $this->developableUserList();
        return view(config('app.theme').'.home.SecondaryDealer')->with(['userlist'=>$userlist,'title'=>'二级代理商添加']);
    }

    //可操作用户信息列表
    private function developableUserList(){
        /**
         * 判断当前用户类型
         * 如果是普通用户就查询所有一级代理商
         * 如果是一级代理商就查询所有普通用户信息
         * 如果是二级代理商就没有数据
         *
         * 0管理员，1为代理商，2为普通用户
         */
        $nowuser = Auth::user();
        if($nowuser->type == 1 && $nowuser->upperparter_id == 0){
            //一级代理商，查询所有普通用户信息
            $userlist = User::whereNull('parter_id')->where('type',2)->get();
        }elseif($nowuser->type == 2){
            //普通用户，查询一级代理商列表
//            $userlist = User::where('upperparter_id',0)->where('type',1)->get();
            //查询可申请一级用户列表
            $sql = "select * from fx_user where maxparternumber > (select count(id) from fx_user where upperparter_id in (select id from fx_user where type = 1 and upperparter_id = 0)) and type = 1 and parter_id != '' and upperparter_id = 0;";
//            dd($sql);
            $userlist = DB::select($sql);
        }else{
            $userlist = [];
        }
        //返回视图
        return $userlist;//返回视图
    }

    //申请信息保存
    public function applicationInformationPreservation(Request $request){
        //获取申请对象的名字
        $username = $request->secondarydealername;

        //受邀对像
        $inviteuserinfo = User::where('name',$username)->first();
        //申请对象
        $applicationuserinfo = Auth::user();

        //一级代理商id
        $id = $applicationuserinfo->type == 1?$applicationuserinfo->id:$inviteuserinfo->id;
        if(!$this->maxparternumber($id)){
            //返回失效信息：邀请用户的名额已满无法进行同意操作
            return json_encode(['status'=>500,'message'=>'邀请用户的名额已满无法进行同意操作']);
        }
        //将申请信息保存到数据库中去
        if (isset($request->id)){
            //修改信息
            $applicationrecordinfo = ApplicationRecord::find($request->id);
        }else{
            //新增信息
            $applicationrecordinfo = new ApplicationRecord();
        }
        //申请类型
        if($applicationuserinfo->type==1 && $applicationuserinfo->upperparter_id == 0){
            //一级代理商
            $applicationrecordinfo->type = 1;
        }elseif($applicationuserinfo->type == 2){
            //普通用户
            $applicationrecordinfo->type = 0;
        }
        //$applicationrecordinfo->type = Auth::user()->type;
        $applicationrecordinfo->application_user_id = $applicationuserinfo->id;
        $applicationrecordinfo->target_users_id = $inviteuserinfo->id;
        //接收其它数据
        $applicationrecordinfo->message = $request->message;//发送消息
        $applicationrecordinfo->scale = $request->scale;//佣金比
        $applicationrecordinfo->date = date("Y-m-d H:i:s");//申请时间
        //信息保存
        if($applicationrecordinfo->save()){
            return abort(200,'申请成功!');
        }else{
            return abort(500,'申请失败！');
        }
    }

    //我的代理商列表
    public function dealerInformationList(){
        return User::where('upperparter_id',Auth::user()->id)->get();
    }

    //申请信息列表 (当前用户向其他用户发出的申请)
    public function applicationInformationList(){
        //获取当前用户信息
        $nowuser = Auth::user();
        //得到申请列表[一个申请项用;号隔开,子项用|号隔开]
        $applicationinfolist = ApplicationRecord::select('application_record.*','user.name as name','user.phone')
            ->join('user','user.id','application_record.target_users_id')
            ->where('application_record.application_user_id',$nowuser->id)
            ->get();//获取邀请列表
        return $applicationinfolist;//返回申请数据
    }

    //邀请信息列表(其他用户向我发出的请求，我这边需要确认)
    public function inviteInformationList(){
        //当前用户信息
        $nowuser = Auth::user();
        //邀请对象是我，所以target_users_id = $nowuser->id
        $inviteinformationlist = ApplicationRecord::select('application_record.*','user.name as name','user.phone')
            ->join('user','user.id','application_record.application_user_id')
            ->where('application_record.target_users_id',$nowuser->id)
            ->get();//获取邀请列表
        return $inviteinformationlist;

    }

    //申请信息编辑
    public function applicationInformationEdit(Request $request,$id){
//        $applicationInformationinfo = ApplicationRecord::find($id);
        $applicationInformationinfo = ApplicationRecord::select('application_record.*','user.name as name')
            ->join('user','user.id','application_record.target_users_id')
            ->where('application_record.id',$id)
            ->first();
        $userlist = $this->developableUserList();
        return view(config('app.theme').'.home.SecondaryDealer')->with(['userlist'=>$userlist,'title'=>'二级代理商添加','applicationInformationinfo'=>$applicationInformationinfo]);
    }

    //同意邀请
    public function agreeInvitation(Request $request){
//        return $request->id;
        //获取申请信息
        $applicationInfromationinfo = ApplicationRecord::find($request->id);
        $id = $applicationInfromationinfo->type == 1?$applicationInfromationinfo->application_user_id:$applicationInfromationinfo->target_users_id;//获取一级代理商id
        if(!$this->maxparternumber($id)){
            $this->failureOperation($request->id);//进行失效信息操作
            //返回失效信息：邀请用户的名额已满无法进行同意操作
            return json_encode(['status'=>500,'message'=>'邀请用户的名额已满无法进行同意操作']);
        }
        // 开启事务操作
        DB::beginTransaction();
        //安全性判断
        if(empty($applicationInfromationinfo)){
            //如果没有此记录信息，就要返回200+没有此记录信息
            return json_encode(['status'=>200,'message'=>'没有此记录信息!']);
        }
        //非法操作
        if ($applicationInfromationinfo->target_users_id !== Auth::id()){
            return json_encode(['status'=>401,'message'=>'非法操作!']);
        }
        // 同意操作
        //获取相应的信息
        //受邀用户的id号//类型判断
        $userid = $applicationInfromationinfo->type == 1?$applicationInfromationinfo->target_users_id:$applicationInfromationinfo->application_user_id;
        //目标用户信息
        $targetuserinfo = User::find($userid);
        //如果该用户有关联对像了
        if ($targetuserinfo->upperparter_id != 0 || !empty($targetuserinfo->upperparter_id)){
            return json_encode(['status'=>401,'message'=>'无法关联指定用户，因为此用户已经被关联']);
        }
        //保存目标用户信息
        // 上级代理商用户id
        $targetuserinfo->upperparter_id = $applicationInfromationinfo->type == 0?$applicationInfromationinfo->target_users_id:$applicationInfromationinfo->application_user_id;//类型判断
        //提成信息
        $targetuserinfo->scale = $applicationInfromationinfo->scale;
        //代理商角色
        $targetuserinfo->parter_id = User::find($applicationInfromationinfo->application_user_id)->parter_id;
        //用户类型改为代理商
        $targetuserinfo->type = 1;
        //修改申请记录表中的信息
        $applicationInfromationinfo->status = 1;//修改状态为1(申请通过)[接受申请]
        //保存(如果全部保存成功，就提交，否则就回滚)
        if($targetuserinfo->save() && $applicationInfromationinfo->save()){
            DB::commit();//保存对数据的修改
            //接受申请成功
            return json_encode(['status'=>200,'message'=>'接受成功!']);
        }else{
            DB::rollBack();//数据回滚
            //操作失败
            return json_encode(['status'=>500,'message'=>'操作失败！']);
        }
    }

    //拒绝邀请
    public function refuseInvitation(Request $request){
        //  判断目标用户是不是当前登录的用户，如果不是就无法操作
        $applicationInfromationinfo = ApplicationRecord::find($request->id);
        //安全性判断
        if(empty($applicationInfromationinfo)){
            //如果没有此记录信息，就要返回200+没有此记录信息
            return json_encode(['status'=>200,'message'=>'没有此记录信息!']);
        }
        //非法操作
        if ($applicationInfromationinfo->target_users_id !== Auth::id()){
            return json_encode(['status'=>401,'message'=>'非法操作!']);
        }
        //拒绝操作
        $applicationInfromationinfo->status = 0;
        // 保存对数据的修改
        if($applicationInfromationinfo->save()){
            return json_encode(['status'=>200,'message'=>'已经拒绝此邀请!']);
        }else{
            return json_encode(['status'=>500,'message'=>'操作失败!']);
        }
    }

    //删除邀请
    public function deleteInvitation(Request $request){
        //删除邀请信息
        //获取删除的记录信息
        $invitationInformation = ApplicationRecord::find($request->id);
        //安全性判断
        //如果当前登录用户的id不是申请用户id就不能将其记录进行删除(非法操作)
        if($invitationInformation->application_user_id != Auth::id()){
            return json_encode(['status'=>401,'message'=>'非法操作!']);
        }
        //如果没有相应的记录信息就返回200+没有该记录信息
        if(empty($invitationInformation)){
            return json_encode(['status'=>200,'message'=>'没有该记录信息!']);
        }
        //删除操作
        if($invitationInformation->delete()){
            //删除成功
            return json_encode(['status'=>200,'message'=>'删除邀请成功!','data'=>$invitationInformation]);
        }else{
            //删除失败
            return json_encode(['status'=>500,'message'=>'删除记录信息失败!']);
        }
//        return $request->id;
    }

    //解除关联(删除关联)
    public function disassociate(Request $request){
        //获取将要解除与当前用户关联的用户信息
        $disassociateobj = User::find($request->id);
        //如果没有就返回500+没有此关联信息
        if(Empty($disassociateobj)){
            return json_encode(['message'=>'没有此关联信息!','start'=>200]);
        }
        //如果解除关联用户的关联一级代理商不是当前用户信息就返回403+非法操作
        if($disassociateobj->upperparter_id !== Auth::id()){
            //非法解除关联
            return json_encode(['message'=>'非法操作!','start'=>401]);
        }
        //设置将要保存的数据信息
        //将以下两个字段设置为0(默认值)
        $disassociateobj->upperparter_id = 0;
        $disassociateobj->scale = 0;
        //保存关联
        if($disassociateobj->save()){
            //保存成功
            return json_encode(['message'=>'解除操作成功!','start'=>200]);
        }else{
            //保存失败
            return json_encode(['message'=>'保存失败!','start'=>500]);
        }
//        return $request->id;
    }

    //当前一级代理商的二级代理商总数超出判断
    private function maxparternumber($id){
        $maxnumber = User::find($id)->maxparternumber;
        $nownumber = User::where('upperparter_id',$id)->count();
        return $maxnumber>$nownumber ? true : false;
    }
    //当邀请的一级代理商的二级代理商超出最大数时的同意为失效的。[status=null]
    private function failureOperation($id){
        //操作一些失效信息
        $record = ApplicationRecord::find($id);
        $record->status = 3;//为空时便是失效邀请
        return $record->save();
    }
    //当前一级代理商用户的二级代理商用户量是否满？
    public function maxparternumberBeyond(){
        if($this->maxparternumber(Auth::user()->id)){
            return json_encode(['status'=>200,'number'=>1]);
        }else{
            return json_encode(['status'=>500,'number'=>0]);
        }
    }

	/* *********   20180907 add  end     ***********/
}
