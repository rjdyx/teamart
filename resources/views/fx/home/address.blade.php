@extends('layouts.app')

@section('title') 地址管理 @endsection

@section('css')
@endsection

@section('script')
    @parent
	<script>
		$(function () {
			// 设置默认地址
			$('.J_setdefault').on('click tap', function () {
				var id = $(this).data('id')
				var $this = $(this)
				ajax('get', '/home/address/default/' + id)
					.then(function (res) {
						if (res) {
							prompt.message('修改成功')
							$this.parents('.address').find('.address_default').removeClass('active')
							$this.addClass('active')
						} else {
							prompt.message('修改失败')
						}
					})
			})
			// 删除地址
			$('.J_del').on('click tap', function () {
				var id = $(this).data('id')
				var $this = $(this)
				ajax('delete', '/home/address/' + id)
					.then(function (res) {
						if (res) {
							prompt.message('删除成功')
							$this.parents('.address_warpper').remove()
						} else {
							prompt.message('删除失败')
						}
					})
			})
		})
	</script>
@endsection

@section('content')

	@include("layouts.header-info")

	@include("layouts.backIndex")
	<div class="address">
		<div class="address_container">
			@foreach($lists as $list)
			<div class="address_warpper">
				<div class="address_warpper_info">
					<div class="address_warpper_info_tit">
						<span class="chayefont">{{$list->name}}</span>
						<span class="pull-right phone">{{$list->phone}}</span>
					</div>
					<p>{{$list->province}}@if($list->city == $list->area){{$list->city}}@else{{$list->city}}{{$list->area}} @endif{{$list->detail}}</p>
				</div>
				<div class="address_warpper_opts">
					<a href="javascript:;" class="address_default pull-left @if($list->state == 1) active @endif J_setdefault" data-id="{{$list->id}}">默认地址</a>		
					<ul class="pull-right">
						<li>
							<a href="{{url('home/address')}}/{{$list->id}}/edit">
								<i class="fa fa-edit" id="edit"></i>
								编辑
							</a>
						</li>
						<li class="J_del" data-id="{{$list->id}}">
							<i class="fa fa-trash-o"></i>
							删除
						</li>
					</ul>
				</div>
			</div>
			@endforeach
		</div>
		<a href="{{ url('/home/address/create') }}" class="chayefont address_add">添加新地址</a>
	</div>
@endsection
