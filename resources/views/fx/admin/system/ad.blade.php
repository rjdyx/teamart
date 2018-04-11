@extends('fx.admin.layouts.app')

@section('title')
广告设置
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
          <div class="box-header">
              <div class="input-group input-group-sm" style="width: 470px;">
                  <div class="row">
                    <div class="col-sm-12"><input type="text" id="searchTitle" name="title" class="form-control pull-right input-sm" placeholder="请输入标题搜索" value="{{isset($_GET['title'])? $_GET['title']:'' }}" ></div>
                  </div>
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" onclick="search({{$lists->currentPage()}},['searchTitle']);"><i class="fa fa-search"></i></button>
                  </div>
              </div>
            <div class="box-tools">
              <a href="{{ url('admin/system/ad/create') }}"><button type="button" class="btn btn-block btn-success btn-sm" id="addUser">新建广告</button></a>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <tbody><tr>
                <th>多选框</th>
                <th>编号</th>
                <th>标题</th>
                <th>描述</th>
                <th>图片</th>
                <th>链接</th>
                <th>展示位置</th>
                <th>状态</th>
                <th>操作</th>
              </tr>
              @foreach($lists as $k => $list)
                <tr>
                  <td><input type="checkbox" class="check" value="{{$list->id}}"></td>
                  <td>{{$k + 1}}</td>
                  <td>{{$list->title}}</td>
                  <td>{{$list->desc}}</td>
                  <td><img src="{{url('')}}/{{$list->thumb}}" alt="图片" width="40px" height="40px"></td>
                  <td>{{$list->url}}</td>
                  <td>@if($list->position == 'index')首页@endif</td>
                  <td>@if($list->state)开启 @else 关闭 @endif</td>
                  <td>
                  <a href="{{url('admin/system/ad')}}/{{$list->id}}/edit">
                  <i class="fa fa-edit" style="margin-right: 5px;cursor: pointer;"></i></a>
                  <i class="fa fa-trash-o" onclick="del({{$list->id}});" style="margin-right: 5px;cursor: pointer;"></i>
                 </td>
                </tr>
              @endforeach
              <tr>
                <td><button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></td>
                <td><button type="button" onclick="dels();" class="btn btn-block btn-default btn-sm">删除</button></td>
                <th colspan="7">
                  <ul class="pagination pagination-sm no-margin pull-right">
                    {{$lists->appends(['title' => isset($_GET['title'])? $_GET['title']:''])->links() }}
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
    </div>
  </section>
@endsection
