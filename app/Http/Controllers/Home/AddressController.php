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
		$lists = Address::where('user_id',Auth::user()->id)->get();
		return view(config('app.theme').'.home.addressList')->with(['lists'=>$lists]);
	}

	//地址管理新建
	public function create () {
		return view(config('app.theme').'.home.addressAdd');
	}
}
