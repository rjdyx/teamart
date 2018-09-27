@extends('layouts.app')

@section('title') 用户绑定信息 @endsection
@section('css')
@endsection

@section('content')

    {{--@include("layouts.header-info")--}}

    {{--@include("layouts.backIndex")--}}
    {{--<div class="container userassets">--}}
        {{--你已经绑定了{{$bindusername}}!--}}
    {{--</div>--}}
    <script>
        window.onload = function () {
            //提示信息，一秒钟后跳转到上一个页面
            fxPrompt.message("{{$message}}",'history');
        };
    </script>


@endsection
