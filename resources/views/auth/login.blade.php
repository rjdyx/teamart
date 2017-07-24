@extends('layouts.app')

@section('title')
登陆
@endsection

@section('css')
@endsection

@section('script')
    @parent
    {!! Geetest::render('bind') !!}
    <script src="{{url('/fx/build/valid.js')}}"></script>
    <script src="{{url('/fx/js/fixInput.js')}}"></script>
    <script>
        function validate() {
            if (!_valid.ness('用户名', $('#name').val())) {
                return false;
            }
            if (!_valid.ness('密码', $('#password').val())) {
                return false;
            }
            return true;
        }
        function submitForm() {
            var form = document.forms['form']
            var params = {
                name: form['name'].value,
                password: form['password'].value
            }
            var pm = new Promise(function (resolve, reject) {
                axios.post('/login/check', params)
                    .then(function (res) {
                        if (res.data == 200) {
                            resolve(true)
                        } else if (res.data == 403) {
                            $('.form_error').text('登录入口错误')
                        } else if (res.data == 404) {
                            $('.form_error').text('账号或密码不正确')
                        }
                        resolve(false)
                    })
                    .catch(function (err) {
                        reject(err)
                    })
            })
            return pm
        }
    </script>
@endsection

@section('content')
    <div class="login">
        <div class="login_logo"></div>
        <p class="form_error chayefont fz-14"></p>
        <div class="form_style">
            <form method="POST" id="form" name="form" action="{{ route('login') }}">
                {{ csrf_field() }}
                <label for="name" class="field white">
                    <i class="fa fa-user-o"></i>
                    <input type="text" id="name" class="chayefont white" name="name" autocomplete="off" placeholder="请输入用户名">
                </label>
                <label for="password" class="field white">
                    <i class="fa fa-lock"></i>
                    <input type="password" id="password" class="chayefont white" name="password" autocomplete="off" placeholder="请输入密码">
                </label>
                <div class="login_link txt-c fz-16">
                    <!-- 输入邮箱和更改密码的页面的跳转地址：/password/reset/{id} -->
                    <a class="pull-left chayefont" href="{{ url('/password/reset') }}">
                        <!-- <i class="fa fa-circle-thin"></i> -->
                        忘记密码
                    </a>
                    <a class="pull-left chayefont" href="{{ url('/register') }}">
                        <!-- <i class="fa fa-circle"></i> -->
                        注册账号
                    </a>
                </div>
                <label for="valid" class="submit">
                    <input type="button" id="valid">
                </label>
            </form>
        </div>
    </div>
    @include("layouts.backIndex")
@endsection
