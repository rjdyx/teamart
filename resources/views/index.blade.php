@extends('layouts.app')

@section('title')
首页
@endsection

@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('fx/css/catelog.css') }}"> --}}
@endsection

@section('script')
    @parent
    <script type="text/javascript" src="{{ url('fx/js/catelog.js') }}"></script>
@endsection

@section('content')
 @include("layouts.header")
    <div class="container index">
        <div class="banner">
            <img src="fx/images/index_banner.png" alt="">
        </div>
        <div class="index_box">
            <div class="index_box_title">
                <h1 class="pull-left chayefont">活动商品</h1>
                <a href="javascript:;" class="pull-right">
                    <span class="chayefont">更多</span>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
            <div class="index_box_content clearfix">
                <div class="ibc_single pull-left">
                    <a href="#">
                        <h5 class="chayefont">云南碧螺春绿茶</h5>
                        <span class="price">$4.99</span>
                        <img src="fx/img/pic5.png" alt="">
                    </a>
                </div>
                <div class="ibc_multi pull-right">
                    <div class="ibc_multi_goods top">
                        <a href="#">
                            <img class="pull-right" src="fx/img/pic5.png" alt="">
                            <h5 class="chayefont">云南碧螺春绿茶</h5>
                            <p class="chayefont">清纯可口 清纯可口</p>
                            <span class="price">$4.99</span>
                        </a>
                    </div>
                    <div class="ibc_multi_goods txt-r">
                        <a href="#">
                            <img class="pull-left" src="fx/img/pic5.png" alt="">
                            <h5 class="chayefont">云南碧螺春绿茶</h5>
                            <p class="chayefont">清纯可口 清纯可口</p>
                            <span class="price">$4.99</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner_box mb-10">
            <div class="banner_box_row mb-10">
                <img src="/fx/images/index_banner2_1.png" alt="">
                <p class="chayefont">一共要有20个字左右左右, 左右左右左右左右左右左右</p>
            </div>
            <div class="banner_box_row">
                <img src="/fx/images/index_banner2_2.png" alt="">
                <p class="chayefont">一共要有20个字左右左右sssss</p>
            </div>
        </div>
        
        <div class="index_box">
            <div class="index_box_title">
                <h1 class="pull-left chayefont">活动商品</h1>
                <a href="javascript:;" class="pull-right">
                    <span class="chayefont">更多</span>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
            <div class="index_box_content clearfix">
                <div class="ibc_single pull-right">
                    <a href="#">
                        <h5 class="chayefont">云南碧螺春绿茶</h5>
                        <span class="price">$4.99</span>
                        <img src="fx/img/pic5.png" alt="">
                    </a>
                </div>
                <div class="ibc_multi pull-left">
                    <div class="ibc_multi_goods top">
                        <a href="#">
                            <img class="pull-right" src="fx/img/pic5.png" alt="">
                            <h5 class="chayefont">云南碧螺春绿茶</h5>
                            <p class="chayefont">清纯可口 清纯可口</p>
                            <span class="price">$4.99</span>
                        </a>
                    </div>
                    <div class="ibc_multi_goods_cell left pull-left">
                        <a href="#">
                            <h5 class="chayefont">云南碧螺春绿茶</h5>
                            <span class="price">$4.99</span>
                            <img src="fx/img/pic5.png" alt="">
                        </a>
                    </div>
                    <div class="ibc_multi_goods_cell right pull-left">
                        <a href="#">
                            <h5 class="chayefont">云南碧螺春绿茶</h5>
                            <span class="price">$4.99</span>
                            <img src="fx/img/pic5.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="index_box">
            <div class="index_box_list">
                <ul class="clearfix">
                    <li>
                        <a href="#">
                            <img src="fx/img/pic5.png" alt="">
                            <h5 class="chayefont">云南碧螺春绿茶</h5>
                            <p class="chayefont">非常好喝好喝好 非常好喝好喝好</p>
                            <span class="price">$4.99</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="fx/img/pic5.png" alt="">
                            <h5 class="chayefont">云南碧螺春绿茶</h5>
                            <p class="chayefont">非常好喝好喝好 非常好喝好喝好</p>
                            <span class="price">$4.99</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="fx/img/pic5.png" alt="">
                            <h5 class="chayefont">云南碧螺春绿茶</h5>
                            <p class="chayefont">非常好喝好喝好 非常好喝好喝好</p>
                            <span class="price">$4.99</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- <div>
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
                    <img src="fx/img/pic21.png" style="display: inline-block;height: 200px;width: 100%">
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
                        <img src="fx/img/pic21.png" style="display: inline-block;height: 99px;width: 100%">
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
                        <img src="fx/img/pic21.png" style="display: inline-block;height: 99px;width: 100%">
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
                <img src="fx/img/pic21.png" style="height: 320px;width: 100%">
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
                    <img src="fx/img/pic21.png" style="display: inline-block;height: 200px;width: 100%">
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
                        <img src="fx/img/pic21.png" style="display: inline-block;height: 99px;width: 100%">
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
                        <img src="fx/img/pic21.png" style="display: inline-block;height: 99px;width: 100%">
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
                    <img src="fx/img/pic21.png" style="display: inline-block;height: 200px;width: 100%">
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
                        <img src="fx/img/pic21.png" style="display: inline-block;height: 99px;width: 100%">
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
                        <img src="fx/img/pic21.png" style="display: inline-block;height: 99px;width: 100%">
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
        </div> -->
    </div>
    @include("layouts.footer")
@endsection
