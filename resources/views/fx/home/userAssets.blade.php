@extends('layouts.app')

@section('title') 个人资产 @endsection
	<link rel="stylesheet" type="text/css" href="{{ asset('fx/css/dropload.css') }}">
@section('css')
@endsection

@section('script')
    @parent
    <script type="text/javascript" src="{{ url('fx/common/dropload.js') }}"></script>
	<script>
		var page = 0
		// 加载
        $('.userassets_container').dropload({
            scrollArea : $('.userassets_container'),
            domDown : {
                domClass   : 'dropload-down',
                domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
                domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
                domNoData  : '<div class="dropload-noData">没有更多数据了</div>'
            },
            loadDownFn : function (me) {
            	getListData(me)
            },
            threshold : 50
        })
		function getListData (me) {
			page++
			ajax('get', '/ddd', {page: page}, false, false, false)
				.then(function (res) {
					var result = ''
					if (res.data.length > 0) {
						res.data.forEach(function (v) {
							result += `
								<div class="userassets_container_warpper">
									<ul class="clearfix">
										<li class="pull-left">
											<p>总金额</p>
											<p>888.00</p>
										</li>
										<li class="pull-left">
											<p>佣金比</p>
											<p>0.2</p>
										</li>
										<li class="pull-left">
											<p>订单数量</p>
											<p>888</p>
										</li>
										<li class="pull-left">
											<p>实际金额</p>
											<p>88</p>
										</li>
										<li class="pull-left">
											<p>未结清余额</p>
											<p>8.88</p>
										</li>
									</ul>
									<p class="mt-10 txt-r">结账日期：0000-00-00</p>
								</div>
							`
						})
					} else {
						me.lock();
                        me.noData();
					}
					$('.collect_list').append(result);
                    me.resetload();
				})
				.catch(function (err) {
					prompt.message('请求错误')
					// me.resetload()
				})
		}
	</script>
@endsection

@section('content')

    @include("layouts.header-info")

    @include("layouts.backIndex")
    <div class="userassets">
    	<div class="userassets_info">
			<div class="userassets_avatar">
				<img src="{{url('')}}/@if(Auth::user()){{Auth::user()->img}} @endif" alt="">
			</div>
			<p class="userassets_name chayefont">@if(Auth::user()){{Auth::user()->name}} @endif</p>
		</div>
		<div class="userassets_content mt-20">
			<div class="userassets_content_row">
				<span class="pull-left chayefont">佣金累计：</span>
				<a href="javascript:;" class="pull-right chayefont orange">&yen {{$allprices}}</a>
			</div>
			<div class="userassets_content_row">
				<span class="pull-left chayefont">佣金余额：</span>
				<a href="javascript:;" class="pull-right chayefont orange">&yen {{$prices}}</a>
			</div>
			<div class="userassets_container mt-20">
				<div class="userassets_list">
					<div class="userassets_container_warpper">
						<ul class="clearfix">
							<li class="pull-left">
								<p>总金额</p>
								<p>888.00</p>
							</li>
							<li class="pull-left">
								<p>佣金比</p>
								<p>0.2</p>
							</li>
							<li class="pull-left">
								<p>订单数量</p>
								<p>888</p>
							</li>
							<li class="pull-left">
								<p>实际金额</p>
								<p>88</p>
							</li>
							<li class="pull-left">
								<p>未结清余额</p>
								<p>8.88</p>
							</li>
						</ul>
						<p class="mt-10 txt-r">结账日期：0000-00-00</p>
					</div>
					<div class="userassets_container_warpper">
						<ul class="clearfix">
							<li class="pull-left">
								<p>总金额</p>
								<p>888.00</p>
							</li>
							<li class="pull-left">
								<p>佣金比</p>
								<p>0.2</p>
							</li>
							<li class="pull-left">
								<p>订单数量</p>
								<p>888</p>
							</li>
							<li class="pull-left">
								<p>实际金额</p>
								<p>88</p>
							</li>
							<li class="pull-left">
								<p>未结清余额</p>
								<p>8.88</p>
							</li>
						</ul>
						<p class="mt-10 txt-r">结账日期：0000-00-00</p>
					</div>
					<div class="userassets_container_warpper">
						<ul class="clearfix">
							<li class="pull-left">
								<p>总金额</p>
								<p>888.00</p>
							</li>
							<li class="pull-left">
								<p>佣金比</p>
								<p>0.2</p>
							</li>
							<li class="pull-left">
								<p>订单数量</p>
								<p>888</p>
							</li>
							<li class="pull-left">
								<p>实际金额</p>
								<p>88</p>
							</li>
							<li class="pull-left">
								<p>未结清余额</p>
								<p>8.88</p>
							</li>
						</ul>
						<p class="mt-10 txt-r">结账日期：0000-00-00</p>
					</div>
					<div class="userassets_container_warpper">
						<ul class="clearfix">
							<li class="pull-left">
								<p>总金额</p>
								<p>888.00</p>
							</li>
							<li class="pull-left">
								<p>佣金比</p>
								<p>0.2</p>
							</li>
							<li class="pull-left">
								<p>订单数量</p>
								<p>888</p>
							</li>
							<li class="pull-left">
								<p>实际金额</p>
								<p>88</p>
							</li>
							<li class="pull-left">
								<p>未结清余额</p>
								<p>8.88</p>
							</li>
						</ul>
						<p class="mt-10 txt-r">结账日期：0000-00-00</p>
					</div>
					<div class="userassets_container_warpper">
						<ul class="clearfix">
							<li class="pull-left">
								<p>总金额</p>
								<p>888.00</p>
							</li>
							<li class="pull-left">
								<p>佣金比</p>
								<p>0.2</p>
							</li>
							<li class="pull-left">
								<p>订单数量</p>
								<p>888</p>
							</li>
							<li class="pull-left">
								<p>实际金额</p>
								<p>88</p>
							</li>
							<li class="pull-left">
								<p>未结清余额</p>
								<p>8.88</p>
							</li>
						</ul>
						<p class="mt-10 txt-r">结账日期：0000-00-00</p>
					</div>
					<div class="userassets_container_warpper">
						<ul class="clearfix">
							<li class="pull-left">
								<p>总金额</p>
								<p>888.00</p>
							</li>
							<li class="pull-left">
								<p>佣金比</p>
								<p>0.2</p>
							</li>
							<li class="pull-left">
								<p>订单数量</p>
								<p>888</p>
							</li>
							<li class="pull-left">
								<p>实际金额</p>
								<p>88</p>
							</li>
							<li class="pull-left">
								<p>未结清余额</p>
								<p>8.88</p>
							</li>
						</ul>
						<p class="mt-10 txt-r">结账日期：0000-00-00</p>
					</div>
					<div class="userassets_container_warpper">
						<ul class="clearfix">
							<li class="pull-left">
								<p>总金额</p>
								<p>888.00</p>
							</li>
							<li class="pull-left">
								<p>佣金比</p>
								<p>0.2</p>
							</li>
							<li class="pull-left">
								<p>订单数量</p>
								<p>888</p>
							</li>
							<li class="pull-left">
								<p>实际金额</p>
								<p>88</p>
							</li>
							<li class="pull-left">
								<p>未结清余额</p>
								<p>8.88</p>
							</li>
						</ul>
						<p class="mt-10 txt-r">结账日期：0000-00-00</p>
					</div>
					<div class="userassets_container_warpper">
						<ul class="clearfix">
							<li class="pull-left">
								<p>总金额</p>
								<p>888.00</p>
							</li>
							<li class="pull-left">
								<p>佣金比</p>
								<p>0.2</p>
							</li>
							<li class="pull-left">
								<p>订单数量</p>
								<p>888</p>
							</li>
							<li class="pull-left">
								<p>实际金额</p>
								<p>88</p>
							</li>
							<li class="pull-left">
								<p>未结清余额</p>
								<p>8.88</p>
							</li>
						</ul>
						<p class="mt-10 txt-r">结账日期：0000-00-00</p>
					</div>
				</div>
			</div>
		</div>
    </div>
@endsection
