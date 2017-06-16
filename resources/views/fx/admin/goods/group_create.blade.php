@extends('fx.admin.layouts.app')
@section('title')新增商品组@endsection
@section('t1')商品管理@endsection
@section('css')@endsection
@section('script')
    @parent
@endsection
@section('content')
    <section class="content">
      <div class="row">
        <!-- 新增商品组 -->
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">新增商品组</h3>
            </div>
            <form class="form-horizontal" action="{{url('admin/goods/group')}}" method="POST">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>商品分类</label>
                  <div class="col-sm-4">
                    <select name="category_id" class="form-control" >
                      <option value="">-请选择商品分类-</option>
                      @foreach($selects as $select)
                        <option value="{{$select->id}}">{{$select->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>商品组名称</label>
                  <div class="col-sm-4">
                    <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="请输入商品组名称">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">商品组描述</label>
                  <div class="col-sm-4">
                    <input type="text" name="desc" class="form-control" id="inputEmail3" placeholder="请输入商品组描述">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-success btn-100">确认</button>
                    <button type="reset" class="btn btn-success btn-100">重置</button>
                    <a href="{{ url('admin/goods/group') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
@endsection

