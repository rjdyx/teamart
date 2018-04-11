@extends('fx.admin.layouts.app')
@section('title')商品分类@endsection
@section('t1')商品管理@endsection
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
            <div class="input-group input-group-sm" style="width: 470px;">
                <input type="text" name="name" class="form-control pull-right input-sm" placeholder="请输入商品分类名称搜索" id="searchName" value="{{isset($_GET['name'])?$_GET['name']:''}}">
                <div class="input-group-btn">
                  <button type="submit" onclick="search({{$lists->currentPage()}},['searchName']);" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>
            <div class="box-tools">
              <a href="{{ url('admin/goods/category/create') }}"><button type="button" class="btn btn-block btn-success btn-sm" id="addUser">新建分类</button></a>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <tbody><tr>
                <th>复选框</th>
                <th>编号</th>
                <th>图片</th>
                <th>商品分类名称</th>
                <th>描述</th>
                <th>操作</th>
              </tr>
              @foreach ($lists as $k => $list)
              <tr>
                <td><input type="checkbox" class="check" value="{{$list->id}}"></td>
                <td>{{$k + 1}}</td>
                <td><img src="{{url('')}}/{{ $list->thumb }}" alt="图标" width="30px" height="30px"></td>
                <td>{{$list->name}}</td>
                <td>{{$list->desc}}</td>
                <td>
                  <div style="color: #dd4b39">
                  <a href="{{url('admin/goods/category')}}/{{$list->id}}/edit">
                  <i class="fa fa-edit" style="margin-right: 5px;cursor: pointer;"></i></a>
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
                      {{ $lists->appends(['name' => ''])->links() }}
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
