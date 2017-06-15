@extends('fx.admin.layouts.app')

@section('title')
新增代理商
@endsection

@section('css')
@endsection

@section('script')
    @parent
@endsection

@section('content')
   @include("fx.admin.layouts.header")

   @include("fx.admin.layouts.left")
   
   <div class="content-wrapper">
    <!-- agentRole -->
    <div id="agentRole">
        <section class="content-header">
          <h1 style="cursor: pointer;">
            <i class="fa fa-home" style="color: #00a65a;margin-right:4px"></i>用户管理
            <small style="color: #00a65a"><i class="fa fa-angle-right" style="margin-right: 4px"></i>新增代理商</small>
          </h1>
        </section>

        <section class="content">
          <div class="row">
            <!-- 新增代理商角色 -->
            <div class="col-xs-12">
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">新增代理商</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">名称</label>

                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail3" placeholder="请输入用户名称">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputAddress3" class="col-sm-2 control-label">地址</label>

                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputAddress3" placeholder="家庭住址">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">登录密码</label>

                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword3" placeholder="请输入密码">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="ComfirmPassword3" class="col-sm-2 control-label">确认密码</label>

                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="ComfirmPassword3" placeholder="请再次输入密码">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">会员等级</label>
                      <div class="col-sm-10">
                        <select class="form-control">
                          <option>option 1</option>
                          <option>option 2</option>
                          <option>option 3</option>
                          <option>option 4</option>
                          <option>option 5</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">性别</label>
                      <div class="col-sm-10">
                        <label class="col-sm-1 gender_label control-label">
                          <input type="radio" name="optionsRadios" id="gender_male" value="option1" checked="checked">男
                        </label>
                        <label class="col-sm-11 gender_label control-label">
                          <input type="radio" name="optionsRadios" id="gender_female" value="option2">女
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">出生日期</label>
                      <div class="col-sm-10">
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right" id="datepicker">
                        </div>
                        <!-- /.input group -->
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="credit_lines" class="col-sm-2 control-label">信用额度</label>

                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="credit_lines" placeholder="输入信用额度">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">门店介绍</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" rows="3" placeholder="请输入详细信息 ..."></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-success btn-100">确认</button>
                        <button type="button" class="btn btn-success btn-100">重置</button>
                        <button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button>
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
    </div>
  </div>
   
@endsection

