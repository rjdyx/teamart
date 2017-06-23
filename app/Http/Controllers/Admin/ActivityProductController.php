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
			'product.price as product_price',
			'activity.price as activity_price',
			'activity.date_start',
			'activity.date_end',
			'activity.name as activity_name')
		->orderBy('activity_product.id','asc');
                //->paginate(3);
		// $lists = ActivityProduct::whereRaw('1=1');      
		if ($request->name) {
			$lists = $lists->where('product.name','like','%'.$request->name.'%')
			->orwhere('activity.name','like','%'.$request->name.'%');
		}
		$lists = $lists->paginate(3);
		return view(config('app.theme').'.admin.activity.group.activity_product')->with(['lists'=>$lists]);
	}

    //数据查询(团购活动查询)
	public function indexData () {
		$lists = DB::table('activity_product')->join('activity','activity_product.activity_id','=','activity.id')
		->join('product','activity_product.product_id','=','product.id')
		->whereNull('product.deleted_at')
		->whereNull('activity.deleted_at')
		->whereNull('activity_product.deleted_at');	
		return $lists;
	}

    //创建
	public function create()
	{
		$activities = Group::select('id','name')->get();
		$products = Product::select('id','name')->get();
		return view(config('app.theme').'.admin.activity.group.activity_product_create')->with(['activities'=>$activities, 'products'=>$products]);
	}

    //修改
	public function edit($id)
	{
		$data = ActivityProduct::find($id);
		$product_id = $data->product_id;
		$activity_id = $data->activity_id;
		$product = Product::find($product_id);
		$activity = Group::find($activity_id);
		$activities = Group::select('id','name')->get();
		$products = Product::select('id','name')->get();
		return view(config('app.theme').'.admin.activity.group.activity_product_edit')
		->with(['data'=>$data, 'product'=>$product, 'activity'=>$activity,'activities'=>$activities, 'products'=>$products]);
	}

    //查看
	public function show($id)
	{
		return Group::find($id);
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
		if (ActivityProduct::destroy($id)) return true;
		return false;
	}

    //批量删除
	public function dels(Request $request)
	{
		$ids = explode(',', $request->ids);
		if (Group::destroy($ids)) {
			return Redirect::back()->with('status','批量删除成功');
		}
		return Redirect::back()->withErrors('批量删除失败');
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
			'product_id' => [
			'required',
			//name+软删除 唯一验证               
			Rule::unique('activity_product')->ignore($id)->where(function($query) use ($id) {
				$query->whereNull('deleted_at');
			})
			],
			'activity_id' => [
			'required', ],           
			]);

		if ($id == -1) {
			$model = new ActivityProduct;
		} else {
			$model = ActivityProduct::find($id);
		}

        //接收数据 加入model
		echo $request->product_id;
		echo $request->activity_id;
		$model->setRawAttributes($request->only(['product_id','activity_id']));

		if ($model->save()) {
			return Redirect::to('admin/activity/activityproduct')->with('status', '保存成功');
		}
		return Redirect::back()->withErrors('保存失败');
	}
}
