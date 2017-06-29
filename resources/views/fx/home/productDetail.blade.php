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
			loadUpFn : function(me){
				getListData(me,'up');
			},
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
			var result = '';
			var url = 'http://'+window.location.host + '/home/product/comment';
			axios.get(url, {params:params}).then(function (res) {
            	var data = res.data
				var arrLen = data.length;
				// 拼接HTML
				if(arrLen > 0){
					for(var i=0; i<arrLen; i++){
						//评论部分
						result +=  '<div class="product_warpper pull-left">';
						if (data[i]['img'] !== null) {
							var imgs = data[i]['img'].split(",");
							for(var j=0;j<imgs.length;j++){
								result += '<img src=http://' + window.location.host + '/' +imgs[j] + '>';
							}
						}
						result += '<p class="mt-10 mb-10">' + data[i]['content']+'</p>';
						//评论回复部分
						if (data[i]['replys'].length > 0) {
							for(var v; v<data[i]['replys'].length; v++) {
								result += '<p class="mt-10 mb-10">' + data[i]['replys'][v]['content']+'</p>';
							}
						}
						result += '</div>';
					}
				}else{
					// 如果没有数据 锁定
					me.lock();
					// 无数据
					me.noData();
				}
				$('.productdetail_container_comment').append(result);// 插入数据到页面，放到最后面
				me.resetload();// 每次数据插入，必须重置
				if (type == 'up') {
					page = 0;// 重置页数，重新获取loadDownFn的数据
					// 解锁loadDownFn里锁定的情况
					me.unlock();
					me.noData(false);
				}
            }).catch(function (err) {
                console.log(err)
				me.resetload();// 即使加载出错，也得重置
            });
		}
	});
    </script>
@endsection

@section('content')
	@include("layouts.header-info")
	<div class="container productdetail">
		<div class="productdetail_container">
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
				<p>
					<span>规格：</span>
					@foreach($specs as $spec)
					<a href="{{url('/home/product/detail')}}/{{$spec->id}}" @if($content->id == $spec->id) class="active" @endif >{{$spec->name}}</a>
					@endforeach
				</p>
			</div>
			<div class="productdetail_container_tabs">
				<a href="javascript:;" class="J_tabs pull-left chayefont active" data-tag="detail">商品详情</a>
				<a href="javascript:;" class="J_tabs pull-left chayefont" data-tag="comment">评价<span>1000</span></a>
			</div>
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
@endsection
