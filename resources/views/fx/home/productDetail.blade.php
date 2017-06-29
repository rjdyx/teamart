@extends('layouts.app')

@section('title') 商品详情 @endsection

@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('fx/css/dropload.css') }}">

@endsection

@section('script')
    @parent
    <script type="text/javascript" src="{{ url('fx/common/dropload.js') }}"></script>
    <script>
    $(function(){
		var page = 0;//分页
		var params = {id:'',page:0};//定义全局对象
		params['id'] = {{ $content->id }};

		$('.productdetail_container_comment').dropload({
			scrollArea : $('.productdetail_container_comment'),
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
			// loadUpFn : function(me){
			// 	getListData(me,'up');
			// },
			loadDownFn : function(me){
				getListData(me,'down');
			},
			threshold : 50
		});

		//获取列表数据
		function getListData(me,type) {
			if (type=='down')
			{
				page++;
				params['page'] = page;
			}
			ajax('get', '/home/product/comment', {page: page}, false, false, false)
                    .then(function (res) {
                        var template = ''
                        if (res.length > 0) {
                            res.forEach(function (v) {
                                template += `
                                    <li class="clearfix">
										<div class="comment_list_avatar pull-left">
											<img src="{{url('/fx/images/usercenter_avatar.png')}}" alt="">
											<span>哈哈哈哈</span>
										</div>
										<div class="comment_list_content pull-right">
											<p class="stars">
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
											</p>
											<p class="fz-12 mt-10 mb-10">哈哈哈哈哈哈哈哈哈哈哈哈,哈哈哈哈哈哈哈哈哈哈哈哈,哈哈哈哈哈哈哈哈,哈哈哈哈哈哈哈哈</p>
											<div class="comment_list_content_img clearfix">
												<img class="pull-left mr-10" src="{{url('/fx/images/user_info_bg.png')}}" alt="">
												<img class="pull-left mr-10" src="{{url('/fx/images/user_info_bg.png')}}" alt="">
												<img class="pull-left mr-10" src="{{url('/fx/images/user_info_bg.png')}}" alt="">
											</div>
											<p class="txt-r mt-10">0000年00月00日 00:00</p>
										</div>
									</li>
                                `
                            })
                        } else {
                            me.lock();
                            me.noData();
                        }
                        $('.comment_list').append(template);
                        me.resetload();
                    })
                    .catch(function (err) {
                        prompt.message('请求错误')
                        me.resetload()
                    })
		}
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
    	});
    	$('.J_favo').on('click tap', function () {
    		var $this = $(this)
    		if ($this.find('i').hasClass('fa-star-o')) {
    			ajax('get', '/home/collect/create/', {id: params['id']})
	    			.then(function (resolve) {
	    				if (resolve) {
	    					$this.find('i').removeClass('fa-star-o').addClass('fa-star')
	    					prompt.message('收藏成功')
	    				} else {
	    					prompt.message('收藏失败')
	    				}
	    			})
    		} else {
    			ajax('delete', '/home/collect/' + params['id'])
	    			.then(function (resolve) {
	    				if (resolve) {
	    					$this.find('i').addClass('fa-star-o').removeClass('fa-star')
	    					prompt.message('取消收藏成功')
	    				} else {
	    					prompt.message('取消收藏失败')
	    				}
	    			})
    		}
    	})
    	$('.J_join_cart').on('click tap', function () {
    		ajax('get', '/home/cart/create/' + params['id'])
    			.then(function (resolve) {
    				if (resolve) {
    					prompt.message('已经加入购物车')
    				} else {
    					prompt.message('加入失败')
    				}
    			})
    	})

    	var tab_offset_top = $('.productdetail_container_tabs').offset().top
    	$('.J_scroll').scroll(function () {
    		if ($(this).scrollTop() > tab_offset_top - $('header').height()) {
    			$('.productdetail_container_tabs').addClass('fixed')
    			$('.productdetail_blank').removeClass('hide')
    		} else {
    			$('.productdetail_container_tabs').removeClass('fixed')
    			$('.productdetail_blank').addClass('hide')
    		}
    	})
	})
    </script>
@endsection

@section('content')
	@include("layouts.header-info")
	<div class="container productdetail">
		<div class="productdetail_container J_scroll">
			<div class="productdetail_container_banner swiper-container">
			    <div class="swiper-wrapper">
			        @foreach($imgs as $img)
			        <div class="swiper-slide">
			        	<img src="{{url('')}}/{{$img->img}}" alt="">
			        </div>
			        @endforeach
			    </div>
			    <div class="swiper-pagination"></div>
			</div>
			<div class="productdetail_container_info">
				<h1 class="chayefont">{{$content->name}}</h1>
				<p class="desc mt-10 mb-10">{{$content->desc}}</p>
				<span class="price">&yen{{sprintf('%.2f', $content->price)}}</span>
				<p class="mt-10 mb-10">价格：<del>{{sprintf('%.2f', $content->raw_price)}}</del></p>
				<p class="clearfix">
					<span class="pull-left">快递：<i>{{sprintf('%.2f', $content->delivery_price)}}</i></span>
					<span class="pull-right">销量：<i>{{$content->sell_amount}}</i>笔</span>
				</p>
				<div class="productdetail_container_info_spec">
					<span>规格：</span>
					<ul class="clearfix">
						@foreach($specs as $spec)
						<li class="pull-left mr-10 mb-10">
							<a href="{{url('/home/product/detail')}}/{{$spec->id}}" @if($content->id == $spec->id) class="active" @endif >{{$spec->name}}</a>
						</li>
						@endforeach
					</ul>
				</div>
			</div>
			<div class="productdetail_container_tabs">
				<a href="javascript:;" class="J_tabs pull-left chayefont active" data-tag="detail">商品详情</a>
				<a href="javascript:;" class="J_tabs pull-left chayefont" data-tag="comment">评价<span>1000</span></a>
			</div>
			<div class="hide productdetail_blank"></div>
			<div class="productdetail_container_detail" data-tab="detail">
				<div class="productdetail_container_detail_info clearfix">
					<ol class="pull-left">
						<li>生产日期: {{$content->date}}</li>
						<li>产地: {{$content->origin}}</li>
						<li>作用: {{$content->effect}}</li>
					</ol>
				</div>
				<div class="productdetail_container_detail_img">
					{!! html_entity_decode($content->gdesc) !!}
				</div>
			</div>
			<div class="productdetail_container_comment hide" data-tab="comment">
				<!-- 评价区域 -->
				<ol class="comment_filter clearfix">
					<li class="pull-left mr-10 mb-10">
						<a href="javascript:;">
							好评(<span>99</span>)
						</a>
					</li>
					<li class="pull-left mr-10 mb-10">
						<a href="javascript:;">
							好评(<span>99</span>)
						</a>
					</li>
					<li class="pull-left mr-10 mb-10">
						<a href="javascript:;">
							好评(<span>99</span>)
						</a>
					</li>
				</ol>
				<ul class="comment_list">
					<li class="clearfix">
						<div class="comment_list_avatar pull-left">
							<img src="{{url('/fx/images/usercenter_avatar.png')}}" alt="">
							<span>哈哈哈哈</span>
						</div>
						<div class="comment_list_content pull-right">
							<p class="stars">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</p>
							<p class="fz-12">哈哈哈哈哈哈哈哈哈哈哈哈,哈哈哈哈哈哈哈哈哈哈哈哈,哈哈哈哈哈哈哈哈,哈哈哈哈哈哈哈哈</p>
							<div class="comment_list_content_img clearfix">
								<img class="pull-left mr-10" src="{{url('/fx/images/user_info_bg.png')}}" alt="">
								<img class="pull-left mr-10" src="{{url('/fx/images/user_info_bg.png')}}" alt="">
								<img class="pull-left mr-10" src="{{url('/fx/images/user_info_bg.png')}}" alt="">
							</div>
							<p class="txt-r mt-10">0000年00月00日 00:00</p>
						</div>
					</li>
					<li class="clearfix">
						<div class="comment_list_avatar pull-left">
							<img src="{{url('/fx/images/usercenter_avatar.png')}}" alt="">
							<span>哈哈哈哈</span>
						</div>
						<div class="comment_list_content pull-right">
							<p class="stars">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</p>
							<p class="fz-12 mt-10 mb-10">哈哈哈哈哈哈哈哈哈哈哈哈,哈哈哈哈哈哈哈哈哈哈哈哈,哈哈哈哈哈哈哈哈,哈哈哈哈哈哈哈哈</p>
							<div class="comment_list_content_img clearfix">
								<img class="pull-left mr-10" src="{{url('/fx/images/user_info_bg.png')}}" alt="">
								<img class="pull-left mr-10" src="{{url('/fx/images/user_info_bg.png')}}" alt="">
								<img class="pull-left mr-10" src="{{url('/fx/images/user_info_bg.png')}}" alt="">
							</div>
							<p class="txt-r mt-10">0000年00月00日 00:00</p>
						</div>
					</li>
					<li class="clearfix">
						<div class="comment_list_avatar pull-left">
							<img src="{{url('/fx/images/usercenter_avatar.png')}}" alt="">
							<span>哈哈哈哈</span>
						</div>
						<div class="comment_list_content pull-right">
							<p class="stars">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</p>
							<p class="fz-12">哈哈哈哈哈哈哈哈哈哈哈哈,哈哈哈</p>
							<div class="comment_list_content_img clearfix">
								<img class="pull-left mr-10" src="{{url('/fx/images/user_info_bg.png')}}" alt="">
								<img class="pull-left mr-10" src="{{url('/fx/images/user_info_bg.png')}}" alt="">
								<img class="pull-left mr-10" src="{{url('/fx/images/user_info_bg.png')}}" alt="">
							</div>
							<p class="txt-r mt-10">0000年00月00日 00:00</p>
						</div>
					</li>
					<li class="clearfix">
						<div class="comment_list_avatar pull-left">
							<img src="{{url('/fx/images/usercenter_avatar.png')}}" alt="">
							<span>哈哈哈哈</span>
						</div>
						<div class="comment_list_content pull-right">
							<p class="stars">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</p>
							<p class="fz-12">哈哈哈哈哈哈哈哈哈哈哈哈,哈哈哈哈哈哈哈哈</p>
							<div class="comment_list_content_img clearfix">
								<img class="pull-left mr-10" src="{{url('/fx/images/user_info_bg.png')}}" alt="">
								<img class="pull-left mr-10" src="{{url('/fx/images/user_info_bg.png')}}" alt="">
								<img class="pull-left mr-10" src="{{url('/fx/images/user_info_bg.png')}}" alt="">
							</div>
							<p class="txt-r mt-10">0000年00月00日 00:00</p>
						</div>
					</li>
					<li class="clearfix">
						<div class="comment_list_avatar pull-left">
							<img src="{{url('/fx/images/usercenter_avatar.png')}}" alt="">
							<span>哈哈哈哈</span>
						</div>
						<div class="comment_list_content pull-right">
							<p class="stars">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</p>
							<p class="fz-12">哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈</p>
							<div class="comment_list_content_img clearfix">
								<img class="pull-left mr-10" src="{{url('/fx/images/user_info_bg.png')}}" alt="">
								<img class="pull-left mr-10" src="{{url('/fx/images/user_info_bg.png')}}" alt="">
								<img class="pull-left mr-10" src="{{url('/fx/images/user_info_bg.png')}}" alt="">
							</div>
							<p class="txt-r mt-10">0000年00月00日 00:00</p>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div class="productdetail_bottom">
			<div class="productdetail_bottom_icon pull-left kefu">
				<i class="fa fa-headphones mt-10"></i>
				<p>客服</p>
			</div>
			<div class="productdetail_bottom_icon pull-left favo J_favo">
				<i class="fa fa-star-o mt-10"></i>
				<p>收藏</p>
			</div>
			<div class="productdetail_bottom_btn pull-left chayefont add_cart J_join_cart">
				加入购物车
			</div>
			<div class="productdetail_bottom_btn pull-left chayefont buy_now">
				立即购买
			</div>
		</div>
	</div>
@endsection
