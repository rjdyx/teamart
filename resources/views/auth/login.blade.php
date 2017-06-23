@extends('layouts.app')

@section('title')
登陆
@endsection

@section('css')
@endsection

@section('script')
    @parent
    <script>
        // $('.add-name,.add-password').hide();
        // $('.myName,.password').on('click',function () {
        //     $('.add-name,.add-password').hide();
        // })
        // function loginVali(){
        //     var name = $(".myName").val();
        //     var password = $(".password").val();
        //     var result = true;
        //     if(name==''){
        //         $('.add-name').css({'display':'inline-block'})
        //         $('.add-name').css({'color':'red'});
        //         result = false;
        //     }
        //     if(password==''){
        //         $('.add-password').css({'display':'inline-block'})
        //         $('.add-password').css({'color':'red'});
        //         result = false;
        //     }
        //     return result;
        // };

        // $('.submit').on('click',function() {
        //     loginVali();
        // });

        // $('.radio_left_box').click(function(){
        //     $(this).addClass("radio_selected");
        //     $('.radio_right_box').removeClass('radio_selected');
        //     $('.radio_left').attr('checked',true);
        //     $('.radio_right').attr('checked',false);
        // });
        // $('.radio_right_box').click(function(){
        //     $(this).addClass("radio_selected");
        //     $('.radio_left_box').removeClass('radio_selected');
        //     $('.radio_right').attr('checked',true);
        //     $('.radio_left').attr('checked',false);
        // });
        function valid() {
            if (!_valid.ness('用户名', $('#name').val())) {
                return false;
            }
            if (!_valid.ness('密码', $('#password').val())) {
                return false;
            }
            return true;
        }
    </script>
@endsection

@section('content')
    <div class="login">
        <div class="login_logo"></div>
        <p class="form_error"></p>
        <div class="login_form">
            <form method="POST" id="form" action="{{ route('login') }}">
                {{ csrf_field() }}
                <label for="name" class="field">
                    <i class="fa fa-user-o"></i>
                    <input type="text" id="name" class="chayefont" name="name" autocomplete="off" placeholder="请输入用户名">
                </label>
                <label for="password" class="field">
                    <i class="fa fa-lock"></i>
                    <input type="password" id="password" class="chayefont" name="password" autocomplete="off" placeholder="请输入密码">
                </label>
                <div class="login_link">
                    <a class="pull-left" href="{{ url('/reset') }}">
                        <i class="fa fa-circle-thin"></i>
                        忘记密码
                    </a>
                    <a class="pull-left" href="{{ url('/register') }}">
                        <i class="fa fa-circle"></i>
                        注册账号
                    </a>
                </div>
                <label for="valid" class="submit">
                    <input type="button" id="valid">
                </label>
            </form>
            {!! Geetest::render('bind') !!}
        </div>
    </div>
    <!-- <div class="content">
        <div class="head">
          <img src="fx/img/pic41.png" style="width: 300px;height: 300px">
        </div>
        <div class="contain">
            <form role="form" method="POST" id="form" action="{{ route('login') }}">
            <div class="number">
                <img src="fx/img/pic34.png" style="width: 20px;height:20px;vertical-align: middle;position: relative;left: 35px">
                <img src="fx/img/pic23.png" style="width: 250px;height:45px;vertical-align: middle;line-height: 60px">

                <input type="text" class="myName" name="name" placeholder="请输入用户名">
            </div>
             {{ csrf_field() }}

            <div class="add-name">请输入用户名</div>
            <div class="number">
                <img src="fx/img/pic35.png" style="width: 20px;height:20px;vertical-align: middle;position: relative;left: 35px">
                <img src="fx/img/pic23.png" style="width: 250px;height:45px;vertical-align: middle;line-height: 60px">
                <input type="password" class="password" name="password" placeholder="请输入密码">
            </div>
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
            <div class="add-password">请输入密码</div>
            <div class="choose">
                <div class="radio_text">
                    <a href="{{ url('/reset') }}">忘记密码</a> 
                </div>
                <div class="radio_text">
                    <a href="{{ url('/register') }}">注册账号</a> 
                </div>
            </div>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
            <div class="number">
                {{-- {!! Geetest::render('bind') !!} --}}
            </div>

            <div class="button" id="bid"></div>
            </form>
        </div>
    </div> -->
@endsection
