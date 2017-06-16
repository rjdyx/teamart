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
use App\Brand;
use Redirect;
use IQuery;

class BrandController extends Controller
{
    //列表页
    public function index(Request $request)
    {
        $lists = Brand::orderBy('id','asc');
        if ($request->name) {
            $lists = $lists->where('name','like','%'.$request->name.'%');
        }
        $lists = $lists->paginate(10);

        return view(config('app.theme').'.admin.goods.brand')->with(['lists'=>$lists]);
    }

    //创建
    public function create()
    {
        return view(config('app.theme').'.admin.goods.brand_create');
    }

    //修改
    public function edit($id)
    {
        $data = Brand::find($id);
        return view(config('app.theme').'.admin.goods.brand_edit')
        ->with(['data'=>$data]);
    }

    //查看
    public function show($id)
    {
        return Brand::find($id);
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
        IQuery::destroyPic(new Brand, $id, 'img'); //删除图片
        if (Brand::destroy($id)) return true;
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
                Rule::unique('brand')->ignore($id)->where(function($query) use ($id) {
                    $query->whereNull('deleted_at');
                })
            ], 
            'desc'=>'nullable|max:255'
        ]);

        if ($id == -1) {
            $model = new Brand;
        } else {
            $model = Brand::find($id);
        }

        //接收数据 加入model
        $model->setRawAttributes($request->only(['name','desc']));

        //资源、上传图片名称、是否生成缩略图
        $imgs = IQuery::upload($request,'img',true);
        if ($imgs != 'false') {
            $model->img = $imgs['pic'];
            $model->thumb = $imgs['thumb'];
            if ($id == -1 ) destroyPic(new Brand, $id, 'img');
        }

        if ($model->save()) {
            return Redirect::to('admin/goods/brand')->with('status', '保存成功');
        }
        return Redirect::back()->withErrors('保存失败');
    }

}
