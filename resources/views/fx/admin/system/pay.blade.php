@extends('fx.admin.layouts.app')

@section('title')
支付设置
@endsection

@section('css')

@endsection

@section('script')
    @parent

@endsection

@section('content')
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
                      <option>支付方式</option>
                      <option>微信</option>
                      <option>支付宝</option>
                    </select>
                  </div>
                  <div class="col-sm-8"><input type="text" name="table_search" class="form-control pull-right input-sm" placeholder="请输入搜索内容"></div>
                </div>
                <div class="input-group-btn">
                  <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>
            <div class="box-tools">
              <button type="button" class="btn btn-block btn-success btn-sm" id="addUser">新支付</button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <tbody><tr>
                <th><!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button> --></th>
                <th>编号</th>
                <th>支付方式名称</th>
                <th>支付方式描述</th>
                <th>插件版本</th>
                <th>插件作者</th>
                <th>费用</th>
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
                <td><div style="color: #dd4b39"><i class="fa fa-edit" style="margin-right: 5px;cursor: pointer;"></i><i class="fa fa-trash-o" style="margin-right: 5px;cursor: pointer;"></div></i>
               </td>
              </tr>
              <tr>
                <td><input type="checkbox"></td>
                <td>183</td>
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
                <td>John Doe</td>
                <td>John Doe</td>
                <td><i class="fa fa-times" style="color: #ca0002"></i></td>
                <td>183</td>
                <td>183</td>
              </tr>
              <tr>
                <td><button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></td>
                <td><button type="button" class="btn btn-block btn-default btn-sm">删除</button></td>
                <th colspan="6">
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
@endsection
