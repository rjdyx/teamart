@extends('layouts.app')

@section('title') 地址管理 @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/css/addAddress.css') }}">
@endsection

@section('script')
    @parent
@endsection

@section('content')
	@include("layouts.header-info")
	<div class="addressadd">
		
	</div>
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
				<div class="item_input_container">
					<select>
						<option>请选择&gt;</option>
						<option>广东</option>
					</select>
				</div>
			</li>
			<li class="item_list">
				<span class="item_list_title">街道</span>
				<div class="item_input_container">请选择&gt;</div>
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
