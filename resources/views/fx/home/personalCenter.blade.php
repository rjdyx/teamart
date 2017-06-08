@extends('layouts.app')

@section('title') 个人中心 @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/css/personalCenter.css') }}">
@endsection

@section('script')
    @parent

@endsection

@section('content')

    @include("layouts.header-info")
	<!-- 内容 -->
	<div class="personal_center_content">
		<div class="personal_center_img_Bamboo">
			<div class="personal_center_head_photo"></div>
			<div class="personal_center_name">周星驰</div>
			<div class="personal_center_toolbar">
				<ul class="list_box">
					<li class="personal_center_toolbar_block">
						<div class="personal_center_toolbar_block_content">积分</div>
						<div class="personal_center_toolbar_block_content" id="personal_center_toolbar_integral">
							(0)
						</div>
					</li>
					<li class="personal_center_toolbar_block">
						<div class="personal_center_toolbar_block_content">所属身份</div>
						<div class="personal_center_toolbar_block_content" id="personal_center_toolbar_id">
							(经销商)
						</div>
					</li>
					<li class="personal_center_toolbar_block">
						<div class="personal_center_toolbar_block_content">消费总额</div>
						<div class="personal_center_toolbar_block_content" id="personal_center_toolbar_consumption">
							(0)
						</div>
					</li>
				</ul>
			</div>	
		</div>

		<div class="personal_center_div_list">
			<ul class="list_box">
				<li id="personal_center_list_one" class="personal_center_list">
					<span class="personal_center_list_span">累计佣金：</span>
					<div id="personal_center_commission">5000.00元</div>
					<div class="personal_center_list_modify_div" id="personal_center_list_button1"></div>
				</li>

				<li class="personal_center_list">
					<span class="personal_center_list_span">可提现余额：</span>
					<div id="personal_center_balance">2000.00元</div>
					<div class="personal_center_list_modify_div" id="personal_center_list_button2">
					提现
						<!-- <input type="button" value="提现" class="personal_center_list_button" id="personal_center_list_button2"> -->
					</div>
				</li>
			</ul>
		</div>

		<div class="personal_center_div_block">
			<ul class="list_box">
				<li class="personal_center_block">
					<div id="personal_center_blackPoint1"></div>
					<div class="personal_center_block_p">我的账号</div>
				</li>
				<li class="personal_center_block">
					<div id="personal_center_blackPoint2"></div>
					<div class=""></div>
					<div class="personal_center_block_p">我的分组</div>
				</li>
				<li class="personal_center_block">
					<div id="personal_center_blackPoint3"></div>
					<div class="personal_center_block_p">我的订单</div>
				</li>
			</ul>
			<ul class="list_box">
				<li class="personal_center_block">
					<div id="personal_center_blackPoint4"></div>
					<div class="personal_center_block_p">帮助中心</div>
				</li>
				<li class="personal_center_block">
					<div id="personal_center_blackPoint5"></div>
					<div class="personal_center_block_p">我的二维码</div>
				</li>
				<li class="personal_center_block">
					<div id="personal_center_blackPoint6"></div>
					<div class="personal_center_block_p">收货地址</div>
				</li>
			</ul>
		</div>
	</div>
    @include("layouts.footer")
@endsection
