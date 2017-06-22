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
@endsection

@section('content')
 @include("layouts.header")
    <div class="container base-fontsize">
        <div class="banner">
            <img src="fx/img/pic1.png" alt="">
        </div>
        <div class="index_box">
            <div class="index_box_title">
                <h1>活动商品</h1>
                <a href="javascript:;">
                    <span class="chayefont">更多</span>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
            <div class="index_content_box_content">
                <div class="icbc_left">
                    <h5>云南碧螺春绿茶</h5>
                    <span>$4.99</span>
                    <img src="fx/img/pic5.png" alt="">
                </div>
                <div class="icbc_right">
                    <div class="icbc_right_goods">
                        <h5>云南碧螺春绿茶</h5>
                        <p>清纯可口 清纯可口</p>
                        <span>$4.99</span>
                        <img src="fx/img/pic5.png" alt="">
                    </div>
                    <div class="icbc_right_goods">
                        <img src="fx/img/pic5.png" alt="">
                        <h5>云南碧螺春绿茶</h5>
                        <p>清纯可口 清纯可口</p>
                        <span>$4.99</span>
                    </div>
                </div>
            </div>
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
                    <div class="contentLeft-des">
                    @if(isset($activitys[0]))
                        {{$activitys[0]->name}}
                    @endif
                    </div>
                    <div class="contentLeft-price price">
                        <div class="price-logo">
                            <img src="fx/img/pic51.png" style="width: 15px;height: 15px;vertical-align: middle;">
                        </div>
                    @if(isset($activitys[0]))
                        {{$activitys[0]->price}}
                    @endif
                        </div>
                    <div class="contentLeft-pic">
                        <img src="fx/img/pic5.png" style="width: 100px;height: 120px">
                    </div>
                </div>
                <div class="active-contentRight">
                    <div class="contentRight-top">
                        <!--<img src="fx/img/pic21.png" style="display: inline-block;height: 99px;width: 100%">-->
                        <div class="contentRight-word">
                            <div class="contentRight-des">
                            @if(isset($activitys[1]))
                                {{$activitys[1]->name}}
                            @endif
                            </div>
                            <div class="contentRight-introduce">
                            @if(isset($activitys[1]))
                                {{$activitys[1]->desc}}
                            @endif
                            </div>
                            <div class="contentRight-price price">
                                <div class="price-logo">
                                    <img src="fx/img/pic51.png" style="width: 15px;height: 15px;vertical-align: middle;">
                                </div>
                                @if(isset($activitys[1]))
                                    {{$activitys[1]->price}}
                                @endif
                                </div>
                        </div>
                        <div class="contentRight-pic">
                            <img src="fx/img/pic4.png" style="width: 80px;height: 80px;vertical-align:middle">
                        </div>
                    </div>
                    <div class="contentRight-bottom">
                        <!--<img src="fx/img/pic21.png" style="display: inline-block;height: 99px;width: 100%">-->
                        <div class="contentRight-words">
                            <div class="contentRight-des">
                                @if(isset($activitys[2]))
                                    {{$activitys[2]->name}}
                                @endif
                            </div>
                            <div class="contentRight-introduce">
                                @if(isset($activitys[2]))
                                    {{$activitys[2]->desc}}
                                @endif
                            </div>
                            <div class="contentRight-price price">
                                <div class="price-logo">
                                    <img src="fx/img/pic51.png" style="width: 15px;height: 15px;vertical-align: middle;">
                                </div>
                                @if(isset($activitys[2]))
                                    {{$activitys[2]->price}}
                                @endif
                                </div>
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
                    <div class="contentLeft-des">
                        @if(isset($news[0]))
                            {{$news[0]->name}}
                        @endif
                    </div>
                    <div class="contentLeft-price price">
                        <div class="price-logo">
                            <img src="fx/img/pic51.png" style="width: 15px;height: 15px;vertical-align: middle;"></div>
                        @if(isset($news[0]))
                            {{$news[0]->price}}
                        @endif
                        </div>
                    <div class="contentLeft-pic">
                        <img src="fx/img/pic5.png" style="width: 100px;height: 120px">
                    </div>
                </div>
                <div class="active-contentRight">
                    <div class="contentRight-top">
                        <!--<img src="fx/img/pic21.png" style="display: inline-block;height: 99px;width: 100%">-->
                        <div class="contentRight-word">
                            <div class="contentRight-des">
                            @if(isset($news[1]))
                                {{$news[1]->name}}
                            @endif
                            </div>
                            <div class="contentRight-introduce">
                                @if(isset($news[1]))
                                    {{$news[1]->desc}}
                                @endif
                            </div>
                            <div class="contentRight-price price">
                                <div class="price-logo">
                                    <img src="fx/img/pic51.png" style="width: 15px;height: 15px;vertical-align: middle;">
                                </div>
                            @if(isset($news[1]))
                                {{$news[1]->price}}
                            @endif
                                </div>
                        </div>
                        <div class="contentRight-pic">
                            <img src="fx/img/pic4.png" style="width: 80px;height: 80px;vertical-align:middle">
                        </div>
                    </div>
                    <div class="contentRight-bottom">
                        <!--<img src="fx/img/pic21.png" style="display: inline-block;height: 99px;width: 100%">-->
                        <div class="contentRight-words">
                            <div class="contentRight-des">@if(isset($news[2])) {{$news[2]->name}} @endif</div>
                            <div class="contentRight-introduce">@if(isset($news[2])) {{$news[2]->desc}} @endif</div>
                            <div class="contentRight-price price">
                                <div class="price-logo">
                                    <img src="fx/img/pic51.png" style="width: 15px;height: 15px;vertical-align: middle;">
                                </div>
                                @if(isset($news[2])) {{$news[2]->price}} @endif
                                </div>
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
                    <div class="contentLeft-des">@if(isset($sells[0])) {{$sells[0]->name}} @endif</div>
                    <div class="contentLeft-price price">
                        <div class="price-logo">
                            <img src="fx/img/pic51.png" style="width: 15px;height: 15px;vertical-align: middle;"></div>
                            @if(isset($sells[0])) {{$sells[0]->price}} @endif
                        </div>
                    <div class="contentLeft-pic">
                        <img src="fx/img/pic5.png" style="width: 100px;height: 120px">
                    </div>
                </div>
                <div class="active-contentRight">
                    <div class="contentRight-top">
                        <!--<img src="fx/img/pic21.png" style="display: inline-block;height: 99px;width: 100%">-->
                        <div class="contentRight-word">
                            <div class="contentRight-des">@if(isset($sells[1])) {{$sells[1]->name}} @endif</div>
                            <div class="contentRight-introduce">@if(isset($sells[1])) {{$sells[1]->desc}} @endif</div>
                            <div class="contentRight-price price">
                                <div class="price-logo">
                                    <img src="fx/img/pic51.png" style="width: 15px;height: 15px;vertical-align: middle;">
                                </div>
                                @if(isset($sells[1])) {{$sells[1]->price}} @endif
                                </div>
                        </div>
                        <div class="contentRight-pic">
                            <img src="fx/img/pic4.png" style="width: 80px;height: 80px;vertical-align:middle">
                        </div>
                    </div>
                    <div class="contentRight-bottom">
                        <!--<img src="fx/img/pic21.png" style="display: inline-block;height: 99px;width: 100%">-->
                        <div class="contentRight-words">
                            <div class="contentRight-des">@if(isset($sells[2])) {{$sells[2]->name}} @endif</div>
                            <div class="contentRight-introduce">@if(isset($sells[2])) {{$sells[2]->desc}} @endif</div>
                            <div class="contentRight-price price">
                                <div class="price-logo">
                                    <img src="fx/img/pic51.png" style="width: 15px;height: 15px;vertical-align: middle;">
                                </div>
                                @if(isset($sells[2])) {{$sells[2]->price}} @endif
                                </div>
                        </div>
                        <div class="contentRight-pics">
                            <img src="" style="width: 80px;height: 80px;vertical-align:middle">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("layouts.footer")
@endsection
