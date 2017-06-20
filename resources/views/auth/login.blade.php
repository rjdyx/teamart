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
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
            <div class="add-password">请输入密码</div>
            <div class="choose">
                <div class="radio_text">
                    <a href="{{ url('/reset') }}">忘记密码</a> 
                </div>
                <div class="radio_text">
                    <a href="{{ url('/register') }}">注册账号</a> 
                </div>
            </div>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
            <div class="number">
                {!! Geetest::render('bind') !!}
            </div>

            <div class="button" id="bid"></div>
            </form>
        </div>
        <!--<div class="bottom">-->
            <!--<img src="../img/pic39.png" style="width: 100%;height: 300px">-->
        <!--</div>-->
    </div>
@endsection
