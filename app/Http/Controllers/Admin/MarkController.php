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
use Redirect;
use IQuery;

class MarkController extends Controller
{
    //首页 (列表页)
    public function index(Request $request)
    {


        if($request->sort!=0){
            return $this->sort($request);
        }else{
        $lists = Product::where('grade',1)->orderBy('id','asc')->paginate(config('app.paginate5'));
        return view(config('app.theme').'.admin.activity.mark')->with('lists',$lists);
        }
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
        if($sort==11){
            $lists =$lists->where('grade',1)->where('state',1)->paginate(config('app.paginate5'));
            return view(config('app.theme').'.admin.activity.mark')->with('lists',$lists);
        }
        if($sort==12){
            $lists =$lists->where('grade',1)->where('state',0)->paginate(config('app.paginate5'));
            return view(config('app.theme').'.admin.activity.mark')->with('lists',$lists);
        }
        if($sort==10){
            $lists =$lists->where('grade',1)->orderBy('id','asc')->paginate(config('app.paginate5'));
            return view(config('app.theme').'.admin.activity.mark')->with('lists',$lists);
        }
        if($sort==21){
            $lists =$lists->where('grade',0)->where('state',1)->paginate(config('app.paginate5'));
            return view(config('app.theme').'.admin.activity.mark_create')->with('lists',$lists);
        }
        if($sort==22){
            $lists =$lists->where('grade',0)->where('state',0)->paginate(config('app.paginate5'));
            return view(config('app.theme').'.admin.activity.mark_create')->with('lists',$lists);
        }
        if($sort==20){
            $lists =$lists->where('grade',0)->orderBy('id','asc')->paginate(config('app.paginate5'));
            return view(config('app.theme').'.admin.activity.mark_create')->with('lists',$lists);
        }



    }

    //数据创建
    public function create()
    {
        $lists=Product::where('grade',0)->orderBy('id','asc')->paginate(config('app.paginate5'));
        return view(config('app.theme').'.admin.activity.mark_create')->with('lists',$lists);
    }

    //保存新建数据
    public function store(Request $request)
    {
        return $this->StoreOrUpdate($request);
    }

    //将积分状态修改为0
    public function edit($id)
    {
        $lists=Product::where('id',$id)->get();
        foreach($lists as $list){
            if($list->grade==1){
                $lists=Product::where('id',$id)->update(['grade'=>0]);
                if($lists){
                    return Redirect::back()->withErrors('删除成功');
                }
                return Redirect::back()->withErrors('删除失败');
            }else{
                $lists=Product::where('id',$id)->update(['grade'=>1]);
                if($lists){
                    return Redirect::back()->withErrors('添加积分商品成功');
                }
                return Redirect::back()->withErrors('添加积分商品失败');
            }
        }


    }
    //批量将积分状态修改为0
    public function dels(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            if (!$this->edit($id)) {
                return Redirect::back()->withErrors('批量删除失败');
            }
        }
        return Redirect::back()->with('status','批量删除成功');
    }

    //编辑保存
    public function update(Request $request, $id)
    {
        return $this->StoreOrUpdate($request, $id);
    }

    //单条删除
    public function destroy($id)
    {
        return Redirect::back()->withErrors('删除失败');
    }


    //保存方法
    public function StoreOrUpdate(Request $request, $id = -1)
    {
        $this->validate($request, [
  
        ]);

    }
}
