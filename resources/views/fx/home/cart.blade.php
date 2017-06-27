@extends('layouts.app')

@section('title') 订单管理 @endsection

@section('css')
@endsection

@section('script')
    @parent
@endsection

@section('content')

    @include("layouts.header-info")
    
    <div class="cart">
        <div class="cart_container">
            <div class="cart_warpper mb-20">
                <div class="cart_warpper_tit">
                    <a href="javascript:;" class="chayefont">
                        <i class="fa fa-ban"></i>
                        绿茶宝塔镇河妖
                    </a>
                </div>
                <div class="cart_warpper_content clearfix">
                    <div class="cart_warpper_content_img pull-left mr-20">
                        <img src="{{ url('fx/img/shop11.png') }}">
                    </div>
                    <div class="cart_warpper_content_info pull-right">
                        <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                        <p>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
                        <div class="cart_warpper_content_info_bottom">
                            <span class="pull-left price">￥212.00</span>
                            <div class="cwcib_number pull-right">
                                <i class="fa fa-minus-circle"></i>
                                <span class="sell">&times2</span>
                                <i class="fa fa-plus-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cart_warpper mb-20">
                <div class="cart_warpper_tit">
                    <a href="javascript:;" class="chayefont">
                        <i class="fa fa-ban"></i>
                        绿茶宝塔镇河妖
                    </a>
                </div>
                <div class="cart_warpper_content clearfix">
                    <div class="cart_warpper_content_img pull-left mr-20">
                        <img src="{{ url('fx/img/shop11.png') }}">
                    </div>
                    <div class="cart_warpper_content_info pull-right">
                        <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                        <p>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
                        <div class="cart_warpper_content_info_bottom">
                            <span class="pull-left price">￥212.00</span>
                            <div class="cwcib_number pull-right">
                                <i class="fa fa-minus-circle"></i>
                                <span class="sell">&times2</span>
                                <i class="fa fa-plus-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cart_warpper mb-20">
                <div class="cart_warpper_tit">
                    <a href="javascript:;" class="chayefont">
                        <i class="fa fa-ban"></i>
                        绿茶宝塔镇河妖
                    </a>
                </div>
                <div class="cart_warpper_content clearfix">
                    <div class="cart_warpper_content_img pull-left mr-20">
                        <img src="{{ url('fx/img/shop11.png') }}">
                    </div>
                    <div class="cart_warpper_content_info pull-right">
                        <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                        <p>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
                        <div class="cart_warpper_content_info_bottom">
                            <span class="pull-left price">￥212.00</span>
                            <div class="cwcib_number pull-right">
                                <i class="fa fa-minus-circle"></i>
                                <span class="sell">&times2</span>
                                <i class="fa fa-plus-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cart_warpper mb-20">
                <div class="cart_warpper_tit">
                    <a href="javascript:;" class="chayefont">
                        <i class="fa fa-ban"></i>
                        绿茶宝塔镇河妖
                    </a>
                </div>
                <div class="cart_warpper_content clearfix">
                    <div class="cart_warpper_content_img pull-left mr-20">
                        <img src="{{ url('fx/img/shop11.png') }}">
                    </div>
                    <div class="cart_warpper_content_info pull-right">
                        <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                        <p>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
                        <div class="cart_warpper_content_info_bottom">
                            <span class="pull-left price">￥212.00</span>
                            <div class="cwcib_number pull-right">
                                <i class="fa fa-minus-circle"></i>
                                <span class="sell">&times2</span>
                                <i class="fa fa-plus-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cart_warpper mb-20">
                <div class="cart_warpper_tit">
                    <a href="javascript:;" class="chayefont">
                        <i class="fa fa-ban"></i>
                        绿茶宝塔镇河妖
                    </a>
                </div>
                <div class="cart_warpper_content clearfix">
                    <div class="cart_warpper_content_img pull-left mr-20">
                        <img src="{{ url('fx/img/shop11.png') }}">
                    </div>
                    <div class="cart_warpper_content_info pull-right">
                        <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                        <p>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
                        <div class="cart_warpper_content_info_bottom">
                            <span class="pull-left price">￥212.00</span>
                            <div class="cwcib_number pull-right">
                                <i class="fa fa-minus-circle"></i>
                                <span class="sell">&times2</span>
                                <i class="fa fa-plus-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cart_bottom">
            <span class="cart_bottom_selection pull-left">全选</span>
            <div class="cart_bottom_info pull-left">合计：<span class="price">&yen9999.00</span></div>
            <div class="cart_bottom_settle pull-right">结算</div>
            <div class="cart_bottom_del pull-right">删除</div>
        </div>
        <!-- <div class="cart_container">
            <div class="cart_warpper mb-20">
                <div class="cart_warpper_tit">
                    <h1 class="pull-left chayefont">
                        <i class="fa fa-ban"></i>
                        绿茶宝塔镇河妖
                        <i class="fa fa-angle-right ml-20"></i>
                    </h1>
                    <span class="pull-right chayefont">等待买家付款</span>
                </div>
                <div class="cart_warpper_info">
                    <div class="cart_warpper_info_img pull-left mr-20">
                        <img src="{{url('fx/images/goods_avatar.png')}}">
                    </div>
                    <div class="cart_warpper_info_detail pull-left mr-20">
                        <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                        <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                    </div>
                    <div class="cart_warpper_info_price pull-left txt-r">
                        <span class="block price">&yen212.00</span>
                        <del class="block price_raw">&yen299.00</del>
                        <span class="block times">&times2</span>
                    </div>
                </div>
                <div class="cart_warpper_sum txt-r">
                    <span>总2件商品</span>
                    <span>合计：<i class="price">&yen424.00</i>（包运费）</span>
                </div>
                <div class="cart_warpper_opts">
                    <ul class="pull-right">
                        <li>
                            <a href="javascript:;" class="chayefont">
                                联系卖家
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" class="chayefont">
                                取消订单
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" class="chayefont point">
                                付款
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="cart_warpper mb-20">
                <div class="cart_warpper_tit">
                    <h1 class="pull-left chayefont">
                        <i class="fa fa-ban"></i>
                        绿茶宝塔镇河妖
                        <i class="fa fa-angle-right ml-20"></i>
                    </h1>
                    <span class="pull-right chayefont">等待买家付款</span>
                </div>
                <div class="cart_warpper_info">
                    <div class="cart_warpper_info_img pull-left mr-20">
                        <img src="{{url('fx/images/goods_avatar.png')}}">
                    </div>
                    <div class="cart_warpper_info_detail pull-left mr-20">
                        <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                        <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                    </div>
                    <div class="cart_warpper_info_price pull-left txt-r">
                        <span class="block price">&yen212.00</span>
                        <del class="block price_raw">&yen299.00</del>
                        <span class="block times">&times2</span>
                    </div>
                </div>
                <div class="cart_warpper_sum txt-r">
                    <span>总2件商品</span>
                    <span>合计：<i class="price">&yen424.00</i>（包运费）</span>
                </div>
                <div class="cart_warpper_opts">
                    <ul class="pull-right">
                        <li>
                            <a href="javascript:;" class="chayefont point">
                                生成二维码
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="cart_warpper mb-20">
                <div class="cart_warpper_tit">
                    <h1 class="pull-left chayefont">
                        <i class="fa fa-ban"></i>
                        绿茶宝塔镇河妖
                        <i class="fa fa-angle-right ml-20"></i>
                    </h1>
                    <span class="pull-right chayefont">等待买家付款</span>
                </div>
                <div class="cart_warpper_info">
                    <div class="cart_warpper_info_img pull-left mr-20">
                        <img src="{{url('fx/images/goods_avatar.png')}}">
                    </div>
                    <div class="cart_warpper_info_detail pull-left mr-20">
                        <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                        <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                    </div>
                    <div class="cart_warpper_info_price pull-left txt-r">
                        <span class="block price">&yen212.00</span>
                        <del class="block price_raw">&yen299.00</del>
                        <span class="block times">&times2</span>
                    </div>
                </div>
                <div class="cart_warpper_sum txt-r">
                    <span>总2件商品</span>
                    <span>合计：<i class="price">&yen424.00</i>（包运费）</span>
                </div>
            </div>
            <div class="cart_warpper mb-20">
                <div class="cart_warpper_tit">
                    <h1 class="pull-left chayefont">
                        <i class="fa fa-ban"></i>
                        绿茶宝塔镇河妖
                        <i class="fa fa-angle-right ml-20"></i>
                    </h1>
                    <span class="pull-right chayefont">等待买家付款</span>
                </div>
                <div class="cart_warpper_info">
                    <div class="cart_warpper_info_img pull-left mr-20">
                        <img src="{{url('fx/images/goods_avatar.png')}}">
                    </div>
                    <div class="cart_warpper_info_detail pull-left mr-20">
                        <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                        <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                    </div>
                    <div class="cart_warpper_info_price pull-left txt-r">
                        <span class="block price">&yen212.00</span>
                        <del class="block price_raw">&yen299.00</del>
                        <span class="block times">&times2</span>
                    </div>
                </div>
                <div class="cart_warpper_sum txt-r">
                    <span>总2件商品</span>
                    <span>合计：<i class="price">&yen424.00</i>（包运费）</span>
                </div>
                <div class="cart_warpper_opts">
                    <ul class="pull-right">
                        <li>
                            <a href="javascript:;" class="chayefont">
                                联系卖家
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" class="chayefont">
                                查看物流
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" class="chayefont point">
                                确定收货
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="cart_warpper mb-20">
                <div class="cart_warpper_tit">
                    <h1 class="pull-left chayefont">
                        <i class="fa fa-ban"></i>
                        绿茶宝塔镇河妖
                        <i class="fa fa-angle-right ml-20"></i>
                    </h1>
                    <span class="pull-right chayefont">等待买家付款</span>
                </div>
                <div class="cart_warpper_info">
                    <div class="cart_warpper_info_img pull-left mr-20">
                        <img src="{{url('fx/images/goods_avatar.png')}}">
                    </div>
                    <div class="cart_warpper_info_detail pull-left mr-20">
                        <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                        <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                    </div>
                    <div class="cart_warpper_info_price pull-left txt-r">
                        <span class="block price">&yen212.00</span>
                        <del class="block price_raw">&yen299.00</del>
                        <span class="block times">&times2</span>
                    </div>
                </div>
                <div class="cart_warpper_sum txt-r">
                    <span>总2件商品</span>
                    <span>合计：<i class="price">&yen424.00</i>（包运费）</span>
                </div>
                <div class="cart_warpper_opts">
                    <ul class="pull-right">
                        <li>
                            <a href="javascript:;" class="chayefont point">
                                评价
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div> -->
    </div>
    <!-- 联系卖家 -->
    <!-- 取消订单 -->
    <!-- 付款 -->

    <!-- 生成二维码 -->

    <!-- 联系卖家 -->
    <!-- 查看物流 -->
    <!-- 确定收货 -->

    <!-- 评价 -->
    @include("layouts.footer")
@endsection
