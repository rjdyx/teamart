@extends('fx.admin.layouts.app')
@section('title')系统日志@endsection
@section('t1')系统管理@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{url('admin/js/datepicker/datepicker3.css')}}">
@endsection
@section('script')
  @parent
    <script src="{{url('admin/js/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{url('admin/js/datepicker/locales/bootstrap-datepicker.zh-CN.js')}}"></script>
    <script>
    	$('#date').datepicker({
          	language: 'zh-CN',
          	format: 'yyyy-mm-dd'
        });
    </script>
@endsection
@section('content')
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <div class="input-group input-group-sm" style="width: 470px;">
                <div class="input-group">
                  <input type="text" name="date" class="form-control pull-right" id="date" value="{{isset($_GET['date'])?$_GET['date']:''}}">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                </div>
                <div class="input-group-btn">
                  <button type="submit" onclick="search({{$lists->currentPage()}},['date']);" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>
<!--             <div class="box-tools">
              <a href="{{ url('admin/goods/brand/create') }}"><button type="button" class="btn btn-block btn-success btn-sm" id="addUser">新建</button></a>
            </div> -->
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <tbody><tr>
                <th>复选框</th>
                <th>编号</th>
                <th>数据表名</th>
                <th>操作</th>
                <th>用户</th>
                <th>时间</th>
                <th>Ip地址</th>
                <th>操作</th>
              </tr>
              @foreach ($lists as $k => $list)
              <tr>
                <td><input type="checkbox" class="check" value="{{$list->id}}"></td>
                <td>{{$k + 1}}</td>
                <td>{{$list->table}}</td>
                <td>{{$list->operate}}</td>
                <td>{{$list->name}}</td>
                <td>{{$list->created_at}}</td>
                <td>{{$list->ip}}</td>
                <td>
                  <div style="color: #dd4b39">
                  <i class="fa fa-trash-o" onclick="del({{$list->id}});" style="margin-right: 5px;cursor: pointer;"></i>
                  </div>
               </td>
              </tr>
              @endforeach
              <tr>
                <td><button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></td>
                <td><button type="button" onclick="dels();" class="btn btn-block btn-default btn-sm">删除</button></td>
                <th colspan="7">
                  <ul class="pagination pagination-sm no-margin pull-right">
                      {{ $lists->appends(['date' => ''])->links() }}
                      共{{ $lists->lastPage() }}页
                  </ul>
                </th>
              </tr>
            </tbody></table>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
