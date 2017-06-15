@extends('fx.admin.layouts.app')

@section('title')
代理商
@endsection

@section('css')
@endsection

@section('script')
    @parent

@endsection

@section('content')
  @include("fx.admin.layouts.header")

  @include("fx.admin.layouts.left")

  <div class="content-wrapper">
    <!-- agentRole -->
    <div id="agentRole">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1 style="cursor: pointer;">
          <i class="fa fa-home" style="color: #00a65a;margin-right:4px"></i>用户管理
          <small style="color: #00a65a"><i class="fa fa-angle-right" style="margin-right: 4px"></i>代理商角色</small>
        </h1>
      </section>

      <!-- Main content of agentRole-->
      <section class="content">
        <div class="row">
          <!-- 代理商角色列表 -->
          <div class="col-xs-12">
            <div class="box box-success">
              <div class="box-header">
                <div class="input-group input-group-sm" style="width: 470px;">
                    <input type="text" id="searchName" name="name" class="form-control pull-right" placeholder="请输入角色名称搜索" value="{{isset($_GET['name'])? $_GET['name']:''}}">

                    <div class="input-group-btn">
                      <button type="button" onclick="search({{$lists->currentPage()}},['searchName','b']);" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <div class="box-tools">
                  <a href="{{ url('admin/user/agentrole/create') }}"><button type="button" class="btn btn-block btn-success btn-sm" id="addNewAgent">新建角色</button></a>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>复选框</th>
                    <th>编号</th>
                    <th>分销角色名称</th>
                    <th>分销金额比例</th>
                    <th>描述</th>
                    <th>操作</th>
                  </tr>
                  @foreach ($lists as $k=>$list)
                  <tr>
                    <td><input type="checkbox" class="check" value="{{$list->id}}"></td>
                    <td>{{$k+1}}</td>
                    <td>{{$list->name}}</td>
                    <td>{{$list->scale}}</td>
                    <td>{{$list->desc}}</td>
                    <td>
                    <div style="color: #dd4b39">
                    <a href="{{url('admin/user/agentrole')}}/{{$list->id}}/edit">
                    <i class="fa fa-edit" style="margin-right: 5px;cursor: pointer;"></i></a>
                    <i class="fa fa-trash-o" onclick="del({{$list->id}});" style="margin-right: 5px;cursor: pointer;"></i>
                    </div>
                   </td>
                  </tr>
                  @endforeach
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
    </div>
  </div>
   
@endsection
