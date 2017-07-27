@extends('layouts.app')

@section('title') 个人资产 @endsection
@section('css')
@endsection

@section('script')
    @parent
    <script type="text/javascript" src="{{ url('fx/js/dropload.min.js') }}"></script>
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
			ajax('get', '/home/userasset/brokerage/data', {page: page}).then(function (res) {
					var result = ''
					if (res.data.length > 0) {
						res.data.forEach(function (v) {
							result += `
								<div class="userassets_container_warpper w-100 p-10">
									<ul class="clearfix w-100">
										<li class="pull-left txt-c">
											<p>总金额</p>
											<p>&yen; ${v.count}</p>
										</li>
										<li class="pull-left txt-c">
											<p>佣金比</p>
											<p>${v.scale}</p>
										</li>
										<li class="pull-left txt-c">
											<p>订单数量</p>
											<p>${v.amount}</p>
										</li>
										<li class="pull-left txt-c">
											<p>实际金额</p>
											<p>&yen; ${v.price}</p>
										</li>
										<li class="pull-left txt-c">
											<p>未结清余额</p>
											<p>&yen; ${v.remain}</p>
										</li>
									</ul>
									<p class="mt-10 txt-r">结账日期：${v.date}</p>
								</div>
							`
						})
					} else {
						me.lock();
                        me.noData();
                        if (page == 1) {
                            $('.dropload-down').hide()
                            $('.userassets_container').find('.list_nodata').remove()
                            $('.userassets_container').append(`
                            <div class="list_nodata txt-c">
                                暂无记录
                            </div>`)
                        }
					}
					$('.userassets_list').append(result);
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
    <div class="container userassets">
    	<div class="userassets_info relative">
			<div class="avatar">
				<img class="w-100" src="{{url('')}}/@if(Auth::user()){{Auth::user()->img}} @endif" alt="">
			</div>
			<p class="userassets_name white fz-20 txt-c chayefont">@if(Auth::user()){{Auth::user()->name}} @endif</p>
		</div>
		<div class="userassets_content mt-20 w-100">
			<div class="userassets_content_row w-100">
				<span class="pull-left chayefont">佣金累计：</span>
				<a href="javascript:;" class="pull-right block chayefont txt-c price">&yen; {{$allprices}}</a>
			</div>
			<div class="userassets_content_row w-100">
				<span class="pull-left chayefont">佣金余额：</span>
				<a href="javascript:;" class="pull-right block chayefont txt-c price">&yen; {{$prices}}</a>
			</div>
			<div class="userassets_container mt-20 w-100">
				<div class="userassets_list">

				</div>
			</div>
		</div>
    </div>
@endsection
