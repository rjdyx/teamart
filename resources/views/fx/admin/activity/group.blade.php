@extends('fx.admin.layouts.app')

@section('title')
团购活动
@endsection
@section('t1')
促销管理
@endsection
@section('css')

@endsection

@section('script')
    @parent

@endsection

@section('content')
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
                          <option>状态</option>
                          <option>1</option>
                          <option>2</option>
                        </select>
                      </div>
                      <div class="col-sm-8"><input type="text" name="table_search" class="form-control pull-right input-sm" placeholder="请输入搜索内容"></div>
                    </div>
                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <div class="box-tools">
                  <button type="button" class="btn btn-block btn-success btn-sm" id="addUser">新建团购</button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tbody><tr>
                    <th><!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button> --></th>
                    <th>编号</th>
                    <th>商品名称</th>
                    <th>状态</th>
                    <th>结束时间</th>
                    <th>保证金</th>
                    <th>限购</th>
                    <th>订购商品</th>
                    <th>订单</th>
                    <th>当前价格</th>
                    <th>操作</th>
                  </tr>
                  <tr>
                    <td><input type="checkbox"></td>
                    <td>183</td>
                    <td>John Doe</td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-check fa_skin"></i></td>
                    <td>John Doe</td>
                    <td>John Doe</td>
                    <td>John Doe</td>
                    <td>John Doe</td>
                    <td>John Doe</td>
                    <td><div style="color: #dd4b39"><i class="fa fa-edit" style="margin-right: 5px;cursor: pointer;"></i><i class="fa fa-trash-o" style="margin-right: 5px;cursor: pointer;"></div></i>
                   </td>
                  </tr>
                  <tr>
                    <td><input type="checkbox"></td>
                    <td>183</td>
                    <td>John Doe</td>
                    <td><i class="fa fa-times" style="color: #ca0002"></i></td>
                    <td>183</td>
                    <td>John Doe</td>
                    <td>John Doe</td>
                    <td>John Doe</td>
                    <td>183</td>
                    <td>John Doe</td>
                    <td>11-7-2014</td>
                  </tr>
                  <tr>
                    <td><input type="checkbox"></td>
                    <td>183</td>
                    <td>John Doe</td>
                    <td>John Doe</td>
                    <td>John Doe</td>
                    <td>John Doe</td>
                    <td>11-7-2014</td>
                    <td>John Doe</td>
                    <td><i class="fa fa-times" style="color: #ca0002"></i></td>
                    <td>183</td>
                    <td>183</td>
                  </tr>
                  <tr>
                    <td><button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></td>
                    <td><button type="button" class="btn btn-block btn-default btn-sm">删除</button></td>
                    <th colspan="9">
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
          <a href="#" style="color: #000"><i class="fa fa-home fa_skin" style="margin-right:4px"></i>促销管理</a>
          <a href="#"><small class="fa_skin"><i class="fa fa-angle-right" style="margin-right: 4px"></i>新增团购</small></a>
        </h1>
      </section>
      <!-- Main content of addGgent-->
      <section class="content">
        <div class="row">
          <!-- 新增代理商角色 -->
          <div class="col-xs-12">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">新增团购</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form class="form-horizontal">
                <div class="box-body">
                  <div class="form-group">
                    <label for="inputName3" class="col-sm-2 control-label">团购商品</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputName3" placeholder="请输入商品名称">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">活动开始时间</label>
                    <div class="col-sm-10">
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="startDay">
                      </div>
                      <!-- /.input group -->
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">活动结束时间</label>
                    <div class="col-sm-10">
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="endDay">
                      </div>
                      <!-- /.input group -->
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ComfirmLogo3" class="col-sm-2 control-label">保证金</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="ComfirmLogo3" placeholder="请输入保证金数额">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPrice3" class="col-sm-2 control-label">限购数量</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputPrice3" placeholder="请输入数量">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputFinialsPrice3" class="col-sm-2 control-label">赠送积分</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputFinialsPrice3" placeholder="请输入积分额">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="priceGradient" class="col-sm-2 control-label">价格梯度</label>

                    <div class="col-sm-10">
                      数量到达
                      <input type="email" class="form-control" id="priceGradient" placeholder="请输入数量" style="display: inline-block;width: auto;margin: 0px 10px;">
                      享受价格
                      <input type="email" class="form-control" placeholder="请输入优惠价格" style="display: inline-block;width: auto;margin: 0px 10px;">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">活动说明</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" rows="3" placeholder="请输入网页信息 ..."></textarea>
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

@endsection
