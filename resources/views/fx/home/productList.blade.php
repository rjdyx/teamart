@extends('layouts.app')

@section('title') 商品搜索 @endsection

@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('fx/css/dropload.css') }}">
@endsection

@section('script')
    @parent
    {{-- <script type="text/javascript" src="{{ url('fx/common/dropload.js') }}"></script>
	<script>
		var myLoadUp = {
				loadUpFnContainer:function(){
					var counter = 0;
				    // 每页展示4个
				    var num = 4;
				    var pageStart = 0,pageEnd = 0;

				    // dropload
				    $('.products_list').dropload({
				        scrollArea : window,
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
			                var result = '';
			                for(var i = 0; i < 6; i++){
			                    result +=   "<li class='products_detail opacity'>"
											+"<a href='##'' class='products_detail_a'>"
												+"<div class='products_detail_img'>"
													+"<img src='../img/shop11.png'>"
												+"</div>"
												+"<div class='products_detail_content'>"
													+"<h3 class='products_name'>菲律宾进口香蕉</h3>"
													+"<p class='detail_description'>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>"
													+"<p class='price'>￥12.0</p>"
												+"</div>"
											+"</a>"
										+"</li>";
			                }
			                // 为了测试，延迟1秒加载
			                setTimeout(function(){
			                    $('.lists').prepend(result);
			                    // 每次数据加载完，必须重置
			                    me.resetload();
			                    // 重置索引值，重新拼接more.json数据
			                    counter = 0;
			                    // 解锁
			                    me.unlock();
			                    me.noData(false);
			                },1000);
				        },
				        loadDownFn : function(me){
			                var result = '';
			                counter++;
			                pageEnd = num * counter;
			                pageStart = pageEnd - num;

			                for(var i = pageStart; i < pageEnd; i++){
			                    result +=   "<li class='products_detail opacity'>"
											+"<a href='##'' class='products_detail_a'>"
												+"<div class='products_detail_img'>"
													+"<img src='../img/shop11.png'>"
												+"</div>"
												+"<div class='products_detail_content'>"
													+"<h3 class='products_name'>菲律宾进口香蕉</h3>"
													+"<p class='detail_description'>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>"
													+"<p class='price'>￥12.0</p>"
												+"</div>"
											+"</a>"
										+"</li>";
			                    if((i + 1) >= 3){
			                        // 锁定
			                        me.lock();
			                        // 无数据
			                        me.noData();
			                        break;
			                    }
			                }
			                // 为了测试，延迟1秒加载
			                setTimeout(function(){
			                    $('.lists').append(result);
			                    // 每次数据加载完，必须重置
			                    me.resetload();
			                },1000);
				        },
				        threshold : 50
				    });
				}
			}
		$(function(){
			// 头部返回
			$(".header_turnBack").click(function(){
				window.history.back(-1);
			});
			//商品列表页跳转 
			$(".products_detail_a").prop("href","productDetail.html");
				console.log(window.location.href);
			myLoadUp.loadUpFnContainer();
		});
	</script> --}}
	<script>
		$(function () {
			$('.J_show_filter').on('click', function () {
				$('.filter').addClass('left-0')
			})
			$('.J_hide_filter').on('click', function () {
				$('.filter').removeClass('left-0')
			})
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
		<div class="product_container clearfix">
			<div class="product_warpper pull-left">
				<a href="{{url('home/product/detail/1')}}">
					<img src="{{url('fx/img/shop11.png')}}">
					<h1 class="mt-20 chayefont">菲律宾进口香蕉</h1>
					<p class="mt-10 mb-10">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
					<span class="price">&yen12.00</span>
				</a>
			</div>
			<div class="product_warpper pull-left">
				<a href="#">
					<img src="{{url('fx/img/shop11.png')}}">
					<h1 class="mt-20 chayefont">菲律宾进口香蕉</h1>
					<p class="mt-10 mb-10">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
					<span class="price">&yen12.00</span>
				</a>
			</div>
			<div class="product_warpper pull-left">
				<a href="#">
					<img src="{{url('fx/img/shop11.png')}}">
					<h1 class="mt-20 chayefont">菲律宾进口香蕉</h1>
					<p class="mt-10 mb-10">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
					<span class="price">&yen12.00</span>
				</a>
			</div>
			<div class="product_warpper pull-left">
				<a href="#">
					<img src="{{url('fx/img/shop11.png')}}">
					<h1 class="mt-20 chayefont">菲律宾进口香蕉</h1>
					<p class="mt-10 mb-10">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
					<span class="price">&yen12.00</span>
				</a>
			</div>
			<div class="product_warpper pull-left">
				<a href="#">
					<img src="{{url('fx/img/shop11.png')}}">
					<h1 class="mt-20 chayefont">菲律宾进口香蕉</h1>
					<p class="mt-10 mb-10">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
					<span class="price">&yen12.00</span>
				</a>
			</div>
			<div class="product_warpper pull-left">
				<a href="#">
					<img src="{{url('fx/img/shop11.png')}}">
					<h1 class="mt-20 chayefont">菲律宾进口香蕉</h1>
					<p class="mt-10 mb-10">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
					<span class="price">&yen12.00</span>
				</a>
			</div>
			<div class="product_warpper pull-left">
				<a href="#">
					<img src="{{url('fx/img/shop11.png')}}">
					<h1 class="mt-20 chayefont">菲律宾进口香蕉</h1>
					<p class="mt-10 mb-10">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
					<span class="price">&yen12.00</span>
				</a>
			</div>
			<div class="product_warpper pull-left">
				<a href="#">
					<img src="{{url('fx/img/shop11.png')}}">
					<h1 class="mt-20 chayefont">菲律宾进口香蕉</h1>
					<p class="mt-10 mb-10">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
					<span class="price">&yen12.00</span>
				</a>
			</div>
		</div>
 	</div>
    @include("layouts.footer")
@endsection
