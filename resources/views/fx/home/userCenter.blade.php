@extends('layouts.app')

@section('title') 个人中心 @endsection

@section('css')
@endsection

@section('script')
    @parent
@endsection

@section('content')

    @include("layouts.header-info")
	<!-- 内容 -->
	<div class="container usercenter">
		<div class="usercenter_info">
			<div class="usercenter_avatar">
				<img src="/fx/images/usercenter_avatar.png" alt="">
			</div>
			<p class="usercenter_name chayefont">DDD</p>
			<ul class="usercenter_list">
				<li>
					<a href="javascript:;">
						<p>积分</p>
						<p>(0)</p>
					</a>
				</li>
				<li>
					<a href="javascript:;">
						<p>所属身份</p>
						<p>分销商</p>
					</a>
				</li>
				<li>
					<a href="javascript:;">
						<p>消费总额</p>
						<p>(0)</p>
					</a>
				</li>
			</ul>
		</div>
		<div class="usercenter_assets">
			<ol>
				<li class="chayefont">累计佣金：</li>
				<li class="chayefont gray">9999.00元</li>
				<li class="chayefont">
					<a href="javascript:;" class="pull-right">
						<i class="fa fa-angle-right"></i>
					</a>
				</li>
			</ol>
			<ol>
				<li class="chayefont">累计佣金：</li>
				<li class="chayefont red">9999.00元</li>
				<li class="chayefont">
					<a href="javascript:;" class="pull-right withdraw">提现</a>
				</li>
			</ol>
		</div>
		<ul class="usercenter_nav clearfix">
			<li>
				<a href="{{url('/home/useredit')}}">
					<div class="usercenter_nav_icon">
						<i class="fa fa-pencil"></i>
					</div>
					<p class="chayefont">我的账号</p>
				</a>
			</li>
			<li>
				<a href="{{url('/home/userasset')}}">
					<div class="usercenter_nav_icon">
						<i class="fa fa-users"></i>
					</div>
					<p class="chayefont">我的分销</p>
				</a>
			</li>
			<li>
				<a href="javascript:;">
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
				<a href="javascript:;">
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
		<div class="usercenter_loginout chayefont">退出</div>
	</div>
    @include("layouts.footer")
@endsection
