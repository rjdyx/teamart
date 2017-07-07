<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Activity;
use Illuminate\Support\Facades\Auth;
use Redirect;

class ActivityController extends Controller
{

	//优惠券
	public function roll (Request $request) 
	{ 
		$title = '优惠券';
		return view(config('app.theme').'.home.activity.roll')->with(['title'=>$title]);
	}

	//团购
	public function many ()
	{
		$title = '团购活动';
		return view(config('app.theme').'.home.activity.many')->with(['title'=>$title]);
	}

	//团购数据
	public function manyData ()
	{
		$lists = Activity::orderBy('date_start','desc')->paginate(10);
		return $lists;
	}
}