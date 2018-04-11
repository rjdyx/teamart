@extends('layouts.app')

@section('title')
重置密码
@endsection

@section('css')
@endsection

@section('script')
    @parent
    <script src="{{url('/fx/build/valid.js')}}"></script>
    <script src="{{url('/fx/js/fixInput.js')}}"></script>
    <script>
        function submitForm() {
            var form = document.forms['form']
            if (!_valid.email($('#email').val())) {
                return false;
            }
            if (!_valid.password($('#password').val())) {
                return false;
            }
            if (!_valid.repassword($('#repassword').val())) {
                return false;
            }
            return true
        }
        $(function () {
            if ("{{session('error')}}" == 'ok') {
                prompt.message('重置密码成功！正在跳转登录...','http://'+window.location.host+'/login');
            }
        })
        
    </script>
@endsection

@section('content')
    @include("layouts.backIndex")

    <div class="reset w-100 h-100">
        <div class="step txt-c">
            <h1 class="fz-20 w-100 chayefont">重置密码</h1>
        </div>
        <p class="form_error formfont txt-c fz-14">
            @if(!empty(session('error')) && session('error')!='ok')
             {{session('error')}}
            @endif
        </p>
        <div class="form_style p-10">
            <form method="POST" id="form" name="form" action="{{ url('password/resets') }}" onsubmit="return submitForm()">
            <input type="hidden" name="token" value="{{ $token }}">
                {{ csrf_field() }}
                <label for="email" class="field white block">
                    <i class="fa fa-lock fz-16"></i>
                    <input type="email" id="email" class="formfont white fz-16" name="email" autocomplete="off" placeholder="请输入绑定的邮箱">
                </label>
                <label for="password" class="field white block">
                    <i class="fa fa-lock fz-16"></i>
                    <input type="password" id="password" class="formfont white fz-16" name="password" autocomplete="off" placeholder="请输入新密码">
                </label>
                <label for="repassword" class="field white block">
                    <i class="fa fa-lock fz-16"></i>
                    <input type="password" id="repassword" class="formfont white fz-16" name="repassword" autocomplete="off" placeholder="请输入确认新密码">
                </label>
                <label for="valid" class="submit block">
                    <input type="submit" id="valid" class="invisibility">
                </label>
                <div class="filling"></div>
            </form>
        </div>
    </div>
@endsection
