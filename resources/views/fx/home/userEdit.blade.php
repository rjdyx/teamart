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
		$(function () {
			//日期插件初始化
			var myDate = new Date();
			var start_time_picker = new mui.DtPicker({"type":"date","beginYear":1960,"endYear":myDate.getFullYear()});
			$("#useData").on("tap", function(){
				setTimeout(function(){
					start_time_picker.show(function(items){
						$("#useData_id").val(items.text);
						$("#useData").html(items.text);
					});
				},200);
			});

			// 选择性别
			$('.J_gender').on('click tap', function () {
				$(this).addClass('active').siblings().removeClass('active')
			})

			// 上传图片改变时
			$('#img').on('change', function () {
				var file = $(this)[0].files[0]
				if (file.size / 1024 > 200) {
					prompt.error('图片太大')
					return
				}
				if (file.type !== 'image/png' && file.type !== 'image/jpeg') {
					prompt.error('图片格式只支持png和jpg')
					return
				}
				var fr = new FileReader()
				fr.onload = function (e) {
					$('#avatar').attr('src', e.target.result)
				}
				fr.readAsDataURL(file)
			})

			//表单提交
			$(".J_submit").click(function(){
				var temp = true
				Promise.all([
					_valid.check('email', $('#email').val()),
					_valid.check('phone', $('#phone').val())
				])
				.then(function (resolve) {
					resolve.forEach(function (v) {
						if (!v) {
							temp = false
						}
					})
					if (temp) {
						submitForm()
					}
				})
			});
			_valid.bindEvent(['realname', 'phone', 'email', 'password'])
			function submitForm(){
				var form = document.forms['form'];
				var url = $("form").attr('action');//当前编辑id
	            var params = {
	                realname: form['realname'].value,
	                phone: form['phone'].value,
	                gender: form['gender'].value,
	                email: form['email'].value,
	                birth_date: form['birth_date'].value,
	                password: form['password'].value,
	                img: form['img'].files[0]
	            }
	            if (_valid.validForm(params)) {
	                ajax('post', url, params, true, true)
		            	.then(function (resolve) {
		            		if (resolve) {
		            			prompt.message('保存成功', 'http://' + window.location.host + '/home/userinfo')
		            		} else {
		            			prompt.message('保存失败')
		            		}
		            	})
	            }
			}

		})
	</script>
@endsection

@section('content')

    @include("layouts.header-info")

	<div class="useredit">
		<div class="useredit_info mb-10">
			<label for="img" class="block useredit_avatar">
				<img id="avatar" src="{{url('fx/images/usercenter_avatar.png')}}">
			</label>
			<p class="useredit_name chayefont">{{Auth::user()->name}}</p>
			@if(Auth::user()->type==2)<p class="useredit_name chayefont fz-18">推荐人：@if($data->pname){{$data->pname}}@else 无 @endif</p>@endif
		</div>
		<form action="{{url('home/user')}}/{{$data->id}}" id="form">
			<div class="form_item chayefont">
				<label for="realname">姓名</label>
				<input type="text" name="realname" id="realname" class="chayefont" autocomplete="off" placeholder="请输入姓名" value="{{$data->realname}}">
			</div>
			<div class="form_item chayefont">
				<label for="gender">性别</label>
				<div class="pull-right">
					<label class="pull-left mr-20 gray J_gender @if($data->gender == 0) active @endif" for="male">男</label>
					<label class="pull-left gray J_gender @if($data->gender == 1) active @endif" for="female">女</label>
				</div>
				<input type="radio" name="gender" class="invisibility" id="male" value="0" @if($data->gender == 0) checked @endif>
				<input type="radio" name="gender" class="invisibility" id="female" value="1" @if($data->gender == 1) checked @endif>
			</div>
			<div class="form_item chayefont">
				<label for="phone">手机</label>
				<input type="tel" name="phone" id="phone" data-required="true" class="chayefont" autocomplete="off" placeholder="请输入手机号码" value="{{$data->phone}}">
			</div>
			<div class="form_item chayefont">
				<label for="email">邮箱</label>
				<input type="email" name="email" id="email" data-required="true" class="chayefont" autocomplete="off" placeholder="请输入邮箱" value="{{$data->email}}">
			</div>
			<div class="form_item chayefont">
				<label for="birth_date">出生日期</label>
				<input type="hidden" name="birth_date" value="{{$data->birth_date}}"  id="useData_id">
				<div class="pull-right gray" id="useData">@if($data->birth_date){{$data->birth_date}} @else 请选择@endif<i class="fa fa-angle-down"></i></div>
			</div>
			<div class="form_item chayefont">
				<label for="password">密码</label>
				<input type="password" name="password" id="password" class="chayefont" autocomplete="off" placeholder="输入修改 (默认不输入)">
			</div>
			<div class="form_item chayefont">
				<label for="password">确认密码</label>
				<input type="password" name="repassword" id="repassword" class="chayefont" autocomplete="off" placeholder="输入密码后再确认密码">
			</div>
			<input type="file" name="img" id="img" class="invisibility" accept="image/jpeg,image/jpg,image/png" capture="camera">
		</form>
		<div class="chayefont useredit_save J_submit">确定保存</div>
	</div>
@endsection

