@extends('layouts.app')

@section('title') 商品详情 @endsection

@section('css')
@endsection

@section('script')
    @parent
    <script>
    	$('.J_tabs').on('click', function () {
    		$(this).addClass('active')
    		.siblings().removeClass('active')
    		var tag = $(this).data('tag')
    		$('[data-tab]').addClass('hide')
    		.each(function () {
    			if ($(this).data('tab') == tag) {
    				$(this).removeClass('hide')
    			}
    		})
    	})
    </script>
@endsection

@section('content')
	@include("layouts.header-info")
	<div class="container productdetail">
		<div class="productdetail_container">
			<div class="productdetail_container_banner">
				<img src="{{ url('fx/img/detail.png') }}" alt="">
			</div>
			<div class="productdetail_container_info">
				<h1 class="chayefont">云南凤庆功夫金芽红茶</h1>
				<p class="desc mt-10 mb-10">新鲜梨酥雪梨发货供货的供货皇烦得很冠分隔符梨</p>
				<span class="price">&yen12.00</span>
				<p class="mt-10 mb-10">价格：<del>25.00</del></p>
				<p class="clearfix">
					<span class="pull-left">快递：<i>0.00</i></span>
					<span class="pull-right">月销：<i>5555</i>笔</span>
				</p>
			</div>
			<div class="productdetail_container_tabs">
				<a href="javascript:;" class="J_tabs pull-left chayefont active" data-tag="detail">商品详情</a>
				<a href="javascript:;" class="J_tabs pull-left chayefont" data-tag="comment">评价<span>1000</span></a>
			</div>
			<div class="productdetail_container_detail" data-tab="detail">
				<div class="productdetail_container_detail_info clearfix">
					<ol class="pull-left">
						<li>生产许可证编号:sc11453010306856</li>
						<li>厂址:昆明市盘龙区双龙街道办事处庄房</li>
						<li>储藏方法:在通风干燥无异味的环境下存放</li>
						<li>净含量:300g</li>
						<li>系列:倚玛留香</li>
						<li>级别:一级</li>
						<li>省份:云南省</li>
					</ol>
					<ol class="pull-left">
						<li>产品标准号:GB/T 13738.2-2008</li>
						<li>保质期:1095天</li>
						<li>包装方法:散装</li>
						<li>是否为有机食品:否</li>
						<li>生长季节:春季</li>
						<li>城市:临沧市</li>
						<li>套餐分量:1人</li>
						<li>价格段:60-99元</li>
					</ol>
				</div>
				<div class="productdetail_container_detail_img">
					<img src="{{ url('fx/img/detai_top.png') }}">
					<img src="{{ url('fx/img/detai_top.png') }}">
					<img src="{{ url('fx/img/detai_top.png') }}">
				</div>
			</div>
			<div class="productdetail_container_comment hide" data-tab="comment">
				暂无评价
			</div>
		</div>
		<div class="productdetail_bottom">
			<div class="productdetail_bottom_icon pull-left kefu">
				<i class="fa fa-headphones mt-10"></i>
				<p>客服</p>
			</div>
			<div class="productdetail_bottom_icon pull-left favo">
				<i class="fa fa-star-o mt-10"></i>
				<p>收藏</p>
			</div>
			<div class="productdetail_bottom_btn pull-left chayefont add_cart">
				加入购物车
			</div>
			<div class="productdetail_bottom_btn pull-left chayefont buy_now">
				立即购买
			</div>
		</div>
	</div>
	<!-- <div class="container">
		<div class="myFocus">
			<div class="slide_content" id="slide_content">
		        <img class="slide_item" src="{{ url('fx/img/detail.png') }}" alt="1"/>
		        <img class="slide_item" src="{{ url('fx/img/detail.png') }}" alt="2"/>
		        <img class="slide_item" src="{{ url('fx/img/detail.png') }}" alt="3"/>
			</div>
		<div class="production_description">
			<h3 class="prot_name">云南凤庆功夫金芽红茶</h3>
			<p class="prot_whole_name">新鲜梨酥雪梨发货供货的供货皇烦得很冠分隔符梨</p>
			<p class="new_price">￥<span>12.0</span></p>
			<p class="old_price">价格&nbsp;:&nbsp;<span>￥25</span></p>
			<p class="postage_sales"><span class="postage">快递&nbsp;:&nbsp;0.00</span><span class="sales_volume">月销&nbsp;:&nbsp;520笔</span></p>
		</div>
		<div class="container_btn_box">
			<div class="detail_btn">&nbsp;&nbsp;商品详情</div>
			<div class="comment_btn">&nbsp;&nbsp;评价&nbsp;&nbsp;100</div>
		</div>
		<div class="production_detailInfo">
			<div class="production_detailInfo_left">
				<p>生产许可证编号:sc11453010306856</p>
				<p>厂址:昆明市盘龙区双龙街道办事处庄房</p>
				<p>储藏方法:在通风干燥无异味的环境下存放</p>
				<p>净含量:300g</p>
				<p>系列:倚玛留香</p>
				<p>级别:一级</p>
				<p>省份:云南省</p>
			</div>
			<div class="production_detailInfo_right">
				<p>产品标准号:GB/T 13738.2-2008</p>
				<p>保质期:1095天</p>
				<p>包装方法:散装</p>
				<p>是否为有机食品:否</p>
				<p>生长季节:春季</p>
				<p>城市:临沧市</p>
				<p>套餐分量:1人</p>
				<p>价格段:60-99元</p>
			</div>
		</div>
		<div class="prot_img">
			<ul>
				<li class="prot_img_single">
					<img src="{{ url('fx/img/detai_top.png') }}">
				</li>
				<li class="prot_img_single">
					<img src="{{ url('fx/img/detai_top.png') }}">
				</li>
				<li class="prot_img_single">
					<img src="{{ url('fx/img/detai_top.png') }}">
				</li>
				<li class="prot_img_single">
					<img src="{{ url('fx/img/detai_top.png') }}">
				</li>
			</ul>
		</div>
		<div class="productDetail_bottom">
			<ul class="productDetail_bottom_container">
				<li class="service_staff_container myCollection">
					<img src="{{ url('fx/img/service_staff.png') }}">
					<p>客服</p>
				</li>
				<li class="myCollection">
					<img src="{{ url('fx/img/start.png') }}">
					<p>收藏</p>
				</li>
				<li class="putIn_shopping_cart productDetail_bottom_item">
					加入购物车
				</li>
				<li class="buy_now productDetail_bottom_item">
					立即购买
				</li>
			</ul>
		</div>
	</div> -->
@endsection
