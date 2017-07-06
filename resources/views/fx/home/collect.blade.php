@extends('layouts.app')

@section('title') 我的收藏 @endsection

@section('css')
@endsection

@section('script')
	@parent
	<script type="text/javascript" src="{{ url('fx/common/dropload.js') }}"></script>
    <script>
		$(function () {
			var dels = []
			// 单个选择
			function selectSingle () {
				if (!$(this).hasClass('active')) {
					$(this).addClass('active')
					dels.push($(this).data('id'))
					if (dels.length == $('.J_select').length) {
						$('.J_select_all').find('span').addClass('active')
					}
				} else {
					$(this).removeClass('active')
					$('.J_select_all').find('span').removeClass('active')
					var arr = []
					for (var i = 0; i < dels.length; i++) {
						if (dels[i] != $(this).data('id')) {
							arr.push(dels[i])
						}
					}
					dels = arr
				}
				console.log(dels)
			}
			// 全选
			$('.J_select_all').on('click tap', function () {
				if (!$(this).find('span').hasClass('active')) {
					dels = []
					$('.J_select')
					.each(function () {
						$(this).addClass('active')
						dels.push($(this).data('id'))
					})
					$(this).find('span').addClass('active')
				} else {
					$('.J_select')
					.each(function () {
						$(this).removeClass('active')
						dels = []
					})
					$(this).find('span').removeClass('active')
				}
				console.log(dels)
			})
			// 删除商品
			$('.J_dels').on('click tap', function () {
				if (dels.length == 0) {
                    prompt.message('请选择要删除的商品')
                    return
                } else {
                	prompt.question('是否删除所选商品', function () {
						ajax('post', '/home/collect/dels', dels)
							.then(function (res) {
								if (res) {
									prompt.message('删除成功')
									$('.J_select').each(function () {
										var $this = $(this)
										dels.forEach(function (v) {
											if (v == $this.data('id')) {
												$this.parent().remove()
											}
										})
									})
									dels = []
								} else {
									prompt.message('删除失败')
								}
							})
					})
                }
			})
			// 加入购物车
			$('.J_join_cart').on('click tap', function () {
				if (dels.length == 0) {
                    prompt.message('请选择要加入购物车')
                    return
                } else {
                	prompt.question('是否加入购物车', function () {
						ajax('get', '/home/collect/cart', {ids: dels})
							.then(function (res) {
								if (res) {
									prompt.message('添加成功')
								} else {
									prompt.message('添加失败')
								}
							})
					})
                }
			})
			var page = 0
			// 加载
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
	            loadUpFn : function (me) {
	            	getListData(me, 'up')
	            },
	            loadDownFn : function (me) {
	            	getListData(me, 'down')
	            },
	            threshold : 50
	        })
			function getListData (me, type) {
				if (type == 'down') {
					page++
				} else {
                	page = 1
                	$('.dropload-down').show()
				}
				ajax('get', '/home/collect/data', {page: page}, false, false, false)
					.then(function (res) {
						var result = ''
						if (res.data.length > 0) {
							res.data.forEach(function (v) {
								result += `
									<div class="collect_warpper mb-20 clearfix">
										<i class="collect_warpper_select J_select" data-id="${v.op_id}"></i>
										<div class="collect_warpper_content_img pull-left mr-20">
											<img src="${v.img}">
										</div>
										<div class="collect_warpper_content_info pull-right">
											<h5 class="chayefont mb-10">${v.name}</h5>
											<p class="desc">${v.desc}</p>
											<div class="collect_warpper_content_info_bottom">
												<span class="pull-left price">￥${v.price}</span>
												<span class="pull-right sell">已售${v.sell_amount}</span>
											</div>
										</div>
									</div>
								`
							})
						} else {
							me.lock();
                        	me.noData();
                        	if (page == 1) {
								$('.dropload-down').hide()
	                        	$('.collect_container').find('.collect_nodata').remove()
								$('.collect_container').append(`
								<div class="collect_nodata txt-c">
									你还没有收藏，快去<a href="{{url('')}}">首页</a>看看吧
								</div>`)
                        	}
						}
						if (type == 'up') {
                        	$('.collect_list').html(result);
                        	$('.J_select_all').find('span').removeClass('active')
							$('.J_select').on('click tap', selectSingle)
                        	dels = []
						} else {
							$('.collect_list').append(result);
							$('.J_select').off('click tap').on('click tap', selectSingle)
						}
                        me.resetload();
                        if (type == 'up') {
                            me.unlock();
                            me.noData(false);
                        }
					})
					.catch(function (err) {
						prompt.message('请求错误')
						// me.resetload()
					})
			}
		})
    </script>
@endsection

@section('content')

	@include("layouts.header-info")

	@include("layouts.backIndex")

	<div class="container collect">
		<div class="collect_container">
			<div class="collect_list">
				<!-- 收藏商品结构 -->
			</div>
		</div>

		<div class="collect_bottom">
			<div class="block pull-left txt-l collect_bottom_selection J_select_all">
				<span>全选</span>
			</div>
			<div class="block pull-left txt-c fz-14 collect_bottom_cart J_join_cart">加入购物车</div>
			<div class="block pull-left txt-c collect_bottom_del J_dels">删除</div>
		</div>
	</div>
@endsection
