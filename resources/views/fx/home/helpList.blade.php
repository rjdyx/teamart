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
		<li>
			<a href="{{ url('home/help/detail/1') }}" class="chayefont">个人中心操作大全</a>
		</li>
		<li>
			<a href="javascript:;" class="chayefont">推广二维码更新方法</a>
		</li>
		<li>
			<a href="javascript:;" class="chayefont">真省购物会员卡领取流程</a>
		</li>
		<li>
			<a href="javascript:;" class="chayefont">新手推广流程</a>
		</li>
		<li>
			<a href="javascript:;" class="chayefont">忘记APP密码的修改流程</a>
		</li>
		<li>
			<a href="javascript:;" class="chayefont">提现真实姓名的修改</a>
		</li>
		<li>
			<a href="javascript:;" class="chayefont">APP账号绑定及登录流程</a>
		</li>
		<li>
			<a href="javascript:;" class="chayefont">真省购物合伙人升级流程</a>
		</li>
	</ul>
</div>
@endsection
