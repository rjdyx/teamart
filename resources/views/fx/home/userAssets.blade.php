@extends('layouts.app')

@section('title') 个人资产 @endsection

@section('css')
@endsection

@section('script')
    @parent

@endsection

@section('content')

    @include("layouts.header-info")
    <div class="userassets">
    	<div class="userassets_info">
			<div class="userassets_avatar">
				<img src="{{url('')}}/@if(Auth::user()){{Auth::user()->img}} @endif" alt="">
			</div>
			<p class="userassets_name chayefont">@if(Auth::user()){{Auth::user()->name}} @endif</p>
			<p class="userassets_name chayefont fz-18">推荐人：@if(Auth::user()){{Auth::user()->name}} @endif</p>
		</div>
		<div class="userassets_content mt-20">
			<div class="userassets_content_row">
				<span class="pull-left chayefont">累计佣金：</span>
				<a href="javascript:;" class="pull-right chayefont">记录</a>
			</div>
			<div class="userassets_content_row">
				<span class="pull-left chayefont">可提现余额：</span>
				<a href="javascript:;" class="pull-right chayefont orange">提现</a>
			</div>
			<div class="userassets_content_row">
				<span class="pull-left chayefont">支付密码管理：</span>
				<a href="javascript:;" class="pull-right chayefont orange">设置修改</a>
			</div>
		</div>
    </div>
@endsection
