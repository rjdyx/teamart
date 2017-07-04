@extends('layouts.app')

@section('title') 发表评论 @endsection

@section('css')
@endsection

@section('script')
    @parent
@endsection

@section('content')
    @include("layouts.header-info")

    @include("layouts.backIndex")
	<div class="orderdelivery">
		<div class="orderdelivery_order_lists">
            <div class="orderdelivery_warpper">
                <div class="orderdelivery_warpper_img pull-left mr-20">
                    <img src="{{url('fx/images/goods_avatar.png')}}">
                </div>
                <div class="orderdelivery_warpper_detail pull-left mr-20">
                    <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                    <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                </div>
                <div class="orderdelivery_warpper_price pull-left txt-r">
                    <span class="block price">&yen;212.00</span>
                    <del class="block price_raw">&yen;299.00</del>
                    <span class="block times">&times;2</span>
                </div>
            </div>
            <div class="orderdelivery_warpper">
                <div class="orderdelivery_warpper_img pull-left mr-20">
                    <img src="{{url('fx/images/goods_avatar.png')}}">
                </div>
                <div class="orderdelivery_warpper_detail pull-left mr-20">
                    <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                    <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                </div>
                <div class="orderdelivery_warpper_price pull-left txt-r">
                    <span class="block price">&yen;212.00</span>
                    <del class="block price_raw">&yen;299.00</del>
                    <span class="block times">&times;2</span>
                </div>
            </div>
            <div class="orderdelivery_warpper">
                <div class="orderdelivery_warpper_img pull-left mr-20">
                    <img src="{{url('fx/images/goods_avatar.png')}}">
                </div>
                <div class="orderdelivery_warpper_detail pull-left mr-20">
                    <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                    <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                </div>
                <div class="orderdelivery_warpper_price pull-left txt-r">
                    <span class="block price">&yen;212.00</span>
                    <del class="block price_raw">&yen;299.00</del>
                    <span class="block times">&times;2</span>
                </div>
            </div>
		</div>
		<div class="orderdelivery_sender mt-20">
			由DD快递提供配送服务,xx配送员配送中
			<a href="tel:88888" class="pull-right color-F78223"><i class="fa fa-mobile"></i></a>
		</div>
		<div class="orderdelivery_lists mt-20">
			<div class="orderdelivery_lists_process active">
				<p class="mb-10">极大发圣诞节扣篮大赛极大发圣诞节扣篮大赛极大发圣诞节扣篮大赛极大发圣诞节扣篮大赛</p>
				<p class="fz-12 txt-r">0000年00月00日 00时00分00秒</p>
			</div>
			<div class="orderdelivery_lists_process">
				<p class="mb-10">极大发圣诞节扣篮大赛极大发圣诞节扣篮大赛极大发圣诞节扣篮大赛极大发圣诞节扣篮大赛</p>
				<p class="fz-12 txt-r">0000年00月00日 00时00分00秒</p>
			</div>
			<div class="orderdelivery_lists_process">
				<p class="mb-10">极大发圣诞节扣篮大赛极大发圣诞节扣篮大赛极大发圣诞节扣篮大赛极大发圣诞节扣篮大赛</p>
				<p class="fz-12 txt-r">0000年00月00日 00时00分00秒</p>
			</div>
			<div class="orderdelivery_lists_process">
				<p class="mb-10">极大发圣诞节扣篮大赛极大发圣诞节扣篮大赛极大发圣诞节扣篮大赛极大发圣诞节扣篮大赛</p>
				<p class="fz-12 txt-r">0000年00月00日 00时00分00秒</p>
			</div>
		</div>
	</div>
@endsection