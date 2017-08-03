@extends('layouts.app')

@section('title')
绑定账号
@endsection

@section('css')
@endsection

@section('script')
    @parent

    <script src="{{url('/fx/build/valid.js')}}"></script>
    <script src="{{url('/fx/js/fixInput.js')}}"></script>
    <script>
        function validate() {
            if (!_valid.ness('该字段', $('#name').val())) {
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
	<form action="{{url('')}}/bind/weixin" method="POST">
		{{ csrf_field() }}
		<input type="text" name="user" placeholder="">
		<input type="password" name="password" placeholder="输入密码">
		<input type="submit" value="绑定">

        <label for="user" class="field white block">
            <i class="fa fa-user-o fz-16"></i>
            <input type="text" id="user" class="chayefont white fz-16" name="user" autocomplete="off" placeholder="用户名/手机号/邮箱">
        </label>
        <label for="password" class="field white block">
            <i class="fa fa-lock fz-16"></i>
            <input type="password" id="password" class="chayefont white fz-16" name="password" autocomplete="off" placeholder="输入密码">
        </label>
        <label for="valid" class="submit block">
            <input type="button" id="valid" class="invisibility">
        </label>
	</form>
@endsection