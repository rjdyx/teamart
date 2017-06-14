@extends('fx.admin.layouts.app')

@section('title')
文章分类
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
          <a href="#" style="color: #000"><i class="fa fa-home fa_skin" style="margin-right:4px"></i>文章管理</a>
          <a href="#"><small class="fa_skin"><i class="fa fa-angle-right" style="margin-right: 4px"></i>文章分类</small></a>
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
                <div class="box-tools">
                  <button type="button" class="btn btn-block btn-success btn-sm" id="addUser">新建分类</button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tbody><tr>
                    <th><!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button> --></th>
                    <th>编号</th>
                    <th>文章标题</th>
                    <th>文章分类</th>
                    <th>文章重要性</th>
                    <th>添加日期</th>
                    <th>是否显示</th>
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
                    <td>11-7-2014</td>
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
      <!-- /.content -->
    </div>
    <!-- /agentRole -->

    <!-- addagent -->
    <div id="addAgent">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1 style="cursor: pointer;">
          <a href="#" style="color: #000"><i class="fa fa-home fa_skin" style="margin-right:4px"></i>文章管理</a>
          <a href="#"><small class="fa_skin"><i class="fa fa-angle-right" style="margin-right: 4px"></i>新增分类</small></a>
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
                    <label for="inputName3" class="col-sm-2 control-label">文章标题</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputName3" placeholder="请输入文章标题">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">文章分类</label>
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
                    <label class="col-sm-2 control-label">文章重要性</label>
                    <div class="col-sm-10">
                      <label class="col-sm-1 gender_label control-label">
                        <input type="radio" name="optionsRadios" id="normal" value="option1">普通
                      </label>
                      <label class="col-sm-11 gender_label control-label">
                        <input type="radio" name="optionsRadios" id="ontop" value="option2" checked="checked">置顶
                      </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">是否显示</label>
                    <div class="col-sm-10">
                      <label class="col-sm-1 gender_label control-label">
                        <input type="radio" name="ifshow" id="gender_male" value="option1">显示
                      </label>
                      <label class="col-sm-11 gender_label control-label">
                        <input type="radio" name="ifshow" id="gender_female" value="option2" checked="checked">不显示
                      </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ComfirmLogo3" class="col-sm-2 control-label">文章作者</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="ComfirmLogo3" placeholder="请输入文章作者">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPrice3" class="col-sm-2 control-label">关键字</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputPrice3" placeholder="请输入关键字">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputCutPrice3" class="col-sm-2 control-label">上传文件</label>
                    <div class="col-sm-10">
                      <div class="col-sm-2">
                        <div class="btn btn-default btn-file">
                          <i class="fa fa-paperclip"></i> 上传文件
                          <input type="file" name="上传文件">
                        </div>
                        <p class="help-block">Max. 32MB</p>
                      </div>
                      <div class="col-sm-10">
                        <div class="form-group">
                          <label for="articleAddress" class="col-sm-2 control-label">或输入文件地址</label>

                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="articleAddress" placeholder="请输入文件地址">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputFinialsPrice3" class="col-sm-2 control-label">外部链接</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputFinialsPrice3" value="http://">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">网页描述</label>
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
    </div>
    <!-- /addagent -->
  </div>

@endsection
