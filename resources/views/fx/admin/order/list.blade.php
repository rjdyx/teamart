@extends('fx.admin.layouts.app')
@section('title')订单列表@endsection
@section('t1')订单管理@endsection
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
            <div class="input-group input-group-sm" style="width: 80%;">
                <div class="row">
                    <div class="col-sm-2">
                      <select class="form-control input-sm" id="searchState" name="state">
                        <option value="" > - 订 单 状 态 - </option>
                        <option value="pading" @if(isset($_GET['state'])) @if ($_GET['state'] =='pading') selected @endif @endif> 未 付 款 </option>
                        <option value="paid"@if(isset($_GET['state'])) @if ($_GET['state'] =='paid') selected @endif @endif> 已 付 款 </option>
                        <option value="delivery"@if(isset($_GET['state'])) @if ($_GET['state'] =='delivery') selected @endif @endif> 已 发 货 </option>
                        <option value="take"@if(isset($_GET['state'])) @if ($_GET['state'] =='take') selected @endif @endif> 已 收 货 </option>
                      </select>
                    </div>
                    <div class="col-sm-3" style="padding: 0px;">
                    <input type="text" name="serial" class="form-control pull-right input-sm" id="searchSerial" placeholder="请输入订单号搜索" value="{{isset($_GET['serial'])? $_GET['serial']:''}}">
                    </div>
                    <div class="input-group-btn">
                    <button type="button" onclick="search({{$lists->currentPage()}},['searchSerial','searchState']);" class="btn btn-default">
                    <i class="fa fa-search"></i>
                    </button>
                    </div>
                </div>
            </div>
          </div>

          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <tbody><tr>
                <th>编号</th>
                <th>订单号</th>
                <th>提货方式</th>
                <th>购买用户</th>
                <th>代理商</th>
                <th>总金额</th>
                <th>订单创建时间</th>
                <th>订单操作时间</th>
                <th>订单状态</th>
                <th>备注</th>
                <th>操作</th>
              </tr>
              @foreach ($lists as $k => $list)
              <tr>
                <td>{{$k + 1}}</td>
                <td>{{$list->serial}}</td>
                <td>@if ($list->type == 'self') 站点自提 @else 物流运输 @endif</td>
                <td>{{$list->user_name}}</td>
                <td>@if($list->puser_name) {{$list->puser_name}} @else 无 @endif</td>
                <td>{{sprintf('%.2f', $list->price)}}</td>
                <td>{{$list->created_at}}</td>
                <td>{{$list->date}}</td>
                <td>
                  @if ($list->state == 'pading') 未付款 @endif
                  @if ($list->state == 'paid') 已付款 @endif
                  @if ($list->state == 'delivery') 已发货 @endif
                  @if ($list->state == 'take') 已收货 @endif
                </td>
                <td>{{$list->memo}}</td>
                <td>
                  <div style="color: #dd4b39">
                  <a href="{{url('admin/order/list')}}/{{$list->id}}/edit">
                  <i class="fa fa-edit" style="margin-right: 5px;cursor: pointer;"></i></a>
                  </div>
               </td>
              </tr>
              @endforeach
              <tr>
                <th colspan="11">
                  <ul class="pagination pagination-sm no-margin pull-right">
                      {{ $lists->appends(['serial' => '','state'=> ''])->links() }}
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
