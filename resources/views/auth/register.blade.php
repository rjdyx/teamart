@extends('layouts.app')

@section('title') 用户注册 @endsection

@section('css')
@endsection

@section('script')
    @parent
    {!! Geetest::render('bind') !!}
    <script>
        function validate() {
            if (!_valid.name('用户名', $('#name').val())) {
                return false;
            }
            if (!_valid.password($('#password').val())) {
                return false;
            }
            if (!_valid.repassword($('#repassword').val())) {
                return false;
            }
            if (!_valid.email($('#email').val())) {
                return false;
            }
            if (!_valid.phone($('#phone').val())) {
                return false;
            }
            if (!_valid.ness('性别', document.forms['form']['gender'].value)) {
                return false;
            }
            return true;
        }
        function submitForm () {
            var pm = new Promise(function (resolve, reject) {
                if (_valid.checkField('name', $('#name').val(), 'user', '用户名') && _valid.checkField('email', $('#email').val(), 'user', '邮箱') && _valid.checkField('phone', $('#phone').val(), 'user', '手机')) {
                    resolve(true)
                } else {
                    reject(false)
                }
            })
            return pm
        }
        $('#name').on('input', function () {
            _valid.name('用户名', $(this).val())
        })
        .on('blur', function () {
            _valid.checkField('name', $(this).val(), 'user', '用户名')
        })
        $('#password').on('input', function () {
            _valid.password($(this).val())
        })
        $('#repassword').on('input', function () {
            _valid.repassword($(this).val())
        })
        $('#email').on('input', function () {
            _valid.email($(this).val())
        })
        .on('blur', function () {
            _valid.checkField('email', $(this).val(), 'user', '邮箱')
        })
        $('#phone').on('input', function () {
            _valid.phone($(this).val())
        })
        .on('blur', function () {
            _valid.checkField('phone', $(this).val(), 'user', '手机')
        })
        $('input[name="gender"]').on('change', function () {
            if ($(this)[0].checked) {
                $(this).parent().removeClass('fa-circle-thin').addClass('fa-circle')
                    .siblings().addClass('fa-circle-thin').removeClass('fa-circle')
            }
        })
    </script>
@endsection

@section('content')
    @include("layouts.backIndex")
    
    <!-- 绑定分销商数据 -->
    <?php 
        $v = '';
        if ($_GET) {
            foreach ($_GET as $value) {
                $v = base64_decode($value);
            }
        }
    ?>
    <div class="register">
        <div class="register_logo"></div>
        <p class="form_error chayefont"></p>
        <div class="register_form">
            <form method="POST" id="form" name="form" action="{{ route('register') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$v}}" name="agent_id">
                <label for="name" class="field">
                    <i class="fa fa-user-o"></i>
                    <input type="text" id="name" class="chayefont" name="name" autocomplete="off" placeholder="请输入用户名">
                </label>
                <label for="password" class="field">
                    <i class="fa fa-lock"></i>
                    <input type="password" id="password" class="chayefont" name="password" autocomplete="off" placeholder="请输入密码">
                </label>
                <label for="repassword" class="field">
                    <i class="fa fa-lock"></i>
                    <input type="password" id="repassword" class="chayefont" name="repassword" autocomplete="off" placeholder="请输入确认密码">
                </label>
                <label for="email" class="field">
                    <i class="fa fa-envelope-o"></i>
                    <input type="email" id="email" class="chayefont" name="email" autocomplete="off" placeholder="请输入邮箱">
                </label>
                <label for="phone" class="field">
                    <i class="fa fa-mobile fz-20"></i>
                    <input type="phone" id="phone" class="chayefont" name="phone" autocomplete="off" placeholder="请输入手机">
                </label>
                <div class="register_gender clearfix">
                    <label for="gender_male" class="pull-left fa fa-circle-thin">
                        男
                        <input type="radio" id="gender_male" class="chayefont invisibility" name="gender" value="0">
                    </label>
                    <label for="gender_female" class="fa fa-circle-thin pull-left">
                        女
                        <input type="radio" id="gender_female" class="chayefont invisibility" name="gender" value="1">
                    </label>
                </div>
                <div class="register_link">
                    <a class="pull-left chayefont" href="{{ url('/login') }}">
                        <!-- <i class="fa fa-circle-thin"></i> -->
                        已有账号
                    </a>
                    <a class="pull-left chayefont" href="{{ url('/login') }}">
                        <!-- <i class="fa fa-circle"></i> -->
                        注册说明
                    </a>
                </div>
                <label for="valid" class="submit">
                    <input type="button" id="valid">
                </label>
            </form>
        </div>
    </div>
@endsection
