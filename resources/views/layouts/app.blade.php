<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1,maximum-scale=1, minimum-scale=1">
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

    <title>@yield('title')</title>

    
    <!-- Styles -->
    <link rel="stylesheet" href="{{url('/fx/build/css/index.css')}}">
    {{-- <link rel="stylesheet" href="http://localhost:8080/fx/build/css/index.css"> --}}
    @yield('css')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    @yield('content')
    <!-- Scripts -->
    {{-- <script src="http://cdn.webfont.youziku.com/wwwroot/js/wf/youziku.api.min.js"></script>
    <script type="text/javascript">
        $youziku.load(".tea,#webfont,.contentLeft-des,.contentRight-introduce,.active-word,.more-word,.contentRight-des,.add-word", "f61ea8f5934348a2916e178809a3cbae", "yuweij");
        $youziku.draw();
    </script> --}}
    <script src="{{url('/fx/build/vendor-bundle.js')}}"></script>
    <script src="{{url('/fx/build/index.js')}}"></script>
    {{-- <script src="http://localhost:8080/fx/build/vendor-bundle.js"></script>
    <script src="http://localhost:8080/fx/build/index.js"></script> --}}
    <script>
        console.log(1)
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 640) deviceWidth = 640;
        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
    </script>
    @yield('script')
</body>
</html>
