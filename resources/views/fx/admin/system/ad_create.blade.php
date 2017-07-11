@extends('fx.admin.layouts.app')
@section('title')新增广告@endsection
@section('t1')系统管理@endsection
@section('css')
@endsection
@section('script')
    @parent
    <script src="{{url('admin/js/upload.js')}}"></script>
    <script>

      $(function () {
        var form = document.forms['listForm']
        $(form).on('submit', function () {
          return submitForm()
        })
        $('#position').on('change', function () {
          _valid.ness('position', '广告位置', $(this).val())
        })
        $('#state').on('change', function () {
          _valid.ness('state', '广告状态', $(this).val())
        })
        $('#title').on('blur input', function () {
          _valid.title('title', '广告标题', $(this).val(), 'product')
        })
        $('#desc').on('blur input', function () {
          _valid.desc('desc', '广告描述', $(this).val(), 255)
        })
        $('#url').on('blur input', function () {
          _valid.desc('url', '链接', $(this).val(), 255)
        })

        function submitForm() {
          var position = form['position']
          var state = form['state']
          var title = form['title']
          if (!_valid.ness('position', '广告位置', position.value)) {
            return false
          }
          if (!_valid.ness('state', '广告状态', state.value)) {
            return false
          }
          if (!_valid.ness('title', '广告标题', title.value)) {
            return false
          }
          return true
        } 
      })
    </script>
@endsection
@section('content')
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">新增广告</h3>
            </div>
            <form class="form-horizontal" action="{{url('admin/system/ad')}}" method="POST" name="listForm" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-3 control-label"><i style="color:red;">*</i>广告位置</label>
                  <div class="col-sm-4">
                    <select name="position" class="form-control" id="position">
                      <option value="">-请选广告展示位置-</option>
                        <option value="index">首页</option>
                    </select>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="position_txt"></span>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label"><i style="color:red;">*</i>广告状态</label>
                  <div class="col-sm-4">
                    <select name="state" class="form-control" id="state">
                        <option value="1">开启</option>
                        <option value="0">关闭</option>
                    </select>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="state_txt"></span>
                </div>
                <div class="form-group">
                  <label for="title" class="col-sm-3 control-label"><i style="color:red;">*</i>广告标题</label>
                  <div class="col-sm-4">
                    <input type="text" name="title" class="form-control" id="title" placeholder="请输入广告标题">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="title_txt"></span>
                </div>
                <div class="form-group">
                  <label for="desc" class="col-sm-3 control-label">广告描述</label>
                  <div class="col-sm-4">
                    <input type="text" name="desc" class="form-control" id="desc" placeholder="请输入商品描述">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="desc_txt"></span>
                </div>

                <div class="form-group">
                  <label for="url" class="col-sm-3 control-label">广告链接</label>
                  <div class="col-sm-4">
                    <input type="text" name="url" class="form-control" id="url" placeholder="请输入广告链接">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="url_txt"></span>
                </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">图片</label>
                    <div class="col-sm-4">
                      <div class="upload_single">
                          <label for="img" class="upload pull-left">
                            <i class="glyphicon glyphicon-plus"></i>
                          </label>
                          <label class="btn btn-primary pull-left ml-10 invisible" for="img">修改</label>
                          <div class="btn btn-danger pull-left ml-10 invisible J_remove">删除</div>
                          <input type="file" name="img" id="img" class="invisible form-control J_img" accept="image/jpeg,image/jpg,image/png">
                      </div>
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="img_txt"></span>
                  </div>

                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-success btn-100">确认</button>
                    <button type="reset" class="btn btn-success btn-100">重置</button>
                    <a href="{{ url('admin/system/ad') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
@endsection

