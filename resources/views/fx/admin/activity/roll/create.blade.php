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
            <form class="form-horizontal" action="{{url('admin/activity/roll')}}" method="POST">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>优惠券名称</label>
                  <div class="col-sm-4">
                    <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="请输入优惠券名称"">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">满金额</label>
                  <div class="col-sm-4">
                    <input type="number" name="full" class="form-control" id="inputEmail3" placeholder="请输入满金额" ">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">减金额</label>
                  <div class="col-sm-4">
                    <input type="number" name="cut" class="form-control" id="inputEmail3" placeholder="请输入减金额" ">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">数量</label>
                  <div class="col-sm-4">
                    <input type="number" name="amount" class="form-control" id="inputEmail3" placeholder="请输入优惠券数量" ">
                  </div>
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
                    <span class="col-sm-4 text-danger form_error" id="date_txt"></span>
                  </div>
                </div>
                <div class="form-group">
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
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">描述</label>
                  <div class="col-sm-4">
                    <input type="text" name="desc" class="form-control" id="inputEmail3" placeholder="请输入优惠券描述">
                  </div>
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

