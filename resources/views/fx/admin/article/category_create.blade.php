@extends('fx.admin.layouts.app')
@section('title')新增文章分类@endsection
@section('t1')文章管理@endsection
@section('css')
<style type="text/css">
    .upload_box {
      height: 100px;
    }
    .upload {
      width: 100px;
      height: 100px;
      border: 1px dashed #777;
      text-align: center;
      color: #777;
      line-height: 132px;
      cursor: pointer;
    }
    .upload:hover {
      border: 1px dashed #337ab7;
      color: #337ab7;
    }
    .upload i {
      font-size: 50px;
    }
    .upload_img {
      width: 100px;
      height: 100px;
    }
  </style>
@endsection
@section('script')
    @parent
    <script>
      $(function () {
        var form = document.forms['categoryForm']
        $(form).on('submit', function () {
          return submitForm()
        })
        $('#name').on('blur input', function () {
          validname('name', '分类名称', $(this).val(), 'product_category')
        })
        $('#desc').on('blur input', function () {
          validdesc('desc', '分类描述', $(this).val())
        })
        $('#img').on('change', function () {
          var $this = $(this)
          var file = $this[0].files[0]
          if (!validimg('img', file)) {
            return
          }
          $this.siblings('img').remove()
          var fr = new FileReader()
          fr.onload = function (e) {
            var img = new Image()
            img.src = e.target.result
            img.classList.add('pull-left')
            img.classList.add('upload_img')
            $this.parent().prepend(img).end()
            .siblings('.invisible').removeClass('invisible')
            .siblings('.upload').hide()
          }
          fr.readAsDataURL(file)
        })
        function submitForm() {
          var name = form['name']
          var desc = form['desc']
          var img = form['img']
          if (!validname('name', '分类名称', name.value, 'product_category')) {
            return false
          }
          if (!validdesc('desc', '分类描述', desc.value)) {
            return false
          }
          if (img.files.length > 0) {
            if (!validimg('img', img.files[0])) {
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
          <!-- 新增代理商角色 -->
          <div class="col-xs-12">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">新增文章分类</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form class="form-horizontal" action="{{url('admin/article/category')}}" method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>分类名称</label>
                  <div class="col-sm-4">
                    <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="请输入分类名称">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">分类描述</label>
                  <div class="col-sm-4">
                    <input type="text" name="desc" class="form-control" id="inputEmail3" placeholder="请输入分类描述">
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-3 control-label">图片</label>
                  <div class="col-sm-4">
                    <div class="upload_box relative">
                      <label for="img" class="upload pull-left">
                        <i class="glyphicon glyphicon-plus"></i>
                      </label>
                      <!-- <img class="pull-left upload_img" src="{{url('/admin/images/photo1.png')}}"> -->
                      <label class="btn btn-primary pull-left ml-10 invisible" for="img">修改</label>
                      <input type="file" name="img" id="img" class="form-control invisible" accept="image/jpeg,image/jpg,image/png">
                    </div>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="img_txt"></span>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-success btn-100">确认</button>
                    <button type="reset" class="btn btn-success btn-100">重置</button>
                    <a href="{{ url('admin/article/category') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
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