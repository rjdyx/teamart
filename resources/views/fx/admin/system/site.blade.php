@extends('fx.admin.layouts.app')

@section('title')
站点设置
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
        <!-- 代理商角色列表 -->
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header">
              <form action="{{url('admin/system/site')}}"" method="GET">
                <div class="input-group input-group-sm" style="width: 470px;">
                    <div class="row">
                      <div class="col-sm-12"><input type="text" name="detail" class="form-control pull-right input-sm" placeholder="请输入搜索内容" value="{{isset($_GET['detail'])? $_GET['detail']:'' }}" ></div>
                    </div>
                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
              </form>  
              <div class="box-tools">
                <a href="{{url('/admin/system/site/create')}}"><button type="button" class="btn btn-block btn-success btn-sm">新建站点</button></a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th>多选框</th>
                  <th>序号</th>
                  <th>站点名称</th>
                  <th>经度</th>
                  <th>纬度</th>
                  <th>联系人</th>
                  <th>联系电话</th>
                  <th>操作</th>
                </tr>
                @foreach($lists as $k => $list)
                  <tr>
                    <td><input type="checkbox" class="check" value="{{$list->id}}"></td>
                    <td>{{$k + 1}}</td>
                    <td>{{$list->name}}</td>
                    <td>{{$list->longitude}}</td>
                    <td>{{$list->latitude}}</td>
                    <td>{{$list->user}}</td>
                    <td>{{$list->phone}}</td>
                    <td>
                    <a href="{{url('admin/system/site/')}}/{{$list->id}}/edit">
                    <i class="fa fa-edit" style="margin-right: 5px;cursor: pointer;"></i></a>
                    <i class="fa fa-trash-o" onclick="del({{$list->id}});" style="margin-right: 5px;cursor: pointer;"></i>
                   </td>
                  </tr>
                @endforeach
                <tr>
                  <td><button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></td>
                  <td><button type="button" onclick="dels();" class="btn btn-block btn-default btn-sm">删除</button></td>
                  <th colspan="8">
                    <ul class="pagination pagination-sm no-margin pull-right">
                      {{$lists->appends(['detail' => isset($_GET['detail'])? $_GET['detail']:''])->links() }}
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
@endsection
