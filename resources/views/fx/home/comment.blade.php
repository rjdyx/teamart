@extends('layouts.app')

@section('title') 发表评论 @endsection

@section('css')
@endsection

@section('script')
    @parent
@endsection

@section('content')

    @include("layouts.header-info")
	<div class="comment"></div>
@endsection
