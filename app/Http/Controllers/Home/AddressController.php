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
		return view(config('app.theme').'.home.address.address')->with(['title'=>$title, 'lists'=>$lists]);
	}

	//地址管理新建
	public function create () {
		$title = '新增地址';
		$user_id = Auth::user()->id;
		echo $user_id;
		return view(config('app.theme').'.home.address.addressAdd')->with(['title'=>$title,'user_id'=>$user_id]);
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
		return view(config('app.theme').'.home.address.address_edit')->with(['data' => $data,'title' => $title]);
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
			return true;
		}else{
			$defaultaddress = Address::find($address->id);
			$defaultaddress->state = 0;
			if($defaultaddress->save()){
				return true;
			}
			return false;
		}
	}

    //更新默认地址
	public function default($id){
		if($this->canceldefault()){
			$model = Address::find($id);
			$model->state = 1;
			if ($model->save()) {
				return Redirect::to('home/address')->with('status', '设置成功');
			}
		}	
		return Redirect::back()->withErrors('设置失败');
	}

    //保存方法
	public function StoreOrUpdate(Request $request, $id = -1)
	{
		$this->validate($request, [
			'name' => [
			'required',
			'max:50', 
			], 
			'province'=>'required',
			'city'=>'required',
			'area'=>'required',
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
        //接收数据 加入model
		$model->setRawAttributes($request->only(['name','user_id','phone','province','city','area','detail','code']));  
		$state = 0;
		if($request->default == 'on'){
			if($this->canceldefault()){
				$state = 1;
			}else{
				return Redirect::back()->withErrors('设置默认地址时出错');
			}
		}  
		$model->state = $state;
		if ($model->save()) {
			return Redirect::to('home/address')->with('status', '保存成功');
		}
		return Redirect::back()->withErrors('保存失败');
	}
}
