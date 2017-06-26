@extends('layouts.app')

@section('title') 个人资产 @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/css/personalAssets.css') }}">
@endsection

@section('script')
    @parent

@endsection

@section('content')

    @include("layouts.header-info")
    <div class="container userassets"></div>
	<div class="personal_assets_content">

		<div class="personal_assets_img_Bamboo">
			<div class="personal_assets_head_photo">
				<div class="img_background_shadow"></div>
			  	<div class="personal_assets_img_BlackCircle"></div>
			</div>
			<div class="personal_assets_two_name">
				<div class="personal_assets_name">王宝强</div>
		 		<div class="personal_assets_name" id="personal_assets_recommend_name">推荐人：隔壁老王</div>
			</div>
		</div>


		<div class="personal_assets_div_list">
			<ul>
				<li id="personal_assets_list_one" class="personal_assets_list">
					<span class="personal_assets_list_span">累计佣金：</span>
					<div class="personal_assets_list_modify_div" id="personal_assets_list_button1">记录</div>
				</li>

				<li class="personal_assets_list">
					<span class="personal_assets_list_span">可提现余额：</span>
					<div class="personal_assets_list_modify_div" id="personal_assets_list_button2">提现</div>
				</li>

				<li class="personal_assets_list">
					<span class="personal_assets_list_span">支付密码管理：</span>
					<div class="personal_assets_list_modify_div" id="personal_assets_list_button3">设置修改</div>
				</li>
			</ul>
		</div>
	</div>
@endsection
