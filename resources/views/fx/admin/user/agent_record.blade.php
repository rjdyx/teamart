@extends('fx.admin.layouts.app')
@section('title')代理商@endsection
@section('t1')用户管理@endsection
@section('css')@endsection
@section('script')
  @parent
  <script>
    datepicker.datepicker();
    var url = 'http://' + window.location.host;
      //单条删除
      function gdel(id) {
        if (confirm('确定要删除这条记录吗？')==true){ 
          $("#gdel").attr('action', url + '/admin/user/agent/record/del?id=' + id);
          $("#gdel").submit();
        }
      }
      //多条删除
      function gdels() {
        if ($(".check:checked").length > 0) {
          if (confirm('确定要删除选中记录吗？')==true){ 
            var ids = Array();
            $("#dels").attr('action', url + '/admin/user/agent/record/dels');
            $(".check:checked").each(function(){
                ids.push($(this).val());
            });
            $("#delsIds").val(ids);
            $("#dels").submit();
          }
        }
      }
  </script>
@endsection
@section('content')
    <!-- 单条数据删除 -->
    <form action="" method="POST" id="gdel">
      {{ csrf_field() }}
    </form>
    <!-- Main content of agentRole-->
    <section class="content">
      <div class="row">
        <!-- 代理商角色列表 -->
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header">
              <div class="input-group input-group-sm" style="width: 470px;">
                <div class="form-group">
                  <label for="datepicker" class="col-sm-3 control-label">结账日期</label>
                  <div class="col-sm-6">
                    <div class="input-group">
                      <input type="text" name="date" class="form-control pull-right" id="datepicker" onchange="search({{$lists->currentPage()}},['datepicker']);" value="{{isset($_GET['date'])? $_GET['date']:''}}"">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                    </div>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="date_txt"></span>
                </div>
              </div>

                <div class="box-tools">
                <a href="{{ url('admin/user/agent/record/solve') }}/{{$id}}"><button type="button" class="btn btn-block btn-success btn-sm" id="addNewAgent">给代理商结账</button></a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th>复选框</th>
                  <th>编号</th>
                  <th>订单数量</th>
                  <th>总金额</th>
                  <th>结账日期</th>
                  <th>佣金比率</th>
                  <th>结账金额</th>
                  <th>未结清金额</th>
                  <th>操作</th>
                </tr>
                @foreach ($lists as $k=>$list)
                <tr>
                  <td><input type="checkbox" class="check" value="{{$list->id}}"></td>
                  <td>{{$k+1}}</td>
                  <td>{{$list->amount}}</td>
                  <td>&yen {{$list->count}}</td>
                  <td>{{$list->date}}</td>
                  <td>{{$list->scale}}</td>
                  <td>{{$list->price}}</td>
                  <td>{{$list->remain}}</td>
                  <td>
                  <div style="color: #dd4b39">
                  <i class="fa fa-trash-o" onclick="gdel({{$list->id}});" style="margin-right: 5px;cursor: pointer;"></i>
                  </div>
                 </td>
                </tr>
                @endforeach
                <tr>
                  <td><button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></td>
                  <td><button type="button" onclick="gdels();" class="btn btn-block btn-default btn-sm">删除</button></td>
                  <th colspan="8">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        {{ $lists->appends(['name' => '','role'=> ''])->links() }}
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
