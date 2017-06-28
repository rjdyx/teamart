@extends('layouts.app')

@section('title') 地址管理 @endsection

@section('css')
@endsection

@section('script')
    @parent
@endsection

@section('content')
	@include("layouts.header-info")
	<div class="confirm">
		<div class="confirm_address mb-20 express">
			<a href="javascript:;" class="clearfix">
				<i class="fa fa-map-marker pull-left"></i>
				<div class="confirm_address_info pull-left">
					<p class="clearfix">
						<span class="pull-left chayefont fz-16">隔壁老王</span>
						<span class="pull-right gray">13912345678</span>
					</p>
					<p class="gray">广东省广州市天河区五山街道华南理工大学国家大学科技园2号楼204</p>
				</div>
				<i class="fa fa-angle-right pull-right txt-r"></i>
			</a>
		</div>
		<div class="confirm_address mb-20 point hide">
			<a href="javascript:;" class="clearfix">
				<i class="fa fa-map-marker pull-left"></i>
				<div class="confirm_address_info pull-left">
					<p>(请选择)自提点</p>
					<p class="gray">广东省广州市天河区五山街道华南理工大学国家大学科技园2号楼204</p>
				</div>
				<i class="fa fa-angle-right pull-right txt-r"></i>
			</a>
		</div>
		<div class="confirm_container">
			<div class="confirm_warpper mb-20">
				<div class="confirm_warpper_tit">
					<a href="javascript:;" class="chayefont">
						<i class="fa fa-ban"></i>
						绿茶宝塔镇河妖
					</a>
				</div>
				<div class="confirm_warpper_content clearfix">
					<div class="confirm_warpper_content_img pull-left mr-20">
						<img src="{{ url('fx/img/shop11.png') }}">
					</div>
					<div class="confirm_warpper_content_info pull-right">
						<h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
						<p>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
						<div class="confirm_warpper_content_info_bottom">
							<span class="pull-left price">￥212.00</span>
							<span class="pull-right sell">&times1</span>
						</div>
					</div>
				</div>
			</div>
			<div class="confirm_warpper mb-20">
				<div class="confirm_warpper_tit">
					<a href="javascript:;" class="chayefont">
						<i class="fa fa-ban"></i>
						绿茶宝塔镇河妖
					</a>
				</div>
				<div class="confirm_warpper_content clearfix">
					<div class="confirm_warpper_content_img pull-left mr-20">
						<img src="{{ url('fx/img/shop11.png') }}">
					</div>
					<div class="confirm_warpper_content_info pull-right">
						<h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
						<p>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
						<div class="confirm_warpper_content_info_bottom">
							<span class="pull-left price">￥212.00</span>
							<span class="pull-right sell">&times1</span>
						</div>
					</div>
				</div>
			</div>
			<div class="confirm_warpper mb-20">
				<div class="confirm_warpper_tit">
					<a href="javascript:;" class="chayefont">
						<i class="fa fa-ban"></i>
						绿茶宝塔镇河妖
					</a>
				</div>
				<div class="confirm_warpper_content clearfix">
					<div class="confirm_warpper_content_img pull-left mr-20">
						<img src="{{ url('fx/img/shop11.png') }}">
					</div>
					<div class="confirm_warpper_content_info pull-right">
						<h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
						<p>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
						<div class="confirm_warpper_content_info_bottom">
							<span class="pull-left price">￥212.00</span>
							<span class="pull-right sell">&times1</span>
						</div>
					</div>
				</div>
			</div>
			<div class="confirm_warpper mb-20">
				<div class="confirm_warpper_tit">
					<a href="javascript:;" class="chayefont">
						<i class="fa fa-ban"></i>
						绿茶宝塔镇河妖
					</a>
				</div>
				<div class="confirm_warpper_content clearfix">
					<div class="confirm_warpper_content_img pull-left mr-20">
						<img src="{{ url('fx/img/shop11.png') }}">
					</div>
					<div class="confirm_warpper_content_info pull-right">
						<h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
						<p>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
						<div class="confirm_warpper_content_info_bottom">
							<span class="pull-left price">￥212.00</span>
							<span class="pull-right sell">&times1</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="confirm_bottom">
			<div class="confirm_bottom_sum pull-left">
				合计总金额：<span class="price">&yen212.00</span>
			</div>
			<div class="confirm_bottom_submit pull-left">
				<a href="javascript:;">提交订单</a>
			</div>
		</div>
	</div>

@endsection
