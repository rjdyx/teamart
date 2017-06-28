@extends('layouts.app')

@section('title') 帮助中心 @endsection

@section('css')
@endsection

@section('script')
    @parent

@endsection

@section('content')
@include("layouts.header-info")
<div class="helpcenter">
	<ul class="helpcenter_list">
		@foreach($lists as $list)
		<li>
			<a href="{{ url('home/help/detail') }}/{{$list->id}}" class="chayefont">{{$list->name}}</a>
		</li>
		@endforeach
	</ul>
</div>
@endsection
