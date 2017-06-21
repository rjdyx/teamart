@extends('fx.admin.layouts.app')

@section('t1')
系统管理
@endsection
@section('title')
店铺设置
@endsection

@section('css')

@endsection

@section('script')
    @parent
    <script src="{{url('admin/js/upload.js')}}"></script>
    <script src="{{url('admin/js/uploads.js')}}"></script>
@endsection

@section('content')
   
      <!-- Main content of addGgent-->
      <section class="content">
        <div class="row">
          <!-- 新增代理商角色 -->
          <div class="col-xs-12">
            <div class="box box-success">
              
              <!-- form start -->
              <form action="{{url('admin/system/shop')}}/{{$shop->id}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" value="PUT" name="_method">
                <div class="box-body">
                  <div class="form-group">
                    <label for="storeName" class="col-sm-2 control-label">网站名称</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="storeName" placeholder="请输入商店名称" name="name" value="{{$shop->name}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="storeTitle" class="col-sm-2 control-label">意见邮箱</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="storeTitle" placeholder="请输入联系email" name="email" value="{{$shop->email}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="storeAddress" class="col-sm-2 control-label">热线电话</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="storeAddress" placeholder="请输入联系电话" name="phone" value="{{$shop->phone}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">验证码开关状态</label>
                    <div class="col-sm-10">
                      <label class="col-sm-1 gender_label control-label">
                        <input type="radio" name="verify_state" id="gender_female" value="0" @if($shop->verify_state===0)checked="checked"@endif>关闭
                      </label>
                      <label class="col-sm-11 gender_label control-label">
                        <input type="radio" name="verify_state" id="gender_male" value="1" @if($shop->verify_state===1)checked="checked"@endif >打开
                      </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="storeTel" class="col-sm-2 control-label">免邮金额</label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control" id="storeTel" placeholder="请输入免邮金额" name="free" value="{{$shop->free}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="storeNum" class="col-sm-2 control-label">备案号</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="storeNum" placeholder="请输入备案号" name="record" value="{{$shop->record}}">
                    </div>
                  </div>
                  <!-- logo -->
                  <div class="form-group">
                    <label class="col-sm-2 control-label">logo</label>
                    <div class="col-sm-4">
                      <div class="upload_single">
                        <label for="img" class="upload pull-left">
                          <i class="glyphicon glyphicon-plus"></i>
                        </label>
                        <!-- <img class="pull-left upload_img" src="{{url('/admin/images/photo1.png')}}"> -->
                        <label class="btn btn-primary pull-left ml-10 invisible" for="img">修改</label>
                        <div class="btn btn-danger pull-left ml-10 invisible J_remove">删除</div>
                        <input type="file" name="img" id="img" class="form-control invisible J_img" accept="image/jpeg,image/jpg,image/png">
                      </div>
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="img_txt"></span>
                  </div>
                  <!-- 轮播图 -->
                  <div class="form-group">
                    <label class="col-sm-2 control-label">轮播图</label>
                    <div class="col-sm-4 upload_list">
                      <div class="upload_box pull-left ml-10 mt-10">
                        <label for="img1" class="upload pull-left">
                          <i class="glyphicon glyphicon-plus"></i>
                        </label>
                        <!-- <img class="pull-left upload_img" src="{{url('/admin/images/photo1.png')}}"> -->
                        <label class="btn btn-primary pull-left invisible ml-10" for="img1">修改</label>
                        <div class="btn btn-danger pull-left invisible ml-10 mt-10 J_remove">删除</div>
                        <input type="file" name="imgs" id="img1" class="form-control invisible J_img" accept="image/jpeg,image/jpg,image/png">
                      </div>
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="img_txt"></span>
                  </div>
                <!--  -->
                  <div class="form-group">
                    <label class="col-sm-2 control-label">关键字</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" rows="3" placeholder="请输入关键字 ..." name="keywords">{{$shop->keywords}}</textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-success btn-100">确认</button>
                      <button type="reset" class="btn btn-success btn-100">重置</button>
                      <button type="button" class="btn btn-success btn-100">取消</button>
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
      <!-- /.content -->

@endsection
