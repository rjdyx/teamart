@extends('fx.admin.layouts.app')
@section('title')文章列表@endsection
@section('t1')文章管理@endsection
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
              <div class="col-sm-12"><input type="text" name="name" class="form-control pull-right input-sm" placeholder="请输入文章分类名称搜索" id="searchName" value="{{isset($_GET['name'])?$_GET['name']:''}}"></div>
            </div>
           <div class="input-group-btn">
              <button type="submit" onclick="search({{$lists->currentPage()}},['searchName']);" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
          </div>
          <div class="box-tools">
            <a href="{{ url('admin/article/list/create') }}"><button type="button" class="btn btn-block btn-success btn-sm" id="addUser">新建文章</button></a>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <tbody><tr>
              <th><!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button> --></th>
              <th>编号</th>
              <th>文章标题</th>
              <th>文章分类</th>
              <th>图片</th>
              <th>更新日期</th>
              <th>操作</th>
            </tr>
            @foreach ($lists as $k => $list)
            <tr>
              <td><input type="checkbox" class="check" value="{{$list->id}}"></td>
              <td>{{$list->id}}</td>
              <td>{{$list->name}}</td>
              <td>{{$list->category_name}}</i></td>
              <td><img src="{{ url('')}}/{{ $list->thumb }}" alt="图标" width="30px" height="30px"></td>
              <td>{{$list->updated_at}}</td>
              <td><div style="color: #dd4b39"><a href="{{url('admin/article/list')}}/{{$list->id}}/edit"><i class="fa fa-edit" style="margin-right: 5px;cursor: pointer;"></i></a><i class="fa fa-trash-o"  onclick="del({{$list->id}});" style="margin-right: 5px;cursor: pointer;"></div></i>
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
