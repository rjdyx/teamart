@extends('layouts.app')

@section('title')
绑定账号
@endsection

@section('css')
	<style>
		.desc{
			width:90%;
			height:180px;
			border:1px solid #D5AA7A;
			border-radius: 10px;
			margin: auto;
			margin-top:20px;
			padding: 10px;
			font-size:16px;
			margin-bottom: 20px;
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
			margin-top:10px;
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
			background:white;
			opacity:0.8;
		}
		.sub-next,.sub-per,.sub-bind{display: none;float: left;}
		.sub-y,.sub-n{width:100%;}
		#passMd,#emailMd,#phoneMd,#userMd,#nameMd{display: none;}
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
    	var type = 1;

        //有账号
        $(".sub-y").click(function(){
			show(false)
			type = 1;
        })

        //无账号
        $(".sub-n").click(function(){
			show(true)
			type = 0;
        })

        //显示的模块
        function show(isshow) { 
        	$(".sub-y").hide();
        	$(".sub-n").hide();
        	$("#passMd").css('display','block');
            $(".sub-per").css('display','block');
            $(".sub-bind").css('display','block');
            if (isshow){
           	    $("#nameMd").css('display','block');
           	    $("#emailMd").css('display','block');
            	$("#phoneMd").css('display','block');
            } else {
            	$("#userMd").css('display','block');
            }
        }

        // 上一步返回
        $(".sub-per").click(function(){
        	$("#passMd").hide();
            $("#emailMd").hide();
            $("#phoneMd").hide();
            $("#userMd").hide();
            $("#nameMd").hide();
            $("#email").val('');
            $("#phone").val('');
            $("#pass").val('');
            $("#name").val('');
            $("#user").val('');
            $(".sub-per").hide();
            $(".sub-bind").hide();
        	$(".sub-n").css('display','block');
        	$(".sub-y").css('display','block');
        })

        //绑定
        $(".sub-bind").click(function(){
    		var form = document.forms['form']
        	if (fieldCheck(form)) {
        		var params = {user: form['user'].value, pass: form['password'].value, parter_id: form['parter_id'].value,type:type}
        		if (!type) {
        			params['email'] = form['email'].value
        			params['phone'] = form['phone'].value
        			params['name'] = form['name'].value
        		}
        		bindUser(params)
        	}
        })

    	//字段验证
    	function fieldCheck(){
        	var pass = form['password'].value
        	if (type) {
        		var user = form['user'].value
        		if (user.length<1) {
        			alert('请输入用户名/邮箱/手机号')
        			return false
        		} else {
	        		if (user.length<4 || user.length>18) {
	        			alert('请输入4~18位 用户名/邮箱/手机号')
	        			return false
	        		}
        		}
        	} else {
	        	var email = form['email'].value
	        	var phone = form['phone'].value
	        	var name = form['name'].value
	        	if (name.length<1) {
        			alert('请输入用户名')
        			return false
        		} else {
	        		if (name.length<6 || name.length>18) {
	        			alert('请输入6~18位用户名')
	        			return false
	        		}
        		}
	        	if (email.length<1) {
        			alert('请输入邮箱')
        			return false
        		} else {
        			if (emailCheck (email)) {
        				alert('请输入正确的邮箱格式')
	        			return false
        			}
	        		if (email.length<8 || email.length>30) {
	        			alert('请输入8~30位邮箱')
	        			return false
	        		}
        		}
        		if (phone.length<1) {
        			alert('请输入手机号')
        			return false
        		} else {
        			if (phoneCheck (phone)) {
        				alert('请输入正确的手机格式')
	        			return false
        			}
        		}
        	}
    	    if (pass.length<1) {
    			alert('请输入密码')
    			return false
    		} else {
        		if (pass.length<6 || pass.length>18) {
        			alert('请输入6~18位密码')
        			return false
        		}
    		}
        	return true
    	}

    	function emailCheck (temp) {
	        var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	        if(!myreg.test(temp)) {
	            return true;
            }
            return false;
        }

        function phoneCheck (temp) {
        	var reg = /^1[3|4|5|7|8][0-9]{9}$/; //验证规则
			if (!reg.test(temp)) {
				return true;
			}
			return false;
        }

        function bindUser(params){
        	var url = '/bind/weixin'	
        	axios.post(url, params).then(function (res) {
        		var res = res.data
                if (res == 1) {
                	$(".default-info").hide();
                	$(".success").show();
                }else if(res == -1){
                	alert('账号已绑定其它微信')
                } else if (res == 0) {
                	alert('账号不存在')
                }else if (res == 2) {
                	alert('用户名或密码错误')
                }else if (res == 3) {
                	alert('注册失败')
                } else if (res == -2) {
                	alert('用户名已存在')
                } else if (res == -3) {
                	alert('邮箱已被使用')
                } else if (res == -4) {
                	alert('手机号已被使用')
                } else {
                	alert(res+ '未知错误')
                }
            })
        }
        alert("{{$parter_id}}");
    </script>
@endsection

@section('content')

<div class="login w-100 h-100 default-info">
	<div class="desc-title">绑定须知</div>
	<div class="desc">
		<p>1.请使用在该平台注册的账号或邮箱或手机号码来进行绑定</p>
		<p>2.如果你还未注册账号，请填入账号和邮箱和手机号进行注册绑定</p>
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
        <label for="name" class="field white block" id="nameMd">
            <i class="fa fa-user-o fz-16"></i>
            <input type="text" id="name" class="chayefont white fz-16" name="name" autocomplete="off" placeholder="用户名">
        </label>
        <label for="email" class="field white block" id="emailMd">
            <i class="fa fa-envelope-o fz-16"></i>
            <input type="text" id="email" class="chayefont white fz-16" name="email" autocomplete="off" placeholder="输入邮箱">
        </label>
        <label for="phone" class="field white block" id="phoneMd">
            <i class="fa fa-mobile fz-16"></i>
            <input type="text" id="phone" class="chayefont white fz-16" name="phone" autocomplete="off" placeholder="输入手机号">
        </label>
        <label for="password" class="field white block" id="passMd">
            <i class="fa fa-lock fz-16"></i>
            <input type="password" id="pass" class="chayefont white fz-16" name="password" autocomplete="off" placeholder="输入密码">
        </label>
        <div class="sub sub-y"><input type="button" value="有账号，直接绑定"></div>
        <div class="sub sub-n"><input type="button" value="无账号，注册绑定"></div>
        <div class="sub sub-per"><input type="button" value="上一步"></div>
        <div class="sub sub-bind"><input type="button" value="绑 定"></div>
	</form>
	</div>
</div>

<div class="success w-100 h-100 login">
	<div class="success1"><img src="{{url('')}}/fx/images/success.png" alt="">绑定成功</div>
	<div class="success2"><a href="{{url('')}}">返回首页</a></div>
</div>
@endsection