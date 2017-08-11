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
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>
	var webType = "{{session('webType')}}";
	if (webType == 1) 
	{		
	    var uid = "{{base64_encode(Auth::user()->id)}}";
	    var jsApiList = ["onMenuShareTimeline","onMenuShareAppMessage","onMenuShareQQ","onMenuShareWeibo","onMenuShareQZone"];
	    wx.config({
	        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
	        appId: "{{isset($appid)?$appid:''}}", // 必填，公众号的唯一标识
	        timestamp: "{{isset($timestamp)?$timestamp:''}}", // 必填，生成签名的时间戳
	        nonceStr: "{{isset($noncestr)?$noncestr:''}}", // 必填，生成签名的随机串
	        signature: "{{isset($sign)?$sign:''}}",// 必填，签名，见附录1
	        jsApiList: jsApiList // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
	    });

	    wx.error(function(res){
	        alert(res)
	    });

		window.share_config = {
		    "share": {
		        "imgUrl": "http://"+window.location.host+"/fx/images/index_banner.png",//分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
		        "desc" : "代理商分享",//摘要,如果分享到朋友圈的话，不显示摘要。
		        "title" : '茶叶水果商城',//分享标题
		        "link": "http://"+window.location.host+'/bind/agent/'+ uid,//分享出去后的链接，这里可以将链接设置为另一个页面。
		        "success":function(){//分享成功后的回调函数
		        },
		        'cancel': function () { 
		            // 用户取消分享后执行的回调函数
		        }
		    }
		 };
		wx.ready(function () {
		    wx.onMenuShareAppMessage(share_config.share);//分享给好友
		    wx.onMenuShareTimeline(share_config.share);//分享到朋友圈
		    wx.onMenuShareQQ(share_config.share);//分享给手机QQ
		    wx.onMenuShareQZone(share_config.share);//分享给QQ空间
		    wx.onMenuShareWeibo(share_config.share);//分享给微博
		});
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
