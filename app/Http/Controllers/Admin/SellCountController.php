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
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use IQuery;
use DB;
class SellCountController extends Controller
{
    //客户统计
    public function client () {

        return view(config('app.theme').'.admin.sell.client');
    }

    //统计年份
    public function clientCountYear()
    {
        $years = User::select(DB::raw('distinct date_format(created_at, "%Y") as year'))
                ->groupBy('year')
                ->orderBy('year','asc')
                ->get();

        $yearValues = array();
        $newyears = array();
        foreach ($years as $year) {
            $newyears[] = $year->year;
            $yearValues[] = User::whereYear('created_at',$year->year)->count();
        }
        return ['years'=>$newyears, 'values'=>$yearValues];
    }

    //统计月份
    public function clientCountMonth(Request $request)
    {
        $year = date('Y');
        if ($request->year) $year = $request->year;

        $monthValues = array();
        for ($i=1; $i<13; $i++) {
            $monthValues[$i-1] = User::whereYear('created_at',$year)->whereMonth('created_at',$i)->count();
        }
        return $monthValues; 
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
