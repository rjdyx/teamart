@extends('fx.admin.layouts.app')
@section('title')编辑用户@endsection
@section('t1')用户管理@endsection
@section('css')@endsection
@section('script')
    @parent
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
            <form class="form-horizontal" action="{{url('admin/user/list')}}/{{$data->id}}" method="POST">
              {{ csrf_field() }}
              <input type="hidden" value="PUT" name="_method">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>用户名</label>
                  <div class="col-sm-4">
                    <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="请输入用户名" value="{{$data->name}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">姓名</label>
                  <div class="col-sm-4">
                    <input type="text" name="realname" class="form-control" id="inputEmail3" placeholder="请输入姓名" value="{{$data->realname}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>邮箱</label>
                  <div class="col-sm-4">
                    <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="请输入邮箱" value="{{$data->email}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">手机</label>
                  <div class="col-sm-4">
                    <input type="text" name="phone" class="form-control" id="inputEmail3" placeholder="请输入手机号" value="{{$data->phone}}">
                  </div>
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
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">出生日期</label>
                  <div class="col-sm-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" value="{{$data->birth_date}}" class="form-control pull-right" id="datepicker" name="birth_date">
                    </div>
                    <!-- /.input group -->
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">登录密码</label>
                  <div class="col-sm-4">
                    <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="不输入密码则不修改">
                  </div>
                </div>
                <div class="form-group">
                  <label for="ComfirmPassword3" class="col-sm-3 control-label">确认密码</label>
                  <div class="col-sm-4">
                    <input type="password" class="form-control" id="ComfirmPassword3" placeholder="若登录密码未输入，则确认密码无效">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-success btn-100">确认</button>
                    <button type="reset" class="btn btn-success btn-100">重置</button>
                    <a href="{{ url('admin/user/list') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
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

