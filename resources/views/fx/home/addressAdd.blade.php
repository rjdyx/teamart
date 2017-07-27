@extends('layouts.app')

@section('title') 地址管理 @endsection

@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('fx/larea/css/LArea.css') }}">
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
    </style> --}}
@endsection

@section('script')
    @parent
    <script src="{{url('/fx/build/valid.js')}}"></script>
    <script src="{{url('/fx/build/areaSelector.js')}}"></script>
    <!-- <script src="{{ asset('fx/larea/js/LAreaData1.js') }}"></script> -->
    <script src="{{ asset('fx/mui/js/data.city.js') }}"></script>
    <!-- <script src="{{ asset('fx/larea/js/LArea.min.js') }}"></script> -->
	<script src="{{url('/fx/js/fixInput.js')}}"></script>
    <script>
        // var area1 = new LArea();
        // area1.init({
        //     'trigger': '#address', //触发选择控件的文本框，同时选择完毕后name属性输出到该位置
        //     'valueTo': '#value1', //选择完毕后id属性输出到该位置
        //     'keys': {
        //         id: 'id',
        //         name: 'name'
        //     }, //绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
        //     'type': 1, //数据源类型
        //     'data': LAreaData //数据源
        // });
        // area1.value=[1,13,3];//控制初始位置，注意：该方法并不会影响到input的value
        $(function () {
        	var areaSelector = new AreaSelector()
	        areaSelector.init({
	        	data: init_city_picker,
	        	trigger: '.addressadd_selection',
	        	txtTo: '#address',
	        	valueTo: '#addressValue'
	        })
	        $('.J_defualtAddress').click(function(){
				var v = $("input[name='state']").val();
				if (v > 0) {
					$(this).find('i').removeClass('active');
					$("input[name='state']").val(0);
				} else {
					$(this).find('i').addClass('active');
					$("input[name='state']").val(1);
				}
			});
			_valid.bindEvent(['name', 'phone', 'code', 'detail', 'address'])
			$('.J_submit').on('tap', function () {
				var params = {
					name: $('#name').val(),
					phone: $('#phone').val(),
					code: $('#code').val(),
					detail: $('#detail').val(),
					address: $('#address').val(),
					state: $('#state').val()
				}
				if (_valid.validForm(params)) {
					prompt.loading('保存中')
					ajax('post', '/home/address', params)
						.then(function (resolve) {
							if (resolve) {
								// prompt.message('新增成功', 'history')
								prompt.message('新增成功', 'http://' + window.location.host + '/home/address')
							} else {
								prompt.message('新增失败')
							}
						})
				}
			})
        })
        
    </script>
@endsection

@section('content')
	@include("layouts.header-info")
	<div class="container relative addressadd">
		<form action="#" name="addressform">
			<div class="form_item chayefont fz-16">
				<label for="name">收货人</label>
				<input type="text" name="name" id="name" class="pull-right block txt-r chayefont" data-required="true" autocomplete="off" placeholder="请输入收货人名称">
			</div>
			<div class="form_item chayefont fz-16">
				<label for="phone">联系电话</label>
				<input type="tel" name="phone" id="phone" class="pull-right block txt-r chayefont" data-required="true" autocomplete="off" placeholder="请输入联系电话">
			</div>
			<div class="form_item chayefont fz-16">
				<label for="region">所在地区</label>
		        <span class="pull-right block color-8C8C8C addressadd_selection">选择地区</span>
		        <input id="address" name="address" data-required="true" type="hidden"/>
		        <input id="addressValue" name="addressValue" type="hidden"/>
			</div>
			<div class="form_item chayefont fz-16">
				<label for="code">邮编</label>
				<input type="number" name="code" id="code" class="pull-right block txt-r chayefont" data-required="true" placeholder="请输入邮编">
			</div>
			<div class="form_item fz-16">
				<textarea class="w-100" name="detail" id="detail" data-required="true" placeholder="请填写详细地址，不少于5个字"></textarea>
			</div>
			<div class="form_item fz-16 mt-20 J_defualtAddress">
				<label for="state" class="block">
					默认地址
					<i class="pull-right block address_default"></i>
				</label>
				<input type="hidden" name="state" id="state" value="0">
			</div>
			<div class="filling"></div>
		</form>
		<div class="chayefont block txt-c white fz-18 bottom_btn J_submit">保存地址</div>
	</div>
	<div class="areaSelector w-100 h-100">
		<div class="areaSelector_bg w-100 h-100"></div>
		<div class="areaSelector_container w-100">
			<div class="areaSelector_opts clearfix">
				<a href="javascript:;" class="pull-left fz-14 J_region_cancel">取消</a>
				<a href="javascript:;" class="pull-right fz-14 J_region_submit">确定</a>
			</div>
			<div class="areaSelector_area w-100 clearfix">
				<ul class="pull-left area_list province"></ul>
				<ul class="pull-left area_list city"></ul>
				<ul class="pull-left area_list area"></ul>
			</div>
		</div>
	</div>
@endsection
