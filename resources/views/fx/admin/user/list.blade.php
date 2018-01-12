@extends('fx.admin.layouts.app')
@section('title')用户列表@endsection
@section('t1')用户管理@endsection
@section('css')@endsection
@section('script')
    @parent
@endsection
@section('content')
    <!-- Main content of agentRole-->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header">
              <div class="input-group input-group-sm" style="width: 470px;">
                  <input type="text" id="searchName" name="name" class="form-control pull-right" placeholder="请输入用户名或姓名搜索" value="{{isset($_GET['name'])? $_GET['name']:''}}">
                  <div class="input-group-btn">
                    <button type="button" onclick="search({{$lists->currentPage()}},['searchName']);" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
                <div class="box-tools">
                <a href="{{ url('admin/user/list/create') }}"><button type="button" class="btn btn-block btn-success btn-sm" id="addNewAgent">新建</button></a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th>复选框</th>
                  <th>编号</th>
                  <th>用户名</th>
                  <th>姓名</th>
                  <th>手机</th>
                  <th>邮箱</th>
                  <th>性别</th>
                  <th>年龄</th>
                  <th>消费积分</th>
                  <th>操作</th>
                </tr>
                @foreach ($lists as $k=>$list)
                <tr>
                  <td><input type="checkbox" class="check" value="{{$list->id}}"></td>
                  <td>{{$k+1}}</td>
                  <td>{{$list->name}}</td>
                  <td>{{$list->realname}}</td>
                  <td>{{$list->phone}}</td>
                  <td>{{$list->email}}</td>
                  <td>@if($list->gender) 女 @else 男 @endif</td>
                  <td>@if ($list->birth_date) {{date('Y') - date('Y',strtotime($list->birth_date))}} @else 0 @endif </td>
                  <td>{{$list->grade}}</td>
                  <td>
                  <div style="color: #dd4b39">
                    <a href="{{url('admin/user/list')}}/{{$list->id}}/edit" title="编辑">
                      <i class="fa fa-edit" style="margin-right: 10px;"></i>
                    </a>
                    <i class="fa fa-trash-o" title="删除" onclick="del({{$list->id}});" style="cursor: pointer;"></i>
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
