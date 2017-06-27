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

		//唯一验证方法
		function check(name){
			var url = 'http://' + window.location.host;
			var params = {
                _token: $('meta[name="csrf-token"]').attr('content')
            }
            params['field'] = name;
            params['value'] = form[name].value;
            params['table'] = 'user';
            var pm = new Promise(function (resolve, reject) {
				axios.post(url + '/check', params)
	            .then(function (res) {
	                resolve(res.data)
	            }).catch(function (err) {
	                console.log(err)
	            })
	        })
	        return pm;
		}

		//表单提交
		$(".useredit_save").click(function(){
			if (!check('email')) return false;
			if (!check('phone')) return false;
			submitForm();
		});

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
                _token: $('meta[name="csrf-token"]').attr('content'),
            	_method: "PUT"
            }
	        axios.post(url, params)
            .then(function (res) {
            	var al = '成功';
                if (!res.data) {
                   	al = '失败';
                } else {
                	window.location.href = 'http://' + window.location.host + '/home/userinfo';
                }
                alert(al);
            }).catch(function (err) {
                console.log(err)
            })
		}
	</script>
@endsection

@section('content')

    @include("layouts.header-info")

	<div class="useredit">
		<div class="useredit_info mb-10">
			<label for="img" class="block useredit_avatar">
				<img src="{{url('fx/images/usercenter_avatar.png')}}">
			</label>
			<p class="useredit_name chayefont">{{Auth::user()->name}}</p>
			@if(Auth::user()->type==2)<p class="useredit_name chayefont fz-18">推荐人：@if($data->pname){{$data->pname}}@else 无 @endif</p>@endif
		</div>
		<form action="{{url('home/user')}}/{{$data->id}}" name="usereditform" id="form">
			<div class="useredit_item chayefont">
				<label for="realname">姓名</label>
				<input type="text" name="realname" id="realname" class="chayefont" autocomplete="off" placeholder="请输入姓名" value="{{$data->realname}}">
			</div>
			<div class="useredit_item chayefont">
				<label for="gender">性别</label>
				<div class="pull-right useredit_selection"><input type="radio" name="gender" value="0" checked>男</div>
				<div class="pull-right useredit_selection"><input type="radio" name="gender" value="1">女</div>
				<!-- <div class="pull-right useredit_selection">男<i class="fa fa-angle-down"></i></div> -->
			</div>
			<div class="useredit_item chayefont">
				<label for="phone">手机</label>
				<input type="tel" name="phone" id="phone" class="chayefont" autocomplete="off" placeholder="请输入手机号码" value="{{$data->phone}}">
			</div>
			<div class="useredit_item chayefont">
				<label for="email">邮箱</label>
				<input type="email" name="email" id="email" class="chayefont" autocomplete="off" placeholder="请输入邮箱" value="{{$data->email}}">
			</div>
			<div class="useredit_item chayefont">
				<label for="birth_date">出生日期</label>
				<input type="hidden" name="birth_date" value="{{$data->birth_date}}"  id="useData_id">
				<div class="pull-right useredit_selection" id="useData">@if($data->birth_date){{$data->birth_date}} @else 请选择@endif<i class="fa fa-angle-down"></i></div>
			</div>
			<div class="useredit_item chayefont">
				<label for="password">密码</label>
				<input type="password" name="password" id="password" class="chayefont" autocomplete="off" placeholder="输入修改 (默认不输入)">
			</div>
			<div class="useredit_item chayefont">
				<label for="password">确认密码</label>
				<input type="password" name="repassword" id="repassword" class="chayefont" autocomplete="off" placeholder="输入密码后再确认密码">
			</div>
			<input type="file" name="img" id="img" class="invisibility">
		</form>
		<div class="chayefont useredit_save">确定保存</div>
	</div>
@endsection

