@extends('fx.admin.layouts.app')
@section('t1')
系统管理
@endsection
@section('title')
个人中心
@endsection

@section('css')

@endsection

@section('script')
    @parent
    <script src="{{url('admin/js/upload.js')}}"></script>
    <script>
      $(function () {
        var form = document.forms['personalForm']
        $(form).on('submit', function () {
          return submitForm()
        })
        $('#name').on('blur input', function () {
          _valid.name('name', '登录用户名', $(this).val(), 'user')
        })
        $('#email').on('blur input', function () {
          _valid.email('email', $(this).val())
        })
        $('#phone').on('blur input', function () {
          _valid.phone('phone', $(this).val())
        })
        $('#password').on('blur input', function () {
          _valid.password('password', $(this).val(), false)
        })
        $('#repassword').on('blur input', function () {
          _valid.repassword('repassword', $(this).val(), false)
        })
        function submitForm() {
          var name = form['name']
          var email = form['email']
          var phone = form['phone']
          var password = form['password']
          var repassword = form['repassword']
          if (!_valid.name('name', '登录用户名', name.value, 'user')) {
            return false
          }
          if (!_valid.email('email', email.value)) {
            return false
          }
          if (!_valid.phone('phone', phone.value)) {
            return false
          }
          if (!_valid.password('password', password.value, false)) {
            return false
          }
          if (!_valid.repassword('repassword', repassword.value, false)) {
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
          <!-- 新增代理商角色 -->
          <div class="col-xs-12">
            <div class="box box-success">
              
              <!-- form start -->
              <form action="{{url('admin/system/personal')}}/{{$user->id}}" method="POST" class="form-horizontal" name="personalForm" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" value="PUT" name="_method">
                <input type="hidden" value="{{$user->id}}" name="id" id="id">
                <div class="box-body">
                  <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">登录用户名</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="name" placeholder="请输入商店名称" name="name" value="{{$user->name}}">
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="name_txt"></span>
                  </div>
                  <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">登录邮箱</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="email" placeholder="请输入联系email" name="email" value="{{$user->email}}">
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="email_txt"></span>
                  </div>
                  <div class="form-group">
                    <label for="phone" class="col-sm-2 control-label">联系电话</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="phone" placeholder="请输入联系电话" name="phone" value="{{$user->phone}}">
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="phone_txt"></span>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">性别</label>
                    <label class="col-sm-2 gender_label control-label">
                      <input type="radio" name="gender" id="gender_female" value="0" @if($user->gender===0)checked="checked"@endif>男
                    </label>
                    <label class="col-sm-2 gender_label control-label">
                      <input type="radio" name="gender" id="gender_male" value="1" @if($user->gender===1)checked="checked"@endif >女
                    </label>
                    <span class="col-sm-4 text-danger form_error" id="gender_txt"></span>
                  </div>
                  <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">密码</label>
                    <div class="col-sm-6">
                      <input type="password" class="form-control" id="password" placeholder="请输入密码" name="password">
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="password_txt"></span>
                  </div>
                  <div class="form-group">
                    <label for="repassword" class="col-sm-2 control-label">确认密码</label>
                    <div class="col-sm-6">
                      <input type="password" class="form-control" id="repassword" placeholder="请再次输入密码" name="repassword">
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="repassword_txt"></span>
                  </div>
                  <div class="form-group">
	                  <label class="col-sm-2 control-label">图片</label>
	                  <div class="col-sm-4">
	                    <div class="upload_single">
	                      @if ($user->img) 
                          <img class="pull-left upload_img" src="{{url('')}}/{{$user->img}}">
                          <label for="img" class="upload pull-left hidden">
                            <i class="glyphicon glyphicon-plus"></i>
                          </label>
                          <label class="btn btn-primary pull-left ml-10" for="img">修改</label>
                          <div class="btn btn-danger pull-left ml-10 J_remove">删除</div>
                          <input type="file" name="img" id="img" class="invisible form-control J_img" accept="image/jpeg,image/jpg,image/png">
                        @else
                          <label for="img" class="upload pull-left">
                            <i class="glyphicon glyphicon-plus"></i>
                          </label>
                          <label class="btn btn-primary pull-left ml-10 invisible" for="img">修改</label>
                          <div class="btn btn-danger pull-left ml-10 invisible J_remove">删除</div>
                          <input type="file" name="img" id="img" class="invisible form-control J_img" accept="image/jpeg,image/jpg,image/png">
                        @endif
	                    </div>
	                  </div>
	                  <span class="col-sm-4 text-danger form_error" id="img_txt"></span>
	                </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-success btn-100">确认</button>
                      <button type="reset" class="btn btn-success btn-100">重置</button>
                      <button type="button" class="btn btn-success btn-100">取消</button>
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
