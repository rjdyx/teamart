<?php
/*
 * @version: 0.1 文章控制器
 * @author: gsl
 * @date: 2017/06/08
 * @description:数据增删查改
 *
 */
namespace App\Http\Controllers\Admin;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use IQuery;

class ArticleController extends Controller
{
    //首页 (列表页)
    public function index(Request $request)
    {
        $lists = Article::join('article_category','article.category_id','=','article_category.id')
        ->select('article_category.name as category_name','article.*')
        ->paginate(config('app.paginate10'));
        return view(config('app.theme').'.admin.article.index')->with('lists',$lists);
    }

    //查看单条信息
    public function show($id)
    {
        return Article::find($id);
    }

    //数据创建
    public function create()
    {
        return view(config('app.theme').'.admin.article.create');
    }

    //保存新建数据
    public function store(Request $request)
    {
        return $this->StoreOrUpdate($request);
    }

    //编辑数据
    public function edit($id)
    {
        $data = Article::find($id);
        return view(config('app.theme').'.admin.article.edit')->with('data',$data);
    }

    //编辑保存
    public function update(Request $request, $id)
    {
        return $this->StoreOrUpdate($request, $id);
    }

    //单条删除
    public function destroy($id)
    {
        $data = Article::find($id);
        if($data->delete()){
            IQuery::destroyPic(new Article, $id);//公共工具删除图片
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
                Rule::unique('article_')->ignore($id)->where(function($query) use ($id) {
                    $query->where('category_id',$request->category_id)->whereNull('deleted_at');
                })
            ], 
            'category_id'=>'required',
            'content'=>'null|max:2000'
        ]);

        //判断 新增/编辑
        if ($id == -1) {
            $model = new Article;
        } else {
            $model = Article::find($id);
        }

        //接收数据 加入model
        $model->setRawAttributes($request->only(['name','content','category_id']));

        //上传图片
        $pics = 'false';
        if ($request->hasFile('img')) $pics = IQuery::upload($request);
        if ($pics != 'false') {
            $model->img = $pics['pic'];
            $model->thumb = $pics['pic_thumb'];
        }

        //保存数据
        if($model->save()){
            return Redirect::to('admin/Article')->with('status', '保存成功');
        }else{
            return Redirect::back()->withErrors('保存失败');
        }
    }
}
