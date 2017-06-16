@extends('fx.admin.layouts.app')
@section('title')编辑商品规格@endsection
@section('t1')商品管理@endsection
@section('css')@endsection
@section('script')
    @parent
@endsection
@section('content')
    <section class="content">
      <div class="row">
        <!-- 编辑商品规格 -->
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">编辑商品规格</h3>
            </div>
            <form class="form-horizontal" action="{{url('admin/goods/spec')}}/{{$data->id}}" method="POST">
              {{ csrf_field() }}
              <input type="hidden" value="PUT" name="_method">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>规格名称</label>
                  <div class="col-sm-4">
                    <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="请输入规格名称" value="{{$data->name}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">规格描述</label>
                  <div class="col-sm-4">
                    <input type="text" name="desc" class="form-control" id="inputEmail3" placeholder="请输入规格描述" value="{{$data->desc}}">
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
                    <a href="{{ url('admin/goods/spec') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
@endsection

