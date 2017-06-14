@extends('fx.admin.layouts.app')

@section('title')
代理商角色
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
        <h1 style="cursor: pointer;">
          <i class="fa fa-home" style="color: #00a65a;margin-right:4px"></i>商品管理
          <small style="color: #00a65a"><i class="fa fa-angle-right" style="margin-right: 4px"></i>用户评价</small>
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
                      <div class="col-sm-4">
                        <select class="form-control input-sm">
                          <option>商品下架</option>
                          <option>是</option>
                          <option>否</option>
                        </select>
                      </div>
                      <div class="col-sm-4">
                        <button type="button" class="btn btn-block btn-success btn-sm" id="addUser">查询</button>
                      </div>
                    </div>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tbody><tr>
                    <th><!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button> --></th>
                    <th>编号</th>
                    <th>商品描述相符</th>
                    <th>卖家的服务态度</th>
                    <th>商品质量</th>
                    <th>晒图</th>
                    <th>评价</th>
                    <th>操作</th>
                  </tr>
                  <tr>
                    <td><input type="checkbox"></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><i class="fa fa-check" style="color: #00a65a;"></i></td>
                    <td>183</td>
                    <td>183</td>
                    <td><img class="usersComments_pic" src="../../dist/img/photo1.png" alt="Attachment"></td>
                    <td>John Doe</td>
                    <td><div style="color: #dd4b39"><i class="fa fa-edit" style="margin-right: 5px;cursor: pointer;"></i><i class="fa fa-trash-o" style="margin-right: 5px;cursor: pointer;"></div></i>
                   </td>
                  </tr>
                  <tr>
                    <td><input type="checkbox"></td>
                    <td>11-7-2014</td>
                    <td>John Doe</td>
                    <td><i class="fa fa-times" style="color: #ca0002"></i></td>
                    <td>183</td>
                    <td><img class="usersComments_pic" src="../../dist/img/photo1.png" alt="用户晒图"></td>
                    <td>John Doe</td>
                    <td style="color: #008d4c">回复</td>
                  </tr>
                  <tr>
                    <td><input type="checkbox"></td>
                    <td>11-7-2014</td>
                    <td>John Doe</td>
                    <td><i class="fa fa-times" style="color: #ca0002"></i></td>
                    <td>183</td>
                    <td>无图</td>
                    <td>John Doe</td>
                    <td style="color: #008d4c">回复</td>
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

  </div>

@endsection
