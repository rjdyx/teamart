<?php
/*
 * @version: 0.1 商品控制器
 * @author: gsl
 * @date: 2017/06/08
 * @description:数据增删查改
 *
 */
namespace App\Http\Controllers\Admin;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use IQuery;

class ProductController extends Controller
{
    //首页 (列表页)
    public function index(Request $request)
    {
        $lists = Product::paginate(config('app.paginate10'));
        return view(config('app.theme').'.admin.product.index')->with('lists',$lists);
    }

    //查看单条信息
    public function show($id)
    {
        return Product::find($id);
    }

    //数据创建
    public function create()
    {
        return view(config('app.theme').'.admin.product.create');
    }

    //保存新建数据
    public function store(Request $request)
    {
        return $this->StoreOrUpdate($request);
    }

    //编辑数据
    public function edit($id)
    {
        $data = Product::find($id);
        return view(config('app.theme').'.admin.product.edit')->with('data',$data);
    }

    //编辑保存
    public function update(Request $request, $id)
    {
        return $this->StoreOrUpdate($request, $id);
    }

    //单条删除
    public function destroy($id)
    {
        $data = Product::find($id);
        if($data->delete()){
            IQuery::destroyPic(new Product, $id);//公共工具删除图片
            return Redirect::back()->withErrors('删除成功');
        }
        return Redirect::back()->withErrors('删除失败');
    }

    //保存方法
    public function StoreOrUpdate(Request $request, $id = -1)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'max:50', 
                //name+category_id+软删除 唯一验证               
                Rule::unique('product_')->ignore($id)->where(function($query) use ($id) {
                    $query->where('category_id',$request->category_id)->whereNull('deleted_at');
                })
            ], 
            'price_raw'=>'nullable|numeric',
            'price'=>'required|numeric',
            'origin'=>'required|max:255',
            'category_id'=>'required',
            'brand_id'=>'required',
            'date'=>'required|date',
            'desc' => 'nullable|max:255'
        ]);

        //判断 新增/编辑
        if ($id == -1) {
            $model = new Product;
        } else {
            $model = Product::find($id);
        }

        //接收数据 加入model
        $model->setRawAttributes($request->only(['category_id','brand_id','name','price_raw','price','origin','date','desc']));

        //上传图片
        $pics = 'false';
        if ($request->hasFile('img')) $pics = IQuery::upload($request);
        if ($pics != 'false') {
            $model->img = $pics['pic'];
            $model->thumb = $pics['pic_thumb'];
        }

        if ($id == -1) {
            $model->user_id = Auth::user()->id;
        } else {
            $model->id = $id;
        }

        //保存数据
        if($model->save()){
            if ($request->hasFile('imgs')) {
                $pics = IQuery::uploads($request,'imgs',true);

            }
            if ($id != -1) {
                IQuery::destroyPic(new ProductImg, $id);//公共工具删除图片
            }
            return Redirect::to('admin/product')->with('status', '保存成功');
        }else{
            return Redirect::back()->withErrors('保存失败');
        }
    }
}
