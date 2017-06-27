@extends('layouts.app')

@section('title') 地址管理 @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/css/addAddress.css') }}">
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
        
        input {
            width: 90%;
            height: 40px;
            font-size: 18px;
            border: 1px solid #b72f20;
            border-radius: 5px;
            margin: 20px 5% 0 5%;
            padding: 5px;
        }
        
        h1 {
            background-color: #b72f20;
            color: #fff;
            font-size: 25px;
            text-align: center;
            padding: 10px;
        }
    </style>
@endsection

@section('script')
    @parent
<!--     <script src="{{ asset('fx/larea/js/LAreaData1') }}"></script>
    <script src="{{ asset('fx/larea/js/LAreaData2') }}"></script>
    <script src="{{ asset('fx/larea/js/LArea.js') }}"></script> -->
    <script>
        // var area1 = new LArea();
        // area1.init({
        //     'trigger': '#demo1', //触发选择控件的文本框，同时选择完毕后name属性输出到该位置
        //     'valueTo': '#value1', //选择完毕后id属性输出到该位置
        //     'keys': {
        //         id: 'id',
        //         name: 'name'
        //     }, //绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
        //     'type': 1, //数据源类型
        //     'data': LAreaData //数据源
        // });
        // area1.value=[1,13,3];//控制初始位置，注意：该方法并不会影响到input的value
        // var area2 = new LArea();
        // area2.init({
        //     'trigger': '#demo2',
        //     'valueTo': '#value2',
        //     'keys': {
        //         id: 'value',
        //         name: 'text'
        //     },
        //     'type': 2,
        //     'data': [provs_data, citys_data, dists_data]
        // });
    </script>
@endsection

@section('content')

	@include("layouts.header-info")

	<div class="addAddress_container">
		<ul>
			<li class="item_list">
				<span class="item_list_title">收货人</span>
				<div class="item_input_container"><input class="item_input" type="text" name="" placeholder="隔壁老王"></div>
			</li>
			<li class="item_list">
				<span class="item_list_title">联系电话</span>
				<div class="item_input_container"><input class="item_input" type="text" name="" placeholder="13560449011"></div>
			</li>
			<li class="item_list">
				<span class="item_list_title">所在地区</span>
				<div class="item_input_container">请选择<img class="right_arrow" src="{{ url('fx/img/right_arrow.png') }}"></div>
			</li>
			<li class="item_list">
				<span class="item_list_title">街道</span>
				<div class="item_input_container">请选择<img class="right_arrow" src="{{ url('fx/img/right_arrow.png') }}"></div>
			</li>
		</ul>
		<textarea class="addressDetail" placeholder="请填写详细地址，不少于5个字"></textarea>
		<div class="defaultAddress">
			<span>默认地址</span>
			<div class="img_container"><img class="defaultAddress_img" src="{{ url('fx/img/setDefault.png') }}"></div>
		</div>
	</div>

	<!-- 底部 -->
	<div class="bottom2">保存新地址</div>
@endsection
