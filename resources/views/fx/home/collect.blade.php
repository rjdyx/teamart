@extends('layouts.app')

@section('title') 我的收藏 @endsection

@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('fx/css/dropload.css') }}">
@endsection

@section('script')
	@parent
	<script type="text/javascript" src="{{ url('fx/common/dropload.js') }}"></script>
    <script>
        var page = 0;
        var size = 10;
        $('.collect_container').dropload({
            scrollArea : $('.collect_container'),
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
    </script>
@endsection

@section('content')

	@include("layouts.header-info")

	<div class="container collect">
		<div class="collect_container">
			<div class="collect_list">
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
