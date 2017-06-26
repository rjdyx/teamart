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
                  <button type="button" class="btn btn-block btn-success btn-sm" id="addUser">新建站点</button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>多选框</th>
                    <th>编号</th>
                    <th>省份</th>
                    <th>城市</th>
                    <th>地区</th>
                    <th>详细描述</th>
                    <th>联系人</th>
                    <th>联系电话</th>
                    <th>操作</th>
                  </tr>
                  @foreach($lists as $k => $list)
                    <tr>
                      <td><input type="checkbox" class="check" value="{{$list->id}}"></td>
                      <td>{{$k + 1}}</td>
                      <td>{{$list->province}}</td>
                      <td>{{$list->city}}</td>
                      <td>{{$list->area}}</td>
                      <td>{{$list->detail}}</td>
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
                    <th colspan="7">
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
      <!-- /.content -->
    </div>
    <!-- /agentRole -->

    <!-- addagent -->
    <div id="addAgent">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1 style="cursor: pointer;">
          <a href="#" style="color: #000"><i class="fa fa-home fa_skin" style="margin-right:4px"></i>系统管理</a>
          <a href="#"><small class="fa_skin"><i class="fa fa-angle-right" style="margin-right: 4px"></i>新建站点</small></a>
        </h1>
      </section>
      <!-- Main content of addGgent-->
      <section class="content">
        <div class="row">
          <!-- 新增代理商角色 -->
          <div class="col-xs-12">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">新站点</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form action="{{url('admin/system/site')}}" method="post" class="form-horizontal">
                {{ csrf_field() }}
                <div class="box-body">
                  <div class="form-group">
                    <label for="storename" class="col-sm-2 control-label">省份</label>
                    <div class="col-sm-10">
                      <input type="text" name="province" class="form-control" id="storename" placeholder="请输入省份">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="storeBusiness" class="col-sm-2 control-label">城市</label>
                    <div class="col-sm-10">
                      <input type="text" name="city" class="form-control" id="storeBusiness" placeholder="请输入城市">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="Contacts" class="col-sm-2 control-label">地区</label>
                    <div class="col-sm-10">
                      <input type="text" name="area" class="form-control" id="Contacts" placeholder="请输入地区">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">描述</label>
                    <div class="col-sm-10">
                      <textarea name="detail" class="form-control" rows="3" placeholder="请输入描述 ..."></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="Contacts" class="col-sm-2 control-label">联系人</label>
                    <div class="col-sm-10">
                      <input type="text" name="user" class="form-control" id="Contacts" placeholder="请输入地图经纬度">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="Contacts" class="col-sm-2 control-label">联系电话</label>
                    <div class="col-sm-10">
                      <input type="text" name="phone" class="form-control" id="Contacts" placeholder="请输入地图经纬度">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-success btn-100">确认</button>
                      <button type="reset" class="btn btn-success btn-100">重置</button>
                      <button type="button" class="btn btn-success btn-100" id="cancel_addUser">取消</button>
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
