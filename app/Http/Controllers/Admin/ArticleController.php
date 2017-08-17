<?php
/*
 * user: 严能发
 * @version: 0.1 文章控制器
 * @author: gsl
 * @date: 2017/06/08
 * @description:数据增删查改
 *
 */
namespace App\Http\Controllers\Admin;

use App\Article;
use App\ArticleCategory;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Redirect;
use IQuery;

class ArticleController extends Controller
{
    //首页 (列表页)
    public function index(Request $request)
    {
        $lists = Article::join('article_category','article.category_id','=','article_category.id')
        ->orderBy('article.id','desc')
        ->select('article_category.name as category_name','article.*')
        ->paginate(10);
        if ($request->name) {
            $lists = $lists->where('name','like','%'.$request->name.'%');
        }
        return view(config('app.theme').'.admin.article.list')->with('lists',$lists);
    }

    //查看单条信息
    public function show($id)
    { 
        return Article::find($id);
    }

    //数据创建
    public function create()
    {
        $lists = ArticleCategory::select('id','name')->get();
        return view(config('app.theme').'.admin.article.list_create')->with(['lists' => $lists]);
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
        $lists = ArticleCategory::select('id','name')->get();
        return view(config('app.theme').'.admin.article.list_edit')->with(['data' => $data, 'lists' => $lists]);
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
        IQuery::destroyPic(new Article, $id, 'img'); //删除图片
        if (Article::destroy($id)) return true;
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
                Rule::unique('article')->ignore($id)->where(function($query) use ($id) {
                    $query->whereNull('deleted_at');
                })
            ], 
            'category_id'=>'required'
        ]);

        if ($id == -1) {
            $model = new Article;
        } else {
            $model = Article::find($id);
        }

        //接收数据 加入model
        $model->setRawAttributes($request->only(['name','category_id','content']));

        //资源、上传图片名称、是否生成缩略图
        $imgs = IQuery::upload($request,'img',true,new Article, $id);
        $model->img = $imgs['pic'];
        $model->thumb = $imgs['thumb'];

        if ($model->save()) {
            return Redirect::to('admin/article/list')->with('status', '保存成功');
        }
        return Redirect::back()->withErrors('保存失败');
    }
}
