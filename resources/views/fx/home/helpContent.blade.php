@extends('layouts.app')

@section('title') 帮助中心 @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/css/helpCenter_TeaCeremony.css') }}">
@endsection

@section('script')
    @parent

@endsection

@section('content')

	@include("layouts.header-info")
	<div class="helpCenter_TeaCeremony_body">
		<img src="{{ url('fx/img/helpCenter_TeaCeremony.png') }}">
	</div>
@endsection
