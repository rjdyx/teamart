<?php

namespace App\Http\Controllers\Admin;

/*
* user: 郭森林
* title: 商品
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
use App\Brand;
use App\Spec;
use App\ProductCategory as Category;
use App\Product;
use App\ProductImg;
use Redirect;
use IQuery;

class GoodsController extends Controller
{
    //列表页
    public function index(Request $request)
    {
        $lists = $this->indexData();
        if ($request->name) {
            $lists = $lists->where('product.name','like','%'.$request->name.'%');
        }
        if ($request->category) {
            $lists = $lists->where('product_category.id','=',$request->category);
        }
        if ($request->brand) {
            $lists = $lists->where('brand.id','=',$request->brand);
        }
        $lists = $lists->select(
                    'product.*',
                    'product_category.name as category_name',
                    'brand.name as brand_name',
                    'spec.price'
                )->orderBy('product.id','desc')->paginate(10);

        //查询所有关联的商品分类
        $categorySelects = $this->indexData()->distinct('product_category.id')->select('product_category.name','product_category.id')->get();

        //查询所有关联的商品品牌
        $brandSelects = $this->indexData()->distinct('brand.id')->select('brand.name','brand.id')->get();

        return view(config('app.theme').'.admin.goods.list')
        ->with([
            'lists'=>$lists,
            'categorySelects'=>$categorySelects,
            'brandSelects'=>$brandSelects
        ]);
    }

    //数据查询
    public function indexData () {
        $lists = Product::join('product_category','product.category_id','=','product_category.id')
                ->join('brand','product.brand_id','=','brand.id')
                ->join('spec','product.id','=','spec.product_id')
                ->where('spec.state','=',1)
                ->whereNull('product.deleted_at')
                ->whereNull('brand.deleted_at')
                ->whereNull('product_category.deleted_at');
        return $lists;
    }

    //创建
    public function create()
    {
        $categorys = Category::select('id','name')->get();
        $brands = Brand::select('id','name')->get();
        return view(config('app.theme').'.admin.goods.list_create')
        ->with([
            'categorys'=>$categorys,
            'brands'=>$brands
        ]);
    }

    //修改
    public function edit($id)
    {
        $categorys = Category::select('id','name')->get();
        $brands = Brand::select('id','name')->get();
        $specs = Spec::where('product_id',$id)->get();
        $data = Product::find($id);
        $imgs = ProductImg::where('product_id',$id)->get();

        return view(config('app.theme').'.admin.goods.list_edit')
        ->with([
            'data' => $data,
            'categorys'=>$categorys,
            'brands'=>$brands,
            'specs'=>$specs,
            'imgs'=>$imgs
        ]);
    }

    //查看
    public function show($id)
    {
        return $this->indexData()
        ->select(
            'product.*',
            'product_category.name as category_name',
            'brand.name as brand_name'
        );
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
        if (!Product::destroy($id)) return false;
        IQuery::destroyPic(new ProductImg, $id, 'img', 'product_id');
        ProductImg::where('product_id',$id)->delete();
        Spec::where('product_id',$id)->delete();
        return true;
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
                Rule::unique('product')->ignore($id)->where(function($query) use ($id) {
                    $query->whereNull('deleted_at');
                })
            ], 
            'desc'=>'nullable|max:255',
            'details'=>'nullable',
            'brand_id'=>'required',
            'category_id'=>'required',
            'specs'=>'required',
            'delivery_price'=>'required|max:10',
            'stock'=>'required|max:15',
            'low_stock'=>'required|max:15',
            'effect'=>'required|max:255',
            'origin'=>'required|max:255',
            'date'=>'required',
            'state'=>'required',
            'grade'=>'required'
        ]);

        if ($id == -1) {
            $model = new Product;
        } else {
            $model = Product::find($id);
        }

        //接收数据 加入model
        $model->setRawAttributes($request->only(['name','brand_id','desc','category_id','stock','low_stock','effect','origin','date','grade','state','delivery_price','details']));

        if ($id == -1) $model->user_id = Auth::user()->id;

        //资源、上传图片名称、是否生成缩略图
        $res = IQuery::upload($request,'img',true,new Product,$id,'img');
        $model->img = $res['pic'];
        $model->thumb = $res['thumb'];

        if ($model->save()) {
            if ($id != -1) $model->id = $id;
            $this->imgsSave($request, $model->id);//处理多张图片
            $this->specSave(json_decode($request->specs), $id, $model->id);//处理规格
            return Redirect::to('admin/goods/list')->with('status', '保存成功');
        }
        return Redirect::back()->withErrors('保存失败');
    }

    //处理多张图片
    public function imgsSave($request, $id)
    {
        $res = IQuery::uploads($request, 'imgs', true);//批量图片处理
        if ($res != 'false') {
            foreach ($res as $pic) {
                $img = new ProductImg;
                $img->img = $pic['pic'];
                $img->thumb = $pic['thumb'];
                $img->product_id = $id;
                if (!$img->save()) return false;
            }
        }

        //编辑时删除关联图片
        if (isset($request->dels)) {
            $ids = explode(',', $request->dels);
            foreach ($ids as $id) {
                IQuery::destroyPic(new ProductImg, $id, 'img');
                ProductImg::destroy($id);
            }
        }
    }

    //处理规格
    public function specSave($data, $id, $mid)
    {
        foreach ($data as $v) {
            if ($v->name != '' && $v->price!= '') {
                if (!$v->id) {
                    $md = new Spec;
                } else{
                    $md = Spec::find($v->id);
                }
                $md->product_id = $mid;
                $md->state = $v->state;
                $md->price = $v->price;
                $md->name = $v->name;
                $md->save();
            }
        }
    }
}
