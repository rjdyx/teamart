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
            if (!_valid.email($('#email').val())) {
                return false;
            }
            return true
        }
    </script>
@endsection

@section('content')
    @include("layouts.backIndex")
    <div class="email">
        <div class="email_step txt-c">
            <h1 class="fz-20 chayefont">发送邮箱</h1>
        </div>
        <p class="form_error formfont txt-c"></p>
        <div class="email_form">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" id="form" name="form" action="{{ url('password/email') }}" onsubmit="return submitForm()">
                {{ csrf_field() }}
                <label for="email" class="field">
                    <i class="fa fa-envelope"></i>
                    <input type="email" id="email" class="formfont" name="email" autocomplete="off" placeholder="请输入邮箱" value="{{ old('email') }}">
                </label>
                <label for="valid" class="submit">
                    <input type="submit" id="valid">
                </label>
            </form>
        </div>
    </div>
@endsection
