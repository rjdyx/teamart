@extends('layouts.app')

@section('title') 帮助中心 @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/css/helpCenter_option.css') }}">
@endsection

@section('script')
    @parent

@endsection

@section('content')
@include("layouts.header-info")
    <div class="helpCenter_option_body">
		<div class="helpCenter_option_img_container">
			<div class="option_list">
				<ul>
					<li>
						<div class="option">
							<img class="photo_Point" src="{{ url('fx/img/helpCenter_option_point.png') }}">
							<a href="{{ url('home/detail/1') }}" title=""><span class="wordStyle">个人中心操作大全</span></a>
						</div>
					</li>
					
					<li>
						<div class="option">
							<img class="photo_Point" src="{{ url('fx/img/helpCenter_option_point.png') }}">
							<a href="javascript:;" title=""><span class="wordStyle">推广二维码更新方法</span></a>
						</div>
					</li>
					
					<li>
						<div class="option">
							<img class="photo_Point" src="{{ url('fx/img/helpCenter_option_point.png') }}">
							<a href="javascript:;" title=""><span class="wordStyle">真省购物会员卡领取流程</span></a>
						</div>
					</li>
					
					<li>
						<div class="option">
							<img class="photo_Point" src="{{ url('fx/img/helpCenter_option_point.png') }}">
							<a href="javascript:;" title=""><span class="wordStyle">新手推广流程</span></a>
						</div>
					</li>
					
					<li>
						<div class="option">
							<img class="photo_Point" src="{{ url('fx/img/helpCenter_option_point.png') }}">
							<a href="javascript:;" title=""><span class="wordStyle">忘记APP密码的修改流程</span></a>
						</div>
					</li>
					
					<li>
						<div class="option">
							<img class="photo_Point" src="{{ url('fx/img/helpCenter_option_point.png') }}">
							<a href="javascript:;" title=""><span class="wordStyle">提现真实姓名的修改</span></a>
						</div>
					</li>
					
					<li>
						<div class="option">
							<img class="photo_Point" src="{{ url('fx/img/helpCenter_option_point.png') }}">
							<a href="javascript:;" title=""><span class="wordStyle">APP账号绑定及登录流程</span></a>
						</div>
					</li>
					
					<li>
						<div class="option">
							<img class="photo_Point" src="../img/helpCenter_option_point.png">
							<a href="javascript:;" title=""><span class="wordStyle">真省购物合伙人升级流程</span></a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
@endsection
