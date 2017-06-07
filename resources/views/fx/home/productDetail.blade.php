@extends('layouts.app')

@section('title') 商品详情 @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/css/productDetail.css') }}">
@endsection

@section('script')
    @parent
	<script type="text/javascript" src="{{ url('fx/js/productDetail.js') }}"></script>
@endsection

@section('content')
	<div class="container">
		<!-- 轮播图 -->
		<div class="myFocus">
			<div class="slide_content" id="slide_content">
		        <img class="slide_item" src="{{ url('fx/img/detail.png') }}" alt="1"/>
		        <img class="slide_item" src="{{ url('fx/img/detail.png') }}" alt="2"/>
		        <img class="slide_item" src="{{ url('fx/img/detail.png') }}" alt="3"/>
			</div>
		</div>
		<!-- 商品详情介绍 -->
		<div class="production_description">
			<h3 class="prot_name">云南凤庆功夫金芽红茶</h3>
			<p class="prot_whole_name">新鲜梨酥雪梨发货供货的供货皇烦得很冠分隔符梨</p>
			<p class="new_price">￥<span>12.0</span></p>
			<p class="old_price">价格&nbsp;:&nbsp;<span>￥25</span></p>
			<p class="postage_sales"><span class="postage">快递&nbsp;:&nbsp;0.00</span><span class="sales_volume">月销&nbsp;:&nbsp;520笔</span></p>
		</div>
		<!-- 按钮 -->
		<div class="container_btn_box">
			<div class="detail_btn">&nbsp;&nbsp;商品详情</div>
			<div class="comment_btn">&nbsp;&nbsp;评价&nbsp;&nbsp;100</div>
		</div>
		<!-- 商品证书 -->
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
		<!-- 图片介绍 -->
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
		<!-- 底部 -->
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
	</div>
    @include("layouts.footer")
@endsection
