@extends('layouts.app')

@section('title')
登陆
@endsection

@section('css')
@endsection

@section('script')
    @parent
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
        <p class="form_error formfont"></p>
        <div class="login_form">
            <form method="POST" id="form" name="form" action="{{ route('login') }}">
                {{ csrf_field() }}
                <label for="name" class="field">
                    <i class="fa fa-user-o"></i>
                    <input type="text" id="name" class="formfont" name="name" autocomplete="off" placeholder="请输入用户名">
                </label>
                <label for="password" class="field">
                    <i class="fa fa-lock"></i>
                    <input type="password" id="password" class="formfont" name="password" autocomplete="off" placeholder="请输入密码">
                </label>
                <div class="login_link">
                    <a class="pull-left formfont" href="{{ url('/reset') }}">
                        <!-- <i class="fa fa-circle-thin"></i> -->
                        忘记密码
                    </a>
                    <a class="pull-left formfont" href="{{ url('/register') }}">
                        <!-- <i class="fa fa-circle"></i> -->
                        注册账号
                    </a>
                </div>
                <label for="valid" class="submit">
                    <input type="submit" id="valid">
                </label>
            </form>
            {!! Geetest::render('bind') !!}
        </div>
    </div>
@endsection
