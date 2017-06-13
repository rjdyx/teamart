<?php
/*
 * @version: 0.1 后台首页控制器
 * @author: gsl
 * @date: 2017/06/13
 * @description:数据增删查改
 *
 */
namespace App\Http\Controllers\Admin;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use IQuery;

class IndexController extends Controller
{
    //首页
    public function index () {
        return view(config('app.theme').'.admin.index');
    }
}
