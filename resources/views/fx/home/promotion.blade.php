@extends('layouts.app')

@section('title') 活动商品 @endsection

@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('fx/css/dropload.css') }}">
@endsection

@section('script')
    @parent
    <script type="text/javascript" src="{{ url('fx/common/dropload.js') }}"></script>
    <script>
        $(function () {
            var page = 0
            $('.promotion_container').dropload({
                scrollArea : $('.promotion_container'),
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
                    getListData(me, 'up')
                },
                loadDownFn : function(me){
                    getListData(me, 'down')
                },
                threshold : 50
            });
            function getListData (me, type) {
                if (type == 'down') {
                    page++
                } else {
                    page = 0
                }
                ajax('get', '/home/cart/data', {page: page}, false, false, false)
                    .then(function (res) {
                        var template = ''
                        if (res.length > 0) {
                            res.forEach(function (v) {
                                template += `
                                    <div class="promotion_warpper pull-left">
										<a href="javascript:;">
											<img src=http://' + window.location.host + '/' +data[i]['img'] + '>
											<h1 class="mt-20 chayefont">活动商品</h1>
											<p class="mt-10 mb-10">活动商品活动商品活动商品活动商品活动商品活动商品活动商品</p>
											<p class="clearfix">
												<span class="pull-left price">&yen;999.99</span>
												<span class="pull-right sell">销量：<i>888</i></span>
											</p>
										</a>
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
                            $('.promotion_list').html(result);
                        } else {
                            $('.promotion_list').append(result);
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
	<div class="promotion">
		<div class="promotion_container">
			<div class="promotion_list clearfix">
				<div class="promotion_warpper pull-left">
					<a href="javascript:;">
						<img src=http://' + window.location.host + '/' +data[i]['img'] + '>
						<h1 class="mt-20 chayefont">活动商品</h1>
						<p class="mt-10 mb-10">活动商品活动商品活动商品活动商品活动商品活动商品活动商品</p>
						<p class="clearfix">
							<span class="pull-left price">&yen;999.99</span>
							<span class="pull-right sell">销量：<i>888</i></span>
						</p>
					</a>
				</div>
				<div class="promotion_warpper pull-left">
					<a href="javascript:;">
						<img src=http://' + window.location.host + '/' +data[i]['img'] + '>
						<h1 class="mt-20 chayefont">活动商品</h1>
						<p class="mt-10 mb-10">活动商品活动商品活动商品活动商品活动商品活动商品活动商品</p>
						<p class="clearfix">
							<span class="pull-left price">&yen;999.99</span>
							<span class="pull-right sell">销量：<i>888</i></span>
						</p>
					</a>
				</div>
				<div class="promotion_warpper pull-left">
					<a href="javascript:;">
						<img src="">
						<h1 class="mt-20 chayefont">活动商品</h1>
						<p class="mt-10 mb-10">活动商品活动商品活动商品活动商品活动商品活动商品活动商品</p>
						<p class="clearfix">
							<span class="pull-left price">&yen;999.99</span>
							<span class="pull-right sell">销量：<i>888</i></span>
						</p>
					</a>
				</div>
				<div class="promotion_warpper pull-left">
					<a href="javascript:;">
						<img src="">
						<h1 class="mt-20 chayefont">活动商品</h1>
						<p class="mt-10 mb-10">活动商品活动商品活动商品活动商品活动商品活动商品活动商品</p>
						<p class="clearfix">
							<span class="pull-left price">&yen;999.99</span>
							<span class="pull-right sell">销量：<i>888</i></span>
						</p>
					</a>
				</div>
				<div class="promotion_warpper pull-left">
					<a href="javascript:;">
						<img src="">
						<h1 class="mt-20 chayefont">活动商品</h1>
						<p class="mt-10 mb-10">活动商品活动商品活动商品活动商品活动商品活动商品活动商品</p>
						<p class="clearfix">
							<span class="pull-left price">&yen;999.99</span>
							<span class="pull-right sell">销量：<i>888</i></span>
						</p>
					</a>
				</div>
				<div class="promotion_warpper pull-left">
					<a href="javascript:;">
						<img src="">
						<h1 class="mt-20 chayefont">活动商品</h1>
						<p class="mt-10 mb-10">活动商品活动商品活动商品活动商品活动商品活动商品活动商品</p>
						<p class="clearfix">
							<span class="pull-left price">&yen;999.99</span>
							<span class="pull-right sell">销量：<i>888</i></span>
						</p>
					</a>
				</div>
			</div>
		</div>
	</div>
	@include("layouts.footer")
@endsection
