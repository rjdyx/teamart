@extends('layouts.app')

@section('title') 订单管理 @endsection

@section('css')
@endsection

@section('script')
    @parent
@endsection

@section('content')

    @include("layouts.header-info")
    
    <div class="container order">
        <div class="order_search">
            <input type="text" placeholder="商品名称／商品编号／订单号">
            <i class="fa fa-search"></i>
        </div>
        <div class="order_tabs">
            <ul>
                <li class="active">
                    <i class="fa fa-align-justify"></i>
                    <p>全部</p>
                </li>
                <li>
                    <i class="fa fa-money"></i>
                    <p>待付款</p>
                </li>
                <li>
                    <i class="fa fa-map-marker"></i>
                    <p>待取货</p>
                </li>
                <li>
                    <i class="fa fa-feed"></i>
                    <p>待发货</p>
                </li>
                <li>
                    <i class="fa fa-car"></i>
                    <p>待收货</p>
                </li>
                <li>
                    <i class="fa fa-comment-o"></i>
                    <p>待评价</p>
                </li>
            </ul>
        </div>
        <div class="order_container">
            <div class="order_warpper mb-20">
                <div class="order_warpper_tit">
                    <h1 class="pull-left chayefont">
                        <i class="fa fa-ban"></i>
                        绿茶宝塔镇河妖
                        <i class="fa fa-angle-right ml-20"></i>
                    </h1>
                    <span class="pull-right chayefont">等待买家付款</span>
                </div>
                <div class="order_warpper_info">
                    <div class="order_warpper_info_img pull-left mr-20">
                        <img src="{{url('fx/images/goods_avatar.png')}}">
                    </div>
                    <div class="order_warpper_info_detail pull-left mr-20">
                        <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                        <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                    </div>
                    <div class="order_warpper_info_price pull-left txt-r">
                        <span class="block price">&yen212.00</span>
                        <del class="block price_raw">&yen299.00</del>
                        <span class="block times">&times2</span>
                    </div>
                </div>
                <div class="order_warpper_sum txt-r">
                    <span>总2件商品</span>
                    <span>合计：<i class="price">&yen424.00</i>（包运费）</span>
                </div>
                <div class="order_warpper_opts">
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
            <div class="order_warpper mb-20">
                <div class="order_warpper_tit">
                    <h1 class="pull-left chayefont">
                        <i class="fa fa-ban"></i>
                        绿茶宝塔镇河妖
                        <i class="fa fa-angle-right ml-20"></i>
                    </h1>
                    <span class="pull-right chayefont">等待买家付款</span>
                </div>
                <div class="order_warpper_info">
                    <div class="order_warpper_info_img pull-left mr-20">
                        <img src="{{url('fx/images/goods_avatar.png')}}">
                    </div>
                    <div class="order_warpper_info_detail pull-left mr-20">
                        <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                        <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                    </div>
                    <div class="order_warpper_info_price pull-left txt-r">
                        <span class="block price">&yen212.00</span>
                        <del class="block price_raw">&yen299.00</del>
                        <span class="block times">&times2</span>
                    </div>
                </div>
                <div class="order_warpper_sum txt-r">
                    <span>总2件商品</span>
                    <span>合计：<i class="price">&yen424.00</i>（包运费）</span>
                </div>
                <div class="order_warpper_opts">
                    <ul class="pull-right">
                        <li>
                            <a href="javascript:;" class="chayefont point">
                                生成二维码
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="order_warpper mb-20">
                <div class="order_warpper_tit">
                    <h1 class="pull-left chayefont">
                        <i class="fa fa-ban"></i>
                        绿茶宝塔镇河妖
                        <i class="fa fa-angle-right ml-20"></i>
                    </h1>
                    <span class="pull-right chayefont">等待买家付款</span>
                </div>
                <div class="order_warpper_info">
                    <div class="order_warpper_info_img pull-left mr-20">
                        <img src="{{url('fx/images/goods_avatar.png')}}">
                    </div>
                    <div class="order_warpper_info_detail pull-left mr-20">
                        <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                        <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                    </div>
                    <div class="order_warpper_info_price pull-left txt-r">
                        <span class="block price">&yen212.00</span>
                        <del class="block price_raw">&yen299.00</del>
                        <span class="block times">&times2</span>
                    </div>
                </div>
                <div class="order_warpper_sum txt-r">
                    <span>总2件商品</span>
                    <span>合计：<i class="price">&yen424.00</i>（包运费）</span>
                </div>
            </div>
            <div class="order_warpper mb-20">
                <div class="order_warpper_tit">
                    <h1 class="pull-left chayefont">
                        <i class="fa fa-ban"></i>
                        绿茶宝塔镇河妖
                        <i class="fa fa-angle-right ml-20"></i>
                    </h1>
                    <span class="pull-right chayefont">等待买家付款</span>
                </div>
                <div class="order_warpper_info">
                    <div class="order_warpper_info_img pull-left mr-20">
                        <img src="{{url('fx/images/goods_avatar.png')}}">
                    </div>
                    <div class="order_warpper_info_detail pull-left mr-20">
                        <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                        <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                    </div>
                    <div class="order_warpper_info_price pull-left txt-r">
                        <span class="block price">&yen212.00</span>
                        <del class="block price_raw">&yen299.00</del>
                        <span class="block times">&times2</span>
                    </div>
                </div>
                <div class="order_warpper_sum txt-r">
                    <span>总2件商品</span>
                    <span>合计：<i class="price">&yen424.00</i>（包运费）</span>
                </div>
                <div class="order_warpper_opts">
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
            <div class="order_warpper mb-20">
                <div class="order_warpper_tit">
                    <h1 class="pull-left chayefont">
                        <i class="fa fa-ban"></i>
                        绿茶宝塔镇河妖
                        <i class="fa fa-angle-right ml-20"></i>
                    </h1>
                    <span class="pull-right chayefont">等待买家付款</span>
                </div>
                <div class="order_warpper_info">
                    <div class="order_warpper_info_img pull-left mr-20">
                        <img src="{{url('fx/images/goods_avatar.png')}}">
                    </div>
                    <div class="order_warpper_info_detail pull-left mr-20">
                        <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                        <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                    </div>
                    <div class="order_warpper_info_price pull-left txt-r">
                        <span class="block price">&yen212.00</span>
                        <del class="block price_raw">&yen299.00</del>
                        <span class="block times">&times2</span>
                    </div>
                </div>
                <div class="order_warpper_sum txt-r">
                    <span>总2件商品</span>
                    <span>合计：<i class="price">&yen424.00</i>（包运费）</span>
                </div>
                <div class="order_warpper_opts">
                    <ul class="pull-right">
                        <li>
                            <a href="javascript:;" class="chayefont point">
                                评价
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
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
