<?php
/*
 * @version: 0.1 广告控制器
 * @author: gsl
 * @date: 2017/06/13
 * @description:数据增删查改
 *
 */
namespace App\Http\Controllers\Admin;

use App\Ad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use IQuery;

class AdController extends Controller
{
    //首页 (列表页)
    public function index(Request $request)
    {
        $lists = new Ad;
        if ($request->title)
        {
            $lists = $lists->where('title','like','%'.$request->title.'%');
        }
         $lists = $lists->paginate(10);
        return view(config('app.theme').'.admin.system.ad')->with('lists',$lists);
    }

    //查看单条信息
    public function show($id)
    {
        return Ad::find($id);
    }

    //数据创建
    public function create()
    {
        return view(config('app.theme').'.admin.system.ad_create');
    }

    //保存新建数据
    public function store(Request $request)
    {
        return $this->StoreOrUpdate($request);
    }

    //编辑数据
    public function edit($id)
    {
        $data = Ad::find($id);
        return view(config('app.theme').'.admin.system.ad_edit')->with(['data'=>$data]);
    }

    //编辑保存
    public function update(Request $request, $id)
    {
        return $this->StoreOrUpdate($request, $id);
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
        IQuery::destroyPic(new Ad, $id, 'img'); //删除图片
        if (Ad::destroy($id)) return true;
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

    //保存方法
    public function StoreOrUpdate(Request $request, $id = -1)
    {
        $this->validate($request, [
            'title'=>'required|string|max:50',
            'desc'=>'nullable|string|max:255',
            'url'=>'nullable|string|max:255',
            'state'=>'required',
            'position'=>'required',
        ]);

        if ($id == -1) {
            $model = new Ad;
        } else {
            $model = Ad::find($id);
        }
        //接收数据 加入model
        $model->setRawAttributes($request->only(['title','state','position','desc','url']));

        if ($id != -1 && $request->del) {
            $model->img = null;
            $model->thumb = null;
            IQuery::destroyPic(new Ad, $id, 'img');
        }

        //资源、上传图片名称、是否生成缩略图
        $imgs = IQuery::upload($request,'img',true,new Ad);
        if (isset($imgs['pic'])) {
            $model->img = $imgs['pic'];
            $model->thumb = $imgs['thumb'];
        }

        if ($model->save()) {
            return Redirect::to('admin/system/ad')->with('status', '保存成功');
        }
        return Redirect::back()->withErrors('保存失败');
    }
}
