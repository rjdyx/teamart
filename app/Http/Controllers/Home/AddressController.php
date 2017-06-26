<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Address;
use Illuminate\Support\Facades\Auth;

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
		return view(config('app.theme').'.home.addressAdd')->with(['title'=>$title]);
	}
}
