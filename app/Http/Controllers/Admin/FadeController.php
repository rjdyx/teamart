<?php
/*
 * @version: 0.1 订单控制器
 * @author: gsl
 * @date: 2017/06/13
 * @description:数据增删查改
 *
 */
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\OrderProduct;
use Redirect;
use IQuery;

class FadeController extends Controller
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
        if (isset($request->state))
        {
            $lists = $lists->where('order.state','=',$request->state);
        }
        $lists = $lists->where('order.type','=','order')
                    ->where('order.state','!=','pading')
                    ->where('order.state','!=','paid')
                    ->where('order.state','!=','delivery')
                    ->where('order.state','!=','close')
                    ->where('order.state','!=','take')
                    ->orderBy('order.created_at','desc')
                    ->select('order.*','user.name as user_name','puser.name as puser_name')
                    ->paginate(config('app.paginate10'));
        return view(config('app.theme').'.admin.order.fade')->with('lists',$lists);
    }

    //编辑数据
    public function edit($id)
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
                )
                ->first();
        $products = Product::join('order_product','product.id','=','order_product.product_id')
                // ->join('product_group','product.group_id','=','product_group.id')
                // ->leftjoin('product_img','product_group.id','=','product_img.group_id')
                ->leftjoin('product_img','product.id','=','product_img.product_id')
                ->where('order_product.order_id','=',$id)
                ->distinct('product.id')
                ->select('product.*','product_img.img as image')
                ->get();
        return view(config('app.theme').'.admin.order.fade_edit')->with(['data'=>$data,'products'=>$products]);
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
            'state'=>'required'
        ]);

        $model = Order::find($id);
        $model->state = $request->state;
        if ($model->save()) {
            return Redirect::to('admin/order/fade')->with('status', '处理成功');
        }
        return Redirect::back()->withErrors('处理失败');

    }
}
