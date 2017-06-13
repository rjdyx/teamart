<?php
/*
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
use Redirect;
use IQuery;

class ArticleCategoryController extends Controller
{
    //首页 (列表页)
    public function index(Request $request)
    {
        $lists = ArticleCategory::paginate(config('app.paginate10'));
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
        return view(config('app.theme').'.admin.article.category_edit');
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
