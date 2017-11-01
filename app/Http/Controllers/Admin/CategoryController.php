<?php

namespace App\Http\Controllers\Admin;

/*
* user: 郭森林
* title: 商品分类
* date: 2017/06/15
 */
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\ProductCategory as Category;
use Redirect;
use IQuery;

class CategoryController extends Controller
{
    //列表页
    public function index(Request $request)
    {
        $lists = Category::orderBy('id','desc');
        if ($request->name) {
            $lists = $lists->where('name','like','%'.$request->name.'%');
        }
        $lists = $lists->paginate(10);

        return view(config('app.theme').'.admin.goods.category')->with(['lists'=>$lists]);
    }

    //创建
    public function create()
    {
        return view(config('app.theme').'.admin.goods.category_create');
    }

    //修改
    public function edit($id)
    {
        $data = Category::find($id);
        return view(config('app.theme').'.admin.goods.category_edit')
        ->with(['data'=>$data]);
    }

    //查看
    public function show($id)
    {
        return Category::find($id);
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
        IQuery::destroyPic(new Category, $id, 'img'); //删除图片
        if (Category::destroy($id)) return true;
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
            'name' => [
                'required',
                'max:50', 
                //name+软删除 唯一验证               
                Rule::unique('product_category')->ignore($id)->where(function($query) use ($id) {
                    $query->whereNull('deleted_at');
                })
            ], 
            'desc'=>'nullable|max:255'
        ]);

        if ($id == -1) {
            $model = new Category;
        } else {
            $model = Category::find($id);
        }

        //接收数据 加入model
        $model->setRawAttributes($request->only(['name','desc']));

        //资源、上传图片名称、是否生成缩略图
        $imgs = IQuery::upload($request,'img', true, new Category, $id, 'img');
        if (isset($imgs['pic'])) {
            $model->img = $imgs['pic'];
            $model->thumb = $imgs['thumb'];
        }
        
        if ($model->save()) {
            return Redirect::to('admin/goods/category')->with('status', '保存成功');
        }
        return Redirect::back()->withErrors('保存失败');
    }

}
