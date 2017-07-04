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
		</div>
		<div class="userassets_content mt-20">
			<div class="userassets_content_row">
				<span class="pull-left chayefont">佣金累计：</span>
				<a href="javascript:;" class="pull-right chayefont orange">&yen {{$allprices}}</a>
			</div>
			<div class="userassets_content_row">
				<span class="pull-left chayefont">佣金余额：</span>
				<a href="javascript:;" class="pull-right chayefont orange">&yen {{$prices}}</a>
			</div>
		</div>
    </div>
@endsection
