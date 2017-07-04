@extends('fx.admin.layouts.app')
@section('title')代理商结账@endsection
@section('t1')用户管理@endsection
@section('css')
@endsection
@section('script')
    @parent
    <script src="{{url('admin/js/upload.js')}}"></script>
    <script>
      $(function () {
        var form = document.forms['Form']
        $(form).on('submit', function () {
          return submitForm()
        })

        $('#price').on('blur input', function () {
          _valid.number('price', '结账金额', $(this).val())
        });

        function submitForm() {
          var price = form['price']
          var remain = form['remain']
          var count = form['count']
          var v = parseFloat(remain.value) + parseFloat(count.value)
          if (!_valid.number('price', '当前结账金额', price.value)) {
            return false
          }
          if (v < 0.01) {
            _valid.number('price', '金额为0,不能结账-', 0)
            return false
          }
          if (v < price.value) {
            _valid.number('price', '结账金额已超出结账范围-', 0)
            return false
          }
          return true
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
              <h3 class="box-title">代理商结账</h3>
            </div>
            <form class="form-horizontal" action="{{url('admin/user/agent/record/store')}}" method="POST" name="Form">
              {{ csrf_field() }}
              <input type="hidden" value="{{$id}}" name="id" id="id">
              <div class="box-body">
                <div class="form-group">
                  <label for="amount" class="col-sm-3 control-label"><i style="color:red;">*</i>订单总数量</label>
                  <div class="col-sm-4">
                    <input type="text" name="amount" class="form-control" readonly="true" id="amount" placeholder="" value="{{$orders}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="count" class="col-sm-3 control-label"><i style="color:red;">*</i>订单佣金总额</label>
                  <div class="col-sm-4">
                    <input type="text" name="count" class="form-control" readonly="true" id="count" value="{{$prices}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="remain" class="col-sm-3 control-label"><i style="color:red;">*</i>未结清金额</label>
                  <div class="col-sm-4">
                    <input type="text" name="remain" class="form-control" readonly="true" id="remain" value="{{$remain}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="scale" class="col-sm-3 control-label"><i style="color:red;">*</i>当前佣金比率</label>
                  <div class="col-sm-4">
                    <input type="text" name="scale" class="form-control J_FloatNum" readonly="true" id="scale" value="{{$parter->scale}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="price" class="col-sm-3 control-label"><i style="color:red;">*</i>当前结账金额</label>
                  <div class="col-sm-4">
                    <input type="number" name="price" class="form-control" id="price" value="">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="price_txt"></span>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-success btn-100">确认</button>
                    <button type="reset" class="btn btn-success btn-100">重置</button>
                    <a href="{{ url('admin/user/agent/record') }}/{{$id}}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
@endsection

