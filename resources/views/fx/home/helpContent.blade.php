@extends('layouts.app')

@section('title') 帮助中心 @endsection

@section('css')
@endsection

@section('script')
@parent

@endsection

@section('content')

@include("layouts.header-info")
<div class="container helpdetail">
	{!! $con !!}
</div>
@endsection
