@extends('layouts.app')

@section('title')
首页
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/css/catelog.css') }}">
@endsection

@section('script')
    @parent
    <script type="text/javascript" src="{{ url('fx/js/catelog.js') }}"></script>
    <script type="text/javascript">
        $youziku.load(".tea,#webfont,.contentLeft-des,.contentRight-introduce,.active-word,.more-word,.contentRight-des,.add-word", "f61ea8f5934348a2916e178809a3cbae", "yuweij");
        $youziku.draw();
    </script>
@endsection

@section('content')
 @include("layouts.header")
    <div class="content">
        <div class="lead-pic">
            <img src="fx/img/pic1.png" style="height:160px;width: 100%">
        </div>


        <div>
            <div class="active-lead">
                <div class="active-title">
                    <img src="fx/img/pic3.png" style="height: 64px;width: 100%">
                    <div class="active-word">活动商品</div>
                </div>
                <div class="active-more">
                    <div class="more-word">更多</div>
                    <div class="more-pic">
                        <img src="fx/img/pic17.png" style="width: 10px;height: 20px;position: relative;top: 4px">
                    </div>
                </div>
            </div>
            <div class="active-content">
                <div class="active-contentLeft">
                    <!--<img src="fx/img/pic21.png" style="display: inline-block;height: 200px;width: 100%">-->
                    <div class="contentLeft-des">碧螺春</div>
                    <div class="contentLeft-price price">
                        <div class="price-logo">
                            <img src="fx/img/pic51.png" style="width: 15px;height: 15px;vertical-align: middle;"></div>
                        12</div>
                    <div class="contentLeft-pic">
                        <img src="fx/img/pic5.png" style="width: 100px;height: 120px">
                    </div>
                </div>
                <div class="active-contentRight">
                    <div class="contentRight-top">
                        <!--<img src="fx/img/pic21.png" style="display: inline-block;height: 99px;width: 100%">-->
                        <div class="contentRight-word">
                            <div class="contentRight-des">碧螺春好茶</div>
                            <div class="contentRight-introduce">香甜可口香甜可口</div>
                            <div class="contentRight-price price">
                                <div class="price-logo">
                                    <img src="fx/img/pic51.png" style="width: 15px;height: 15px;vertical-align: middle;">
                                </div>
                                12</div>
                        </div>
                        <div class="contentRight-pic">
                            <img src="fx/img/pic4.png" style="width: 80px;height: 80px;vertical-align:middle">
                        </div>
                    </div>
                    <div class="contentRight-bottom">
                        <!--<img src="fx/img/pic21.png" style="display: inline-block;height: 99px;width: 100%">-->
                        <div class="contentRight-words">
                            <div class="contentRight-des">碧螺春好茶</div>
                            <div class="contentRight-introduce">香甜可口香甜可口</div>
                            <div class="contentRight-price price">
                                <div class="price-logo">
                                    <img src="fx/img/pic51.png" style="width: 15px;height: 15px;vertical-align: middle;">
                                </div>
                                12</div>
                        </div>
                        <div class="contentRight-pics">
                            <img src="fx/img/pic2.png" style="width: 80px;height: 80px;vertical-align:middle">
                        </div>
                    </div>
                </div>
            </div>
            <div class="add-pic">
                <!--<img src="fx/img/pic21.png" style="height: 320px;width: 100%">-->
                <div class="add-box">
                    <img src="fx/img/pic6.png" style="height: 150px;width: 100%">
                    <div class="add-word">床前明月光疑是地上霜</div>
                </div>
                <div class="add-box" style="margin-top: 5px">
                    <img src="fx/img/pic7.png" style="height: 150px;width: 100%">
                    <div class="add-word">床前明月光疑是地上霜</div>
                </div>
            </div>
        </div>


        <div class="activities">
            <div class="active-lead">
                <div class="active-title">
                    <img src="fx/img/pic3.png" style="height: 64px;width: 100%">
                    <div class="active-word">新品推荐</div>
                </div>
                <div class="active-more">
                    <div class="more-word">更多</div>
                    <div class="more-pic">
                        <img src="fx/img/pic17.png" style="width: 10px;height: 20px;position: relative;top: 4px">
                    </div>
                </div>
            </div>
            <div class="active-content">
                <div class="active-contentLeft">
                    <!--<img src="fx/img/pic21.png" style="display: inline-block;height: 200px;width: 100%">-->
                    <div class="contentLeft-des">碧螺春</div>
                    <div class="contentLeft-price price">
                        <div class="price-logo">
                            <img src="fx/img/pic51.png" style="width: 15px;height: 15px;vertical-align: middle;"></div>
                        12</div>
                    <div class="contentLeft-pic">
                        <img src="fx/img/pic5.png" style="width: 100px;height: 120px">
                    </div>
                </div>
                <div class="active-contentRight">
                    <div class="contentRight-top">
                        <!--<img src="fx/img/pic21.png" style="display: inline-block;height: 99px;width: 100%">-->
                        <div class="contentRight-word">
                            <div class="contentRight-des">碧螺春好茶</div>
                            <div class="contentRight-introduce">香甜可口香甜可口</div>
                            <div class="contentRight-price price">
                                <div class="price-logo">
                                    <img src="fx/img/pic51.png" style="width: 15px;height: 15px;vertical-align: middle;">
                                </div>
                                12</div>
                        </div>
                        <div class="contentRight-pic">
                            <img src="fx/img/pic4.png" style="width: 80px;height: 80px;vertical-align:middle">
                        </div>
                    </div>
                    <div class="contentRight-bottom">
                        <!--<img src="fx/img/pic21.png" style="display: inline-block;height: 99px;width: 100%">-->
                        <div class="contentRight-words">
                            <div class="contentRight-des">碧螺春好茶</div>
                            <div class="contentRight-introduce">香甜可口香甜可口</div>
                            <div class="contentRight-price price">
                                <div class="price-logo">
                                    <img src="fx/img/pic51.png" style="width: 15px;height: 15px;vertical-align: middle;">
                                </div>
                                12</div>
                        </div>
                        <div class="contentRight-pics">
                            <img src="fx/img/pic2.png" style="width: 80px;height: 80px;vertical-align:middle">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="activities" style="margin-top: 5px;">
            <div class="active-lead">
                <div class="active-title">
                    <img src="fx/img/pic3.png" style="height: 64px;width: 100%">
                    <div class="active-word">热卖推荐</div>
                </div>
                <div class="active-more">
                    <div class="more-word">更多</div>
                    <div class="more-pic">
                        <img src="fx/img/pic17.png" style="width: 10px;height: 20px;position: relative;top: 4px">
                    </div>
                </div>
            </div>
            <div class="active-content">
                <div class="active-contentLeft">
                    <!--<img src="fx/img/pic21.png" style="display: inline-block;height: 200px;width: 100%">-->
                    <div class="contentLeft-des">碧螺春</div>
                    <div class="contentLeft-price price">
                        <div class="price-logo">
                            <img src="fx/img/pic51.png" style="width: 15px;height: 15px;vertical-align: middle;"></div>
                        12</div>
                    <div class="contentLeft-pic">
                        <img src="fx/img/pic5.png" style="width: 100px;height: 120px">
                    </div>
                </div>
                <div class="active-contentRight">
                    <div class="contentRight-top">
                        <!--<img src="fx/img/pic21.png" style="display: inline-block;height: 99px;width: 100%">-->
                        <div class="contentRight-word">
                            <div class="contentRight-des">碧螺春好茶</div>
                            <div class="contentRight-introduce">香甜可口香甜可口</div>
                            <div class="contentRight-price price">
                                <div class="price-logo">
                                    <img src="fx/img/pic51.png" style="width: 15px;height: 15px;vertical-align: middle;">
                                </div>
                                12</div>
                        </div>
                        <div class="contentRight-pic">
                            <img src="fx/img/pic4.png" style="width: 80px;height: 80px;vertical-align:middle">
                        </div>
                    </div>
                    <div class="contentRight-bottom">
                        <!--<img src="fx/img/pic21.png" style="display: inline-block;height: 99px;width: 100%">-->
                        <div class="contentRight-words">
                            <div class="contentRight-des">碧螺春好茶</div>
                            <div class="contentRight-introduce">香甜可口香甜可口</div>
                            <div class="contentRight-price price">
                                <div class="price-logo">
                                    <img src="fx/img/pic51.png" style="width: 15px;height: 15px;vertical-align: middle;">
                                </div>
                                12</div>
                        </div>
                        <div class="contentRight-pics">
                            <img src="fx/img/pic2.png" style="width: 80px;height: 80px;vertical-align:middle">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("layouts.footer")
@endsection
