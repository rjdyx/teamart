@extends('fx.admin.layouts.app')
@section('title')编辑商品分类@endsection
@section('t1')商品管理@endsection
@section('css')
@endsection
@section('script')
    @parent
    <script src="{{url('admin/js/upload.js')}}"></script>
    <script>
      $(function () {
        var form = document.forms['categoryForm']
        $(form).on('submit', function () {
          return submitForm()
        })
        $('#name').on('blur input', function () {
          _valid.name('name', '分类名称', $(this).val(), 'product_category')
        })
        $('#desc').on('blur input', function () {
          _valid.desc('desc', '分类描述', $(this).val())
        })
        function submitForm() {
          var name = form['name']
          var desc = form['desc']
          var img = form['img']
          if (!_valid.name('name', '分类名称', name.value, 'product_category')) {
            return false
          }
          if (!_valid.desc('desc', '分类描述', desc.value)) {
            return false
          }
          if (img.files.length > 0) {
            if (!_valid.img('img', img.files[0])) {
              return false
            }
          }
          return true
        }
      })
    </script>
@endsection
@section('content')
    <section class="content">
      <div class="row">
        <!-- 编辑商品分类 -->
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">编辑商品分类</h3>
            </div>
            <form class="form-horizontal" action="{{url('admin/goods/category')}}/{{$data->id}}" method="POST" name="categoryForm" enctype="multipart/form-data">
              {{ csrf_field() }}
              <input type="hidden" value="PUT" name="_method">
              <input type="hidden" value="{{$data->id}}" name="id" id="id">
              <input type="hidden" value="0" name="del" id="del">
              <div class="box-body">
                <div class="form-group">
                  <label for="name" class="col-sm-3 control-label"><i style="color:red;">*</i>分类名称</label>
                  <div class="col-sm-4">
                    <input type="text" name="name" class="form-control" id="name" placeholder="请输入分类名称" value="{{$data->name}}">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="name_txt"></span>
                </div>
                <div class="form-group">
                  <label for="desc" class="col-sm-3 control-label">分类描述</label>
                  <div class="col-sm-4">
                    <input type="text" name="desc" class="form-control" id="desc" placeholder="请输入分类描述" value="{{$data->desc}}">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="desc_txt"></span>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">图片</label>
                  <div class="col-sm-4">
                    <div class="upload_single">
                      @if ($data->img) 
                        <img class="pull-left upload_img" src="{{url('')}}/{{$data->img}}">
                        <label for="img" class="upload pull-left hidden">
                          <i class="glyphicon glyphicon-plus"></i>
                        </label>
                        <label class="btn btn-primary pull-left ml-10" for="img">修改</label>
                        <div class="btn btn-danger pull-left ml-10 J_remove">删除</div>
                        <input type="file" name="img" id="img" class="invisible form-control J_img" accept="image/jpeg,image/jpg,image/png">
                      @else
                        <label for="img" class="upload pull-left">
                          <i class="glyphicon glyphicon-plus"></i>
                        </label>
                        <label class="btn btn-primary pull-left ml-10 invisible" for="img">修改</label>
                        <div class="btn btn-danger pull-left ml-10 invisible J_remove">删除</div>
                        <input type="file" name="img" id="img" class="invisible form-control J_img" accept="image/jpeg,image/jpg,image/png">
                      @endif
                    </div>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="img_txt"></span>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-success btn-100">确认</button>
                    <button type="reset" class="btn btn-success btn-100">重置</button>
                    <a href="{{ url('admin/goods/category') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
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
@endsection

