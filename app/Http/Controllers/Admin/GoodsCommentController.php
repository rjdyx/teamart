<?php

namespace App\Http\Controllers\Admin;

/*
* user: 郭森林
* title: 用户评论
* date: 2017/06/19
 */
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Order;
use App\OrderProduct;
use App\Comment;
use App\Reply;
use App\Product;
use Redirect;
use IQuery;

class GoodsCommentController extends Controller
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
        $lists = $lists->select(
                    'comment.*','user.name as user_name',
                    'product.name as product_name',
                    'product_category.name as category_name' 
                )->orderBy('comment.created_at','desc')->paginate(10);

        $categorySelects = $this->indexData()->distinct('product_category.id')
        ->select('product_category.id','product_category.name')->get();

        return view(config('app.theme').'.admin.goods.comment')
               ->with(['lists'=>$lists,'categorySelects'=>$categorySelects]);
    }

    //数据查询
    public function indexData () {
        $lists = Comment::join('product','comment.product_id','=','product.id')
            ->join('product_category','product.category_id','=','product_category.id')
            ->join('user','comment.user_id','=','user.id')
            ->whereNull('product.deleted_at')
            ->whereNull('comment.deleted_at')
            ->whereNull('user.deleted_at');
        return $lists;
    }
    //创建
    public function create()
    {
    }

    //修改
    public function edit($id)
    {

    }

    //查看
    public function show($id)
    {
        $show = Comment::find($id);
        $replys = Reply::join('user','reply.auser_id','=','user.id')
                ->join('user as buser','reply.buser_id','=','buser.id')
                ->where('reply.comment_id','=',$id)
                ->orderBy('reply.created_at','asc')
                ->select('reply.*','user.name as aname','buser.name as bname')
                ->get();
        return view(config('app.theme').'.admin.goods.comment_show')
               ->with(['show'=>$show, 'replys'=>$replys]);
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
        if (Comment::destroy($id)) return true;
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
            'content'=>'required|max:2000',
        ]);

        $model = new Reply;
        $model->content = $request->content;
        $model->auser_id = Auth::user()->id;
        $model->buser_id = $request->bid;
        $model->comment_id = $request->id;

        if (!$model->save()) {
            if (!$img->save()) return Redirect::back()->withErrors('回复失败');
        }
        return Redirect::to('admin/goods/comment')->with('status', '回复成功');
    }

}
