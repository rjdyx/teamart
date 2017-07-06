<?php
/*
 * @version: 0.1 积分商品活动控制器
 * @author: gsl
 * @date: 2017/06/13
 * @description:数据增删查改
 *
 */
namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductCategory;
use Redirect;
use IQuery;

class MarkController extends Controller
{
    //首页 (列表页)
    public function index(Request $request)
    {
        $name = $request->name;
        $lists = Product::where('grade',1)->orderBy('id','desc')
                ->where('name','like','%'.$name.'%')
                ->paginate(config('app.paginate5'));

        return view(config('app.theme').'.admin.activity.mark')->with('lists',$lists);
    }

    //查看单条信息
    public function show(Request $request)
    {
        return $this->sort($request);
    }

    //排序
    public function sort($request){
        $sort=$request->input("sort");
        $table_search =$request->input('table_search');

        if($table_search){
            $lists = Product::where('name','like','%'.$request->input("table_search").'%');
        }else{
            $lists=new Product;
        }
    }

    //数据创建
    public function create()
    {
        $lists = ProductCategory::get();
        return view(config('app.theme').'.admin.activity.mark_create')->with('lists',$lists);
    }

    //获取商品 分类作为条件
    public function getProduct(Request $request)
    {
        $id = $request->id;
        $data = Product::where('category_id',$id)
            ->where('grade',0)
            ->get();
        return $data;
    }

    //保存积分商品
    public function store(Request $request)
    {
        $this->validate($request, [
            'pid'=>'required'
        ]);
        $ids = $request->pid;

        foreach ($ids as $id) {
            $data = Product::find($id);        
            $data->grade = 1;
            if (!$data->save()) Redirect::back()->withErrors('添加积分商品失败');
        }
        return Redirect::to('/admin/activity/mark')->with('status','添加积分商品成功');
    }

    //批量将积分状态修改为0
    public function dels(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            if (!$this->updataGrade($id)) {
                return Redirect::back()->withErrors('批量删除失败');
            }
        }
        return Redirect::back()->with('status','批量删除成功');
    }

    //单条删除
    public function destroy($id)
    {
        if ($this->updataGrade($id)) return Redirect::back()->with('status','删除成功');
        return Redirect::back()->withErrors('删除失败');
    }

    //编辑保存
    public function updataGrade($id)
    {
        $data = Product::find($id);        
        $data->grade = 0;
        if ($data->save()) return 1;
        return 0;
    }
}
