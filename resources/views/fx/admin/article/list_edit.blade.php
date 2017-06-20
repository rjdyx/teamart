 @extends('fx.admin.layouts.app')
 @section('title')文章新增@endsection
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
    <script src="{{url('ueditor/ueditor.config.js')}}"></script>
    <script src="{{url('ueditor/ueditor.all.min.js')}}"></script>
    <script src="{{url('ueditor/lang/zh-cn/zh-cn.js')}}"></script>
    <script src="{{url('admin/js/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{url('admin/js/datepicker/locales/bootstrap-datepicker.zh-CN.js')}}"></script>
    <script>
        $('#datepicker').datepicker({
          language: 'zh-CN',
          format: 'yyyy-mm-dd'
        });
        //实例化编辑器
        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
        var ue = UE.getEditor('editor');
        imagePathFormat='/upload/descs/'; 
    </script>
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
 <!-- Main content of addGgent-->
 <section class="content">
  <div class="row">
    <!-- 新增代理商角色 -->
    <div class="col-xs-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">新增文章</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="{{url('admin/article/list')}}/{{$data->id}}" method="POST" name="categoryForm" enctype="multipart/form-data">
           {{ csrf_field() }}
           <input type="hidden" value="PUT" name="_method">
          <div class="box-body">
            <div class="form-group">
              <label for="inputName3" class="col-sm-2 control-label">文章标题</label>

              <div class="col-sm-10">
                <input type="text" class="form-control" name='name' id="inputName3" placeholder="请输入文章标题" value="{{$data->name}}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">文章分类</label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-8">
                    <select class="form-control" name="category_id">
                      <option value="1">option 1</option>
                      <option value="1">option 2</option>
                      <option value="1">option 3</option>
                      <option value="1">option 4</option>
                      <option value="1">option 5</option>
                    </select>
                  </div>
                  <div class="col-sm-4">
                    <a href="{{ url('admin/article/category/create') }}"><button type="button" class="btn btn-success btn-100">添加分类</button></a></div>
                  </div>
                </div>
              </div>         
               <div class="form-group">
                  <label class="col-sm-2 control-label">图片</label>
                  <div class="col-sm-10">
                    <div class="upload_box relative">
                      @if ($data->img) 
                        <img class="pull-left upload_img" src="{{ url('')}}/{{$data->img}}">
                        <label for="img" class="upload pull-left hidden">
                          <i class="glyphicon glyphicon-plus"></i>
                        </label>
                        <label class="btn btn-primary pull-left ml-10" for="img">修改</label>
                        <input type="file" name="img" id="img" class="invisible form-control" accept="image/jpeg,image/jpg,image/png">
                      @else
                        <label for="img" class="upload pull-left">
                          <i class="glyphicon glyphicon-plus"></i>
                        </label>
                        <label class="btn btn-primary pull-left ml-10 invisible" for="img">修改</label>
                        <input type="file" name="img" id="img" class="invisible form-control" accept="image/jpeg,image/jpg,image/png">
                      @endif
                    </div>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="img_txt"></span>
                </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">文章内容</label>
                <div class="col-sm-5">
                  <script id="editor" type="text/plain"  name="content" 
                  style="width:1024px;height:400px;border:1px solid #3DCDB4;">{{$data->content}}</script>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-success btn-100">确认</button>
                  <button type="reset" class="btn btn-success btn-100">重置</button>
                  <a href="{{ url('admin/article/list') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addUser">取消</button></a>
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
