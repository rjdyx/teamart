<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Site;
use Illuminate\Support\Facades\Auth;
use Redirect;

class SiteController extends Controller
{
	
	public function index () 
	{ 
		$title = '站点信息';
		return view(config('app.theme').'.home.site');
	}


	//站点列表数据接口
	public function indexData (Request $request) 
	{ 
		$datas = Site::paginate(10);
		return $datas;
	}

	//查询最新的站点 
	public function siteDefualt ()
	{
		return Site::orderBy('created_at','desc')->first();
	}
}