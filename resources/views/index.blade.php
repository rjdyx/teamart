@extends('layouts.app')

@section('title')
首页
@endsection

@section('css')
@endsection

@section('script')
    @parent
    <script src="{{url('/fx/build/swiper.js')}}"></script>
    <script>
        alert(<?php echo isset($_GET['code'])?$_GET['code']:'false'; ?>);
    </script>
@endsection

@section('content')

@include("layouts.header")
    <div class="container index">
        <!-- 轮播 -->
        <div class="banner w-100 swiper-container">
            <ul class="swiper-wrapper">
            @if(count($lbs))
                @foreach($lbs as $lb)
                    <li class="swiper-slide" data-swiper-autoplay="2000"><img src="{{url('')}}/{{$lb}}" alt="" class="w-100"></li> 
                @endforeach
            @else
                <li class="swiper-slide"><img class="w-100" src="fx/images/index_banner.png" alt=""></li> 
            @endif
            </ul>
            <div class="swiper-pagination"></div>
        </div>
        <div class="index_box w-100 mb-10">
            <div class="index_box_title w-100">
                <h1 class="pull-left chayefont white">活动商品</h1>
                <a href="{{url('/home/activity/many')}}" class="pull-right inline-block">
                    <span class="chayefont">更多</span>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
            <div class="index_box_content w-100 clearfix">
                <div class="ibc_single pull-left p-10">
                    <a href="{{url('/home/product/detail')}}/@if(isset($activitys[0])){{$activitys[0]->id}}@endif">
                        <h1 class="chayefont">@if(isset($activitys[0])) {{$activitys[0]->name}} @endif</h1>
                        <p class="chayefont">@if(isset($activitys[0])) {{$activitys[0]->desc}} @endif</p>
                        <span class="block price mt-10 mb-10"> ￥ @if(isset($activitys[0])) {{sprintf('%.2f', $activitys[0]->price)}} @endif</span>
                        <img src="@if(isset($activitys[0])) {{$activitys[0]->thumb}} @endif" alt="图片">
                    </a>
                </div>
                <div class="ibc_multi pull-right">
                    <div class="ibc_multi_goods p-10 top">
                        <a href="{{url('/home/product/detail')}}/@if(isset($activitys[1])){{$activitys[1]->id}}@endif">
                            <img class="pull-right h-100" src="@if(isset($activitys[1])) {{$activitys[1]->thumb}} @endif" alt="">
                            <h1 class="chayefont">@if(isset($activitys[1])) {{$activitys[1]->name}} @endif</h1>
                            <p class="mt-10 mb-10 chayefont">@if(isset($activitys[1])) {{$activitys[1]->desc}} @endif</p>
                            <span class="price">￥ @if(isset($activitys[1])) {{sprintf('%.2f', $activitys[1]->price)}} @endif</span>
                        </a>
                    </div>
                    <div class="ibc_multi_goods p-10 txt-r">
                        <a href="{{url('/home/product/detail')}}/@if(isset($activitys[2])){{$activitys[2]->id}}@endif">
                            <img class="pull-left h-100" src="@if(isset($activitys[2])) {{$activitys[2]->thumb}} @endif" alt="">
                            <h1 class="chayefont">@if(isset($activitys[2])) {{$activitys[2]->name}} @endif</h1>
                            <p class="chayefont txt-l mt-10 mb-10">@if(isset($activitys[2])) {{$activitys[2]->desc}} @endif</p>
                            <span class="price">￥ @if(isset($activitys[2])) {{sprintf('%.2f', $activitys[2]->price)}} @endif</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if (count($ads) > 0)
        <div class="banner_box w-100 mb-10 p-10">
            @foreach ($ads as $ad)
            <a href="{{$ad->url}}">
            <div class="banner_box_row mb-10 w-100">
                <img src="{{url('')}}/{{$ad->img}}" alt="{{$ad->name}}" class="w-100 h-100">
                <p class="chayefont w-100 fz-16">{{$ad->desc}}</p>
            </div></a>
            @endforeach
        </div>
        @endif

        <div class="index_box w-100 mb-10">
            <div class="index_box_title w-100">
                <h1 class="pull-left chayefont white">最新商品</h1>
                <a href="{{url('/home/promotion/new')}}" class="pull-right inline-block">
                    <span class="chayefont">更多</span>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
            <div class="index_box_content w-100 clearfix">
                <div class="ibc_single pull-right p-10">
                    <a href="{{url('/home/product/detail')}}/@if(isset($news[0])){{$news[0]->id}}@endif">
                        <h1 class="chayefont">@if(isset($news[0])) {{$news[0]->name}} @endif</h1>
                        <p class="chayefont">@if(isset($news[0])) {{$news[0]->desc}} @endif</p>
                        <span class="block price mt-10 mb-10">￥ @if(isset($news[0])) {{sprintf('%.2f', $news[0]->price)}} @endif</span>
                        <img src="@if(isset($news[0])) {{$news[0]->thumb}} @endif" alt="">
                    </a>
                </div>
                <div class="ibc_multi pull-left">
                    <div class="ibc_multi_goods p-10 top">
                        <a href="{{url('/home/product/detail')}}/@if(isset($news[1])){{$news[1]->id}}@endif">
                            <img class="pull-right h-100" src="@if(isset($news[1])) {{$news[1]->thumb}} @endif" alt="">
                            <h1 class="chayefont">@if(isset($news[1])) {{$news[1]->name}} @endif</h1>
                            <p class="chayefont mt-10 mb-10">@if(isset($news[1])) {{$news[1]->desc}} @endif</p>
                            <span class="price">￥ @if(isset($news[1])) {{sprintf('%.2f', $news[1]->price)}} @endif</span>
                        </a>
                    </div>
                    <div class="ibc_multi_goods_cell p-10 left pull-left txt-c">
                        <a href="{{url('/home/product/detail')}}/@if(isset($news[2])){{$news[2]->id}}@endif" class="block">
                            <h1 class="chayefont">@if(isset($news[2])) {{$news[2]->name}} @endif</h1>
                            <span class="price">￥ @if(isset($news[2])) {{sprintf('%.2f', $news[2]->price)}} @endif</span>
                            <img src="@if(isset($news[2])) {{$news[2]->thumb}} @endif" alt="">
                        </a>
                    </div>
                    <div class="ibc_multi_goods_cell p-10 right pull-left txt-c">
                        <a href="{{url('/home/product/detail')}}/@if(isset($news[3])){{$news[3]->id}}@endif" class="block">
                            <h1 class="chayefont">@if(isset($news[3])) {{$news[3]->name}} @endif</h1>
                            <span class="price">￥ @if(isset($news[3])) {{sprintf('%.2f', $news[3]->price)}} @endif</span>
                            <img src="@if(isset($news[3])) {{$news[3]->thumb}} @endif" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="index_list mb-10 w-100">
            <ul class="clearfix">
                <!-- <li class="pull-left">
                    <a href="{{url('/home/product/detail')}}/@if(isset($sells[0])){{$sells[0]->id}}@endif">
                        <img src="@if(isset($sells[0])) {{$sells[0]->thumb}} @endif" alt="">
                        <h1 class="chayefont">@if(isset($sells[0])) {{$sells[0]->name}} @endif</h1>
                        <p class="chayefont">@if(isset($sells[0])) {{$sells[0]->desc}} @endif</p>
                        <span class="price">￥ @if(isset($sells[0])) {{sprintf('%.2f', $sells[0]->price)}} @endif</span>
                    </a>
                </li>
                <li class="pull-left">
                    <a href="{{url('/home/product/detail')}}/@if(isset($sells[1])){{$sells[1]->id}}@endif">
                        <img src="@if(isset($sells[1])) {{$sells[1]->thumb}} @endif" alt="">
                        <h1 class="chayefont">@if(isset($sells[1])) {{$sells[1]->name}} @endif</h1>
                        <p class="chayefont">@if(isset($sells[1])) {{$sells[1]->desc}} @endif</p>
                        <span class="price">￥ @if(isset($sells[1])) {{sprintf('%.2f', $sells[1]->price)}} @endif</span>
                    </a>
                </li>
                <li class="pull-left">
                    <a href="{{url('/home/product/detail')}}/@if(isset($sells[2])){{$sells[2]->id}}@endif">
                        <img src="@if(isset($sells[2])) {{$sells[2]->thumb}} @endif" alt="">
                        <h1 class="chayefont">@if(isset($sells[2])) {{$sells[2]->name}} @endif</h1>
                        <p class="chayefont">@if(isset($sells[2])) {{$sells[2]->desc}} @endif</p>
                        <span class="price">￥ @if(isset($sells[2])) {{sprintf('%.2f', $sells[2]->price)}} @endif</span>
                    </a>
                </li> -->
                @foreach($sells as $sell)
                    @if(isset($sell))
                    <li class="pull-left p-10">
                        <a href="{{url('/home/product/detail')}}/{{$sell->id}}">
                            <img src="{{$sell->thumb}}" alt="">
                            <h1 class="chayefont">{{$sell->name}}</h1>
                            <p class="chayefont fz-12">{{$sell->desc}}</p>
                            <span class="price">&yen;{{sprintf('%.2f', $sell->price)}}</span>
                        </a>
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
    @include("layouts.footer")
    
    @include("layouts.service")

@endsection
