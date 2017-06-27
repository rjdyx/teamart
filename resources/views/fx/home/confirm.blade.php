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
