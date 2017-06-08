@extends('layouts.app')

@section('title') 我的收藏 @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/css/collect.css') }}">
@endsection

@section('script')
    @parent
	<script type="text/javascript" src="{{ url('fx/js/collect.js') }}"></script>
@endsection

@section('content')

    @include("layouts.header-info")
	<!-- 我的收藏列表 -->
	<div class="container">
		<div class="products">
			<ul>
				<li class="products_list">
					<div class="products_nav">
						<div class="products_nav_left">
							<img class="products_nav_img" src="{{ url('fx/img/choose.png') }}">
							<img class="goods_nav_img" src="{{ url('fx/img/home_active.png') }}">
							<span class="products_nav_font">绿茶宝塔镇河妖</span>
						</div>
						<div class="products_nav_right">
							<span class="products_nav_font">编辑</span>
						</div>
					</div>
					<div class="products_details">
						<div class="products_details_left">
							<div class="products_details_img">
								<img src="{{ url('fx/img/shop11.png') }}">
							</div>
						</div>
						<div class="products_details_right">
							<h3 class="products_details_name">菲律宾进口香蕉</h3>
							<p class="products_details_description">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
							<div class="p">
								<p class="prices">￥212.00</p>
								<p class="sold">已售</p>
								<p class="sold_num">197</p>
							</div>
						</div>
					</div>
				</li>
				<li class="products_list">
					<div class="products_nav">
						<div class="products_nav_left">
							<img class="products_nav_img" src="{{ url('fx/img/choose.png') }}">
							<img class="goods_nav_img" src="{{ url('fx/img/home_active.png') }}">
							<span class="products_nav_font">绿茶宝塔镇河妖</span>
						</div>
						<div class="products_nav_right">
							<span class="products_nav_font">编辑</span>
						</div>
					</div>
					<div class="products_details">
						<div class="products_details_left">
							<div class="products_details_img">
								<img src="{{ url('fx/img/shop11.png') }}">
							</div>
						</div>
						<div class="products_details_right">
							<h3 class="products_details_name">菲律宾进口香蕉</h3>
							<p class="products_details_description">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
							<div class="p">
								<p class="prices">￥212.00</p>
								<p class="sold">已售</p>
								<p class="sold_num">197</p>
							</div>
						</div>
					</div>
				</li>
				<li class="products_list">
					<div class="products_nav">
						<div class="products_nav_left">
							<img class="products_nav_img" src="{{ url('fx/img/choose.png') }}">
							<img class="goods_nav_img" src="{{ url('fx/img/home_active.png') }}">
							<span class="products_nav_font">绿茶宝塔镇河妖</span>
						</div>
						<div class="products_nav_right">
							<span class="products_nav_font">编辑</span>
						</div>
					</div>
					<div class="products_details">
						<div class="products_details_left">
							<div class="products_details_img">
								<img src="{{ url('fx/img/shop11.png') }}">
							</div>
						</div>
						<div class="products_details_right">
							<h3 class="products_details_name">菲律宾进口香蕉</h3>
							<p class="products_details_description">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
							<div class="p">
								<p class="prices">￥212.00</p>
								<p class="sold">已售</p>
								<p class="sold_num">197</p>
							</div>
						</div>
					</div>
				</li>
				<li class="products_list">
					<div class="products_nav">
						<div class="products_nav_left">
							<img class="products_nav_img" src="{{ url('fx/img/choose.png') }}">
							<img class="goods_nav_img" src="{{ url('fx/img/home_active.png') }}">
							<span class="products_nav_font">绿茶宝塔镇河妖</span>
						</div>
						<div class="products_nav_right">
							<span class="products_nav_font">编辑</span>
						</div>
					</div>
					<div class="products_details">
						<div class="products_details_left">
							<div class="products_details_img">
								<img src="{{ url('fx/img/shop11.png') }}">
							</div>
						</div>
						<div class="products_details_right">
							<h3 class="products_details_name">菲律宾进口香蕉</h3>
							<p class="products_details_description">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
							<div class="p">
								<p class="prices">￥212.00</p>
								<p class="sold">已售</p>
								<p class="sold_num">197</p>
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<!-- 底部 -->
	<div class="bottom">
		<div class="bottom_left">
			<label class="bottom_img"></label>
			<p class="all_font">全选</p>
		</div>
		<div class="bottom_right">
			<p class="delete">删除</p>
		</div>
	</div>
@endsection
