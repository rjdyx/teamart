@extends('fx.admin.layouts.app')

@section('title')
发货订单
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
    <!-- agentRole -->
    <div id="agentRole">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <a href="#" style="color: #000"><i class="fa fa-home fa_skin" style="margin-right:4px"></i>商品管理</a>
          <a href="#"><small class="fa_skin"><i class="fa fa-angle-right" style="margin-right: 4px"></i>商品品牌</small></a>
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
                      <div class="col-sm-12"><input type="text" name="table_search" class="form-control pull-right input-sm" placeholder="请输入搜索内容"></div>
                    </div>
                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tbody><tr>
                    <th><!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button> --></th>
                    <th>编号</th>
                    <th>订单号</th>
                    <th>成交时间</th>
                    <th>收货人</th>
                    <th>商品名称</th>
                    <th>物件</th>
                    <th>快递公司</th>
                    <th>操作</th>
                  </tr>
                  <tr>
                    <td><input type="checkbox"></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-check fa_skin"></i></td>
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
                    <td>John Doe</td>
                    <td><i class="fa fa-times" style="color: #ca0002"></i></td>
                    <td>183</td>
                    <td>183</td>
                    <td>John Doe</td>
                    <td>
                      <a class="check_order" href="#" style="margin-right: 5px;">查看</a><a class="del_order" href="#">删除</a>
                    </td>
                  </tr>
                  <tr>
                    <td><input type="checkbox"></td>
                    <td>183</td>
                    <td>John Doe</td>
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
        <h1>
          <a href="#" style="color: #000"><i class="fa fa-home fa_skin" style="margin-right:4px"></i>订单管理</a>
          <a href="#"><small class="fa_skin"><i class="fa fa-angle-right" style="margin-right: 4px"></i>订单列表</small></a>
          <a href="#"><small class="fa_skin"><i class="fa fa-angle-right" style="margin-right: 4px"></i>订单详情</small></a>
        </h1>
      </section>
      <!-- Main content of addGgent-->
      <section class="content">
        <div class="row">
          <!-- 新增代理商角色 -->
          <div class="col-xs-12">
            <div class="box box-success">
              <!-- 第一排信息 -->
              <div class="box-header">
                <h3 class="box-title">订单基础信息</h3>
                <div class="box-tools" style="top: 5px;">
                  <ul class="pagination pagination-sm no-margin pull-right">
                    <li><a href="#">前一个订单</a></li>
                    <li><a href="#">后一个订单</a></li>
                    <li><a href="#">打印订单</a></li>
                  </ul>
                </div>
              </div>
              <!-- /.box-header -->
              <form class="form-horizontal">
                <div class="box-body row" style="margin: 0">
                  <!-- .box-body-left -->
                  <div class="col-sm-6 box-body-left" style="border-right: 3px dotted #dedede">
                    <div class="form-group">
                      <div class="col-sm-4 control-label">订单号:</div>
                      <div class="col-sm-8 control-label text-left">123124123493475743</div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-4 control-label">购物人:</div>
                      <div class="col-sm-8 control-label text-left">老王</div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-4 control-label">支付方式:</div>
                      <div class="col-sm-8 control-label text-left">微信支付<button type="button" class="btn btn-sm btn-success">编辑</button></div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-4 control-label">配送方式:</div>
                      <div class="col-sm-8 control-label text-left">顺丰快递<button type="button" class="btn btn-sm btn-success">编辑</button><button type="button" class="btn btn-sm btn-success">打印快递单</button><button type="button" class="btn btn-sm btn-success">自取商品</button></div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-4 control-label">发货单号:</div>
                      <div class="col-sm-8 control-label text-left">23412489573495793475</div>
                    </div>
                  </div>
                  <!-- /.box-body-left -->
                  <!-- .box-body-right -->
                  <div class="col-sm-6 box-body-right">
                    <div class="form-group">
                      <div class="col-sm-4 control-label">订单状态:</div>
                      <div class="col-sm-8 control-label text-left">未付款</div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-4 control-label">下单时间:</div>
                      <div class="col-sm-8 control-label text-left">2017-03-23 16:56:32</div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-4 control-label">付款时间:</div>
                      <div class="col-sm-8 control-label text-left">未付款</div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-4 control-label">发货时间:</div>
                      <div class="col-sm-8 control-label text-left">未发货</div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-4 control-label">订单来源:</div>
                      <div class="col-sm-8 control-label text-left">本站</div>
                    </div>
                  </div>
                  <!-- /.box-body-right -->
                </div>
                <!-- /.box-body -->
              </form>
              <!-- 第二排信息 -->
              <div class="box-header">
                      <h3 class="box-title">订单其他信息</h3>
                      <div class="box-tools" style="top: 5px;">
                        <ul class="pagination pagination-sm no-margin pull-right">
                          <li><a href="javascript:;">编辑</a></li>
                        </ul>
                      </div>
                    </div>
              <form class="form-horizontal">
                <div class="box-body row" style="margin: 0">
                  <!-- .box-body-left -->
                  <div class="col-sm-6 box-body-left" style="border-right: 3px dotted #dedede">
                    <div class="form-group">
                      <div class="col-sm-4 control-label">发货类型:</div>
                      <div class="col-sm-8 control-label text-left">123124123493475743</div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-4 control-label">包装:</div>
                      <div class="col-sm-8 control-label text-left">老王</div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-4 control-label">缺货处理:</div>
                      <div class="col-sm-8 control-label text-left">等商品齐全再发</div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-4 control-label">贺卡祝福语:</div>
                      <div class="col-sm-8 control-label text-left">你好666</div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-4 control-label">商家给客户的留言:</div>
                      <div class="col-sm-8 control-label text-left">推迟一天</div>
                    </div>
                  </div>
                  <!-- /.box-body-left -->
                  <!-- .box-body-right -->
                  <div class="col-sm-6 box-body-right">
                    <div class="form-group">
                      <div class="col-sm-4 control-label">收货人:</div>
                      <div class="col-sm-8 control-label text-left">郭富城</div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-4 control-label">地址:</div>
                      <div class="col-sm-8 control-label text-left">华南农业大学</div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-4 control-label">电话:</div>
                      <div class="col-sm-8 control-label text-left">020-4821677</div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-4 control-label">手机:</div>
                      <div class="col-sm-8 control-label text-left">13545423765</div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-4 control-label">邮箱:</div>
                      <div class="col-sm-8 control-label text-left">514475</div>
                    </div>
                  </div>
                  <!-- /.box-body-right -->
                </div>
                <!-- /.box-body -->
              </form>
              <!-- 第三排信息 -->
              <div class="box-header">
                      <h3 class="box-title">订单商品信息</h3>
                    </div>
              <form class="form-horizontal">
                <div class="box-body" style="margin: 0">
                  <table class="table table-bordered">
                    <tbody><tr>
                      <th>商品名称[品牌]</th>
                      <th>货号</th>
                      <th>价格</th>
                      <th>数量</th>
                      <th>属性</th>
                      <th>库存</th>
                      <th>小计</th>
                    </tr>
                    <tr>
                      <td>1.</td>
                      <td>Update software</td>
                      <td>23</td>
                      <td>Update software</td>
                      <td>23</td>
                      <td>Update software</td>
                      <td>23</td>
                    </tr>
                  </tbody></table>
                </div>
                <!-- /.box-body -->
              </form>
              <div class="box-footer clearfix" style="border-top: 0px;text-align: center;">
                <button type="button" class="btn btn-success">确认修改</button>
                <button id="cancel_addUser" type="button" class="btn btn-success">取消</button>
              </div>
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
