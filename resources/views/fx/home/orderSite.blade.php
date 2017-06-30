@extends('layouts.app')

@section('title') 发表评论 @endsection

@section('css')
@endsection

@section('script')
    @parent
    <script>
    	$(function () {
    		// 选择自提点
    		$('.J_choose_site').on('click tap', function () {
    			$(this).addClass('active').siblings().removeClass('active')
    		})
    	})
    </script>
@endsection

@section('content')

    @include("layouts.header-info")
	<div class="ordersite">
		<div class="ordersite_map">地图</div>
		<div class="ordersite_list">
			<div class="ordersite_warp clearfix active J_choose_site">
				<i class="fa fa-map-marker"></i>
				<div class="ordersite_warp_info pull-right">
					<h1 class="mb-10">xxxxx自提点</h1>
					<p>广州市天河区华南理工大学北区国家科技园553514号</p>
				</div>
			</div>
			<div class="ordersite_warp clearfix J_choose_site">
				<i class="fa fa-map-marker"></i>
				<div class="ordersite_warp_info pull-right">
					<h1 class="mb-10">xxxxx自提点</h1>
					<p>广州市天河区华南理工大学北区国家科技园553514号</p>
				</div>
			</div>
			<div class="ordersite_warp clearfix J_choose_site">
				<i class="fa fa-map-marker"></i>
				<div class="ordersite_warp_info pull-right">
					<h1 class="mb-10">xxxxx自提点</h1>
					<p>广州市天河区华南理工大学北区国家科技园553514号</p>
				</div>
			</div>
			<div class="ordersite_warp clearfix J_choose_site">
				<i class="fa fa-map-marker"></i>
				<div class="ordersite_warp_info pull-right">
					<h1 class="mb-10">xxxxx自提点</h1>
					<p>广州市天河区华南理工大学北区国家科技园553514号</p>
				</div>
			</div>
			<div class="ordersite_warp clearfix J_choose_site">
				<i class="fa fa-map-marker"></i>
				<div class="ordersite_warp_info pull-right">
					<h1 class="mb-10">xxxxx自提点</h1>
					<p>广州市天河区华南理工大学北区国家科技园553514号</p>
				</div>
			</div>
			<div class="ordersite_warp clearfix J_choose_site">
				<i class="fa fa-map-marker"></i>
				<div class="ordersite_warp_info pull-right">
					<h1 class="mb-10">xxxxx自提点</h1>
					<p>广州市天河区华南理工大学北区国家科技园553514号</p>
				</div>
			</div>
		</div>
	</div>
@endsection