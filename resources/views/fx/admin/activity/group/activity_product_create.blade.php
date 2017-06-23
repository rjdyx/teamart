 @extends('fx.admin.layouts.app')
 @section('title')新增团购商品@endsection
 @section('t1')促销管理@endsection
 @section('css')
 @endsection
 @section('script')
 @parent
 @endsection
 @section('content')
 <!-- Main content of addGgent-->
 <section class="content">
  <div class="row">
    <!-- 新增代理商角色 -->
    <div class="col-xs-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">新增团购商品</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="{{url('admin/activity/activityproduct')}}" method="POST" name="listForm" enctype="multipart/form-data">
           {{ csrf_field() }}
         <div class="form-group">
              <label class="col-sm-2 control-label"><i style="color:red;">*</i>商品列表</label>
              <div class="col-sm-6">
                <select class="form-control pull-left" style="width: 50%" name="product_id" id="product_id">
                  <option value="">-请选择参与团购商品-</option>
                  @foreach ($products as $product)
                  <option value="{{$product->id}}">{{$product->name}}</option>
                  @endforeach
                </select>
              </div>
              <span class="col-sm-4 text-danger form_error" id="category_id_txt"></span>
            </div>   
            <div class="form-group">
              <label class="col-sm-2 control-label"><i style="color:red;">*</i>团购活动列表</label>
              <div class="col-sm-6">
                <select class="form-control pull-left" style="width: 50%" name="activity_id" id="activity_id">
                  <option value="">-请选择团购活动-</option>
                  @foreach ($activities as $activity)
                  <option value="{{$activity->id}}">{{$activity->name}}</option>
                  @endforeach
                </select>
                <a class="pull-left ml-10" href="{{ url('admin/activity/group/create') }}"><button type="button" class="btn btn-success btn-100">新增活动</button></a>
              </div>
              <span class="col-sm-4 text-danger form_error" id="category_id_txt"></span>
            </div>         
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-success btn-100">确认</button>
                  <button type="reset" class="btn btn-success btn-100">重置</button>
                  <a href="{{ url('admin/activity/activityproduct') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addUser">取消</button></a>
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
