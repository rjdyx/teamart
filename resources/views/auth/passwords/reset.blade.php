@extends('layouts.app')

@section('title')
重置密码
@endsection

@section('css')
@endsection

@section('script')
    @parent
    <script>
        function submitForm() {
            var form = document.forms['form']
            if (!_valid.password($('#password').val())) {
                return false;
            }
            if (!_valid.repassword($('#repassword').val())) {
                return false;
            }
            return true
        }
    </script>
@endsection

@section('content')
    @include("layouts.backIndex")
    <div class="reset">
        <div class="reset_step txt-c">
            <h1 class="fz-20 chayefont">重置密码</h1>
        </div>
        <p class="form_error formfont txt-c"></p>
        <div class="reset_form">
            <form method="POST" id="form" name="form" action="{{ url('password/reset') }}" onsubmit="return submitForm()">
            <input type="hidden" name="token" value="{{ $token }}">
                {{ csrf_field() }}
                <label for="password" class="field">
                    <i class="fa fa-lock"></i>
                    <input type="password" id="password" class="formfont" name="password" autocomplete="off" placeholder="请输入新密码">
                </label>
                <label for="repassword" class="field">
                    <i class="fa fa-lock"></i>
                    <input type="password" id="repassword" class="formfont" name="repassword" autocomplete="off" placeholder="请输入确认新密码">
                </label>
                <label for="valid" class="submit">
                    <input type="submit" id="valid">
                </label>
            </form>
        </div>
    </div>
@endsection
