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
		<a href="{{ url('/home/address/create') }}" class="chayefont address_add">添加新地址</a>
	</div>
	<div class="addAddress_container">
		<form name="addressform" method="POST" action="{{url('home/address')}}">
		{{csrf_field()}}
		<input type="hidden" name="user_id" value="{{$user_id}}">
		<ul>
			<li class="item_list">
				<span class="item_list_title">收货人</span>
				<div class="item_input_container"><input class="item_input" type="text" name="name" placeholder="隔壁老王"></div>
			</li>
			<li class="item_list">
				<span class="item_list_title">联系电话</span>
				<div class="item_input_container"><input class="item_input" type="text" name="phone" placeholder="13560449011"></div>
			</li>
			<li class="item_list">
				<span class="item_list_title">邮编</span>
				<div class="item_input_container"><input class="item_input" type="text" name="code" placeholder="526100"></div>
			</li>
			<li class="item_list">
				<span class="item_list_title">所在省份</span>
				<div class="item_input_container">
					<select name="province">
						<option value="">--请选择省份--</option>
						<option value="广东省">广东省</option>
						<option value="江苏省">浙江省</option>
						<option value="浙江省">江苏</option>
					</select>
				</div>
			</li>
			<li class="item_list">
				<span class="item_list_title">所在市</span>
				<div class="item_input_container">
					<select name="city">
						<option value="">--请选择市--</option>
						<option value="广州市">广州市</option>
						<option value="杭州市">杭州市</option>
						<option value="南京市">南京市</option>
					</select>
				</div>
			</li>
			<li class="item_list">
				<span class="item_list_title">所在区/县</span>
				<div class="item_input_container">
					<select name="area">
						<option value="">--请选择区--</option>
						<option value="天河区">天河区</option>
						<option value="上城区">上城区</option>
						<option value="玄武区">玄武区</option>
					</select>
				</div>
			</li>
		</ul>
		<textarea class="addressDetail" placeholder="请填写详细地址，不少于5个字" name="detail"></textarea>
		<div class="defaultAddress">
			<input type="checkbox" name="default" id="default">
			<label for="state">设为默认地址</label>
		</div>
	</div>
	<!-- 底部 -->
	<div class="bottom2">
		<input type="submit" name="submit" value="保存">
	</div>
	</form>
@endsection
