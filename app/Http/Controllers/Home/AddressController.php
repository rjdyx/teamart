<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Address;
use Illuminate\Support\Facades\Auth;
use Redirect;

class AddressController extends Controller
{
	//地址管理列表页
	public function index (Request $request) { 
		$title = '地址管理';
		$lists = Address::where('user_id',Auth::user()->id)->get();
		return view(config('app.theme').'.home.address')->with(['title'=>$title, 'lists'=>$lists]);
	}

	//地址管理新建
	public function create () {
		$title = '新增地址';
		$user_id = Auth::user()->id;
		return view(config('app.theme').'.home.addressAdd')->with(['title'=>$title,'user_id'=>$user_id]);
	}

	//查看单条信息
	public function show($id)
	{ 
		return Address::find($id);
	}

    //保存新建数据
	public function store(Request $request)
	{
		return $this->StoreOrUpdate($request);
	}

    //编辑数据
	public function edit($id)
	{
		$title = '编辑地址';
		$data = Address::find($id);
		return view(config('app.theme').'.home.addressEdit')->with(['data' => $data,'title' => $title]);
	}

    //编辑保存
	public function update(Request $request, $id)
	{
		return $this->StoreOrUpdate($request, $id);
	}

    //单条删除
	public function destroy($id)
	{
		if ($this->del($id)) {
			return 'true';
		}
		return 'false';
	}

	public function del($id) 
	{
		if (Address::destroy($id)) return 'true';
		return 'false';
	}

    //批量删除
	public function dels(Request $request)
	{
		$ids = explode(',', $request->ids);
		foreach ($ids as $id) {
			if ($this->del($id)=='false') {
				return 'false';
			}
		}
		return 'true';
	}

	//查询用户默认地址
	public function defaultState()
	{
		$data = Address::where('state',1)->where('user_id',Auth::user()->id)->first();
		return $data;
	}

	//取消当前的默认地址选中状态
	public function canceldefault(){
		$address = Address::where('user_id',Auth::user()->id)->where('state','=','1')->first();
		if(empty($address)){
			//没设置过默认地址
			return 'true';
		}else{
			$defaultaddress = Address::find($address->id);
			$defaultaddress->state = 0;
			if($defaultaddress->save()){
				//已经取消了默认地址
				return 'true';
			}
			//取消默认地址失败
			return 'true';
		}
	}

    //更新默认地址
	public function defaultaddress($id){
		//判断现在是所有地址都不是默认选中状态，如果是则设定新的默认地址
		if(strcmp($this->canceldefault(), 'true')==0){
			$model = Address::find($id);
			$model->state = 1;
			if ($model->save()) {
				//设置了默认地址并保存成功
				return 'true';
			}else{
				//默认地址保存失败
				return 'false';
			}
		}	
		//取消数据库中默认地址的选中状态失败
		return 'false';
	}

    //保存方法
	public function StoreOrUpdate(Request $request, $id = -1)
	{
		$this->validate($request, [
			'name' => [
			'required',
			'min:2', 
			], 
			'address'=>'required',
			'phone'=>[
			'required',
			'min:11',
			'max:11',
			],
			'code'=>'required|min:6|max:6',
			'detail'=>'required|min:5',
			]);
		//如果该地址被选择为默认地址，则先取消数据库中的默认地址选中状态
		if($request->state == 1){
			if(strcmp($this->canceldefault(), 'false')==0){
				return false;
			}
		}  
		if ($id == -1) {
			$model = new Address;
		} else {
			$model = Address::find($id);
		}
		$address = explode(',', $request->address);
		$province = $address[0];
		$city = $address[1];
		//如果地址只有省和市时进行判断
		if (count($address)>2){
			$area = $address[2];
		}else{
			$area = $address[1];
		}
        //接收数据 加入model
		$model->setRawAttributes($request->only(['name','phone','detail','code']));  
		$model->user_id = Auth::user()->id;
		$model->province = $province;
		$model->city = $city;
		$model->area = $area;
		$model->state = $request->state;
		if ($model->save()) {
			return 'true';
		}
		return 'false';
	}
}
