<?php
/*
 * @version: 0.1 已完成订单控制器
 * @author: gsl
 * @date: 2017/06/13
 * @description:数据增删查改
 *
 */
namespace App\Http\Controllers\Admin;

use App\Order;
use App\Product;
use App\OrderProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use IQuery;

class CloseController extends Controller
{
    //首页 (列表页)
    public function index(Request $request)
    {
        $lists = Order::join('user','order.user_id','=','user.id')
                ->leftjoin('user as puser','order.pid','=','puser.id');
        if (isset($request->serial))
        {
            $lists = $lists->where('order.serial','like','%'.$request->serial.'%');
        }
        $lists = $lists->where('order.state','=','close')
                    ->where('order.type','=','order')
                    ->orderBy('order.created_at','desc')
                    ->select('order.*','user.name as user_name','puser.name as puser_name')
                    ->paginate(config('app.paginate10'));
        return view(config('app.theme').'.admin.order.close')->with('lists',$lists);
    }

    //查看单条信息
    public function show($id)
    {
        $data = Order::join('user','order.user_id','=','user.id')
                ->leftjoin('user as puser','order.pid','=','puser.id')
                ->leftjoin('address','order.address_id','=','address.id')
                ->where('order.id','=',$id)
                ->orderBy('order.created_at','desc')
                ->select(
                    'order.*','puser.name as puser_name',
                    'user.name as user_name',
                    'address.name as address_name',
                    'address.province',
                    'address.city',
                    'address.area',
                    'address.detail',
                    'address.phone as address_phone'
                )->first();
        $products = Product::join('order_product','product.id','=','order_product.product_id')
                // ->join('product_group','product.group_id','=','product_group.id')
                // ->leftjoin('product_img','product_group.id','=','product_img.group_id')
                ->where('order_product.order_id','=',$id)
                ->distinct('product.id')
                ->select('product.*','order_product.price as price')//,'product_img.img as image'
                ->get();
        return view(config('app.theme').'.admin.order.close_show')->with(['data'=>$data,'products'=>$products]);
    }


}
