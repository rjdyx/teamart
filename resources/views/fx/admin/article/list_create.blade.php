 @extends('fx.admin.layouts.app')
 @section('title')文章新增@endsection
 @section('t1')文章管理@endsection
 @section('css')
 @endsection
 @section('script')
 @parent
    <script src="{{url('ueditor/ueditor.config.js')}}"></script>
    <script src="{{url('ueditor/ueditor.all.min.js')}}"></script>
    <script src="{{url('ueditor/lang/zh-cn/zh-cn.js')}}"></script>
    <script src="{{url('admin/js/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{url('admin/js/datepicker/locales/bootstrap-datepicker.zh-CN.js')}}"></script>
    <script src="{{url('admin/js/upload.js')}}"></script>
    <script>
        //实例化编辑器
        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
      $(function () {
        $('#datepicker').datepicker({
          language: 'zh-CN',
          format: 'yyyy-mm-dd'
        });
        var ue = UE.getEditor('editor');
        imagePathFormat='/upload/descs/'; 
        var form = document.forms['listForm']
        $(form).on('submit', function () {
          return submitForm()
        })
        $('#name').on('blur input', function () {
          _valid.name('name', '文章标题', $(this).val(), 'article')
        })
        $('#category_id').on('change', function () {
          _valid.ness('category_id', '文章分类', $(this).val())
        })
        function submitForm() {
          var name = form['name']
          var category_id = form['category_id']
          var img = form['img']
          if (!_valid.name('name', '文章标题', name.value, 'article')) {
            return false
          }
          if (!_valid.ness('category_id', '文章分类', category_id.value)) {
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
        <form class="form-horizontal" action="{{url('admin/article/list')}}" method="POST" name="listForm" enctype="multipart/form-data">
           {{ csrf_field() }}
          <div class="box-body">
            <div class="form-group">
              <label for="name" class="col-sm-2 control-label"><i style="color:red;">*</i>文章标题</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name='name' id="name" placeholder="请输入文章标题">
              </div>
              <span class="col-sm-4 text-danger form_error" id="name_txt"></span>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label"><i style="color:red;">*</i>文章分类</label>
              <div class="col-sm-6">
                <select class="form-control pull-left" style="width: 50%" name="category_id" id="category_id">
                  <option value="">-请选择文章分类-</option>
                  @foreach ($lists as $list)
                  <option value="{{$list->id}}">{{$list->name}}</option>
                  @endforeach               
                </select>
                <a class="pull-left ml-10" href="{{ url('admin/article/category/create') }}"><button type="button" class="btn btn-success btn-100">添加分类</button></a>
              </div>
              <span class="col-sm-4 text-danger form_error" id="category_id_txt"></span>
            </div>         
            <div class="form-group">
              <label class="col-sm-2 control-label">上传图片</label>
              <div class="col-sm-10">
                <div class="upload_single">
                  <label for="img" class="upload pull-left">
                    <i class="glyphicon glyphicon-plus"></i>
                  </label>
                  <label class="btn btn-primary pull-left ml-10 invisible" for="img">修改</label>
                  <div class="btn btn-danger pull-left ml-10 invisible J_remove">删除</div>
                  <input type="file" name="img" id="img" class="form-control invisible J_img" accept="image/jpeg,image/jpg,image/png">
                </div>
              </div>
              <span class="col-sm-4 text-danger form_error" id="img_txt"></span>
            </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">文章内容</label>
                <div class="col-sm-5">
                  <script id="editor" type="text/plain"  name="content" 
                  style="width:1024px;height:400px;border:1px solid #3DCDB4;"></script>
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
