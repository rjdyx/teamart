@extends('fx.admin.layouts.app')
@section('title')新增用户@endsection
@section('t1')用户管理@endsection
@section('css')
@endsection
@section('script')
	@parent
	<script>
		$(function () {
			
			// 参数是一个对象
			// opts.selector = opts.selector != undefined ? opts.selector : '#datepicker' // 选择器
			// opts.enableTime = opts.enableTime != undefined ? opts.enableTime : false // 是否获取时间
			// opts.disable = opts.disable != undefined ? opts.disable : true // 是否禁用时间
			// opts.mode = opts.mode != undefined ? opts.mode : false // 为true时变成选择范围模式
			// opts.disableFn // 禁用时间时要使用的函数，如果不传入会使用默认函数
			// opts.dateFormat = opts.dateFormat != undefined ? opts.dateFormat : 'Y-m-d' // 默认格式 'Y-m-d H:i:S'为完整的时分秒格式
			datepicker()
			var form = document.forms['userForm']
			$(form).on('submit', function () {
				return submitForm()
			})
			function submitForm() {
				var name = form['name']
				var email = form['email']
				var gender = form['gender']
				var password = form['password']
				var repassword = form['repassword']
				var phone = form['phone']
				var realname = form['realname']
				var birth_date = form['birth_date']
				if (!_valid.name('name', '用户名', name.value, 'user')) {
					return false
				}
				if (!_valid.mail('email', email.value)) {
					return false
				}
				if (!_valid.ness('gender', '性别', gender.value)) {
					return false
				}
				if (!_valid.password('password', password.value)) {
					return false
				}
				if (!_valid.repassword('repassword', repassword.value)) {
					return false
				}
				if (!_valid.phone('phone', phone.value)) {
					return false
				}
				if (!_valid.realname('realname', realname.value)) {
					return false
				}
				if (!_valid.birth_date('birth_date', '出生日期', birth_date.value)) {
					return false
				}
				return true
			}
		})
	</script>
@endsection
@section('content')
	<section class="content">
		<div class="row">
			<!-- 新增用户角色 -->
			<div class="col-xs-12">
				<div class="box box-success">
					<div class="box-header with-border">
						<h3 class="box-title">新增用户</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<form class="form-horizontal" action="{{url('admin/user/list')}}" method="POST" name="userForm">
						{{ csrf_field() }}
						<div class="box-body">

							<div class="form-group">
								<label for="name" class="col-sm-3 control-label"><i style="color:red;">*</i>用户名</label>
								<div class="col-sm-4">
									<input type="text" name="name" class="form-control" id="name" placeholder="请输入用户名" onblur="_valid.name('name', '用户名', this.value, 'user')" oninput="_valid.name('name', '用户名', this.value, 'user')">
								</div>
								<span class="col-sm-4 text-danger form_error" id="name_txt"></span>
							</div>

							<div class="form-group">
								<label for="email" class="col-sm-3 control-label"><i style="color:red;">*</i>邮箱</label>
								<div class="col-sm-4">
									<input type="email" name="email" class="form-control" id="email" placeholder="请输入邮箱" onblur="_valid.email('email', this.value)" oninput="_valid.email('email', this.value)">
								</div>
								<span class="col-sm-4 text-danger form_error" id="email_txt"></span>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label"><i style="color:red;">*</i>性别</label>
								<div class="col-sm-4">
									<label class="col-sm-2 gender_label control-label">
										<input type="radio" name="gender" id="gender_male" checked="checked" value="0">男
									</label>
									<label class="col-sm-2 gender_label control-label">
										<input type="radio" name="gender" id="gender_female" value="1">女
									</label>
								</div>
								<span class="col-sm-4 text-danger form_error" id="gender_txt"></span>
							</div>

							<div class="form-group">
								<label for="password" class="col-sm-3 control-label"><i style="color:red;">*</i>登录密码</label>
								<div class="col-sm-4">
									<input type="password" name="password" class="form-control" id="password" placeholder="请输入密码" onblur="_valid.password('password', this.value)" oninput="_valid.password('password', this.value)">
								</div>
								<span class="col-sm-4 text-danger form_error" id="password_txt"></span>
							</div>

							<div class="form-group">
								<label for="repassword" class="col-sm-3 control-label"><i style="color:red;">*</i>确认密码</label>
								<div class="col-sm-4">
									<input type="password" name="repassword" class="form-control" id="repassword" placeholder="请再次输入密码" onblur="_valid.repassword('repassword', this.value)" oninput="_valid.repassword('repassword', this.value)">
								</div>
								<span class="col-sm-4 text-danger form_error" id="repassword_txt"></span>
							</div>

							<div class="form-group">
								<label for="phone" class="col-sm-3 control-label">手机</label>
								<div class="col-sm-4">
									<input type="text" name="phone" class="form-control" id="phone" placeholder="请输入手机号" onblur="_valid.phone('phone', this.value)" oninput="_valid.phone('phone', this.value)">
								</div>
								<span class="col-sm-4 text-danger form_error" id="phone_txt"></span>
							</div>

							<div class="form-group">
								<label for="realname" class="col-sm-3 control-label">姓名</label>
								<div class="col-sm-4">
									<input type="text" name="realname" class="form-control" id="realname" placeholder="请输入姓名" onblur="_valid.realname('realname', this.value)" oninput="_valid.realname('realname', this.value)">
								</div>
								<span class="col-sm-4 text-danger form_error" id="realname_txt"></span>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label" for="datepicker">出生日期</label>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" name="birth_date" class="form-control pull-right" id="datepicker" onblur="_valid.birth_date('birth_date', '出生日期', this.value)" oninput="_valid.birth_date('birth_date', '出生日期', this.value)">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
									</div>
								</div>
								<span class="col-sm-4 text-danger form_error" id="birth_date_txt"></span>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-10">
									<button type="submit" class="btn btn-success btn-100">确认</button>
									<button type="reset" class="btn btn-success btn-100">重置</button>
									<a href="{{ url('admin/user/list') }}">
										<button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button>
									</a>
								</div>
							</div>

						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
@endsection

