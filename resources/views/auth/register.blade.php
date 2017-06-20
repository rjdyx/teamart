@extends('layouts.app')

@section('title') 用户注册 @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/css/register.css') }}">
@endsection

@section('script')
    @parent
    <script type="text/javascript" src="{{ url('fx/js/register.js') }}"></script>
@endsection

@section('content')
<style>
    .img1{width: 20px;height:20px;vertical-align: middle;position: relative;left: 35px;}
    .img2{width: 250px;height:45px;vertical-align: middle;line-height: 60px;}
    .img3{width: 250px;height:180px;}
    .img4{width: 25px;height:25px;}
</style>
    <div class="content">
        <div class="head">
            <img src="{{ url('fx/img/pic52.png') }}" class="img3">
        </div>
        <div class="contain">
            <form class="form" role="form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="number">
                    <img src="{{ url('fx/img/pic34.png') }}" class="img1">
                    <img src="{{ url('fx/img/pic31.png') }}" class="img2">
                    <input type="text" class="name" name="name" placeholder="用户名">
                    <div class="add-password">请输入用户名</div>
                </div>
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
                <div class="number">
                    <img src="{{ url('fx/img/pic35.png') }}" class="img1">
                    <img src="{{ url('fx/img/pic31.png') }}" class="img2">
                    <input type="password" class="password" name="password" placeholder="请输入密码">
                    <div class="add-password">请输入密码</div>
                </div>
                <div class="number">
                    <img src="{{ url('fx/img/pic35.png') }}" class="img1">
                    <img src="{{ url('fx/img/pic31.png') }}" class="img2">
                    <input type="password" class="password2" name="password2" placeholder="请确认密码">
                    <div class="add-password2">请输入确认密码</div>
                </div>
                <div class="number">
                    <img src="{{ url('fx/img/email.png') }}" class="img1">
                    <img src="{{ url('fx/img/pic31.png') }}" class="img2">
                    <input type="text" class="email" name="email" placeholder="邮箱">
                    <div class="add-email">请输入邮箱</div>
                </div>

                <div class="number">
                    <img src="{{ url('fx/img/phone.png') }}" class="img1">
                    <img src="{{ url('fx/img/pic31.png') }}" class="img2">
                    <input type="text" class="phone" name="phone" placeholder="手机">
                    <div class="add-phone">请输入手机</div>
                </div>

                <div class="choose">
                    <img src="{{ url('fx/img/man.png') }}" class="img4">
                    <input type="radio" name="sex" value="0" checked="true" style="    margin-right: 20%;cursor: pointer;">
                    <img src="{{ url('fx/img/woman.png') }}" class="img4">
                    <input type="radio" name="sex" value="1" style="cursor: pointer;">
                </div>

                <div class="choose">
                    <div class="radio_text">
                        <!-- <div class="radio_left_box"></div> -->
                        <a href="{{ url('/login') }}">已有账号</a> 
                    </div>
                    <div class="radio_text">
                        <!-- <div class="radio_right_box radio_selected"></div> -->
                        <a href="{{ url('/login') }}">注册说明</a>
                    </div>
                </div>
                <div class="button" id="bid"></div>
                <div class="number">
                    {!! Geetest::render('bind') !!}
                </div>
            </form>
        </div>
        <!-- <div class="bottom">
        <img src="{{ url('fx/img/pic50.png') }}" style="width: 100%;height: 150px">
        </div> -->
    </div>
@endsection
