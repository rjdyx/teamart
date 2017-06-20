<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" style="height: 100%;width:100%;">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 避免IE使用兼容模式 -->
    <!-- 针对手持设备优化，主要是针对一些老的不识别viewport的浏览器，比如黑莓 -->
    <meta name="HandheldFriendly" content="true">
    <!-- 微软的老式浏览器 -->
    <meta name="MobileOptimized" content="320">
    <!-- uc强制竖屏 -->
    <meta name="screen-orientation" content="portrait">
    <!-- QQ强制竖屏 -->
    <meta name="x5-orientation" content="portrait">
    <!-- UC强制全屏 -->
    <meta name="full-screen" content="yes">
    <!-- QQ强制全屏 -->
    <meta name="x5-fullscreen" content="true">
    <!-- UC应用模式 -->
    <meta name="browsermode" content="application">
    <!-- QQ应用模式 -->
    <meta name="x5-page-mode" content="app">
    <!-- windows phone 点击无高光 -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- iOS 设备 end -->
    <meta name="msapplication-TileColor" content="#000"/>
    <!-- Windows 8 磁贴颜色 -->
    <meta name="msapplication-TileImage" content="icon.png"/>
    


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>后台登录</title>

	<link rel="stylesheet" href="{{url('/admin/build/css/index.css')}}">
	{{-- <link rel="stylesheet" href="http://localhost:8080/admin/build/css/index.css"> --}}
	<style type="text/css">
		.login_box{
			display: flex;
		}
		.login_foget_pwd,.login_register{
			flex: 1
		}
	</style>

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body class="hold-transition login-page" style="height: auto">

    



	<div class="login-box">
	  <div class="login-logo">
	    <a href="javascript:;"><b>分销后台</b>管理</a>
	  </div>
	  <!-- /.login-logo -->
	  <div class="login-box-body">
	    <p class="login-box-msg">用户登录</p>

	    <form action="/admin/login" method="POST" name="loginForm">
	    {{ csrf_field() }}
	      <div class="form-group has-feedback">
	        <input type="text" class="form-control" name="name" placeholder="账号">
	        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
	      </div>
	      <div class="form-group has-feedback">
	        <input type="password" class="form-control" name="password" placeholder="密码">
	        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
	      </div>
	      <div class="form-group has-feedback">
            <input type="text" name="captcha" class="form-control" placeholder="请输入验证码">
            <a onclick="javascript:re_captcha();">
                <img src="" id="captcha" class="verifi-code" alt="验证码" title="刷新图片" width="100" height="40" id="verifi_code_image" border="0">
            </a>
          </div>
	      <div class="row">
<!-- 	        <div class="col-xs-8">
	          <div class="checkbox icheck">
	            <label>
	              <input type="checkbox">记住我
	            </label>
	          </div>
	        </div> -->
	        <!-- /.col -->
	        <div class="col-xs-12">
	          <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
	        </div>
	        <!-- /.col -->
	      </div>
	    </form>

	    <div class="login_box">
	      <!-- <a href="#" class="login_foget_pwd text-center" >忘记密码</a><br> -->
	      <!-- <a href="register.html" class="login_register text-center">注册新账号</a> -->
	    </div>

	  </div>
	  <!-- /.login-box-body -->
	</div>
	
	<script src="{{url('/admin/build/vendor-bundle.js')}}"></script>
	<script src="{{url('/admin/build/index.js')}}"></script>
    {{-- <script src="http://localhost:8080/admin/build/vendor-bundle.js"></script>
    <script src="http://localhost:8080/admin/build/index.js"></script> --}}

	<script>
		// $(function () {
		// 	$('input').iCheck({
		// 		checkboxClass: 'icheckbox_square-blue',
		// 		radioClass: 'iradio_square-blue',
		// 		increaseArea: '20%' // optional
		// 	});
		// });
		$(function () {
			function re_captcha(){
	            axios.get('/captcha')
	                .then(function (res) {
	                    $("#captcha").attr('src',res.data) 
	                })
	                .catch(function (err) {
	                    console.log(err)
	                })
	        }
	        re_captcha();
		})
	</script>

</body>
</html>
