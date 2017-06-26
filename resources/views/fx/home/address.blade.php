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
		<div class="address_warpper">
			<div class="address_warpper_info">
				<div class="address_warpper_info_tit">
					<span class="chayefont">隔壁老王</span>
					<span class="pull-right phone">13560449011</span>
				</div>
				<p>广东省广州市天河区五山街道华南理工大学国家大学科技园2号楼204</p>
			</div>
			<div class="address_warpper_opts">
				<a href="javascript:;" class="address_default pull-left active">默认地址</a>
				<ul class="pull-right">
					<li>
						<i class="fa fa-edit"></i>
						编辑
					</li>
					<li>
						<i class="fa fa-trash-o"></i>
						删除
					</li>
				</ul>
			</div>
		</div>
		<div class="address_warpper">
			<div class="address_warpper_info">
				<div class="address_warpper_info_tit">
					<span class="chayefont">隔壁老王</span>
					<span class="pull-right phone">13560449011</span>
				</div>
				<p>广东省广州市天河区五山街道华南理工大学国家大学科技园2号楼204</p>
			</div>
			<div class="address_warpper_opts">
				<a href="javascript:;" class="address_default pull-left">默认地址</a>
				<ul class="pull-right">
					<li>
						<i class="fa fa-edit"></i>
						编辑
					</li>
					<li>
						<i class="fa fa-trash-o"></i>
						删除
					</li>
				</ul>
			</div>
		</div>
		<a href="{{ url('/home/address/create') }}" class="chayefont address_add">添加新地址</a>
	</div>
@endsection
