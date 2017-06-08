<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderProduct;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	//个人中心 用户相关信息
	public function userInfo () {
		$show = User::find(Auth::user()->id);
		$title = '个人中心';
		$footer = 'user';
		return view(config('app.theme').'.home.personalCenter')->with(['show'=>$show,'title'=>$title,'footer'=>$footer]);
	}

	//个人资产
	public function userAsset () {
		$show = User::find(Auth::user()->id);
		$title = '个人资产';
		return view(config('app.theme').'.home.personalAssets')->with(['show'=>$show,'title'=>$title]);
	}

	//编辑 用户信息
	public function edit () {
		$show = User::find(Auth::user()->id);
		$title = '个人信息';
		return view(config('app.theme').'.home.userEdit')->with(['show'=>$show,'title'=>$title]);
	}
}
