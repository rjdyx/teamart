<?php

namespace App\Http\Controllers\Admin;

/*
* user: 郭森林
* title: 商品组
* date: 2017/06/16
 */
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\ProductGroup as Group;
use App\ProductCategory as Category;
use Redirect;
use IQuery;

class GoodsGroupController extends Controller
{
    //列表页
    public function index(Request $request)
    {
        $lists = $this->indexData();
        if ($request->name) {
            $lists = $lists->where('product_group.name','like','%'.$request->name.'%');
        }
        if ($request->category) {
            $lists = $lists->where('product_category.id','=',$request->category);
        }
        $lists = $lists->select('product_group.*','product_category.name as category_name')
                ->orderBy('product_group.id','asc')
                ->paginate(10);

        //查询所有关联的商品分类
        $selects = $this->indexData()->distinct('product_category.id')->select('product_category.name','product_category.id')->get();

        return view(config('app.theme').'.admin.goods.group')->with(['lists'=>$lists,'selects'=>$selects]);
    }

    //数据查询
    public function indexData () {
        $lists = Group::join('product_category','product_group.category_id','=','product_category.id')
                ->whereNull('product_group.deleted_at')
                ->whereNull('product_category.deleted_at');
        return $lists;
    }
    //创建
    public function create()
    {
        //查询所有商品分类
        $selects = Category::get();
        return view(config('app.theme').'.admin.goods.group_create')->with('selects',$selects);
    }

    //修改
    public function edit($id)
    {
        $selects = Category::get();
        $data = Group::find($id);
        return view(config('app.theme').'.admin.goods.group_edit')
        ->with(['data'=>$data, 'selects'=>$selects]);
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
        if (Group::destroy($id)) return true;
        return false;
    }

    //批量删除
    public function dels(Request $request)
    {
        $ids = explode(',', $request->ids);
        if (Group::destroy($ids)) {
            return Redirect::back()->withErrors('批量删除失败');
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
            'name' => [
                'required',
                'max:50', 
                //name+软删除 唯一验证               
                Rule::unique('product_group')->ignore($id)->where(function($query) use ($id) {
                    $query->whereNull('deleted_at');
                })
            ], 
            'desc'=>'nullable|max:255'
        ]);

        if ($id == -1) {
            $model = new Group;
        } else {
            $model = Group::find($id);
        }

        //接收数据 加入model
        $model->setRawAttributes($request->only(['name','desc','category_id']));

        if ($model->save()) {
            return Redirect::to('admin/goods/group')->with('status', '保存成功');
        }
        return Redirect::back()->withErrors('保存失败');
    }

}
