@extends('layouts.app')

@section('title')
重置密码
@endsection

@section('css')
@endsection

@section('script')
    @parent
    <script src="{{url('/fx/build/valid.js')}}"></script>
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

    <div class="reset">
        <div class="step txt-c">
            <h1 class="fz-20 chayefont">重置密码</h1>
        </div>
        <p class="form_error formfont txt-c fz-14">
            @if(!empty(session('error')) && session('error')!='ok')
             {{session('error')}}
            @endif
        </p>
        <div class="form_style">
            <form method="POST" id="form" name="form" action="{{ url('password/resets') }}" onsubmit="return submitForm()">
            <input type="hidden" name="token" value="{{ $token }}">
                {{ csrf_field() }}
                <label for="email" class="field white">
                    <i class="fa fa-lock"></i>
                    <input type="email" id="email" class="formfont white" name="email" autocomplete="off" placeholder="请输入绑定的邮箱">
                </label>
                <label for="password" class="field white">
                    <i class="fa fa-lock"></i>
                    <input type="password" id="password" class="formfont white" name="password" autocomplete="off" placeholder="请输入新密码">
                </label>
                <label for="repassword" class="field white">
                    <i class="fa fa-lock"></i>
                    <input type="password" id="repassword" class="formfont white" name="repassword" autocomplete="off" placeholder="请输入确认新密码">
                </label>
                <label for="valid" class="submit">
                    <input type="submit" id="valid">
                </label>
            </form>
        </div>
    </div>
@endsection
