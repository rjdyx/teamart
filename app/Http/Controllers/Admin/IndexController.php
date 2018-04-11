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
    public function index () 
    {
        return view(config('app.theme').'.admin.index');
    }

    //销售情况
    public function sells () 
    {
    	$dates = $prices = $sells = array();
		for($i=0; $i<7; $i++) {
			$d = 6-$i;
			$date = date('Y-m-d',strtotime('-'.$d.'day'));
			$dates[$i] = date('m-d',strtotime('-'.$d.'day'));
			$sells[$i] = $this->orderReturnData($date);
			$prices[$i] = $this->priceReturnData($date);
		}
        return ['dates'=>$dates,'sells'=>$sells,'prices'=>$prices];
    }

    public function orderReturnData($date)
    {
       return $order = Order::whereDate('updated_at',$date)->where('type','order')->count();
    }

    public function priceReturnData($date)
    {
        $price = Order::whereDate('updated_at',$date)
       			->where('type','order')
       			->where('state','!=','padding')
       			->sum('price');
       	return $price;
    }
}
