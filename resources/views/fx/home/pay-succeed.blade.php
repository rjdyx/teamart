@extends('layouts.app')

@section('title') 支付成功 @endsection

@section('css')
@endsection

@section('script')
    @parent
@endsection

@section('content')
	@include("layouts.header-info")
	<p style="font-size:18px;text-align: center;">订单号</p>
	<p style="font-size:18px;text-align: center;">支付金额</p>
	<p style="font-size:18px;text-align: center;">支付单位</p>

@endsection