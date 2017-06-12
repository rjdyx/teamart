@extends('fx.admin.layouts.app')

@section('title')
代理商角色
@endsection

@section('css')
<style type="text/css">
    .content-header>h1{
      font-size: 18px;
      margin: 0;
    }
    .box-header>.box-tools{
      top: 10px;
    }
    .main-sidebar .user-panel{
      border-bottom: 1px solid #c0c0c0;
      line-height: 40px;
      padding-left: 15px;
    }
    td,th{
      text-align: center;
    }
    .content-header{
      box-sizing: border-box;
      border-bottom: 1px solid #c5c5c5;
      padding-bottom: 10px;
      padding-left: 0px;
      padding-right: 0px;
      margin: 0 15px 0 15px;
    }
    .pull-right-container i{
      color: #008d4c;
    }
    .box-footer-left{
      /*padding: 8px;*/
      float: left;
      display: inline-block;
      
      text-align: center;
    }
    .btn-100{
      width: 100px;
      margin-right: 20px;
    }
    .gender_label{
      text-align: left !important;
    }
    #agentRole{
      display: block;
    }
    #addAgent{
      display: none;
    }
  </style>
@endsection

@section('script')
    @parent
    <script>
    $(function(){
      $('#addUser,#cancel_addUser').click(function(){
        $('#agentRole').toggle();
        $('#addAgent').toggle();
      });
      $(".checkbox-toggle").click(function () {
        var clicks = $(this).data('clicks');
        if (clicks) {
          //Uncheck all checkboxes
          $(".table td input[type='checkbox']").prop('checked',false);
          $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
        } else {
          //Check all checkboxes
          $(".table td input[type='checkbox']").prop('checked',true);
          $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
        }
        $(this).data("clicks", !clicks);
      });
    });
</script>
@endsection

@section('content')
   @include("fx.admin.layouts.header")

   @include("fx.admin.layouts.left")
   
<div class="content-wrapper">
    <!-- agentRole -->
    <div id="agentRole">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1 style="cursor: pointer;">
          <i class="fa fa-home" style="color: #00a65a;margin-right:4px"></i>商品管理
          <small style="color: #00a65a"><i class="fa fa-angle-right" style="margin-right: 4px"></i>商品列表</small>
        </h1>
      </section>

      <!-- Main content of agentRole-->
      <section class="content">
        <div class="row">
          <!-- 代理商角色列表 -->
          <div class="col-xs-12">
            <div class="box box-success">
              <div class="box-header">
                <div class="input-group input-group-sm" style="width: 470px;">
                    <div class="row">
                      <div class="col-sm-4">
                        <select class="form-control input-sm">
                          <option>商品下架</option>
                          <option>是</option>
                          <option>否</option>
                        </select>
                      </div>
                      <div class="col-sm-8"><input type="text" name="table_search" class="form-control pull-right input-sm" placeholder="请输入搜索内容"></div>
                    </div>
                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <div class="box-tools">
                  <button type="button" class="btn btn-block btn-success btn-sm" id="addUser">新建商品</button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tbody><tr>
                    <th><!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button> --></th>
                    <th>编号</th>
                    <th>商品名称</th>
                    <th>货号</th>
                    <th>价格</th>
                    <th>上架</th>
                    <th>热销</th>
                    <th>新品</th>
                    <th>库存</th>
                    <th>操作</th>
                  </tr>
                  <tr>
                    <td><input type="checkbox"></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-check" style="color: #00a65a;"></i></td>
                    <td>183</td>
                    <td>183</td>
                    <td>11-7-2014</td>
                    <td>John Doe</td>
                    <td>John Doe</td>
                    <td>John Doe</td>
                    <td><div style="color: #dd4b39"><i class="fa fa-edit" style="margin-right: 5px;cursor: pointer;"></i><i class="fa fa-trash-o" style="margin-right: 5px;cursor: pointer;"></div></i>
                   </td>
                  </tr>
                  <tr>
                    <td><input type="checkbox"></td>
                    <td>11-7-2014</td>
                    <td>John Doe</td>
                    <td>11-7-2014</td>
                    <td>John Doe</td>
                    <td><i class="fa fa-times" style="color: #ca0002"></i></td>
                    <td>183</td>
                    <td>183</td>
                    <td>John Doe</td>
                    <td>11-7-2014</td>
                  </tr>
                  <tr>
                    <td><input type="checkbox"></td>
                    <td>183</td>
                    <td>John Doe</td>
                    <td>11-7-2014</td>
                    <td>John Doe</td>
                    <td><i class="fa fa-times" style="color: #ca0002"></i></td>
                    <td>183</td>
                    <td>11-7-2014</td>
                    <td>John Doe</td>
                    <td>11-7-2014</td>
                  </tr>
                  <tr>
                    <td><button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></td>
                    <td><button type="button" class="btn btn-block btn-default btn-sm">删除</button></td>
                    <th colspan="7">
                      <ul class="pagination pagination-sm no-margin pull-right">
                        <li><a href="#">«</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">»</a></li>
                      </ul>
                    </th>
                  </tr>
                </tbody></table>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /代理商角色列表 -->
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /agentRole -->

    <!-- addagent -->
    <div id="addAgent">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1 style="cursor: pointer;">
          <i class="fa fa-home" style="color: #00a65a;margin-right:4px"></i>商品管理
          <small style="color: #00a65a"><i class="fa fa-angle-right" style="margin-right: 4px"></i>商品列表</small>
        </h1>
      </section>
      <!-- Main content of addGgent-->
      <section class="content">
        <div class="row">
          <!-- 新增代理商角色 -->
          <div class="col-xs-12">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">新增商品</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form class="form-horizontal">
                <div class="box-body">
                  <div class="form-group">
                    <label for="inputName3" class="col-sm-2 control-label">商品名称</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputName3" placeholder="请输入商品名称">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputNum3" class="col-sm-2 control-label">商品货号</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputNum3" placeholder="商品货号">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">商品分类</label>
                    <div class="col-sm-10">
                      <div class="row">
                        <div class="col-sm-8">
                          <select class="form-control">
                            <option>option 1</option>
                            <option>option 2</option>
                            <option>option 3</option>
                            <option>option 4</option>
                            <option>option 5</option>
                          </select>
                        </div>
                        <div class="col-sm-4"><button type="button" class="btn btn-success btn-100">添加分类</button></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ComfirmLogo3" class="col-sm-2 control-label">商品品牌</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="ComfirmLogo3" placeholder="商品品牌">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">选择供货商</label>
                    <div class="col-sm-10">
                      <select class="form-control">
                        <option>option 1</option>
                        <option>option 2</option>
                        <option>option 3</option>
                        <option>option 4</option>
                        <option>option 5</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPrice3" class="col-sm-2 control-label">本店售价</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputPrice3" placeholder="商品货号">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">会员价格</label>
                    <div class="col-sm-10">
                      <select class="form-control">
                        <option>option 1</option>
                        <option>option 2</option>
                        <option>option 3</option>
                        <option>option 4</option>
                        <option>option 5</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputCutPrice3" class="col-sm-2 control-label">商品优惠价格</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputCutPrice3" placeholder="商品货号">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputFinialsPrice3" class="col-sm-2 control-label">促销价</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputFinialsPrice3" placeholder="商品货号">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">促销日期</label>
                    <div class="col-sm-10">
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="datepicker">
                      </div>
                      <!-- /.input group -->
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">上传图片</label>
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
                          <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo1.png" alt="Attachment"></span>

                          <div class="mailbox-attachment-info">
                            <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo1.png</a>
                                <span class="mailbox-attachment-size">
                                  2.67 MB
                                  <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                </span>
                          </div>
                        </li>
                        <li>
                          <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo2.png" alt="Attachment"></span>

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
                    <label class="col-sm-2 control-label">产品描述</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" rows="3" placeholder="请输入产品信息 ..."></textarea>
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
   @include("fx.admin.layouts.slide")
@endsection
