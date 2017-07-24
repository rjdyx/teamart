@extends('layouts.app')

@section('title') 个人资料 @endsection

@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('fx/mui/mui.picker.css') }}">
	<!-- <link rel="stylesheet" type="text/css" href="{{ asset('fx/mui/mui.css') }}"> -->
@endsection

@section('script')
	@parent
	<!-- <script src="http://localhost:8080/fx/build/resizeImg.js"></script> -->
	<script src="{{url('/fx/build/valid.js')}}"></script>
	<script src="{{url('/fx/build/resizeImg.js')}}"></script>
	<script src="{{ asset('fx/js/fixInput.js') }}"></script>
	<script src="{{ asset('fx/mui/js/mui.min.js') }}"></script>
	<script src="{{ asset('fx/mui/js/mui.picker.min.js') }}"></script>
	<!-- <script src="{{ asset('fx/mui/js/data.city.js') }}"></script> -->
	<script src="{{url('/fx/js/fixInput.js')}}"></script>
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
			$('.J_gender').on('tap', function () {
				$(this).addClass('active').siblings().removeClass('active')
			})

			// 上传图片改变时
			$('#img').on('change', function () {
				var file = $(this)[0].files[0]
				// if (file.size / 1024 > 200) {
				// 	prompt.message('图片太大')
				// 	return
				// }
				if (file.type !== 'image/png' && file.type !== 'image/jpeg') {
					prompt.message('图片格式只支持png和jpg')
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
			_valid.bindEvent(['realname', 'phone', 'email', 'password', 'repassword'])
			function submitForm(){
				var form = document.forms['form'];
				var params = {
					realname: form['realname'].value,
					phone: form['phone'].value,
					gender: form['gender'].value,
					email: form['email'].value,
					birth_date: form['birth_date'].value,
					password: form['password'].value,
					repassword: form['repassword'].value,
					// img: form['img'].files[0]
				}
				if (form['img'].files[0]) {
					if (form['img'].files[0].size / 1024 < 200) {
						params['img'] = form['img'].files[0]
						submitAjax(params)
					} else {
						resizeImg(form['img'].files[0])
						.then(function (blob) {
							params['img'] = blob
							submitAjax(params)
						})
					}
				} else {
					submitAjax(params)
				}
			}
			function submitAjax (params) {
				var url = $("form").attr('action');//当前编辑id
				if (_valid.validForm(params)) {
					prompt.loading('保存中')
					ajax('post', url, params, true, true)
						.then(function (resolve) {
							if (resolve) {
								// prompt.message('保存成功')
								prompt.message('保存成功', 'http://' + window.location.host + '/home/userinfo')
							} else {
								prompt.message('保存失败')
							}
						})
				} else {
					str = `请正确填写个人信息`
					// $('.form_item.error').each(function() {
					// 	str += $(this).find('label').text() + ','
					// })
					prompt.message(str)
				}
			}
		})
	</script>
@endsection

@section('content')

	@include("layouts.header-info")

	<div class="container useredit relative">
		<div class="useredit_info mb-10 relative">
			<label for="img" class="block avatar">
				<img class="w-100" id="avatar" src="{{url('')}}/{{Auth::user()->img}}">
			</label>
			<p class="useredit_name white fz-20 txt-c chayefont">{{Auth::user()->name}}</p>
			@if(Auth::user()->type==2)<p class="useredit_name chayefont white txt-c fz-16">推荐人：@if($data->pname){{$data->pname}}@else 无 @endif</p>@endif
		</div>
		<form action="{{url('home/user')}}/{{$data->id}}" id="form" enctype="multipart/form-data">
			<div class="form_item fz-16 chayefont">
				<label for="realname">姓名</label>
				<input type="text" name="realname" id="realname" class="pull-right txt-r color-8C8C8C block chayefont" autocomplete="off" placeholder="请输入姓名" value="{{$data->realname}}">
			</div>
			<div class="form_item fz-16 chayefont">
				<label for="gender">性别</label>
				<div class="pull-right">
					<label class="pull-left mr-20 relative block color-8C8C8C gender J_gender @if($data->gender == 0) active @endif" for="male">男</label>
					<label class="pull-left relative block color-8C8C8C gender J_gender @if($data->gender == 1) active @endif" for="female">女</label>
				</div>
				<input type="radio" name="gender" class="invisibility pull-right" id="male" value="0" @if($data->gender == 0) checked @endif>
				<input type="radio" name="gender" class="invisibility pull-right" id="female" value="1" @if($data->gender == 1) checked @endif>
			</div>
			<div class="form_item fz-16 chayefont">
				<label for="phone">手机</label>
				<input type="tel" name="phone" id="phone" data-required="true" class="pull-right txt-r color-8C8C8C block chayefont" autocomplete="off" placeholder="请输入手机号码" value="{{$data->phone}}">
			</div>
			<div class="form_item fz-16 chayefont">
				<label for="email">邮箱</label>
				<input type="email" name="email" id="email" data-required="true" class="pull-right color-8C8C8C txt-r block chayefont" autocomplete="off" placeholder="请输入邮箱" value="{{$data->email}}">
			</div>
			<div class="form_item fz-16 chayefont">
				<label for="birth_date">出生日期</label>
				<input type="hidden" name="birth_date" value="{{$data->birth_date}}"  id="useData_id">
				<div class="pull-right color-8C8C8C" id="useData">@if($data->birth_date){{$data->birth_date}} @else 请选择@endif<i class="fa fa-angle-down"></i></div>
			</div>
			<div class="form_item fz-16 chayefont">
				<label for="password">密码</label>
				<input type="password" name="password" id="password" class="pull-right txt-r color-8C8C8C block chayefont" autocomplete="off" placeholder="输入修改 (默认不输入)">
			</div>
			<div class="form_item fz-16 chayefont">
				<label for="password">确认密码</label>
				<input type="password" name="repassword" id="repassword" class="pull-right txt-r color-8C8C8C block chayefont" autocomplete="off" placeholder="输入密码后再确认密码">
			</div>
			<div class="filling">
				<input type="file" name="img" id="img" class="invisibility" accept="image/jpeg,image/jpg,image/png">
			</div>
		</form>
		<div class="chayefont bottom_btn white txt-c block fz-18 J_submit">确定保存</div>
	</div>
@endsection

