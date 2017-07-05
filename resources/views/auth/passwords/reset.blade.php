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
            <p class="fz-20 mb-20 ">1.发送邮箱</p>
            <p class="fz-20 active">2.重置密码</p>
        </div>
        <p class="form_error formfont txt-c"></p>
        <div class="reset_form">
            <form method="POST" id="form" name="form" action="{{ url('password/email') }}" onsubmit="return submitForm">
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
<!-- <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="user_id" value="2">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection
