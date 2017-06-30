@extends('layouts.app')

@section('title')
重置密码
@endsection

@section('css')
@endsection

@section('script')
    @parent
@endsection

@section('content')
<div class="reset">
    <h1>重置密码</h1>
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
                <!-- 输入邮箱和更改密码的页面的跳转地址：/password/reset/{id} -->
                <a class="pull-left formfont" href="{{ url('/password/reset') }}">
                    <!-- <i class="fa fa-circle-thin"></i> -->
                    忘记密码
                </a>
                <a class="pull-left formfont" href="{{ url('/register') }}">
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

<div class="container">
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
</div>
@endsection
