@extends('fx.admin.layouts.app')
@section('title')新增用户@endsection
@section('t1')用户管理@endsection
@section('css')@endsection
@section('script')
    @parent
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
            <form class="form-horizontal" action="{{url('admin/user/list')}}" method="POST">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>用户名</label>
                  <div class="col-sm-4">
                    <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="请输入用户名">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>邮箱</label>
                  <div class="col-sm-4">
                    <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="请输入邮箱">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label"><i style="color:red;">*</i>性别</label>
                  <div class="col-sm-4">
                    <label class="col-sm-2 gender_label control-label">
                    <input type="radio" name="gender" id="gender_male" value="0" checked="checked">男
                    </label>
                    <label class="col-sm-2 gender_label control-label">
                      <input type="radio" name="gender" id="gender_female" value="1">女
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label"><i style="color:red;">*</i>登录密码</label>
                  <div class="col-sm-4">
                    <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="请输入密码">
                  </div>
                </div>
                <div class="form-group">
                  <label for="ComfirmPassword3" class="col-sm-3 control-label"><i style="color:red;">*</i>确认密码</label>
                  <div class="col-sm-4">
                    <input type="password" class="form-control" id="ComfirmPassword3" placeholder="请再次输入密码">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">手机</label>
                  <div class="col-sm-4">
                    <input type="text" name="phone" class="form-control" id="inputEmail3" placeholder="请输入手机号">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">姓名</label>
                  <div class="col-sm-4">
                    <input type="text" name="realname" class="form-control" id="inputEmail3" placeholder="请输入姓名">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">出生日期</label>
                  <div class="col-sm-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="birth_date" class="form-control pull-right" id="datepicker">
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- <div class="col-sm-4 verify-hint"></div> -->
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-success btn-100">确认</button>
                    <button type="reset" class="btn btn-success btn-100">重置</button>
                    <a href="{{ url('admin/user/list') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
@endsection

