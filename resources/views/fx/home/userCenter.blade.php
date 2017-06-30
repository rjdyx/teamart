@extends('layouts.app')

@section('title') 个人中心 @endsection

@section('css')
@endsection

@section('script')
	@parent
	<script>
	$(function () {
		$(".J_loginout").on('click tap', function () {
			ajax('get', '/layout')
				.then(function (resolve) {
					prompt.message('退出成功', 'http://' + window.location.host)
				})
		})
	})
	</script>
@endsection

@section('content')

	@include("layouts.header-info")
	<!-- 内容 -->
	<div class="container usercenter">
		<div class="usercenter_info">
			<div class="usercenter_avatar">
				<img src="{{url('')}}/@if(Auth::user()){{Auth::user()->img}} @endif" alt="">
			</div>
			<p class="usercenter_name chayefont">@if(Auth::user()){{Auth::user()->name}} @endif</p>
			<ul class="usercenter_list">
				<li>
					<a href="javascript:;">
						<p>积分</p>
						<p>@if(Auth::user()) ({{Auth::user()->grade}}) @else (0) @endif</p>
					</a>
				</li>
				<li>
					<a href="javascript:;">
						<p>所属身份</p>
						<p>@if(Auth::user())
							@if (Auth::user()->type < 2) 分销商 @else 普通会员 @endif
						 @endif
						 </p>
					</a>
				</li>
				<li>
					<a href="javascript:;">
						<p>消费总额</p>
						<p>({{$prices}})</p>
					</a>
				</li>
			</ul>
		</div>
		@if (isset(Auth::user()->type) && Auth::user()->type < 2)
		<div class="usercenter_assets">
			<ol>
				<li class="chayefont">累计佣金：</li>
				<li class="chayefont red">{{sprintf('%.2f', $sells)}}元</li>
				<li class="chayefont">
					<a href="javascript:;" class="pull-right withdraw">提现</a>
				</li>
			</ol>
		</div>
		@endif
		<ul class="usercenter_nav clearfix">
			<li>
				<a href="{{url('/home/useredit')}}">
					<div class="usercenter_nav_icon">
						<i class="fa fa-pencil"></i>
					</div>
					<p class="chayefont">我的账号</p>
				</a>
			</li>
			@if (isset(Auth::user()->type) && Auth::user()->type < 2)
			<li>
				<a href="{{url('/home/userasset')}}">
					<div class="usercenter_nav_icon">
						<i class="fa fa-users"></i>
					</div>
					<p class="chayefont">我的分销</p>
				</a>
			</li>
			@endif
			<li>
				<a href="{{url('/home/order/list')}}">
					<div class="usercenter_nav_icon">
						<i class="fa fa-credit-card"></i>
					</div>
					<p class="chayefont">我的订单</p>
				</a>
			</li>
			<li>
				<a href="{{url('/home/help/list')}}">
					<div class="usercenter_nav_icon">
						<i class="fa fa-info"></i>
					</div>
					<p class="chayefont">帮助中心</p>
				</a>
			</li>
			<li>
				<a href="{{url('/home/collect')}}">
					<div class="usercenter_nav_icon">
						<i class="fa fa-star"></i>
					</div>
					<p class="chayefont">我的收藏</p>
				</a>
			</li>
			<li>
				<a href="{{url('/home/address')}}">
					<div class="usercenter_nav_icon">
						<i class="fa fa-location-arrow"></i>
					</div>
					<p class="chayefont">收货地址</p>
				</a>
			</li>
		</ul>
		@if (Auth::user())
		<div class="usercenter_loginout chayefont J_loginout">退出</div>
		@else
		<a href="{{url('/login')}}"><div class="usercenter_loginout chayefont">登录</div></a>
		@endif
	</div>
	@include("layouts.footer")
@endsection
