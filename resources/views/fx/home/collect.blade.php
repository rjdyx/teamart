@extends('layouts.app')

@section('title') 我的收藏 @endsection

@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('fx/css/dropload.css') }}">
@endsection

@section('script')
	@parent
	<script type="text/javascript" src="{{ url('fx/common/dropload.js') }}"></script>
    <script>
		$(function () {
			var dels = []
			// 单个选择
			$('.J_select').on('click tap', function () {
				if (!$(this).find('a').hasClass('active')) {
					$(this).find('a').addClass('active')
					dels.push($(this).data('id'))
					if (dels.length == $('.J_select').length) {
						$('.J_select_all').find('span').addClass('active')
					}
				} else {
					$(this).find('a').removeClass('active')
					var arr = []
					for (var i = 0; i < dels.length; i++) {
						if (dels[i] != $(this).data('id')) {
							arr.push(dels[i])
						}
					}
					dels = arr
				}
				console.log(dels)
			})
			// 全选
			$('.J_select_all').on('click tap', function () {
				if (!$(this).find('span').hasClass('active')) {
					$('.J_select')
					.each(function () {
						$(this).find('a').addClass('active')
						dels.push($(this).data('id'))
					})
					$(this).find('span').addClass('active')
				} else {
					$('.J_select')
					.each(function () {
						$(this).find('a').removeClass('active')
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
								} else {
									prompt.message('删除失败')
								}
							})
					})
                }
			})

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
			var page = 0
			function getListData (me, type) {
				if (type == 'down') {
					page++
				} else {
					page = 0
				}
				ajax('get', '/home/collect/data', { page: page}, false, false, false)
					.then(function (res) {
						var template = ''
						if (res.length > 0) {
							res.forEach(function (v) {
								template += `
									<div class="collect_warpper mb-20">
										<div class="collect_warpper_tit J_select" data-id="${v.id}">
											<a href="javascript:;" class="chayefont">
												<i class="fa fa-ban"></i>
												绿茶宝塔镇河妖
											</a>
										</div>
										<div class="collect_warpper_content clearfix">
											<div class="collect_warpper_content_img pull-left mr-20">
												<img src="${v.img}">
											</div>
											<div class="collect_warpper_content_info pull-right">
												<h5 class="chayefont mb-10">${v.name}</h5>
												<p>${v.desc}</p>
												<div class="collect_warpper_content_info_bottom">
													<span class="pull-left price">￥${v.price}</span>
													<span class="pull-right sell">已售${v.sell_amount}</span>
												</div>
											</div>
										</div>
									</div>
								`
							})
						} else {
							me.lock();
                            me.noData();
						}
						if (type == 'up') {
                            me.unlock();
                            me.noData(false);
                            $('.collect_list').html(result);
						} else {
							$('.collect_list').append(result);
						}
                        me.resetload();
					})
					.catch(function (err) {
						prompt.message('请求错误')
						me.resetload()
					})
			}
		})
    </script>
@endsection

@section('content')

	@include("layouts.header-info")

	<div class="container collect">
		<div class="collect_container">
			<div class="collect_list">
				@foreach($lists as $list)
				<div class="collect_warpper mb-20">
					<div class="collect_warpper_tit J_select" data-id="{{$list->op_id}}">
						<a href="javascript:;" class="chayefont">
							<i class="fa fa-ban"></i>
							绿茶宝塔镇河妖
						</a>
					</div>
					<div class="collect_warpper_content clearfix">
						<div class="collect_warpper_content_img pull-left mr-20">
							<img src="{{url('')}}/{{ $list->p_img }}">
						</div>
						<div class="collect_warpper_content_info pull-right">
							<h5 class="chayefont mb-10">{{$list->p_name}}</h5>
							<p>{{$list->p_desc}}</p>
							<div class="collect_warpper_content_info_bottom">
								<span class="pull-left price">&yen;{{number_format($list->price,2)}}</span>
								<span class="pull-right sell">{{'已售'.$list->p_sell_amount}}</span>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>

		<div class="collect_bottom">
			<div class="block pull-left txt-l collect_bottom_selection J_select_all">
				<span>全选</span>
			</div>
			<div class="block pull-left txt-c collect_bottom_del J_dels">删除</div>
		</div>
	</div>
@endsection
