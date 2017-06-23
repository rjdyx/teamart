@extends('fx.admin.layouts.app')

@section('title')
编辑站点
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
          <!-- 新增代理商角色 -->
          <div class="col-xs-12">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">新站点</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form action="{{url('admin/system/site')}}/{{$site->id}}" method="post" class="form-horizontal">
                {{ csrf_field() }}
                <input type="hidden" value="PUT" name="_method">
                <div class="box-body">
                  <div class="form-group">
                    <label for="storename" class="col-sm-2 control-label">省份</label>
                    <div class="col-sm-10">
                      <input type="text" name="province" class="form-control" id="storename" placeholder="请输入省份" value="{{$site->province}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="storeBusiness" class="col-sm-2 control-label">城市</label>
                    <div class="col-sm-10">
                      <input type="text" name="city" class="form-control" id="storeBusiness" placeholder="请输入城市" value="{{$site->city}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="Contacts" class="col-sm-2 control-label">地区</label>
                    <div class="col-sm-10">
                      <input type="text" name="area" class="form-control" id="Contacts" placeholder="请输入地区"  value="{{$site->area}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">描述</label>
                    <div class="col-sm-10">
                      <textarea name="detail" class="form-control" rows="3" placeholder="请输入描述 ...">{{$site->detail}}</textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="Contacts" class="col-sm-2 control-label">联系人</label>
                    <div class="col-sm-10">
                      <input type="text" name="user" class="form-control" id="Contacts" placeholder="请输入地图经纬度"  value="{{$site->user}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="Contacts" class="col-sm-2 control-label">联系电话</label>
                    <div class="col-sm-10">
                      <input type="text" name="phone" class="form-control" id="Contacts" placeholder="请输入地图经纬度"  value="{{$site->phone}}">
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
