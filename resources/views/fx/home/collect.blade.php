@extends('layouts.app')

@section('title') 我的收藏 @endsection

@section('css')
@endsection

@section('script')
	@parent
@endsection

@section('content')

	@include("layouts.header-info")

	<div class="container collect">
		<div class="collect_container">
			<div class="collect_warpper mb-20">
				<div class="collect_warpper_tit">
					<a href="javascript:;" class="chayefont">
						<i class="fa fa-ban"></i>
						绿茶宝塔镇河妖
					</a>
				</div>
				<div class="collect_warpper_content clearfix">
					<div class="collect_warpper_content_img pull-left mr-20">
						<img src="{{ url('fx/img/shop11.png') }}">
					</div>
					<div class="collect_warpper_content_info pull-right">
						<h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
						<p>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
						<div class="collect_warpper_content_info_bottom">
							<span class="pull-left price">￥212.00</span>
							<span class="pull-right sell">已售197</span>
						</div>
					</div>
				</div>
			</div>
			<div class="collect_warpper mb-20">
				<div class="collect_warpper_tit">
					<a href="javascript:;" class="chayefont">
						<i class="fa fa-ban"></i>
						绿茶宝塔镇河妖
					</a>
				</div>
				<div class="collect_warpper_content clearfix">
					<div class="collect_warpper_content_img pull-left mr-20">
						<img src="{{ url('fx/img/shop11.png') }}">
					</div>
					<div class="collect_warpper_content_info pull-right">
						<h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
						<p>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
						<div class="collect_warpper_content_info_bottom">
							<span class="pull-left price">￥212.00</span>
							<span class="pull-right sell">已售197</span>
						</div>
					</div>
				</div>
			</div>
			<div class="collect_warpper mb-20">
				<div class="collect_warpper_tit">
					<a href="javascript:;" class="chayefont">
						<i class="fa fa-ban"></i>
						绿茶宝塔镇河妖
					</a>
				</div>
				<div class="collect_warpper_content clearfix">
					<div class="collect_warpper_content_img pull-left mr-20">
						<img src="{{ url('fx/img/shop11.png') }}">
					</div>
					<div class="collect_warpper_content_info pull-right">
						<h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
						<p>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
						<div class="collect_warpper_content_info_bottom">
							<span class="pull-left price">￥212.00</span>
							<span class="pull-right sell">已售197</span>
						</div>
					</div>
				</div>
			</div>
			<div class="collect_warpper mb-20">
				<div class="collect_warpper_tit">
					<a href="javascript:;" class="chayefont">
						<i class="fa fa-ban"></i>
						绿茶宝塔镇河妖
					</a>
				</div>
				<div class="collect_warpper_content clearfix">
					<div class="collect_warpper_content_img pull-left mr-20">
						<img src="{{ url('fx/img/shop11.png') }}">
					</div>
					<div class="collect_warpper_content_info pull-right">
						<h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
						<p>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
						<div class="collect_warpper_content_info_bottom">
							<span class="pull-left price">￥212.00</span>
							<span class="pull-right sell">已售197</span>
						</div>
					</div>
				</div>
			</div>
			<div class="collect_warpper mb-20">
				<div class="collect_warpper_tit">
					<a href="javascript:;" class="chayefont">
						<i class="fa fa-ban"></i>
						绿茶宝塔镇河妖
					</a>
				</div>
				<div class="collect_warpper_content clearfix">
					<div class="collect_warpper_content_img pull-left mr-20">
						<img src="{{ url('fx/img/shop11.png') }}">
					</div>
					<div class="collect_warpper_content_info pull-right">
						<h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
						<p>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
						<div class="collect_warpper_content_info_bottom">
							<span class="pull-left price">￥212.00</span>
							<span class="pull-right sell">已售197</span>
						</div>
					</div>
				</div>
			</div>
			<div class="collect_warpper mb-20">
				<div class="collect_warpper_tit">
					<a href="javascript:;" class="chayefont">
						<i class="fa fa-ban"></i>
						绿茶宝塔镇河妖
					</a>
				</div>
				<div class="collect_warpper_content clearfix">
					<div class="collect_warpper_content_img pull-left mr-20">
						<img src="{{ url('fx/img/shop11.png') }}">
					</div>
					<div class="collect_warpper_content_info pull-right">
						<h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
						<p>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
						<div class="collect_warpper_content_info_bottom">
							<span class="pull-left price">￥212.00</span>
							<span class="pull-right sell">已售197</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="collect_bottom">
			<div class="block pull-left txt-l collect_bottom_selection">
				<span>全选</span>
			</div>
			<div class="block pull-left txt-c collect_bottom_del">删除</div>
		</div>
	</div>
	<!-- 我的收藏列表 -->
	<!-- <div class="container">
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
	</div> -->
	<!-- 底部 -->
@endsection
