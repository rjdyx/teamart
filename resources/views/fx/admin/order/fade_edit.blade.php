@extends('fx.admin.layouts.app')
@section('title')编辑退货订单@endsection
@section('t1')订单管理@endsection
@section('css')
  <style>
      .showInfo{width:100%;height:auto;float:left;padding-top:20px;padding-bottom: 20px;}
      .showInfo li{width:30%;min-height:30px;float:left;line-height:30px;list-style-type: none;margin-left:3%;margin-top:15px;}
  </style>
@endsection
@section('script')
    @parent
    <script>
      $(function () {
        var form = document.forms['brandForm']
        $(form).on('submit', function () {
          return submitForm()
        });
        function submitForm() {
          return true;
        }
      })
    </script>
@endsection
@section('content')
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">退货订单详情</h3>
            </div>
            <div class="showInfo">
              <li>
                <label for="">订单号: </label>
                <label for="">&nbsp;{{$data->serial}}</label>
              </li>
              <li>
                <label for="">订单状态: </label>
                <label for="">                  
                  @if ($data->state == 'pading') 未付款 @endif
                  @if ($data->state == 'paid') 已付款 @endif
                  @if ($data->state == 'delivery') 已发货 @endif
                  @if ($data->state == 'take') 已收货 @endif
                </label>
              </li>
              <li>
                <label for="">订单总金额: </label>
                <label for="">&nbsp;￥{{sprintf('%.2f', $data->price)}} 元</label>
              </li>
              <li><label for="">用户: </label><label for="">&nbsp;{{$data->user_name}}</label></li>
              <li>
                <label for="">代理商: </label>
                <label for="">&nbsp;@if($data->puser_name) {{$data->puser_name}} @else 无 @endif </label>
              </li>
              <li><label for="">订单创建时间: </label><label for="">&nbsp;{{$data->created_at}}</label></li>
              <li><label for="">订单操作时间: </label><label for="">&nbsp;{{$data->date}}</label></li>
              <li>
                <label for="">提货方式: </label>
                <label for="">@if ($data->type == 'self') 站点自提 @else 物流运输 @endif</label>
              </li>
              @if ($data->method == 'delivery')
              <li>
                <label for="">收货地址: </label>
                <label for="">{{$data->province}}{{$data->city}}{{$data->area}}{{$data->detail}}</label>
              </li>
              <li><label for="">物流单号: </label><label for="">&nbsp;{{$data->delivery_serial}}</label></li>
              <li><label for="">收货人: </label><label for="">&nbsp;{{$data->address_name}}</label></li>
              <li><label for="">联系电话: </label><label for="">&nbsp;{{$data->address_phone}}</label></li>
              @endif
              <li>
                <label for="">备注: </label>
                <label for="">{{$data->memo}}</label>
              </li>
              <li>
                <label for="">退货理由: </label>
                <label for="">{{$data->reason}}</label>
              </li>
            </div>
            <div class="showInfo">
              @foreach($products as $product)
              <li>
              <label for=""><img src="{{url('')}}/{{$product->image}}" alt="" height="80px" width="80px"></label>
              <label for="">￥{{sprintf('%.2f',$product->price)}}</label>
              <div >{{$product->name}}</div>
              </li>
              @endforeach
            </div>
            <form class="form-horizontal" action="{{url('admin/order/fade')}}/{{$data->id}}" method="POST" name="brandForm">
              {{ csrf_field() }}
              <input type="hidden" value="PUT" name="_method">
              <div class="box-body">

                <div class="form-group">
                  <label for="name" class="col-sm-3 control-label"><i style="color:red;">*</i>处理结果</label>
                  <div class="col-sm-4">
                      <select class="form-control input-sm" name="state" onchange="requiedx();">
                        <option value="backy" @if($data->state=='backy')selected @endif > 退 款 (尊从买家意愿)</option>
                        <option value="close" @if($data->state=='close')selected @endif > 不退款 (和买家达成一致) </option>
                      </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-success btn-100">确认</button>
                    <button type="reset" class="btn btn-success btn-100">重置</button>
                    <a href="{{ url('admin/order/fade') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
@endsection

