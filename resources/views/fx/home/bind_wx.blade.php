@extends('layouts.app')

@section('title')
绑定账号
@endsection

@section('css')
	<style>
		.desc{
			width:90%;
			height:200px;
			border:1px solid #D5AA7A;
			border-radius: 10px;
			margin: auto;
			margin-top:20px;
			padding: 10px;
			font-size:16px;
			margin-bottom: 40px;
		}
		.desc p{
			color:#907967;
			font-family: '楷体';
			margin-top:10px;	
		}
		.desc-title{
			text-align: center;
			font-size:20px;
			color:#D5AA7A;
			margin: auto;
			margin-top:30px;
		}
		.sub{
			width:50%;
			height: 50px;
			text-align: center;
			margin-top:40px;
			font-family: '楷体';
		}
		.sub input{
			border:1px solid #D5AA7A;
			border-radius: 5px;
			height:40px;
			min-width:90px;
			padding: 0px 5px;
			line-height: 30px;
			color:#D5AA7A;
			font-size:14px;
			background:none;
		}
		.sub-next{display: none;float: left;}
		.sub-per{display: none;float: left;}
		.sub-bind{width:100%;}
		#passMd{display: none;}
		.success1{
			width:60%;
			height:20%;
			margin: auto;
			text-align: center;	
			margin-top: 30%;
			font-size:13px;
			cursor: pointer;
			color:#D5AA7A;
		}
		.success1 img{
			width:100px;
			height:100px;
			margin: auto;
		}
		.success2{
			width:60%;
			height:20%;
			margin: auto;
			text-align: center;	
			margin-top: 150px;
		}
		.success2 a{
			font-size:18px;
			cursor: pointer;
			color:#D5AA7A;
		}
		.success{
			display: none;
		}
	</style>
@endsection

@section('script')
    @parent

    <script src="{{url('/fx/build/valid.js')}}"></script>
    <script src="{{url('/fx/js/fixInput.js')}}"></script>
    <script>
        function validate() {
            if (!_valid.ness('该字段', $('#name').val())) {
                return false;
            }
            if (!_valid.ness('密码', $('#password').val())) {
                return false;
            }
            return true;
        }

        //验证账号事件
        $(".sub-bind").click(function(){
        	var form = document.forms['form']
        	var params = {user: form['user'].value}
        	var $this = $(this)
        	ajax('get','/bind/user/check', params).then(function (res) {
        		var res = res.data
                if(res < 0){
                	alert('已被使用')
                } else {
                	$("form input[name='password']").val('');
                	$this.hide();
                	$("#userMd").hide();
                	$("#passMd").css('display','block');
                    $(".sub-per").css('display','block');
                    $(".sub-next").css('display','block');
                }
            })
        })

        //验证密码 及绑定
        $(".sub-next").click(function(){
        	var form = document.forms['form']
        	var params = {user: form['user'].value, pass: form['password'].value, parter_id: form['parter_id'].value}
        	var url = '/bind/pass/check'
        	bindUser(url, params)
        })

        // 上一步返回
        $(".sub-per").click(function(){
        	$("#passMd").hide();
            $(".sub-per").hide();
            $(".sub-next").hide();
        	$("#userMd").css('display','block');
        	$(".sub-bind").css('display','block');
        })

        function bindUser(url, params){
        	axios.post(url, params).then(function (res) {
        		var res = res.data
                if (res == 1) {
                	$(".default-info").hide();
                	$(".success").show();
                }else if(res == -1){
                	alert('账号已被使用')
                } else if (res == false || res == 'false' || res == 0) {
                	alert('绑定失败，请重试！')
                }else if (res == -2) {
                	alert('密码错误')
                } else {
                	alert(res+ '未知错误')
                }
            })
        }
    </script>
@endsection

@section('content')

<div class="login w-100 h-100 default-info">
	<div class="desc-title">绑定须知</div>
	<div class="desc">
		<p>1.请使用在该平台注册的账号或邮箱或手机号码来进行绑定</p>
		<p>2.如果你还未注册账号，请填入账号或邮箱或手机号进行注册绑定</p>
		<p>3.注意请输入有效的邮箱或手机号，方便找回密码</p>
	</div>
	<div class="form_style p-10">
	<form action="{{url('')}}/bind/weixin" method="POST" id="form" name="form">
		{{ csrf_field() }}
		<input type="hidden" name="parter_id" value="{{$parter_id}}">
		
        <label for="user" class="field white block" id="userMd">
            <i class="fa fa-user-o fz-16"></i>
            <input type="text" id="user" class="chayefont white fz-16" name="user" autocomplete="off" placeholder="用户名/手机号/邮箱">
        </label>
        <label for="password" class="field white block" id="passMd">
            <i class="fa fa-lock fz-16"></i>
            <input type="password" id="password" class="chayefont white fz-16" name="password" autocomplete="off" placeholder="输入密码">
        </label>
        <div class="sub sub-bind"><input type="button" value="绑 定"></div>
        <div class="sub sub-per"><input type="button" value="上一步"></div>
        <div class="sub sub-next"><input type="button" value="下一步"></div>
	</form>
	</div>
</div>

<div class="success w-100 h-100 login">
	<div class="success1"><img src="{{url('')}}/fx/images/success.png" alt="">绑定成功</div>
	<div class="success2"><a href="{{url('')}}">返回首页</a></div>
</div>
@endsection