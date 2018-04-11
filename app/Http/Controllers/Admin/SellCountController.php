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
        $years = $this->clientCountYear()['years'];//年份数据
        return view(config('app.theme').'.admin.sell.client')->with(['years'=>$years]);
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
        $datas = $this->orderYearCount();
        return view(config('app.theme').'.admin.sell.product')->with(['years'=>$datas]);
    }

    //订单年份统计
    public function orderYearCount(){
        $datas = Order::select(DB::raw('distinct date_format(created_at, "%Y") as year'))
            ->groupBy('year')
            ->orderBy('year','asc')
            ->get();
        $arrs = array();
        foreach ($datas as $data) {
            $arrs[] = $data->year;
        }
        return $arrs;
    }

    //订单、总金额 统计
    public function productCountOrder(Request $request, $agency = false){
        $year = date('Y');
        if($request->year) $year = $request->year;  

        $orders = array();
        $prices = array();
        for ($i=1; $i<13; $i++) {
            $orders[$i-1] = $this->orderReturnData($year, $i, $agency);
            $prices[$i-1] = $this->priceReturnData($year, $i, $agency);
        }
        return ['orders'=>$orders,'prices'=>$prices];
    }

    public function orderReturnData($year, $i, $agency){
        $order = Order::whereYear('created_at',$year)->whereMonth('created_at',$i);
        if ($agency) $order = $order ->whereNotNull('pid');
        return $order->count();
    }

    public function priceReturnData($year, $i, $agency){
        $price = Order::whereYear('created_at',$year)->whereMonth('created_at',$i);
        if ($agency) $price = $price ->whereNotNull('pid');
        return $price->sum('price');
    }

    //分销商统计
    public function agency () {
        $datas = $this->orderYearCount();
        return view(config('app.theme').'.admin.sell.agency')->with(['years'=>$datas]);
    }

    //分销商订单数量、销售额统计
    public function agencyCountOrder(Request $request){
        return $this->productCountOrder($request, true);
    }
}
