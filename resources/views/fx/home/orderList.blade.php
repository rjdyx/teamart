@extends('layouts.app')

@section('title') 订单管理 @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/css/myOrder.css') }}">
@endsection

@section('script')
    @parent
    <script type="text/javascript" src="{{ url('fx/js/myOrder.js') }}"></script>
@endsection

@section('content')

    @include("layouts.header-info")
     <!--搜索栏-->
    <div class="myOrder_search">
        <div class="search_ground">
            <div class="search_input">
                <img src="{{ url('fx/img/search_sign.png') }}" class="search_sign">
                <input type="value" placeholder="商品名称／商品编号／订单号" class="input_area"></div>
        </div>
    </div>

    <!--导航栏-->
    <div class="myOrder_navigation_bar">
        <ul class="myOrder_navigation_bar_ul" style="height: 45px;margin-top: 5px;margin-bottom: 2px;text-align: center">
            <li class="li">
                <div class="myOrder_navigation_bar_li" onclick="handleClick(0)">
                    <img src="{{ url('fx/img/all_sign.png') }}" class="myOrder_navigation_bar_sign all_sign">

                    <span class="myOrder_navigation_bar_word">全部</span>
                </div>
            </li>
            <li class="li">
                <div class="myOrder_navigation_bar_li" onclick="handleClick(1)">
                    <img src="{{ url('fx/img/pay_sign.png') }}" class="myOrder_navigation_bar_sign pay_sign sign_left">

                    <span class="myOrder_navigation_bar_word">待付款</span>
                </div>
            </li>
            <li class="li">
                <div class="myOrder_navigation_bar_li" onclick="handleClick(2)">
                    <img src="{{ url('fx/img/shipment_sign.png') }}" class="myOrder_navigation_bar_sign shipment_sign sign_left">

                    <span class="myOrder_navigation_bar_word">待取货</span>
                </div>
            </li>
            <li class="li">
                <div class="myOrder_navigation_bar_li" onclick="handleClick(3)">
                    <img src="{{ url('fx/img/delivery.png') }}" class="myOrder_navigation_bar_sign delivery_sign sign_left">

                    <span class="myOrder_navigation_bar_word">待发货</span>
                </div>
            </li>
            <li class="li">
                <div class="myOrder_navigation_bar_li" onclick="handleClick(4)">
                    <img src="{{ url('fx/img/receive_sign.png') }}" class="myOrder_navigation_bar_sign receive_sign sign_left">

                    <span class="myOrder_navigation_bar_word">待收货</span>
                </div>
            </li>
            <li class="li">
                <div class="myOrder_navigation_bar_li" onclick="handleClick(5)">
                    <img src="{{ url('fx/img/evaluate_sign.png') }}" class="myOrder_navigation_bar_sign evaluate_sign sign_left">

                    <span class="myOrder_navigation_bar_word">待评价</span>
                </div>
            </li>
        </ul>
    </div>

    <div style="width: 100%;height: 2px;background-color: #d5d5d6;position: fixed;z-index: 9999"></div>

    <!--订单列表-->
    <div id="content" style="margin-top: 165px;z-index: -1;margin-bottom: 50px;display: block;background-color: #EEEFF1;">
    </div>
    @include("layouts.footer")
@endsection
