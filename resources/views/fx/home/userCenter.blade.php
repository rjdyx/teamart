@extends('layouts.app')

@section('title') 个人中心 @endsection

@section('css')
@endsection

@section('script')
	@parent
	<script src="{{url('/fx/js/qrcode.js')}}"></script>
	<script>
	$(function () {

		// navigator.getUserMedia
		// navigator.mediaDevices.getUserMedia({
		// 	audio: false,
		// 	video: {
		// 		width: { min: 1024, ideal: 1280, max: 1920 },
		// 		height: { min: 776, ideal: 720, max: 1080 }
		// 	}
		// })
		// .then(function(mediaStream) {
		// 	console.dir(mediaStream)
		// })
		// .catch(function(error) {
		// 	console.log(error)
		// })
		// 生成二维码
		setTimeout(function () {
			var uid = $('.J_QRcode').attr('uid');
			var qrcode = new QRCode(document.getElementById("qrcode"), {
			    text: "http://"+window.location.host+'/bind/agent/'+ uid,
			    width: 512,
			    height: 512
			})
		}, 200)

		// 账号退出
		$(".J_loginout").on('tap', function () {
			prompt.question('是否退出？', function () {
				ajax('get', '/layout').then(function (resolve) {
					prompt.message('退出成功', 'http://' + window.location.host)
				})
			})
		})

		// 解除绑定退出
		$(".J_loginout_wx").on('tap', function () {
			prompt.question('是否解除绑定？', function () {
				ajax('get', '/bind/weixin/relieve').then(function (res) {
					if (res) {
						prompt.message('解除绑定成功', 'http://' + window.location.host)
					} else {
						prompt.message('解除绑定失败')
					}
				})
			})
		})

		// 显示二维码
		$('.J_QRcode').on('tap', function () {
			prompt.qrcode()
		})

		// 扫描二维码
		$('.J_getQRcode').on('tap', function () {
			// prompt.qrcode()
		})
	})
	</script>
@endsection

@section('content')

	@include("layouts.header-info")
	<?php 
		$img = '';
		if (Auth::user()) {
			$img = Auth::user()->img;
			if (!strstr($img,'http') && !empty($img)) $img = url('').'/'.$img;
		}
	?>
	<!-- 内容 -->
	<div class="container usercenter">
		<div class="usercenter_info relative">
			<div class="avatar @if(Auth::user() && Auth::user()->type == 1) J_QRcode @else J_getQRcode @endif" uid="@if(Auth::user() && Auth::user()->type == 1) {{base64_encode(Auth::user()->id)}} @endif">
			
				<img class="w-100" src="{{$img}}" alt="">
			</div>
			<p class="usercenter_name white fz-20 txt-c chayefont">@if(Auth::user()){{Auth::user()->name}} @endif</p>
			<ul class="usercenter_list w-100">
				<li class="relative pull-left txt-c">
					<a href="javascript:;" class="white">
						<p>积分</p>
						<p>@if(Auth::user()) ({{Auth::user()->grade}}) @else (0) @endif</p>
					</a>
				</li>
				<li class="relative pull-left txt-c">
					<a href="javascript:;" class="white">
						<p>所属身份</p>
						<p>
						@if(Auth::user())
							@if (Auth::user()->type == 1) 分销商 @else 普通会员 @endif
						@else
							无
						@endif
						 </p>
					</a>
				</li>
				<li class="relative pull-left txt-c">
					<a href="javascript:;" class="white">
						<p>消费总额</p>
						<p>({{$prices}})</p>
					</a>
				</li>
			</ul>
		</div>
		@if (isset(Auth::user()->type) && Auth::user()->type < 2)
		<div class="usercenter_assets w-100 mt-10">
			<ol class="w-100">
				<li class="chayefont pull-left fz-14">累计佣金：</li>
				<li class="chayefont pull-left fz-14 price">{{sprintf('%.2f', $sells)}}元</li>
				<li class="chayefont pull-left fz-14">
					<a href="{{url('/home/userasset')}}" class="pull-right block fz-16 mt-10 white withdraw">详细</a>
				</li>
			</ol>
		</div>
		@endif
		<ul class="usercenter_nav clearfix w-100 mt-10">
			<li class="pull-left txt-c">
				<a href="{{url('/home/useredit')}}">
					<div class="txt-c usercenter_nav_icon">
						<i class="fa fa-pencil white fz-20"></i>
					</div>
					<p class="chayefont fz-14">我的账号</p>
				</a>
			</li>
			@if (isset(Auth::user()->type) && Auth::user()->type < 2)
			<li class="pull-left txt-c">
				<a href="{{url('/home/userasset')}}">
					<div class="txt-c usercenter_nav_icon">
						<i class="fa fa-users white fz-20"></i>
					</div>
					<p class="chayefont fz-14">我的分销</p>
				</a>
			</li>
			@endif
			<li class="pull-left txt-c">
				<a href="{{url('/home/order/list')}}">
					<div class="txt-c usercenter_nav_icon">
						<i class="fa fa-credit-card white fz-20"></i>
					</div>
					<p class="chayefont fz-14">我的订单</p>
				</a>
			</li>
			<li class="pull-left txt-c">
				<a href="{{url('/home/help/list')}}">
					<div class="txt-c usercenter_nav_icon">
						<i class="fa fa-info white fz-20"></i>
					</div>
					<p class="chayefont fz-14">帮助中心</p>
				</a>
			</li>
			<li class="pull-left txt-c">
				<a href="{{url('/home/collect')}}">
					<div class="txt-c usercenter_nav_icon">
						<i class="fa fa-star white fz-20"></i>
					</div>
					<p class="chayefont fz-14">我的收藏</p>
				</a>
			</li>
			<li class="pull-left txt-c">
				<a href="{{url('/home/address')}}">
					<div class="txt-c usercenter_nav_icon">
						<i class="fa fa-location-arrow white fz-20"></i>
					</div>
					<p class="chayefont fz-14">收货地址</p>
				</a>
			</li>
			<li class="pull-left txt-c">
				<a href="{{url('/home/site')}}">
					<div class="txt-c usercenter_nav_icon">
						<i class="fa fa-map-marker white fz-20"></i>
					</div>
					<p class="chayefont fz-14">查看站点</p>
				</a>
			</li>
			<li class="pull-left txt-c">
				<a href="{{url('/home/activity/roll')}}">
					<div class="txt-c usercenter_nav_icon">
						<i class="fa fa-ticket white fz-20"></i>
					</div>
					<p class="chayefont fz-14">优惠券</p>
				</a>
			</li>
			<li class="pull-left txt-c">
				<a href="{{url('/home/feedback')}}">
					<div class="txt-c usercenter_nav_icon">
						<i class="fa fa-feed white fz-20"></i>
					</div>
					<p class="chayefont fz-14">意见反馈</p>
				</a>
			</li>
		</ul>
		@if (Auth::user())
			@if (session('webType') == 1)
				<div class="usercenter_loginout txt-c fz-18 white chayefont J_loginout_wx">解除绑定</div>
			@endif
			@if (session('webType') < 1)
				<div class="usercenter_loginout txt-c fz-18 white chayefont J_loginout">退出</div>
			@endif

		@else
			<a href="{{url('/login')}}"><div class="usercenter_loginout txt-c fz-18 white chayefont">登录</div></a>
			<a href="{{url('/register')}}"><div class="usercenter_loginout txt-c fz-18 white chayefont">注册</div></a>
		@endif

	</div>
	@include("layouts.footer")
@endsection
