@extends('layouts.app')

@section('title') 物流查询 @endsection

@section('css')
@endsection

@section('script')
    @parent
    <script>
        var url = 'http://'+window.location.host+'/home/order/delivery_data';
        //code:物流单号、 id:订单id 、coding快递公司编号
        var params = {id:"{{$data->id}}",code:"{{$data->delivery_serial}}",coding:"{{$data->coding}}"}
        // var params = {code:3333416009794,id:8025019758554139,coding:'STO'}
        ajax('get', url, params).then(function (data) {
            if (data) {
                var res = data;
                var tmp = '';
                for(var i= res.length-1;i>=0;i--) {
                    tmp += `<div class="orderdelivery_lists_process relative ${i == res.length-1 ? 'active' : ''}"><p class="mb-10">${res[i]['AcceptStation']}</p>
                    <p class="fz-12 txt-r">${res[i]['AcceptTime']}</p></div>`; 
                }
                $(".orderdelivery_lists").html(tmp);
            } else {
                prompt.message('查询失败！请稍后再试！');
            }
        })
    </script>
@endsection

@section('content')
    @include("layouts.header-info")

    @include("layouts.backIndex")
	<div class="container orderdelivery">
		<div class="orderdelivery_order_lists">
        @foreach($lists as $list)
            <div class="orderdelivery_warpper">
                <div class="warpper_img pull-left mr-20">
                    <img class="w-100" src="{{url('')}}/{{$list->thumb}}">
                </div>
                <div class="warpper_detail pull-left mr-20">
                    <h5 class="chayefont mb-10">{{$list->name}}</h5>
                    <p class="color-8C8C8C">{{$list->desc}}</p>
                </div>
                <div class="warpper_price pull-left txt-r">
                    <span class="block price">&yen;{{$list->price}}</span>
                    <del class="block price_raw color-8C8C8C">&yen;{{$list->raw_price * $list->amount}}</del>
                    <span class="block times color-8C8C8C">&times;{{$list->amount}}</span>
                </div>
            </div>
        @endforeach
		</div>
		<!-- <div class="orderdelivery_sender mt-20">
			由DD快递提供配送服务,xx配送员配送中
			<a href="tel:88888" class="pull-right color-F78223"><i class="fa fa-mobile"></i></a>
		</div> -->
		<div class="orderdelivery_lists w-100 mt-20">
<!-- 			<div class="orderdelivery_lists_process active">
				<p class="mb-10">sss</p>
				<p class="fz-12 txt-r">0000年00月00日 00时00分00秒</p>
			</div> -->
		</div>
	</div>
@endsection