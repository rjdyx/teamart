<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Activity;
use App\Cheap;
use App\CheapUser;
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

	//优惠券数据
	public function rollData ()
	{
		$lists = Cheap::leftjoin('cheap_user','cheap.id','=','cheap_user.cheap_id')
				->orderBy('cheap.indate','desc')
				->where('cheap.range','<',1)
				->orwhere('cheap.range','=',Auth::user()->type)
				->select('cheap.*','cheap_user.user_id','cheap_user.state as ustate')
				->paginate(10);
		return $lists;
	}

	//领取优惠券
	public function getRoll (Request $request)
	{
		$id = $request->id;
		if (!$this->rollAmount($id)) return 2;
		$model = new CheapUser;
		$model->user_id = Auth::user()->id;
		$model->cheap_id = $id;
		if ($model->save()) return 1;
		return 0;
	}

	//统计优惠券数量 判断剩余数量
	public function rollAmount($id)
	{
		$roll = Cheap::find($id);
		$unum = CheapUser::where('cheap_id',$id)->count();
		if ($roll->amount > $unum) return 1;
		return 0;
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