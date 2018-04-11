@extends('fx.admin.layouts.app')

@section('title')
新建站点
@endsection
@section('t1')
系统管理
@endsection
@section('css')

@endsection

@section('script')
    @parent
    <script>
      $(function () {
        var form = document.forms['siteForm']
        $(form).on('submit', function () {
          return submitForm()
        })
        $('#name').on('input blur', function () {
          _valid.ness('name', '站点名称', $(this).val())
        })
        $('#longitude').on('input blur', function () {
          _valid.lng('longitude', $(this).val())
        })
        $('#latitude').on('blur input', function () {
          _valid.lat('latitude', $(this).val())
        })
        $('#user').on('blur input', function () {
          _valid.ness('user', '联系人', $(this).val())
        })
        $('#phone').on('blur input', function () {
          _valid.phone('phone', $(this).val(), true)
        })

        function submitForm() {
          var name = form['name']
          var longitude = form['longitude']
          var latitude = form['latitude']
          var user = form['user']
          var phone = form['phone']
          if (!_valid.ness('name', '站点名称', name.value)) {
            return false
          }
          if (!_valid.lng('longitude', longitude.value)) {
            return false
          }
          if (!_valid.lat('latitude', latitude.value)) {
            return false
          }
          if (!_valid.ness('user', '联系人', user.value)) {
            return false
          }
          if (!_valid.phone('phone', phone.value, true)) {
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
                <h3 class="box-title">新站点</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form action="{{url('admin/system/site')}}" method="post" name="siteForm" class="form-horizontal">
                {{ csrf_field() }}
                <div class="box-body">
                  <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">站点名称</label>
                    <div class="col-sm-4">
                      <input type="text" name="name" class="form-control" id="name" placeholder="请输入站点名称">
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="name_txt"></span>
                  </div>
                  <div class="form-group">
                    <label for="longitude" class="col-sm-2 control-label">经度</label>
                    <div class="col-sm-3">
                      <input type="text" name="longitude" class="form-control" id="longitude" placeholder="请输入地图经度">
                    </div>
                    <a href="http://api.map.baidu.com/lbsapi/getpoint/index.html" target="_blank" class="col-sm-1">获取坐标</a>
                    <span class="col-sm-4 text-danger form_error" id="longitude_txt"></span>
                  </div>
                  <div class="form-group">
                    <label for="latitude" class="col-sm-2 control-label">纬度</label>
                    <div class="col-sm-3">
                      <input type="text" name="latitude" class="form-control" id="latitude" placeholder="请输入地图纬度">
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="latitude_txt"></span>
                  </div>
                  <div class="form-group">
                    <label for="user" class="col-sm-2 control-label">联系人</label>
                    <div class="col-sm-4">
                      <input type="text" name="user" class="form-control" id="user" placeholder="请输入联系人">
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="user_txt"></span>
                  </div>
                  <div class="form-group">
                    <label for="phone" class="col-sm-2 control-label">联系电话</label>
                    <div class="col-sm-4">
                      <input type="text" name="phone" class="form-control" id="phone" placeholder="请输入联系电话">
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="phone_txt"></span>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-success btn-100">确认</button>
                      <button type="reset" class="btn btn-success btn-100">重置</button>
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

@endsection
