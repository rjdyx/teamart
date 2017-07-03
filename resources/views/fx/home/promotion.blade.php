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
            var page = 0;
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
                var type = $(".promotion").attr('type');
                ajax('get', '/home/index/more', {page: page,type:type}).then(function (res) {
                    var template = ''
                    var data = res.data
                    if (data.length > 0) {
 						template = dataForeach(data);
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
                }).catch(function (err) {
                    prompt.message('服务器异常！请稍后再试！')
                    // me.resetload()
                    me.unlock();
                })
            }

            //遍历数据到模版
            function dataForeach(data){
            	var template = '';
            	data.forEach(function (v) {
                    template += '<div class="promotion_warpper pull-left">'+
							'<a href="http://'+window.location.host+'/home/product/detail/'+v['id']+'">' +
								'<img src="http://' + window.location.host + '/' +v['img']+'">'+
								'<h1 class="mt-20 chayefont">'+v['name']+'</h1>'
								'<p class="mt-10 mb-10">'+v['desc']+'</p>'+ '<p class="clearfix">'+
								'<span class="pull-left price">&yen;'+v['price']+'</span>'
								'<span class="pull-right sell">销量：<i>'+v['sell_amount']+
								'</i></span></p></a></div>';  
                })
                return template;
            }
        })
    </script>
@endsection

@section('content')
	@include("layouts.header-info")
	<div class="promotion" type="{{$type}}">
		<div class="promotion_container">
			<div class="promotion_list clearfix">

	
			</div>
		</div>
	</div>
	@include("layouts.footer")
@endsection
