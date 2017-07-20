<?php 
    $data = App\System::first();
 ?>
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="@if(count($data)){{$data->keywords}} @endif">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <!-- 避免IE使用兼容模式 -->
    <!-- 针对手持设备优化，主要是针对一些老的不识别viewport的浏览器，比如黑莓 -->
    <meta name="HandheldFriendly" content="true">
    <!-- 微软的老式浏览器 -->
    <meta name="MobileOptimized" content="320">
    <!-- uc强制竖屏 -->
    <meta name="screen-orientation" content="portrait">
    <!-- QQ强制竖屏 -->
    <meta name="x5-orientation" content="portrait">
    <!-- UC强制全屏 -->
    <meta name="full-screen" content="yes">
    <!-- QQ强制全屏 -->
    <meta name="x5-fullscreen" content="true">
    <!-- UC应用模式 -->
    <meta name="browsermode" content="application">
    <!-- QQ应用模式 -->
    <meta name="x5-page-mode" content="app">
    <!-- windows phone 点击无高光 -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- iOS 设备 end -->
    <meta name="msapplication-TileColor" content="#000"/>
    <!-- Windows 8 磁贴颜色 -->
    <meta name="msapplication-TileImage" content="icon.png"/>
    <meta name="format-detection" content="telphone=no, email=no"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@if(count($data)){{$data->name}} @endif - @yield('title')</title>

    <!-- Styles -->
    {{-- <link rel="stylesheet" href="{{url('/fx/build/css/index.css')}}"> --}}
    <link rel="stylesheet" href="http://localhost:8080/fx/build/css/index.css">
    @yield('css')
<!--     <script type="text/javascript" src="http://cdn.webfont.youziku.com/wwwroot/js/wf/youziku.api.min.js"></script>
    <script type="text/javascript">
       $youziku.load("body", "b4da953a9d2d4dd09db49d0b68b5e297", "yuweij");
       $youziku.draw();
    </script> -->
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body class="base-fontsize">
    @include("layouts.prompt")

    @yield('content')
    <!-- Scripts -->
    {{-- <script src="{{url('/fx/build/vendor-bundle.js')}}"></script>
    <script src="{{url('/fx/build/index.js')}}"></script> --}}
    <script src="http://localhost:8080/fx/build/vendor-bundle.js"></script>
    <script src="http://localhost:8080/fx/build/index.js"></script>
    <script src="http://localhost:8080/fx/build/prompt.js"></script>
    <script src="http://localhost:8080/fx/build/valid.js"></script>
    <script src="{{url('/fx/zetop/fx.js')}}"></script>
    <script src="{{url('/fx/zetop/stack.js')}}"></script>
    <script src="{{url('/fx/zetop/touch.js')}}"></script>
    <script src="{{url('/fx/build/prompt.js')}}"></script>
    <script>
        // !(function(doc, win) {
        //     var docEle = doc.documentElement,
        //         evt = "onorientationchange" in window ? "orientationchange" : "resize",
        //         fn = function() {
        //             var width = docEle.clientWidth;
        //             width && (docEle.style.fontSize = 100 * (width / 750) + "px");
        //         };
        //     win.addEventListener(evt, fn, false);
        //     doc.addEventListener("DOMContentLoaded", fn, false);
        // }(document, window));
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 640) deviceWidth = 640;
        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
        function backTop (container) {
            $('.J_backTop').on('tap', function () {
                // $('#' + container).animate({
                //     'scrollTop': 0
                // }, 100)
                $('#' + container).scrollTop(0)
            })
        }
        $(function () {
            prompt.init()
            // 返回按钮事件绑定
            $('.J_header_back').on('tap', function () {
                history.go(-1)
            })
            // 返回首页
            $('.J_backIndex').on('tap', function () {
                window.location.href = 'http://' + window.location.host
            })
            // 头部分类
            $('.J_show_header_category').on('tap', function () {
                $('.header_category').addClass('left-0').animate({
                    'opacity': 1},
                    300,
                    function () {
                        $('.header_category').find('ul').addClass('left-0')
                    }
                )
            })
            $('.J_hide_header_category').on('tap', function () {
                $('.header_category').removeClass('left-0').animate({
                    'opacity': 0},
                    300,
                    function () {
                        $('.header_category').find('ul').removeClass('left-0')
                    }
                )
            })
            // 头部搜索
            $('.J_header_search_inp').on('input', function () {
                if ($.trim($(this).val()).length > 0) {
                    $(this).siblings('.J_header_search').removeClass('hide')
                } else {
                    $(this).siblings('.J_header_search').addClass('hide')
                }
            })
            $('.J_header_search').on('tap', function () {
                let v = $(this).siblings('input').val()
                window.location.href = 'http://' + window.location.host + '/home/product/list?name=' + v
            })
        })
    </script>
    @yield('script')
    <!-- @include("layouts.service")  -->
</body>
</html>
