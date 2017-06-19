@extends('layouts.app')

@section('title')
登陆
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('fx/css/login.css') }}">
@endsection

@section('script')
    @parent
    <script src="{{ url('fx/js/login.js') }}"></script>
    <script>
        function submit() {
            $("#form").submit();

        }
        function re_captcha(){
            axios.get('/captcha')
                .then(function (res) {
                    $("#captcha").attr('src',res.data) 
                })
                .catch(function (err) {
                    console.log(err)
                })
        }
        function re_captcha1() {
            $url = "{{ URL('captcha') }}";
            $url = $url + "/" + Math.random();
            document.getElementById('captcha').src = $url;
        }
        re_captcha();
    </script>
@endsection

@section('content')
    <div class="content">
        <div class="head">
          <img src="fx/img/pic41.png" style="width: 300px;height: 300px">
        </div>
        <div class="contain">
            <form role="form" method="POST" id="form" action="{{ route('login') }}">
            <div class="number">
                <img src="fx/img/pic34.png" style="width: 20px;height:20px;vertical-align: middle;position: relative;left: 35px">
                <img src="fx/img/pic23.png" style="width: 250px;height:45px;vertical-align: middle;line-height: 60px">

                <input type="text" class="myName" name="name" placeholder="请输入用户名">
            </div>
             {{ csrf_field() }}

            <div class="add-name">请输入用户名</div>
            <div class="number">
                <img src="fx/img/pic35.png" style="width: 20px;height:20px;vertical-align: middle;position: relative;left: 35px">
                <img src="fx/img/pic23.png" style="width: 250px;height:45px;vertical-align: middle;line-height: 60px">
                <input type="password" class="password" name="password" placeholder="请输入密码">
            </div>
<!--             <div class="add-name">请输入验证码</div>
            <div class="number">
                <input type="text" name="captcha" class="right-main-input rmain-input-code" placeholder="请输入验证码">
                <a onclick="javascript:re_captcha();">
                    <img src="{{ URL('captcha') }}" id="captcha" class="verifi-code" alt="验证码" title="刷新图片" width="100" height="40"
                         id="verifi_code_image" border="0">
                </a>
            </div> -->
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
            <div class="add-password">请输入密码</div>
            <div class="choose">
                    <!-- <input type="radio" name="sex" value="male" checked='true' class="radio_left"> -->
                    <div class="radio_text">
                        <!-- <div class="radio_left_box radio_selected"></div> -->
                        <a href="{{ url('/reset') }}">忘记密码</a> 
                    </div>
                    <!-- <input type="radio" name="sex" value="female" style="margin-left: 20px" class="radio_right"> -->
                    <div class="radio_text">
                    <!-- <div class="radio_right_box"></div> -->
                        <a href="{{ url('/register') }}">注册账号</a> 
                    </div>
            </div>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif

            <div class="button" onclick="submit();"></div>
            </form>
        </div>
        <!--<div class="bottom">-->
            <!--<img src="../img/pic39.png" style="width: 100%;height: 300px">-->
        <!--</div>-->
    </div>
@endsection
