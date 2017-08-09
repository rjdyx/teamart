@extends('fx.admin.layouts.app')
@section('title')编辑用户@endsection
@section('t1')用户管理@endsection
@section('css')
<style>
	.agent_cl{
		width:100px;height: 40px;font-size:22px;color:#999;
		background: #ccc;line-height: 40px;text-align: center;
		cursor: pointer;border:1px solid #AAA;border-radius: 18px;
	}
	#parterMd{display:none;}
</style>
@endsection
@section('script')
	@parent
	<script src="{{url('/admin/js/jquery-1.8.3.min.js')}}"></script>	
	<script>
		$(function () {
			datepicker()
			var form = document.forms['userForm']
			$(form).on('submit', function () {
				return submitForm()
			})
			$('#name').on('blur input', function () {
				_valid.name('name', '用户名', $(this).val(), 'user')
			})
			$('#email').on('blur input', function () {
				_valid.email('email', $(this).val())
			})
			$('input[name="gender"]').on('change', function () {
				_valid.ness('gender', '性别', $(this).val())
			})
			$('#password').on('input', function () {
				_valid.password('password', $(this).val(), false)
			})
			$('#repassword').on('input', function () {
				_valid.repassword('repassword', $(this).val(), false)
			})
			$('#phone').on('blur input', function () {
				_valid.phone('phone', $(this).val())
			})
			$('#realname').on('blur input', function () {
				_valid.realname('realname', $(this).val())
			})
			$('#birth_date').on('blur', function () {
				_valid.birth_date('birth_date', '出生日期', $(this).val())
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
				if (!_valid.email('email', email.value)) {
					return false
				}
				if (!_valid.ness('gender', '性别', gender.value)) {
					return false
				}
				if (!_valid.password('password', password.value, false)) {
					return false
				}
				if (!_valid.repassword('repassword', repassword.value, false)) {
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
				var state = $(".agent_cl").attr('state')
				if (state != 'off') {
					var parter_id = form['parter_id']
					if (!_valid.ness('parter_id', '代理商角色', parter_id.value)) {
						return false
					}
				}
				return true
			}
		})

		$(".agent_cl").click(function(){
			var state = $(this).attr('state');
			if (state == 'off') {
				$(this).css('background','#00a65a');
				$(this).css('color','white');
				$(this).attr('state','on');
				$(this).html('ON');
				$("#parterMd").show();
			}else{
				$(this).css('background','#ccc');
				$(this).css('color','#999');
				$(this).attr('state','off');
				$(this).html('OFF');
				$("#parterMd").hide();
			}
		})	
	</script>


@endsection
@section('content')
	<section class="content">
		<div class="row">
			<!-- 编辑用户 -->
			<div class="col-xs-12">
				<div class="box box-success">
					<div class="box-header with-border">
						<h3 class="box-title">编辑用户</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<form class="form-horizontal" action="{{url('admin/user/list')}}/{{$data->id}}" method="POST" name="userForm">
						{{ csrf_field() }}
						<input type="hidden" value="PUT" name="_method">
						<input type="hidden" value="{{$data->id}}" name="id" id="id">
						<div class="box-body">
							<div class="form-group">
								<label for="name" class="col-sm-3 control-label"><i style="color:red;">*</i>用户名</label>
								<div class="col-sm-4">
									<input type="text" name="name" class="form-control" id="name" placeholder="请输入用户名" value="{{$data->name}}">
								</div>
								<span class="col-sm-4 text-danger form_error" id="name_txt"></span>
							</div>
							<div class="form-group">
								<label for="realname" class="col-sm-3 control-label">姓名</label>
								<div class="col-sm-4">
									<input type="text" name="realname" class="form-control" id="realname" placeholder="请输入姓名" value="{{$data->realname}}">
								</div>
								<span class="col-sm-4 text-danger form_error" id="realname_txt"></span>
							</div>
							<div class="form-group">
								<label for="email" class="col-sm-3 control-label"><i style="color:red;">*</i>邮箱</label>
								<div class="col-sm-4">
									<input type="email" name="email" class="form-control" id="email" placeholder="请输入邮箱" value="{{$data->email}}">
								</div>
								<span class="col-sm-4 text-danger form_error" id="email_txt"></span>
							</div>
							<div class="form-group">
								<label for="phone" class="col-sm-3 control-label">手机</label>
								<div class="col-sm-4">
									<input type="text" name="phone" class="form-control" id="phone" placeholder="请输入手机号" value="{{$data->phone}}">
								</div>
								<span class="col-sm-4 text-danger form_error" id="phone_txt"></span>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label"><i style="color:red;">*</i>性别</label>
								<div class="col-sm-4">
									<label class="col-sm-2 gender_label control-label">
										<input type="radio" name="gender" id="gender_male" value="0" @if(!$data->gender) checked="checked" @endif>男
									</label>
									<label class="col-sm-2 gender_label control-label">
										<input type="radio" name="gender" id="gender_female" value="1" @if($data->gender) checked="checked" @endif>女
									</label>
								</div>
								<span class="col-sm-4 text-danger form_error" id="gender_txt"></span>
							</div>
							<div class="form-group">
									<label class="col-sm-3 control-label" for="datepicker">出生日期</label>
									<div class="col-sm-4">
										<div class="input-group date">
											<input type="text" name="birth_date" class="form-control pull-right" id="datepicker" value="{{$data->birth_date}}">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
										</div>
									</div>
									<span class="col-sm-4 text-danger form_error" id="birth_date_txt"></span>
								</div>
							<div class="form-group">
								<label for="password" class="col-sm-3 control-label">登录密码</label>
								<div class="col-sm-4">
									<input type="password" name="password" class="form-control" id="password" placeholder="不输入密码则不修改">
								</div>
								<span class="col-sm-4 text-danger form_error" id="password_txt"></span>
							</div>
							<div class="form-group">
								<label for="repassword" class="col-sm-3 control-label">确认密码</label>
								<div class="col-sm-4">
									<input type="password" class="form-control" id="repassword" placeholder="若登录密码未输入，则确认密码无效">
								</div>
								<span class="col-sm-4 text-danger form_error" id="repassword_txt"></span>
							</div>
							<div class="form-group">
								<label for="repassword" class="col-sm-3 control-label">升级成为代理商</label>
								<div class="col-sm-4">
									<div class="agent_cl" state="off">OFF</div>
								</div>
								<span class="col-sm-4 text-danger form_error" id="repassword_txt"></span>
							</div>
							<div class="form-group" id="parterMd">
								<label for="parter_id" class="col-sm-3 control-label"><i style="color:red;">*</i>代理商角色</label>
								<div class="col-sm-4">
									<select name="parter_id" id="parter_id" class="form-control">
										<option value="">-- 请选择代理商角色 --</option>
				                    @foreach($selects as $select)
				                        <option value="{{$select->id}}">
				                        	{{$select->name}} ({{$select->scale}})
				                        </option>
				                    @endforeach
									</select>
								</div>
								<span class="col-sm-4 text-danger form_error" id="parter_id_txt"></span>
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
						<!-- /.box-body -->
					</form>
				</div>
			</div>
			<!-- /新增代理商角色 -->
		</div>
	</section>
@endsection

