@extends('layouts.app')

@section('title')
首页
@endsection

@section('css')
@endsection

@section('script')
    @parent
@endsection

@section('content')

@include("layouts.header")
    <div class="container index" >
        <!-- 轮播 -->
        <div class="banner swiper-container">
            <div class="swiper-wrapper">
                <ul>
                @if(count($lbs))
                    @foreach($lbs as $lb)
                        <li class="swiper-slide"><img src="{{url('')}}/{{$lb}}" alt=""></li> 
                    @endforeach
                @else
                    <li class="swiper-slide"><img src="fx/images/index_banner.png" alt=""></li> 
                @endif
                </ul>
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
                <div class="ibc_single pull-left">
                    <a href="javascript:;">
                        <h5 class="chayefont">@if(isset($activitys[0])) {{$activitys[0]->name}} @endif</h5>
                        <span class="price"> ￥ @if(isset($activitys[0])) {{sprintf('%.2f', $activitys[0]->price)}} @endif</span>
                        <img src="@if(isset($activitys[0])) {{$activitys[0]->thumb}} @endif" alt="图片">
                    </a>
                </div>
                <div class="ibc_multi pull-right">
                    <div class="ibc_multi_goods top">
                        <a href="javascript:;">
                            <img class="pull-right" src="@if(isset($activitys[1])) {{$activitys[1]->image}} @endif" alt="">
                            <h5 class="chayefont">@if(isset($activitys[1])) {{$activitys[1]->name}} @endif</h5>
                            <p class="chayefont">@if(isset($activitys[1])) {{$activitys[1]->desc}} @endif</p>
                            <span class="price">￥ @if(isset($activitys[1])) {{sprintf('%.2f', $activitys[1]->price)}} @endif</span>
                        </a>
                    </div>
                    <div class="ibc_multi_goods txt-r">
                        <a href="javascript:;">
                            <img class="pull-left" src="@if(isset($activitys[2])) {{$activitys[2]->image}} @endif" alt="">
                            <h5 class="chayefont">@if(isset($activitys[2])) {{$activitys[2]->name}} @endif</h5>
                            <p class="chayefont">@if(isset($activitys[2])) {{$activitys[2]->desc}} @endif</p>
                            <span class="price">￥ @if(isset($activitys[2])) {{sprintf('%.2f', $activitys[2]->price)}} @endif</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner_box mb-10">
            @foreach ($ads as $ad)
            <a href="{{$ad->url}}">
            <div class="banner_box_row mb-10" style="height:150px;">
                <img src="{{url('')}}/{{$ad->img}}" alt="{{$ad->name}}" height="100%">
                <p class="chayefont">{{$ad->desc}}</p>
            </div></a>
            @endforeach
        </div>
        
        <div class="index_box">
            <div class="index_box_title">
                <h1 class="pull-left chayefont">最新商品</h1>
                <a href="javascript:;" class="pull-right">
                    <span class="chayefont">更多</span>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
            <div class="index_box_content clearfix">
                <div class="ibc_single pull-right">
                    <a href="#">
                        <h5 class="chayefont">@if(isset($news[0])) {{$news[0]->name}} @endif</h5>
                        <span class="price">￥ @if(isset($news[0])) {{sprintf('%.2f', $news[0]->price)}} @endif</span>
                        <img src="@if(isset($news[0])) {{$news[0]->image}} @endif" alt="">
                    </a>
                </div>
                <div class="ibc_multi pull-left">
                    <div class="ibc_multi_goods top">
                        <a href="javascript:;">
                            <img class="pull-right" src="@if(isset($news[1])) {{$news[1]->image}} @endif" alt="">
                            <h5 class="chayefont">@if(isset($news[1])) {{$news[1]->name}} @endif</h5>
                            <p class="chayefont">@if(isset($news[1])) {{$news[1]->desc}} @endif</p>
                            <span class="price">￥ @if(isset($news[1])) {{sprintf('%.2f', $news[1]->price)}} @endif</span>
                        </a>
                    </div>
                    <div class="ibc_multi_goods_cell left pull-left">
                        <a href="javascript:;">
                            <h5 class="chayefont">@if(isset($news[2])) {{$news[2]->name}} @endif</h5>
                            <span class="price">￥ @if(isset($news[2])) {{sprintf('%.2f', $news[2]->price)}} @endif</span>
                            <img src="@if(isset($news[2])) {{$news[2]->image}} @endif" alt="">
                        </a>
                    </div>
                    <div class="ibc_multi_goods_cell right pull-left">
                        <a href="javascript:;">
                            <h5 class="chayefont">@if(isset($news[3])) {{$news[3]->name}} @endif</h5>
                            <span class="price">￥ @if(isset($news[3])) {{sprintf('%.2f', $news[3]->price)}} @endif</span>
                            <img src="@if(isset($news[3])) {{$news[3]->image}} @endif" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="index_box">
            <div class="index_box_list">
                <ul class="clearfix">
                    <li>
                        <a href="javascript:;">
                            <img src="@if(isset($sells[0])) {{$sells[0]->image}} @endif" alt="">
                            <h5 class="chayefont">@if(isset($sells[0])) {{$sells[0]->name}} @endif</h5>
                            <p class="chayefont">@if(isset($sells[0])) {{$sells[0]->desc}} @endif</p>
                            <span class="price">￥ @if(isset($sells[0])) {{sprintf('%.2f', $sells[0]->price)}} @endif</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <img src="@if(isset($sells[1])) {{$sells[1]->image}} @endif" alt="">
                            <h5 class="chayefont">@if(isset($sells[1])) {{$sells[1]->name}} @endif</h5>
                            <p class="chayefont">@if(isset($sells[1])) {{$sells[1]->desc}} @endif</p>
                            <span class="price">￥ @if(isset($sells[1])) {{sprintf('%.2f', $sells[1]->price)}} @endif</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <img src="@if(isset($sells[2])) {{$sells[2]->image}} @endif" alt="">
                            <h5 class="chayefont">@if(isset($sells[2])) {{$sells[2]->name}} @endif</h5>
                            <p class="chayefont">@if(isset($sells[2])) {{$sells[2]->desc}} @endif</p>
                            <span class="price">￥ @if(isset($sells[2])) {{sprintf('%.2f', $sells[2]->price)}} @endif</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @include("layouts.footer")
@endsection
