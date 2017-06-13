<?php
/*
 * @version: 0.1 报表统计控制器
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

class SellCountController extends Controller
{
    //客户统计
    public function client () {
        return view(config('app.theme').'.admin.sell.client');
    }

    //商品统计
    public function product () {
        return view(config('app.theme').'.admin.sell.product');
    }

    //分销商统计
    public function agency () {
        return view(config('app.theme').'.admin.sell.agency');
    }
}
