@extends('fx.admin.layouts.app')
@section('title')编辑订单@endsection
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
      function requiedx(){
        var method = $("form select[name='method']").val();
        var state = $("form select[name='state']").val();
        if (method!='self' && state !='pading' && state!='paid'){
          $('.fhrequied').html('*');
        }else{
          $('.fhrequied').html('');
        }
        if (method == 'self') {
          $('#delivery_serial, #coding').attr('disabled', true).val('')
        } else {
          $('#delivery_serial, #coding').attr('disabled', false)
        }
      }
      requiedx();
      $(function () {
        var form = document.forms['brandForm']
        $(form).on('submit', function () {
          return submitForm()
        });
        function submitForm() {
          var method = $("form select[name='method']").val();
          var state = $("form select[name='state']").val();
          if (method != 'self' && state != 'pading' && state != 'paid'){
            if (!$("#delivery_serial").val()) {
              $("#delivery_serial_txt").html('请填入订单号');
              return false
            }
          }
          if (state != 'pading' && state != 'paid') {
            if (!$("form select[name='method']").val()) {
              $("#method_txt").html('请选择取货方式');
              return false
            }
          }
          return true
        }
      })
    </script>
@endsection
@section('content')
    <section class="content">
      <div class="row">
        <!-- 编辑商品品牌 -->
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">编辑订单</h3>
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
              <li><label for="">快递公司: </label><label for="">&nbsp;{{$data->coding}}</label></li>
              <li><label for="">收货人: </label><label for="">&nbsp;{{$data->address_name}}</label></li>
              <li><label for="">联系电话: </label><label for="">&nbsp;{{$data->address_phone}}</label></li>
              @endif
              <li>
                <label for="">备注: </label>
                <label for="">{{$data->memo}}</label>
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
            <form class="form-horizontal" action="{{url('admin/order/list')}}/{{$data->id}}" method="POST" name="brandForm">
              {{ csrf_field() }}
              <input type="hidden" value="PUT" name="_method">
              <div class="box-body">

                <div class="form-group">
                  <label for="name" class="col-sm-3 control-label"><i style="color:red;">*</i>订单状态</label>
                  <div class="col-sm-4">
                      <select class="form-control input-sm" name="state" onchange="requiedx();">
                        <option value="pading" @if($data->state=='pading')selected @endif > 未 付 款 </option>
                        <option value="paid" @if($data->state=='paid')selected @endif > 已 付 款 </option>
                        <option value="delivery" @if($data->state=='delivery')selected @endif > 已 发 货 </option>
                        <option value="take" @if($data->state=='take')selected @endif > 已 收 货 </option>
                      </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="name" class="col-sm-3 control-label"><i style="color:red;">*</i>取货方式</label>
                  <div class="col-sm-4">
                      <select class="form-control input-sm" name="method" onchange="requiedx();">
                        <option value="self" @if($data->method=='self')selected @endif > 站 点 自 提 </option>
                        <option value="delivery" @if($data->method=='delivery')selected @endif > 物 流 运 输 </option>
                      </select>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="method_txt"></span>
                </div>
                <div class="form-group">
                  <label for="name" class="col-sm-3 control-label">快递公司</label>
                  <div class="col-sm-4">
                    <select class="form-control input-sm" name="coding" id="coding" onchange="requiedx();">
                    <option value="">-请选择快递公司-</option>
                    <option value="EMS" @if($data->coding=='EMS')selected @endif >EMS</option>
                    <option value="STO" @if($data->coding=='STO')selected @endif >申通快递</option>
                    <option value="HHTT" @if($data->coding=='HHTT')selected @endif >天天快递</option>
                    <option value="DBL" @if($data->coding=='DBL')selected @endif >德邦快递</option>
                    <option value="SF" @if($data->coding=='SF')selected @endif >顺丰快递</option>
                    <option value="YD" @if($data->coding=='YD')selected @endif >韵达快递</option>
                    <option value="ZJS" @if($data->coding=='ZJS')selected @endif >宅急送</option>
                    <option value="ZTO" @if($data->coding=='ZTO')selected @endif >中通快递</option>
                    <option value="HTKY" @if($data->coding=='HTKY')selected @endif >百世快递</option>
                    <option value="YTO" @if($data->coding=='YTO')selected @endif >圆通快递</option>
                    </select>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="method_txt"></span>
                </div>
                <div class="form-group" id="changeHide">
                  <label for="delivery_serial" class="col-sm-3 control-label">
                      <i style="color:red;" class="fhrequied"></i>物流订单号
                  </label>
                  <div class="col-sm-4">
                    <input type="text" name="delivery_serial" class="form-control" id="delivery_serial" 
                    placeholder="请输入物流订单号" value="{{$data->delivery_serial}}">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="delivery_serial_txt"></span>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-success btn-100">确认</button>
                    <button type="reset" class="btn btn-success btn-100">重置</button>
                    <a href="{{ url('admin/order/list') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
@endsection

