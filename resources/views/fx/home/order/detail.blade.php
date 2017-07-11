@extends('layouts.app')

@section('title') 订单详情 @endsection

@section('css')
@endsection

@section('script')
    @parent
@endsection

@section('content')

    @include("layouts.header-info")
    
    <div class="orderdetail">
        <div class="orderdetail_warpper mb-20">
            <div class="orderdetail_warpper_info">
                <div class="orderdetail_warpper_info_img pull-left mr-20">
                    <img src="{{url('fx/images/goods_avatar.png')}}">
                </div>
                <div class="orderdetail_warpper_info_detail pull-left mr-20">
                    <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                    <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                </div>
                <div class="orderdetail_warpper_info_price pull-left txt-r">
                    <span class="block price">&yen;212.00</span>
                    <del class="block price_raw">&yen;299.00</del>
                    <span class="block times">&times;2</span>
                </div>
            </div>
            <div class="orderdetail_warpper_cheap">
                <span class="pull-left chayefont fz-18">优惠券</span>
                <span class="pull-right gray fz-14 J_show_roll">
                    已使用优惠券1
                </span>
            </div>
            <div class="orderdetail_warpper_cheap">
                <span class="pull-left chayefont fz-18">积分抵扣</span>
                <span class="pull-right price fz-14 user-grade">
                    已使用100分
                </span>
            </div>
            <div class="orderdetail_warpper_sum txt-r">
                <span>总2件商品</span>
                <span>合计：<i class="price">&yen;424.00</i>（包运费）</span>
            </div>
        </div>
        <div class="orderdetail_state">
            <span>订单当前状态：</span>
            <span>未付款</span>
        </div>
        <!-- 物流 -->
        <div class="delivery"></div>
        <!-- 评价 -->
        <div class="comment"></div>
        <!-- 退货 -->
        <div class="backn"></div>
    </div>
@endsection