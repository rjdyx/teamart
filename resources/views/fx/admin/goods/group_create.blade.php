@extends('fx.admin.layouts.app')
@section('title')新增商品组@endsection
@section('t1')商品管理@endsection
@section('css')@endsection
@section('script')
    @parent
    <script src="{{url('ueditor/ueditor.config.js')}}"></script>
    <script src="{{url('ueditor/ueditor.all.min.js')}}"></script>
    <script src="{{url('ueditor/lang/zh-cn/zh-cn.js')}}"></script>
    <script src="{{url('admin/js/uploads.js')}}"></script>
    <script>
      $(function () {
        var ue = UE.getEditor('editor');
        imagePathFormat='/upload/descs/'; 
        var form = document.forms['groupForm']
        $(form).on('submit', function () {
          return submitForm()
        })
        $('#category_id').on('change', function () {
          _valid.ness('category_id', '商品分类', $(this).val())
        })
        $('#name').on('blur input', function () {
          _valid.name('name', '商品组名称', $(this).val(), 'product_group')
        })
        // $('#desc').on('blur input', function () {
        //   _valid.desc('desc', '商品组描述', $(this).val())
        // })
        function submitForm() {
          var category_id = form['category_id']
          var name = form['name']
          var desc = form['desc']
          var imgs = form['imgs[]']
          if (!_valid.ness('category_id', '商品分类', category_id.value)) {
            return false
          }
          if (!_valid.name('name', '分类名称', name.value, 'product_category')) {
            return false
          }
          // if (!_valid.desc('desc', '分类描述', desc.value)) {
          //   return false
          // }
          if (imgs.length) {
            var arr = []
            for (var i = 0; i < imgs.length; i++) {
              if (imgs[i].files[0]) {
                if (!_valid.img('imgs', imgs[i].files[0])) {
                  return false
                }
                arr.push(imgs[i].files[0])
              }
            }
            if (arr.length == 0) {
              $('#imgs_txt').text('至少要上传一张商品图片')
              return false
            }
          } else {
            if (imgs.files.length == 0) {
              $('#imgs_txt').text('至少要上传一张商品图片')
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
        <!-- 新增商品组 -->
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">新增商品组</h3>
            </div>
            <form class="form-horizontal" action="{{url('admin/goods/group')}}" method="POST" name="groupForm" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="category_id" class="col-sm-3 control-label"><i style="color:red;">*</i>商品分类</label>
                  <div class="col-sm-4">
                    <select name="category_id" class="form-control" id="category_id">
                      <option value="">-请选择商品分类-</option>
                      @foreach($selects as $select)
                        <option value="{{$select->id}}">{{$select->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="category_id_txt"></span>
                </div>
                <div class="form-group">
                  <label for="name" class="col-sm-3 control-label"><i style="color:red;">*</i>商品组名称</label>
                  <div class="col-sm-4">
                    <input type="text" name="name" class="form-control" id="name" placeholder="请输入商品组名称">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="name_txt"></span>
                </div>
                <!-- 此处4张图片上传 -->
                <div class="form-group">
                  <label class="col-sm-3 control-label"><i style="color:red;">*</i>商品图片</label>
                  <div class="col-sm-4 upload_list">
                    <div class="upload_box pull-left ml-10 mt-10">
                      <label for="img1" class="upload pull-left">
                        <i class="glyphicon glyphicon-plus"></i>
                      </label>
                      <!-- <img class="pull-left upload_img" src="{{url('/admin/images/photo1.png')}}"> -->
                      <label class="btn btn-primary pull-left invisible ml-10" for="img1">修改</label>
                      <div class="btn btn-danger pull-left invisible ml-10 mt-10 J_removes">删除</div>
                      <input type="file" name="imgs[]" id="img1" class="form-control invisible J_imgs" accept="image/jpeg,image/jpg,image/png">
                    </div>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="imgs_txt"></span>
                </div>
                <!-- 商品详情 -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">详情图描述</label>
                  <div class="col-sm-5">
                    <script id="editor" type="text/plain"  name="desc" 
                    style="width:1024px;height:400px;border:1px solid #3DCDB4;"></script>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-success btn-100">确认</button>
                    <button type="reset" class="btn btn-success btn-100">重置</button>
                    <a href="{{ url('admin/goods/group') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
@endsection

