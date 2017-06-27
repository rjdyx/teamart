@extends('layouts.app')

@section('title') 个人资料 @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/mui/mui.picker.css') }}">
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('fx/mui/mui.css') }}"> -->
@endsection

@section('script')
    @parent
	<script src="{{ asset('fx/mui/js/mui.min.js') }}"></script>
	<script src="{{ asset('fx/mui/js/mui.picker.min.js') }}"></script>
	<script src="{{ asset('fx/mui/js/data.city.js') }}"></script>
	<script>
		var start_time_picker = new mui.DtPicker({"type":"date","beginYear":1960,"endYear":2020});
		$("#useData").on("tap", function(){
			setTimeout(function(){
				start_time_picker.show(function(items){
					$("#useData_id").val(items.text);
					$("#useData").html(items.text);
				});
			},200);
		});
	</script>
@endsection

@section('content')

    @include("layouts.header-info")

	<div class="useredit">
		<div class="useredit_info mb-10">
			<label for="img" class="block useredit_avatar">
				<img src="{{url('fx/images/usercenter_avatar.png')}}">
			</label>
			<p class="useredit_name chayefont">王宝强</p>
			<p class="useredit_name chayefont fz-18">推荐人：隔壁老王</p>
		</div>
		<form action="#" name="usereditform">
			<div class="useredit_item chayefont">
				<label for="realname">姓名</label>
				<input type="text" name="realname" id="realname" class="chayefont" autocomplete="off" placeholder="请输入姓名">
			</div>
			<div class="useredit_item chayefont">
				<label for="gender">性别</label>
				<input type="hidden" name="gender" value="">
				<div class="pull-right useredit_selection">男<i class="fa fa-angle-down"></i></div>
			</div>
			<div class="useredit_item chayefont">
				<label for="phone">手机</label>
				<input type="tel" name="phone" id="phone" class="chayefont" autocomplete="off" placeholder="请输入手机号码">
			</div>
			<div class="useredit_item chayefont">
				<label for="email">邮箱</label>
				<input type="email" name="email" id="email" class="chayefont" autocomplete="off" placeholder="请输入邮箱">
			</div>
			<div class="useredit_item chayefont">
				<label for="birth_date">出生日期</label>
				<input type="hidden" name="birth_date" value=""  id="useData_id">
				<div class="pull-right useredit_selection" id="useData">请选择<i class="fa fa-angle-down"></i></div>
			</div>
			<div class="useredit_item chayefont">
				<label for="password">密码</label>
				<input type="password" name="password" id="password" class="chayefont" autocomplete="off" placeholder="请输入密码">
			</div>
			<div class="useredit_item chayefont">
				<label for="password">确认密码</label>
				<input type="password" name="repassword" id="repassword" class="chayefont" autocomplete="off" placeholder="请输入确认密码">
			</div>
			<input type="file" name="img" id="img" class="invisibility">
		</form>
		<div class="chayefont useredit_save">确定保存</div>
	</div>
@endsection

