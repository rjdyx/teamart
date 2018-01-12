@extends('layouts.app')

@section('title') 商品详情 @endsection

@section('css')
@endsection

@section('script')
	@parent
	<script src="{{url('/fx/build/swiper.js')}}"></script>
	<script type="text/javascript" src="{{ url('fx/js/dropload.min.js') }}"></script>
	<script>
	$(function(){
		var page = 0;//分页
		var params = {id:'', page:0, grade:''};//定义全局对象
    	var popid = '';
    	var poptype = 'cart';
        var spec_id = '';
    	var uid = {{Auth::user() ? Auth::user()->id : 0}} //用户id
		params['id'] = {{ $content->id }};
		var state = {{ $content->state }}
		var stock = {{ $content->stock }}
				
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
						if (page == 1) {
							$('.dropload-down').hide()
							$('.productdetail_container_comment').find('.comment_nodata').remove()
							$('.productdetail_container_comment').append(`
							<div class="list_nodata txt-c">
								暂无评价
							</div>`)
						}
					}
					$('.comment_list').append(template);
					me.resetload();
					$('.J_show_image').off('tap').on('tap', function () {
						fxPrompt.image($(this).data('img'))
					})
					$('.J_reply_btn').off('tap').on('tap', function () {
						// TODO回复
					})
				})
				.catch(function (err) {
					console.dir(err)
					fxPrompt.message('请求错误')
				});
		}

		function listData(res){
			var template = '';
			res.forEach(function (v) {
				template += `<li class="clearfix">
								<div class="comment_list_avatar pull-left">
									<img src="http://${window.location.host}/${v.user_img}">
									<span class="block txt-c">${v.user_name}</span>
								</div>
								<div class="comment_list_content pull-right">
									<p class="stars">`
				//评论星星
				for (var i=0;i<v['grade']/20;i++)
				{
					template += '<i class="fa fa-star"></i>';
				}
				template += `</p>
							<p class="fz-12">${v.content}</p>
							<div class="comment_list_content_img clearfix">`
				//评论图片
				if (v['img']) {
					var imgs = v['img'].split(',')
					var thumb = v['thumb'].split(',')
					for(var j=0;j<imgs.length;j++) {
						template += `<img class="pull-left mr-10 J_show_image" src="http://${window.location.host}/${thumb[j]}" data-img="http://${window.location.host}/${imgs[j]}">`;
					}
				}
				template += `</div><p class="txt-r mt-10">${v.created_at}</p>`
				if (v['replys']) {
					template += '<div class="comment_reply w-100">'
					for(var j=0;j<v['replys'].length;j++) {
								// ${v.user_id == uid ? '<a href="javascript:;" class="comment_reply_btn block J_reply_btn">回复</a>' : ''}
						template += `
							<div class="comment_reply_warpper w-100 p-10 relative">
								<p class="fz-12">${v['replys'][j]['aname']} <b>回复</b> ${v['replys'][j]['bname']}：</p>
								<p class="fz-12">${v['replys'][j]['content']}</p>
								<p class="fz-12 txt-r">${v['replys'][j]['created_at']}</p>
							</div>
						`
					}
					// template += `
					// 	<div class="comment_reply_warpper w-100 p-10 relative">
					// 		<label for="reply">
					// 			<input class="pl-10" type="text" id="reply" placeholder="回复。。。" />
					// 		</label>
					// 	</div>
					// 	`
					template += '</div>'
				}	
				template += `</div></li>`
			})
			return template;
		}

		function searchComment() {
			params['page'] = 1;
			ajax('get', '/home/product/comment/'+params['id'], params)
				.then(function (res) {
					var template = ''
					if (res.length > 0) {
						template = listData(res);
					}
					$('.comment_list').html(template);
					$('.J_show_image').off('tap').on('tap', function () {
						fxPrompt.image($(this).data('img'))
					})
				})
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
		$('.J_favo').on('tap', function () {
			if ($(this).find('i').hasClass('fa-star-o')) {
				ajax('post', '/home/collect', {id: params['id']})
					.then(function (resolve) {
						if (resolve) {
							$('.J_favo').find('i').removeClass('fa-star-o').addClass('fa-star')
							fxPrompt.message('收藏成功')
						} else {
							fxPrompt.message('收藏失败')
						}
					})
			} else {
				ajax('delete', '/home/collect/' + params['id'])
					.then(function (resolve) {
						if (resolve) {
							$('.J_favo').find('i').addClass('fa-star-o').removeClass('fa-star')
							fxPrompt.message('取消收藏成功')
						} else {
							fxPrompt.message('取消收藏失败')
						}
					})
			}
		});

    	// 弹窗确定
    	// 新增后台商品数量判断
    	$('.J_join_cart').on('tap', function () {
            var num = $('.productspec_container_amount input').val();
			ajax('get', `/home/product/{{ $content->id }}/stock`, {stock: num})
			.then(function (resolve) {
				if (resolve) {
					var params = {id:popid, amount:num, spec_id:spec_id};
					if (poptype == 'cart') {
						storeCart(params);
					} else {
						storeBuy(params);
					}
				} else {
					fxPrompt.message('商品库存不足')
				}
			})
            
    	});

    	// 加入购物车
    	function storeCart(params) {
            var url = '/home/product/detail/addcart';
    		ajax('post', url, params).then(function (resolve) {
				if (resolve) {
					fxPrompt.message('已经加入购物车')
					$('.productspec_container').removeClass('bottom-0')
					$('.productspec').animate({
						'opacity': 0},100,function () {
						$('.productspec').removeClass('top-0')
					})
				} else {
					fxPrompt.message('加入购物车失败')
				}
			})
    	};

    	// 立即购买（待支付）
    	function storeBuy(params) {
            var url = '/home/product/detail/addorder';
    		var url_a = 'http://' + window.location.host + '/home/order/confirm?id=';
    		ajax('post', url, params).then(function (resolve) {
				if (resolve) {
					window.location.href = url_a + resolve;	
				} else {
					fxPrompt.message('服务器异常！请稍后再试！')
				}
			})
    	};


		//点击加入购物车
		$('.J_show_productspec').on('tap', function () {
			if (state == 0) {
				fxPrompt.message('该商品已下架')
			} else if (stock <= 0) {
				fxPrompt.message('该商品缺货中')
			} else {
				poptype = 'cart';
				cshPop();
			}
		});

		//点击立即购买
		$('.buy_now').on('tap', function () {
			if (state == 0) {
				fxPrompt.message('该商品已下架')
			} else if (stock <= 0) {
				fxPrompt.message('该商品缺货中')
			} else {
				poptype = 'buy';
				cshPop();
			}
		});

    	//初始化弹窗
    	function cshPop() {
            var url = '/home/product/detail/addcart/' + params['id'];
    		ajax('get', url).then(function (resolve) {
				if (resolve) {
					var v = resolve['content'];
					var specs = resolve['specs'];
					var template = '';
					addCartProductData(v);
					specs.forEach(function (data) {
						template += '<li class="pull-left mr-10 mb-10 J_choose_spec ';  
						if (data['state']) {
							template += 'active';
							popid = v['id']
                            spec_id = data['id']
						}
						template += '" pid='+data['id']+' price='+data['price']+'><a href="javascript:;" class="block p-10 color-3B3B3B">'+data['name']+'</a></li>';
					});	
					$('.addcart-specs').html(template);
					//打开加入购物车弹窗
					$('.productspec').addClass('top-0').animate({
						'opacity': 1},100,function () {
						$('.productspec_container').addClass('bottom-0')
					})
				} else {
					fxPrompt.message('服务器繁忙！稍后再试！')
				}
			})
    	}

		//加入购物车 设置商品参数
		function addCartProductData(v) {
			$(".productspec_container_info_img img").attr('src','http://'+window.location.host+'/'+v['thumb']);
			$(".productspec_container_info_content h1").html(v['name']);
			$(".productspec_container_info_content p").html(v['desc']);
			$(".productspec_container_info_content span").html('&yen;'+parseFloat(v['price']).toFixed(2));
			$(".sum_price").html(parseFloat(v['price']).toFixed(2));
			$("#price").val(v['price']);
			$("#amount").val(1)
		}

		// 隐藏产品规格弹窗
		$('.J_hide_productspec').on('tap', function () {
			console.dir($('.productspec'))
			$('.productspec').removeClass('top-0').animate({
				'opacity': 0},
				300,
				function () {
					$('.productspec_container').removeClass('bottom-0')
				}
			)
		})

    	// 减少数量
    	$('.J_minus_amount').on('tap', function () {
    		var amount = parseInt($(this).siblings('input[name="amount"]').val())
    		var price = parseFloat($(this).parents('.productspec_container').find('#price').val())
    		if (amount == 1) return;
    		else {
    			amount = amount - 1
    			$(this).siblings('input[name="amount"]').val(amount)
    			$(this).parents('.productspec_container').find('.sum_price').text((price * amount).toFixed(2))
    		}
    	})
    	// 增加数量
    	$('.J_plus_amount').on('tap', function () {
    		var amount = parseInt($(this).siblings('input[name="amount"]').val())
    		var price = parseFloat($(this).parents('.productspec_container').find('#price').val())
    		if (amount > 99) return; // ajax请求库存，如果库存不足返回并提示
    		else {
    			amount = amount + 1
    			$(this).siblings('input[name="amount"]').val(amount)
    			$(this).parents('.productspec_container').find('.sum_price').text((price * amount).toFixed(2))
    		}
    	})
        //输入数量
    	$('input[name="amount"]').on('blur', function () {
    		var amount = parseInt($(this).val())
    		var price = parseFloat($(this).parents('.productspec_container').find('#price').val())
    		if (amount > 1) {
    			$(this).parents('.productspec_container').find('.sum_price').text((price * amount).toFixed(2))
    		} else {
    			$(this).val(1)
    			$(this).parents('.productspec_container').find('.sum_price').text((price * 1).toFixed(2))
    		}
    	}).on('input', function () {
    		var v = parseInt($(this).val())
    		if (!/^[0-9]{0,}$/.test(v)) {
    			$(this).val(1)
    			return
    		}
    	})

    	// 弹窗选择规格
    	$('.addcart-specs').on('tap', '.J_choose_spec',function () {
            spec_id = $(this).attr('pid');
    		var price = $(this).attr('price');
            $("#price").val(price);
            $(".sum_price").text(parseFloat(price).toFixed(2));
            $('input[name="amount"]').val(1);
            $(".productspec_container_info_content span").html('&yen'+parseFloat(price).toFixed(2));
    		$(this).addClass('active').siblings().removeClass('active');
    	})

		// 选择评论类型
		$('.J_choose_comment_type').on('tap', function () {
			$(this).addClass('active').siblings().removeClass('active')
			params['grade'] = $(this).attr('type');
			searchComment();
		})

		// 商品下架后执行的
		$('.J_xiajia').on('tap', function () {
			fxPrompt.message('商品已下架')
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

        //规格点击事件
        $(".spec-click").on('tap',function(){
            $(".spec-click").removeClass('active');
            $(this).addClass('active');
            $(".price").html('&yen'+$(this).attr('price'));
        })
	})
	</script>
@endsection

@section('content')
	@include("layouts.header-info")

	@include("layouts.backIndex")
	<div class="container productdetail relative">
		<div class="productdetail_cart txt-c fz-20">
			<a href="{{url('/home/cart')}}" class="color-F78223">
				<i class="fa fa-shopping-cart"></i>
			</a>
		</div>
		<div class="productdetail_container w-100 h-100 J_scroll">
			<div class="productdetail_container_banner w-100 swiper-container">
				<div class="swiper-wrapper">
					@foreach($imgs as $img)
					<div class="swiper-slide" data-swiper-autoplay="2000">
						<img class="w-100" src="{{url('')}}/{{$img->img}}" alt="">
					</div>
					@endforeach
				</div>
				<div class="swiper-pagination"></div>
			</div>
			<div class="productdetail_container_info">
				<h1 class="chayefont fz-18">{{$content->name}}</h1>
				<p class="desc fz-16 color-8C8C8C mt-10 mb-10">{{$content->desc}}</p>
				<span class="price fz-14">&yen;{{sprintf('%.2f', $content->price)}}</span>
				<p class="clearfix color-8C8C8C fz-14">
					<span class="pull-left">快递：<i>{{sprintf('%.2f', $content->delivery_price)}}</i></span>
					<span class="pull-right">销量：<i>{{$content->sell_amount}}</i>笔</span>
				</p>
				<div class="productdetail_container_info_spec">
					<span class="fz-14 color-8C8C8C">规格：</span>
					<ul class="clearfix w-100">
					@foreach($specs as $spec)
						<li class="pull-left mr-10 mb-10 J_choose_spec" >
							<a href="javascript:;" class="spec-click block p-10 color-3B3B3B @if($spec->state)active  @endif" price="{{$spec->price}}" sid="{{$spec->id}}">{{$spec->name}}</a>
						</li>
					@endforeach
					</ul>
				</div>
			</div>
			<div class="productdetail_container_tabs p-10 w-100">
				<a href="javascript:;" class="J_tabs pull-left color-8C8C8C fz-14 block txt-c chayefont active" data-tag="detail">商品详情</a>
				<a href="javascript:;" class="J_tabs pull-left color-8C8C8C fz-14 block txt-c chayefont" data-tag="comment">评价<span>{{$commentAmount}}</span></a>
			</div>
			<div class="hide productdetail_blank w-100"></div>
			<div class="productdetail_container_detail" data-tab="detail">
				<div class="productdetail_container_detail_info clearfix">
					<ol class="pull-left fz-12 color-8C8C8C">
						<li>生产日期: {{$content->date}}</li>
						<li>产地: {{$content->origin}}</li>
						<li>作用: {{$content->effect}}</li>
					</ol>
				</div>
				<div class="productdetail_container_detail_img">
					{!! html_entity_decode($content->details) !!}
				</div>
			</div>
			<div class="productdetail_container_comment hide" data-tab="comment">
				<!-- 评价区域 -->
				<ol class="comment_filter w-100 clearfix">
					<li class="pull-left mr-10 mb-10 J_choose_comment_type active" type="">
						<a href="javascript:;" class="block color-3B3B3B p-10">
							全部(<span>{{$commentAmount}}</span>)
						</a>
					</li>
					<li class="pull-left mr-10 mb-10 J_choose_comment_type" type="A">
						<a href="javascript:;" class="block color-3B3B3B p-10">
							好评(<span>{{$commentA}}</span>)
						</a>
					</li>
					<li class="pull-left mr-10 mb-10 J_choose_comment_type" type="B">
						<a href="javascript:;" class="block color-3B3B3B p-10">
							中评(<span>{{$commentB}}</span>)
						</a>
					</li>
					<li class="pull-left mr-10 mb-10 J_choose_comment_type" type="C">
						<a href="javascript:;" class="block color-3B3B3B p-10">
							差评(<span>{{$commentC}}</span>)
						</a>
					</li>
					<li class="pull-left mr-10 mb-10 J_choose_comment_type" type="Img">
						<a href="javascript:;" class="block color-3B3B3B p-10">
							有图片(<span>{{$commentImg}}</span>)
						</a>
					</li>
				</ol>
				<ul class="comment_list">
					<!-- <li class="clearfix">
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
							<div class="comment_reply">
								<div class="comment_reply_warpper">
									<p class="fz-12">答案地方 <b>回复</b> 打撒：</p>
									<p class="fz-12">水电费撒的发生发顺丰.....</p>
									<p class="fz-12 txt-r">2018-10-12 12:23:34</p>
								</div>
								<div class="comment_reply_warpper">
									<p class="fz-12">答案地方 <b>回复</b> 打撒：</p>
									<p class="fz-12">水电费撒的发生发顺丰.....</p>
									<p class="fz-12 txt-r">2018-10-12 12:23:34</p>
								</div>
								<div class="comment_reply_warpper">
									<p class="fz-12">答案地方 <b>回复</b> 打撒：</p>
									<p class="fz-12">水电费撒的发生发顺丰.....</p>
									<p class="fz-12 txt-r">2018-10-12 12:23:34</p>
								</div>
								<div class="comment_reply_warpper">
									<p class="fz-12">答案地方 <b>回复</b> 打撒：</p>
									<p class="fz-12">水电费撒的发生发顺丰.....</p>
									<p class="fz-12 txt-r">2018-10-12 12:23:34</p>
								</div>
								<div class="comment_reply_warpper">
									<p class="fz-12">答案地方 <b>回复</b> 打撒：</p>
									<p class="fz-12">水电费撒的发生发顺丰.....</p>
									<p class="fz-12 txt-r">2018-10-12 12:23:34</p>
								</div>
							</div>
						</div>
					</li> -->
				</ul>
			</div>
		</div>
		<div class="bottom_btn txt-c">
			<?php 
				$system = App\System::find(1);
				$qq = '';
				if (count($system)) {
					$qq = $system->qq;
				}
			 ?>
			<a class="bottom_btn_icon fz-16 pull-left fz-16 color-717171 kefu" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={{$qq}}&site=qq&menu=yes">
				<i class="fa fa-headphones mt-10"></i>
				<p>客服</p>
			</a>
			<div class="bottom_btn_icon pull-left fz-16 color-717171 favo J_favo">
				<i class="fa mt-10 @if(isset($collect->id)) fa-star @else fa-star-o @endif"></i>
				<p>收藏</p>
			</div>
			<div class="bottom_btn_btn pull-left white fz-18 chayefont add_cart J_show_productspec">
				加入购物车
			</div>
			<div class="bottom_btn_btn pull-left white fz-18 chayefont buy_now">
				立即购买
			</div>
		</div>
	</div>

	<div class="productspec w-100 h-100">
		<div class="productspec_bg w-100 h-100 J_hide_productspec"></div>
		<div class="productspec_container w-100">
			<div class="productspec_container_info w-100">
				<div class="productspec_container_info_img h-100 pull-left mr-10">
					<img class="h-100" src="" alt="">
				</div>
				<div class="productspec_container_info_content pull-right">
					<h1 class="mb-10">商品名称</h1>
					<p>商品描述</p>
					<span class="pull-right color-F78223">&yen;<s class="pop-price">价格</s></span>
				</div>
			</div>
			<div class="productspec_container_spec w-100">
				<p>规格：</p>
				<ul class="clearfix mt-10 addcart-specs w-100">

				</ul>
			</div>
			<div class="productspec_container_amount w-100 txt-c">
				<i class="fa fa-minus-square inline-block mr-10 color-d7d7d7 J_minus_amount"></i>
				<input type="number" class="txt-c" autocomplete="off" id="amount" name="amount" value="1">
				<i class="fa fa-plus-square inline-block ml-10 color-F78223 J_plus_amount"></i>
			</div>
			<div class="productspec_container_price w-100">
				<span class="pull-left color-d7d7d7">合计：</span>
				<span class="pull-right color-F78223">&yen;<s class="sum_price"> 总价格 </s></span>
				<input type="hidden" id="price" value="0">
			</div>
			<div class="bottom_btn txt-c">
				<?php 
					$system = App\System::find(1);
					$qq = '';
					if (count($system)) {
						$qq = $system->qq;
					}
				 ?>
				<a class="bottom_btn_icon pull-left fz-16 color-717171 kefu" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={{$qq}}&site=qq&menu=yes">
					<i class="fa fa-headphones mt-10"></i>
					<p>客服</p>
				</a>
				<div class="bottom_btn_icon pull-left fz-16 color-717171 favo J_favo">
					<i class="fa  @if(isset($collect->id)) fa-star @else fa-star-o @endif mt-10"></i>
					<p>收藏</p>
				</div>
				<div class="bottom_btn_btn pull-left white fz-18 chayefont add_cart J_join_cart">
					确定
				</div>
				<div class="bottom_btn_btn pull-left white fz-18 chayefont cancel J_hide_productspec">
					取消
				</div>
			</div>
		</div>
	</div>
@endsection
