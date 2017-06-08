@extends('layouts.app')

@section('title') 个人资料 @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/css/personalInformation.css') }}">
@endsection

@section('script')
    @parent

@endsection

@section('content')

    @include("layouts.header-info")
	<!-- 内容 -->
	<div class="personal_info_content">
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
		
		<div class="personal_info_div_list">
			<ul>
				<li id="personal_info_list_one" class="personal_info_list">
					<span class="personal_info_list_span">姓名：</span>
					<div class="personal_info_list_modify_div">
						<input class="personal_info_list_input" type="text" name="" placeholder="天王盖地虎">
					</div>
				</li>

				<li class="personal_info_list">
					<span class="personal_info_list_span">性别：</span>
					<div class="personal_info_list_modify_div">
						<select class="personal_info_list_select">
							<option selected="true">男</option>
							<option>女</option>
						</select>
					</div>
				</li>

				<li class="personal_info_list">
					<span class="personal_info_list_span">手机：</span>
					<div class="personal_info_list_modify_div">
						<input class="personal_info_list_input" type="text" name="" placeholder="13560449011">
					</div>
				</li>

				<li class="personal_info_list">
					<span class="personal_info_list_span">QQ：</span>
					<div class="personal_info_list_modify_div">
						<input class="personal_info_list_input" type="text" name="" placeholder="455010903">
					</div>
				</li>

				<li class="personal_info_list">
					<span class="personal_info_list_span">生日：</span>
					<div class="personal_info_list_modify_div">
						<select class="personal_info_list_select">
							<option selected="true">男</option>
							<option>女</option>
						</select>
					</div>
				</li>

				<li class="personal_info_list">
					<span class="personal_info_list_span">绑定手机号：</span>
					<div class="personal_info_list_modify_div">
						<input id="personal_info_list_last" class="personal_info_list_input" type="text" name="" placeholder="未绑定">
					</div>
				</li>
			</ul>
		</div>
	</div>
	
	<!-- 底部 -->
	<div class="bottom2">确定保存</div>
@endsection

