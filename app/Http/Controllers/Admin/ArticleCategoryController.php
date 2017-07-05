<?php
/*
 * user: 严能发
 * title: 文章分类
 * date: 2017/06/19
 * @version: 0.1 文章分类控制器
 * @author: gsl
 * @date: 2017/06/08
 * @description:数据增删查改
 *
 */
namespace App\Http\Controllers\Admin;

use App\ArticleCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Redirect;
use IQuery;

class ArticleCategoryController extends Controller
{
    //首页 (列表页)
    public function index(Request $request)
    {
        $lists = ArticleCategory::orderBy('id','desc');
        if ($request->name) {
            $lists = $lists->where('name','like','%'.$request->name.'%');
        }
        $lists = $lists->paginate(10);
        return view(config('app.theme').'.admin.article.category')->with('lists',$lists);
    }

    //查看单条信息
    public function show($id)
    {
        return Article::find($id); 
    }

    //数据创建
    public function create()
    {
        return view(config('app.theme').'.admin.article.category_create');
    }

    //保存新建数据
    public function store(Request $request)
    {
        return $this->StoreOrUpdate($request);
    }

    //编辑数据
    public function edit($id)
    {
        $data = ArticleCategory::find($id);
        return view(config('app.theme').'.admin.article.category_edit')->with(['data'=>$data]);
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
        IQuery::destroyPic(new ArticleCategory, $id, 'img'); //删除图片
        if (ArticleCategory::destroy($id)) return true;
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
            'name' => [
                'required',
                'max:50', 
                //name+软删除 唯一验证               
                Rule::unique('article_category')->ignore($id)->where(function($query) use ($id) { 
                    $query->whereNull('deleted_at');
                })
            ], 
            'desc'=>'nullable'
        ]);

        if ($id == -1) {
            $model = new ArticleCategory;
        } else {
            $model = ArticleCategory::find($id);
        }

        //接收数据 加入model
        $model->setRawAttributes($request->only(['name','desc']));

        //资源、上传图片名称、是否生成缩略图
        $imgs = IQuery::upload($request,'img',true);
        if ($imgs != 'false') {
            $model->img = $imgs['pic'];
            if ($id == -1 ) IQuery::destroyPic(new ArticleCategory, $id, 'img');
        }

        if ($model->save()) {
            return Redirect::to('admin/article/category')->with('status', '保存成功');
        }
        return Redirect::back()->withErrors('保存失败');

    }
}
