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
		var params = {id:'', page:0, grade:''};//定义全局对象
    	var popid = '';
    	var poptype = 'cart';

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
			ajax('get', '/home/product/comment/'+params['id'], {page: page}, false, false, false)
                .then(function (res) {
                	var template = '';
                    if (res.length > 0) {
                    	template = listData(res);
                    } else {
                        me.lock();
                        me.noData();
                    }
                    $('.comment_list').append(template);
                    me.resetload();
                })
                .catch(function (err) {
                    prompt.message('请求错误')
                });
		}

		function listData(res){
			var template = '';
            res.forEach(function (data) {
                template += '<li class="clearfix">'+'<div class="comment_list_avatar pull-left">'+
					'<img src="'+'http://'+window.location.host+'/'+data['user_img']+'" alt="">'+
					'<span>'+data['user_name']+'</span>'+'</div>'+
					'<div class="comment_list_content pull-right">'+ '<p class="stars">';
					//评论星星
					for (var i=0;i<=data['grade']/20;i++)
					{
						template += '<i class="fa fa-star"></i>';
					}
				template += '</p>'+ '<p class="fz-12">'+data['content']+'</p>'+
					'<div class="comment_list_content_img clearfix">';
				//评论图片
				if (data['img']) {
					for(var j=0;j<data['img'].length;j++) {
						template += '<img class="pull-left mr-10" src="'+'http://'+window.location.host+'/'+data['thumb']+'" alt="">';
					}
				}
				template += '</div>';
				//评论回复
				if (data['replys']) {
					for(var j=0;j<data['replys'].length;j++) {
						template += '<p class="fz-12">' + data['replys'][j]['aname'] +'<b>回复</b>'+ data['replys'][j]['bname']+'['+data['replys'][j]['created_at']+']:</p>'+ 
							'<p class="fz-12">'+data['replys'][j]['content']+'</p>';					
					}
				}	
				template += '<p class="txt-r mt-10">'+data['created_at']+'</p>'+'</div>'+'</li>';
            });
            return template;
		}

		function searchComment() {
			params['page'] = 1;
			ajax('get', '/home/product/comment/'+params['id'], params, false, false, false)
                .then(function (res) {
                	var template = ''
                    if (res.length > 0) {
                    	template = listData(res);
                    }
                    $('.comment_list').html(template);
                }).catch(function (err) {
                	console.log(err)
                });
		}

		// 切换
		$('.J_tabs').on('click', function () {
    		$(this).addClass('active')
    		.siblings().removeClass('active')
    		var tag = $(this).data('tag')
    		$('[data-tab]').addClass('hide')
    		.each(function () {
    			if ($(this).data('tab') == tag) {
    				$(this).removeClass('hide')
    			}
    		});
    	});
    	// 收藏
    	$('.J_favo').on('click tap', function () {
    		var $this = $(this)
    		if ($this.find('i').hasClass('fa-star-o')) {
    			ajax('post', '/home/collect', {id: params['id']})
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
    	});

    	// 弹窗确定
    	$('.J_join_cart').on('click tap', function () {
    		if (poptype == 'cart') {
    			storeCart();
    		} else {
				storeBuy();
    		}
    	});

    	// 加入购物车
    	function storeCart() {
    		var num = $('.productspec_container_amount input').val();
    		var params = {id:popid, amount:num};
    		ajax('post', '/home/cart', params)
    			.then(function (resolve) {
    				if (resolve) {
    					prompt.message('已经加入购物车')
    				} else {
    					prompt.message('加入失败')
    				}
    			})
    	};

    	// 立即购买（待支付）
    	function storeBuy() {
    		var num = $('.productspec_container_amount input').val();
    		var params = {data:{2:3}};
    		params['data'][popid] = num;

    		var url = 'http://' + window.location.host + '/home/order/confirm?id=';
    		ajax('post', '/home/order/confirm', params)
    			.then(function (resolve) {
    				console.log(resolve)
    				if (resolve) {
    					window.location.href = url + resolve;	
    				} else {
    					prompt.message('服务器异常！请稍后再试！')
    				}
    			})
    	};

    	//点击加入购物车
    	$('.J_show_productspec').on('click tap', function () {
    		poptype = 'cart';
			cshPop();
    	});

    	//点击立即购买
    	$('.buy_now').on('click tap', function () {
    		poptype = 'buy';
			cshPop();
    	});

    	//初始化弹窗
    	function cshPop() {
    		ajax('get', '/home/product/detail/addcart/' + params['id'])
    			.then(function (resolve) {
    				if (resolve) {
    					var v = resolve['content'];
    					var specs = resolve['specs'];
    					var template = '';
    					addCartProductData(v);
						specs.forEach(function (data) {
    						template += '<li class="pull-left mr-10 mb-10 J_choose_spec ';  
    						if (v['id'] == data['id']) {
    							template += 'active';
    							popid = v['id']
    						}
    						template += '" pid='+data['id']+'><a href="javascript:;">'+data['name']+'</a></li>';
    					});	
						$('.addcart-specs').html(template);
						//打开加入购物车弹窗
						$('.productspec').addClass('top-0').animate({
							'opacity': 1},100,function () {
							$('.productspec_container').addClass('bottom-0')
						})
    				} else {
    					prompt.message('服务器繁忙！稍后再试！')
    				}
    			})
    	}

    	//加入购物车 设置商品参数
    	function addCartProductData(v) {
    		$(".productspec_container_info_img img").attr('src','http://'+window.location.host+'/'+v['thumb']);
    		$(".productspec_container_info_content h1").html(v['name']);
    		$(".productspec_container_info_content p").html(v['desc']);
    		$(".productspec_container_info_content span").html('&yen;'+v['price']);
    		$(".sum_price").html(v['price']);
    		$("#price").val(v['price']);
    	}

    	// 隐藏产品规格弹窗
    	$('.J_hide_productspec').on('click tap', function () {
    		$('.productspec').removeClass('top-0').animate({
				'opacity': 0},
				300,
				function () {
					$('.productspec_container').removeClass('bottom-0')
				}
			)
    	})

    	// 减少数量
    	$('.J_minus_amount').on('click tap', function () {
    		var amount = parseInt($(this).siblings('input[name="amount"]').val())
    		var price = parseInt($(this).parents('.productspec_container').find('#price').val())
    		if (amount == 1) return;
    		else {
    			amount = amount - 1
    			$(this).siblings('input[name="amount"]').val(amount)
    			$(this).parents('.productspec_container').find('.sum_price').text((price * amount).toFixed(2))
    		}
    	})
    	// 增加数量
    	$('.J_plus_amount').on('click tap', function () {
    		var amount = parseInt($(this).siblings('input[name="amount"]').val())
    		var price = parseFloat($(this).parents('.productspec_container').find('#price').val())
    		if (amount > 99) return; // ajax请求库存，如果库存不足返回并提示
    		else {
    			amount = amount + 1
    			$(this).siblings('input[name="amount"]').val(amount)
    			$(this).parents('.productspec_container').find('.sum_price').text((price * amount).toFixed(2))
    		}
    	})
    	$('input[name="amount"]').on('blur', function () {
    		var amount = parseInt($(this).val())
    		var price = parseFloat($(this).parents('.productspec_container').find('#price').val())
    		if (amount > 1) {
    			$(this).parents('.productspec_container').find('.sum_price').text((price * amount).toFixed(2))
    		} else {
    			$(this).val(1)
    			$(this).parents('.productspec_container').find('.sum_price').text((price * 1).toFixed(2))
    		}
    	})

    	// 选择规格
    	$('.addcart-specs').on('click tap', '.J_choose_spec',function () {
    		// ajax 写法
    		var $this = $(this)
    		var id = $(this).attr('pid');
    		ajax('get', '/home/product/detail/addcart/'+ id)
    			.then(function (res) {
    				if (res){
    					var v = res['content'];
    					addCartProductData(v);
    					$this.addClass('active').siblings().removeClass('active');
    					popid = $this.attr('pid');
    				} else {
    					prompt.message('服务器繁忙！稍后再试！')
    				}
    			})
    	})

    	// 选择评论类型
    	$('.J_choose_comment_type').on('click tap', function () {
    		$(this).addClass('active').siblings().removeClass('active')
    		params['grade'] = $(this).attr('type');
    		searchComment();
    	})

    	var tab_offset_top = $('.productdetail_container_tabs').offset().top
    	// 页面滚动
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
				<span class="price">&yen;{{sprintf('%.2f', $content->price)}}</span>
				<p class="mt-10 mb-10">价格：<del>{{sprintf('%.2f', $content->raw_price)}}</del></p>
				<p class="clearfix">
					<span class="pull-left">快递：<i>{{sprintf('%.2f', $content->delivery_price)}}</i></span>
					<span class="pull-right">销量：<i>{{$content->sell_amount}}</i>笔</span>
				</p>
				<div class="productdetail_container_info_spec">
					<span>规格：</span>
					<ul class="clearfix">
					@foreach($specs as $spec)
						<li class="pull-left mr-10 mb-10 J_choose_spec" >
							<a href="{{url('/home/product/detail')}}/{{$spec->id}}" @if($content->id == $spec->id)class="active"  @endif>{{$spec->name}}</a>
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
					<li class="pull-left mr-10 mb-10 J_choose_comment_type active" type="A">
						<a href="javascript:;">
							好评(<span>{{$commentA}}</span>)
						</a>
					</li>
					<li class="pull-left mr-10 mb-10 J_choose_comment_type" type="B">
						<a href="javascript:;">
							中评(<span>{{$commentB}}</span>)
						</a>
					</li>
					<li class="pull-left mr-10 mb-10 J_choose_comment_type" type="C">
						<a href="javascript:;">
							差评(<span>{{$commentC}}</span>)
						</a>
					</li>
					<li class="pull-left mr-10 mb-10 J_choose_comment_type" type="Img">
						<a href="javascript:;">
							有图片(<span>{{$commentImg}}</span>)
						</a>
					</li>
				</ol>
				<ul class="comment_list">
<!-- 					<li class="clearfix">
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
							<p class="fz-12">答案地方 <b>回复</b> 打撒 [2018-10-12 12:23:34] ：</p>
							<p class="fz-12">水电费撒的发生发顺丰.....</p>
							<p class="txt-r mt-10">0000年00月00日 00:00</p>
						</div>
					</li> -->
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
			<div class="productdetail_bottom_btn pull-left chayefont add_cart J_show_productspec">
				加入购物车
			</div>
			<div class="productdetail_bottom_btn pull-left chayefont buy_now">
				立即购买
			</div>
		</div>
	</div>

	<div class="productspec">
		<div class="productspec_bg J_hide_productspec"></div>
		<div class="productspec_container">
			<div class="productspec_container_info">
				<div class="productspec_container_info_img pull-left mr-10">
					<img src="" alt="">
				</div>
				<div class="productspec_container_info_content pull-right">
					<h1 class="mb-10">商品名称</h1>
					<p>商品描述</p>
					<span class="pull-right color-F78223">&yen;<s class="price">价格</s></span>
				</div>
			</div>
			<div class="productspec_container_spec">
				<p>规格：</p>
				<ul class="clearfix mt-10 addcart-specs">

				</ul>
			</div>
			<div class="productspec_container_amount">
				<i class="fa fa-minus-square mr-10 color-d7d7d7 J_minus_amount"></i>
				<input type="number" autocomplete="off" name="amount" value="1">
				<i class="fa fa-plus-square ml-10 color-F78223 J_plus_amount"></i>
			</div>
			<div class="productspec_container_price">
				<span class="pull-left color-d7d7d7">合计：</span>
				<span class="pull-right color-F78223">&yen;<s class="sum_price"> 总价格 </s></span>
				<input type="hidden" id="price" value="0">
			</div>
			<div class="productspec_container_bottom">
				<div class="productspec_container_bottom_icon pull-left kefu">
					<i class="fa fa-headphones mt-10"></i>
					<p>客服</p>
				</div>
				<div class="productspec_container_bottom_icon pull-left favo J_favo">
					<i class="fa fa-star-o mt-10"></i>
					<p>收藏</p>
				</div>
				<div class="productspec_container_bottom_btn pull-left chayefont add_cart J_join_cart">
					确定
				</div>
				<div class="productspec_container_bottom_btn pull-left chayefont cancel J_hide_productspec">
					取消
				</div>
			</div>
		</div>
	</div>
@endsection
