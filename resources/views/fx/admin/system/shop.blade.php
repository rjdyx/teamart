@extends('fx.admin.layouts.app')

@section('title')
店铺设置
@endsection

@section('css')

@endsection

@section('script')
    @parent

@endsection

@section('content')
   @include("fx.admin.layouts.header")

   @include("fx.admin.layouts.left")
   
   <div class="content-wrapper">
    <!-- addagent -->
    <div id="addAgent">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1 style="cursor: pointer;">
          <a href="#" style="color: #000"><i class="fa fa-home fa_skin" style="margin-right:4px"></i>系统管理</a>
          <a href="#"><small class="fa_skin"><i class="fa fa-angle-right" style="margin-right: 4px"></i>商店设置</small></a>
        </h1>
      </section>
      <!-- Main content of addGgent-->
      <section class="content">
        <div class="row">
          <!-- 新增代理商角色 -->
          <div class="col-xs-12">
            <div class="box box-success">
              
              <!-- form start -->
              <form class="form-horizontal">
                <div class="box-body">
                  <div class="form-group">
                    <label for="storeName" class="col-sm-2 control-label">商店名称</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="storeName" placeholder="请输入商店名称">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="storeTitle" class="col-sm-2 control-label">商店标题</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="storeTitle" placeholder="请输入商店标题">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="storeAddress" class="col-sm-2 control-label">地址</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="storeAddress" placeholder="请输入商店地址">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">状态</label>
                    <div class="col-sm-10">
                      <label class="col-sm-1 gender_label control-label">
                        <input type="radio" name="ifshow" id="gender_male" value="option1">开
                      </label>
                      <label class="col-sm-11 gender_label control-label">
                        <input type="radio" name="ifshow" id="gender_female" value="option2" checked="checked">关
                      </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="storeTel" class="col-sm-2 control-label">客服电话</label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control" id="storeTel" placeholder="请输入电话">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="storeContacts" class="col-sm-2 control-label">联系人</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="storeContacts" placeholder="请输入联系人">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="storeNum" class="col-sm-2 control-label">备案号</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="storeNum" placeholder="请输入备案号">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="storelogo" class="col-sm-2 control-label">水印</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="storelogo" placeholder="请输入水印">
                    </div>
                  </div>
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
                  <div class="form-group">
                    <label class="col-sm-2 control-label">公告</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" rows="3" placeholder="请输入公告 ..."></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">描述</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" rows="3" placeholder="请输入商店描述 ..."></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="button" class="btn btn-success btn-100">确认</button>
                      <button type="button" class="btn btn-success btn-100">重置</button>
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
      <!-- /.content -->
    </div>
    <!-- /addagent -->
  </div>

@endsection
