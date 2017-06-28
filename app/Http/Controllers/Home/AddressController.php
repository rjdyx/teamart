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
			return Redirect::back()->with('status','删除成功');
		}
		return Redirect::back()->withErrors('删除失败');
	}

	public function del($id) 
	{
		if (Address::destroy($id)) return true;
		return false;
	}

    //批量删除
	public function dels(Request $request)
	{
		$ids = explode(',', $request->ids);
		foreach ($ids as $id) {
			if (!$this->del($id)) {
				return Redirect::back()->withErrors('批量删除失败');
			}
		}
		return Redirect::back()->with('status','批量删除成功');
	}

	//取消当前的默认地址选中状态
	public function canceldefault(){
		$address = Address::where('user_id',Auth::user()->id)->where('state','=','1')->first();
		if(empty($address)){
			//还没设置默认地址
			return true;
		}else{
			$defaultaddress = Address::find($address->id);
			$defaultaddress->state = 0;
			if($defaultaddress->save()){
				//已经取消了默认地址
				return true;
			}
			//取消默认地址失败
			return false;
		}
	}

    //更新默认地址
	public function defaultaddress($id){
		//判断现在是所有地址都不是默认选中状态，如果是则设定新的默认地址
		if($this->canceldefault()){
			$model = Address::find($id);
			$model->state = 1;
			if ($model->save()) {
				//return Redirect::to('home/address')->with('status', '设置成功');
				return true;
			}
		}	
		//return Redirect::back()->withErrors('设置失败');
		return false;
	}

    //保存方法
	public function StoreOrUpdate(Request $request, $id = -1)
	{
		$this->validate($request, [
			'name' => [
			'required',
			'max:50', 
			], 
			'address'=>'required',
			'phone'=>[
			'required',
			'max:11',
			],
			'detail'=>'required',
			]);
		if ($id == -1) {
			$model = new Address;
		} else {
			$model = Address::find($id);
		}
		$address = explode(',', $request->address);
		$province = $address[0];
		$city = $address[1];
		$area = $address[2];
        //接收数据 加入model
		$model->setRawAttributes($request->only(['name','phone','detail','code']));  
		$model->user_id = Auth::user()->id;
		$model->province = $province;
		$model->city = $city;
		$model->area = $area;
		$state = 0;
		if($request->state == 1){
			if($this->canceldefault()){
				$state = 1;
			}else{
				//return Redirect::back()->withErrors('设置默认地址时出错');
				return false;
			}
		}  
		$model->state = $state;
		if ($model->save()) {
			//return Redirect::to('home/address')->with('status', '保存成功');
			return true;
		}
		//return Redirect::back()->withErrors('保存失败');
		return false;
	}
}
