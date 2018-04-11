<?php
/*
 * @version: 0.1 日志制器
 * @author: gsl
 * @date: 2017/06/13
 * @description:数据增删查改
 *
 */
namespace App\Http\Controllers\Admin;

use App\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use IQuery;

class LogController extends Controller
{
    //首页 (列表页)
    public function index(Request $request)
    {
        $lists = Log::Join('user','log.user_id','=','user.id')
                ->orderBy('id','desc');
        if (isset($request->date))
        {
            $lists = $lists->where('log.created_at','>',$request->date);
        }
        $lists = $lists->select('log.*','user.name')
        ->paginate(config('app.paginate10'));
        return view(config('app.theme').'.admin.system.log')->with('lists',$lists);
    }

    //单条删除
    public function destroy($id)
    {
        if (Log::find($id)->forceDelete())
        {
            return Redirect::back()->with('删除成功');
        }
        return Redirect::back()->withErrors('删除失败');
    }


    //批量删除
    public function dels(Request $request)
    {
        $ids = explode(',', $request->ids);
        if (Log::whereIn('id',$ids)->forceDelete())
        {
            return Redirect::back()->with('批量删除成功');
        }
        return Redirect::back()->withErrors('批量删除失败');
    }

}
