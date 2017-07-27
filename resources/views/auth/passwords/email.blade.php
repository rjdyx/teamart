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
        //判断邮箱是否存在
        function checkEmail() {
            var email = $.trim($('#email').val())
            var params = {email:email}
            return ajax('get', '/check/email', params).then(function (res) {
                if (res) {
                    return true
                } else{
                    $('.form_error').text('邮箱不存在')
                    return false
                }
            })
        }

        function submitForm() {
            var form = document.forms['form']
            //邮箱是否存在
            if (!_valid.email($('#email').val())) {
                return false
            }
            if (!checkEmail()) {
                return false
            }
            return true
        }
    </script>
@endsection

@section('content')
    @include("layouts.backIndex")
    <div class="email w-100 h-100">
        <div class="step txt-c">
            <h1 class="fz-20 w-100 chayefont">发送邮箱</h1>
        </div>
        <p class="form_error formfont txt-c fz-14"></p>
        <div class="form_style p-10">

            <!-- 这个保留 -->
            @if (session('status'))
            <p>{{ session('status') }}</p>
            @endif

            <form method="POST" id="form" name="form" action="{{ url('password/email') }}" onsubmit="return submitForm()">
                {{ csrf_field() }}
                <label for="email" class="field white block">
                    <i class="fa fa-envelope fz-16"></i>
                    <input type="email" id="email" class="formfont white fz-16" name="email" autocomplete="off" placeholder="请输入邮箱" value="{{ old('email') }}">
                </label>
                <label for="valid" class="submit block">
                    <input type="submit" id="valid" class="invisibility">
                </label>
                <div class="filling"></div>
            </form>
        </div>
    </div>
@endsection
