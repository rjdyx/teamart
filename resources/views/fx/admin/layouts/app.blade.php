<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" style="height: 100%;width:100%;">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{url('admin/common/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('admin/common/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{url('admin/common/dist/css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{url('admin/common/dist/css/ionicons.css')}}">
    <link rel="stylesheet" href="{{url('admin/common/dist/css/skins/skin-green-light.css')}}">
    <!-- Styles -->
    @yield('css')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body class="hold-transition skin-green-light sidebar-mini">
    
    <div class="wrapper">
        @yield('content')
    </div>

    <script src="{{url('admin/common/dist/js/app.min.js')}}"></script>
    <script>
        (function($){
            let curhref = window.location.href
            $('.sidebar-menu')
            .find('.active').removeClass('active').end()
            .find('a').each(function (idx, elem) {
                let href = $(this).attr('href')
                if (curhref === href) {
                    $(this)
                        .parent().addClass('active').end()
                        .parents('.treeview').addClass('active')
                }
            })
        })($)
    </script>
    @yield('script')
</body>
</html>
