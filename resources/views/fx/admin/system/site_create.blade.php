@extends('fx.admin.layouts.app')

@section('title')
新建站点
@endsection
@section('t1')
系统管理
@endsection
@section('css')

@endsection

@section('script')
    @parent
@endsection

@section('content')
   
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">新站点</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form action="{{url('admin/system/site')}}" method="post" class="form-horizontal">
                {{ csrf_field() }}
                <div class="box-body">
                  <div class="form-group">
                    <label for="storename" class="col-sm-2 control-label">站点名称</label>
                    <div class="col-sm-10">
                      <input type="text" name="name" class="form-control" id="storename" placeholder="请输入站点名称">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="Contacts" class="col-sm-2 control-label">经度</label>
                    <div class="col-sm-10">
                      <input type="text" name="longitude" class="form-control" id="Contacts" placeholder="请输入地图经度">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="Contacts" class="col-sm-2 control-label">纬度</label>
                    <div class="col-sm-10">
                      <input type="text" name="latitude" class="form-control" id="Contacts" placeholder="请输入地图纬度">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="Contacts" class="col-sm-2 control-label">联系人</label>
                    <div class="col-sm-10">
                      <input type="text" name="user" class="form-control" id="Contacts" placeholder="请输入联系人">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="Contacts" class="col-sm-2 control-label">联系电话</label>
                    <div class="col-sm-10">
                      <input type="text" name="phone" class="form-control" id="Contacts" placeholder="请输入联系电话">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-success btn-100">确认</button>
                      <button type="reset" class="btn btn-success btn-100">重置</button>
                      <button type="button" class="btn btn-success btn-100" id="cancel_addUser">取消</button>
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
