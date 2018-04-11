@extends('layouts.app')

@section('title') 帮助中心 @endsection

@section('css')
@endsection

@section('script')
    @parent

@endsection

@section('content')
@include("layouts.header-info")

@include("layouts.backIndex")
<div class="container helpcenter">
	<ul class="helpcenter_list fz-16">
		@foreach($lists as $list)
		<li class="relative mb-20">
			<a href="{{ url('home/help/detail') }}/{{$list->id}}" class="chayefont">{{$list->name}}</a>
		</li>
		@endforeach
	</ul>
</div>
@endsection
