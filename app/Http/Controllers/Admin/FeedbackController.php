<?php
/*
 * @version: 0.1 意见反馈控制器
 * @author: gsl
 * @date: 2017/06/09
 * @description:数据增删查改
 *
 */
namespace App\Http\Controllers\Admin;

use App\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use IQuery;

class FeedbackController extends Controller
{
    //首页 (列表页)
    public function index(Request $request)
    {
        $lists = Feedback::paginate(config('app.paginate10'));
        return view(config('app.theme').'.admin.feedback.index')->with('lists',$lists);
    }

    //查看单条信息
    public function show($id)
    {
        return Feedback::find($id);
    }

    //数据创建
    public function create()
    {
        return view(config('app.theme').'.admin.feedback.create');
    }

    //保存新建数据
    public function store(Request $request)
    {
        return $this->StoreOrUpdate($request);
    }

    //编辑数据
    public function edit($id)
    {
        $data = Feedback::find($id);
        return view(config('app.theme').'.admin.feedback.edit')->with('data',$data);
    }

    //编辑保存
    public function update(Request $request, $id)
    {
        return $this->StoreOrUpdate($request, $id);
    }

    //单条删除
    public function destroy($id)
    {
        $data = Feedback::find($id);
        if($data->delete()){
            IQuery::destroyPic(new Feedback, $id);//公共工具删除图片
            return Redirect::back()->withErrors('删除成功');
        }
        return Redirect::back()->withErrors('删除失败');
    }

    //保存方法
    public function StoreOrUpdate(Request $request, $id = -1)
    {
        $this->validate($request, [
            'contact' =>'null|max:100', 
            'content'=>'required|max:2000'
        ]);

        //判断 新增/编辑
        if ($id == -1) {
            $model = new Feedback;
        } else {
            $model = Feedback::find($id);
        }

        //接收数据 加入model
        $model->setRawAttributes($request->only(['content','contact']));

        //上传图片
        $pics = 'false';
        if ($request->hasFile('img')) $pics = IQuery::upload($request);
        if ($pics != 'false') {
            $model->img = $pics['pic'];
        }

        if ($id == -1) {
        	$model->user_id = Auth::user()->id;
        	$model->date = date('Y-m-d H:i:s',time());
        } else {
        	$model->id = $id;
        }

        //保存数据
        if($model->save()){
            return Redirect::to('admin/feedback')->with('status', '保存成功');
        }else{
            return Redirect::back()->withErrors('保存失败');
        }
    }
}
