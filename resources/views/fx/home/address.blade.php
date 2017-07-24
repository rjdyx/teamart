@extends('layouts.app')

@section('title') 地址管理 @endsection

@section('css')
@endsection

@section('script')
    @parent
	<script>
		$(function () {
			// 设置默认地址
			$('.J_setdefault').on('tap', function () {
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
			$('.J_del').on('tap', function () {
				var id = $(this).data('id')
				var $this = $(this)
				prompt.question('是否删除地址', function () {
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

			// 结算页跳转过来时的操作
			if (sessionStorage.getItem('chaye')){
				$('.J_header_back').off('tap').on('tap', function () {
					var chaye = sessionStorage.getItem('chaye')
					sessionStorage.removeItem('chaye')
					window.location.href = chaye
				})
			} else {
				// $('.J_header_back').off('tap').on('tap', function () {
				// 	window.location.href = 'http://' + window.location.host + '/home/userinfo'
				// })
			}
		})
	</script>
@endsection

@section('content')

	@include("layouts.header-info")

	@include("layouts.backIndex")
	<div class="address relative container">
		<div class="address_container">
			@foreach($lists as $list)
			<div class="address_warpper mb-20">
				<div class="address_warpper_info">
					<div class="address_warpper_info_tit fz-16">
						<span class="chayefont">{{$list->name}}</span>
						<span class="pull-right fz-14 color-8C8C8C">{{$list->phone}}</span>
					</div>
					<p class="color-8C8C8C mt-20 fz-14">{{$list->province}}@if($list->city == $list->area){{$list->city}}@else{{$list->city}}{{$list->area}} @endif{{$list->detail}}</p>
				</div>
				<div class="address_warpper_opts">
					<a href="javascript:;" class="address_default pull-left @if($list->state == 1) active @endif J_setdefault" data-id="{{$list->id}}">默认地址</a>		
					<ul class="pull-right color-8C8C8C fz-14">
						<li class="pull-left mr-20">
							<a class="color-8C8C8C" href="{{url('home/address')}}/{{$list->id}}/edit">
								<i class="fa fa-edit" id="edit"></i>
								编辑
							</a>
						</li>
						<li class="pull-left J_del" data-id="{{$list->id}}">
							<i class="fa fa-trash-o"></i>
							删除
						</li>
					</ul>
				</div>
			</div>
			@endforeach
			@if (!count($lists))
			<div class="list_nodata txt-c fz-20">暂时还没有收货地址</div>
			@endif
		</div>
		<a href="{{ url('/home/address/create') }}" class="chayefont block txt-c white fz-18 bottom_btn">添加新地址</a>
	</div>
@endsection
