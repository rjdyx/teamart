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
            <p class="fz-20 mb-20 active">1.发送邮箱</p>
            <p class="fz-20">2.重置密码</p>
        </div>
        <p class="form_error formfont txt-c"></p>
        <div class="email_form">
            <form method="POST" id="form" name="form" action="{{ url('password/email') }}" onsubmit="return submitForm()">
                {{ csrf_field() }}
                <label for="email" class="field">
                    <i class="fa fa-envelope"></i>
                    <input type="email" id="email" class="formfont" name="email" autocomplete="off" placeholder="请输入邮箱">
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

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('password/email') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Send Password Reset Link
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
