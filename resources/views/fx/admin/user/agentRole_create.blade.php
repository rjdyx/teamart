@extends('fx.admin.layouts.app')
@section('title') 新增代理商角色 @endsection
@section('t1') 用户管理 @endsection
@section('css')
@endsection
@section('script')
    @parent
@endsection
@section('content')
  <section class="content">
    <div class="row">
      <!-- 新增代理商角色 -->
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">新增代理商角色</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form class="form-horizontal" action="{{url('admin/user/agentrole')}}" method="POST">
          {{ csrf_field() }}
            <div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i> 分销角色名称</label>

                <div class="col-sm-4">
                  <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="请输入分销角色名称，不超过50字符">
                </div>
              </div>
              <div class="form-group">
                <label for="inputAddress3" class="col-sm-3 control-label"><i style="color:red;">*</i>分销比例</label>

                <div class="col-sm-4">
                  <input type="text" class="form-control" id="inputAddress3" placeholder="请输入范围在0 ~ 1的数，保留两位小数" name='scale'>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">描述</label>
                <div class="col-sm-4">
                  <textarea class="form-control" rows="3" name="desc" placeholder="请输入角色描述 ..."></textarea >
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-10">
                  <button type="submit" class="btn btn-success btn-100">确认</button>
                  <button type="reset" class="btn btn-success btn-100">重置</button>
                  <a href="{{ url('admin/user/agentrole') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
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

