@extends('fx.admin.layouts.app')
@section('title')新增商品分类@endsection
@section('t1')商品管理@endsection
@section('css')@endsection
@section('script')
    @parent
@endsection
@section('content')
    <section class="content">
      <div class="row">
        <!-- 新增商品分类 -->
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">新增商品分类</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{url('admin/goods/category')}}" method="POST">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>分类名称</label>
                  <div class="col-sm-4">
                    <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="请输入分类名称">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">分类描述</label>
                  <div class="col-sm-4">
                    <input type="text" name="desc" class="form-control" id="inputEmail3" placeholder="请输入分类描述">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">图片</label>
                  <div class="col-sm-4">
                    待补充...
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-success btn-100">确认</button>
                    <button type="reset" class="btn btn-success btn-100">重置</button>
                    <a href="{{ url('admin/goods/category') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
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

