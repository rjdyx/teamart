@extends('layouts.app')

@section('title') 商品搜索 @endsection

@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('fx/css/dropload.css') }}">
@endsection

@section('script')
	@parent
	<script type="text/javascript" src="{{ url('fx/common/dropload.js') }}"></script>
	<script>
		$(function () {
			$('.J_show_filter').on('click', function () {
				$('.filter').addClass('left-0')
			})
			$('.J_hide_filter').on('click', function () {
				$('.filter').removeClass('left-0')
			})
			var page = 0;
			var size = 10;
			$('.product_container').dropload({
				scrollArea : $('.product_container'),
				domUp : {
					domClass   : 'dropload-up',
					domRefresh : '<div class="dropload-refresh">↓下拉刷新</div>',
					domUpdate  : '<div class="dropload-update">↑释放更新</div>',
					domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中...</div>'
				},
				domDown : {
					domClass   : 'dropload-down',
					domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
					domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
					domNoData  : '<div class="dropload-noData">没有更多数据了</div>'
				},
				loadUpFn : function(me){
					$.ajax({
						type: 'GET',
						url: 'json/update.json',
						dataType: 'json',
						success: function(data){
							var result = '';
							for(var i = 0; i < data.lists.length; i++){
								result +=   '<a class="item opacity" href="'+data.lists[i].link+'">'
												+'<img src="'+data.lists[i].pic+'" alt="">'
												+'<h3>'+data.lists[i].title+'</h3>'
												+'<span class="date">'+data.lists[i].date+'</span>'
											+'</a>';
							}
							// 为了测试，延迟1秒加载
							setTimeout(function(){
								$('.lists').html(result);
								// 每次数据加载完，必须重置
								me.resetload();
								// 重置页数，重新获取loadDownFn的数据
								page = 0;
								// 解锁loadDownFn里锁定的情况
								me.unlock();
								me.noData(false);
							},1000);
						},
						error: function(xhr, type){
							alert('Ajax error!');
							// 即使加载出错，也得重置
							me.resetload();
						}
					});
				},
				loadDownFn : function(me){
					page++;
					// 拼接HTML
					var result = '';
					$.ajax({
						type: 'GET',
						url: 'http://ons.me/tools/dropload/json.php?page='+page+'&size='+size,
						dataType: 'json',
						success: function(data){
							var arrLen = data.length;
							if(arrLen > 0){
								for(var i=0; i<arrLen; i++){
									result +=   '<a class="item opacity" href="'+data[i].link+'">'
													+'<img src="'+data[i].pic+'" alt="">'
													+'<h3>'+data[i].title+'</h3>'
													+'<span class="date">'+data[i].date+'</span>'
												+'</a>';
								}
							// 如果没有数据
							}else{
								// 锁定
								me.lock();
								// 无数据
								me.noData();
							}
							// 为了测试，延迟1秒加载
							setTimeout(function(){
								// 插入数据到页面，放到最后面
								$('.lists').append(result);
								// 每次数据插入，必须重置
								me.resetload();
							},1000);
						},
						error: function(xhr, type){
							alert('Ajax error!');
							// 即使加载出错，也得重置
							me.resetload();
						}
					});
				},
				threshold : 50
			});
		})
	</script>
@endsection

@section('content')
	@include("layouts.header")
	<div class="filter">
		<div class="filter_bg J_hide_filter"></div>
		<div class="filter_container">
			<div class="filter_price mb-20">
				<span>价格区间</span>
				<div class="filter_price_box mt-20 clearfix">
					<input type="number" name="min_price" class="pull-left" placeholder="最低价">
					<i class="fa fa-minus pull-left"></i>
					<input type="number" name="max_price" class="pull-left" placeholder="最高价">
				</div>
			</div>
			<div class="filter_category mb-20">
				<div class="filter_category_top">
					<span class="pull-left">全部分类</span>
					<a href="javascript:;" class="pull-right">
						全部
						<i class="fa fa-angle-right"></i>
					</a>
				</div>
				<ul class="filter_category_list hide">
					<li class="active">
						<a href="javascript:;">分类1</a>
					</li>
					<li>
						<a href="javascript:;">分类1</a>
					</li>
					<li>
						<a href="javascript:;">分类1</a>
					</li>
					<li>
						<a href="javascript:;">分类1</a>
					</li>
					<li>
						<a href="javascript:;">分类1</a>
					</li>
					<li>
						<a href="javascript:;">分类1</a>
					</li>
					<li>
						<a href="javascript:;">分类1</a>
					</li>
					<li>
						<a href="javascript:;">分类1</a>
					</li>
				</ul>
			</div>
			<div class="filter_brand">
				<div class="filter_brand_top">
					<span class="pull-left">品牌</span>
					<a href="javascript:;" class="pull-right">
						全部
						<i class="fa fa-angle-right active"></i>
					</a>
				</div>
				<ul class="filter_brand_list">
					<li class="active">
						<a href="javascript:;">分类1</a>
					</li>
					<li>
						<a href="javascript:;">分类1</a>
					</li>
					<li>
						<a href="javascript:;">分类1</a>
					</li>
					<li>
						<a href="javascript:;">分类1</a>
					</li>
					<li>
						<a href="javascript:;">分类1</a>
					</li>
					<li>
						<a href="javascript:;">分类1</a>
					</li>
					<li>
						<a href="javascript:;">分类1</a>
					</li>
					<li>
						<a href="javascript:;">分类1</a>
					</li>
				</ul>
			</div>
			<div class="filter_opts">
				<span class="filter_opts_btn pull-left reset">重置</span>
				<span class="filter_opts_btn pull-left del">确定</span>
			</div>
		</div>
	</div>
	<div class="container product">
		<ul class="product_nav">
			<li>
				综合
				<i class="fa fa-caret-down"></i>
			</li>
			<li>
				销量
				<i class="fa fa-caret-down"></i>
			</li>
			<li>
				价格
				<i class="fa fa-caret-down"></i>
			</li>
			<li class="J_show_filter">
				筛选
				<i class="fa fa-filter"></i>
			</li>
		</ul>
		<div class="product_container">
			<div class="product_list clearfix">
				<div class="product_warpper pull-left">
					<a href="{{url('home/product/detail/1')}}">
						<img src="{{url('fx/img/shop11.png')}}">
						<h1 class="mt-20 chayefont">菲律宾进口香蕉</h1>
						<p class="mt-10 mb-10">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
						<p class="clearfix">
							<span class="pull-left price">&yen12.00</span>
							<span class="pull-right sell">销量：<i>9999</i></span>
						</p>
					</a>
				</div>
				<div class="product_warpper pull-left">
					<a href="{{url('home/product/detail/1')}}">
						<img src="{{url('fx/img/shop11.png')}}">
						<h1 class="mt-20 chayefont">菲律宾进口香蕉</h1>
						<p class="mt-10 mb-10">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
						<p class="clearfix">
							<span class="pull-left price">&yen12.00</span>
							<span class="pull-right sell">销量：<i>9999</i></span>
						</p>
					</a>
				</div>
				<div class="product_warpper pull-left">
					<a href="{{url('home/product/detail/1')}}">
						<img src="{{url('fx/img/shop11.png')}}">
						<h1 class="mt-20 chayefont">菲律宾进口香蕉</h1>
						<p class="mt-10 mb-10">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
						<p class="clearfix">
							<span class="pull-left price">&yen12.00</span>
							<span class="pull-right sell">销量：<i>9999</i></span>
						</p>
					</a>
				</div>
				<div class="product_warpper pull-left">
					<a href="{{url('home/product/detail/1')}}">
						<img src="{{url('fx/img/shop11.png')}}">
						<h1 class="mt-20 chayefont">菲律宾进口香蕉</h1>
						<p class="mt-10 mb-10">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
						<p class="clearfix">
							<span class="pull-left price">&yen12.00</span>
							<span class="pull-right sell">销量：<i>9999</i></span>
						</p>
					</a>
				</div>
				<div class="product_warpper pull-left">
					<a href="{{url('home/product/detail/1')}}">
						<img src="{{url('fx/img/shop11.png')}}">
						<h1 class="mt-20 chayefont">菲律宾进口香蕉</h1>
						<p class="mt-10 mb-10">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
						<p class="clearfix">
							<span class="pull-left price">&yen12.00</span>
							<span class="pull-right sell">销量：<i>9999</i></span>
						</p>
					</a>
				</div>
				<div class="product_warpper pull-left">
					<a href="{{url('home/product/detail/1')}}">
						<img src="{{url('fx/img/shop11.png')}}">
						<h1 class="mt-20 chayefont">菲律宾进口香蕉</h1>
						<p class="mt-10 mb-10">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
						<p class="clearfix">
							<span class="pull-left price">&yen12.00</span>
							<span class="pull-right sell">销量：<i>9999</i></span>
						</p>
					</a>
				</div>
				<div class="product_warpper pull-left">
					<a href="{{url('home/product/detail/1')}}">
						<img src="{{url('fx/img/shop11.png')}}">
						<h1 class="mt-20 chayefont">菲律宾进口香蕉</h1>
						<p class="mt-10 mb-10">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
						<p class="clearfix">
							<span class="pull-left price">&yen12.00</span>
							<span class="pull-right sell">销量：<i>9999</i></span>
						</p>
					</a>
				</div>
				<div class="product_warpper pull-left">
					<a href="{{url('home/product/detail/1')}}">
						<img src="{{url('fx/img/shop11.png')}}">
						<h1 class="mt-20 chayefont">菲律宾进口香蕉</h1>
						<p class="mt-10 mb-10">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
						<p class="clearfix">
							<span class="pull-left price">&yen12.00</span>
							<span class="pull-right sell">销量：<i>9999</i></span>
						</p>
					</a>
				</div>
			</div>
		</div>
	</div>
	@include("layouts.footer")
@endsection
