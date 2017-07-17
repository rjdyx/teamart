@extends('layouts.app')

@section('title') 帮助中心 @endsection

@section('css')
<style>
	.content{
		background: url('/fx/images/article_bg.png');
		background-size: 100%;width:100%;height:100%;
		padding:20px 15px 20px 15px;margin-top:58px;
	}	
</style>
@endsection

@section('script')
@parent

@endsection

@section('content')

@include("layouts.header-info")

@include("layouts.backIndex")
<!-- <div class="container helpdetail"> {!! $con !!} </div> -->
<div class="content"> {!! $con !!} </div>
@endsection
