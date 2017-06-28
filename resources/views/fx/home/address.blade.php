@extends('layouts.app')

@section('title') 地址管理 @endsection

@section('css')
@endsection

@section('script')
    @parent

@endsection

@section('content')

	@include("layouts.header-info") 
	<div class="address">
		@foreach($lists as $list)
		<div class="address_warpper">
			<div class="address_warpper_info">
				<div class="address_warpper_info_tit">
					<span class="chayefont">{{$list->name}}</span>
					<span class="pull-right phone">{{$list->phone}}</span>
				</div>
				<p>{{$list->province}}{{$list->city}}{{$list->area}}{{$list->detail}}</p>
			</div>
			<div class="address_warpper_opts">
				
				<a href="{{url('home/address/default')}}/{{$list->id}}" class="address_default pull-left @if($list->state == 1) active @endif">默认地址</a>		
				<ul class="pull-right">
					<li>
						<a href="{{url('home/address')}}/{{$list->id}}/edit"><i class="fa fa-edit" id="edit"></i>
						编辑</a>
					</li>
					<li>
						<i class="fa fa-trash-o" onclick="del({{$list->id}});"></i>
						删除
					</li>
				</ul>
			</div>
		</div>
		@endforeach
		<a href="{{ url('/home/address/create') }}" class="chayefont address_add">添加新地址</a>
	</div>
@endsection
