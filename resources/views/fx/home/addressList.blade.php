@extends('layouts.app')

@section('title') 地址管理 @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/css/addressManagement.css') }}">
@endsection

@section('script')
    @parent

@endsection

@section('content')

	@include("layouts.header-info")
	<!-- 主体部分 -->
	<div class="addressManagement_container">
		<ul class="addressManagement_list">
			<li class="addressManagement_list_detail">
				<a href="javascript:;">
					<div class="addressManagement_list_top">
						<div class="userDetail"><span class="userName">隔壁老王</span><span class="userTel">13560449011</span></div>
						<div class="addressDetail">广东省广州市天河区五山街道华南理工大学国家大学科技园2号楼204</div> 
					</div>
					<div class="addressManagement_list_bottom">
						<div class="setDefault_btn" style="color: #ff5500"><img src="../img/DefaultAddress.png') }}">默认地址</div>
						<div class="operation_container">
							<div class="edit"><img src="../img/edit.png') }}">编辑</div>
							<div class="delete"><img src="../img/delete.png') }}">删除</div>
						</div>
					</div>
				</a>
			</li>
			<li class="addressManagement_list_detail">
				<a href="javascript:;">
					<div class="addressManagement_list_top">
						<div class="userDetail"><span class="userName">隔壁老王</span><span class="userTel">13560449011</span></div>
						<div class="addressDetail">广东省广州市天河区五山街道华南理工大学国家大学科技园2号楼204</div> 
					</div>
					<div class="addressManagement_list_bottom">
						<div class="setDefault_btn"><img src="../img/setDefault.png') }}">设为默认</div>
						<div class="operation_container">
							<div class="edit"><img src="../img/edit.png') }}">编辑</div>
							<div class="delete"><img src="../img/delete.png') }}">删除</div>
						</div>
					</div>
				</a>
			</li>
			<li class="addressManagement_list_detail">
				<a href="javascript:;">
					<div class="addressManagement_list_top">
						<div class="userDetail"><span class="userName">隔壁老王</span><span class="userTel">13560449011</span></div>
						<div class="addressDetail">广东省广州市天河区五山街道华南理工大学国家大学科技园2号楼204</div> 
					</div>
					<div class="addressManagement_list_bottom">
						<div class="setDefault_btn"><img src="{{ url('fx/img/setDefault.png') }}">设为默认</div>
						<div class="operation_container">
							<div class="edit"><img src="{{ url('fx/img/edit.png') }}">编辑</div>
							<div class="delete"><img src="{{ url('fx/img/delete.png') }}">删除</div>
						</div>
					</div>
				</a>
			</li>
			<li class="addressManagement_list_detail">
				<a href="javascript:;">
					<div class="addressManagement_list_top">
						<div class="userDetail"><span class="userName">隔壁老王</span><span class="userTel">13560449011</span></div>
						<div class="addressDetail">广东省广州市天河区五山街道华南理工大学国家大学科技园2号楼204</div> 
					</div>
					<div class="addressManagement_list_bottom">
						<div class="setDefault_btn"><img src="{{ url('fx/img/setDefault.png') }}">设为默认</div>
						<div class="operation_container">
							<div class="edit"><img src="{{ url('fx/img/edit.png') }}">编辑</div>
							<div class="delete"><img src="{{ url('fx/img/delete.png') }}">删除</div>
						</div>
					</div>
				</a>
			</li>
			<li class="addressManagement_list_detail">
				<a href="javascript:;">
					<div class="addressManagement_list_top">
						<div class="userDetail"><span class="userName">隔壁老王</span><span class="userTel">13560449011</span></div>
						<div class="addressDetail">广东省广州市天河区五山街道华南理工大学国家大学科技园2号楼204</div> 
					</div>
					<div class="addressManagement_list_bottom">
						<div class="setDefault_btn"><img src="{{ url('fx/img/setDefault.png') }}">设为默认</div>
						<div class="operation_container">
							<div class="edit"><img src="{{ url('fx/img/edit.png') }}">编辑</div>
							<div class="delete"><img src="{{ url('fx/img/delete.png') }}">删除</div>
						</div>
					</div>
				</a>
			</li>
			<li class="addressManagement_list_detail">
				<a href="javascript:;">
					<div class="addressManagement_list_top">
						<div class="userDetail"><span class="userName">隔壁老王</span><span class="userTel">13560449011</span></div>
						<div class="addressDetail">广东省广州市天河区五山街道华南理工大学国家大学科技园2号楼204</div> 
					</div>
					<div class="addressManagement_list_bottom">
						<div class="setDefault_btn"><img src="{{ url('fx/img/setDefault.png') }}">设为默认</div>
						<div class="operation_container">
							<div class="edit"><img src="{{ url('fx/img/edit.png') }}">编辑</div>
							<div class="delete"><img src="{{ url('fx/img/delete.png') }}">删除</div>
						</div>
					</div>
				</a>
			</li>
			<li class="addressManagement_list_detail">
				<a href="javascript:;">
					<div class="addressManagement_list_top">
						<div class="userDetail"><span class="userName">隔壁老王</span><span class="userTel">13560449011</span></div>
						<div class="addressDetail">广东省广州市天河区五山街道华南理工大学国家大学科技园2号楼204</div> 
					</div>
					<div class="addressManagement_list_bottom">
						<div class="setDefault_btn"><img src="{{ url('fx/img/setDefault.png') }}">设为默认</div>
						<div class="operation_container">
							<div class="edit"><img src="{{ url('fx/img/edit.png') }}">编辑</div>
							<div class="delete"><img src="{{ url('fx/img/delete.png') }}">删除</div>
						</div>
					</div>
				</a>
			</li>
		</ul>
	</div>

	<!-- 底部 -->
	<div class="bottom2"><a href="{{ url('/home/address/create') }}">添加新地址</a></div>
@endsection
