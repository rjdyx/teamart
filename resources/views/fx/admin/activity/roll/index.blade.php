@extends('fx.admin.layouts.app')

@section('t1')促销管理@endsection
@section('title')优惠券@endsection
@section('css')@endsection

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
                <form action="{{url('admin/activity/roll')}}"" method="GET">
                  <div class="input-group input-group-sm" style="width: 470px;">
                      <div class="row">
                        <div class="col-sm-4">
                          <select name="state" id="searchState" class="form-control input-sm">
                            <option value="">状态</option>
                            @foreach(App\Cheap::STATE as $key=>$state)
                              <option value="{{$key}}"
                                @if(isset($_GET['state'])) 
                                  @if($_GET['state'] == $key) 
                                    selected 
                                  @endif 
                                @endif > 
                                {{$state}}
                              </option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-sm-8"><input type="text" name="name" id="searchName" class="form-control pull-right input-sm" placeholder="请输入搜索内容" value="{{isset($_GET['name'])? $_GET['name']:'' }}"></div>
                      </div>
                      <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                      </div>
                  </div>
                </form>
                <div class="box-tools">
                  <a href="{{ url('admin/activity/roll/create') }}"><button type="button" class="btn btn-block btn-success btn-sm" id="addUser">新建优惠</button></a>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tbody><tr>
                    <th><!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button> --></th>
                    <th>编号</th>
                    <th>优惠券名称</th>
                    <th>满金额</th>
                    <th>减金额</th>
                    <th>数量</th>
                    <th>有效期</th>
                    <th>发放状态</th>
                    <th>描述</th>
                    <th>操作</th>
                  </tr>
                   @foreach ($lists as $k => $list)
                  <tr>
                    <td><input type="checkbox" class="check" value="{{$list->id}}"></td>
                    <td>{{$k + 1}}</td>
                    <td>{{$list->name}}</td>
                    <td>{{$list->full}}</td>
                    <td>{{$list->cut}}</td>
                    <td>{{$list->amount}}</td>
                    <td>{{$list->indate}}</td>
                    <td>{{App\Cheap::STATE[$list->state]}}</td>
                    <td>{{$list->desc}}</td>
                    <td>
                      <div style="color: #dd4b39">
                      <a href="{{url('admin/activity/roll/')}}/{{$list->id}}/edit">
                      <i class="fa fa-edit" style="margin-right: 5px;cursor: pointer;"></i></a>
                      <i class="fa fa-trash-o" onclick="del({{$list->id}});" style="margin-right: 5px;cursor: pointer;"></i>
                      </div>
                   </td>
                  </tr>
                  @endforeach
                  <tr>
                    <td><button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></td>
                    <td><button type="button" onclick="dels();" class="btn btn-block btn-default btn-sm">删除</button></td>
                    <th colspan="8">
                      <ul class="pagination pagination-sm no-margin pull-right">
                          {{$lists->appends(['name' => isset($_GET['name'])? $_GET['name']:'' ,'state'=>isset($_GET['state'])? $_GET['state']:'' ])->links() }}
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

@endsection
