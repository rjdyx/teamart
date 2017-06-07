@extends('layouts.app')

@section('title') 商品搜索 @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/css/catelog.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/css/productList.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('fx/css/dropload.css') }}">
@endsection

@section('script')
    @parent
    <script type="text/javascript" src="{{ url('fx/common/dropload.js') }}"></script>
	<script type="text/javascript" src="{{ url('fx/js/productList.js') }}"></script>
	<script type="text/javascript" src="{{ url('fx/js/goToUrl.js') }}"></script>
@endsection

@section('content')
 	@include("layouts.header")
	<div class="container">
		<!-- 导航条 -->
		<div class="nav">
			<ul class="nav_container">
				<li class="nav_item">
					<span>销量</span>
					<img class="down_arrow" src="{{url('fx/img/down_arrow.png')}}">
				</li>
				<li class="nav_item">
					<span>价格</span>
					<img class="down_arrow" src="{{url('fx/img/down_arrow.png')}}">
				</li>
				<li class="nav_item">
					<span>时间</span>
					<img class="down_arrow" src="{{url('fx/img/down_arrow.png')}}">
				</li>
				<li class="nav_item">
					<span>筛选</span>
					<img class="filter" src="{{url('fx/img/filter.png')}}">
				</li>
			</ul>
		</div>
		<!-- 产品展示 -->
		<div class="products_list">
			<ul class="lists">
				<li class="products_detail">
					<a href="##" class="products_detail_a">
						<div class="products_detail_img">
							<img src="{{url('fx/img/shop11.png')}}">
						</div>
						<div class="products_detail_content">
							<h3 class="products_name">菲律宾进口香蕉</h3>
							<p class="detail_description">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
							<p class="price">￥12.0</p>
						</div>
					</a>
				</li>
				<li class="products_detail">
					<a href="##" class="products_detail_a">
						<div class="products_detail_img">
							<img src="{{url('fx/img/shop_photo1.png')}}">
						</div>
						<div class="products_detail_content">
							<h3 class="products_name">菲律宾进口香蕉</h3>
							<p class="detail_description">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
							<p class="price">￥12.0</p>
						</div>
					</a>
				</li>
				<li class="products_detail">
					<a href="##" class="products_detail_a">
						<div class="products_detail_img">
							<img src="{{url('fx/img/shop11.png')}}">
						</div>
						<div class="products_detail_content">
							<h3 class="products_name">菲律宾进口香蕉</h3>
							<p class="detail_description">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
							<p class="price">￥12.0</p>
						</div>
					</a>
				</li>
				<li class="products_detail">
					<a href="##" class="products_detail_a">
						<div class="products_detail_img">
							<img src="{{url('fx/img/shop_photo1.png')}}">
						</div>
						<div class="products_detail_content">
							<h3 class="products_name">菲律宾进口香蕉</h3>
							<p class="detail_description">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
							<p class="price">￥12.0</p>
						</div>
					</a>
				</li>
				<li class="products_detail">
					<a href="##" class="products_detail_a">
						<div class="products_detail_img">
							<img src="{{url('fx/img/shop11.png')}}">
						</div>
						<div class="products_detail_content">
							<h3 class="products_name">菲律宾进口香蕉</h3>
							<p class="detail_description">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
							<p class="price">￥12.0</p>
						</div>
					</a>
				</li>
				<li class="products_detail">
					<a href="##" class="products_detail_a">
						<div class="products_detail_img">
							<img src="{{url('fx/img/shop_photo1.png')}}">
						</div>
						<div class="products_detail_content">
							<h3 class="products_name">菲律宾进口香蕉</h3>
							<p class="detail_description">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
							<p class="price">￥12.0</p>
						</div>
					</a>
				</li>
			</ul>
		</div>
	</div>
    @include("layouts.footer")
@endsection
