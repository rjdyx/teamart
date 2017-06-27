@extends('layouts.app')

@section('title') 地址管理 @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/larea/css/LArea.css') }}">
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            -webkit-appearance: none; //去掉浏览器默认样式
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            -webkit-touch-callout: none;
            box-sizing: border-box;
        }
        
        html,
        body {
            margin: 0 auto;
            width: 100%;
            min-height: 100%;
            overflow-x: hidden;
            -webkit-user-select: none;
        }
        
        body {
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            -webkit-text-size-adjust: 100%; //关闭自动调整字体
            -webkit-overflow-scrolling: touch;
            overflow-scrolling: touch;
        }
    </style>
@endsection

@section('script')
    @parent
    <script src="{{ asset('fx/larea/js/LAreaData1.js') }}"></script>
    <script src="{{ asset('fx/larea/js/LArea.js') }}"></script>
    <script>
        var area1 = new LArea();
        area1.init({
            'trigger': '#demo1', //触发选择控件的文本框，同时选择完毕后name属性输出到该位置
            'valueTo': '#value1', //选择完毕后id属性输出到该位置
            'keys': {
                id: 'id',
                name: 'name'
            }, //绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
            'type': 1, //数据源类型
            'data': LAreaData //数据源
        });
        area1.value=[1,13,3];//控制初始位置，注意：该方法并不会影响到input的value
        $('#defualtAddress').click(function(){
			var v = $("input[name='state']").val();
			if (v > 0) {
				$('.hiddeni').removeClass('active');
				$("input[name='state']").val(0);
			} else {
				$('.hiddeni').addClass('active');
				$("input[name='state']").val(1);
			}
		});
		
    </script>
@endsection

@section('content')
	@include("layouts.header-info")

	<div class="addressadd">
		<form action="#" name="addressform">
			<div class="addressadd_item chayefont">
				<label for="name">收货人</label>
				<input type="text" name="name" id="name" class="chayefont" autocomplete="off" placeholder="请输入收货人名称">
			</div>
			<div class="addressadd_item chayefont">
				<label for="phone">联系电话</label>
				<input type="tel" name="phone" id="phone" class="chayefont" autocomplete="off" placeholder="请输入收货人名称">
			</div>
			<div class="addressadd_item chayefont">
				<label for="region">所在地区</label>
		        <input type="text" id="demo1" name="address" readonly="" placeholder="城市选择特效"  value="广东省,广州市,天河区"/>
		        <input id="value1" type="hidden" value="20,234,504"/>
				<!-- <div class="pull-right addressadd_selection J_msa">请选择<i class="fa fa-angle-right"></i></div> -->
			</div>
			<div class="addressadd_item chayefont">
				<label for="code">邮编</label>
				<input type="number" name="code" id="code" class="chayefont" placeholder="请输入邮编">
			</div>
			<div class="addressadd_item">
				<textarea name="detail" placeholder="请填写详细地址，不少于5个字"></textarea>
			</div>
			<div class="addressadd_item mt-20" id="defualtAddress">
				<label for="state" class="block">
					默认地址
					<i class="pull-right address_default hiddeni"></i>
				</label>
				<input type="hidden" name="state" id="state" value="0">
			</div>
		</form>
		<div class="chayefont address_add">保存地址</div>
	</div>
@endsection
