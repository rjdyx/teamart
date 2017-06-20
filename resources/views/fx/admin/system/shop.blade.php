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
                    <div class="col-sm-10">
                      <ul class="mailbox-attachments clearfix">
                        <li>
                          <span class="mailbox-attachment-icon"><i class="fa fa-picture-o"></i></span>
                          <div class="mailbox-attachment-info">
                            <a href="#" class="mailbox-attachment-name">
                              <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-upload"></i>上传</a>
                            </a>
                                <span class="mailbox-attachment-size">
                                  最大:1.9 MB
                                  <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i>下载</a>
                                </span>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <!-- 轮播图 -->
                  <div class="form-group">
                    <label class="col-sm-2 control-label">商品默认图</label>
                    <div class="col-sm-10">
                      <ul class="mailbox-attachments clearfix">
                        <li>
                          <span class="mailbox-attachment-icon"><i class="fa fa-picture-o"></i></span>

                          <div class="mailbox-attachment-info">
                            <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Sep2014-report.pdf</a>
                                <span class="mailbox-attachment-size">
                                  1,245 KB
                                  <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                </span>
                          </div>
                        </li>
                        <li>
                          <span class="mailbox-attachment-icon"><i class="fa fa-picture-o"></i></span>

                          <div class="mailbox-attachment-info">
                            <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> App Description.docx</a>
                                <span class="mailbox-attachment-size">
                                  1,245 KB
                                  <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                </span>
                          </div>
                        </li>
                        <li>
                          <span class="mailbox-attachment-icon has-img"><img src="../img/photo1.png" alt="Attachment"></span>

                          <div class="mailbox-attachment-info">
                            <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo1.png</a>
                                <span class="mailbox-attachment-size">
                                  2.67 MB
                                  <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                </span>
                          </div>
                        </li>
                        <li>
                          <span class="mailbox-attachment-icon has-img"><img src="../img/photo1.png" alt="Attachment"></span>

                          <div class="mailbox-attachment-info">
                            <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo2.png</a>
                                <span class="mailbox-attachment-size">
                                  1.9 MB
                                  <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                </span>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">关键字</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" rows="3" placeholder="请输入关键字 ..." name="keywords">{{$shop->keywords}}</textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-success btn-100">确认</button>
                      <button type="button" class="btn btn-success btn-100">重置</button>
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
