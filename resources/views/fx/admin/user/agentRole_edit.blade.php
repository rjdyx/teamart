@extends('fx.admin.layouts.app')

@section('title')
编辑代理商角色
@endsection

@section('t1')
用户管理
@endsection

@section('css')
@endsection

@section('script')
    @parent
    <script src="{{url('admin/js/axios.js')}}"></script>
    <script>
      $(function () {
        var form = document.forms['parterForm']
        $(form).on('submit', function () {
          return submitForm()
        })
        $('#name').on('blur input', function () {
          vaildName('name', $('#name').val())
        })
        $('#scale').on('blur input', function () {
          vaildScale('scale', $('#scale').val())
        })
        $('#desc').on('blur input', function () {
          vaildDesc('desc', $('#desc').val())
        })
        function submitForm() {
          var name = form['name']
          var scale = form['scale']
          var desc = form['desc']
          if (!vaildName('name', name.value)) {
            return false
          }
          if (!vaildScale('scale', scale.value)) {
            return false
          }
          if (!vaildDesc('desc', desc.value)) {
            return false
          }
          return true
        }
        function required (field, fieldtxt, value) {
          if (value) {
            $('#' + field + '_txt').text('')
            return true
          } else {
            $('#' + field + '_txt').text(fieldtxt + '不能为空')
            return false
          }
        }
        function vaildName (field, value) {
          var vaild = false
          var temp = required(field, '分销角色名称', value)
          if (temp) {
            if (value.length < 4) {
              $('#' + field + '_txt').text('分销角色名称不能少于4个字符')
              vaild = false
            } else {
              // id
              // field
              // value
              // table
              var params = {
                id: $('input[name="id"]').val(),
                field: 'name',
                table: 'parter',
                value: value
              }
              axios.post('/check', params)
                .then(function (res) {
                  if (res.data == 'false') {
                    vaild = true
                  } else {
                    $('#' + field + '_txt').text('该名字已经存在')
                    vaild = false
                  }
                })
                .catch(function (err) {
                  console.log(err)
                })
              $('#' + field + '_txt').text('')
              vaild = true
            }
          }
          return vaild
        }
        function vaildScale (field, value) {
          var vaild = false
          var temp = required(field, '分销比例', value)
          if (temp) {
            if (isNaN(parseFloat(value))) {
              $('#' + field + '_txt').text('请输入数字')
              vaild = false
            } else if (value <= 0 || value > 1) {
              $('#' + field + '_txt').text('分销比例区间在0~1之间')
              vaild = false
            } else {
              $('#' + field + '_txt').text('')
              vaild = true
            }
          }
          return vaild
        }
        function vaildDesc (field, value) {
          var vaild = false
          if (value) {
            if (value.length > 50) {
              $('#' + field + '_txt').text('角色描述在50个字内')
              vaild = false
            } else {
              $('#' + field + '_txt').text('')
              vaild = true
            }
          }
          return vaild
        }
      })
    </script>
@endsection

@section('content')
  <section class="content">
    <div class="row">
      <!-- 编辑代理商角色 -->
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">编辑代理商角色</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form class="form-horizontal" action="{{url('admin/user/agentrole')}}/{{$data->id}}" method="POST">
          {{ csrf_field() }}
          <input type="hidden" value="PUT" name="_method">
          <input type="hidden" value="{{$data->id}}" name="id">
            <div class="box-body">
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label"><i style="color:red;">*</i> 分销角色名称</label>

                <div class="col-sm-4">
                  <input type="text" name="name" class="form-control" id="name" placeholder="请输入分销角色名称，不超过50字符" value="{{$data->name}}">
                </div>
                <span class="col-sm-4 text-danger form_error" id="name_txt"></span>
              </div>
              <div class="form-group">
                <label for="scale" class="col-sm-3 control-label"><i style="color:red;">*</i>分销比例</label>

                <div class="col-sm-4">
                  <input type="text" class="form-control" id="scale" placeholder="请输入范围在0 ~ 1的数，保留两位小数" name='scale' value="{{$data->scale}}">
                </div>
                <span class="col-sm-4 text-danger form_error" id="scale_txt"></span>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="desc">描述</label>
                <div class="col-sm-4">
                  <textarea class="form-control" rows="3" name="desc" id="desc" placeholder="请输入角色描述 ...">{{$data->desc}}</textarea>
                </div>
                <span class="col-sm-4 text-danger form_error" id="desc_txt"></span>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-10">
                  <button type="submit" class="btn btn-success btn-100">确认</button>
                  <button type="reset" class="btn btn-success btn-100">重置</button>
                  <a href="{{ url('admin/user/agentrole') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </form>
        </div>
      </div>
      <!-- /编辑代理商角色 -->
    </div>
  </section>
@endsection

