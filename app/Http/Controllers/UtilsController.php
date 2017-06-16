<?php

namespace App\Http\Controllers;
/*
* user: 郭森林
* title: 公共接口控制器
* date: 2017/06/16
 */
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use DB;
use Redirect;

class UtilsController extends Controller
{
   //check 字段唯一验证
   public function check(Request $request)
   {
    $field = $request->field;
    $value = $request->value;
    $table = $request->table;
    $id = null;
    if ($request->id) $id = $request->id;
    $result = DB::table($table)
            ->whereNull($table.'.deleted_at')
            ->where($table.'.id','!=',$id)
            ->where($table.'.'.$field,'=',$value)
            ->first();
    if(empty($result))
        return response()->json('false');
    else
        return response()->json('true');
   }
}
