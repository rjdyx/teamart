<?php

namespace App\Http\Controllers\Admin;

/*
* author:严能发
* title: 活动与商品关联控制器
* date: 2017/06/16
 */

use App\ActivityProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Redirect;
use IQuery;
use DB;
use App\Group;
use App\Product;

class ActivityProductController extends Controller
{
    //列表页
	public function index(Request $request)
	{
		$lists = $this->indexData();
		$lists = $lists->select(
			'activity_product.*',
			'product.name as product_name',
			'spec.price as product_price',
			'activity.price as activity_price',
			'activity.date_start',
			'activity.date_end',
			'activity.name as activity_name')
		->orderBy('activity_product.id','desc');
		$activity_id = $request->activity_id;   
 
		if ($request->name) {
			$lists = $lists->where('product.name','like','%'.$request->name.'%');
		}

		$lists = $lists->paginate(10);
		return view(config('app.theme').'.admin.activity.group.activity_product')->with(['lists'=>$lists,'activity_id'=>$activity_id]);
	}

    //数据查询(团购活动查询)
	public function indexData () {
		$lists = DB::table('activity_product')
		->join('activity','activity_product.activity_id','=','activity.id')
		->join('product','activity_product.product_id','=','product.id')
		->join('spec','product.id','=','spec.product_id')
        ->where('spec.state','=',1)
		->whereNull('product.deleted_at')
		->whereNull('activity.deleted_at')
		->whereNull('activity_product.deleted_at');	
		return $lists;
	}

    //创建活动-商品关联
	public function create(Request $request)
	{
		$id = $request->activity_id;
		$activity = Group::find($id);
		$pts = Product::join('activity_product','product.id','=','activity_product.product_id')
				->distinct('product.id')
				->whereNull('activity_product.deleted_at')
				->whereNull('product.deleted_at')
				->select('product.id')
				->get();
		$arr = [];
		foreach ($pts as $pt) {
			$arr[] = $pt->id;
		}
		$products = Product::whereNotIn('id',$arr)->select('product.id','product.name')->get();
		return view(config('app.theme').'.admin.activity.group.activity_product_create')->with(['activity'=>$activity, 'products'=>$products]);
	}

    //修改活动-商品关联关系
	public function edit($id)
	{
		return view(config('app.theme').'.admin.activity.group.activity_product_edit')->with([]);
	}

    //查看活动-商品关联相关信息
	public function show($id)
	{
		$lists = $this->indexData();
		$lists = $lists->select(
			'activity_product.*',
			'product.name as product_name',
			'spec.price as product_price',
			'activity.price as activity_price',
			'activity.date_start',
			'activity.date_end',
			'activity.name as activity_name')
		->orderBy('activity_product.id','asc');
		$lists = $lists->where('activity.id','=',$id);
		$lists = $lists->paginate(10);
		$activity_id = $id;
		return view(config('app.theme').'.admin.activity.group.activity_product')->with(['lists'=>$lists, 'activity_id'=>$activity_id]);
	}

    //单条删除
	public function destroy($id)
	{
		if ($this->del($id)) {
			return Redirect::to('admin/activity/group')->with('status','删除成功');
		}
		return Redirect::back()->withErrors('删除失败');
	}

	public function del($id) 
	{
		if (ActivityProduct::destroy($id)) return true;
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

    //新建保存
	public function store(Request $request)
	{	
		return $this->StoreOrUpdate($request);
	}

    //编辑保存
	public function update(Request $request, $id)
	{   
		return $this->StoreOrUpdate($request, $id);
	}

    //保存方法
	public function StoreOrUpdate(Request $request, $id = -1)
	{
		$this->validate($request, [
			'pid' => 'required',
			'activity_id' => 'required'           
		]);

		$pids = $request->pid;
		foreach ($pids as $pid) {
			$model = new ActivityProduct;
			$model->product_id = $pid;
			$model->activity_id = $request->activity_id;
			if (!$model->save()) return Redirect::back()->withErrors('保存失败');
		}
		return Redirect::to('admin/activity/activityproduct?activity_id='.$request->activity_id)->with('status', '保存成功');
	}
}
