@extends('fx.admin.layouts.app')
@section('t1')促销管理@endsection
@section('title')新增优惠券@endsection
@section('css')@endsection
@section('script')
    @parent
    <script >
        $(function(){
          datepicker({
            enableTime: true,
            disable: false,
            dateFormat: 'Y-m-d H:i:S'
          })
          var form = document.forms['rollForm']
          $(form).on('submit', function () {
            return submitForm()
          })
          $('#name').on('blur input', function () {
            _valid.title('name', '优惠券名称', $(this).val())
          })
          $('#full').on('blur input', function () {
            _valid.number('full', '满金额', $(this).val())
          })
          $('#cut').on('blur input', function () {
            _valid.number('cut', '减金额', $(this).val())
          })
          $('#amount').on('blur input', function () {
            _valid.number('amount', '数量', $(this).val())
          })
          $('#datepicker').on('blur input', function () {
            _valid.ness('indate', '有效期', $(this).val())
          })
          $('#desc').on('blur input', function () {
            _valid.desc('desc', '描述', $(this).val())
          })
          function submitForm() {
            var name = form['name']
            var full = form['full']
            var cut = form['cut']
            var amount = form['amount']
            var indate = form['indate']
            var desc = form['desc']
            if (!_valid.title('name', '优惠券名称', name.value)) {
              return false
            }
            if (!_valid.number('full', '满金额', full.value)) {
              return false
            }
            if (!_valid.number('cut', '减金额', cut.value)) {
              return false
            }
            if (!_valid.number('amount', '数量', amount.value)) {
              return false
            }
            if (!_valid.ness('indate', '有效期', indate.value)) {
              return false
            }
            if (!_valid.desc('desc', '描述', desc.value)) {
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
        <!-- 编辑商品品牌 -->
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">新增优惠券</h3>
            </div>
            <form class="form-horizontal" name="rollForm" action="{{url('admin/activity/roll')}}" method="POST">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="name" class="col-sm-3 control-label"><i style="color:red;">*</i>优惠券名称</label>
                  <div class="col-sm-4">
                    <input type="text" name="name" class="form-control" id="name" placeholder="请输入优惠券名称"">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="name_txt"></span>
                </div>
                <div class="form-group">
                  <label for="full" class="col-sm-3 control-label">满金额</label>
                  <div class="col-sm-4">
                    <input type="number" name="full" class="form-control" id="full" placeholder="请输入满金额" ">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="full_txt"></span>
                </div>
                <div class="form-group">
                  <label for="cut" class="col-sm-3 control-label">减金额</label>
                  <div class="col-sm-4">
                    <input type="number" name="cut" class="form-control" id="cut" placeholder="请输入减金额" ">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="cut_txt"></span>
                </div>
                <div class="form-group">
                  <label for="amount" class="col-sm-3 control-label">数量</label>
                  <div class="col-sm-4">
                    <input type="number" name="amount" class="form-control" id="amount" placeholder="请输入优惠券数量" ">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="amount_txt"></span>
                </div>
                <div class="form-group">
                  <label for="datepicker" class="col-sm-3 control-label">有效期</label>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <input type="text" name="indate" class="form-control pull-right" id="datepicker">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="indate_txt"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="datepicker" class="col-sm-3 control-label">使用群体</label>
                  <div class="col-sm-4">
                    <select name="range" class="form-control">
                        <option value="0">- 全部 -</option>
                        <option value="1">- 代理商 -</option>
                        <option value="2">- 普通会员 -</option>
                    </select>
                    <span class="col-sm-4 text-danger form_error" id="indate_txt"></span>
                  </div>
                </div>
<!--                 <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">发放状态</label>
                  <div class="col-sm-4">
                    <select name="state" class="form-control">
                      @foreach(App\Cheap::STATE as $key=>$state)
                        @if($key == App\Cheap::CHEAP_OPEN)
                        <option value="{{$key}}" selected> {{$state}}</option>
                        @else
                        <option value="{{$key}}">{{$state}}</option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                </div> -->
                <div class="form-group">
                  <label for="desc" class="col-sm-3 control-label">描述</label>
                  <div class="col-sm-4">
                    <input type="text" name="desc" class="form-control" id="desc" placeholder="请输入优惠券描述">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="desc_txt"></span>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-success btn-100">确认</button>
                    <button type="reset" class="btn btn-success btn-100">重置</button>
                    <a href="{{ url('admin/activity/roll') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
@endsection

