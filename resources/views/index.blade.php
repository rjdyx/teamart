@extends('layouts.app')

@section('title')
首页
@endsection

@section('css')
@endsection

@section('script')
    @parent
    <script src="{{url('/fx/build/swiper.js')}}"></script>
@endsection

@section('content')

@include("layouts.header")
    <div class="container index" >
        <!-- 轮播 -->
        <div class="banner swiper-container">
            <ul class="swiper-wrapper">
            @if(count($lbs))
                @foreach($lbs as $lb)
                    <li class="swiper-slide" data-swiper-autoplay="2000"><img src="{{url('')}}/{{$lb}}" alt=""></li> 
                @endforeach
            @else
                <li class="swiper-slide"><img src="fx/images/index_banner.png" alt=""></li> 
            @endif
            </ul>
            <div class="swiper-pagination"></div>
        </div>
        <div class="index_box mb-10">
            <div class="index_box_title">
                <h1 class="pull-left chayefont">活动商品</h1>
                <a href="{{url('/home/activity/many')}}" class="pull-right inline-block">
                    <span class="chayefont">更多</span>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
            <div class="index_box_content clearfix">
                <div class="ibc_single pull-left">
                    <a href="{{url('/home/product/detail')}}/@if(isset($activitys[0])){{$activitys[0]->id}}@endif">
                        <h1 class="chayefont">@if(isset($activitys[0])) {{$activitys[0]->name}} @endif</h1>
                        <p class="chayefont">@if(isset($activitys[0])) {{$activitys[0]->desc}} @endif</p>
                        <span class="price mt-10 mb-10"> ￥ @if(isset($activitys[0])) {{sprintf('%.2f', $activitys[0]->price)}} @endif</span>
                        <img src="@if(isset($activitys[0])) {{$activitys[0]->thumb}} @endif" alt="图片">
                    </a>
                </div>
                <div class="ibc_multi pull-right">
                    <div class="ibc_multi_goods top">
                        <a href="{{url('/home/product/detail')}}/@if(isset($activitys[1])){{$activitys[1]->id}}@endif">
                            <img class="pull-right" src="@if(isset($activitys[1])) {{$activitys[1]->thumb}} @endif" alt="">
                            <h1 class="chayefont">@if(isset($activitys[1])) {{$activitys[1]->name}} @endif</h1>
                            <p class="chayefont">@if(isset($activitys[1])) {{$activitys[1]->desc}} @endif</p>
                            <span class="price">￥ @if(isset($activitys[1])) {{sprintf('%.2f', $activitys[1]->price)}} @endif</span>
                        </a>
                    </div>
                    <div class="ibc_multi_goods txt-r">
                        <a href="{{url('/home/product/detail')}}/@if(isset($activitys[2])){{$activitys[2]->id}}@endif">
                            <img class="pull-left" src="@if(isset($activitys[2])) {{$activitys[2]->thumb}} @endif" alt="">
                            <h1 class="chayefont">@if(isset($activitys[2])) {{$activitys[2]->name}} @endif</h1>
                            <p class="chayefont txt-l">@if(isset($activitys[2])) {{$activitys[2]->desc}} @endif</p>
                            <span class="price">￥ @if(isset($activitys[2])) {{sprintf('%.2f', $activitys[2]->price)}} @endif</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if (count($ads) > 0)
        <div class="banner_box mb-10">
            @foreach ($ads as $ad)
            <a href="{{$ad->url}}">
            <div class="banner_box_row mb-10" style="height:150px;">
                <img src="{{url('')}}/{{$ad->img}}" alt="{{$ad->name}}" height="100%">
                <p class="chayefont">{{$ad->desc}}</p>
            </div></a>
            @endforeach
        </div>
        @endif

        <div class="index_box mb-10">
            <div class="index_box_title">
                <h1 class="pull-left chayefont">最新商品</h1>
                <a href="{{url('/home/promotion/new')}}" class="pull-right inline-block">
                    <span class="chayefont">更多</span>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
            <div class="index_box_content clearfix">
                <div class="ibc_single pull-right">
                    <a href="{{url('/home/product/detail')}}/@if(isset($news[0])){{$news[0]->id}}@endif">
                        <h1 class="chayefont">@if(isset($news[0])) {{$news[0]->name}} @endif</h1>
                        <p class="chayefont">@if(isset($news[0])) {{$news[0]->desc}} @endif</p>
                        <span class="price mt-10 mb-10">￥ @if(isset($news[0])) {{sprintf('%.2f', $news[0]->price)}} @endif</span>
                        <img src="@if(isset($news[0])) {{$news[0]->thumb}} @endif" alt="">
                    </a>
                </div>
                <div class="ibc_multi pull-left">
                    <div class="ibc_multi_goods top">
                        <a href="{{url('/home/product/detail')}}/@if(isset($news[1])){{$news[1]->id}}@endif">
                            <img class="pull-right" src="@if(isset($news[1])) {{$news[1]->thumb}} @endif" alt="">
                            <h1 class="chayefont">@if(isset($news[1])) {{$news[1]->name}} @endif</h1>
                            <p class="chayefont">@if(isset($news[1])) {{$news[1]->desc}} @endif</p>
                            <span class="price">￥ @if(isset($news[1])) {{sprintf('%.2f', $news[1]->price)}} @endif</span>
                        </a>
                    </div>
                    <div class="ibc_multi_goods_cell left pull-left">
                        <a href="{{url('/home/product/detail')}}/@if(isset($news[2])){{$news[2]->id}}@endif">
                            <h1 class="chayefont">@if(isset($news[2])) {{$news[2]->name}} @endif</h1>
                            <span class="price">￥ @if(isset($news[2])) {{sprintf('%.2f', $news[2]->price)}} @endif</span>
                            <img src="@if(isset($news[2])) {{$news[2]->thumb}} @endif" alt="">
                        </a>
                    </div>
                    <div class="ibc_multi_goods_cell right pull-left">
                        <a href="{{url('/home/product/detail')}}/@if(isset($news[3])){{$news[3]->id}}@endif">
                            <h1 class="chayefont">@if(isset($news[3])) {{$news[3]->name}} @endif</h1>
                            <span class="price">￥ @if(isset($news[3])) {{sprintf('%.2f', $news[3]->price)}} @endif</span>
                            <img src="@if(isset($news[3])) {{$news[3]->thumb}} @endif" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="index_box mb-10">
            <div class="index_box_list">
                <ul class="clearfix">
                    <li>
                        <a href="{{url('/home/product/detail')}}/@if(isset($sells[0])){{$sells[0]->id}}@endif">
                            <img src="@if(isset($sells[0])) {{$sells[0]->thumb}} @endif" alt="">
                            <h1 class="chayefont">@if(isset($sells[0])) {{$sells[0]->name}} @endif</h1>
                            <p class="chayefont">@if(isset($sells[0])) {{$sells[0]->desc}} @endif</p>
                            <span class="price">￥ @if(isset($sells[0])) {{sprintf('%.2f', $sells[0]->price)}} @endif</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/home/product/detail')}}/@if(isset($sells[1])){{$sells[1]->id}}@endif">
                            <img src="@if(isset($sells[1])) {{$sells[1]->thumb}} @endif" alt="">
                            <h1 class="chayefont">@if(isset($sells[1])) {{$sells[1]->name}} @endif</h1>
                            <p class="chayefont">@if(isset($sells[1])) {{$sells[1]->desc}} @endif</p>
                            <span class="price">￥ @if(isset($sells[1])) {{sprintf('%.2f', $sells[1]->price)}} @endif</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/home/product/detail')}}/@if(isset($sells[2])){{$sells[2]->id}}@endif">
                            <img src="@if(isset($sells[2])) {{$sells[2]->thumb}} @endif" alt="">
                            <h1 class="chayefont">@if(isset($sells[2])) {{$sells[2]->name}} @endif</h1>
                            <p class="chayefont">@if(isset($sells[2])) {{$sells[2]->desc}} @endif</p>
                            <span class="price">￥ @if(isset($sells[2])) {{sprintf('%.2f', $sells[2]->price)}} @endif</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @include("layouts.footer")
    
    @include("layouts.service")

@endsection
