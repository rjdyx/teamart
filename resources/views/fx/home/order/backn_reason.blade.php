@extends('layouts.app')

@section('title') 订单管理 @endsection

@section('css')
@endsection

@section('script')
    @parent
    <script>
    var data = ['','收到商品破损','商品错发、漏发','收到商品与描述不符'];
    	$("#submit").click(function(){
            var url = 'http://'+window.location.host + '/home/order/operate/backn';
            var params = {reason:data[$('#reason').val()],desc:$("#desc").val(),id:"{{$id}}"};
    		ajax('post', url, params).then(function (data) {
                if (data == 200) {
                    prompt.message('申请成功');
                    //跳转到申请处理页 待补充...
                } else {
                    prompt.message('申请失败！请稍后再试！');
                }
            })
    	});	
    </script>
@endsection

@section('content')

    @include("layouts.header-info")
    <div class="container order">
	    <select id="reason">
			<option value="">-退货理由-</option>
			<option value="1">收到商品破损</option>
			<option value="2">商品错发、漏发</option>
			<option value="3">收到商品与描述不符</option>
	    </select>
	    <p>其它理由：</p>
	    <textarea id="desc" cols="30" rows="10"></textarea>
	    <button id="submit">申请退货</button>
	    <button onclick="history.go(-1);">取消退货</button>
    </div>
    @include("layouts.footer")
@endsection