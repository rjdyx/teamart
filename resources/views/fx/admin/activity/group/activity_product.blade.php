@extends('fx.admin.layouts.app')

@section('title')
团购商品列表
@endsection
@section('t1')
促销管理
@endsection
@section('css')

@endsection

@section('script')
@parent

@endsection

@section('content')
<!-- Main content of agentRole-->
<section class="content">
  <div class="row">
    <!-- 代理商角色列表 -->
    <div class="col-xs-12">
      <div class="box box-success">
        <div class="box-header">
          <div class="input-group input-group-sm" style="width: 470px;">
            <div class="row">
              <div class="col-sm-4">
                <select class="form-control input-sm">
                  <option>状态</option>
                  <option>1</option>
                  <option>2</option>
                </select>
              </div>
              <div class="col-sm-8"><input type="text" name="name" class="form-control pull-right input-sm" placeholder="请输入搜索团购商品或团购活动名称" id="searchName" value="{{isset($_GET['name'])?$_GET['name']:''}}"></div>
            </div>
            <div class="input-group-btn">
              <button type="submit" onclick="search({{$lists->currentPage()}},['searchName']);" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>

          </div>
          <div class="box-tools">
            @if($flag ==0)
            <form method="GET" action="{{url('admin/activity/activityproduct/create')}}">
            <input type="hidden" name="activity_id" value="{{$activity_id}}">
              <button type="submit" class="btn btn-block btn-success btn-sm" id="addUser">添加团购商品</button>
            </form>
            @endif
          </div>
        </div>       

        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <tbody><tr>
              <th><!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button> --></th>
              <th>编号</th>
              <th>商品名称</th>
              <th>活动名称</th>
              <th>结束时间</th>
              <th>原价</th>                                     
              <th>活动价格</th>
              <th>操作</th>
            </tr>
            @foreach($lists as $list)
            <tr>
              <td><input type="checkbox" value="{{$list->id}}" class="check"></td>
              <td>{{$list->id}}</td>
              <td>{{$list->product_name}}</td>
              <td>{{$list->activity_name}}</i></td>
              <td>{{$list->date_end}}</i></td>



              <td>{{$list->product_price}}</td>
              <td>{{$list->activity_price}}</td>
              <td><div style="color: #dd4b39"><a href="{{url('admin/activity/activityproduct')}}/{{$list->id}}/edit"><i class="fa fa-edit" style="margin-right: 5px;cursor: pointer;"></i></a><i class="fa fa-trash-o" onclick="del({{$list->id}});" style="margin-right: 5px;cursor: pointer;"></div></i>
              </td>
            </tr>
            @endforeach
            <tr>
              <td><button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></td>
              <td><button type="button" onclick="dels();" class="btn btn-block btn-default btn-sm">删除</button></td>
              <th colspan="7">
                <ul class="pagination pagination-sm no-margin pull-right">
                  {{ $lists->appends(['name' => ''])->links() }}
                  共{{ $lists->lastPage() }}页
                </ul> 
              </th>
            </tr>
          </tbody></table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /代理商角色列表 -->
  </div>
</section>
<!-- /.content -->

@endsection